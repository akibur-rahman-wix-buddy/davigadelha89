<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\PdfController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\SocialAuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\SearchController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ROUTE FOR USER ACCOUNT LOGIN AND REGISTER
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/verify/registration', [AuthController::class, 'verifyRegistrationOtp']);
Route::post('/resend/registration/otp', [AuthController::class, 'resendRegistrationOtp']);

Route::post('/forgot-password', [AuthController::class, 'sendResetOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyResetOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


// ROUTE FOR SOCIAL LOGIN
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);




//Route for Category controller
Route::get('/category', [CategoryController::class, 'index']);

Route::get('/courses', [CourseController::class, 'index']);


Route::group(['middleware' => 'jwt.auth'], function() {

    // ROUTE FOR USER PROFILE UPDATE
    Route::get('/profile/show', [AuthController::class, 'show']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);


//    Route::get('/search', [SearchController::class, 'search']);

    //Wishlist Route
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggleWishlist']);
    Route::get('/wishlist/view', [WishlistController::class, 'viewWishlist']);
    Route::post('/wishlist/clear', [WishlistController::class, 'clearAllCloset']);


    //Pdf Route
    Route::get('pdfs', [PdfController::class, 'index']);
    Route::get('pdfs/{id}', [PdfController::class, 'show']);


    //! Route for Chat Controller added by masum
    Route::post('/send-message', [ChatController::class, 'sendMessage']);
    Route::get('/get-messages/{conversation_id}', [ChatController::class, 'getMessages']);


});

//Route for search
Route::get('/search', [SearchController::class, 'search']);

