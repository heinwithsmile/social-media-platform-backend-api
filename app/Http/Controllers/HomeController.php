<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reaction;

class HomeController extends Controller
{
    public function getAllPosts()
    {
        $posts = Post::all();
        $posts->load('user', 'comments', 'reactions');
        return response()->json($posts);
    }

    public function getCommentsByPostId($postId)
    {
        $comments = Comment::where('post_id', $postId)->get();
        return response()->json($comments);
    }

    public function getReactionsByPostId($postId)
    {
        $reactions = Reaction::where('post_id', $postId)->get();
        return response()->json($reactions);
    }
}
