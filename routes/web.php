<?php

use Illuminate\Support\Facades\Route;
Auth::routes();

 
Route::resource('/categorias', 'CategoriaController')->middleware('auth');  
Route::resource('/comentarios', 'ComentarioController')->middleware('auth');  

Route::get('/{any}', function(){
    return view('spa');
})->where('any','.*')->middleware('auth'); 

 