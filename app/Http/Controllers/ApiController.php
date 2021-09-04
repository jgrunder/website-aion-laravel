<?php

namespace App\Http\Controllers;

use App\Models\Gameserver\Player;

class ApiController extends Controller {
    
    /**
     * GET /page/join-us
     */
    public function online()
    {
        return ['response' => [
            'player_count' => Player::online()->count(),
            'result' => 1,
        ]];
    }
    
}
