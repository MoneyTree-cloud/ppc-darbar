<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}

$utm = getUTMParams();
$csrf_token = generateCSRFToken();

// Dynamic headline from URL (message match)
$default_headline = $page_headline ?? PROPERTY_NAME . ' — ' . PROPERTY_TYPE . ' in ' . PROPERTY_LOCATION;
$headline = isset($_GET['headline']) ? sanitize($_GET['headline']) : $default_headline;

// Page meta
$page_title       = $page_title ?? PROPERTY_NAME . ' ' . PROPERTY_LOCATION . ' | ' . PROPERTY_TYPE . ' — ' . PROPERTY_PRICE_START . ' Onwards';
$page_description = $page_description ?? 'Invest in ' . PROPERTY_NAME . ', ' . PROPERTY_LOCATION . ' by ' . PROPERTY_DEVELOPER . '. Premium commercial retail & office spaces. RERA registered. Call ' . SITE_PHONE_DISPLAY . ' for best deals.';
$page_url         = $page_url ?? SITE_URL . $_SERVER['REQUEST_URI'];
$page_image       = $page_image ?? SITE_URL . '/assets/img/hero.webp';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Primary Meta -->
    <title><?= sanitize($page_title) ?></title>
    <meta name="description" content="<?= sanitize($page_description) ?>">
    <link rel="canonical" href="<?= sanitize($page_url) ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= sanitize($page_title) ?>">
    <meta property="og:description" content="<?= sanitize($page_description) ?>">
    <meta property="og:url" content="<?= sanitize($page_url) ?>">
    <meta property="og:site_name" content="<?= SITE_NAME ?>">
    <meta property="og:image" content="<?= sanitize($page_image) ?>">
    <meta property="og:locale" content="en_IN">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= sanitize($page_title) ?>">
    <meta name="twitter:description" content="<?= sanitize($page_description) ?>">
    <meta name="twitter:image" content="<?= sanitize($page_image) ?>">

    <!-- Geo Meta Tags (Local SEO) -->
    <meta name="geo.region" content="IN-HR">
    <meta name="geo.placename" content="Sector 85, Gurugram, Haryana">
    <meta name="geo.position" content="28.4089;76.9450">
    <meta name="ICBM" content="28.4089, 76.9450">

    <!-- Language & Region -->
    <link rel="alternate" hreflang="en-in" href="<?= sanitize($page_url) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= sanitize($page_url) ?>">

    <!-- Additional SEO Meta -->
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="author" content="<?= PROPERTY_DEVELOPER ?>">
    <meta name="classification" content="Commercial Real Estate">
    <meta name="topic" content="Commercial Property Investment in Gurgaon">

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://www.googletagmanager.com">

    <!-- Fonts: Playfair Display (serif headings) + DM Sans (body) -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Critical CSS (inlined) -->
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        ul, ol { list-style: none; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', system-ui, -apple-system, sans-serif;
            font-size: 16px;
            line-height: 1.7;
            color: #2A2A2A;
            background: #FAF8F5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        img { max-width: 100%; height: auto; display: block; }
        a { color: #8B6F4E; text-decoration: none; transition: color 0.3s; }
        a:hover { color: #2A2A2A; }

        /* ── Design Tokens (Omara-inspired) ── */
        :root {
            /* Warm earthy palette */
            --primary: #2A2A2A;
            --accent: #8B6F4E;
            --accent-hover: #735A3D;
            --accent-light: #C4A87C;
            --secondary: #6B8F7B;
            --bg-cream: #FAF8F5;
            --bg-warm: #F0EBE3;
            --bg-sand: #E8E0D4;
            --bg-dark: #2A2A2A;
            --bg-white: #FFFFFF;
            --text-dark: #2A2A2A;
            --text-body: #4A4A4A;
            --text-muted: #6B6B6B;
            --text-light: #999999;
            --border-light: #E0D9CF;
            --shadow-sm: 0 1px 4px rgba(42,42,42,0.04);
            --shadow-md: 0 8px 30px rgba(42,42,42,0.08);
            --shadow-lg: 0 16px 48px rgba(42,42,42,0.10);
            --radius: 2px;
            --radius-lg: 4px;

            /* Typography scale */
            --font-serif: 'Playfair Display', Georgia, 'Times New Roman', serif;
            --font-sans: 'DM Sans', system-ui, -apple-system, sans-serif;

            /* Spacing scale */
            --space-xs: 8px;
            --space-sm: 16px;
            --space-md: 24px;
            --space-lg: 48px;
            --space-xl: 80px;
            --space-2xl: 120px;
        }

        /* ── Layout ── */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .container-narrow { max-width: 800px; margin: 0 auto; padding: 0 24px; }
        .section { padding: var(--space-2xl) 0; }
        .section-alt { background: var(--bg-warm); }
        .section-dark { background: var(--bg-dark); color: #fff; }
        .section-cream { background: var(--bg-cream); }

        /* ── Typography ── */
        h1, h2, h3, h4, h5 {
            font-family: var(--font-serif);
            font-weight: 400;
            line-height: 1.2;
            color: var(--text-dark);
        }
        .label-sm {
            font-family: var(--font-sans);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 16px;
            display: block;
        }

        /* ── CTA Button ── */
        .cta-btn {
            display: inline-block;
            background: var(--accent);
            color: #fff;
            font-family: var(--font-sans);
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            padding: 18px 40px;
            border: none;
            border-radius: 0;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
        }
        .cta-btn:hover { background: var(--accent-hover); color: #fff; }
        .cta-btn:active { transform: scale(0.98); }
        .cta-btn-outline {
            background: transparent;
            border: 1px solid var(--accent);
            color: var(--accent);
        }
        .cta-btn-outline:hover { background: var(--accent); color: #fff; }
        .cta-btn-dark {
            background: var(--bg-dark);
        }
        .cta-btn-dark:hover { background: #3a3a3a; color: #fff; }

        /* ── Sticky Header ── */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(250,248,245,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 16px 0;
            border-bottom: 1px solid var(--border-light);
            transition: box-shadow 0.3s;
        }
        .site-header.scrolled { box-shadow: 0 2px 20px rgba(42,42,42,0.06); }
        .site-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .site-header .logo {
            font-family: var(--font-serif);
            color: var(--text-dark);
            font-size: 22px;
            font-weight: 400;
            letter-spacing: 1px;
        }
        .site-header .logo em {
            font-style: italic;
            color: var(--accent);
        }
        .header-cta {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .header-cta a {
            font-family: var(--font-sans);
            font-weight: 500;
            font-size: 13px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-dark);
            padding: 10px 24px;
            transition: all 0.3s;
        }
        .header-phone {
            background: var(--accent);
            color: #fff !important;
        }
        .header-phone:hover { background: var(--accent-hover); color: #fff; }

        /* ── Hero ── */
        .hero {
            position: relative;
            background: var(--bg-dark);
            color: #fff;
            min-height: 92vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }
        .hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.5;
        }
        .hero-bright .hero-bg { opacity: 0.6; }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(42,42,42,0.4) 0%, rgba(42,42,42,0.7) 100%);
        }
        .hero-bright .hero-overlay {
            background: linear-gradient(180deg, rgba(42,42,42,0.3) 0%, rgba(42,42,42,0.65) 100%);
        }
        .hero-inner {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 80px 0;
        }
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 60px;
            align-items: center;
        }
        .hero .label-sm { color: var(--accent-light); }
        .hero h1 {
            font-family: var(--font-serif);
            font-size: 48px;
            font-weight: 400;
            line-height: 1.15;
            color: #fff;
            margin-bottom: 20px;
        }
        .hero h1 em { font-style: italic; color: var(--accent-light); }
        .hero .subhead {
            font-size: 16px;
            font-weight: 300;
            color: rgba(255,255,255,0.7);
            line-height: 1.8;
            margin-bottom: 36px;
            max-width: 520px;
        }
        .hero-usps {
            list-style: none !important;
            padding-left: 0 !important;
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-bottom: 40px;
        }
        .hero-usps li {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 15px;
            font-weight: 300;
            color: rgba(255,255,255,0.85);
            list-style: none;
        }
        .hero-usps .usp-icon {
            width: 7px;
            height: 7px;
            background: var(--accent-light);
            border-radius: 50%;
            flex-shrink: 0;
        }
        .trust-bar {
            display: flex;
            gap: 32px;
            padding-top: 32px;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: 13px;
            font-weight: 300;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.5px;
        }

        /* ── Lead Form (elevated, warm) ── */
        .lead-form-card {
            background: #FFFFFF;
            padding: 40px 32px;
            border: 1px solid var(--border-light);
            box-shadow: 0 12px 40px rgba(0,0,0,0.12);
        }
        .hero .lead-form-card {
            box-shadow: 0 16px 48px rgba(0,0,0,0.25);
        }
        .lead-form-card h3 {
            font-family: var(--font-serif);
            color: var(--text-dark);
            font-size: 24px;
            font-weight: 400;
            text-align: center;
            margin-bottom: 6px;
        }
        .lead-form-card .form-sub {
            color: var(--text-muted);
            text-align: center;
            font-size: 13px;
            margin-bottom: 28px;
            letter-spacing: 0.3px;
        }
        .lead-form .form-group { margin-bottom: 16px; }
        .lead-form input, .lead-form select {
            width: 100%;
            padding: 16px 20px;
            border: 1px solid var(--border-light);
            border-radius: 0;
            -webkit-appearance: none;
            appearance: none;
            font-size: 16px;
            font-family: var(--font-sans);
            transition: border-color 0.3s;
            background: #fff;
            color: var(--text-dark);
        }
        .lead-form input::placeholder { color: var(--text-light); font-weight: 300; }
        .lead-form input:focus, .lead-form select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: none;
        }
        .lead-form .cta-btn { margin-top: 8px; }
        .form-disclaimer {
            text-align: center;
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 14px;
            letter-spacing: 0.5px;
        }
        .form-disclaimer svg { display: inline; vertical-align: middle; margin-right: 4px; }

        /* Success / Error */
        .form-success { display: none; text-align: center; padding: 32px 16px; }
        .form-success .check { font-size: 40px; margin-bottom: 12px; color: var(--secondary); }
        .form-success h4 { font-family: var(--font-serif); color: var(--text-dark); font-size: 22px; margin-bottom: 6px; font-weight: 400; }
        .form-success p { color: var(--text-muted); font-size: 14px; }
        .form-error { display: none; background: #fdf2f2; color: #9b2c2c; padding: 12px 16px; font-size: 13px; margin-bottom: 14px; text-align: center; border: 1px solid #fecaca; }

        /* Honeypot */
        .hp-field { position: absolute; left: -9999px; }

        /* ── Stats Bar (Omara-style superscript numbers) ── */
        .stats-bar {
            padding: 80px 0;
            background: var(--bg-cream);
            border-top: 1px solid var(--border-light);
            border-bottom: 1px solid var(--border-light);
        }
        .stats-grid {
            display: flex;
            justify-content: center;
            gap: 80px;
        }
        .stat-item { text-align: center; }
        .stat-number {
            font-family: var(--font-serif);
            font-size: 64px;
            font-weight: 400;
            color: var(--text-dark);
            line-height: 1;
            margin-bottom: 8px;
        }
        .stat-number sup {
            font-size: 28px;
            vertical-align: super;
            color: var(--accent);
            font-weight: 400;
        }
        .stat-label {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        /* ── Divider ── */
        .divider {
            width: 48px;
            height: 1px;
            background: var(--accent);
            margin: 0 auto 24px;
        }

        /* ── Mobile sticky CTA ── */
        .mobile-sticky {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 99;
            background: var(--bg-dark);
            padding: 10px 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .mobile-sticky .btns { display: flex; gap: 8px; }
        .mobile-sticky a {
            flex: 1;
            text-align: center;
            padding: 14px 8px;
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #fff;
        }
        .mobile-sticky .btn-call { background: var(--accent); }
        .mobile-sticky .btn-whatsapp { background: #25D366; }

        /* ── Critical: Gallery + Section titles (prevent FOUC) ── */
        .gallery-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            grid-template-rows: auto auto;
            gap: 3px;
        }
        .gallery-large { grid-column: 1 / 3; grid-row: 1 / 3; }
        .gallery-item { position: relative; overflow: hidden; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .section-title {
            font-family: var(--font-serif);
            font-size: 38px;
            font-weight: 400;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 12px;
            line-height: 1.2;
        }
        .section-title em { font-style: italic; color: var(--accent); }
        .section-subtitle {
            font-size: 15px;
            font-weight: 300;
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 56px;
            max-width: 560px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ── Tablet (769-1024px) ── */
        @media (min-width: 769px) and (max-width: 1024px) {
            .hero-grid { grid-template-columns: 1fr 360px; gap: 36px; }
            .hero h1 { font-size: 38px; }
            .stats-grid { gap: 48px; }
            .stat-number { font-size: 52px; }
        }

        /* ── Mobile ── */
        @media (max-width: 768px) {
            .gallery-grid { grid-template-columns: 1fr 1fr; }
            .gallery-large { grid-column: 1 / 3; grid-row: auto; }
            :root { --space-2xl: 72px; --space-xl: 56px; }
            .section { padding: var(--space-xl) 0; }
            .hero { min-height: auto; }
            .hero-inner { padding: 48px 0; }
            .hero-grid { grid-template-columns: 1fr; gap: 36px; }
            .hero h1 { font-size: 32px; }
            .hero .subhead { font-size: 15px; }
            .trust-bar { flex-wrap: wrap; gap: 16px; }
            .stats-grid { flex-wrap: wrap; gap: 40px; }
            .stat-number { font-size: 48px; }
            .mobile-sticky { display: block; }
            body { padding-bottom: 68px; }
            .header-phone-text { display: none; }
            .header-phone { padding: 10px 16px !important; min-width: 44px; min-height: 44px; display: inline-flex !important; align-items: center; justify-content: center; }
            .lead-form-card { padding: 28px 20px; }
            .whatsapp-float { bottom: 78px; right: 16px; width: 48px; height: 48px; }
        }
    </style>

    <!-- Stylesheet (non-critical) -->
    <link rel="stylesheet" href="/ppc-darbar/trehaniris/assets/css/style.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="/ppc-darbar/trehaniris/assets/css/style.css"></noscript>

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
    <!-- GTM noscript -->
    <?php if (GTM_ID !== 'GTM-XXXXXXX'): ?>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= GTM_ID ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php endif; ?>

    <!-- Sticky Header (no navigation links — PPC escape-proof) -->
    <header class="site-header" id="siteHeader">
        <div class="container">
            <div class="logo"><em>Trehan</em> Iris Broadway</div>
            <div class="header-cta">
                <a href="tel:<?= SITE_PHONE ?>" class="header-phone" onclick="trackEvent('click_to_call','header')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16" style="vertical-align:middle;" class="header-phone-icon"><path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58z"/></svg>
                    <span class="header-phone-text" style="margin-left:6px;"><?= SITE_PHONE_DISPLAY ?></span>
                </a>
            </div>
        </div>
    </header>
