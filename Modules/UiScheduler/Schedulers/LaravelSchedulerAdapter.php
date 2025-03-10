<?php

namespace Modules\UiScheduler\Schedulers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Modules\UiScheduler\Schedulers\ProcessScheduler;

class LaravelSchedulerAdapter implements SchedulerAdapterInterface
{
    protected $processScheduler;

    /**
     * Constructor to initialize ProcessScheduler.
     */
    public function __construct()
    {
        $this->processScheduler = new ProcessScheduler();
    }

    /**
     * Schedule the jobs using Laravel's Schedule.
     */
    public function schedule($schedule = null): ?Schedule
    {
        // Go through defined jobs
        foreach ($this->processScheduler->loadJobs() as $job) {
            $this->scheduleJob($schedule, $job);
        }
        return $schedule;
    }

    /**
     * Schedule a single job.
     */
    public function scheduleJob(Schedule $schedule, array $job): void
    {
        // Prepare Mutex with key
        $mutex = $this->processScheduler->prepareMutex($job);
        
        // Schedule the job with the defined frequency and description
        $schedule->call(function() use ($mutex, $job) {
            // Process scheduled jobs and commands
            ProcessScheduler::processJobs($mutex, $job);
        })->cron($job['frequency'])
          ->description($job['description']);
    }

    /**
     * Run the Laravel Scheduler.
     */
    public static function run(): void
    {
        // Run Laravel Scheduler
        Artisan::call('schedule:run');
        return;
    }
}