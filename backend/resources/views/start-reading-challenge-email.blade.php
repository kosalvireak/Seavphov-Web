@php
    $appName = config('app.name', 'Seavphov');
    $logoUrl = env('APP_LOGO_URL');
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $appName }} - Start Reading Challenge</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: center;
            justify-content: center;
        }

        .logo {
            max-width: 120px;
            margin-bottom: 16px;
        }

        .token {
            margin-top: 20px;
            background-color: #f3f4f6;
            color: #111827;
            font-weight: bold;
            padding: 12px 24px;
            font-size: 18px;
            letter-spacing: 1px;
            border-radius: 6px;
            width: fit-content;
        }

        .button {
            width: fit-content;
            margin-top: 30px;
            background-color: #5c836e;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <div class="container">
        @if ($logoUrl)
            <img src="{{ $logoUrl }}" alt="{{ $appName }} Logo" class="logo">
        @endif
        <h2>{{ $appName }}</h2>

        <h3>Ready to jump in?</h3>

        <p>Start reading <i>"{{ $bookTitle }}"</i> now!</p>

        <a href="{{ $challengeUrl }}" class="button" target="_blank">
            Start Now
        </a>

        <div class="footer">
            &copy; {{ now()->year }} {{ $appName }}. All rights reserved.
        </div>
    </div>
</body>

</html>
