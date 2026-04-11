<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegenerateSessionAfterLogin
{
    /**
     * Safely regenerate session ID after a Livewire-based login.
     *
     * This runs on a full HTTP request (not a Livewire AJAX call),
     * so session()->regenerate() will correctly propagate the new
     * session cookie to the browser — preventing session fixation
     * without causing the two-attempt login bug.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->pull('_login_success')) {
            $request->session()->regenerate();
        }

        return $next($request);
    }
}
