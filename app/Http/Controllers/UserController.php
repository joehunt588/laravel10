<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreatedRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
// use Hash;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return User::paginate(1); //select how many page to display
        // return User::with('role')->paginate(10);
        //using UserResource
        return UserResource::collection(User::paginate(10)) ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreatedRequest $request)
    //UserCreatedRequest only need first_name ,last_name and email must required
    {
        $user = User::create(
            $request->only('first_name', 'last_name', 'email') + ['password' => Hash::make(1234)]
        );
        // return response($user, Response::HTTP_CREATED);
        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return User::find($id);
        // return User::with('role')->find($id);
        return new UserResource(User::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    //UserUpdateRequest check email is must email
    {
        $user = User::find($id);
        $user->update($request->only('first_name', 'last_name', 'email'));
        return response($user, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
