<?php


namespace Acadea\Snapshot\Tests\Models;

use Acadea\Snapshot\Traits\Snapshotable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, Snapshotable;

    protected $fillable = [
        'title',
        'post_id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'comment_tag', 'comment_id', 'tag_id');
    }


}
