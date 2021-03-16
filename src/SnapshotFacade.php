<?php

namespace Acadea\Snapshot;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Acadea\Snapshot\Snapshot
 */
class SnapshotFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-snapshotable';
    }
}
