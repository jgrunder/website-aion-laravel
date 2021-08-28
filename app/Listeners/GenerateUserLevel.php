<?php
namespace App\Listeners;

use App\Events\UserWasPurchasedShopPoint;

use App\Models\Loginserver\AccountData;
use App\Models\Loginserver\AccountLevel;

use App\Models\Webserver\LogsAllopass;
use App\Models\Webserver\LogsPaypal;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class GenerateUserLevel {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  UserWasPurchasedShopPoint  $event
	 * @return void
	 */
	public function handle(UserWasPurchasedShopPoint $event)
	{
		$accountId = $event->accountId;
		$levels	   = Config::get('aion.levels');

		$logsAllopass = LogsAllopass::where('id_account', $accountId)->count();
		$logsPaypal 	= LogsPaypal::where('id_account', $accountId)->where('status', 'completed')->get();
		$accountLevel = 0;

		foreach($logsPaypal as $logPaypal){
			$logsAllopass += $logPaypal->price;
		}

		// Find the user Level base on levels from config
		foreach(array_reverse($levels) as $key => $level){
			if($logsAllopass >= $level['price']){
				$accountLevel = $level['level'];
				break;
			}
		}

		$accountLevelFromDatabase = AccountLevel::where('account_id', $accountId)->first();

		if(!$accountLevelFromDatabase){
			AccountLevel::create([
				'account_id' 	=> $accountId,
				'total' 		=> $logsAllopass,
				'level' 		=> $accountLevel
			]);
		} else {
			AccountLevel::where('account_id', $accountId)->update([
				'total' => $logsAllopass,
				'level' => $accountLevel
			]);
		}

		// Put the level in the session
		Session::put('user.level', $accountLevel);

	}

}
