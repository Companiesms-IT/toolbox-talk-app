<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #4f46e5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $title }}</h1>
    </div>

    <div class="content">
        <p>Hello {{ $user->name }},</p>

        <p>{{ $body }}</p>

        @if($actionUrl)
        <a href="{{ $actionUrl }}" class="button">
            {{ $actionText }}
        </a>
        @endif

        <p>If you have any questions, please contact our support team.</p>
    </div>

    <div class="footer">
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</body>

</html>