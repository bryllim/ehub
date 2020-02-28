<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use SweetAlert;

class PostController extends Controller
{
    public function newPost(Request $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->save();

        alert()->success(' ', 'Successfully posted!');
        return back();
    }
}
