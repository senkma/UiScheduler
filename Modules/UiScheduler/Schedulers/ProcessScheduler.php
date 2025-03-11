<?php

namespace Modules\UiScheduler\Schedulers;

use Modules\UiScheduler\Mutexes\MutexFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class ProcessScheduler
{
    protected $mutexFactory;

    public function __construct()
    {
        $this->mutexFactory =  new MutexFactory();
    }

    public function loadJobs()
    {
        //Load crons/jobs
        $jobs = config('uischeduler_jobs');
        return $jobs;
    }

    public function generateMutexKey(array $job): string
    {
        $key ='mutex_' . md5($job['command'] . $job['frequency']);
        //Generate Mutex key for locking
        return $key;
    }

    public function prepareMutex(array $job)
    {
        $key = $this->generateMutexKey($job);
        $mutex = $this->mutexFactory->createMutex($key);
        $mutex->key = $key;
        $mutex->ttl = 120;

        return $mutex;
    }

    public static function processJobs($mutex, $job)
    {
        //Check if is possible generate Mutex 
        if ($mutex->acquire($mutex->key, $mutex->ttl)) {
            Log::info("-- Mutex Acquired: " . $job['command']);
            try {

                if ($job['type'] === 'command') {
                    Log::info("[QUEUE JOB RUN]");
                    Artisan::call($job['command']);

                }
            } finally {
                $mutex->release($mutex->key);
                Log::info("-- Mutex Released: " . $job['command']);
            }
        } else {
            Log::info("-- Mutex Locked - SKIP: " . $job['command']);
        }
    }

}