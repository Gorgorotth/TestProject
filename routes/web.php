<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FileController;


Route::get('/', [LoginController::class, 'index'])->name('login');

Route::post('login', [LoginController::class, 'store'])->name('submit.login');

Route::get('logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('file', [FileController::class, 'index'])->middleware('auth');

Route::get('file/create', [FileController::class, 'create'])->middleware('auth')->name('file.create');

Route::post('file/store', [FileController::class, 'store'])->middleware('auth')->name('file.add');

Route::get('file/edit/{id}', [FileController::class, 'edit'])->middleware('auth')->name('file.edit');

//Route::post('file/update/{id}', [FileController::class, 'update'])->middleware('auth')->name('file.update');

Route::post('zip/setPassword/{id}', [FileController::class, 'storePassword'])->middleware('auth')->name('zip.setPassword');

Route::post('zip/download/{id}', [FileController::class, 'download'])->middleware('auth')->name('zip.download');

