<?php


namespace Acadea\Snapshot\Traits;


use Acadea\Snapshot\Models\Snapshot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait Snapshotable
{
    /*
     * An array of relation, key
     * Does NOT Supports the 'dot' notation to define the relationships
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
    protected function toSnapshotRelations()
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
        $relations = $this->toSnapshotRelations();

        // loadMissing is not a pure function, load rel to the model instance
        $this->loadMissing(array_keys($relations));


        $relationResults = collect($relations)->reduce(function ($carry, $next, $relation) {

            $relationData = $this->{$relation};

            if($relationData instanceof Collection){

                $carry[$relation] = $relationData->map($next);

            }else{
                $carry[$relation] = $next($relationData);
            }

            return $carry;

        }, []);

        /** @var $snapshot Snapshot */
        $snapshot = $this->snapshots()->create([
            'payload' => array_merge($excepted, $relationResults)
        ]);

        return $snapshot;
    }


    /**
     * Retrieve the last taken snapshot
     */
    public function lastSnapshot()
    {
        return $this->snapshots()->latest()->first();
    }


    public function removeSnapshot(string $snapshotId)
    {
        return $this->snapshots()->where('id', '=', $snapshotId)->delete();
    }


    public function snapshots()
    {
        return $this->morphMany(Snapshot::class, 'snapshotable');
    }


}