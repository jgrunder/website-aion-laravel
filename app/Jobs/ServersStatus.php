<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ServersStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $servers;

    /**
     * Check the status of each server and store data into the cache
     *
     * @return void
     */
    public function __construct()
    {
        $this->servers = config('aion.servers');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->servers as $key => $server) {
            
            // Ignore if server is disabled
            if (!$server['enabled']) continue;
            // Ignore if server is Discord as it's always on
            if ($key == 'Discord') continue;
            
            try {
                // Try to access the server
                $check = fsockopen($server['ip'], $server['port']);
                // If here server is responding, but we save the info from $check for double check
                cache(['status.'.$key => ($check) ? true : false]);
                // Then we close the connexion
                fclose($check);
            } catch (\Throwable $e) {
                // If server is not responding this error is thrown
                debug('Server ' . $key . ' is not available');
                // Save in the cache that the server is not responding
                cache(['status.'.$key => false]);
            }
            
        }
    }
}
