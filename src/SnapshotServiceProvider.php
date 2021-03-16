<?php

namespace Acadea\Snapshot;

use Acadea\LaravelPackageTools\Package;
use Acadea\LaravelPackageTools\PackageServiceProvider;
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
            ->hasViews()
            ->hasMigration('create_laravel_snapshotable_table')
            ->hasCommand(SnapshotCommand::class);
    }
}
