<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: black;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .links > a {
                color: black;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            
            p {
                color:black;
            }
        </style>
    </head>
    <body>
                <p>
                    Artist Single-Page App.
                <ul>
                    <li>REST API in PHP
                        <ul>
                            <li>Laravel 5.4 framework
                            <li>Token authorization (using signed Google OAuth ID token)
                            <li>Custom authorization middleware that verifies Google OAuth ID token
                        </ul>
                    </li>
                    <li>JavaScript
                        <ul>
                            <li>BackboneJS
                            <li>RequireJS 2.0
                            <li>Google API client
                        </ul>
                    </li>
                </ul>
                </p>
        <div class="flex-center position-ref">


            <div class="content">
                <div class="links">
                    <a href="http://localhost:8000/index.html" target="_blank" rel="nofollow">App (port 8000)</a>
                    <a href="docs-api" target="_blank" rel="nofollow">API documentation</a>
                    <a href="docs/index.html" target="_blank" rel="nofollow">PHP API Classes Documentation</a>
                    <p>
App must be on localhost and port 8000 or 8200 for google oauth certificates to work.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
