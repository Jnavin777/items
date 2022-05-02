<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->syncPermissions($request->input('permissions'));
        $role->save();

        return new JsonResponse($role, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(Request $request, Role $role)
    {
        $role->name = $request->input('name');
        $role->syncPermissions($request->input('permissions'));
        $role->save();
        return new JsonResponse($role, Response::HTTP_OK);
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return new JsonResponse([], Response::HTTP_OK);
    }

    public function getItems()
    {
        $roles = Role::with(['permissions'])->get();

        return new JsonResponse($roles, Response::HTTP_OK);
    }
}
