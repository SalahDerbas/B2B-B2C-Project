<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transform: scale(0.8);
            animation: popIn 0.5s ease-out forwards;
        }
        .error-icon {
            font-size: 80px;
            color: #e63946;
            margin-bottom: 20px;
            animation: pulse 1.5s infinite;
        }
        .title {
            font-size: 28px;
            font-weight: bold;
            color: #2b2d42;
            margin-bottom: 10px;
        }
        .message {
            font-size: 18px;
            color: #555;
            margin-bottom: 25px;
        }
        .retry-button {
            display: inline-block;
            padding: 12px 25px;
            font-size: 18px;
            color: #ffffff;
            background-color: #e63946;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s, background-color 0.3s;
        }
        .retry-button:hover {
            background-color: #b71c1c;
            transform: scale(1.05);
        }

        @keyframes popIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-icon">&#128683;</div>
        <div class="title">Payment Failed</div>
        <div class="message">Unfortunately, your payment could not be processed. Please try again or contact support for help.</div>
    </div>
</body>
</html>
