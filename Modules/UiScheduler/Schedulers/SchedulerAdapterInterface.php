<?php

namespace Modules\UiScheduler\Schedulers;

use Illuminate\Console\Scheduling\Schedule;

interface SchedulerAdapterInterface
{
    /**
     * Schedules tasks according to defined jobs.
     * 
     * @param mixed $schedule Schedule object (can be Crunz\Schedule or Illuminate\Console\Scheduling\Schedule).
     * @return mixed Returns Schedule or null.
     */
    public function schedule($schedule = null);

    /**
     * Runs the scheduler.
     *
     * @param Schedule $schedule
     * @param array $job
     * @return void
     */
    public function scheduleJob(Schedule $schedule, array $job): void;

    /**
     * Runs the scheduler.
     *
     * @return void
     */
    public static function run(): void;
}