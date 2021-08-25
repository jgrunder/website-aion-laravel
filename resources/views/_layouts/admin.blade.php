<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">

    <!-- SEO -->
    {!! SEO::generate() !!}
    <meta name="author" content="Mathieu Le Tyrant"/>
    <meta name="copyright" content="Copyright 2016 © MathieuLeTyrant.com"/>
    <meta name="location" content="France"/>

    <!-- STYLESHEETS -->
    <link href="{!! asset('css/admin.css') !!}" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{Route('home')}}">{{Config::get('aion.website_name')}}</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{Route('admin')}}">Home</a></li>

                    <!-- Articles -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">News <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{Route('admin.news')}}">The news</a></li>
                            <li><a href="{{Route('admin.news.add')}}">Add a news</a></li>
                        </ul>
                    </li>

                    <!-- Boutique -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{Route('admin.shop.all')}}">All items</a></li>
                            <li><a href="{{Route('admin.shop.add')}}">Add item</a></li>
                            <li><a href="{{Route('admin.shop.category')}}">Categories list</a></li>
                            <li><a href="{{Route('admin.shop.subcategory')}}">Sub-categories list</a></li>
                        </ul>
                    </li>

                    <!-- Logs -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Logs <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach($adminLogsMenu as $adminLogMenu)
                                <li><a href="{{Route('admin.logs', $adminLogMenu)}}">Log : {{$adminLogMenu}}</a></li>
                            @endforeach
                        </ul>
                    </li>

                    <!-- PAGE -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pages <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{Route('admin.page', 'joinus')}}">Edit : Join-us</a></li>
                            <li><a href="{{Route('admin.page', 'rules')}}">Edit : Rules</a></li>
                            <li><a href="{{Route('admin.page', 'team')}}">Edit : Team</a></li>
                            <li><a href="{{Route('admin.page', 'teamspeak')}}">Edit : Teamspeak</a></li>
                            <li><a href="{{Route('admin.page', 'subscribe')}}">Edit : Subscribe</a></li>
                            <li><a href="{{Route('admin.page', 'rates')}}">Edit : Rates of server</a></li>
                        </ul>
                    </li>

                    <!-- Autre -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Others <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{Route('admin.slider')}}">Slider</a></li>
                            @if(Config::get('services.pushbullet.apiKey'))
                                <li><a href="{{Route('admin.pushbullet')}}">Pushbullet</a></li>
                            @endif
                            <li><a href="{{Route('admin.add.points')}}">Add Shop's Points</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{Route('admin.points')}}">Log Shop's Points</a></li>
                            <li><a href="{{Route('admin.allopass')}}">Log Allopass</a></li>
                            <li><a href="{{Route('admin.paypal')}}">Log Paypal</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Search Function -->
                {!! Form::open(['class' => 'navbar-form navbar-right', 'url' => Route('admin.search'), 'method' => 'get']) !!}

                <div class="form-group">
                    {!! Form::select('search_type', ['character' => 'Characters', 'shop_item_name' => 'Shop (Name)', 'shop_item_id' => 'Shop (ID)'], null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::text('search_value', null, ['placeholder' => "Name", 'class' => 'form-control']) !!}
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JAVASCRIPTS -->
    <script type="text/javascript" src="{!! asset('js/ckeditor/ckeditor.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/admin.js') !!}"></script>
</body>
</html>