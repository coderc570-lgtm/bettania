<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Verification</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Open+Sans:wght@400;600&display=swap');

        body {
            font-family: 'Open Sans', Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 4px 16px rgba(0,0,0,0.08);
        }
        .header {
            background: #18411D;
            color: #ffffff;
            text-align: center;
            padding: 35px 20px;
        }
        .header h1 {
            font-family: 'Playfair Display', serif;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .tagline {
            font-size: 14px;
            margin-top: 8px;
            font-style: italic;
            opacity: 0.9;
        }
        .body {
            padding: 40px 30px;
            text-align: center;
            color: #333333;
        }
        .body h2 {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            margin-bottom: 25px;
            color: #18411D;
        }
        .verification-code {
            font-size: 34px;
            font-weight: bold;
            font-family: 'Playfair Display', serif;
            color: #286C31;
            margin: 25px 0;
            letter-spacing: 6px;
        }
        .body p {
            font-size: 15px;
            margin: 14px 0;
            line-height: 1.7;
            color: #555555;
        }
        .footer {
            background: #f4f4f4;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #777777;
        }
        .footer a {
            color: #18411D;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Bettania Suits</h1>
            <p class="tagline">Tailoring Confidence. Stitch by Stitch.</p>
        </div>

        <!-- Body -->
        <div class="body">
            <h2>Your Login Verification Code</h2>
            <p>Dear {{ trim($user->first_name . ' ' . ($user->middle_name ? $user->middle_name . ' ' : '') . $user->last_name) ?? 'Valued Client' }},</p>
            <p>To keep your account secure, please use the code below to complete your login:</p>
            
            <div class="verification-code">
                {{ $code }}
            </div>

            <p>This code will expire in <strong>10 minutes</strong>.  
               If you didn’t request this login, you may safely ignore this email.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Bettania Suits. All rights reserved.</p>
            <p>
                <a href="{{ url('/') }}">Visit Bettania Suits</a>
            </p>
        </div>
    </div>
</body>
</html>
