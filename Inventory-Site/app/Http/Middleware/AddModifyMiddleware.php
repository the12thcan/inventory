<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Member_Position;

class AddModifyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::check())
        {
            //Only users with privilege 2 or higher should be able to access admin page
            $position_id =  $request->user()->position_id;
            //check privilege of the user by looking up their position_id in the member_position table
            $member = Member_Position::find($position_id);
            $privilege = $member->privilege;

            if($privilege>=1)
            {
                return $next($request);
            }
            return redirect('/dashboard');
        }

        return redirect('/login');
    }


}
