<?php


namespace Acadea\Snapshot\Tests\Models;

use Acadea\Snapshot\Traits\Snapshotable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    use Snapshotable;


    protected $fillable = [
        'name',
    ];

    protected function toSnapshotRelations()
    {
        return [

        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
