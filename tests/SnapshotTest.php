<?php

namespace Acadea\Snapshot\Tests;


use Acadea\Snapshot\Tests\Models\Comment;
use Acadea\Snapshot\Tests\Models\Post;
use Acadea\Snapshot\Tests\Models\Tag;
use Illuminate\Support\Arr;

class SnapshotTest extends TestCase
{

    protected function createPost(): Post
    {
        /** @var Post $post*/
        $post = Post::factory()->create();

        $comments = Comment::factory()->count(3)->create([
            'post_id' => $post->id,
        ]);

        $tags = Tag::factory()->count(3)->create();

        $comments->each(fn (Comment $comment) => $comment->tags()->sync($tags->only('id')));

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

        foreach (array_keys($snapshotPayload) as $snapshotKey){
            $this->assertArrayHasKey($snapshotKey, $attributes);
        }

        foreach ($snapshotPayload as $key => $value){
            $this->assertSame(data_get($attributes, $key), $value);
        }
    }


    public function test_can_record_one_to_many()
    {
        $post = $this->createPost();



    }

//    public function test_can_record_many_to_many()
//    {
//
//        // test pivot data
//
//    }
//
//    public function test_can_record_recursively()
//    {
//
//    }
//
//
//    public function test_can_get_last_snapshot_taken()
//    {
//
//    }
//
//    public function test_can_()
//    {
//
//    }


}
