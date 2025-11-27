<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\User\CategoryController as UserCategoryController;

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
        
    // les routes de categorie 
    Route::get("dashboard/categories/index/",[AdminCategoryController::class, 'index'])->name("admin-category-index");  
    Route::get("dashboard/categories/create/",[AdminCategoryController::class, 'create'])->name("admin-category-create");  
    Route::post("dashboard/categories/store/",[AdminCategoryController::class, 'store'])->name("admin-category-store");  
 });

    // les routes por utilisateurs simples 
    Route::middleware(["role:user"])->group(function(){
        Route::get("user/",function(){
            return view("user.index");
        });

        Route::get("user/categories/index/",[UserCategoryController::class,"index"])->name("user-category-index");
    });

    // les routes pour les deux 
    Route::middleware(["role:admin,user"])->group(function(){
        Route::get('/', function () {
            return view('welcome');
        });
    });
});