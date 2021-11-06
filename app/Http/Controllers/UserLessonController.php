<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserLesson;
use App\Models\UserCourse;

class UserLessonController extends Controller
{
    public function toView(Request $request, $slug, $json = true){
        $response = $this->validateRequest($request);
        if(!$response['result']){
            if($json) return response()->json($response);
            return $response;
        }
        [$course_id, $lesson_id] = $response['response'];

        if(!$course = Course::with(['lessons' => function($query) use ($lesson_id){
            $query->with(['studentsPivot' => function($q){
                $q->where('user_id', auth()->user()->id);
            }])->where('id', $lesson_id);
        }, 'studentsPivot' => function($query){
            $query->where('user_id', auth()->user()->id);
        }])->whereId($course_id)->first()){
            $response = [
                'result' => false,
                'response' => 'Curso não encontrado'
            ];
            if($json) return response()->json($response);
            return $response;
        }

        $student = $course->studentsPivot->first();
        if(!$student){
            $response = [
                'result' => false,
                'response' => 'Você ainda não ingressou neste curso, matricule-se para ter acesso as aulas.'
            ];
            if($json) return response()->json($response);
            return $response;
        }

        $lesson = $course->lessons->first();
        if(!$lesson){
            $response = [
                'result' => false,
                'response' => 'Atividade não encontrada'
            ];
            if($json) return response()->json($response);
            return $response;
        }

        $lessonStudent = $lesson->studentsPivot->first();

        if(!$lessonStudent) $lessonStudent = UserLesson::create([
            'user_id' => auth()->user()->id,
            'lesson_id' => $lesson_id,
            'course_id' => $course_id,
            'viewed' => true,
        ]);
        else $lessonStudent->update(['viewed' => true]);

        ['isCompleted' => $isCompleted] = $this->handleUserCourse($course_id, $lesson);
        
        $response = [
            'result' => true,
            'response' => 'Aula visualizada',
            'isCompleted' => $isCompleted
        ];
        
        if($json) return response()->json($response);
        return $response;
    }
    protected function handleUserCourse($course_id, $current_lesson, $nextLesson = true){
        $countLessons = Lesson::whereCourseId($course_id)->count();
        $countLessonsVieweds = UserLesson::whereUserId(auth()->user()->id)
            ->whereCourseId($course_id)
            ->whereViewed(true)
            ->count();

        $progress = ($countLessonsVieweds * 100) / $countLessons;
        if($progress >= 99) $progress = floor($progress);
        else $progress = ceil($progress);

        $data = [
            'progress' => $progress,
            'completed' => $countLessons == $countLessonsVieweds
        ];

        if($nextLesson){
            if($lesson = Lesson::whereCourseId($course_id)
                ->where('real_index','>',$current_lesson->real_index)
                ->orderBy('real_index')
                ->first()
            ) $current_lesson = $lesson;
            
            $data+= ['current_lesson_id' => $current_lesson->id];
        }

        $userCourse = UserCourse::whereCourseId($course_id)->whereUserId(auth()->user()->id)->update($data);

        return [
            'isCompleted' => $countLessons == $countLessonsVieweds
        ];
    }
    protected function validateRequest(Request $request){
        if(!$course_id = $request->course_id) return [
            'result' => false,
            'response' => 'Id do curso é obrigatório'
        ];
        if(!$lesson_id = $request->lesson_id) return [
            'result' => false,
            'response' => 'Id da atividade é obrigatório'
        ];
          
        return [
            'result' => true,
            'response' => [
                $course_id,
                $lesson_id
            ]
        ];
    }
    public function rating($course_id, $id, $rating){
        if(!$course = Course::with(['lessons' => function($query) use ($id){
            $query->where('id', $id);
        },'studentsPivot' => function($query){
            $query->where('user_id', auth()->user()->id);
        }])->whereId($course_id)->first()) return redirect()->back()->with(
            'message', 'Curso não encontrado'
        );

        if(!$course->studentsPivot->first()) return redirect()->back()->with(
            'message', 'Você não ainda não é membro deste grupo'
        );

        $lesson = $course->lessons->first();
        if(!$lesson) return redirect()->back()->with(
            'message', 'Aula não encontrada'
        );
        
        $student = $lesson->student();
        if(!$student) UserLesson::create([
            'user_id' => auth()->user()->id,
            'lesson_id' => $id,
            'course_id' => $course_id,
            'rating' => $rating
        ]);
        else $student->update(['rating' => $rating]);
        
        return redirect()->back();
    }
}