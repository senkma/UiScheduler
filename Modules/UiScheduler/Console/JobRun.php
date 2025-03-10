<?php

namespace Modules\UiScheduler\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class JobRun extends Command
{
    protected $signature = 'job:run {jobName}';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $jobName = $this->argument('jobName');

        // Name of Job with path
        $jobClass = "App\\Jobs\\{$jobName}";

        // Check class exists
        if (class_exists($jobClass)) {
            try {
                // Call Job
                $jobInstance = app($jobClass);
                $jobInstance::dispatch();
            } catch (\Exception $e) {
                Log::error("Job {$jobName} failed to dispatch. Error: " . $e->getMessage());
            }
        } else {
            Log::error("Job {$jobName} was not found.");
        }
    }
}