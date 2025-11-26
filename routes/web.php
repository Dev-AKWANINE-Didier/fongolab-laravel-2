<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// les routes pour les utilisateurs connectés
Route::middleware("auth")->group(function(){
    // les routes pour les admins
    Route::middleware(["role:admin"])->group(function(){
        Route::get("dashboard",function(){
            return view("admin.index");
        })->name("dashboard");
        
    });

    // les routes por utilisateurs simples 
    Route::middleware(["role:user"])->group(function(){
        Route::get("user/",function(){
            return view("user.index");
        });
    });

    // les routes pour les deux 
    Route::middleware(["role:admin,user"])->group(function(){
        Route::get('/', function () {
            return view('welcome');
        });
    });
});