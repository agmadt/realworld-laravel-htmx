<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'body'
    ];

    /**
     * Comment's article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Article, self>
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Comment's user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, self>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
