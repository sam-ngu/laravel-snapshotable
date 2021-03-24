<?php

namespace Acadea\Snapshot\Tests;


use Acadea\Snapshot\Models\Snapshot;
use Acadea\Snapshot\Tests\Models\Comment;
use Acadea\Snapshot\Tests\Models\Post;
use Acadea\Snapshot\Tests\Models\Tag;
use Acadea\Snapshot\Tests\Models\User;
use Illuminate\Support\Arr;

class SnapshotTest extends TestCase
{

    protected function createPost(): Post
    {
        $user = User::factory()->count(3)->create();
        /** @var Post $post*/
        $post = Post::factory()->create();

        $comments = Comment::factory()->count(3)->create([
            'post_id' => $post->id,
        ]);

        $tags = Tag::factory()->count(3)->create();

        $comments->each(fn (Comment $comment) => $comment->tags()->sync($tags->pluck('id')));

        return $post;
    }


    public function test_can_record_model_attributes()
    {
        $post = $this->createPost();

        $snapshot = $post->takeSnapshot();

        // test_can_record_model_attributes
        $snapshotPayload = $snapshot->payload;

        $attributes = $post->getAttributes();

        // checking all keys are available in payload
        $attributes = Arr::except($attributes, ['id', 'created_at', 'updated_at']);

        foreach ($attributes as $attribute => $value){

            $this->assertArrayHasKey($attribute, $snapshotPayload);
        }

        foreach ($attributes as $attribute => $value){
            $this->assertSame(data_get($snapshotPayload, $attribute), $value);
        }
    }


    public function test_can_record_one_to_many()
    {
        $post = $this->createPost();

        $snapshot = $post->takeSnapshot();

        $snapshotPayload = $snapshot->payload;

        $snapshotComments = data_get($snapshotPayload, 'comments');

        $this->assertSameSize($post->comments, $snapshotComments, 'Snapshot taken has the same one to many value as original');

    }

    public function test_can_record_many_to_many()
    {
        // test pivot data
        $post = $this->createPost();
        /** @var Comment $comment */

        $comment = $post->comments->first();

        $snapshot = $comment->takeSnapshot();

        $tags = $comment->tags;

        $snapshotTags = data_get($snapshot->payload, 'tags');

        $this->assertSameSize($tags, $snapshotTags);

        // make sure all id are the same
        array_map(function ($tag, $snapshotTag){
            $this->assertSame($tag['id'], $snapshotTag['id'], 'Make sure all many to many ids are the same');
        }, $tags->toArray(), $snapshotTags);


    }


    public function test_can_get_last_snapshot_taken()
    {
        $post = $this->createPost();

        $this->travel(-5)->hours();

        for ($ii = 0; $ii < 10; $ii++){
            $post->takeSnapshot();
        }

        $this->travelBack();

        $snapshot = $post->takeSnapshot();

        $lastSnapshot = $post->lastSnapshot();

        $this->assertSame($snapshot->id, $lastSnapshot->id, 'Last snapshot id is not the same');

    }


    public function test_snapshot_can_be_deleted()
    {
        $post = $this->createPost();

        $snapshot = $post->takeSnapshot();
        $snapshot = $post->takeSnapshot();
        $snapshot = $post->takeSnapshot();

        $result = $post->removeSnapshot($snapshot->id);

        $this->assertSame(2, $post->snapshots->count());

    }

    public function test_can_take_snapshot_for_all()
    {
        $post1 = $this->createPost();
        $post2 = $this->createPost();
        $post3 = $this->createPost();

        $snapshots = Post::takeSnapshotForAll();


        $this->assertSame(3, $snapshots->count());
        $this->assertSame(3, Snapshot::query()->count());


    }


}
