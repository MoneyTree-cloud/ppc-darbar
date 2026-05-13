<?php
/**
 * Thank You Page — Post-Conversion
 * Fires conversion tracking pixels
 */
require_once __DIR__ . '/../config.php';
$page_title = 'Thank You | ' . PROPERTY_NAME;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1A3A5C 0%, #0f2640 100%);
            padding: 20px;
        }
        .card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(8px);
            border-radius: 16px;
            padding: 48px 40px;
            max-width: 460px;
            width: 100%;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            animation: fadeIn 0.6s ease-out;
        }
        @keyframes fadeIn { from { opacity:0; transform:scale(0.95); } to { opacity:1; transform:scale(1); } }
        @keyframes drawCheck { 0% { stroke-dashoffset:32; } 100% { stroke-dashoffset:0; } }
        .check-icon { width: 64px; height: 64px; margin: 0 auto 20px; }
        .check-circle { stroke: #22c55e; }
        .check-path { stroke-dasharray: 32; stroke-dashoffset: 32; animation: drawCheck 0.5s ease-in-out 0.3s forwards; }
        h1 { font-size: 28px; font-weight: 700; color: #1A1A2E; margin-bottom: 8px; }
        .subtitle { font-size: 16px; color: #6B7280; margin-bottom: 24px; line-height: 1.5; }
        .next-steps { background: #F7F8FA; border-radius: 12px; padding: 20px; margin-bottom: 24px; text-align: left; }
        .next-steps h3 { font-size: 14px; font-weight: 600; color: #1A3A5C; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .next-steps ul { list-style: none; }
        .next-steps li { font-size: 14px; color: #374151; padding: 6px 0; display: flex; align-items: center; gap: 8px; }
        .next-steps li::before { content: '✓'; color: #22c55e; font-weight: 700; }
        .cta-btn {
            display: inline-block;
            background: #F5A623;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            padding: 14px 28px;
            border-radius: 8px;
            text-decoration: none;
            margin: 4px;
            transition: background 0.2s;
        }
        .cta-btn:hover { background: #E09000; }
        .cta-secondary { background: #25D366; }
        .cta-secondary:hover { background: #20bd5a; }
        .redirect { font-size: 13px; color: #9CA3AF; margin-top: 20px; }
    </style>

    <!-- Google Tag Manager -->
    <?php if (GTM_ID !== 'GTM-XXXXXXX'): ?>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?= GTM_ID ?>');</script>
    <?php endif; ?>
</head>
<body>
    <?php if (GTM_ID !== 'GTM-XXXXXXX'): ?>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= GTM_ID ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php endif; ?>

    <div class="card">
        <!-- Animated Checkmark -->
        <svg class="check-icon" viewBox="0 0 24 24" fill="none">
            <circle class="check-circle" cx="12" cy="12" r="11" stroke-width="2"/>
            <path class="check-path" d="M8 12.5L10.5 15L16 9.5" stroke="#22c55e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        <h1>Thank You!</h1>
        <p class="subtitle">Your enquiry has been submitted successfully.<br>Our property expert will call you within <strong>30 minutes</strong>.</p>

        <div class="next-steps">
            <h3>What Happens Next?</h3>
            <ul>
                <li>Our expert calls you within 30 minutes</li>
                <li>Get detailed price list & payment plans</li>
                <li>Schedule a free site visit</li>
                <li>Receive exclusive deals & offers</li>
            </ul>
        </div>

        <a href="tel:<?= SITE_PHONE ?>" class="cta-btn">Call Us Now: <?= SITE_PHONE_DISPLAY ?></a>
        <a href="https://api.whatsapp.com/send?phone=<?= SITE_WHATSAPP ?>&text=Hi%20I%20just%20submitted%20an%20enquiry%20for%20<?= urlencode(PROPERTY_NAME) ?>.%20Please%20share%20details." target="_blank" class="cta-btn cta-secondary">WhatsApp Us</a>

        <p class="redirect">Redirecting to homepage in <span id="countdown">5</span> seconds...</p>
    </div>

    <!-- Conversion Tracking Scripts -->
    <script>
        // Google Ads Conversion
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}

        <?php if (GADS_CONVERSION_ID !== 'AW-XXXXXXXXX'): ?>
        gtag('event', 'conversion', {
            send_to: '<?= GADS_CONVERSION_ID ?>/<?= GADS_CONVERSION_LABEL ?>'
        });
        <?php endif; ?>

        // GTM conversion event
        dataLayer.push({ event: 'form_submission_thankyou' });

        <?php if (FB_PIXEL_ID !== ''): ?>
        // Facebook Pixel
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?= FB_PIXEL_ID ?>');
        fbq('track', 'Lead');
        <?php endif; ?>

        // Countdown redirect
        var seconds = 5;
        var el = document.getElementById('countdown');
        var timer = setInterval(function() {
            seconds--;
            el.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(timer);
                window.location.href = '<?= SITE_URL ?>';
            }
        }, 1000);
    </script>
</body>
</html>
