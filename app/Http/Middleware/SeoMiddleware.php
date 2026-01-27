<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $robots = "index, follow";

        $path = $request->path();

        // TAG PAGES → noindex
        if (str_starts_with($path, 'tag/')) {
            $robots = "noindex, follow";
        }

        // ARCHIVE PAGES → noindex
        if (str_starts_with($path, 'archive/')) {
            $robots = "noindex, follow";
        }

        // ADMIN / DASHBOARD → noindex nofollow
        if (str_starts_with($path, 'admin') || str_starts_with($path, 'dashboard')) {
            $robots = "noindex, nofollow";
        }

        // PAGINATION > page 1 → noindex
        if ($request->has('page') && $request->page > 1) {
            $robots = "noindex, follow";
        }

        // Tambahkan ke header HTML
        $response->header('X-Robots-Tag', $robots);

        view()->share('robots', $robots);

        return $response;
    }
}
