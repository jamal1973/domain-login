<?php

use Illuminate\Support\Facades\Route;
use Jamal1973\DomainLogin\Http\Controllers\DomainLoginController;

$middleware = config('domain-login.middleware', ['web']);
$loginPath = trim((string) config('domain-login.login_path', 'login'), '/');
$logoutPath = trim((string) config('domain-login.logout_path', 'logout'), '/');

$loginUri = $loginPath === '' ? '/' : '/' . $loginPath;
$logoutUri = $logoutPath === '' ? '/logout' : '/' . $logoutPath;

Route::middleware($middleware)->group(function () use ($loginUri, $logoutUri) {
    Route::get($loginUri, [DomainLoginController::class, 'showLoginForm'])->name('login');
    Route::post($loginUri, [DomainLoginController::class, 'login'])->name('login.post');
    Route::post($logoutUri, [DomainLoginController::class, 'logout'])->name('logout');
});
