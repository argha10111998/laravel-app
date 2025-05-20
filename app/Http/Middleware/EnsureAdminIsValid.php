<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // echo 'abcs';
        // dd();
        if (!(Auth::guard('admin')->check())) {
            // echo 'abcd';
            // dd();
            return redirect()->route('user-login')->with('error', 'Must Be An Admin To Access The Page');
        }

        return $next($request);
    }
}
