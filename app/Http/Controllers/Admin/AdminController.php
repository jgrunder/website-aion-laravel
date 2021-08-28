<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gameserver\Player;
use App\Models\Loginserver\AccountData;
use App\Models\Webserver\ConfigSlider;
use App\Models\Webserver\LogsAllopass;
use App\Models\Webserver\LogsPaypal;
use App\Models\Webserver\LogsShopPoints;
use App\Models\Webserver\Pages;
use App\Models\Webserver\ShopItem;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Lahaxearnaud\LaravelPushbullet\LaravelPushbulletFacade;

class AdminController extends Controller
{

    /**
     * GET /admin/logs/{name}
     */
    public function logs($name)
    {
        $logsConfig      = Config::get('aion.logs');
        $logsPath        = $logsConfig['path'];
        $logsFiles       = $logsConfig['files'];
        $userAccessLevel = Session::get('user.access_level');

        foreach ($logsFiles as $key => $value) {

            // Check if the name are in the config
            if ($name.$value['extension'] == $value['file'].$value['extension']) {

                // Check User accessLevel
                if ($userAccessLevel >= $value['access_level']){

                    $filePath = $logsPath.$value['file'].$value['extension'];

                    // Check if file exist
                    if (file_exists($filePath)){

                        // Download the file
                        return response()->download($filePath);

                    }

                }

            }
        }

        return redirect(route('admin'));
    }

    /**
     * POST /admin/search
     */
    public function search(Request $request)
    {
        $searchValue = empty($request->input('search_value')) ? '%' : $request->input('search_value');
        $searchType  = $request->input('search_type');

        switch ($searchType){
            case 'character':
                $results = Player::where('name', 'LIKE', '%'.$searchValue.'%')->paginate(30);
                break;
            case 'shop_item_name':
                $results = ShopItem::withCategory()->where('name', 'LIKE', '%'.$searchValue.'%')->paginate(30);
                break;
            case 'shop_item_id':
                $results = ShopItem::withCategory()->where('id_item', $searchValue)->paginate(30);
                break;
            default:
                $results = Player::where('name', 'LIKE', '%'.$searchValue.'%')->paginate(30);
                break;
        }

        $results->appends(['search_value' => $searchValue, 'search_type' => $searchType]);

        return view('admin.search', [
            'searchType' => $searchType,
            'results'    => $results
        ]);

    }

    /**
     * GET /admin/allopass
     */
    public function allopass()
    {
        return view('admin.allopass', [
           'allopass' => LogsAllopass::orderBy('created_at', 'DESC')->paginate(30)
        ]);
    }

    /**
     * GET /admin/paypal
     */
    public function paypal()
    {
        return view('admin.paypal', [
            'paypal' => LogsPaypal::orderBy('created_at', 'DESC')->paginate(30)
        ]);
    }

    /**
     * GET /admin/points
     */
    public function points()
    {
        return view('admin.shop_points', [
            'points' => LogsShopPoints::orderBy('created_at', 'DESC')->paginate(30)
        ]);
    }

    /**
     * GET/POST /admin/page/{$name}
     */
    public function pageEdit(Request $request, $name)
    {

        if ($request->isMethod('POST')){
            Pages::where('page_name', '=', $name)->update([
                'fr'     => $request->input('fr'),
                'en'     => $request->input('en')
            ]);
        }

        $page = Pages::where('page_name', '=', $name)->first();

        return view('admin.page', [
           'page' => $page
        ]);
    }

    /**
     * GET/POST /admin/add-points
     */
    public function addPoints(Request $request)
    {
        $success = null;
        $errors  = null;

        if ($request->isMethod('POST')){

            $account_name = $request->input('account_name');
            $shopPoints   = $request->input('points');
            $reason       = $request->input('reason');

            $account = AccountData::where('name', '=', $account_name)->first();

            if($account !== null){

                // Because we don't trust the team
                LogsShopPoints::create([
                    'sender_name'   => Session::get('user.name'),
                    'receiver_name' => $account_name,
                    'reason'        => $reason,
                    'points'        => $shopPoints
                ]);

                AccountData::where('name', '=', $account_name)->increment('shop_points', $shopPoints);

                $success = "Le compte a été crédité de ".$shopPoints;
            } else {
                $errors = "Le compte n'existe pas";
            }

        }

        return view('admin.addPoints', [
            'success' => $success,
            'errors'  => $errors
        ]);
    }

    /**
     * GET/POST /admin/sider
     */
    public function slider(Request $request)
    {
        if ($request->isMethod('POST')){
            $data = $request->all();
            ConfigSlider::create([
                'title' => $data['title'],
                'path'  => ConfigSlider::upload(Input::file('path'))
            ]);
        }

        // Flush the cache
        Cache::forget('sliders');
        $slider = Cache::rememberForever('sliders', function() {
            return ConfigSlider::all();
        });

        return view('admin.slider', [
            'slider' => $slider
        ]);
    }

    /**
     * GET/POST /admin/pushbullet
     *
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function pushbullet(Request $request)
    {
        $count = null;

        if($request->isMethod('post')){

            $data       = $request->all();
            $accounts   = AccountData::select('pushbullet')->where('pushbullet', '!=', '')->get();
            $count      = $accounts->count();

            foreach($accounts as $account){
                if(filter_var($account->pushbullet, FILTER_VALIDATE_EMAIL)){
                    LaravelPushbulletFacade::user($account->pushbullet)->note('[Aion Server] '.$data['title'], $data['content']);
                }
            }
        }

        return view('admin.pushbullet', [
            'count' => $count
        ]);
    }
}
