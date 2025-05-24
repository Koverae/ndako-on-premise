<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;

class CheckIfInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $installed = File::exists(storage_path('installed'));

        // If installed and trying to access installer, redirect to dashboard/home
        if ($installed && $request->is('installer*')) {
            return redirect('/web');
        }

        // If NOT installed and NOT accessing installer, redirect to installer
        if (!$installed && !$request->is('install*')) {
            return redirect('/install');
        }

        return $next($request);
    }
}
