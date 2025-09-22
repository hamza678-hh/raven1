<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Themecontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CommentController;

//THEME ROUTE

Route::controller(Themecontroller::class)->name('theme.')->group(function(){
        Route::get('/i','index')->name('index');
        Route::get('/category/{id}','category')->name('category');
        Route::get('/contact','contact')->name('contact');
        // Route::get('/single-blog','singleblog')->name('singleblog');
       
       
});

//SUBScriber ROUTER STORE
Route::post('/subscriber/store', [SubscriberController::class,'store'])->name('subscriber.store');


//CONTACT ROUTER STORE
Route::post('/contact/store', [ContactController::class,'store'])->name('contact.store');

//Blog Controller
Route::get('/myblogs',[BlogController::class,'myblog'])->name('blogs.My-blogs');
Route::resource('blogs',BlogController::class);

// Comment Controller
Route::post('/comments/store',[CommentController::class,'store'])->name('comments.store');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
