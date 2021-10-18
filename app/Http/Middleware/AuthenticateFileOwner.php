<?php

namespace App\Http\Middleware;

use App\Models\File;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AuthenticateFileOwner
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $file = File::query()->firstWhere('id', $request->id);

        if ($file && $file->user_id == auth()->id()) {
            return $next($request);
        } else {
            return redirect(route('file.index'))->with('error', 'File doesnt exist');
        }
    }
}
