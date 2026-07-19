<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Menerima satu atau lebih role yang diizinkan.
     * PENTING: role di-cast ke UserRole enum, jadi harus pakai ->value
     * supaya perbandingan string berjalan benar.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        if (!auth()->check()) {
            abort(403);
        }

        $userRole = auth()->user()->role->value ?? auth()->user()->role;

        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}