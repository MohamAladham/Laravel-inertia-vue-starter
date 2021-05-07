<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::get( '/register', [ RegisteredUserController::class, 'create' ] )
    ->middleware( [ 'guest', 'guest:user', 'guest:admin' ] )
    ->name( 'register' );

Route::post( '/register', [ RegisteredUserController::class, 'store' ] )
    ->middleware( [ 'guest', 'guest:user', 'guest:admin' ] );

Route::get( '/login/{guard?}', [ AuthenticatedSessionController::class, 'create' ] )
    ->middleware( [ 'guest', 'guest:user', 'guest:admin' ] )
    ->name( 'login' );

Route::post( '/login/{guard?}', [ AuthenticatedSessionController::class, 'store' ] )
    ->middleware( [ 'guest', 'guest:user', 'guest:admin' ] );

Route::get( '/forgot-password/{guard?}', [ PasswordResetLinkController::class, 'create' ] )
    ->middleware( [ 'guest', 'guest:user', 'guest:admin' ] )
    ->name( 'password.request' );

Route::post( '/forgot-password/{guard?}', [ PasswordResetLinkController::class, 'store' ] )
    ->middleware( [ 'guest', 'guest:user', 'guest:admin' ] )
    ->name( 'password.email' );

Route::get( '/reset-password/{token}/{guard?}', [ NewPasswordController::class, 'create' ] )
    ->middleware( [ 'guest', 'guest:user', 'guest:admin' ] )
    ->name( 'password.reset' );

Route::post( '/reset-password/{guard?}', [ NewPasswordController::class, 'store' ] )
    ->middleware( [ 'guest', 'guest:user', 'guest:admin' ] )
    ->name( 'password.update' );

Route::get( '/verify-email', [ EmailVerificationPromptController::class, '__invoke' ] )
    ->middleware( 'auth:admin,user' )
    ->name( 'verification.notice' );

Route::get( '/verify-email/{id}/{hash}', [ VerifyEmailController::class, '__invoke' ] )
    ->middleware( [ 'auth:admin,user', 'signed', 'throttle:6,1' ] )
    ->name( 'verification.verify' );

Route::post( '/email/verification-notification', [ EmailVerificationNotificationController::class, 'store' ] )
    ->middleware( [ 'auth:admin,user', 'throttle:6,1' ] )
    ->name( 'verification.send' );

Route::get( '/confirm-password', [ ConfirmablePasswordController::class, 'show' ] )
    ->middleware( 'auth:admin,user' )
    ->name( 'password.confirm' );

Route::post( '/confirm-password', [ ConfirmablePasswordController::class, 'store' ] )
    ->middleware( 'auth:admin,user' );

Route::post( '/logout', [ AuthenticatedSessionController::class, 'destroy' ] )
    ->middleware( 'auth:admin,user' )
    ->name( 'logout' );
