<?php

namespace App\Http\Controllers;

use App\Models\Gameserver\MyShop;
use App\Models\Gameserver\Player;
use App\Models\Loginserver\AccountData;
use App\Models\Loginserver\AccountLevel;
use App\Models\Webserver\ShopCategory;
use App\Models\Webserver\ShopHistory;
use App\Models\Webserver\ShopItem;

use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller {

    /**
     * GET /shop
     */
    public function index()
    {
        $top_purchased  = ShopItem::where('purchased', '>', 0)->orderBy('purchased', 'DESC')->take(6)->get();
        $accountLevel   = AccountLevel::where('account_id', '=', Session::get('user.id'))->first();

        return view('shop.index', [
          'accountLevel'    => $accountLevel,
          'categories'      => ShopCategory::with('name')->get(),
          'top'             => true,
          'items'           => $top_purchased,
          'items_cart'      => Cart::content(),
          'total'           => Cart::total(),
          'count'           => Cart::count()
        ]);
    }
    
    /**
     * POST /shop/search
     */
    public function search(Request $request)
    {
		if(empty($request->input('search_value'))) {
			return redirect(route('shop'))->with('error', Lang::get('flashMessage.shop.no_search_empty'));
        }
		
        $accountLevel = AccountLevel::where('account_id', '=', Session::get('user.id'))->first();
        $searchValue = $request->input('search_value');
        $searchType  = 'shop_item_name';

        $results = ShopItem::withCategory()->where('name', 'LIKE', '%'.$searchValue.'%')->paginate(30);

        $results->appends(['search_value' => $searchValue, 'search_type' => $searchType]);

        return view('shop.index', [
			'accountLevel'    => $accountLevel,
			'categories'      => ShopCategory::with('name')->get(),
			'items'           => $results,
			'searchValue'	  => $searchValue,
			'items_cart'      => Cart::content(),
			'total'           => Cart::total(),
			'count'           => Cart::count()
        ]);

    }

    /**
     * GET /shop/category/{id}
     */
    public function category($id)
    {
        $items          = ShopItem::where('id_sub_category', '=', $id)->paginate(12);
        $accountLevel   = AccountLevel::where('account_id', '=', Session::get('user.id'))->first();

        if($items->count() === 0) {
            return redirect(route('shop'))->with('error', Lang::get('flashMessage.shop.fail_category_id'));
        }

        return view('shop.index', [
          'accountLevel'    => $accountLevel,
          'categories'      => ShopCategory::with('name')->get(),
          'items'           => $items,
          'items_cart'      => Cart::content(),
          'total'           => Cart::total(),
          'count'           => Cart::count()
        ]);
    }

    /**
     * GET /shop/add/{id}
     */
    public function addToCart($id)
    {
        $item            = ShopItem::where('id_item', '=', $id)->first();
        $item_in_cart    = Cart::search(['id' => $id]);
        $content_in_cart = Cart::content();

        if($item->count() > 0) {

            if(!$item_in_cart) {
                Cart::add($id, $item->name, 1, $item->price, ['id_item' => $id, 'quantity' => $item->quantity]); // Add new Item in Cart
            } else {
                Cart::update($item_in_cart[0], $content_in_cart[$item_in_cart[0]]['qty'] + 1); // Update Quantity
            }

            return view('_modules.cart', [
              'items_cart'      => Cart::content(),
              'total'           => Cart::total(),
              'count'           => Cart::count()
            ]);

        }
    }

    /**
     * GET /shop/remove/{id}
     */
    public function removeToCart($id)
    {
        $item               = ShopItem::where('id_item', '=', $id)->first();
        $item_in_cart       = Cart::search(['id' => $id]);
        $content_in_cart    = Cart::content();
        $newQt              = $content_in_cart[$item_in_cart[0]]['qty'] - $item->quantity;

        if($newQt <= 0){
            Cart::remove($item_in_cart[0]);
        } else {
            Cart::update($item_in_cart[0], $content_in_cart[$item_in_cart[0]]['qty'] - $item->quantity);
        }

        return view('_modules.cart', [
          'items_cart'      => Cart::content(),
          'total'           => Cart::total(),
          'count'           => Cart::count()
        ]);
    }

    /**
     * GET /shop/buy
     */
    public function summary()
    {
        $account = AccountData::me(Session::get('user.id'))->first();

        if(Cart::count() == 0) { // If cart is empty -> Redirect to the shop page
            return redirect(route('shop'))->with('error', Lang::get('flashMessage.shop.empty_cart'));
        }
        else if($account->shop_points < Cart::total()) { // If no shop points -> Redirect to the shop page
            return redirect()->back()->with('error', Lang::get('flashMessage.shop.not_shop_points'));
        }

        $players        = Player::where('account_id', '=', Session::get('user.id'))->get();
        $players_array  = [];

        foreach($players as $player){
            $players_array[$player->id] = $player->name;
        }

        return view('shop.summary', [
          'categories'      => ShopCategory::with('name')->get(),
          'items_cart'      => Cart::content(),
          'total'           => Cart::total(),
          'players'         => $players_array,
          'count'           => Cart::count()
        ]);
    }

    /**
     * POST /shop/buy
     */
    public function buy(Request $request)
    {
        $player_id  = $request->input('player_id');
        $player     = Player::where('id', '=', $player_id)->first();
        $total      = Cart::total();
        $account_id = Session::get('user.id');

        foreach(Cart::content() as $item){
            ShopItem::where('id_item', '=', $item->options['id_item'])->increment('purchased', 1);
            MyShop::create([
              'item'      => $item->options['id_item'],
              'nb'        => $item->options['quantity'] * $item->qty,
              'player_id' => $player_id
            ]);

            for($i = 0; $i < $item->qty; $i++){
                ShopHistory::create([
                  'account_id'    => $account_id,
                  'player_id'     => $player_id,
                  'player_name'   => $player->name,
                  'item_id'       => $item->options['id_item'],
                  'quantity'      => $item->options['quantity'],
                  'price'         => $item->price,
                  'name'          => $item->name,
                ]);
            }

        }

        AccountData::me($account_id)->decrement('shop_points', $total);

        Cart::destroy();

        return redirect(route('shop'))->with('success', Lang::get('flashMessage.shop.success').' '.$player->name);
    }

}
