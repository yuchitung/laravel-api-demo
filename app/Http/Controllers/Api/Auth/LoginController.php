<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Handle a login request to the application.
     *
     * @param App\Http\Requests\UserLoginRequest
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(UserLoginRequest $request)
    {
        /**
         *  Verify the credentials and create a token for the user
         */
        try {
            if (!$token = JWTAuth::attempt(
                $this->getCredentials($request)
            )) {
                return $this->onUnauthorized();
            }
        } catch (JWTException $e) {
            
            return $this->onJwtGenerationError();
        }

        return $this->onAuthorized($token);
    }

    /**
     * Unauthorized
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function onUnauthorized()
    {
        return response()->json([
            'message' => 'invalid_credentials'
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Can not generate a token
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function onJwtGenerationError()
    {
        return response()->json([
            'message' => 'could_not_create_token'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Authorized
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function onAuthorized($token)
    {
        return response()->json([
            'message' => 'token_generated',
            'data' => [
                'token' => $token,
            ]
        ]);
    }

    /**
     * Get the needed authorization credentials from the request
     *
     * @param App\Http\Requests\UserLoginRequest
     * @return array
     */
    protected function getCredentials(UserLoginRequest $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Invalidate a token
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteInvalidate()
    {
        $token = JWTAuth::parseToken();

        $token->invalidate();

        return response()->json(['message' => 'token_invalidated']);
    }

    /**
     * Refresh a token
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function patchRefresh()
    {
        $token = JWTAuth::parseToken();

        $newToken = $token->refresh();

        return response()->json([
            'message' => 'token_refreshed',
            'data' => [
                'token' => $newToken
            ]
        ]);
    }

    /**
     * Get authenticated user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getUser()
    {
        return response()->json([
            'message' => 'authenticated_user',
            'data' => JWTAuth::parseToken()->authenticate()
        ]);
    }
}