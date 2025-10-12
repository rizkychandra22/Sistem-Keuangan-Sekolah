<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Message;

class UnreadMessagesCount
{
    public function handle(Request $request, Closure $next)
    {
        $unreadCount = Message::where('is_read', false)->count();
        view()->share('unreadCount', $unreadCount);

        return $next($request);
    }
}