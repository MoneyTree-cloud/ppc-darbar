<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - 3BHK in Noida</title>
    <!-- Favicon matching the theme -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>👑</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'cream-bg': '#F8F5F2',
                        'off-white': '#FEFCF8',
                        'gold': '#B99769',
                        'gold-secondary': '#D8C6B1',
                        'charcoal-dark': '#1a1a1a',
                        'charcoal-light': '#2C2C2C'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap');

        :root {
            --gold-primary: #B99769;
            --gold-secondary: #D8C6B1;
            --charcoal-dark: #1a1a1a;
            --charcoal-light: #2C2C2C;
            --cream-bg: #F8F5F2;
            --off-white: #FEFCF8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--cream-bg);
            color: var(--charcoal-dark);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .heading-serif {
            font-family: 'Playfair Display', serif;
        }

        .text-gold {
            color: var(--gold-primary);
        }

        .bg-gold {
            background-color: var(--gold-primary);
        }

        /* Main container animation */
        .thank-you-animation {
            animation: fadeIn 2s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Checkmark drawing animation */
        .checkmark-path {
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            animation: draw-checkmark 1s ease-in-out 0.5s forwards;
        }

        @keyframes draw-checkmark {
            100% {
                stroke-dashoffset: 0;
            }
        }

        /* Subtle pulse animation for the ring */
        .pulse-ring {
            animation: pulse-subtle 2.5s ease-out infinite;
        }

        @keyframes pulse-subtle {
            0% {
                transform: scale(0.9);
                opacity: 0.7;
            }

            70% {
                transform: scale(1.4);
                opacity: 0;
            }

            100% {
                opacity: 0;
            }
        }

        /* Gentle floating animation for the title */
        .floating-title {
            animation: float-gentle 4s ease-in-out infinite;
        }

        @keyframes float-gentle {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        /* Button styling */
        .btn-primary {
            background-color: var(--gold-primary);
            color: white;
            position: relative;
            overflow: hidden;
            transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s;
        }

        .btn-primary:hover {
            background-color: #bfa77a;
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 10px 24px 0 rgba(185, 151, 105, 0.18);
        }

        /* Parallax Background */
        .thank-you-parallax {
            background-image: url('./assets/image1.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            position: relative;
        }

        .thank-you-parallax::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(26, 26, 26, 0.7);
            z-index: 1;
        }

        .thank-you-content {
            position: relative;
            z-index: 2;
        }

        @media (max-width: 768px) {
            .thank-you-parallax {
                background-attachment: scroll;
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 overflow-hidden thank-you-parallax">

    <div class="thank-you-animation text-center max-w-2xl mx-auto thank-you-content">
        <!-- Success Icon with Gold Pulse Ring -->
        <div class="relative mb-8 w-24 h-24 mx-auto">
            <div class="pulse-ring absolute inset-0 border-2 border-gold rounded-full"></div>
            <div class="relative bg-gold/10 border border-gold rounded-full w-full h-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path class="checkmark-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <!-- Thank You Message -->
        <div class="floating-title">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 text-gold heading-serif">
                Thank You!
            </h1>
        </div>
        <p class="text-xl text-charcoal-light mb-8">
            Your inquiry has been successfully submitted.
        </p>

        <!-- Message Box -->
        <div class="bg-white/80 backdrop-blur-sm rounded-lg p-8 mb-8 border border-gold/20 shadow-lg">
            <p class="text-lg text-charcoal-dark mb-4">
                We have received your details and our Executive will connect with you shortly.
            </p>
            <p class="text-sm text-charcoal-light">
                Get ready to explore your dream 3BHK residence in Noida!
            </p>
        </div>


        <!-- Countdown and Redirect -->
        <div class="text-center">
            <p class="text-lg mb-4 text-charcoal-light">
                Redirecting to homepage in <span id="countdown" class="font-bold text-gold">3</span>...
            </p>
            <a href="index.php" class="btn btn-primary inline-block px-8 py-3 rounded-lg font-semibold">
                Go to Homepage
            </a>
        </div>
    </div>

    <script>
        // --- REDIRECT COUNTDOWN ---
        let timeLeft = 3;
        const countdownElement = document.getElementById('countdown');
        // Set the URL for the homepage.
        const homepageUrl = 'index.php';

        const timer = setInterval(() => {
            timeLeft--;
            if (countdownElement) {
                countdownElement.textContent = timeLeft;
            }

            if (timeLeft <= 0) {
                clearInterval(timer);
                window.location.href = homepageUrl;
            }
        }, 1000);
    </script>
</body>

</html>