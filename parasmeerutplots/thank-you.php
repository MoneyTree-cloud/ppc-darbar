<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Paras Meerut Plots</title>
    
      <!-- Comprehensive Favicon Support -->
    <link rel="icon" type="image/x-icon" href="assets/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="assets/favicon/android-chrome-512x512.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    
    
    <link rel="stylesheet" href="css/styles.css">
    <meta http-equiv="refresh" content="3;url=index.php">
    <style>
        .thank-you-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 20px;
        }

        .thank-you-content {
            max-width: 600px;
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .thank-you-content h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .thank-you-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .redirect-message {
            font-size: 1rem;
            opacity: 0.8;
            margin-top: 20px;
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="thank-you-container">
        <div class="thank-you-content">
            <h1>🎉 Thank You!</h1>
            <p>Your inquiry has been successfully submitted. Our team will contact you shortly with more information about Paras Meerut Plots.</p>
            <p>We appreciate your interest in our premium residential plots.</p>
            <div class="redirect-message">
                Redirecting back to homepage in 3 seconds... <span class="loading-spinner"></span>
            </div>
        </div>
    </div>

    <script>
        // Countdown timer
        let timeLeft = 3;
        const countdownElement = document.querySelector('.redirect-message');

        const countdown = setInterval(() => {
            timeLeft--;
            if (timeLeft > 0) {
                countdownElement.innerHTML = `Redirecting back to homepage in ${timeLeft} seconds... <span class="loading-spinner"></span>`;
            } else {
                countdownElement.innerHTML = 'Redirecting now... <span class="loading-spinner"></span>';
                clearInterval(countdown);
            }
        }, 1000);
    </script>
</body>

</html>