<?php


namespace Acadea\Snapshot\Models;


use Illuminate\Database\Eloquent\Model;

class Snapshot extends Model
{

    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    protected $casts = [
        'payload' => 'array'
    ];

    public function getTable()
    {
        return config('snapshotable.table_names.snapshot', parent::getTable());
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function snapshotable()
    {
        return $this->morphTo('snapshotable');
    }





}