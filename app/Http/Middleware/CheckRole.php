<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class CheckRole {
    public function handle($request, Closure $next, $access) {
        if (!Auth::check())
            return redirect('/login');

        if (!Auth::user()->hasAccess($access))
            abort(403, 'У вашої ролі немає доступу до цієї сторінки :`(');

        return $next($request);
    }
}
