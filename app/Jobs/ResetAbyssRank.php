<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResetAbyssRank implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected object $accounts;

    /**
     * Resetting the specified accounts' Abyssal rank
     *
     * @return void
     */
    public function __construct($accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->accounts as $account) {
            // We query each account to get attached players
            foreach ($account->players()->get() as $player) {
                // Resetting each players abyssal rank, including AP, kills and rank
                $player->abyssRank()->reset();
            }
        }
    }
}
