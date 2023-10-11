<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function showCreateForm()
    {
        return view('create-post');
    }
    public function storeNewPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => ['required'],
            'body' => ['required'],
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newpost = Post::create($incomingFields);

        return redirect("/post/{$newpost->id}")->with('success','successfully created blog');
    }
    public function viewSinglePost(Post $postedid)
    {   
        //normal markdown
        // $ourHTML = Str::markdown($postedid->body);
        //markdown with filter
        //strip_tags only allow <p><ul><ol><li><strong><em>
        $ourHTML = strip_tags(Str::markdown($postedid->body),'<p><ul><ol><li><strong><em>');
        $postedid['body'] = $ourHTML;

        return view('single-post',['post'=>$postedid]);
    }
}