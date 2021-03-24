<?php

namespace Acadea\Snapshot;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Acadea\Snapshot\Commands\SnapshotCommand;

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
            ->hasMigration('create_snapshots_table');
    }
}
