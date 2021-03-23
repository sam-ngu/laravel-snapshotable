<?php

namespace Acadea\Snapshot\Tests;


use Acadea\Snapshot\Tests\Models\Comment;
use Acadea\Snapshot\Tests\Models\Post;

class SnapshotTest extends TestCase
{

    public function test_can_record_one_to_many()
    {
        /** @var Post $post*/
        $post = Post::factory()->create();

        $comments = Comment::factory()->count(3)->create([
            'post_id' => $post->id,
        ]);

        $snapshot = $post->takeSnapshot();



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
