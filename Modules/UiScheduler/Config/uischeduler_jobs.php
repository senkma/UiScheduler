<?php

    /*
    |--------------------------------------------------------------------------
    | Job Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for defining the jobs and commands that will be scheduled
    | by the application. You can add new jobs or commands by copying the
    | pattern below and modifying it as needed.
    |
    | Example:
    | [
    |     'type' => 'command', // command/exec
    |     'command' => 'job:run LogMessage', // job:run {jobName}/shell command
    |     'frequency' => '* * * * *', // Cron format
    |     'description' => 'Run the LogMessage job'
    | ],
    |
    */

return [
    [ 
        'type' => 'command',
        'command' => 'job:run LogMessage', 
        'frequency' => '* * * * *',
        'description' => 'LogMessage'
    ],
    [
        'type' => 'command',
        'command' => 'job:run LogMessageSleep80', 
        'frequency' => '* * * * *',
        'description' => 'LogMessageSleep80'
    ],
    [
        'type' => 'exec',
        'command' => 'echo "ExecCommand/2 >  DONE" >> /var/www/html/uischeduler/storage/logs/laravel.log', 
        'frequency' => '*/2 * * * *',
        'description' => 'ExecCommand/2'
    ],
    [
        'type' => 'exec',
        'command' => 'echo "ExecCommand/3 >  DONE" >> /var/www/html/uischeduler/storage/logs/laravel.log', 
        'frequency' => '*/3 * * * *',
        'description' => 'ExecCommand/3'
    ],

];

