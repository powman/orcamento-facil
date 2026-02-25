<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', \App\Http\Middleware\EnsureCompanyAccess::class])->group(function () {
    // Budget routes
    Route::get('/orcamentos', [BudgetController::class, 'index'])->name('budgets.index');
    Route::get('/orcamentos/criar', [BudgetController::class, 'create'])->name('budgets.create');
    Route::get('/orcamentos/{budget}/editar', [BudgetController::class, 'edit'])->name('budgets.edit');
    Route::get('/orcamentos/{budget}/imprimir', [BudgetController::class, 'print'])->name('budgets.print');

    // Client routes
    Route::get('/clientes', [ClientController::class, 'index'])->name('clients.index');

    // Company routes
    Route::get('/empresa/configuracoes', [CompanyController::class, 'settings'])->name('company.settings');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
