<?php

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Models\Branch;
use App\Models\Inventory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BranchController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('branches.index', [
            'isAddNewBranch' => in_array(RoleEnum::ROLE_CLIENT,Auth::user()->getRoleNames()->toArray()),
        ]);
    }

    /**
     *
     */
    public function create()
    {
//
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $newBranch = new Branch();
        $newBranch->name = $request->get('name');
        $newBranch->resp_user_id = $request->get('respUserId');
        $newBranch->user_id = Auth::id();

        $newBranch->save();
        return new JsonResponse($newBranch, Response::HTTP_OK);
    }

    /**
     * @param Branch $branch
     */
    public function show(Branch $branch)
    {
        return view('branches.show', [
            'item' => $branch
        ]);
    }

    /**
     * @param Branch $branch
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * @param Request $request
     * @param Branch $branch
     * @return JsonResponse
     */
    public function update(Request $request, Branch $branch)
    {
        $branch->name = $request->get('name');
        $branch->resp_user_id = $request->get('resp_user_id');
        $branch->save();
        return new JsonResponse($branch, Response::HTTP_OK);
    }

    /**
     * @param Branch $branch
     * @return JsonResponse
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return new JsonResponse([], Response::HTTP_OK);
    }

    public function getItems()
    {
        $roles = Auth::user()->getRoleNames()->toArray();
        if(in_array(RoleEnum::ROLE_CLIENT, $roles)) {
            $criteria = ['user_id' => Auth::id()];
        } else {
            $criteria = ['resp_user_id' => Auth::id()];
        }

        $branches = Branch::where($criteria)->with('user','respUser')->get();

        $data = [];
        if(!empty($branches)) {
            foreach ($branches as $key => $branch) {
                $data[$key]['branch'] = $branch;
                $data[$key]['totalItems'] = $branch->inventories()->count();
            }
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }

    public function getInventories(int $id)
    {
        $inventories = Inventory::where(['user_id' => Auth::id(), 'branch_id' => $id])->with(['user','branch',])->get();

        $data = [];
        if(!empty($inventories)) {
            foreach ($inventories as $key => $inventory) {
                $data[$key]['inventory'] = $inventory;
                $data[$key]['totalItems'] = $inventory->items()->count();
            }
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
