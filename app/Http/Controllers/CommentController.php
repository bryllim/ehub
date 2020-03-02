<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Auth;

class CommentController extends Controller
{
    public function newComment(Request $request)
    {
        $comment = new Comment;
        $comment->content = $request->content;
        $comment->post_id = $request->post_id;
        $comment->user_id = Auth::user()->id;
        $comment->save();        
        
        return 1;
    }

    public function fetchComments(Request $request)
    {
        $results = Comment::where('post_id', '=', $request->id)->get();
        $comments = [];

        foreach($results as $result){
            array_push($comments, 
                [   
                    "user"      => $result->user->name,
                    "content"   => $result->content,
                    "date"      => $result->created_at->diffForHumans()
                ]
            );
        }
        return $comments;
    }
}
