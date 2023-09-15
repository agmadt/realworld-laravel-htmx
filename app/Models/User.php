<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Determine if user is following an user.
     */
    public function following(User $user): bool
    {
        return $this->followings()
            ->whereKey($user->getKey())
            ->exists();
    }

    /**
     * Determine if user followed by a user.
     *
     * @param \App\Models\User $follower
     * @return bool
     */
    public function followedBy(User $follower): bool
    {
        return $this->followers()
            ->whereKey($follower->getKey())
            ->exists();
    }

    /**
     * The followings of the user.
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follower', 'follower_id', 'user_id');
    }

    /**
     * The followers of the user.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follower', 'user_id', 'follower_id');
    }

    /**
     * Get the comments of the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    /**
     * Get user written articles.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    /**
     * Get user favorite articles.
     */
    public function favorites()
    {
        return $this->belongsToMany(Article::class, 'article_favorite');
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function getIsSelfAttribute()
    {
        $loggedInUser = auth()->user();

        if (!$loggedInUser) {
            return false;
        }

        if ($loggedInUser->id != $this->id) {
            return false;
        }

        return true;
    }

    public function toggleFollowUser(User $user)
    {
        $isFollowing = false;

        if ($this->following($user)) {
            $this->followings()->detach($user);
        } else {
            $this->followings()->syncWithoutDetaching($user);
            $isFollowing = true;
        }

        return $isFollowing;
    }
}
