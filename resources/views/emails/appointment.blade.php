<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .details {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .footer {
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">Appointment Update</div>
        <div class="details">
            <p>Dear {{ $details['name'] }},</p>
            <p>{{ $details['message'] }}</p>
            <p><strong>Date:</strong> {{ $details['appointment_date'] }}</p>
            <p><strong>Doctor:</strong> {{ $details['doctor'] }}</p>
            <p><strong>Status:</strong> {{ ucfirst($details['status']) }}</p>
        </div>
        <div class="footer">
            <p>Thank you for using our service.</p>
        </div>
    </div>
</body>
</html>
