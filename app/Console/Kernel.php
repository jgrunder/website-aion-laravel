<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        
        /**
         * Check every 5 minutes the status of each server and store data into the cache
         */
        $schedule->call(function () {
            
            $servers = config('aion.servers');
            
            foreach ($servers as $key => $server) {
                if (!$server['enabled']) continue;
                if ($key == 'Discord') continue;
                
                $expiresAt = 300;
                
                try {
                    $check = fsockopen($server['ip'], $server['port'], $errno, $errstr, 1.0);
                    
                    cache(['status.'.$key => ($check) ? true : false], $expiresAt);
                    
                    $serversStatus[] = [
                        'name'   => $key,
                        'status' => ($check) ? true : false
                    ];
                    
                    fclose($check);
                    
                } catch (\Throwable $e) {
                    debug('Server ' . $key . ' is not available');
                    $serversStatus[] = [
                        'name'   => $key,
                        'status' => false
                    ];
                    cache(['status.'.$key => false], $expiresAt);
                }
                
            }
        })->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
