<?php

namespace Acadea\Snapshot\Commands;

use Illuminate\Console\Command;

class SnapshotCommand extends Command
{
    public $signature = 'laravel-snapshotable';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
