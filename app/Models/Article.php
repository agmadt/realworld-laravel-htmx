<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'body'
    ];

    /**
     * Check if user favored the article.
     */
    public function favoritedByUser(User $user): bool
    {
        return $this->favoritedUsers()
            ->whereKey($user->getKey())
            ->exists();
    }

    /**
     * Scope articles to favored by a user.
     */
    public function scopeFavoritedByUser(Builder $query, string $username): Builder
    {
        return $query->whereHas('favoritedUsers', function (Builder $builder) use ($username) {
            $builder->where('username', $username);
        });
    }

    /**
     * Scope articles to favored by a user.
     */
    public function scopeOfAuthorsFollowedByUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('user', function (Builder $builder) use ($user) {
            $builder->whereIn('id', $user->followings->pluck('id'));
        });
    }

    /**
     * Attach tags to article.
     */
    public function attachTags(array $tags): void
    {
        $tagIDs = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate([
                'name' => $tagName,
            ]);

            $tagIDs[] = $tag->id;
        }

        $this->tags()->sync($tagIDs);
    }

    /**
     * Article user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Article tags.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get comments for article.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get users that favorited the article.
     */
    public function favoritedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'article_favorite');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function toggleUserFavorite(User $user): bool
    {
        $isFavorited = false;

        if ($this->favoritedByUser($user)) {
            $user->favorites()->detach($this);
        } else {
            $user->favorites()->syncWithoutDetaching($this);
            $isFavorited = true;
        }

        return $isFavorited;
    }
}
