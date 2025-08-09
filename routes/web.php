<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;

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

// LTUC AI Chatbot
Route::get('/ltuc/chatbot', [ChatbotController::class, 'index'])->name('ltuc.chatbot');
Route::post('/api/chat', [ChatbotController::class, 'chat'])->middleware('throttle:20,1')->name('api.chat');
Route::post('/api/chat/clear-history', [ChatbotController::class, 'clearHistory'])->name('api.chat.clear-history');
Route::get('/api/chat/history', [ChatbotController::class, 'getHistory'])->name('api.chat.history');

require __DIR__ . '/auth.php';
