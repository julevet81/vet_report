<?php

use App\Http\Controllers\AdminBranchController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminWilayaInspectorateController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonthlyReportController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/reports', [MonthlyReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [MonthlyReportController::class, 'show'])->name('reports.show');
    Route::get('/reports-create', [MonthlyReportController::class, 'create'])
        ->middleware('role:private_vet')
        ->name('reports.create');
    Route::post('/reports', [MonthlyReportController::class, 'store'])
        ->middleware('role:private_vet')
        ->name('reports.store');

    Route::middleware('role:branch_manager,wilaya_inspector,admin')->group(function (): void {
        Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
        Route::post('/approvals/{user}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('/approvals/{user}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function (): void {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');

        Route::resource('inspectorates', AdminWilayaInspectorateController::class)->except(['show']);
        Route::resource('branches', AdminBranchController::class)->except(['show']);
    });
});