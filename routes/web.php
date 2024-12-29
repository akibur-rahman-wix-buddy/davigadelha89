<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Backend\ClothingController;
use App\Http\Controllers\Web\Backend\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware(['auth'])->group(function () {

});

require __DIR__ . '/auth.php';
