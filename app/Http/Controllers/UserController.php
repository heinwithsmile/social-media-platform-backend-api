<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * User profile
     * @return JsonResponse
     * @author Hein Htet Aung
     * @date 2025-09-24
     */
    public function profile()
    {
        $user = auth('api')->user();
        $post_count = $user->posts()->count();
        $comment_count = $user->comments()->count();
        $reaction_count = $user->reactions()->count();
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format('d-M-Y'),
                'updated_at' => $user->updated_at->format('d-M-Y'),
            ],
            'post_count' => $post_count,
            'comment_count' => $comment_count,
            'reaction_count' => $reaction_count,
        ]);
    }
}
