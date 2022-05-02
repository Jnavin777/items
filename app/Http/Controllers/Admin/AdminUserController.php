<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Symfony\Component\HttpFoundation\Response;

class AdminUserController extends Controller
{
    use HasRoles;
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('admin.users.index');
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
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->lockout_time = 10;
        $user->syncRoles($request->input('role'));
        $user->save();

        return new JsonResponse($user, Response::HTTP_OK);
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
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->syncRoles($request->input('role'));
        $user->save();
        return new JsonResponse($user, Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return new JsonResponse([], Response::HTTP_OK);
    }

    public function getItems()
    {
        $users = User::where('id', '!=', Auth::id())->with('roles')->get()->toArray();
        foreach ($users as $key => $user) {
            $roles = $user['roles'];
            $users[$key]['roles'] = [];
            foreach ($roles as $role) {
                $users[$key]['roles'][] = [
                    'id' => $role['id'],
                    'name' => $role['name']
                ];
//                    array_push($users[$key]['roles'], $role['id']);
//                array_push($users[$key]['roles'], $role['name']);
            }
        }

        return new JsonResponse($users, Response::HTTP_OK);
    }
}
