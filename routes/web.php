<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\uploadCsvFileReportController;
use App\Http\Controllers\UserInfoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::controller(UserInfoController::class)->prefix('user-info')->name('user.meta.')->group(function () {
        Route::post('/upload', 'store')->name('upload');
        Route::get('/list', 'index')->name('list');
        Route::get('/list-datatable', 'listDatatable')->name('list.datatable');
        Route::get('/list-datatable', 'listDatatable')->name('list.datatable');
    });

    Route::controller(uploadCsvFileReportController::class)->prefix('uploaded-csv-file')->name('uploaded.csvfile.')->group(function () {
        Route::get('/report', 'csvFileReport')->name('report');
        Route::get('/report-datatable', 'csvFileReportDatatable')->name('report.datatable');
    });
});
