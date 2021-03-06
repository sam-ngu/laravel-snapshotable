<?php

namespace Acadea\Snapshot;

use Acadea\Snapshot\Commands\SnapshotCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SnapshotServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-snapshotable')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_snapshot_table')
            ->hasCommand(SnapshotCommand::class);
    }
}
