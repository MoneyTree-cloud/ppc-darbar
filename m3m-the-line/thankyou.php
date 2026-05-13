<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - M3M The Line</title>
    <meta http-equiv="refresh" content="3;url=https://m3m-the-line.in">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="./assets/favicon/site.webmanifest">
    <link rel="shortcut icon" href="./assets/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#1e40af">
    <meta name="theme-color" content="#1e40af">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(rgba(17, 24, 39, 0.8), rgba(17, 24, 39, 0.8)), url('./assets/hero-bg.webp');
            background-size: cover;
            background-position: center;
        }

        .thank-you-container {
            text-align: center;
            padding: 3rem 4rem;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            max-width: 450px;
            width: 90%;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #28a745;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 1.5rem;
            animation: scale-in 0.5s ease-out;
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
            fill: white;
        }

        @keyframes scale-in {
            from {
                transform: scale(0.5);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        h1 {
            color: #2c3e50;
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        p {
            color: #7f8c8d;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .redirect-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #e9ecef;
            color: #6c757d;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            position: relative;
            overflow: hidden;
            cursor: not-allowed;
        }

        .redirect-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: #28a745;
            animation: progress 3s linear forwards;
        }

        .redirect-button span {
            position: relative;
            z-index: 1;
            color: #fff;
        }

        @keyframes progress {
            from {
                width: 0%;
            }

            to {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="thank-you-container">
        <div class="success-icon">
            <svg viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
            </svg>
        </div>
        <h1>Thank You!</h1>
        <p>Your submission has been received successfully. We appreciate you contacting us.</p>
        <div class="redirect-button">
            <span>Redirecting to Homepage...</span>
        </div>
    </div>
</body>

</html>