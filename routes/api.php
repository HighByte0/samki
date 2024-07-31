<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TextController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
    
], function ($router) {
    // Authentication routes
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/verify/{token}/{email}', [AuthController::class, 'accountVerify']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/logout', [HomeController::class, 'logout']);

    // Nested application routes under /auth/application
    Route::prefix('application')->group(function () {
        Route::get('/', [ApplicationController::class, 'application']);
        Route::get('/daily', [ApplicationController::class, 'applicationDaily']);
        Route::get('/applicationUnreachable_rdv', [ApplicationController::class, 'applicationUnreachable']);
        Route::get('/appDetail', [ApplicationController::class, 'appDetail']);
        Route::post('/offDetail/{id}', [ApplicationController::class, 'offDetail']);
        Route::post('/decisionDetail/{id}', [ApplicationController::class, 'decisionDetail']);
        Route::post('/setStatus/{id}', [ApplicationController::class, 'setStatus']);
        Route::get('/calRdv', [ApplicationController::class,'calRdv']);
        Route::get('/history/{id}',[ApplicationController::class,'history']); 
       
    });
    Route::prefix('charts')->group( function (){
        Route::get('/', [ApplicationController::class, 'dailyApplications']);
        
});
Route::prefix('emailParam')->group( function (){
    Route::get('/', [TextController::class, 'mailing']);    
    Route::post('/update', [TextController::class, 'upMailing']);
    // Route::post('/mailIngoin/{id}',TextController::class,'mailIngoin');
    Route::post('/mailIngoin/{id}', [TextController::class, 'mailIngoin']);
    Route::post('/mailRdv/{id}', [TextController::class, 'mailConvo']);
    
});

    Route::post('/create', [HomeController::class, 'create']);
}); 
//Route::middleware('auth')->post('/create', [HomeController::class, 'create']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);




Route::group(['middleware' => 'api'], function ($router) {
    Route::resource('/categories', CategoryController::class);
    Route::resource('/applications', ApplicationController::class);
});

//without resource

//home
Route::get('/home',[HomeController::class,'index']);
Route::post('/create',[HomeController::class,'create']);

Route::get('/home/browse',[HomeController::class,'getALlJobs']);


Route::get('/home/{slug}',[HomeController::class,'getSingleJobDetails']);
