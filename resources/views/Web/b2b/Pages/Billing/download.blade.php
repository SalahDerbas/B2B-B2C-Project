<!DOCTYPE html>
<html>
<head>
    <title>Billing PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }

        .info {
            margin: 20px 0;
        }

        .info p {
            font-size: 16px;
            line-height: 1.6;
        }

        .info p strong {
            color: #000;
        }

        .invoice-details {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        .invoice-details th, .invoice-details td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .invoice-details th {
            background-color: #f8f8f8;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }

        .highlight {
            color: #007BFF;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Billing Information</div>

        <div class="info">
            <p><strong>Billing Number:</strong> <span class="highlight">{{ $data['number_id'] ?? 'N/A' }}</span></p>
            <p><strong>Issue Date:</strong> <span>{{ $data['issue_date'] ?? 'N/A' }}</span></p>
            <p><strong>Due Date:</strong> <span>{{ $data['due_date'] ?? 'N/A' }}</span></p>
            <p><strong>User Email:</strong> <span>{{ $data['getUser']['email'] ?? 'N/A' }}</span></p>
            <p><strong>Amount:</strong> <span class="highlight">${{ $data['amount'] ?? 'N/A' }}</span></p>
            <p><strong>Payment:</strong> <span>{{ $data['getPayment']['name'] ?? 'N/A' }}</span></p>
            <p><strong>Status:</strong> <span>{{ $data['getStatus']['value'] ?? 'N/A' }}</span></p>
        </div>

        <table class="invoice-details">
            <tr>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <!-- Example Row -->
            <tr>
                <td>Product/Service Name</td>
                <td>1</td>
                <td>${{ $data['amount'] ?? 'N/A' }}</td>
                <td>${{ $data['amount'] ?? 'N/A' }}</td>
            </tr>
            <!-- Additional rows can be added dynamically -->
        </table>

        <div class="text-center text-md-left">
            <p class="mb-0"> &copy; Copyright 2025 @sd-softwares Salah Derbas All Rights Reserved</p>
        </div>
</div>
</body>
</html>
