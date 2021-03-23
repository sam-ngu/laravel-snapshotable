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

    protected function getNonPayloadAttributes()
    {
        return [$this->primaryKey, self::CREATED_AT, self::UPDATED_AT];
    }

    /**
     * Take a snapshot of the model
     * @return Snapshot
     */
    public function takeSnapshot(): Snapshot
    {
        $attributes = $this->getAttributes();

        $excepted = Arr::except($attributes, $this->getNonPayloadAttributes());

        // convert relationships into payload
        $relations = $this->toSnapshotRelation();

        $modelWithRelations = $this->loadMissing(array_keys($relations));

//        dd($modelWithRelations);

        collect($relations)
            ->sortBy(fn ($callback, $relation) => $relations) // sort relationship in asc so once we reached nested we can be sure the parent is already loaded
            ->each(function ($callback, $relation) use($modelWithRelations) {


                // get all relations

                // destructure dot notation
                $exploded = explode('.', $relation);
                if(sizeof($exploded) > 1){
                    // we have nested relationship

                    // retrieve nested model, everything should be eager loaded by now

                    data_set($this, $relation, $callback($this));

                }

                $related = data_get($modelWithRelations, $relation);

                dd($modelWithRelations);


            });

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