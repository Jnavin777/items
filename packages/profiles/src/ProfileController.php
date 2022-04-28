<?php

namespace Profiles;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function profile(int $id)
    {
        $user = User::findOrFail($id);
        return view('profile::profile', compact('user'));
    }

    public function myProfile()
    {
        $user = User::where(['id' => Auth::id()])->with('roles','teams', 'ownedTeams')->first();

        return view('profile::my-profile', compact('user'));
    }

    public function profileUpdate (Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        return new JsonResponse($user, Response::HTTP_OK);
    }
}
