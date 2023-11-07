<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    //
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    public function store(Request $request)
    {
        //create new role use POST
        $role = Role::create($request->only('name'));
        //create role send list of id for permission where id is belongs
        // $role->permissions()->attach(input('permissions'));
        $role->permissions()->sync($request->input('permissions'));

        return response(new RoleResource($role->load('permissions')), Response::HTTP_CREATED);
    }
    public function show($id)
    {
        //with is whenloaded resources`
        // $role = Role::find($id);
        // return $role;
        // return response($role, Response::HTTP_OK);
        return new RoleResource(Role::with('permissions')->find($id));
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->update($request->only('name'));
        //update we have to remove all permision and add new permision
        $role->permissions()->sync($request->input('permissions'));
        // return response($role, Response::HTTP_ACCEPTED);
        return response(new RoleResource($role->load('permissions')), Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        // $role = Role::find($id);
        // $role->delete();
        Role::destroy($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
