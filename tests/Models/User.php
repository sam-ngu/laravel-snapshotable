<?php


namespace Acadea\Snapshot\Tests\Models;

use Acadea\Snapshot\Traits\Snapshotable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    use Snapshotable;


    protected $fillable = [
        'name',
    ];

    protected function toSnapshotRelations()
    {
        return [
            'posts' => function (Post $post) {
                return $post->only('title');
            },
            'posts.comments' => function (Comment $comment) {
                return $comment->title;
            },
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function profile()
    {
        return $this->hasOne();
    }
}
