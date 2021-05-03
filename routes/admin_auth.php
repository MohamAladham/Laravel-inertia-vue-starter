<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('admin.login');

Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');

Route::get('/admin/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest')
                ->name('admin.password.request');

Route::post('/admin/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('admin.password.email');

Route::get('/admin/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest')
                ->name('admin.password.reset');

Route::post('/admin/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('admin.password.update');

Route::get('/admin/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware('auth')
                ->name('admin.verification.notice');

Route::get('/admin/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('admin.verification.verify');

Route::post('/admin/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('admin.verification.send');

Route::get('/admin/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware('auth')
                ->name('admin.password.confirm');

Route::post('/admin/confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware('auth');

Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('admin.logout');
