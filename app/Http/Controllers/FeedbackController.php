<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index(){
        return view('feedback.index');
    }
    public function store(Request $request){}
    public function delete($id){}
    public function show(){}
    public function more($skip = 0){}
}