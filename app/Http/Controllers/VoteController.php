<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Http\Requests;

use App\Models\Loginserver\AccountData;
use App\Models\Loginserver\AccountVote;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class VoteController extends Controller {

    /**
     * GET /vote/{id}
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index($id)
    {

        $accountId      = Session::get('user.id');
        $votesLinks     = Config::get('aion.vote.links');
        $accountVote    = AccountVote::where('account_id', $accountId)->where('site', $id)->first();

        if($accountVote === null){

            AccountVote::create([
                'account_id' => $accountId,
                'site'       => $id,
                'date'       => Carbon::now(),
                'add'        => 0
            ]);

        } else {

            $oldDate = Carbon::parse($accountVote->date);

            if($oldDate->diffInHours(Carbon::now()) >= 2){

                AccountVote::where('account_id', $accountId)->where('site', $id)->update(['date' => Carbon::now(), 'add' => 0]);

            } else {
                return redirect(route('home'))->with('error', Lang::get('flashMessage.vote.wait_time'));
            }
        }
        
        if(!config('aion.vote.check')) {
            $pointsPerVote  = (!Config::get('aion.vote.boost')) ? Config::get('aion.vote.shop_points_per_vote') : Config::get('aion.vote.shop_points_per_vote') + Config::get('aion.vote.boost_value');
            AccountData::IncrementVoteCount($accountId);
            AccountData::AddShopPoints($accountId, $pointsPerVote);
            AccountVote::where('account_id', $accountId)->where('add', 0)->where('site', $id)->update(['add' => 1]);
        }

        return redirect($votesLinks[$id]['link']);

    }

}
