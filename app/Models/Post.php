<?php

namespace App\Models;

use App\ValueObjects\PostStatus;
use Dom\Attr;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
         'title',
         'slug',
         'image_path',
         'excerpt',
         'content',
         'status',
         'published_at',
         'user_id',
         'category_id'
        ];

        protected $casts = [
            'published_at' => 'datetime',
        ];

        protected function status(): Attribute
        {
            return new Attribute(
                get: fn ($value) => PostStatus::from($value?? PostStatus::DRAFT),
                set: fn (PostStatus $status) => $status->value()
            );
        }

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
                get: fn () => $this->image_path
                    ? Storage::url($this->image_path)
                    : asset('images/default/post-default.jpg')
            );
        }
}
