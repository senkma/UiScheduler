<?php

namespace Modules\UiScheduler\Schedulers;

use Crunz\Schedule;
use Illuminate\Support\Facades\Config;
use Modules\UiScheduler\Schedulers\ProcessScheduler;

class CrunzSchedulerAdapter implements SchedulerAdapterInterface
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
        // Schedule Crunz
        $schedule = new Schedule();

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
        $mutex = $this->processScheduler->prepareMutex($job); // Prepare Mutex with key
        
        // Schedule the job with the defined frequency and description        
        $schedule->run(function () use ($mutex, $job) {
            Self::initializationLaravel(); // Laravel Initialization - Facades, Artisan, Config, etc.
            // Process scheduled jobs and commands
            ProcessScheduler::processJobs($mutex, $job); // Process scheduled jobs and commands
        })->cron($job['frequency'])
          ->description($job['description']);
    }

    /**
     * Run the Crunz Scheduler.
     */
    public static function run(): void
    {
        // Run Crunz Scheduler
        shell_exec('vendor/bin/crunz schedule:run');
        return;
    }

    public static function initializationLaravel()
    {
        // Initialization of Laravel
        $app = require '/var/www/html/uischeduler/bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return;
    }
}