<?php
require_once __DIR__ . '/../env.php';
$siteName = env('SITE_NAME', 'Exotica One32');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Thank You | <?php echo htmlspecialchars($siteName); ?></title>

    <link rel="icon" type="image/x-icon" href="assets/favicon/favicon.ico" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png" />
    <meta name="theme-color" content="#0B1220">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background: var(--ink);
            color: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(11,18,32,.55), rgba(11,18,32,.92)),
                url("./assets/gallery-1.webp") center/cover no-repeat;
            z-index: 0;
        }
        body::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(900px 500px at 50% 20%, rgba(200,164,92,.15), transparent 60%);
            z-index: 0;
        }
        .ty-card {
            position: relative;
            z-index: 1;
            max-width: 620px;
            background: rgba(17, 26, 46, 0.75);
            border: 1px solid rgba(200, 164, 92, 0.35);
            border-top: 2px solid var(--gold);
            padding: 64px 48px;
            backdrop-filter: blur(12px);
        }
        .ty-card .eyebrow { color: var(--gold); }
        .ty-card h1 { color: var(--cream); font-size: clamp(2.25rem, 5vw, 3.5rem); margin-bottom: 1rem; }
        .ty-card p { color: rgba(239, 233, 220, 0.8); font-size: 1rem; line-height: 1.7; }
        .ty-check {
            width: 72px;
            height: 72px;
            border: 1px solid var(--gold);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            margin: 0 auto 24px;
        }
        .ty-actions {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        .countdown { font-size: .75rem; letter-spacing: .18em; text-transform: uppercase; color: rgba(239,233,220,.55); margin-top: 2rem; }
        .countdown strong { color: var(--gold); }
    </style>
</head>
<body>
    <div class="ty-card">
        <div class="ty-check">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M20 6 9 17l-5-5"/>
            </svg>
        </div>
        <span class="eyebrow">Enquiry Received</span>
        <h1>Thank you.</h1>
        <p>
            Your details have reached our investment desk. A senior advisor from
            <?php echo htmlspecialchars($siteName); ?> will call you within 24 hours
            to share the floor plans, price sheet and payment plan.
        </p>
        <div class="ty-actions">
            <a href="./" class="btn btn-ghost-light">Back to Home</a>
            <a href="tel:+919412234688" class="btn btn-primary">Call Now</a>
        </div>
        <p class="countdown">Returning home in <strong id="countdown">8</strong> seconds</p>
    </div>

    <script>
        (function(){
            let seconds = 8;
            const el = document.getElementById('countdown');
            const t = setInterval(function(){
                seconds -= 1;
                if (el) el.textContent = seconds;
                if (seconds <= 0) {
                    clearInterval(t);
                    window.location.href = './';
                }
            }, 1000);
        })();
    </script>
</body>
</html>
