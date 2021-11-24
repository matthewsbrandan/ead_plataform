<?php

namespace App\Observers;

use App\Models\Chat;

class ChatObserver
{

    public function created(Chat $chat){
        if($chat->answer_id){
            if($father = Chat::whereId($chat->answer_id)->first()){
                $breadcrumbs = '';
                if($father->breadcrumbs) $breadcrumbs = $father->breadcrumbs."-";
                $breadcrumbs.= $father->id;

                $chat->update([
                    'depth' => $father->depth+1,
                    'breadcrumbs' => $breadcrumbs
                ]);
                
                $father->update(['num_answers' => $father->num_answers+1]);
            }
        }        
    }

    public function updated(Chat $chat){    }

    public function deleted(Chat $chat){
        if($chat->answer_id){
            if($father = Chat::whereId($chat->answer_id)->first()){
                $father->update(['num_answers' => $father->num_answers-1]);
            }
        }
    }
}
