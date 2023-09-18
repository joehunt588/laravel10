<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function hello()
    {
        return 'hello johan';
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))

        ]);
        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        //login Authentication only need email and password
        if (!Auth::attempt($request->only('email', 'password'))) {
            return \response([
                'error' => 'Invalid credentialss'
            ], Response::HTTP_UNAUTHORIZED);
        }
        // echo 'hello';
        //user exist
        /** @var User $user */
        // $user = Auth::user();
        $user = Auth::user();
        //create token 
        $jwt = $user->createToken('token')->plainTextToken;

        //create cookie
        $cookie = cookie('jwt', $jwt, 60 * 24);

        //return token
        return \response([
            'jwt' => $jwt
        ])->withCookie($cookie);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout()
    {

        $cookie = \Cookie::forget('jwt');
        return \response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    //use when login
    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = $request->user();
        $user->update($request->only('first_name', 'last_name', 'email'));

        return \response($user, Response::HTTP_ACCEPTED);
    }
    //update password
    //Request UpdateInfoRequest
    //php artisan make:request UpdateInfoRequest
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return \response($user, Response::HTTP_ACCEPTED);
    }
}