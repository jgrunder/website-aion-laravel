<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class UserWasPurchasedShopPoint extends Event {

	use SerializesModels;

	public $accountId;

	/**
	 * Create a new event instance.
	 *
	 * @param $accountId
	 */
	public function __construct($accountId)
	{
		$this->accountId = $accountId;
	}

}
