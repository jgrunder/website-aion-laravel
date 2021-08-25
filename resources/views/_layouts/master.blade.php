<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">

    <!-- SEO -->
    {!! SEO::generate() !!}
    <meta name="author" content="Mathieu Le Tyrant"/>
    <meta name="copyright" content="Copyright 2016 © MathieuLeTyrant.com"/>
    <meta name="robots" content="index,follow"/>
    <meta name="location" content="France"/>

    <!-- STYLESHEETS -->
    <link href="{!! asset('css/libs.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/global.css') !!}" rel="stylesheet">
</head>
<body>

    <!-- Flash Messages -->
    @include('_modules.flash_message')

    <!-- NAV -->
    <nav class="nav">

        <div class="languages">
            <a href="{{Route('language', 'fr')}}" class="flag fr"></a>
            <a href="{{Route('language', 'en')}}" class="flag en"></a>
        </div>

        <ul class="menu">
            <li><a href="{{Route('home')}}">{{Lang::get('all.nav.home')}}</a></li>
            <li>
                <a href="#">{{Lang::get('all.nav.about')}}</a>
                <ul class="sub_menu">
                    <li><a href="{{Route('page.teamspeak')}}">{{Lang::get('all.nav.teamspeak')}}</a></li>
                    <li><a href="{{Route('page.team')}}">{{Lang::get('all.nav.team')}}</a></li>
                    <li><a href="mailto:{{Config::get('aion.contactMail')}}">{{Lang::get('all.nav.contact')}}</a></li>
                </ul>
            </li>
            <li><a href="{{Route('page.rules')}}">{{Lang::get('all.nav.rules')}}</a></li>
            <li><a href="{{Route('page.rates')}}">{{Lang::get('all.nav.rates')}}</a></li>
            <li>
                <a href="#">Stats</a>
                <ul class="sub_menu">
                    <li><a href="{{Route('stats.online')}}">{{Lang::get('all.nav.online')}}</a></li>
                    <li><a href="{{Route('stats.legions')}}">{{Lang::get('all.nav.legions')}}</a></li>
                </ul>
            </li>
            <li><a href="{{ Config::get('aion.forumUrl') }}">{{Lang::get('all.nav.forum')}}</a></li>
            <li><a href="{{Route('shop')}}">{{Lang::get('all.nav.shop')}}</a></li>
        </ul>
    </nav>

    <!-- LOGO -->
    <div class="logo">
        <img class="logo" src="{!! asset('images/logo.png') !!}" alt="Logo">
    </div>

    <!-- HEADER -->
    <header class="header">

        <!-- TOP -->
        <div class="header_top">
            <div class="status">
                @foreach($serversStatus as $value)
                    <span>
                    {{Lang::get('all.layout.status_of')}} {{$value['name']}} : <span class="{{($value['status']) ? 'online' : 'offline'}}">{{($value['status']) ? 'ON' : 'OFF'}}</span>
                    </span>
                @endforeach
            </div>
            <div class="btn_user">
                @if(Session::has('connected'))
                    <a href="{{Route('user.account')}}">{{Lang::get('all.nav.account')}} ({{Session::get('user.shop_points')}} Shop's Points)</a>
                    <a href="{{Route('user.logout')}}">{{Lang::get('all.nav.logout')}}</a>
                @else
                    <a href="#" id="btn_connexion">{{Lang::get('all.nav.login')}}</a>
                    <a href="{{Route('user.subscribe')}}">{{Lang::get('all.nav.subscribe')}}</a>
                @endif
            </div>
        </div>

        <!-- USER LOGIN -->
        @include('_modules.login')

        <!-- SLIDER | SOCIAL -->
        <div class="header_bottom">

            @include('_modules.slider')

            <!-- SOCIAL -->
            <div class="social">
                <a href="{{Config::get('aion.link_facebook')}}" target="_blank" class="fa fa-facebook"></a>
                <a href="{{Config::get('aion.link_twitter')}}" target="_blank" class="fa fa-twitter"></a>
                <a href="{{Config::get('aion.link_youtube')}}" target="_blank"class="fa fa-youtube-play"></a>
            </div>

        </div>

    </header>

    <!-- BODY -->
    @yield('content')

    <!-- FOOTER -->
    <footer class="footer">
        <p>{{Lang::get('all.layout.footer_1')}}</p><br>
        @if (Session::has('connected') && Session::get('user.access_level') >= Config::get('aion.minimumAccessLevel'))
            <p><a href="{{Route('admin')}}">Administration</a></p><br>
        @endif
        <p>{{Lang::get('all.layout.footer_2')}} <a href="http://mathieuletyrant.com" target="_blank">Mathieu Le Tyrant</a></p>
    </footer>

    <!-- JAVASCRIPTS -->
    @section('javascript')
        <script type="text/javascript" src="{!! asset('js/global.js') !!}"></script>
    @show
</body>
</html>
