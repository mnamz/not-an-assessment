<?php

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->status === UserStatus::Inactive->value) {
                // Could've made a page but this should be quick way to flash message
                session()->flash('status', 'Your account is inactive. You will be logged out in 5 seconds.');
                return response()->make("
                    <script>
                        setTimeout(function () {
                            document.getElementById('logout-form').submit();
                        }, 5000);
                    </script>
                    <h1>".session('status')."</h1>
                    <form id='logout-form' action='".route('logout')."' method='POST' style='display: none;'>
                        ".csrf_field()."
                    </form>
                ");
            } else if ($user->status === UserStatus::Pending->value) {
                session()->flash('status', 'Your account is pending activation. You will be logged out in 5 seconds.');
                return response()->make("
                    <script>
                        setTimeout(function () {
                            document.getElementById('logout-form').submit();
                        }, 5000);
                    </script>
                    <h1>".session('status')."</h1>
                    <form id='logout-form' action='".route('logout')."' method='POST' style='display: none;'>
                        ".csrf_field()."
                    </form>
                ");
            }

        }

        return $next($request);
    }
}
