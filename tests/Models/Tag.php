<?php


namespace Acadea\Snapshot\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'comment_tag', 'tag_id', 'comment_id');
    }
}
