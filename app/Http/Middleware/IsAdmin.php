<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     $userId = auth()->user()->id;
    //     $userRoles = User::find($id)->roles()->select('role')->get()->toArray();
     
    //     foreach($userRoles as $userRole) {
    //         if($userRole['role'] === 'admin'){
    //             return $next($request);
    //         }
    //     }
    //     return response()->json("You don\'t have access", 400);
    // }
}
