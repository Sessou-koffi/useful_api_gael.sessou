<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    public function handle(Request $request, Closure $next, $moduleId)
    {
        $user = $request->user();

        $isActive = $user->modules()
            ->where('modules.id', $moduleId)
            ->wherePivot('active', true)
            ->exists();

        if (!$isActive) {
            return response()->json([
                'error' => 'Forbidden'
            ], 403);
        }

        return $next($request);
    }
}


