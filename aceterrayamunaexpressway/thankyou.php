<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You | Ace Terra</title>

    <!-- Redirect to homepage after 5 seconds. -->
    <meta http-equiv="refresh" content="5;url=index.php">

    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Playfair Display for headings, Inter for body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500&display=swap" rel="stylesheet">

    <style>
        /* Custom CSS for the new elite theme and animations */
        body {  
            font-family: 'Inter', sans-serif;
            /* Using a high-quality, dark wood background image for a premium, 'woody' look */
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('./assets/image1.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow: hidden;
            /* Prevents scrollbars during animations */
        }

        .elite-card {
            /* Refined Glassmorphism effect */
            background: rgba(30, 30, 30, 0.65);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            /* For Safari */
            border: 1px solid rgba(255, 255, 255, 0.15);

            /* Initial state for card animation */
            opacity: 0;
            transform: scale(0.95) translateY(20px);
            animation: card-reveal 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.2s forwards;
        }

        /* Card reveal animation */
        @keyframes card-reveal {
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Staggered text reveal animation */
        .animated-text {
            opacity: 0;
            transform: translateY(20px);
            animation: text-reveal 0.7s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        @keyframes text-reveal {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* A rich, woody, coppery-gold color inspired by the reference */
        .copper-gold-text {
            color: #B99470;
        }

        .copper-gold-glow {
            /* A soft glow effect with the new accent color */
            filter: drop-shadow(0 0 20px rgba(185, 148, 112, 0.6));
        }

        .heading-font {
            font-family: 'Playfair Display', serif;
        }

        /* Checkmark animations with updated accent color */
        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2.5;
            stroke-miterlimit: 10;
            stroke: #B99470;
            /* New accent color */
            fill: none;
            /* Animation delay adjusted for new sequence */
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) 1s forwards;
        }

        .checkmark {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: block;
            stroke-width: 3;
            stroke: #fff;
            stroke-miterlimit: 10;
            margin: 0 auto 24px;
            box-shadow: inset 0px 0px 0px #B99470;
            /* New accent color */
            animation: fill .4s ease-in-out 1.4s forwards, scale .3s ease-in-out 1.7s both;
        }

        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.4s cubic-bezier(0.65, 0, 0.45, 1) 1.6s forwards;
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes scale {

            0%,
            100% {
                transform: none;
            }

            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }

        @keyframes fill {
            100% {
                box-shadow: inset 0px 0px 0px 40px #B99470;
                /* New accent color */
            }
        }
    </style>
</head>

<body class="text-gray-300">
    <div class="flex items-center justify-center min-h-screen p-4">

        <!-- Elite Thank You Card with Wood & Gold Theme -->
        <div class="elite-card w-full max-w-lg p-10 space-y-6 text-center shadow-2xl rounded-3xl">

            <!-- Animated Copper-Gold Checkmark -->
            <div class="copper-gold-glow animated-text" style="animation-delay: 0.8s;">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                </svg>
            </div>

            <!-- Main Heading with Elegant Font -->
            <h1 class="heading-font text-5xl font-bold copper-gold-text animated-text" style="animation-delay: 1.8s;">
                Thank You
            </h1>

            <!-- Supporting Text with refined wording -->
            <p class="text-lg text-gray-300 animated-text" style="animation-delay: 2s;">
                Your enquiry has been successfully submitted. <br> We appreciate your interest in the unparalleled luxury of Ace Terra.
            </p>

            <!-- Countdown and Redirect Message -->
            <div class="pt-4 text-base text-gray-500 animated-text" style="animation-delay: 2.2s;">
                You will be redirected to our homepage in <span id="countdown" class="font-bold copper-gold-text">5</span> seconds...
            </div>
        </div>
    </div>

    <script>
        // --- Countdown Timer ---
        let countdownElement = document.getElementById('countdown');
        let seconds = 5;

        countdownElement.textContent = seconds;

        const interval = setInterval(() => {
            seconds--;
            if (seconds > 0) {
                countdownElement.textContent = seconds;
            } else {
                countdownElement.textContent = 0;
                clearInterval(interval);
            }
        }, 1000);
    </script>
</body>

</html>