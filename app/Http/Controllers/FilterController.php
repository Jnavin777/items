<?php

namespace App\Http\Controllers;

use App\Enum\ConditionEnum;
use App\Models\Branch;
use App\Models\Category;
use App\Services\FunctionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class FilterController extends Controller
{
    /** @var FunctionService */
    private $functionService;


    public function __construct(FunctionService $functionService)
    {
        $this->functionService = $functionService;
    }

    public function makeFilter(string $name)
    {
        $filterName = 'filter'.ucfirst($name);
        $filterOptions = $this->$filterName();

        return new JsonResponse(['data' => $filterOptions], Response::HTTP_OK);
    }

    private function filterBranch()
    {
        return Branch::select(['id as value', 'name as text'])->where(['user_id' => Auth::id()])->get()->toArray();
    }

    private function filterCondition()
    {
        return ConditionEnum::$filterArray;
    }

    private function filterCategory()
    {
        return Category::select(['id as value', 'name as text'])->where(['user_id' => Auth::id()])->get()->toArray();
    }

    private function filterRole()
    {
        return Role::select(['id as value', 'name as text'])->get()->toArray();
    }

    private function filterPermission()
    {
        return Permission::select(['id as value', 'name as text'])->orderBy('id')->get()->toArray();
    }

    private function filterOwnedTeamsUsers()
    {
        $users = [];
        $teams = Auth::user()->ownedTeams()->get();
        foreach ($teams as $team) {
            $teamUsers = $team->users()->get()->toArray();
            $users = array_merge($users, $teamUsers);
        }

        $users = $this->functionService->uniqueMultiDimArray($users,'id');

        $resolvedArray = [];
        foreach ($users as $user) {
            $resolvedArray[] = [
                'value' => $user['id'],
                'text' => $user['name']
            ];
        }
        return $resolvedArray;
    }
}
