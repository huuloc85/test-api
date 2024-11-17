<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Thêm tài khoản người dùng mới (Register)
    public function register(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8', // password confirmation
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Trả về lỗi nếu dữ liệu không hợp lệ
        }

        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);

        // Tạo token cho người dùng mới
        $token = $user->createToken('testAPI')->plainTextToken;

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // Đăng nhập người dùng (Login)
    public function login(Request $request)
    {
        // Kiểm tra thông tin người dùng và đăng nhập
        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Login successful']);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }


    // Đăng xuất người dùng (Logout)
    public function logout(Request $request)
    {
        // Hủy bỏ tất cả các token của người dùng hiện tại
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
