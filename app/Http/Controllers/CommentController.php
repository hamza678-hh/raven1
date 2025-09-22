<?php

namespace App\Http\Controllers;
use App\Http\Requests\CommentBlogRequest;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentBlogRequest $request){
        // dd($request->all());
        $data=$request->validated();
        Comment::create($data);
        return back()->with('CommentStatues','Your Comment send successfully');
    }
}
