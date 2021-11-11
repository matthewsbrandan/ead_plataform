<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Course;

class ChatController extends Controller
{
    protected $take = 5;
    public function __construct(){
        $this->take = 5;
    }
    public function index(){
        $temp = auth()->user()->coursesPivot()
            ->orderBy('updated_at', 'desc')
            ->get();

        $userCourse = [];
        foreach($temp as $course){
            if($course->course->user_id != auth()->user()->id) $userCourse[]= $course;
        }
        
        $chats = [];
        foreach($userCourse as $student){
            $lastMessage = $student->course->chat()->first();
            if($lastMessage) $chats[] = $lastMessage;
        }
        if(auth()->user()->isTeacher()){
            foreach(auth()->user()->myCourses as $courses){
                foreach($courses->chats->groupBy('user_id') as $userChats){
                    $lastMessage = $userChats->last();
                    if($lastMessage){
                        $chats[] = $lastMessage;
                    }
                }
            }
        }
        $chats = $this->handleChat($chats);

        return view('chat.index',[
            'userCourse' => $userCourse,
            'chats' => $chats
        ]);
    }
    public function chatLesson($lesson_id, $skip = 0){
        $chats = Chat::whereLessonId($lesson_id)
           ->whereDepth(0)
           ->orderByDesc('id')
           ->take($this->take)
           ->skip($skip)
           ->get();
           
        $total = Chat::whereLessonId($lesson_id)->count();

        $chats = $this->handleChat($chats);
        
        return response()->json([
            'result' => true,
            'response' => [
                'chats' => $chats,
                'total' => $total
            ]
        ]);
    }
    public function chatCourse($slug, $user_id, $skip = 0){
        if(!auth()->user()->isTeacher() && $user_id != auth()->user()->id) return redirect()->back()->with(
            'message', 'Você não tem permissão para acessar esse chat'
        );
        if(!$course = Course::with(['teacher'])
            ->whereSlug($slug)
            ->first()
        ) return redirect()->back()->with(
            'message', 'Curso não encontrado'
        );

        $chats = $course->chat($user_id)->take(10)->get()->reverse();
        $chats = $this->handleChat($chats);

        return view('chat.show',[
            'course' => $course,
            'user_id' => $user_id,
            'chats' => $chats
        ]);
    }
    public function store(Request $request){ 
        if(!$request->lesson_id && !$request->course_id) return response()->json([
            'result' => false,
            'response' => 'Informe o id do chat(chat com professor, ou chat da aula)'
        ]);

        $data = ['content' => $request->content];

        if($request->user_id){
            if($request->user_id != auth()->user()->id &&
              !auth()->user()->isTeacher()
            ) return response()->json([
                'result' => false,
                'response' => 'Você não tem permissão para enviar mensagem a esse usuário'
            ]);

            $data+= [
                'user_id' => $request->user_id,
                'is_course' => $request->user_id != auth()->user()->id
            ];
        }
        else $data+= ['user_id' => auth()->user()->id];

        if($request->lesson_id) $data+= ['lesson_id' => $request->lesson_id];
        if($request->course_id) $data+= ['course_id' => $request->course_id];

        if($request->has('answer_id')) $data+= ['answer_id' => $request->answer_id];
        if($chat = Chat::create($data)){
            $chat = Chat::whereId($chat->id)->first();
            $chat->date_formatted = $chat
                ->created_at
                ->setTimezone('America/Sao_Paulo')
                ->format('d M, Y');

            if($chat->is_course){
                $chat->author_thumbnail = $chat->course->wallpaper;
                $chat->author_name = $chat->course->title;
            }else{
                $chat->author_thumbnail = $chat->author->thumbnail ??
                    asset('assets/images/user-default.jpeg');
                $chat->author_name = $chat->author->name;
            }
            
            return response()->json([
                'result' => true,
                'response' => $chat,
            ]);
        }else return response()->json([
            'result' => false,
            'response' => "Houve um erro ao enviar sua mensagem",
        ]);
    }
    public function answers($chat_id, $lead_id = 0, $skip = 0){
        $chats = Chat::whereAnswerId($chat_id)
           ->orderByDesc('id')
           ->take($this->take)
           ->skip($skip)
           ->get();
        $total = Chat::whereAnswerId($chat_id)->count();

        foreach($chats as &$chat){
            $chat->date_formatted = $chat
                ->created_at
                ->setTimezone('America/Sao_Paulo')
                ->format('d M, Y');
            $chat->author_thumbnail = $chat->author->thumbnail ?? asset('assets/images/user-default.jpeg');
            $chat->author_name = $chat->author->name;
        }
        
        return response()->json([
            'result' => true,
            'response' => [
                'chats' => $chats,
                'total' => $total
            ]
        ]);
    }
    public function delete($chat_id){
        if($chat = Chat::whereId($chat_id)->whereUserId(auth()->user()->id)->first()){
            if($chat->num_answers > 0) return response()->json([
                'result' => false,
                'response' => 'Essa mensagem não pode ser excluída, pois já foi respondida'
            ]);

            $chat->delete();

            return response()->json([
                'result' => true,
                'response' => 'Mensagem excluída com sucesso'
            ]);
        }
        return response()->json([
            'result' => false,
            'response' => 'Mensagem não localizado'
        ]);
    }

    protected function handleChat($chats){
        foreach($chats as &$chat){
            $chat->date_formatted = $chat
                ->created_at
                ->setTimezone('America/Sao_Paulo')
                ->format('d M, Y');

            if($chat->is_course){
                $chat->author_thumbnail = $chat->course->wallpaper;
                $chat->author_name = $chat->course->title;
            }else{
                $chat->author_thumbnail = $chat->author->thumbnail ??
                    asset('assets/images/user-default.jpeg');
                $chat->author_name = $chat->author->name;
            }
        }
        return $chats;
    }
}