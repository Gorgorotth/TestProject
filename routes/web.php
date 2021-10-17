<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FileController;


Route::get('/', [LoginController::class, 'index'])->name('login');

Route::post('login', [LoginController::class, 'store'])->name('submit.login');

Route::get('logout', [LoginController::class, 'destroy'])->name('logout');

Route::group(['middleware' => ['auth']], function () {

    Route::get('file', [FileController::class, 'index']);

    Route::get('file/create', [FileController::class, 'create'])->name('file.create');

    Route::post('file/store', [FileController::class, 'store'])->name('file.add');

    Route::get('zip/edit/{id}', [FileController::class, 'edit'])->name('zip.edit');

    Route::get('file/edit/{id}', [FileController::class, 'edit_file'])->name('file.edit');

    Route::get('file/delete/{id}', [FileController::class, 'delete'])->name('file.delete');

    Route::post('file/update/{id}', [FileController::class, 'update'])->name('file.update');

    Route::post('zip/setPassword/{id}', [FileController::class, 'store_password'])->name('zip.setPassword');

    Route::post('zip/download/{id}', [FileController::class, 'download'])->name('zip.download');

});
