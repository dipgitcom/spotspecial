<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f9fc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .email-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .email-header h2 {
            color: #4A90E2;
            margin-bottom: 10px;
        }

        .otp-box {
            font-size: 28px;
            font-weight: bold;
            color: #4A90E2;
            text-align: center;
            border: 2px dashed #4A90E2;
            padding: 15px;
            margin: 30px 0;
            letter-spacing: 6px;
            background-color: #f0f6ff;
            border-radius: 8px;
        }

        .email-body {
            font-size: 16px;
            line-height: 1.6;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <div class="email-header">
            <h2>Password Reset OTP</h2>
            <p>Hello {{ $user->name ?? 'User' }},</p>
        </div>

        <div class="email-body">
            <p>Your One-Time Password (OTP) for resetting your password is:</p>

            <div class="otp-box">
                {{ $user->otp ?? 'XXXXXX' }}
            </div>

            <p>This code will expire in <strong>1 minute</strong>.</p>
            <p>If you did not request this, please ignore this email.</p>
        </div>

        <div class="footer">
            &copy; {{ now()->year }} YourAppName. All rights reserved.
        </div>
    </div>

</body>
</html>
