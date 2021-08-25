<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>404 - {{Config::get('aion.website_name')}}</title>
    <style>
        @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);
        a:link {
            text-decoration: none;
            outline: none;
            transition: all 0.25s;
        }

        a:visited,
        a:link:hover,
        a:visited:hover {
            text-decoration: underline;
        }

        body {
            background: #fff none repeat scroll top left;
            color: #333;
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            line-height: normal;
        }

        #container404 {
            margin: 50px auto;
            max-width: 700px;
            text-align: center;
        }

        h1 {
            font-size: 200%;
            font-weight: 700;
            margin-top: 30px;
        }

        h2 {
            font-size: 120%;
            font-weight: 400;
            margin-top: 30px;
            margin-bottom: 50px;
            line-height: 1.5em;
        }

        @-webkit-keyframes thumb {
            0% {
                -webkit-transform: scale(1);
            }
            50% {
                -webkit-transform: scale(0.9);
            }
            100% {
                -webkit-transform: scale(1);
            }
        }

        #container404 img {
            -webkit-animation-name: thumb;
            -webkit-animation-duration: 200ms;
            -webkit-transform-origin: 50% 50%;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-timing-function: linear;
        }
    </style>
</head>
<body>
    <div id="container404">
        <img src="http://2.bp.blogspot.com/-WaHaYF7vMRo/VX_Cro6zTDI/AAAAAAAACdY/JMpdKqMaH6w/s1600/notfound.jpeg" id="logo404">
        <h1>Waduh... Kok gak ada sih???</h1>
        <h2>Error 404. <a href="{{Config::get('app.url')}}">Back to the website ...</a></h2>
    </div>
</body>
</html>