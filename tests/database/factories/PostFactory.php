<?php


namespace Acadea\Snapshot\Tests\Database\Factories;

use Acadea\Snapshot\Tests\Models\Post;
use Acadea\Snapshot\Tests\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title' => $this->faker->realText(20),
            'user_id' => User::all()->random()->id,
        ];
    }
}
