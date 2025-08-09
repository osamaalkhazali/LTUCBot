<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChatbotDemoController;
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

    // Protected LTUC AI Chatbot (Full Version - Authenticated Users Only)
    Route::get('/ltuc/chatbot', [ChatbotController::class, 'index'])->name('ltuc.chatbot');
    Route::post('/api/chat', [ChatbotController::class, 'chat'])->middleware('throttle:20,1')->name('api.chat');
    Route::post('/api/chat/clear-history', [ChatbotController::class, 'clearHistory'])->name('api.chat.clear-history');
    Route::get('/api/chat/history', [ChatbotController::class, 'getHistory'])->name('api.chat.history');

    // New Chat Management Routes
    Route::get('/api/chats', [ChatbotController::class, 'getChatsHistory'])->name('api.chats.list');
    Route::get('/api/chats/{chatId}/messages', [ChatbotController::class, 'getChatMessages'])->name('api.chats.messages');
    Route::post('/api/chats/new', [ChatbotController::class, 'createNewChat'])->name('api.chats.create');
    Route::delete('/api/chats/{chatId}', [ChatbotController::class, 'deleteChat'])->name('api.chats.delete');
});

// Public LTUC AI Chatbot (Demo Version - No Authentication Required)
Route::get('/ltuc/chatbot-demo', [ChatbotDemoController::class, 'index'])->name('ltuc.chatbot.demo');
Route::post('/api/chat-demo', [ChatbotDemoController::class, 'chat'])->middleware('throttle:10,1')->name('api.chat.demo');

// Documentation Route
Route::get('/documentation', function () {
    return view('documentation');
})->name('documentation');

require __DIR__ . '/auth.php';
