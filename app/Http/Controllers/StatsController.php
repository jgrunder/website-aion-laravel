<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\Gameserver\Legion;
use App\Models\Gameserver\Player;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Lang;

class StatsController extends Controller {

    /**
     * GET /stats/online
     */
    public function online()
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.online.title'));
        SEOMeta::setDescription(Lang::get('seo.online.description'));
        OpenGraph::setDescription(Lang::get('seo.online.description'));

        return view('stats.online', [
            'users' => Player::legion()->online()->paginate(100)
        ]);
    }

    /**
     * GET /stats/legions
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function legions(Request $request)
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.legions.title'));
        SEOMeta::setDescription(Lang::get('seo.legions.description'));
        OpenGraph::setDescription(Lang::get('seo.legions.description'));

        return view('stats.legions', [
            'legions' => Legion::orderBy('contribution_points', 'desc')->paginate(100),
            'start'   =>  ($request->input('page')) ? ((100 * $request->input('page')) - 100) : 0
        ]);
    }

}
