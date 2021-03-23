<?php


namespace Acadea\Snapshot\Tests\Database\Factories;

use Acadea\Snapshot\Tests\Models\Tag;
use Acadea\Snapshot\Tests\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'title' => $this->faker->realText(20),
        ];
    }
}
