<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BranchController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/inventory', [InventoryController::class,'index'])->name('inventory.index');
    Route::post('/inventory', [InventoryController::class,'store'])->name('inventory.store');
    Route::patch('/inventory/{id}', [InventoryController::class,'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class,'destroy'])->name('inventory.destroy');
    Route::get('/inventory/get_items', [InventoryController::class,'getItems'])->name('inventory.get-items');
    Route::get('/inventory/{id}', [InventoryController::class,'show'])->name('inventory.show');
    Route::get('/category/get_item', [CategoryController::class,'getItems'])->name('category.get-items');
    Route::resource('/category', CategoryController::class);
    Route::get('/branch/get_item', [BranchController::class,'getItems'])->name('branch.get-items');
    Route::get('/branch/{id}/inventories', [BranchController::class,'getInventories'])->name('branch.getInventories');
    Route::resource('/branch', BranchController::class);
    Route::resource('/item', ItemController::class);
    Route::post('/item', [ItemController::class, 'store'])->name('item.store');;
    Route::patch('/item/{id}', [ItemController::class,'update'])->name('item.update');
    Route::post('/item', [ItemController::class,'store'])->name('item.store');
    Route::get('/inventory/{inventory}/get_item', [ItemController::class,'getItemsByInventory'])->name('category.get-items-by-inventory');

});


require __DIR__.'/auth.php';
