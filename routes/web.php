<?php

use App\Http\Controllers\Web\Backend\Chat\ChatController;
use Illuminate\Support\Facades\Artisan;
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




//live command run
Route::get('/run-migrate', function () {
    Artisan::call('migrate');
    return 'Database migration completed successfully!';
});

Route::get('/run-fresh-migrate-seed', function () {
    try {
        Artisan::call('migrate:fresh --seed');
        return 'Database refreshed and seeded successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/optimize-clear', function () {
    try {
        Artisan::call('optimize:clear');
        return 'Application cache cleared successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});


Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware(['auth'])->group(function () {

});

Route::get('/send-message', [ChatController::class, 'sendMessage'])->name('send-message');
Route::get('/chat', [ChatController::class, 'showChatForm'])->name('chat.form');

require __DIR__ . '/auth.php';
