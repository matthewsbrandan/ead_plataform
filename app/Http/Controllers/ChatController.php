<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;

class ChatController extends Controller
{
    protected $take = 5;
    public function __construct(){
        $this->take = 5;
    }
    public function index(){
        return view('chat.index');
    }
    public function chatLesson($lesson_id, $skip = 0){
        $chats = Chat::whereLessonId($lesson_id)
           ->whereDepth(0)
           ->orderByDesc('id')
           ->take($this->take)
           ->skip($skip)
           ->get();
           
        $total = Chat::whereLessonId($lesson_id)->count();

        foreach($chats as &$chat){
            $chat->date_formatted = $chat
                ->created_at
                ->setTimezone('America/Sao_Paulo')
                ->format('d M, Y');
        }
        
        return response()->json([
            'result' => true,
            'response' => [
                'chats' => $chats,
                'total' => $total
            ]
        ]);
    }
    public function store(Request $request){ 
        if(!$request->lesson_id && !$request->teacher_id) return response()->json([
            'result' => false,
            'response' => 'Informe o id do chat(chat com professor, ou chat da aula)'
        ]);
        $data = [
            'content' => $request->content,
            'user_id' => auth()->user()->id,
        ];

        if($request->lesson_id) $data+= ['lesson_id' => $request->lesson_id];
        if($request->teacher_id) $data+= ['teacher_id' => $request->teacher_id];

        if($request->has('answer_id')) $data+= ['answer_id' => $request->answer_id];
        if($chat = Chat::create($data)){
            $chat = Chat::whereId($chat->id)->first();
            $chat->date_formatted = $chat
                ->created_at
                ->setTimezone('America/Sao_Paulo')
                ->format('d M, Y');
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
}