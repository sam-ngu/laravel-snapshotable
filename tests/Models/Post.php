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


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
