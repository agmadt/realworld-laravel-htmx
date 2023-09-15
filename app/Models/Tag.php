<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name'
    ];

    /**
     * Tagged articles.
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public static function favoriteTags($count = 5)
    {
        $tags = self::select('id', 'name', DB::raw('COUNT(tag_id) as favorite_count'))
            ->join('article_tag', 'tags.id', '=', 'article_tag.tag_id')
            ->groupBy('tags.id')
            ->orderBy('favorite_count', 'DESC')
            ->limit($count)
            ->get();

        return $tags;
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
}
