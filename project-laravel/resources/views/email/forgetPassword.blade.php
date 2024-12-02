<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-body {
            font-size: 16px;
            color: #333333;
            line-height: 1.5;
        }
        .email-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777777;
        }
        .reset-button {
            display: inline-block;
            background-color: #4CAF50;
            color: #ffffff;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .reset-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="email-body">
            <p>Hello,</p>
            <p>We received a request to reset your password. You can reset it by clicking the link below:</p>
            <a href="{{ URL::to('/reset-password/' . $token) }}" class="reset-button">Reset Password</a>
            <p>If you did not request a password reset, please ignore this email.</p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Your App Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

