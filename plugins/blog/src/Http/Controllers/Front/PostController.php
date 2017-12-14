<?php namespace WebEd\Plugins\Blog\Http\Controllers\Front;

use  WebEd\Plugins\Blog\Models\Post;
use Illuminate\Http\Request;

class PostController{
    public function read(Post $post ,Request $request){
       $r=$post->read($request->id);
       echo "<pre>";
       print_r($r);
    }
}

