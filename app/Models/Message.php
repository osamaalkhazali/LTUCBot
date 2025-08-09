<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'user_id',
        'role',
        'content',
        'html_content',
        'attachments',
        'metadata',
    ];

    protected $casts = [
        'attachments' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Get the chat that owns the message.
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Get the user that owns the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the message is from the user.
     */
    public function isFromUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if the message is from the assistant.
     */
    public function isFromAssistant(): bool
    {
        return $this->role === 'assistant';
    }

    /**
     * Get a short preview of the message content.
     */
    public function getPreview(int $length = 100): string
    {
        $content = strip_tags($this->content);

        if (strlen($content) <= $length) {
            return $content;
        }

        return substr($content, 0, $length) . '...';
    }
}
