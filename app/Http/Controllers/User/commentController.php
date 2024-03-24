<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class commentController extends Controller
{
    public function store(Request $request) {

        if ($request->isMethod('post')) {
            $data = $request->all();
            $comment = Comment::create($data);
            if($comment) {
                $post = Post::find($request->post_id);
                $comments = Comment::where('post_id', $request->post_id)->where('parent_id' , 0)->get();
                return view('user.design.comment', compact('comments', 'post'));
            }
            return response()->json([
                'result' => $comment,
            ]);
        }
    }


    public function delete($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $comment = Comment::find($id);
        $postID = $comment->post_id;
        $post = Post::find($postID);
        $comment->delete();
        $comments = Comment::where('post_id', $postID)->where('parent_id', 0)->get();
        return view('user.design.comment' , compact('comments', 'post'));
    }
}
