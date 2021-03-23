<?php

namespace Acadea\Snapshot\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Acadea\Snapshot\SnapshotServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Acadea\\Snapshot\\Tests\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SnapshotServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);


        include_once __DIR__.'/../database/migrations/0000_00_00_000000_create_snapshots_table.php';
        include_once __DIR__.'/database/migrations/0000_00_00_000000_create_posts_test_table.php.stub';
        include_once __DIR__.'/database/migrations/0000_00_00_000001_create_comments_test_table.php.stub';
        include_once __DIR__.'/database/migrations/0000_00_00_000002_create_tags_test_table.php.stub';
        include_once __DIR__.'/database/migrations/0000_00_00_000003_create_comment_tag_pivot_table.php.stub';
        (new \CreateSnapshotTable())->up();
        (new \CreatePostsTestTable())->up();
        (new \CreateCommentsTestTable())->up();
        (new \CreateTagsTestTable())->up();
        (new \CreateCommentTagPivotTestTable())->up();

    }
}
