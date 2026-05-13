<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You | Exotica One</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/favicon/favicon.ico" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="assets/favicon/site.webmanifest" />
    <meta name="msapplication-TileColor" content="#1a3a5a" />
    <meta name="theme-color" content="#1a3a5a" />

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-900 text-white">

    <div class="relative min-h-screen flex items-center justify-center bg-cover bg-center p-4" style="background-image: url('./assets/gallery-1.webp');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <!-- Content -->
        <div class="relative z-10 text-center max-w-2xl bg-gray-800 bg-opacity-70 backdrop-blur-sm p-8 md:p-12 rounded-2xl shadow-2xl border border-gray-700">
            <svg class="w-20 h-20 mx-auto mb-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Thank You!</h1>
            <p class="text-lg md:text-xl text-gray-300 mb-8">
                Your enquiry has been received. Our team will get in touch with you shortly.
            </p>
            <div class="text-sm text-gray-400">
                <p>You will be redirected back to the homepage in <span id="countdown" class="font-bold text-green-400">3</span> seconds...</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let countdownElement = document.getElementById('countdown');
            let seconds = 2; // Start countdown from 2.5 seconds (displaying 3)

            const countdownInterval = setInterval(() => {
                countdownElement.textContent = seconds;
                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                    // Redirect to the homepage.
                    // IMPORTANT: Replace 'index.html' with the actual URL of your homepage if it's different.
                    window.location.href = './';
                }
                seconds--;
            }, 1000);

            // Initial redirect timeout
            setTimeout(() => {
                window.location.href = './';
            }, 2500);
        });
    </script>

</body>

</html>