<?php


namespace Acadea\Snapshot\Traits;


use Acadea\Snapshot\Models\Snapshot;
use Illuminate\Support\Arr;

trait Snapshotable
{
    /*
     * An array of relation, key
     * Supports the 'dot' notation to define the relationships
     *
     * Key -- dot notation relationship
     * Value -- function to tell Snapshotable how to store the relation in json
     *
     * Relationship must be defined in the model
     *
     * returns eg [
     *  'post' => function($model){
     *      return [
     *          'key' => 'post_name'
     *          'value' => $model->title
     *      ]
     *  }
     * ]
     * */
    protected function toSnapshotRelation()
    {
        return [];
    }


    /**
     * Take a snapshot of the model
     * @return Snapshot
     */
    public function takeSnapshot(): Snapshot
    {
        $attributes = $this->getAttributes();

        $excepted = Arr::except($attributes, ['id', 'created_at', 'updated_at']);

        /** @var $snapshot Snapshot */
        $snapshot = $this->snapshots()->create([
            'payload' => $excepted
        ]);

        return $snapshot;
    }


    /**
     * Retrieve the last taken snapshot
     */
    public function lastSnapshot()
    {
        // TODO: implement this


    }

    /**
     * Gets all snapshots
     * @param ?callable $by A callback to return the condition of search
     */
    public function getSnapshots(?callable $by=null)
    {
        // TODO: implement this


    }


    public function removeSnapshot(string $snapshotId)
    {
        // TODO: implement this
    }


    public function snapshots()
    {
        return $this->morphMany(Snapshot::class, 'snapshotable');
    }


}