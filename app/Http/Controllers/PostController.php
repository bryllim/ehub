<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use SweetAlert;
use App\Acknowledgement;

class PostController extends Controller
{
    public function newPost(Request $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->save();

        $acknowledgement = new Acknowledgement;
        $acknowledgement->post_id = $post->id;
        $acknowledgement->user_id = Auth::user()->id;
        $acknowledgement->save();  

        alert()->success(' ', 'Successfully posted!');
        return back();
    }
}
