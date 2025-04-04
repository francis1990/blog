<?php

namespace App\Models;

use Dom\Attr;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
         'title',
         'slug',
         'image_path',
         'excerpt',
         'content',
         'is_published',
         'published_at',
         'user_id',
         'category_id'
        ];

        protected $casts = [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];

        public function category()
        {
            return $this->belongsTo(Category::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function comments()
        {
            return $this->hasMany(Comment::class);
        }

        public function tags()
        {
            return $this->belongsToMany(Tag::class);
        }

        protected function image(): Attribute
        {
            return new Attribute(
                get: fn () => $this->image_path ?? asset('images/default/post-default.jpg')
            );
        }
}
