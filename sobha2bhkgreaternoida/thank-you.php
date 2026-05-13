<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Sobha Greater Noida</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    <link rel="shortcut icon" href="assets/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#d3a538">
    <meta name="theme-color" content="#d3a538">

    <link rel="stylesheet" href="css/style.css">
    <style>
        .thank-you-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .thank-you-card {
            background: white;
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        .thank-you-icon {
            font-size: 4rem;
            color: #00A884;
            margin-bottom: 1.5rem;
        }

        .thank-you-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .thank-you-message {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .redirect-message {
            color: #888;
            font-size: 0.9rem;
        }

        .countdown {
            color: #d3a538;
            font-weight: 600;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="thank-you-container">
        <div class="thank-you-card">
            <i class="fas fa-check-circle thank-you-icon"></i>
            <h1 class="thank-you-title">Thank You!</h1>
            <p class="thank-you-message">
                Thank you for your interest in Sobha Greater Noida. Our team will contact you shortly to discuss your requirements.
            </p>
            <p class="redirect-message">
                You will be redirected back to the homepage in <span class="countdown">5</span> seconds...
            </p>
        </div>
    </div>

    <script>
        // Countdown and redirect
        let count = 3;
        const countdownElement = document.querySelector('.countdown');

        const countdown = setInterval(() => {
            count--;
            countdownElement.textContent = count;

            if (count <= 0) {
                clearInterval(countdown);
                window.location.href = 'index.php';
            }
        }, 1000);
    </script>
</body>

</html>