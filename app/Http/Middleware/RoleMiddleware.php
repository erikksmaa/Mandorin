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
     * Role diperiksa berdasarkan slug dari relasi $user->role.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        if (!auth()->check()) {
            abort(403);
        }

        $user = auth()->user();
        $userRoleSlug = $user->role?->slug ?? '';

        // Map aliases to standard slugs
        $aliasMap = [
            'admin' => 'administrator',
            'verifier' => 'verifikator',
        ];

        $userRoleNormalized = $aliasMap[$userRoleSlug] ?? $userRoleSlug;

        $normalizedAllowedRoles = array_map(function ($r) use ($aliasMap) {
            return $aliasMap[$r] ?? $r;
        }, $roles);

        if (!in_array($userRoleNormalized, $normalizedAllowedRoles) && !in_array($userRoleSlug, $roles)) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}