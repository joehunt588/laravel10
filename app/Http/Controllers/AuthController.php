<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function servertest()
    {
        return 'Server Up';
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))

            ]);

            return response($user, Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            //throw $th;
            return 'duplicate';
            // return $th;
        }


    }
    public function login(Request $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return \response([
                'error' => 'invalid credential'
            ], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        // The comment /** @var User $user */ is a PHPDoc comment that provides a hint to code editors 
        // and static analysis tools about the expected data type of the variable $user. 
        $user = Auth::user();
        $jwt = $user->createToken('token')->plainTextToken;
        // echo $jwt;
        $cookie = cookie('jwt', $jwt, 60 * 24);
        return response()->json([
            'jwt' => $jwt
        ])->withCookie($cookie);
        //set cors to true for cookie in http
        //config -> cors
        //in order to ket child authentic must modified Authentic.php page
        //at Http->controller->Authcontroller.php
        //insert this code get from middleware
        //     public function handle($request, Closure $next, ...$guards)
        // {
        //     if($jwt= $request->cookie('jwt')){
        //         $request->headers->set('Authorization','Bearer '.$jwt);
        //     };
        //     $this->authenticate($request, $guards);

        //     return $next($request);
        // }

    }

    public function user(Request $request)
    {
        return response()->json($request->user()) ;
    }

    public function logout()
    {

        $cookie = \Cookie::forget('jwt');
        return \response([
            'message' => 'success'
        ])->withCookie($cookie);
    }
}