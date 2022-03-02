<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CRMInquiryController;
use App\Http\Controllers\UsersAdminController;
use App\Http\Controllers\UsersController;


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
Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');




	/// START CRM
	Route::get('/inquiry-question', [CRMInquiryController::class, "question"])->name('question');
	Route::post('/inquiry-question-save', [CRMInquiryController::class, "saveQuestion"])->name('inquiry.question.save');
	Route::post('/inquiry-question-ajax', [CRMInquiryController::class, "ajax"])->name('inquiry.question.ajax');
	Route::get('/inquiry-question-detail', [CRMInquiryController::class, "detail"])->name('inquiry.question.detail');
	Route::get('/inquiry-question-delete', [CRMInquiryController::class, "delete"])->name('inquiry.question.delete');
        
        Route::get('/inquiry', [CRMInquiryController::class, "index"])->name('inquiry'); 
	Route::post('/inquiry-save', [CRMInquiryController::class, "saveInquiry"])->name('inquiry.save');
        Route::post('/inquiry-ajax', [CRMInquiryController::class, "inquiryAjax"])->name('inquiry.ajax');
        Route::get('/inquiry-detail', [CRMInquiryController::class, "inquiryDetail"])->name('inquiry.detail');  
        Route::get('/users-search', [CRMInquiryController::class, "searchUser"])->name('users.search');
        Route::get('/inquiry-questions', [CRMInquiryController::class, "inquiryQuestions"])->name('inquiry.questions');
        Route::post('/inquiry-answer-save', [CRMInquiryController::class, "saveInquiryAnswer"])->name('inquiry.answer.save');
	/// END CRM
	// Users - Admin

	Route::get('/users-admin', [UsersAdminController::class, "index"])->name('users.admin');
	Route::post('/users-admin-ajax', [UsersAdminController::class, "ajax"])->name('users.admin.ajax');
        
        Route::get('/users-search-state', [UsersController::class, "searchState"])->name('users.search.state');
	Route::get('/users-search-city', [UsersController::class, "searchCity"])->name('users.search.city');
	Route::get('/users-search-company', [UsersController::class, "searchCompany"])->name('users.search.company');
	Route::get('/users-search-saleperson-type', [UsersController::class, "searchSalePersonType"])->name('users.search.saleperson.type');
	Route::get('/users-state-cities', [UsersController::class, "stateCities"])->name('users.state.cities');
	Route::get('/users-reporting-manager', [UsersController::class, "reportingManager"])->name('users.reporting.manager');
	Route::get('/users-search-state-cities', [UsersController::class, "searchStateCities"])->name('users.search.state.cities');


