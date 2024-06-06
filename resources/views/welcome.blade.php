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
            background: url('{{ asset('img/welcoma.png') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .top-right {
            position: absolute;
            top: 25px;
            right: 25px;
            z-index: 999;
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
        /* Rounded blue button styles */
        .login-button {
            position: absolute;
            bottom: 150px;
            left: -600px;
            padding: 20px 36px;
            background-color: #00337C;
            color: white;
            border-radius: 25px;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-weight :bold;
        }
        .login-button:hover {
            background-color: #0056b3;
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
                    <a href="{{ route('login') }}"></a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"></a>
                    @endif
                @endauth
            </div>
        </div>
    @endif

    <!-- Rounded blue button -->
    
    <a href="{{ route('login') }}"class="login-button">Login Now</a>
</body>
</html>
