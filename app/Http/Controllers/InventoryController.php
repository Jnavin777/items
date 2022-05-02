<?php

namespace App\Http\Controllers;

use App\Enum\ConditionEnum;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InventoryController extends Controller
{
    public function index()
    {
        return view('inventories.index');
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


    public function store(Request $request)
    {
        $newInventory = new Inventory();
        $newInventory->name = $request->get('name');
        $newInventory->description = $request->get('description');
        $newInventory->branch_id = $request->get('branch_id');
        $newInventory->user_id = Auth::id();
        $newInventory->save();
        return new JsonResponse($newInventory, Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        return view('inventories.show', [
            'item' => Inventory::where(['id' => $id])->with(['branch'])->first()
        ]);
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
     * @param Request $request
     * @param Inventory $inventory
     * @return JsonResponse
     */
    public function update(Request $request, Inventory $inventory)
    {
        $inventory->name = $request->get('name');
        $inventory->description = $request->get('description');
        $inventory->branch_id = $request->get('branch_id');
        $inventory->user_id = Auth::id();
        $inventory->save();
        return new JsonResponse($inventory, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Inventory $inventory
     * @return JsonResponse
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->items()->delete();
        $inventory->delete();
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }


    public function getItems()
    {
        $inventories = Inventory::where(['user_id' => Auth::id()])->with(['user','branch',])->get();

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
