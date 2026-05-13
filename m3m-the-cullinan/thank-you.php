<!DOCTYPE html>
<html lang="en">
<head>
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JZJY23MWW7"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-JZJY23MWW7');
</script>


<!-- Google tag (gtag.js) event -->
<script>
  gtag('event', 'form_submit', {
    // <event_parameters>
  });
</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - M3M The Cullinan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a1a1a;
            --accent-color: #c9a959;
            --secondary-color: #2c3e50;
            --light-bg: #f8f9fa;
            --dark-text: #2c3e50;
            --light-text: #ffffff;
            --cullinan-blue: #0a1a33;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(120deg, rgba(26,26,26,0.7) 60% , rgba(201,169,89,0.3)), url('./assets/bg-image2.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .thank-you-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            max-width: 600px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            margin: 20px;
        }

        .thank-you-icon {
            font-size: 4rem;
            color: var(--accent-color);
            margin-bottom: 1.5rem;
            animation: scaleIn 0.5s ease-out;
        }

        .thank-you-title {
            color: white;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .thank-you-message {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .redirect-message {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 2rem;
            background: rgba(0,0,0,0.2);
            padding: 0.8rem;
            border-radius: 10px;
            display: inline-block;
        }

        .navigation-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .nav-button {
            background: var(--accent-color);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 200px;
            justify-content: center;
        }

        .nav-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(201, 169, 89, 0.4);
            color: white;
        }

        .nav-button.secondary {
            background: transparent;
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
        }

        .nav-button.secondary:hover {
            background: var(--accent-color);
            color: white;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Tablet and smaller desktops */
        @media (max-width: 991px) {
            .thank-you-container {
                padding: 2.5rem;
                max-width: 500px;
            }

            .thank-you-title {
                font-size: 2.2rem;
            }

            .thank-you-message {
                font-size: 1.1rem;
            }
        }

        /* Mobile landscape */
        @media (max-width: 767px) {
            .thank-you-container {
                padding: 2rem;
                margin: 15px;
            }

            .thank-you-title {
                font-size: 2rem;
            }

            .thank-you-message {
                font-size: 1rem;
            }

            .nav-button {
                padding: 0.9rem 1.8rem;
                min-width: 180px;
            }
        }

        /* Mobile portrait */
        @media (max-width: 576px) {
            body {
                padding: 15px;
            }

            .thank-you-container {
                padding: 1.5rem;
                margin: 10px;
            }

            .thank-you-title {
                font-size: 1.8rem;
            }

            .thank-you-message {
                font-size: 0.95rem;
                margin-bottom: 1.5rem;
            }

            .navigation-buttons {
                flex-direction: column;
                gap: 0.8rem;
            }

            .nav-button {
                width: 100%;
                padding: 0.8rem 1.5rem;
                min-width: unset;
            }

            .thank-you-icon {
                font-size: 3rem;
                margin-bottom: 1rem;
            }
        }

        /* Small mobile devices */
        @media (max-width: 360px) {
            .thank-you-container {
                padding: 1.2rem;
            }

            .thank-you-title {
                font-size: 1.5rem;
            }

            .thank-you-message {
                font-size: 0.9rem;
            }

            .nav-button {
                padding: 0.7rem 1.2rem;
                font-size: 0.9rem;
            }
        }

        /* Ensure proper display on devices with notches */
        @supports (padding: max(0px)) {
            body {
                padding-left: max(20px, env(safe-area-inset-left));
                padding-right: max(20px, env(safe-area-inset-right));
                padding-top: max(20px, env(safe-area-inset-top));
                padding-bottom: max(20px, env(safe-area-inset-bottom));
            }
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <div class="thank-you-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="thank-you-title">Thank You!</h1>
        <p class="thank-you-message">
            Your inquiry has been received successfully. Our team will contact you shortly with the details you requested.
        </p>
        <p class="redirect-message">
            You will be redirected to the homepage in <span id="countdown">2</span> seconds...
        </p>
        <div class="navigation-buttons">
            <a href="index.php" class="nav-button">
                <i class="fas fa-home"></i> Return to Home
            </a>
            <a href="tel:+919412234688" class="nav-button secondary">
                <i class="fas fa-phone"></i> Call Us Now
            </a>
        </div>
    </div>

    <script>
        // Countdown and redirect
        let seconds = 2;
        const countdownElement = document.getElementById('countdown');
        
        const countdown = setInterval(() => {
            seconds--;
            countdownElement.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = 'index.php';
            }
        }, 1000);

        // Handle orientation changes
        window.addEventListener('orientationchange', function() {
            // Force a reflow to ensure proper rendering
            document.body.style.display = 'none';
            document.body.offsetHeight; // Force reflow
            document.body.style.display = '';
        });
    </script>
</body>
</html> 