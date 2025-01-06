<?php

use App\Http\Controllers\Web\Backend\Category\CategoryController;
use App\Http\Controllers\Web\Backend\Chat\ChatController;
use App\Http\Controllers\Web\Backend\Course\CourseController;
use App\Http\Controllers\Web\Backend\Pdf\PdfController;
use App\Http\Controllers\Web\Backend\Settings\CustomScriptController;
use App\Http\Controllers\Web\Backend\Settings\DynamicPageController;
use App\Http\Controllers\Web\Backend\Settings\MailSettingController;
use App\Http\Controllers\Web\Backend\Settings\ProfileController;
use App\Http\Controllers\Web\Backend\Settings\StripeSettingController;
use App\Http\Controllers\Web\Backend\Settings\SystemSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Backend\Dashboard\DashboardController;





Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    ////Routes for Settings

    //Route for SystemSettingController
    Route::get('/system-setting', [SystemSettingController::class, 'index'])->name('settings.system.index');
    Route::post('/system-setting/', [SystemSettingController::class, 'update'])->name('settings.system.update');

    //Route for ProfileController
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('settings.profile');
    Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('settings.update-profile');
    Route::post('/update-profile-password', [ProfileController::class, 'updatePassword'])->name('settings.update-password');

    //Route for MailSettingController
    Route::get('/mail-setting', [MailSettingController::class, 'index'])->name('settings.mail');
    Route::post('/mail-setting', [MailSettingController::class, 'update'])->name('settings.mail-update');

    //Route for DynamicPageController
    Route::get('/dynamic-page', [DynamicPageController::class, 'index'])->name('settings.dynamic-page.index');
    Route::get('/dynamic-page/create', [DynamicPageController::class, 'create'])->name('settings.dynamic-page.create');
    Route::post('/dynamic-page/store', [DynamicPageController::class, 'store'])->name('settings.dynamic-page.store');
    Route::get('/dynamic-page/edit/{id}', [DynamicPageController::class, 'edit'])->name('settings.dynamic-page.edit');
    Route::post('/dynamic-page/update/{id}', [DynamicPageController::class, 'update'])->name('settings.dynamic-page.update');
    Route::delete('/dynamic-page/delete/{id}', [DynamicPageController::class, 'destroy'])->name('settings.dynamic-page.destroy');
    Route::get('/dynamic-page/status/{id}', [DynamicPageController::class, 'status'])->name('settings.dynamic-page.status');

    //Route for StripeSettingController
    Route::get('/stripe-setting', [StripeSettingController::class, 'index'])->name('settings.stripe.index');
    Route::post('/stripe-setting', [StripeSettingController::class, 'update'])->name('settings.stripe.update');

    //Route for CustomScriptController
    Route::get('/custom-script', [CustomScriptController::class, 'index'])->name('settings.custom-script.index');
    Route::get('/custom-script/create', [CustomScriptController::class, 'create'])->name('settings.custom-script.create');
    Route::post('/custom-script/store', [CustomScriptController::class, 'store'])->name('settings.custom-script.store');
    Route::get('/custom-script/edit/{id}', [CustomScriptController::class, 'edit'])->name('settings.custom-script.edit');
    Route::post('/custom-script/update/{id}', [CustomScriptController::class, 'update'])->name('settings.custom-script.update');
    Route::get('/custom-script/status/{id}', [CustomScriptController::class, 'status'])->name('settings.custom-script.status');
    Route::delete('/custom-script/destroy/{id}', [CustomScriptController::class, 'destroy'])->name('settings.custom-script.destroy');


    //!! Route for Category Controller
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/show/{id}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/status/{id}', [CategoryController::class, 'status'])->name('category.status');
    Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');


    //!! Route for Course Controller
    Route::get('/course', [CourseController::class, 'index'])->name('course.index');
    Route::get('/course/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('/course/store', [CourseController::class, 'store'])->name('course.store');
    Route::get('/course/show/{id}', [CourseController::class, 'show'])->name('course.show');
    Route::get('/course/edit/{id}', [CourseController::class, 'edit'])->name('course.edit');
    Route::put('/course/update/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::get('/course/status/{id}', [CourseController::class, 'status'])->name('course.status');
    Route::delete('/course/destroy/{id}', [CourseController::class, 'destroy'])->name('course.destroy');

    //!! Route for Chat Controller
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send-message.sendMessage');
    Route::get('/get-messages/{conversation_id}', [ChatController::class, 'getMessages'])->name('get-messages.getMessages');

    //!! Route for Pdf Controller
    Route::get('/pdf', [PdfController::class, 'index'])->name('pdf.index');
    Route::get('/pdf/create', [PdfController::class, 'create'])->name('pdf.create');
    Route::post('/pdf/store', [PdfController::class, 'store'])->name('pdf.store');
    Route::get('/pdf/show/{id}', [PdfController::class, 'show'])->name('pdf.show');
    Route::get('/pdf/edit/{id}', [PdfController::class, 'edit'])->name('pdf.edit');
    Route::put('/pdf/update/{id}', [PdfController::class, 'update'])->name('pdf.update');
    Route::get('/pdf/status/{id}', [PdfController::class, 'status'])->name('pdf.status');
    Route::delete('/pdf/destroy/{id}', [PdfController::class, 'destroy'])->name('pdf.destroy');


    Route::get('/test', function () {
        return view('backend.layouts.chat.sendMessage');
    });


});
