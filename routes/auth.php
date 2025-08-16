<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BulletinsController;
use App\Http\Controllers\UsersController;

use Illuminate\Support\Facades\Route;


//tudo o que NÃO precisa de autênticação
Route::middleware('guest')->group(function () {
          
    //Rotas padrão para controle de logins
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);  
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

//tudo o que precisa de autênticação
Route::middleware('auth')->group(function (){
    
    //ROTAS DE BOLETINS
    //Rotas para páginas de buscas de boletins permitidas a usuários autenticados
    Route::match(['get', 'post'],'/', [BulletinsController::class, 'show_years'])->name('bulletins.show_years'); //Lista os anos que possuem boletins
    Route::get('/months/{selected_year}', [BulletinsController::class, 'show_months_year'])->name('bulletins.show_months_year'); //Lista os meses que possuem boletins conforme ano selecionado pelo usuário
    Route::get('/files/{selected_year}/{selected_month}', [BulletinsController::class, 'show_files_month'])->name('bulletins.show_files_month'); //Lista ARQUIVOS de boletins conforme ANO/MÊS selecionados pelo usuário
    Route::match(['get', 'post'],'results_of_search', [BulletinsController::class, 'results_of_search'])->name('bulletins.results_of_search');
    Route::get('/dashboard', [BulletinsController::class, 'dashboard'])->name('dashboard');

    // Rotas Protegidas por Middleware Somente para Administradores e Administradores de Boletins
    Route::middleware(['can:is_admin_or_admin_bol'])->group(function () { 
        //rotas personalizadas
        Route::resource('/bulletins', BulletinsController::class)->except(['show']);
        Route::delete('/bulletins', [BulletinsController::class, 'destroy_all'])->name('bulletins.selecteds'); 
        Route::match(['get', 'post'],'/bulletins/private_results_of_search', [BulletinsController::class, 'private_results_of_search'])->name('bulletins.private_results_of_search');   
    });

    //ROTAS DE USUÁRIOS
    // Rotas Protegidas por Middleware Somente para Administradores e Administradores de Usuários
    Route::middleware(['can:is_admin_or_admin_usu'])->group(function () {
        Route::resource('/users', UsersController::class)->except(['show']);
        Route::post('/user/{user}', [UsersController::class, 'activate'])->name('user.activate');
        Route::match(['get', 'post'],'/users/private_results_of_search', [UsersController::class, 'private_results_of_search'])->name('users.private_results_of_search');
    });

    //Rotas padrão controles de LOGINS
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
