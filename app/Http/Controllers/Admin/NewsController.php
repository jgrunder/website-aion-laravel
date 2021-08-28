<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;

use App\Models\Loginserver\AccountData;
use App\Models\Webserver\News;
use App\Models\Webserver\ShopHistory;
use App\Models\Webserver\ShopItem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class NewsController extends Controller
{

  /**
   * GET /admin
   */
  public function index()
  {
    $topItemsBuy      = ShopItem::orderBy('purchased', 'desc')->take(5)->get();
    $shopHistoryToday = ShopHistory::where('created_at', '=', Carbon::today())->count();
    $shopHistoryTotal = ShopHistory::count();
    $accountsCount    = AccountData::count();

    return view('admin.index', [
        'shopHistoryToday'  => $shopHistoryToday,
        'shopHistoryTotal'  => $shopHistoryTotal,
        'accountsCount'     => $accountsCount,
        'topItemsBuy'       => $topItemsBuy
    ]);
  }

  /**
   * GET /admin/news
   */
  public function news()
  {
      return view('admin.news.index', [
          'news' => News::get()
      ]);
  }

  /**
   * GET /admin/news-delete/{id}
   */
  public function newsDelete($id)
  {
      News::destroy($id);

      return redirect()->back();
  }

  /**
   * GET/POST /admin/news-add/
   */
  public function newsAdd(Request $request)
  {
      $success    = null;
      $error      = null;

      if($request->isMethod('post')){

          $slug       = Str::slug($request->input('title'), '-');
          $article    = News::where('slug', '=', $slug)->first();

          if($article === null){
              News::create([
                  'title'         => $request->input('title'),
                  'slug'          => $slug,
                  'text'          => $request->input('content'),
                  'account_id'    => Session::get('user.id')
              ]);

              return redirect()->back()->with('success', "Votre article a été crée avec succès.");

          }
          else {
              return redirect()->back()->with('error', "Merci de changer le nom de votre article.")->withInput();
          }


      }

      return view('admin.news.add', [
          'error'     => $error,
          'success'   => $success
      ]);

  }

  /**
   * GET/POST /admin/news-edit/{id}
   */
  public function newEdit(Request $request, $id)
  {
      if($request->isMethod('get')) {
          $news = News::find($id);

          return view ('admin.news.edit', [
              'news' => $news
          ]);

      }
      else {
          News::where('id', '=', $id)->update([
              'title'         => $request->input('title'),
              'slug'          => Str::slug($request->input('title'), '-'),
              'text'          => $request->input('content')
          ]);

          return redirect(route('admin.news'));
      }
  }

}
