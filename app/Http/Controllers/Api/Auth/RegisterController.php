<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\UserCreateRequest;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Prettus\Validator\Exceptions\ValidatorException;
use Throwable;

class RegisterController extends Controller
{

    /**
     * Register new user
     *
     * @param UserCreateRequest 
     * @param UserRepository 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(UserCreateRequest $request,UserRepository $repository)
    {
        try{
        
        $user = $repository->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' =>app('hash')->make($request->input('password'))
        ]);

        return response()->json([
            'message' => 'Success',
            'data' => $user
        ]);

        } catch (ValidatorException $e) {
        
            return response()->json(['error' => 'validation exception'], 500);

        } catch (Throwable $e) {
        
            return response()->json(['errors' => 'Error'], 500);
        }

    }

}