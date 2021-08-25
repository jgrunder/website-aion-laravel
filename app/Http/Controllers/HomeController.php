<?php

namespace App\Http\Controllers;

use App\Models\Webserver\News;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;

use Illuminate\Support\Facades\Lang;

class HomeController extends Controller
{

    /**
     * GET /
     */
	public function index()
	{
        // SEO
        SEOMeta::setTitle(Lang::get('seo.home.title'));
        SEOMeta::setDescription(Lang::get('seo.home.description'));
        OpenGraph::setDescription(Lang::get('seo.home.description'));

        $news = News::orderBy('created_at', 'DESC')->paginate(3);

		return view('home.index', [
            'news' => $news
        ]);
	}

    /**
     * GET /news/{slug}/{id}
     */
    public function news($slug, $id)
    {
      $news = News::where('slug', '=', $slug)->where('id', '=', $id)->get();

      // News don't exist
      if($news->count() == 0){
        return redirect(route('home'))->with('error', Lang::get('flashMessage.news.fail_id'));
      }

      // SEO
      SEOMeta::setTitle($news[0]->title);
      SEOMeta::setDescription($news[0]->title);
      OpenGraph::setDescription($news[0]->title);

      return view('home.index', [
        'full' => true,
        'news' => $news
      ]);
    }

}
