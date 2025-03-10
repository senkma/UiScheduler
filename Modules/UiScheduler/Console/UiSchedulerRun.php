<?php

namespace Modules\UiScheduler\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\UiScheduler\Schedulers\SchedulerFactory;

class UiSchedulerRun extends Command
{
    protected $signature = 'uischeduler:run';

    protected $schedulerFactory;

    public function __construct(SchedulerFactory $schedulerFactory)
    {
        parent::__construct();
        $this->schedulerFactory = $schedulerFactory;
    }

    public function handle()
    {
        try {
            // Run SchedulerFactory
            $this->schedulerFactory->run($this->getLaravel());
        } catch (\Exception $e) {
            Log::error('SchedulerFactory failed to run. Error: ' . $e->getMessage());
        }
    }
}