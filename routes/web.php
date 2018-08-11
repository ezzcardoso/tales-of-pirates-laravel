<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/downloads','HomeController@downloads')->name('downloads');
Route::get('/ranking','HomeController@ranking')->name('ranking');


Route::get("/mall", "MallController@index")->name("mall.index");
Route::post("/mall/buy", "MallController@buy")->name("buy.index");
Route::get("/mall/create", "MallController@create")->name("mall.create");
Route::post("/mall", "MallController@store")->name("mall.store");
Route::get("/mall/{mall}", "MallController@show")->name("mall.show");
Route::get("/mall/{mall}/edit", "MallController@edit")->name("mall.edit");
Route::put("/mall/{mall}", "MallController@update")->name("mall.update");
Route::delete("/mall/{mall}", "MallController@destroy")->name("mall.destroy");


Route::get("/storage", "StorageController@index")->name("storage.index");
Route::get("/storage/create", "StorageController@create")->name("storage.create");
Route::post("/storage", "StorageController@store")->name("storage.store");
Route::get("/storage/{storage}", "StorageController@show")->name("storage.show");
Route::get("/storage/{storage}/edit", "StorageController@edit")->name("storage.edit");
Route::put("/storage/{storage}", "StorageController@update")->name("storage.update");
Route::delete("/storage/{storage}", "StorageController@destroy")->name("storage.destroy");


Route::group(["middleware" => ["Gm"], "namespace" => "Administrator", "prefix" => "/administrator"], function () {

    Route::get("/", "AdministratorController@index")->name("admin.index");
    Route::get("/admin", "AdministratorController@index")->name("admin.index");
    Route::get("/admin/create", "AdministratorController@create")->name("admin.create");
    Route::post("/admin", "AdministratorController@store")->name("admin.store");
    Route::get("/admin/{admin}", "AdministratorController@show")->name("admin.show");
    Route::get("/admin/{admin}/edit", "AdministratorController@edit")->name("admin.edit");
    Route::put("/admin/{admin}", "AdministratorController@update")->name("admin.update");
    Route::delete("/admin/{admin}", "AdministratorController@destroy")->name("admin.destroy");

    Route::get("/mall", "MallController@index")->name("mall.index");
    Route::get("/mall/create", "MallController@create")->name("mall.create");
    Route::post("/mall", "MallController@store")->name("mall.store");
    Route::get("/mall/{mall}", "MallController@show")->name("mall.show");
    Route::get("/mall/{mall}/edit", "MallController@edit")->name("mall.edit");
    Route::put("/mall/{mall}", "MallController@update")->name("mall.update");
    Route::delete("/mall/{mall}", "MallController@destroy")->name("mall.destroy");

});