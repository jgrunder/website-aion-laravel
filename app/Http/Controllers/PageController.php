<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\Webserver\Pages;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;

use Illuminate\Support\Facades\Lang;

class PageController extends Controller {

    /**
     * GET /page/join-us
     */
    public function joinUs()
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.joinus.title'));
        SEOMeta::setDescription(Lang::get('seo.joinus.description', ['name' => config('aion.website_name')]));
        OpenGraph::setDescription(Lang::get('seo.joinus.description', ['name' => config('aion.website_name')]));

        $content = Pages::where('page_name', '=', 'joinus')->first([$this->language]);

        return view('page.joinus', [
            'content' => $content[$this->language]
        ]);
    }

    /**
     * GET /page/teamspeak
     */
    public function teamspeak()
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.teamspeak.title'));
        SEOMeta::setDescription(Lang::get('seo.teamspeak.description'));
        OpenGraph::setDescription(Lang::get('seo.teamspeak.description'));

        $content = Pages::where('page_name', '=', 'teamspeak')->first([$this->language]);

        return view('page.teamspeak', [
            'content' => $content[$this->language]
        ]);
    }
    
    /**
     * GET /page/discord
     */
    public function discord()
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.discord.title'));
        SEOMeta::setDescription(Lang::get('seo.discord.description'));
        OpenGraph::setDescription(Lang::get('seo.discord.description'));
        
        $content = Pages::where('page_name', '=', 'discord')->first([$this->language]);
        
        return view('page.discord', [
            'content' => $content[$this->language]
        ]);
    }

    /**
     * GET /page/rules
     */
    public function rules()
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.rules.title'));
        SEOMeta::setDescription(Lang::get('seo.rules.description'));
        OpenGraph::setDescription(Lang::get('seo.rules.description'));

        $content = Pages::where('page_name', '=', 'rules')->first([$this->language]);

        return view('page.rules', [
            'content' => $content[$this->language]
        ]);
    }

    /**
     * GET /page/rules
     */
    public function team()
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.team.title'));
        SEOMeta::setDescription(Lang::get('seo.team.description', ['name' => config('aion.website_name')]));
        OpenGraph::setDescription(Lang::get('seo.team.description', ['name' => config('aion.website_name')]));

        $content = Pages::where('page_name', '=', 'team')->first([$this->language]);

        return view('page.team', [
            'content' => $content[$this->language]
        ]);
    }

    /**
     * GET /page/error
     */
    public function error()
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.error.title'));
        SEOMeta::setDescription(Lang::get('seo.error.description'));
        OpenGraph::setDescription(Lang::get('seo.error.description'));

        return view('page.error');
    }

    /**
     * GET /page/rates
     */
    public function rates()
    {
        // SEO
        SEOMeta::setTitle(Lang::get('seo.rates.title'));
        SEOMeta::setDescription(Lang::get('seo.rates.description', ['name' => config('aion.website_name')]));
        OpenGraph::setDescription(Lang::get('seo.rates.description', ['name' => config('aion.website_name')]));

        $content = Pages::where('page_name', '=', 'rates')->first([$this->language]);

        return view('page.rates', [
            'content' => $content[$this->language]
        ]);
    }

    /**
     * GET /donation
     */
    public function donation()
    {
        return view('page.donation');
    }

}
