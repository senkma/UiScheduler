<?php

namespace Modules\UiScheduler\App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\UiScheduler\Schedulers\ProcessScheduler;

class ProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mutex;
    protected $queuejob;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mutex, $queuejob)
    {
        $this->mutex = $mutex;
        $this->queuejob = $queuejob;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ProcessScheduler::processJobs($this->mutex, $this->queuejob);
    }
}