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

        // split the relations into 2 group, nested and not nested
        $grouped = collect($relations)->groupBy(function ($callback, $relation) {
            // if nested, will have 'dot' in the relation string
            $isNested = Str::contains($relation, '.');
            return $isNested ? 'nested' : 'flat';
        }, $preserveKeys = true);

//        $nested = collect($grouped->get('nested'))
//            ->

//        function findAndLoadNestedRelation($model, $relation) use ($grouped){
//
//
//        }
//        findAndLoadNestedRelation($comment, 'comments.tags');



        collect($grouped->get('flat'))
//            ->sortBy(fn($callback, $relation) => $relations) // sort relationship in asc so once we reached nested we can be sure the parent is already loaded
            ->each(function ($callback, $relation) use($grouped) {

                $relationData = $this->getRelation($relation);

                if( $relationData instanceof Collection){
                    $payload = $relationData->map($callback);

                    // find nested relationship
                    $nested = collect($grouped->get('nested'));

                    // filter out related relationship to current relation
                    $filtered = $nested->filter(function ($callback, $nestedRelation) use($relation) {

                        [$root] = explode('.', $nestedRelation);
                        return $root === $relation;

                    });

                    dd($filtered);

                    dd($nested);

                    // load it inside payload




                }else {
                    $payload = $callback($relationData);
                }

                dd($payload);

//                // get all relations
//
//                // destructure dot notation
//                $exploded = explode('.', $relation);
//                if (sizeof($exploded) > 1) {
//                    // we have nested relationship
////                    dd($modelWithRelations->getRelations());
////                    dd($relation);
//                    dd($this->getRelations());
//                    // retrieve nested model, everything should be eager loaded by now
//
//                    data_set($this, $relation, $callback($this));
//                    dd($this);
//                }

//                $related = data_get($modelWithRelations, $relation);

//                dd($modelWithRelations);


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
    public function getSnapshots(?callable $by = null)
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