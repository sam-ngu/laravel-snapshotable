<?php


namespace Acadea\Snapshot\Tests\Database\Factories;

use Acadea\Snapshot\Tests\Models\Comment;
use Acadea\Snapshot\Tests\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {

        return [
            'title' => $this->faker->realText(20),
            'post_id' => Post::all()->random()->id,
        ];
    }
}
