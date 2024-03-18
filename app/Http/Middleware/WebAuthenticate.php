<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\Utils;

class WebAuthenticate
{
    protected $roles = ['admin'];

    protected $mapRolesToUrls = [
        // Front
        'GET-/admin/users' => ['admin'],

        // Web
        'POST-/web/auth/signout' => ['admin'],

        'GET-/web/users' => ['admin'],
        'GET-/web/users/{id}/purchase-history' => ['admin'],
    ];

    public function handle(Request $request, Closure $next, string ...$params): Response
    {
        // define auth page urls
        $authPageUrls = [
            'GET-/admin/auth/signin',
            'GET-/admin/auth/signup',
        ];

        // get method and url of request
        $requestedMethod = $request->getMethod();
        $requestedUrl = $request->getPathInfo();
        if (key_exists(0, $params)) {
            $requestedUrl = $params[0];
        }

        if (Auth::check()) {
            // if user has already signed in and url requested is auth page url, redirect default page per role
            if (in_array($requestedMethod . '-' . $requestedUrl, $authPageUrls)) {
                $user = Auth::user();
                $redirectUrl = match ($user->role) {
                    'admin' => '/admin/users',
                    default => null
                };
                if ($redirectUrl === null)
                    return Utils::responseJsonError(trans('invalid_user'));
                return response()->redirectTo($redirectUrl);
            }

            // check if current user has authority for access to this url
            if (key_exists($requestedMethod . '-' . $requestedUrl, $this->mapRolesToUrls))
                return $next($request);
            else
                return Utils::responseJsonError(trans('access_denied'));
        } else {
            // if current user did not sign in yet, redirect to sign in page
            if (!in_array($requestedMethod . '-' . $requestedUrl, $authPageUrls)) {
                $role = explode('/', $requestedUrl)[1];
                return response()->redirectTo((in_array($role, $this->roles) ? '/'.$role : '/admin') . '/auth/signin');
            } else {
                return $next($request);
            }
        }
    }
}
