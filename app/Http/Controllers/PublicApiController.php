<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PublicApiController extends Controller
{
    // Lấy danh sách các bài viết
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts, 200);
    }

    // Thêm mới bài viết
    public function store(Request $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json($post, 201);
    }

    // Lấy chi tiết bài viết
    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post không tồn tại'], 404);
        }
        return response()->json($post, 200);
    }

    // Cập nhật bài viết
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post không tồn tại'], 404);
        }

        $post->update($request->only(['title', 'content']));
        return response()->json($post, 200);
    }

    // Xóa bài viết
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Post không tồn tại'], 404);
        }

        $post->delete();
        return response()->json(['message' => 'Post đã bị xóa'], 200);
    }
}
