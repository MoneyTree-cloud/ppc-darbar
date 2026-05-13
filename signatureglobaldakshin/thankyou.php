<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You!</title>
    <!-- Tailwind CSS for modern styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Define the body font and a simple fade-in animation */
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Keyframes for the checkmark animation */
        @keyframes draw-check {
            0% {
                stroke-dashoffset: 32;
            }

            100% {
                stroke-dashoffset: 0;
            }
        }

        /* Class to apply the animation */
        .checkmark__check {
            stroke-dasharray: 32;
            stroke-dashoffset: 32;
            animation: draw-check 0.5s ease-in-out 0.5s forwards;
        }

        /* Keyframes for fade-in effect */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Class to apply the fade-in animation */
        .animate-fade-in {
            animation: fade-in 0.7s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gray-200 ">
    <!-- Background Image Container -->
    <!-- The background image is applied here. It covers the entire screen. -->
    <!-- Added a semi-transparent overlay for better text readability. -->
    <div class="relative p-4 min-h-screen w-full flex items-center justify-center bg-cover bg-center" style="background-image: url('assets/image1.webp');">
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Thank You Card -->
        <div class="relative z-10 w-full max-w-md p-8 sm:p-12 bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl text-center animate-fade-in">

            <!-- Animated Checkmark Icon -->
            <div class="mx-auto mb-6 h-16 w-16">
                <svg class="h-full w-full" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="11" stroke="#22c55e" stroke-width="2" />
                    <path class="checkmark__check" d="M8 12.5L10.5 15L16 9.5" stroke="#22c55e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            <!-- Main Heading -->
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3">Thank You!</h1>

            <!-- Subtext -->
            <p class="text-gray-600 text-base sm:text-lg mb-8">
                Your details have been submitted successfully.
                <br>We will be in touch shortly.
            </p>

            <!-- Redirect Message with Countdown -->
            <p class="text-gray-500 text-sm">
                Redirecting to the homepage in <span id="countdown" class="font-semibold">5</span> seconds...
            </p>
        </div>
    </div>

    <!-- JavaScript for Countdown and Redirect -->
    
    
    
    
    <script>
    // Set the redirect URL here
    const redirectUrl = 'https://signatureglobaldakshin.in/';
    let countdownElement = document.getElementById('countdown');
    let seconds = 4; // Start countdown from 4

    // Function to update the countdown every second
    const countdownTimer = setInterval(() => {
        seconds--;
        countdownElement.textContent = seconds;

        // When the countdown reaches zero, redirect and stop the timer
        if (seconds <= 0) {
            clearInterval(countdownTimer);
            window.location.href = redirectUrl;
        }
    }, 1000);
</script>
</body>

</html>