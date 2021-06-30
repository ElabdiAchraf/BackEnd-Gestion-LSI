<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('forgot', 'App\Http\Controllers\Auth\ForgotPasswordController@forgot');
Route::post('reset', 'App\Http\Controllers\Auth\ForgotPasswordController@reset');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'App\Http\Controllers\Auth\AuthController@login');

Route::post('register', 'App\Http\Controllers\Auth\AuthController@register');

Route::get('user', 'App\Http\Controllers\Auth\AuthController@user')->middleware('auth:api');

Route::post('/profile/update/{id}', 'App\Http\Controllers\ProfileController@update')->middleware('auth:api');

Route::group([
    'prefix' => 'user',
    'middleware' => ['auth:api', 'Etu']
], function () {
    Route::get('home', 'App\Http\Controllers\Etudiants\HomeController@index');
    Route::get('/emploi', 'App\Http\Controllers\Api\Etudiants\EmploiTempsController@index');
    Route::get('/get_modules', 'App\Http\Controllers\Api\Etudiants\HomeController@getModules');
    Route::get('/notes', 'App\Http\Controllers\Api\Etudiants\HomeController@getNotes');
});

//admin routes
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:api', 'owner']
], function () {
    Route::get('/home', 'App\Http\Controllers\Api\Admin\HomeController@index');
    Route::post('/create/user', 'App\Http\Controllers\Api\Admin\HomeController@createUser');
    Route::resource('/modules', 'App\Http\Controllers\Api\Admin\ModuleController');
    Route::resource('/salles', 'App\Http\Controllers\Api\Admin\SalleController');
    Route::resource('/classes', 'App\Http\Controllers\Api\Admin\ClasseController');
    Route::resource('/etudiants', 'App\Http\Controllers\Api\Admin\EtudiantController');
    Route::resource('/profs', 'App\Http\Controllers\Api\Admin\ProfController');
    Route::resource('/seances', 'App\Http\Controllers\Api\Admin\SeanceController');
    Route::resource('/pfes', 'App\Http\Controllers\Api\Admin\PFEController');
    Route::get('/reservation', 'App\Http\Controllers\Api\Admin\SeanceController@reservetion');
    Route::get('/newetudiants', 'App\Http\Controllers\Api\Admin\EtudiantController@NewRegistration');
});
// Route::post('password/email', 'App\Http\Controllers\ForgotPasswordController@SendsPasswordResetEmails');
// Route::post('password/reset', 'App\Http\Controllers\ResetPasswordController@ResetsPasswords');
// prof routes 
Route::group([
    'prefix' => 'prof',
    'middleware' => ['auth:api', 'ProfMidd']
], function () {
    Route::get('/home', 'App\Http\Controllers\Api\Admin\HomeController@index');
    Route::get('gestion_notes', 'App\Http\Controllers\Api\Professeur\NoteController@Modules');
    Route::get('enter_notes/etudiants/{id}', 'App\Http\Controllers\Api\Professeur\NoteController@classeET');
    Route::get('gestion_notes/etudiants/{id}', 'App\Http\Controllers\Api\Professeur\NoteController@notes');
    Route::post('gestion_notes/etudiant/{id}', 'App\Http\Controllers\Api\Professeur\NoteController@store');
    Route::post('gestion_notes/update/{id}', 'App\Http\Controllers\Api\Professeur\NoteController@update');
    Route::post('gestion_notes/delete/{id}', 'App\Http\Controllers\Api\Professeur\NoteController@destroy');
    // Route::get('/emploi', 'App\Http\Controllers\Api\Etudiants\EmploiTempsController@index');
    Route::post('/resrvation_seance', 'App\Http\Controllers\Api\Admin\SeanceController@store');
});
