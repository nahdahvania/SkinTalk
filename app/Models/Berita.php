<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Berita extends Model
{
    protected $table = 'article_news'; 

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
