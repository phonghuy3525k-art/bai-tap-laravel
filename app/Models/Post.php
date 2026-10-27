<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    //Danh sách chuyên mục dùng chung cho menu, form, validate
    public const CATEGORIES = [
        'travel' => 'Du lịch',
        'study'  => 'Học tập',
        'sport'  => 'Thể thao',
        'life'   => 'Đời sống',
    ];

    protected $fillable = ['user_id', 'title', 'category', 'image', 'content', 'published_at'];

    protected $casts = ['published_at' => 'datetime'];

    //Bài vt thuộc về 1 user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Bài vt có nhiều bình luận
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}