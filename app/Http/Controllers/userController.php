<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class userController extends Controller
{
    //
    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:1', 'confirmed']
        ]);
        //save to db
        $user = User::create($incomingFields);
        //login
        auth()->login($user);
        return redirect('/')->with('success','Account Created');
    }

    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            'loginusername' => ['required'],
            'loginpassword' => ['required'],
        ]);
        if (
            auth()->attempt([
                'username' => $incomingFields['loginusername'],
                'password' => $incomingFields['loginpassword']
            ])
        ) {
            $request->session()->regenerate();
            // return 'Congrat';
            return redirect('/')->with('success','You have login');
        } else {
            // return 'failed';
            return redirect('/')->with('fail','invalid login');
        }
    }
    public function showCorrectHomePage(){
        
        if(auth()->check()){
            return view('homepage-feed');
        }else{
            return view('homepage');
        }
    }

    public function logout(){
        
        auth()->logout();
        return redirect('/')->with('success','you logout');
    }
}