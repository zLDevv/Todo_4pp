<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ToolController;

/*
|--------------------------------------------------------------------------
| ROOT (AUTO REDIRECT)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| AUTH (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [TaskController::class, 'dashboard'])->middleware('auth');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    // TASKS
    Route::resource('tasks', TaskController::class);

    Route::post('/tasks/{id}/done', [TaskController::class, 'done']);
    Route::post('/tasks/{id}/undone', [TaskController::class, 'undone']);
    Route::post('/tasks/{id}/favorite', [TaskController::class, 'favorite']);

    Route::get('/team-tasks', [TaskController::class, 'teamIndex']);
    Route::get('/create-team-task', [TaskController::class, 'createTeamTask']);
    Route::get('/inbox', [TaskController::class, 'inbox']);

    // TEAMS
    Route::resource('teams', TeamController::class);
    Route::post('/teams/{team}/invite-member', [TeamController::class, 'inviteMember']);
    Route::delete('/teams/{team}/members/{user}', [TeamController::class, 'removeMember']);

    // TOOLS
    Route::get('/calculator', [ToolController::class, 'calculator']);
});

/*
|--------------------------------------------------------------------------
| TEAM INVITATION (BOLEH TANPA LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/team-invitations/{token}/accept', [TeamController::class, 'acceptInvitation'])
    ->name('team-invitations.accept');

Route::get('/team-invitations/{token}/decline', [TeamController::class, 'declineInvitation'])
    ->name('team-invitations.decline');