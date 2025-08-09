<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'is_active',
        'last_message_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the user that owns the chat.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the messages for the chat.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest message for the chat.
     */
    public function latestMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'id', 'chat_id')
            ->latest('created_at');
    }

    /**
     * Generate a title from the first user message.
     */
    public function generateTitle(): string
    {
        $firstMessage = $this->messages()
            ->where('role', 'user')
            ->first();

        if (!$firstMessage) {
            return 'New Chat';
        }

        $content = strip_tags($firstMessage->content);
        $words = explode(' ', $content);

        if (count($words) <= 6) {
            return $content;
        }

        return implode(' ', array_slice($words, 0, 6)) . '...';
    }

    /**
     * Update the last message timestamp.
     */
    public function touchLastMessage(): void
    {
        $this->update(['last_message_at' => now()]);
    }
}
