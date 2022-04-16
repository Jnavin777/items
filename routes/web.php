<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminRoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'auth.lock'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/inventory/get-items', [InventoryController::class,'getItems'])->name('inventory.getItems');
    Route::get('/inventory/{inventory}/items', [ItemController::class,'getItemsByInventory'])->name('category.getItemsByInventory');
    Route::resource('/inventory', InventoryController::class)->middleware(['role_or_permission:super-admin|edit inventories']);

    Route::get('/branch/get_item', [BranchController::class,'getItems'])->name('branch.getItems');
    Route::get('/branch/{id}/inventories', [BranchController::class,'getInventories'])->name('branch.getInventories');
    Route::resource('/branch', BranchController::class);

    Route::get('/category/get_item', [CategoryController::class,'getItems'])->name('category.get-items');
    Route::resource('/category', CategoryController::class);
    Route::resource('/item', ItemController::class);
    Route::post('/item', [ItemController::class, 'store'])->name('item.store');
    Route::patch('/item/{id}', [ItemController::class,'update'])->name('item.update');
    Route::post('/item', [ItemController::class,'store'])->name('item.store');

    Route::get('/get-filter/{name}', [FilterController::class, 'makeFilter'])->name('get-filter');

});
Route::get('login/locked', [LoginController::class, 'locked'])->middleware('auth')->name('login.locked');
Route::post('login/locked', [LoginController::class, 'unlock'])->name('login.unlock');
Route::get('/to-locked', [LoginController::class, 'toLocked'])->name('login.toLocked');

require __DIR__.'/auth.php';

Route::prefix('admin')->middleware(['auth', 'auth.lock', 'role:Super Admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/', [AdminDashboardController::class,'dashboard'])->name('admin.index');

    Route::get('/user/get-items', [AdminUserController::class,'getItems'])->name('user.getItems');
    Route::resource('/user', AdminUserController::class);

    Route::get('/role/get-items', [AdminRoleController::class,'getItems'])->name('role.getItems');
    Route::resource('/role', AdminRoleController::class);

});

/**
 * Teamwork routes
 */
Route::group(['prefix' => 'teams', 'namespace' => 'Teamwork'], function()
{
    Route::get('/', [App\Http\Controllers\Teamwork\TeamController::class, 'index'])->name('teams.index');
    Route::get('create', [App\Http\Controllers\Teamwork\TeamController::class, 'create'])->name('teams.create');
    Route::post('teams', [App\Http\Controllers\Teamwork\TeamController::class, 'store'])->name('teams.store');
    Route::get('edit/{id}', [App\Http\Controllers\Teamwork\TeamController::class, 'edit'])->name('teams.edit');
    Route::put('edit/{id}', [App\Http\Controllers\Teamwork\TeamController::class, 'update'])->name('teams.update');
    Route::delete('destroy/{id}', [App\Http\Controllers\Teamwork\TeamController::class, 'destroy'])->name('teams.destroy');
    Route::get('switch/{id}', [App\Http\Controllers\Teamwork\TeamController::class, 'switchTeam'])->name('teams.switch');

    Route::get('members/{id}', [App\Http\Controllers\Teamwork\TeamMemberController::class, 'show'])->name('teams.members.show');
    Route::get('members/resend/{invite_id}', [App\Http\Controllers\Teamwork\TeamMemberController::class, 'resendInvite'])->name('teams.members.resend_invite');
    Route::post('members/{id}', [App\Http\Controllers\Teamwork\TeamMemberController::class, 'invite'])->name('teams.members.invite');
    Route::delete('members/{id}/{user_id}', [App\Http\Controllers\Teamwork\TeamMemberController::class, 'destroy'])->name('teams.members.destroy');

    Route::get('accept/{token}', [App\Http\Controllers\Teamwork\AuthController::class, 'acceptInvite'])->name('teams.accept_invite');
});


