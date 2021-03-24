<?php


namespace Acadea\Snapshot\Tests\Models;

use Acadea\Snapshot\Traits\Snapshotable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, Snapshotable;


    protected $fillable = [
        'title',
    ];

    protected function toSnapshotRelations()
    {
        return [
            'user' => function(User $user){
                return $user->only('name');
            },
            'comments.tags' => function(Tag $tag){
                return $tag->title;
            },
            'user.comments.tags' => function(Tag $tag){
                return $tag->only('title');
            },
            'comments' => function(Comment $comment){
                return $comment->only('title');
            },
            'user.comments' => function(Comment $comment){
                return $comment->only('title');
            },

        ];
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
