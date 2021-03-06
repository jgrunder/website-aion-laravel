<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">

    <!-- SEO -->
    {!! SEO::generate() !!}

    <style>
    body {
        margin: 0;
        overflow: hidden;
    }
    header {
        margin-top: -16px;
    }
    /**
     * bxSlider v4.2.5
     * Copyright 2013-2015 Steven Wanderski
     * Written while drinking Belgian ales and listening to jazz

     * Licensed under MIT (http://opensource.org/licenses/MIT)
     */
    /** VARIABLES
    ===================================*/
    /** RESET AND LAYOUT
    ===================================*/
    .bx-wrapper {
      position: relative;
      margin: 0 auto 60px;
      padding: 0;
      *zoom: 1;
      -ms-touch-action: pan-y;
      touch-action: pan-y;
    }

    .bx-wrapper img {
      max-width: 100%;
      display: block;
    }

    .bxslider {
      margin: 0;
      padding: 0;
    }

    ul.bxslider {
      list-style: none;
    }

    .bx-viewport {
      /*fix other elements on the page moving (on Chrome)*/
      -webkit-transform: translatez(0);
      height: 400px !important;
    }

    /** THEME
    ===================================*/
    .bx-wrapper .bx-pager,
    .bx-wrapper .bx-controls-auto {
      position: absolute;
      bottom: -30px;
      width: 100%;
    }

    /* LOADER */
    .bx-wrapper .bx-loading {
      min-height: 50px;
      height: 100%;
      width: 100%;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 2000;
    }

    /* PAGER */
    .bx-wrapper .bx-pager {
      text-align: center;
      font-size: 0.85em;
      font-family: Arial;
      font-weight: bold;
      color: #666;
      padding-top: 20px;
    }

    .bx-wrapper .bx-pager.bx-default-pager a {
      background: #666;
      text-indent: -9999px;
      display: block;
      width: 10px;
      height: 10px;
      margin: 0 5px;
      outline: 0;
      -moz-border-radius: 5px;
      -webkit-border-radius: 5px;
      border-radius: 5px;
    }

    .bx-wrapper .bx-pager.bx-default-pager a:hover,
    .bx-wrapper .bx-pager.bx-default-pager a.active,
    .bx-wrapper .bx-pager.bx-default-pager a:focus {
      background: #000;
    }

    .bx-wrapper .bx-pager-item,
    .bx-wrapper .bx-controls-auto .bx-controls-auto-item {
      display: inline-block;
      *zoom: 1;
      *display: inline;
    }

    .bx-wrapper .bx-pager-item {
      font-size: 0;
      line-height: 0;
    }

    /* DIRECTION CONTROLS (NEXT / PREV) */
    .bx-wrapper .bx-prev {
      left: 10px;
      background: url("images/controls.png") no-repeat 0 -32px;
    }

    .bx-wrapper .bx-prev:hover,
    .bx-wrapper .bx-prev:focus {
      background-position: 0 0;
    }

    .bx-wrapper .bx-next {
      right: 10px;
      background: url("images/controls.png") no-repeat -43px -32px;
    }

    .bx-wrapper .bx-next:hover,
    .bx-wrapper .bx-next:focus {
      background-position: -43px 0;
    }

    .bx-wrapper .bx-controls-direction a {
      position: absolute;
      top: 50%;
      margin-top: -16px;
      outline: 0;
      width: 32px;
      height: 32px;
      text-indent: -9999px;
      z-index: 9999;
    }

    .bx-wrapper .bx-controls-direction a.disabled {
      display: none;
    }

    /* AUTO CONTROLS (START / STOP) */
    .bx-wrapper .bx-controls-auto {
      text-align: center;
    }

    .bx-wrapper .bx-controls-auto .bx-start {
      display: block;
      text-indent: -9999px;
      width: 10px;
      height: 11px;
      outline: 0;
      background: url("images/controls.png") -86px -11px no-repeat;
      margin: 0 3px;
    }

    .bx-wrapper .bx-controls-auto .bx-start:hover,
    .bx-wrapper .bx-controls-auto .bx-start.active,
    .bx-wrapper .bx-controls-auto .bx-start:focus {
      background-position: -86px 0;
    }

    .bx-wrapper .bx-controls-auto .bx-stop {
      display: block;
      text-indent: -9999px;
      width: 9px;
      height: 11px;
      outline: 0;
      background: url("images/controls.png") -86px -44px no-repeat;
      margin: 0 3px;
    }

    .bx-wrapper .bx-controls-auto .bx-stop:hover,
    .bx-wrapper .bx-controls-auto .bx-stop.active,
    .bx-wrapper .bx-controls-auto .bx-stop:focus {
      background-position: -86px -33px;
    }

    /* PAGER WITH AUTO-CONTROLS HYBRID LAYOUT */
    .bx-wrapper .bx-controls.bx-has-controls-auto.bx-has-pager .bx-pager {
      text-align: left;
      width: 80%;
    }

    .bx-wrapper .bx-controls.bx-has-controls-auto.bx-has-pager .bx-controls-auto {
      right: 0;
      width: 35px;
    }

    /* IMAGE CAPTIONS */
    .bx-wrapper .bx-caption {
      position: absolute;
      bottom: 0;
      left: 0;
      background: #666;
      background: rgba(80, 80, 80, 0.75);
      width: 940px;
    }

    .bx-caption {
      height: 50px;
      background-color: rgba(0, 0, 0, 0.5) !important;
      color: white;
      border-bottom-right-radius: 5px;
      border-bottom-left-radius: 5px;
    }
    .bx-caption span {
      font-size: 16px !important;
      padding: 0px !important;
      padding-left: 15px !important;
      position: relative;
      top: 17px;
    }

    .bx-wrapper .bx-caption span {
      color: #fff;
      font-family: Arial;
      display: block;
      font-size: 0.85em;
      padding: 10px;
    }

    .bx-wrapper img {
      border-bottom-right-radius: 5px;
      border-bottom-left-radius: 5px;
    }
    </style>

</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <!-- SLIDER | SOCIAL -->
        <div class="header_bottom">
            @include('_api.slider')
        </div>
    </header>
    <!-- JAVASCRIPTS -->
    @section('javascript')
		<script type="text/javascript" src="{!! asset('js/libs.js') !!}"></script>
		<script type="text/javascript" src="{!! asset('js/global.js') !!}"></script>
    @show
</body>
</html>
