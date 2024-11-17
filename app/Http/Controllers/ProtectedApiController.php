<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ProtectedApiController extends Controller
{
    // Lấy danh sách các bài viết (yêu cầu đăng nhập)
    public function index()
    {
        if (Auth::check()) {
            $posts = Post::all();
            return response()->json($posts, 200);
        } else {
            return response()->json(['message' => 'Bạn cần đăng nhập để truy cập dữ liệu này.'], 401);
        }
    }

    // Thêm mới bài viết (yêu cầu đăng nhập)
    public function store(Request $request)
    {
        if (Auth::check()) {
            $post = Post::create([
                'title' => $request->title,
                'content' => $request->content,
            ]);
            return response()->json($post, 201);
        } else {
            return response()->json(['message' => 'Bạn cần đăng nhập để thêm bài viết.'], 401);
        }
    }

    // Lấy chi tiết bài viết (yêu cầu đăng nhập)
    public function show($id)
    {
        if (Auth::check()) {
            $post = Post::find($id);
            if (!$post) {
                return response()->json(['message' => 'Post không tồn tại'], 404);
            }
            return response()->json($post, 200);
        } else {
            return response()->json(['message' => 'Bạn cần đăng nhập để xem chi tiết bài viết.'], 401);
        }
    }

    // Cập nhật bài viết (yêu cầu đăng nhập)
    public function update(Request $request, $id)
    {
        if (Auth::check()) {
            $post = Post::find($id);
            if (!$post) {
                return response()->json(['message' => 'Post không tồn tại'], 404);
            }
            $post->update($request->only(['title', 'content']));
            return response()->json($post, 200);
        } else {
            return response()->json(['message' => 'Bạn cần đăng nhập để cập nhật bài viết.'], 401);
        }
    }

    // Xóa bài viết (yêu cầu đăng nhập)
    public function destroy($id)
    {
        if (Auth::check()) {
            $post = Post::find($id);
            if (!$post) {
                return response()->json(['message' => 'Post không tồn tại'], 404);
            }
            $post->delete();
            return response()->json(['message' => 'Post đã bị xóa'], 200);
        } else {
            return response()->json(['message' => 'Bạn cần đăng nhập để xóa bài viết.'], 401);
        }
    }
}
