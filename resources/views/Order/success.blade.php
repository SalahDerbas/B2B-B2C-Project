<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        .container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 50%;
            width: 100%;
        }
        h1 {
            color: #28a745;
            font-size: 2em;
            margin-bottom: 10px;
        }
        p {
            color: #555;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    @php
    $sims = collect($data['sims'])[0];
    @endphp
<div class="container">
    <h1>Payment Successful!</h1>
    <p>Information Data</p>
    <table border="1" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th style="padding: 8px;text-align: center;">Key</th>
                <th style="padding: 8px;text-align: center;">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 8px;">Validity</td>
                <td style="padding: 8px;">{{ $data['validity'] }} Days</td>
            </tr>
            <tr>
                <td style="padding: 8px;">Package</td>
                <td style="padding: 8px;">{{ $data['package'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px;">Data</td>
                <td style="padding: 8px;">{{ $data['data'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px;">Manual Installation</td>
                <td style="padding: 8px;">{!! $data['manual_installation'] !!}</td>
            </tr>
            <tr>
                <td style="padding: 8px;">QR Code Installation</td>
                <td style="padding: 8px;">{!! $data['qrcode_installation'] !!}</td>
            </tr>


            <tr>
                <td style="padding: 8px;">ICCID</td>
                <td style="padding: 8px;">{{ $sims->iccid }}</td>
            </tr>
            <tr>
                <td style="padding: 8px;">QR Code</td>
                <td style="padding: 8px;">{{ $sims->qrcode }}</td>
            </tr>
            <tr>
                <td style="padding: 8px;">QR Code Scan</td>
                <td style="padding: 8px;"><img src="{{  $sims->qrcode_url  }}" height="200" width="200" /> </td>
            </tr>
            <tr>
                <td style="padding: 8px;">Direct APPLE Installation </td>
                <td style="padding: 8px;"><a href="{{  $sims->direct_apple_installation_url  }}" > CLICK</a> </td>
            </tr>
        </tbody>
    </table>
    </div>
</body>
</html>
