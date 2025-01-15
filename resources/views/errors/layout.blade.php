<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('error_title', 'Error Page')</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f7f7f7;
            color: #333;
            text-align: center;
        }

        #error-container {
            max-width: 600px;
            padding: 20px;
        }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            color: #ff6b6b;
            letter-spacing: -5px;
        }

        .error-code span {
            color: #333;
        }

        .error-message {
            font-size: 1.5rem;
            margin: 20px 0;
        }

        .error-description {
            margin: 20px 0;
            font-size: 1rem;
            color: #666;
        }

        .btn-container {
            margin-top: 30px;
        }

        .btn {
            text-decoration: none;
            color: #fff;
            background: #333;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #ff6b6b;
        }
    </style>
</head>
<body>
    <div id="error-container">
        <div class="error-code">
            @yield('error_code', '000')
        </div>
        <div class="error-message">
            @yield('error_message', 'Oops! Something went wrong')
        </div>
        <div class="error-description">
            @yield('error_description', 'An unexpected error occurred. Please try again later.')
        </div>
    </div>
</body>
</html>
