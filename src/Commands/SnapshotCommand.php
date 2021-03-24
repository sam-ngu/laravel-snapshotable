<?php

namespace Acadea\Snapshot\Commands;

use Illuminate\Console\Command;

class SnapshotCommand extends Command
{
    public $signature = 'snapshot:all --model';

    public $description = 'Take a snapshot for all the record of the given model.';

    public function handle()
    {
        $this->comment('All done');
    }
}
