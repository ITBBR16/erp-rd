<?php

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
    return view('index');
});
Route::get('/gudang', function () {
    return view('gudang.main.index');
});
Route::get('gudang/sender', function () {
    return view('gudang.sender.main');
});
Route::get('gudang/belanja', function () {
    return view('gudang.shop.belanja');
});
Route::get('gudang/req-payment', function () {
    return view('gudang.shop.payment');
});
Route::get('gudang/input-resi', function () {
    return view('gudang.shop.resi');
});
Route::get('/battery', function () {
    return view('battery.main.index');
});
Route::get('/kios', function () {
    return view('kios.main.index');
});
Route::get('/content', function () {
    return view('content.main.index');
});
Route::get('/repair', function () {
    return view('repair.main.index');
});
Route::get('/logistik', function () {
    return view('logistik.main.index');
});