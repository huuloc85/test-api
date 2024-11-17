<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Nếu yêu cầu là JSON, không cần chuyển hướng, trả về null hoặc bạn có thể trả về thông báo lỗi.
        if ($request->expectsJson()) {
            // API thường trả về lỗi Unauthorized (401)
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Nếu không phải JSON (trong trường hợp bạn sử dụng web routes), trả về trang login
        return route('login');
    }
}
