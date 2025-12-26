<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
    <style>
        /* Styles must be inline or in <style> for email compatibility */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 0;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .otp {
            font-size: 28px;
            font-weight: bold;
            color: #2d3748;
            letter-spacing: 5px;
            text-align: center;
            margin: 30px 0;
        }

        .footer {
            font-size: 12px;
            color: #888888;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h4>Hello ,{{$user->name}}</h4>
        <h2 style="text-align:center; color:#2b6cb0;">Your OTP </h2>
        <p style="text-align:center;">Use the OTP below to complete your verification process. This OTP is valid for 5
            minutes.</p>
        <div class="otp">{{$user->otp }}</div>
        <p style="text-align:center;">If you didn’t request this, please ignore this email.</p>
        <div class="footer">

            @if (isset($system_setting))
                &copy; {{ date('Y') }} {{ $system_setting->title }}. All rights reserved.
            @endif
        </div>
    </div>
</body>

</html>
