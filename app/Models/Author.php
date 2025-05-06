<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'occupation',
        'avatar',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($author) {
            $author->slug = Str::slug($author->name);
        });

        static::updating(function ($author) {
            if ($author->isDirty('name')) {
                $author->slug = Str::slug($author->name);
            }
        });
    }
    
    public function news(): HasMany
    {
        return $this->hasMany(ArticleNews::class);
    }
}
