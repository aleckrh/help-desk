<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\TicketNumberController;
use App\Models\User;
use App\Models\Ticket;

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

Route::middleware(['guest', 'set_locale'])
    ->group(function () {
        // Login
        Route::view('/auth/login', 'auth.login')->name('auth.login');

        // Forgot password
        Route::view('/auth/forgot-password', 'auth.forgot-password')->name('password.request');

        // Recover password
        Route::get('/auth/recover-password/{token}', fn(string $token) => view('auth.recover-password', compact('token')))->name('password.reset');

        // Account activation
        Route::get('/auth/activate-account/{user:register_token}', fn (User $user) => view('auth.activate-account', compact('user')))->name('auth.activate-account');
    });
Route::middleware(['auth', 'set_locale'])
    ->group(function () {
        // Logout
        Route::get('/auth/logout', LogoutController::class)->name('auth.logout');

        // Home
        Route::view('/', 'welcome')->name('home');

        // My profile
        Route::view('/my-profile', 'my-profile')->name('my-profile');
        // Analytics
        Route::view('/analytics', 'analytics')->name('analytics');

        // Tickets
        Route::view('/tickets', 'tickets')->name('tickets');
        Route::get('/tickets/{ticket:id}/{slug}', fn (Ticket $ticket) => view('ticket-details', compact('ticket')))->name('tickets.details')->middleware('can_access_ticket');
        Route::get('/tickets/{number}', TicketNumberController::class)->name('tickets.number');

        // Administration
        Route::view('/administration', 'administration')->name('administration');
        Route::view('/administration/users', 'administration.users')->name('administration.users');
        Route::view('/administration/ticket-statuses', 'administration.ticket-statuses')->name('administration.ticket-statuses');
        Route::view('/administration/ticket-priorities', 'administration.ticket-priorities')->name('administration.ticket-priorities');
        Route::view('/administration/ticket-types', 'administration.ticket-types')->name('administration.ticket-types');

        // Notifications
        Route::view('/notifications', 'notifications')->name('notifications');

        // Kanban board
        Route::view('/kanban', 'kanban')->name('kanban');
    });
