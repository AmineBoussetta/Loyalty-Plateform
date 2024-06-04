<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background: url('{{ asset('img/welcome.png') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .top-right {
            position: absolute;
            top: 25px;
            right: -700px;
        }
        .top-right a {
            color: white;
            padding: 0 15px;
            font-size: 17px;
            font-weight: 400;
            text-decoration: none;
            text-transform: uppercase;
        }
        .top-right a:hover {
            text-decoration: underline;
        }
        .links {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    @if (Route::has('login'))
        <div class="top-right">
            <div class="links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Log in</a>
                    
                @endauth
            </div>
        </div>
    @endif
</body>
</html>
