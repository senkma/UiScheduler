<?php

namespace Modules\UiScheduler\Schedulers;

use Illuminate\Support\Facades\Log;
use Modules\UiScheduler\Schedulers\LaravelSchedulerAdapter;
use Modules\UiScheduler\Schedulers\CrunzSchedulerAdapter;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Config;

class SchedulerFactory
{
    /**
     * Run the scheduler based on the configured scheduler type.
     *
     * @param Container $container
     * @return void
     */
    public static function run(Container $container)
    {  
        // Get the scheduler type from the configuration
        $schedulerType = Self::getSchedulerType();
        $mutexType = Self::getMutexType();

        // Log the start of the scheduler run
        Log::info('----------------------------------------------------------------------------------------------');
        Log::info($schedulerType . ' scheduler - START.');
        Log::info($mutexType . ' mutex.');

        // Execute the appropriate scheduler based on the type
        switch ($schedulerType) {
            case 'laravel':
                $schedulerRun = LaravelSchedulerAdapter::run();
                break;
            case 'crunz':
                $schedulerRun = CrunzSchedulerAdapter::run();
                break;
            default:
                // Log an error if the scheduler type is unsupported
                Log::error('Unsupported scheduler type.');
                return;
        }

        // Log the completion of the scheduler run
        Log::info($schedulerType . ' scheduler - DONE.');
        Log::info('----------------------------------------------------------------------------------------------');
    }

    /**
     * Get the scheduler type from the configuration.
     *
     * @return string
     */
    public static function getSchedulerType()
    {
        // Retrieve the scheduler type from the configuration file
        $schedulerType = config('uischeduler_config.scheduler');
        return $schedulerType;       
    }
    public static function getMutexType()
    {
        // Retrieve the scheduler type from the configuration file
        $mutexType = config('uischeduler_config.mutex');
        return $mutexType;       
    }
}