<?php


namespace Acadea\Snapshot\Models;

use Illuminate\Database\Eloquent\Model;

class Snapshot extends Model
{
    protected $guarded = [ 'id' ];

    public function getTable()
    {
        return config('snapshotable.table_names.snapshot', parent::getTable());
    }
}
