<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = auth('api')->user()->posts()->with('user')->paginate(10);
        return response()->json([
            'posts' => $posts,
            'message' => 'Posts retrieved successfully',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string',
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }
        $postData = [
            'content' => $validated['content'],
            'image' => $imagePath,
        ];

        // Only add title to the data if it exists in the request
        if (isset($validated['title']) && !empty($validated['title'])) {
            $postData['title'] = $validated['title'];
        }

        $post = auth('api')->user()->posts()->create($postData);

        return response()->json([
            'post' => $post,
            'message' => 'Post created successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = auth('api')->user()->posts()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string',
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [];
        if ($request->has('title')) {
            $data['title'] = $validated['title'];
        }
        if ($request->has('content')) {
            $data['content'] = $validated['content'];
        }

        if ($request->hasFile('image')) {
            // Optional: remove old image file if it exists
            if (!empty($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);
        return response()->json([
            'post' => $post->fresh(),
            'message' => 'Post updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $post = auth('api')->user()->posts()->findOrFail($id);
        $post->delete();
        return response()->json([
            'message' => 'Post deleted successfully',
        ]);
    }
}
