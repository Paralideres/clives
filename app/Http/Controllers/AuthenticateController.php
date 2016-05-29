<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Requests\Auth\AuthenticateRequest;

class AuthenticateController extends Controller
{

    use ThrottlesLogins;

    // Lockout time in seconds
    private $lockoutTime = 120;

    public function authenticate(AuthenticateRequest $request)
    {

        // User is locked out
        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // grab credentials from the request
        $credentials = $request->only($this->loginUsername(), 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {

                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                if (! $lockedOut) {
                    $this->incrementLoginAttempts($request);
                }

                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $this->clearLoginAttempts($request);

        // all good so return the token
        return response()->json(compact('token'));
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->secondsRemainingOnLockout($request);

        return response()->json($this->getLockoutErrorMessage($seconds), 403);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }
}
