<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestsController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\PersonsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RessortCategoriesController;
use App\Http\Controllers\RessortsController;
use App\Http\Controllers\RessortWorkShiftsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Forgot password
Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('forgot.password');
Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('forgot.password.store');

// Password Reset
Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
Route::post('password-reset', [ResetPasswordController::class, 'store'])->name('password.reset.store');


// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');


//RessortCategories

Route::get('ressort-categories', [RessortCategoriesController::class, 'index'])
    ->name('ressort-categories')
    ->middleware('auth');

Route::get('ressort-categories/create', [RessortCategoriesController::class, 'create'])
    ->name('ressort-categories.create')
    ->middleware('auth');

Route::post('ressort-categories', [RessortCategoriesController::class, 'store'])
    ->name('ressort-categories.store')
    ->middleware('auth');

Route::get('ressort-categories/{ressortCategory}/edit', [RessortCategoriesController::class, 'edit'])
    ->name('ressort-categories.edit')
    ->middleware('auth');

Route::put('ressort-categories/{ressortCategory}', [RessortCategoriesController::class, 'update'])
    ->name('ressort-categories.update')
    ->middleware('auth');

Route::delete('ressort-categories/{ressortCategory}', [RessortCategoriesController::class, 'destroy'])
    ->name('ressort-categories.destroy')
    ->middleware('auth');

Route::put('ressort-categories/{ressortCategory}/restore', [RessortCategoriesController::class, 'restore'])
    ->name('ressort-categories.restore')
    ->middleware('auth');


//Ressorts

Route::get('ressorts', [RessortsController::class, 'index'])
    ->name('ressorts')
    ->middleware('auth');

Route::get('ressorts/create', [RessortsController::class, 'create'])
    ->name('ressorts.create')
    ->middleware('auth');

Route::post('ressorts', [RessortsController::class, 'store'])
    ->name('ressorts.store')
    ->middleware('auth');

Route::get('ressorts/{ressort}/edit', [RessortsController::class, 'edit'])
    ->name('ressorts.edit')
    ->middleware('auth');

Route::put('ressorts/{ressort}', [RessortsController::class, 'update'])
    ->name('ressorts.update')
    ->middleware('auth');

Route::delete('ressorts/{ressort}', [RessortsController::class, 'destroy'])
    ->name('ressorts.destroy')
    ->middleware('auth');

Route::put('ressorts/{ressort}/restore', [RessortsController::class, 'restore'])
    ->name('ressorts.restore')
    ->middleware('auth');

Route::get('ressorts/{ressort}/pdf/{day}', [RessortsController::class, 'pdfRessortWorkShifts'])
    ->name('persons.pdfRessortWorkShifts')
    ->middleware('auth');




// Ressort Work Shift

Route::get('ressorts/{ressort}/work-shifts', [RessortWorkShiftsController::class, 'index'])
    ->name('ressort-work-shifts')
    ->middleware('auth');

Route::get('ressorts/{ressort}/work-shifts/create', [RessortWorkShiftsController::class, 'create'])
    ->name('ressort-work-shifts.create')
    ->middleware('auth');

Route::post('ressorts/{ressort}/work-shifts', [RessortWorkShiftsController::class, 'store'])
    ->name('ressort-work-shifts.store')
    ->middleware('auth');

Route::get('ressorts/{ressort}/work-shifts/{ressortWorkShift}/edit', [RessortWorkShiftsController::class, 'edit'])
    ->name('ressort-work-shifts.edit')
    ->middleware('auth');

Route::put('ressorts/{ressort}/work-shifts/{ressortWorkShift}', [RessortWorkShiftsController::class, 'update'])
    ->name('ressort-work-shifts.update')
    ->middleware('auth');

Route::delete('ressorts/{ressort}/work-shifts/{ressortWorkShift}', [RessortWorkShiftsController::class, 'destroy'])
    ->name('ressort-work-shifts.destroy')
    ->middleware('auth');

Route::put('ressorts/{ressort}/work-shifts/{ressortWorkShift}/restore', [RessortWorkShiftsController::class, 'restore'])
    ->name('ressort-work-shifts.restore')
    ->middleware('auth');

Route::get('ressorts/{ressort}/work-shifts/{ressortWorkShift}/persons', [RessortWorkShiftsController::class, 'getPersons'])
    ->name('ressort-work-shifts.getPersons')
    ->middleware('auth');

Route::post('ressorts/{ressort}/work-shifts/{ressortWorkShift}/persons/add', [RessortWorkShiftsController::class, 'addPerson'])
    ->name('ressort-work-shifts.addPerson')
    ->middleware('auth');

Route::post('ressorts/{ressort}/work-shifts/{ressortWorkShift}/persons/delete', [RessortWorkShiftsController::class, 'deletePerson'])
    ->name('ressort-work-shifts.deletePerson')
    ->middleware('auth');

// Persons

Route::get('persons', [PersonsController::class, 'index'])
    ->name('persons')
    ->middleware('auth');

Route::post('persons/search', [PersonsController::class, 'searchPersons'])
    ->name('persons.search')
    ->middleware('auth');

Route::get('persons/create', [PersonsController::class, 'create'])
    ->name('persons.create')
    ->middleware('auth');

Route::post('persons', [PersonsController::class, 'store'])
    ->name('persons.store')
    ->middleware('auth');

Route::get('persons/{person}/edit', [PersonsController::class, 'edit'])
    ->name('persons.edit')
    ->middleware('auth');

Route::put('persons/{person}', [PersonsController::class, 'update'])
    ->name('persons.update')
    ->middleware('auth');

Route::delete('persons/{person}', [PersonsController::class, 'destroy'])
    ->name('persons.destroy')
    ->middleware('auth');

Route::put('persons/{person}/restore', [PersonsController::class, 'restore'])
    ->name('persons.restore')
    ->middleware('auth');

Route::get('persons/{person}/pdf/workload', [PersonsController::class, 'pdfWorkload'])
    ->name('persons.pdfWorkload')
    ->middleware('auth');

Route::post('persons/pdf/filters', [PersonsController::class, 'pdfFilters'])
    ->name('persons.pdfFilters')
    ->middleware('auth');


// Organizations

Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('auth');

Route::get('organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
    ->middleware('auth');


// Guests

Route::get('guests', [GuestsController::class, 'index'])
    ->name('guests')
    ->middleware('auth');

Route::get('guests/create', [GuestsController::class, 'create'])
    ->name('guests.create')
    ->middleware('auth');

Route::post('guests', [GuestsController::class, 'store'])
    ->name('guests.store')
    ->middleware('auth');

Route::get('guests/{guest}/edit', [GuestsController::class, 'edit'])
    ->name('guests.edit')
    ->middleware('auth');

Route::put('guests/{guest}', [GuestsController::class, 'update'])
    ->name('guests.update')
    ->middleware('auth');

Route::delete('guests/{guest}', [GuestsController::class, 'destroy'])
    ->name('guests.destroy')
    ->middleware('auth');

Route::put('guests/{guest}/restore', [GuestsController::class, 'restore'])
    ->name('guests.restore')
    ->middleware('auth');


// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');


// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');


// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');


