<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';
    protected $fillable = [
        'title', 'slug', 'article_body', 'article_banner', 'excerpt'
    ];

    /**
     * Get the author that owns the articles.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }


}
