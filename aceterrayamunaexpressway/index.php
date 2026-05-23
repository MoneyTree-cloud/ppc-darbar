<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="theme-color" content="#242a3a">

<!-- SEO -->
<title>Ace Terra, Yamuna Expressway | 3 &amp; 4 BHK by ACE Group, Sector 22D</title>
<meta name="description" content="Ace Terra by ACE Group — luxury 3 & 4 BHK apartments in Sector 22D, Yamuna Expressway. 11 acres, 12 towers, ~1,166 homes. From ₹1.77 Cr. RERA: UPRERAPRJ683816.">
<meta name="keywords" content="Ace Terra, Ace Terra Yamuna Expressway, Sector 22D apartments, ACE Group, 3 BHK Yamuna Expressway, 4 BHK Greater Noida, Jewar Airport property, Ace Terra price, Ace Terra floor plan, Ace Terra RERA, Ace Terra possession date">
<meta name="author" content="ACE Group">
<meta name="robots" content="index, follow, max-image-preview:large">

<!-- Favicon -->
<link rel="icon" href="assets/favicon/favicon.ico" type="image/x-icon">
<link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
<link rel="apple-touch-icon" href="assets/favicon/apple-touch-icon.png">
<link rel="manifest" href="assets/favicon/site.webmanifest">
<link rel="canonical" href="https://aceterrayamunaexpressway.in/">

<!-- OG -->
<meta property="og:type" content="website">
<meta property="og:title" content="Ace Terra | Luxury 3 &amp; 4 BHK, Yamuna Expressway">
<meta property="og:description" content="Luxury residences by ACE Group in Sector 22D, Yamuna Expressway. ~11 acres, over 70% open greens. From ₹1.77 Cr. RERA: UPRERAPRJ683816.">
<meta property="og:url" content="https://aceterrayamunaexpressway.in/">
<meta property="og:site_name" content="Ace Terra">
<meta property="og:image" content="https://aceterrayamunaexpressway.in/assets/hero-bg.png">
<meta property="og:locale" content="en_IN">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Ace Terra — Luxury Apartments, Yamuna Expressway">
<meta name="twitter:description" content="3 &amp; 4 BHK luxury apartments by ACE Group, Sector 22D, Yamuna Expressway. From ₹1.77 Cr. Near Jewar Airport.">
<meta name="twitter:image" content="https://aceterrayamunaexpressway.in/assets/hero-bg.png">

<!-- Fonts: Raleway (ACE Group's font) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* ═══════════════════════════════════════════════
       ACE GROUP DESIGN SYSTEM
       Extracted from acegroupindia.com
       ═══════════════════════════════════════════════ */

    :root {
        /* ACE Group Colors */
        --ace-gold: #c8c88c;
        --ace-gold-hover: #b5b57a;
        --ace-navy: #242a3a;
        --ace-dark: #181818;
        --ace-black: #000;
        --ace-white: #fff;
        --ace-gray-50: #f9fafb;
        --ace-gray-100: #f3f4f6;
        --ace-gray-200: #e5e7eb;
        --ace-gray-400: #9ca3af;
        --ace-gray-500: #6d6e71;
        --ace-gray-600: #484848;
        --ace-gray-700: #374151;
        --ace-gray-900: #1f2937;

        /* ACE Section Accent Colors */
        --accent-blue: #3b82f6;
        --accent-green: #10b981;
        --accent-amber: #f59e0b;
        --accent-purple: #8b5cf6;

        /* ACE Purple Gradient (signature CTA) */
        --gradient-start: #667eea;
        --gradient-end: #764ba2;
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'Raleway', sans-serif;
        font-weight: 400;
        font-size: 15px;
        line-height: 1.7;
        color: var(--ace-black);
        background: var(--ace-white);
        -webkit-font-smoothing: antialiased;
    }

    /* ── Typography: ACE style = light weights, uppercase, justified ── */

    .ace-display {
        font-family: 'Raleway', sans-serif;
        font-weight: 300;
        text-transform: uppercase;
        letter-spacing: 2px;
        line-height: 1.3;
    }

    .ace-heading {
        font-family: 'Raleway', sans-serif;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .ace-subheading {
        font-family: 'Raleway', sans-serif;
        font-weight: 300;
        letter-spacing: 0.5px;
    }

    .ace-eyebrow {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: var(--ace-gold);
    }

    .ace-body {
        text-align: justify;
        line-height: 1.7;
        color: var(--ace-gray-600);
    }

    /* ── ACE Gold Accent ── */
    .ace-gold { color: var(--ace-gold); }

    .ace-gold-line {
        width: 60px;
        height: 2px;
        background: var(--ace-gold);
        display: block;
    }

    .ace-gold-line-center {
        width: 60px;
        height: 2px;
        background: var(--ace-gold);
        margin: 0 auto;
    }

    /* ── Buttons: ACE style ── */

    /* Primary = ACE Gold (used on dark bg / hero) */
    .btn-primary {
        display: inline-block;
        background: var(--ace-gold);
        color: var(--ace-black);
        font-family: 'Raleway', sans-serif;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 12px 32px;
        border: none;
        border-radius: 0;
        cursor: pointer;
        transition: all 0.3s ease-out;
    }
    .btn-primary:hover {
        background: var(--ace-gold-hover);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(200, 200, 140, 0.3);
    }

    /* Secondary = Purple Gradient (ACE form/CTA signature) */
    .btn-secondary {
        display: inline-block;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: var(--ace-white);
        font-family: 'Raleway', sans-serif;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 12px 32px;
        border: none;
        border-radius: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        color: var(--ace-white);
    }

    /* Ghost = outline on dark bg */
    .btn-ghost {
        display: inline-block;
        background: transparent;
        color: var(--ace-white);
        font-family: 'Raleway', sans-serif;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 10px 28px;
        border: 1px solid var(--ace-white);
        border-radius: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-ghost:hover {
        background: var(--ace-white);
        color: var(--ace-black);
    }

    /* ── Cards: ACE style with color-coded left border ── */

    .ace-card {
        background: var(--ace-gray-50);
        border-radius: 0;
        border-left: 4px solid var(--ace-gold);
        padding: 28px 24px;
        transition: all 0.3s ease;
    }
    .ace-card:hover {
        box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        transform: translateY(-3px);
    }
    .ace-card.blue   { border-left-color: var(--accent-blue); }
    .ace-card.green  { border-left-color: var(--accent-green); }
    .ace-card.amber  { border-left-color: var(--accent-amber); }
    .ace-card.purple { border-left-color: var(--accent-purple); }

    /* Pricing cards — elevated variant */
    .ace-price-card {
        background: var(--ace-white);
        border: 1px solid var(--ace-gray-200);
        border-top: 4px solid var(--ace-gold);
        padding: 32px 24px;
        text-align: center;
        transition: all 0.3s ease;
    }
    .ace-price-card:hover {
        border-top-color: var(--gradient-start);
        box-shadow: 0 25px 50px rgba(0,0,0,0.12);
        transform: translateY(-5px);
    }
    .ace-price-card.featured {
        border-top: 4px solid var(--gradient-start);
        box-shadow: 0 25px 50px rgba(102, 126, 234, 0.15);
        position: relative;
    }

    /* ── Navigation: ACE style ── */

    .nav-link {
        font-size: 13px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--ace-white);
        position: relative;
        transition: color 0.3s;
        text-decoration: none;
    }
    .nav-link::after {
        content: '';
        position: absolute;
        left: 0; bottom: -4px;
        width: 0; height: 1px;
        background: var(--ace-gold);
        transition: width 0.3s;
    }
    .nav-link:hover::after { width: 100%; }
    .nav-link:hover { color: var(--ace-gold); }

    /* Scrolled state: white bg, dark text */
    header.scrolled { background: var(--ace-white) !important; box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
    header.scrolled .nav-link { color: var(--ace-black) !important; }
    header.scrolled .nav-link:hover { color: var(--ace-gold) !important; }
    header.scrolled .header-phone { color: var(--ace-black) !important; border-color: var(--ace-black) !important; }
    header.scrolled .header-cta-btn { background: var(--ace-gold) !important; color: var(--ace-black) !important; border-color: var(--ace-gold) !important; }
    #header.scrolled #mobile-menu-button svg { color: var(--ace-black); }

    /* ── Hero ── */

    .hero-video-bg {
        position: absolute; inset: 0;
        width: 100%; height: 100%;
        object-fit: cover; z-index: 0;
        pointer-events: none;
    }
    .hero-overlay {
        position: absolute; inset: 0; z-index: 1;
        background: rgba(0, 0, 0, 0.7);
    }

    /* ── Popup ── */
    .popup { display: none; }
    .popup.active { display: flex; }

    /* ── Details/Summary: ACE style ── */
    details summary { cursor: pointer; list-style: none; }
    details summary::-webkit-details-marker { display: none; }
    details summary::after {
        content: '+';
        float: right;
        font-weight: 300;
        font-size: 1.4rem;
        color: var(--ace-gold);
        transition: transform 0.2s;
    }
    details[open] summary::after { content: '\2212'; }

    /* ── Tables ── */
    .ace-table th {
        background: var(--ace-navy);
        color: var(--ace-white);
        font-weight: 500;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 20px;
        text-align: left;
    }
    .ace-table td {
        padding: 12px 20px;
        border-bottom: 1px solid var(--ace-gray-200);
        font-size: 14px;
    }
    .ace-table tr:hover td { background: rgba(200, 200, 140, 0.06); }

    /* ── Section Dividers ── */
    .section-divider {
        width: 100%;
        height: 1px;
        background: var(--ace-gray-200);
    }

    /* ── Amenity Tile ── */
    .amenity-tile {
        background: var(--ace-white);
        border: 1px solid var(--ace-gray-200);
        padding: 32px 20px;
        text-align: center;
        transition: all 0.3s ease;
    }
    .amenity-tile:hover {
        border-color: var(--ace-gold);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.06);
    }
    .amenity-tile .amenity-icon {
        width: 48px; height: 48px;
        margin: 0 auto 16px;
        color: var(--ace-gold);
    }

    /* ── Footer: ACE dark style ── */
    .ace-footer {
        background: var(--ace-dark);
        color: var(--ace-white);
    }
    .ace-footer a { color: rgba(255,255,255,0.7); transition: color 0.3s; }
    .ace-footer a:hover { color: var(--ace-gold); }

    /* ── Mobile Bottom Bar ── */
    #mobile-bottom-bar { transform: translateY(100%); }
    #mobile-bottom-bar.show { transform: translateY(0); }

    /* ── Animations ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.8s ease forwards; }
    .fade-up-d1 { animation: fadeUp 0.8s ease 0.1s forwards; opacity: 0; }
    .fade-up-d2 { animation: fadeUp 0.8s ease 0.2s forwards; opacity: 0; }
    .fade-up-d3 { animation: fadeUp 0.8s ease 0.3s forwards; opacity: 0; }
    .fade-up-d4 { animation: fadeUp 0.8s ease 0.4s forwards; opacity: 0; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .ace-display { letter-spacing: 1px; }
    }
</style>
</head>

<body class="overflow-x-hidden">

<!-- ═══════════════════════════════════════════════
     [1] HEADER — ACE Style: fixed white, Raleway uppercase
     ═══════════════════════════════════════════════ -->
<header id="header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
    <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="#hero" aria-label="Ace Terra Home">
            <img src="./assets/logo.svg" alt="Ace Terra Logo" class="h-10 w-auto">
        </a>
        <div class="hidden lg:flex items-center gap-8">
            <a href="#about" class="nav-link">Overview</a>
            <a href="#pricing" class="nav-link">Residences</a>
            <a href="#amenities" class="nav-link">Amenities</a>
            <a href="#payment" class="nav-link">Payment</a>
            <a href="#location" class="nav-link">Location</a>
            <a href="#gallery" class="nav-link">Gallery</a>
            <a href="#faq" class="nav-link">FAQ</a>
        </div>
        <div class="hidden lg:flex items-center gap-3">
            <a href="tel:+919412234688" class="btn-ghost text-xs py-2 px-4 flex items-center gap-2 header-phone" aria-label="Call Sales">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <span>+91 94122 34688</span>
            </a>
            <button id="header-cta" class="btn-primary text-xs py-2 px-5 header-cta-btn" aria-label="Enquire Now">Enquire Now</button>
        </div>
        <button id="mobile-menu-button" class="lg:hidden focus:outline-none" aria-label="Open Menu">
            <svg class="w-7 h-7 text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </nav>
    <div id="mobile-menu" class="hidden lg:hidden bg-white">
        <a href="#about" class="block text-center py-4 text-sm uppercase tracking-widest hover:bg-gray-50 transition-colors">Overview</a>
        <a href="#pricing" class="block text-center py-4 text-sm uppercase tracking-widest hover:bg-gray-50 transition-colors">Residences</a>
        <a href="#amenities" class="block text-center py-4 text-sm uppercase tracking-widest hover:bg-gray-50 transition-colors">Amenities</a>
        <a href="#payment" class="block text-center py-4 text-sm uppercase tracking-widest hover:bg-gray-50 transition-colors">Payment Plan</a>
        <a href="#location" class="block text-center py-4 text-sm uppercase tracking-widest hover:bg-gray-50 transition-colors">Location</a>
        <a href="#gallery" class="block text-center py-4 text-sm uppercase tracking-widest hover:bg-gray-50 transition-colors">Gallery</a>
        <a href="#faq" class="block text-center py-4 text-sm uppercase tracking-widest hover:bg-gray-50 transition-colors">FAQ</a>
        <div class="p-4">
            <button id="mobile-menu-cta" class="w-full btn-secondary py-3" aria-label="Enquire Now">Enquire Now</button>
        </div>
    </div>
</header>


<!-- ═══════════════════════════════════════════════
     [2] HERO — Full-screen video, dark overlay, ACE typography
     ═══════════════════════════════════════════════ -->
<section id="hero" class="relative h-screen flex items-center justify-center overflow-hidden">
    <video class="hero-video-bg" autoplay loop muted playsinline poster="./assets/hero-bg.png">
        <source src="./assets/Ace_Terra_Drone_Shot_Video.mp4" type="video/mp4">
    </video>
    <div class="hero-overlay"></div>

    <div class="max-w-5xl mx-auto px-6 text-center relative z-10">
        <p class="ace-eyebrow mb-6 fade-up-d1">Sector 22D &middot; Yamuna Expressway &middot; ACE Group</p>

        <h1 class="ace-display text-3xl md:text-5xl lg:text-6xl text-white mb-8 fade-up-d2">
            Ace Terra
        </h1>

        <p class="ace-subheading text-white/80 text-base md:text-lg max-w-2xl mx-auto mb-10 fade-up-d3" style="text-align:center;">
            Luxury 3 &amp; 4 BHK residences across ~11 acres with over 70% open greens.<br class="hidden md:block">
            12 towers &middot; ~1,166 homes &middot; Starting ₹1.77 Cr &middot; RERA: UPRERAPRJ683816
        </p>

        <!-- Stat band — ACE style: minimal, uppercase labels -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-10 max-w-3xl mx-auto mb-10 fade-up-d4">
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-200 text-white" style="font-weight:200;">3 &amp; 4</div>
                <div class="ace-eyebrow text-[10px] mt-1">BHK Residences</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-200 text-white" style="font-weight:200;">~11</div>
                <div class="ace-eyebrow text-[10px] mt-1">Acres</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-200 text-white" style="font-weight:200;">70%+</div>
                <div class="ace-eyebrow text-[10px] mt-1">Open Greens</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-200 text-white" style="font-weight:200;">₹1.77</div>
                <div class="ace-eyebrow text-[10px] mt-1">Crore Onwards</div>
            </div>
        </div>

        <button id="hero-cta" class="btn-primary" aria-label="Enquire about Ace Terra">Enquire Now</button>
        <p class="text-xs text-white/40 mt-4 tracking-wide">*T&amp;C apply. Prices are indicative.</p>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [3] TRUST STRIP — Dark navy, gold values
     ═══════════════════════════════════════════════ -->
<section style="background:var(--ace-navy);" aria-label="Project highlights">
    <div class="max-w-6xl mx-auto px-4 py-5">
        <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
            <div class="text-center">
                <div class="text-lg md:text-xl font-300 ace-gold" style="font-weight:300;">RERA</div>
                <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Registered</div>
            </div>
            <div class="text-center">
                <div class="text-lg md:text-xl font-300 ace-gold" style="font-weight:300;">12</div>
                <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Towers</div>
            </div>
            <div class="text-center">
                <div class="text-lg md:text-xl font-300 ace-gold" style="font-weight:300;">G+25</div>
                <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Floors</div>
            </div>
            <div class="text-center">
                <div class="text-lg md:text-xl font-300 ace-gold" style="font-weight:300;">~1,166</div>
                <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Homes</div>
            </div>
            <div class="text-center">
                <div class="text-lg md:text-xl font-300 ace-gold" style="font-weight:300;">Dec 2028</div>
                <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Possession</div>
            </div>
            <div class="text-center">
                <div class="text-lg md:text-xl font-300 ace-gold" style="font-weight:300;">ACE</div>
                <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Group</div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [4] OVERVIEW — ACE layout: image + justified text
     ═══════════════════════════════════════════════ -->
<section id="about" class="py-20 md:py-28">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div>
                <img src="./assets/long.webp" alt="Ace Terra — luxury facade and landscaped greens, Sector 22D Yamuna Expressway" class="w-full h-auto object-cover shadow-lg" loading="lazy">
            </div>
            <div>
                <p class="ace-eyebrow mb-4">About the Project</p>
                <h2 class="ace-heading text-2xl md:text-3xl mb-2">Ace Terra</h2>
                <span class="ace-gold-line mb-6 block"></span>

                <p class="ace-body mb-4">
                    Ace Terra is an 11-acre luxury residential project by ACE Group (ACE Infracity Developers Pvt. Ltd.) in Sector 22D, Yamuna Expressway, Greater Noida, Uttar Pradesh. The project offers approximately 1,166 residences across 12 towers (G+25 floors each) in three configurations: 3 BHK (1,770 sq ft), 3 BHK+SQ (2,395 sq ft) and 4 BHK+SQ (3,025 sq ft). Prices start from ₹1.77 Crore for the 3 BHK. Over 70% of the 11-acre campus is dedicated to open green spaces with a forest-themed landscape. The Club Spade clubhouse anchors community life with a swimming pool, gym, tennis court, mini theatre and themed gardens. RERA registration: UPRERAPRJ683816 (UP-RERA). Expected possession: December 2028.
                </p>

                <details class="mb-6">
                    <summary class="text-sm font-600 uppercase tracking-wider py-2 border-b border-gray-200" style="font-weight:600;">Read More</summary>
                    <div class="ace-body mt-4 space-y-3">
                        <p>Designed around a forest theme, Ace Terra reimagines luxury living on the Yamuna Expressway corridor. The architecture balances towering residences with expansive central greens, water features and landscaped walking paths that thread through the community. Each tower is served by 4 high-speed lifts with 4 units per floor, ensuring privacy and low-density living.</p>
                        <p>Club Spade, the signature clubhouse, extends beyond a standard amenity centre. Residents access a swimming pool with poolside cabanas, a jacuzzi, tennis and squash courts, a billiards room, basketball court, banquet hall, mini theatre, multi-cuisine cafeteria, business lounge, library and unisex salon. Outdoors, themed gardens, a yoga deck, amphitheatre, jogging track, cycling path, meditation zone, kids play area and senior citizen area create a layered wellness landscape. 24x7 manned security, CCTV surveillance, power backup, rainwater harvesting and a sewage treatment plant round out the infrastructure.</p>
                        <p>The 3 BHK apartments (1,770 sq ft) suit nuclear families with three bedrooms, a living-dining area, modular kitchen, utility space and balconies. The 3 BHK+SQ (2,395 sq ft) adds a servant quarter for households needing domestic help. The flagship 4 BHK+SQ (3,025 sq ft) delivers grand living spaces, premium finishes and panoramic green views — positioned as the top-tier residence in the project.</p>
                        <p>Sector 22D's location on the Yamuna Expressway places Ace Terra within approximately 15–20 km of the under-construction Noida International Airport at Jewar, roughly 10 km from the Buddh International Circuit and 20 km from Pari Chowk, Greater Noida's commercial centre. The proposed Film City, Delhi-Mumbai Expressway interchange and future metro connectivity further strengthen the corridor's growth trajectory. ACE Group, with over two decades in Delhi-NCR real estate and a portfolio spanning Ace City, Ace Divino, Ace Parkway, Ace Platinum and Ace Golf Shire, brings proven delivery credibility to the project.</p>
                    </div>
                </details>

                <button id="about-cta" class="btn-secondary" aria-label="Request a callback">Request a Callback</button>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [5] KEY FACTS TABLE — AI-parseable, ACE styled
     ═══════════════════════════════════════════════ -->
<section id="key-facts" style="background:var(--ace-gray-50);" class="py-16 md:py-20">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-10">
            <p class="ace-eyebrow mb-3">Project Specifications</p>
            <h2 class="ace-heading text-2xl md:text-3xl">Ace Terra at a Glance</h2>
            <span class="ace-gold-line-center mt-3 block"></span>
        </div>
        <div class="overflow-x-auto">
            <table class="ace-table w-full">
                <caption class="sr-only">Ace Terra — Key Project Facts</caption>
                <tbody>
                    <tr><td class="font-semibold w-2/5">Project Name</td><td>Ace Terra</td></tr>
                    <tr><td class="font-semibold">Developer</td><td>ACE Group (ACE Infracity Developers Pvt. Ltd.)</td></tr>
                    <tr><td class="font-semibold">Location</td><td>Sector 22D, Yamuna Expressway, Greater Noida, UP</td></tr>
                    <tr><td class="font-semibold">Project Area</td><td>~11 acres &middot; Over 70% open greens</td></tr>
                    <tr><td class="font-semibold">Towers</td><td>12 towers &middot; G+25 floors &middot; 4 units/floor &middot; 4 lifts/tower</td></tr>
                    <tr><td class="font-semibold">Total Residences</td><td>~1,166</td></tr>
                    <tr><td class="font-semibold">Configurations</td><td>3 BHK &middot; 3 BHK+SQ &middot; 4 BHK+SQ</td></tr>
                    <tr><td class="font-semibold">3 BHK</td><td>1,770 sq ft &middot; From ₹1.77 Crore</td></tr>
                    <tr><td class="font-semibold">3 BHK + SQ</td><td>2,395 sq ft &middot; From ~₹2.40 Crore</td></tr>
                    <tr><td class="font-semibold">4 BHK + SQ</td><td>3,025 sq ft &middot; From ~₹3.02 Crore</td></tr>
                    <tr><td class="font-semibold">RERA Number</td><td>UPRERAPRJ683816 (UP-RERA)</td></tr>
                    <tr><td class="font-semibold">Possession</td><td>December 2028</td></tr>
                    <tr><td class="font-semibold">Clubhouse</td><td>Club Spade</td></tr>
                    <tr><td class="font-semibold">Nearest Airport</td><td>Jewar International Airport (~15–20 km, under construction)</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [6] RESIDENCES & PRICING — ACE price cards
     ═══════════════════════════════════════════════ -->
<section id="pricing" class="py-20 md:py-28">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="ace-eyebrow mb-3">Residences</p>
            <h2 class="ace-heading text-2xl md:text-3xl">Choose Your Ace Terra Home</h2>
            <span class="ace-gold-line-center mt-3 block"></span>
            <p class="ace-subheading mt-4 max-w-xl mx-auto" style="color:var(--ace-gray-500);text-align:center;">
                Luxury 3 &amp; 4 BHK apartments with spacious layouts, premium finishes and panoramic green views. Starting ₹1.77 Cr.
            </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- 3 BHK -->
            <div class="ace-price-card">
                <p class="ace-eyebrow text-[10px] mb-3">Configuration</p>
                <h3 class="ace-heading text-xl mb-1">3 BHK</h3>
                <p class="text-3xl font-200 mb-1" style="font-weight:200;">1,770 <span class="text-sm">sq ft</span></p>
                <p class="text-lg font-500 ace-gold mb-6" style="font-weight:500;">From ₹1.77 Cr*</p>
                <p class="text-sm mb-6" style="color:var(--ace-gray-500);">Modern layout for comfortable, elegant family living.</p>
                <button class="price-cta btn-secondary w-full" aria-label="Get 3 BHK price">Get Price Details</button>
            </div>
            <!-- 3 BHK+SQ — Featured -->
            <div class="ace-price-card featured">
                <span class="absolute -top-px left-0 right-0 h-1" style="background:linear-gradient(135deg,var(--gradient-start),var(--gradient-end));"></span>
                <p class="ace-eyebrow text-[10px] mb-3" style="color:var(--gradient-start);">Most Popular</p>
                <h3 class="ace-heading text-xl mb-1">3 BHK + SQ</h3>
                <p class="text-3xl font-200 mb-1" style="font-weight:200;">2,395 <span class="text-sm">sq ft</span></p>
                <p class="text-lg font-500 ace-gold mb-6" style="font-weight:500;">From ~₹2.40 Cr*</p>
                <p class="text-sm mb-6" style="color:var(--ace-gray-500);">Added convenience with a dedicated servant quarter.</p>
                <button class="price-cta btn-secondary w-full" aria-label="Get 3 BHK+SQ price">Get Price Details</button>
            </div>
            <!-- 4 BHK+SQ -->
            <div class="ace-price-card">
                <p class="ace-eyebrow text-[10px] mb-3">Flagship</p>
                <h3 class="ace-heading text-xl mb-1">4 BHK + SQ</h3>
                <p class="text-3xl font-200 mb-1" style="font-weight:200;">3,025 <span class="text-sm">sq ft</span></p>
                <p class="text-lg font-500 ace-gold mb-6" style="font-weight:500;">From ~₹3.02 Cr*</p>
                <p class="text-sm mb-6" style="color:var(--ace-gray-500);">Grand spaces with premium finishes and panoramic views.</p>
                <button class="price-cta btn-secondary w-full" aria-label="Get 4 BHK price">Get Price Details</button>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [7] AMENITIES — 6 hero tiles + collapsed list
     ═══════════════════════════════════════════════ -->
<section id="amenities" style="background:var(--ace-gray-50);" class="py-20 md:py-28">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="ace-eyebrow mb-3">Lifestyle</p>
            <h2 class="ace-heading text-2xl md:text-3xl">Club Spade &amp; Amenities</h2>
            <span class="ace-gold-line-center mt-3 block"></span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
            <div class="amenity-tile">
                <svg class="amenity-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <h3 class="text-sm font-600 uppercase tracking-wider mb-1" style="font-weight:600;">Club Spade</h3>
                <p class="text-xs" style="color:var(--ace-gray-500);">Grand clubhouse &amp; social hub</p>
            </div>
            <div class="amenity-tile">
                <svg class="amenity-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                <h3 class="text-sm font-600 uppercase tracking-wider mb-1" style="font-weight:600;">Swimming Pool</h3>
                <p class="text-xs" style="color:var(--ace-gray-500);">Pool with cabanas &amp; jacuzzi</p>
            </div>
            <div class="amenity-tile">
                <svg class="amenity-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                <h3 class="text-sm font-600 uppercase tracking-wider mb-1" style="font-weight:600;">Gym &amp; Wellness</h3>
                <p class="text-xs" style="color:var(--ace-gray-500);">State-of-the-art fitness centre</p>
            </div>
            <div class="amenity-tile">
                <svg class="amenity-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <h3 class="text-sm font-600 uppercase tracking-wider mb-1" style="font-weight:600;">Mini Theatre</h3>
                <p class="text-xs" style="color:var(--ace-gray-500);">Private screenings &amp; entertainment</p>
            </div>
            <div class="amenity-tile">
                <svg class="amenity-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M8 12h8M12 8v8"/></svg>
                <h3 class="text-sm font-600 uppercase tracking-wider mb-1" style="font-weight:600;">Tennis Court</h3>
                <p class="text-xs" style="color:var(--ace-gray-500);">Premium sports facilities</p>
            </div>
            <div class="amenity-tile">
                <svg class="amenity-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                <h3 class="text-sm font-600 uppercase tracking-wider mb-1" style="font-weight:600;">Themed Gardens</h3>
                <p class="text-xs" style="color:var(--ace-gray-500);">Forest-themed landscaping &amp; yoga deck</p>
            </div>
        </div>

        <div class="mt-10">
            <details>
                <summary class="text-sm font-600 uppercase tracking-wider py-3 border-b border-gray-200 max-w-md mx-auto text-center" style="font-weight:600;">View All 30+ Amenities</summary>
                <div class="mt-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 max-w-4xl mx-auto">
                    <span class="ace-card text-sm py-3 px-4">Banquet Hall</span>
                    <span class="ace-card blue text-sm py-3 px-4">Squash Court</span>
                    <span class="ace-card green text-sm py-3 px-4">Billiards Room</span>
                    <span class="ace-card amber text-sm py-3 px-4">Basketball Court</span>
                    <span class="ace-card purple text-sm py-3 px-4">Amphitheatre</span>
                    <span class="ace-card text-sm py-3 px-4">Business Lounge</span>
                    <span class="ace-card blue text-sm py-3 px-4">Library</span>
                    <span class="ace-card green text-sm py-3 px-4">Cafeteria</span>
                    <span class="ace-card amber text-sm py-3 px-4">Unisex Salon</span>
                    <span class="ace-card purple text-sm py-3 px-4">Poolside Cabanas</span>
                    <span class="ace-card text-sm py-3 px-4">Jacuzzi</span>
                    <span class="ace-card blue text-sm py-3 px-4">Jogging Track</span>
                    <span class="ace-card green text-sm py-3 px-4">Cycling Path</span>
                    <span class="ace-card amber text-sm py-3 px-4">Kids Play Area</span>
                    <span class="ace-card purple text-sm py-3 px-4">Water Features</span>
                    <span class="ace-card text-sm py-3 px-4">Meditation Zone</span>
                    <span class="ace-card blue text-sm py-3 px-4">Senior Citizen Area</span>
                    <span class="ace-card green text-sm py-3 px-4">Multi-Sport Courts</span>
                    <span class="ace-card amber text-sm py-3 px-4">24x7 Security &amp; CCTV</span>
                    <span class="ace-card purple text-sm py-3 px-4">Power Backup</span>
                    <span class="ace-card text-sm py-3 px-4">Rainwater Harvesting</span>
                    <span class="ace-card blue text-sm py-3 px-4">STP</span>
                    <span class="ace-card green text-sm py-3 px-4">High-Speed Lifts (4/tower)</span>
                    <span class="ace-card amber text-sm py-3 px-4">Yoga Deck</span>
                </div>
            </details>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [8] PAYMENT PLAN
     ═══════════════════════════════════════════════ -->
<section id="payment" class="py-20 md:py-28">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-10">
            <p class="ace-eyebrow mb-3">Investment</p>
            <h2 class="ace-heading text-2xl md:text-3xl">Payment Plan</h2>
            <span class="ace-gold-line-center mt-3 block"></span>
            <p class="ace-subheading mt-4" style="color:var(--ace-gray-500);text-align:center;">Construction-linked payment plan — payments align with project milestones.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="ace-table w-full">
                <thead>
                    <tr>
                        <th>Milestone</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>On Booking</td><td>10% of BSP</td></tr>
                    <tr><td>Within 30 Days of Booking</td><td>15% of BSP</td></tr>
                    <tr><td>On Completion of Foundation</td><td>15% of BSP</td></tr>
                    <tr><td>On Completion of Superstructure (50%)</td><td>15% of BSP</td></tr>
                    <tr><td>On Completion of Superstructure (100%)</td><td>15% of BSP</td></tr>
                    <tr><td>On Completion of Brickwork &amp; Plaster</td><td>10% of BSP</td></tr>
                    <tr><td>On Completion of Flooring &amp; Fixtures</td><td>10% of BSP</td></tr>
                    <tr><td>On Offer of Possession</td><td>10% of BSP + Other Charges</td></tr>
                </tbody>
            </table>
        </div>
        <p class="text-center text-xs mt-4" style="color:var(--ace-gray-400);">BSP = Basic Sale Price. Payment plan is indicative. Confirm latest schedule with our sales team.</p>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [9] LOCATION & CONNECTIVITY
     ═══════════════════════════════════════════════ -->
<section id="location" style="background:var(--ace-gray-50);" class="py-20 md:py-28">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="ace-eyebrow mb-3">Location</p>
            <h2 class="ace-heading text-2xl md:text-3xl">Ace Terra &mdash; Yamuna Expressway</h2>
            <span class="ace-gold-line-center mt-3 block"></span>
        </div>
        <div class="grid lg:grid-cols-2 gap-12 items-start">
            <div class="relative w-full h-96 lg:h-[500px] overflow-hidden shadow-lg">
                <iframe title="Ace Terra Location — Sector 22D, Yamuna Expressway"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3510.169542352822!2d77.597658!3d28.384288!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cc767b43f4075%3A0x6b7381699931758c!2sSector%2022D%2C%20Yamuna%20Expy%2C%20Uttar%20Pradesh%20203201!5e0!3m2!1sen!2sin!4v1719139688537!5m2!1sen!2sin"
                    width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="grayscale hover:grayscale-0 transition-all duration-700"></iframe>
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <button class="price-cta btn-primary pointer-events-auto shadow-xl" aria-label="Enquire about location">
                        Enquire About Location
                    </button>
                </div>
            </div>
            <div class="space-y-5">
                <h3 class="ace-heading text-lg mb-4">Key Distances</h3>

                <div class="ace-card blue flex items-start gap-4">
                    <svg class="w-6 h-6 flex-shrink-0 mt-0.5" style="color:var(--accent-blue);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                    <div>
                        <h4 class="font-semibold text-sm">Jewar International Airport</h4>
                        <p class="text-sm" style="color:var(--ace-gray-500);">~15–20 km — India's upcoming global gateway (under construction)</p>
                    </div>
                </div>
                <div class="ace-card green flex items-start gap-4">
                    <svg class="w-6 h-6 flex-shrink-0 mt-0.5" style="color:var(--accent-green);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                    <div>
                        <h4 class="font-semibold text-sm">Buddh International Circuit</h4>
                        <p class="text-sm" style="color:var(--ace-gray-500);">~10 km — World-class motorsport destination</p>
                    </div>
                </div>
                <div class="ace-card amber flex items-start gap-4">
                    <svg class="w-6 h-6 flex-shrink-0 mt-0.5" style="color:var(--accent-amber);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3H21"/></svg>
                    <div>
                        <h4 class="font-semibold text-sm">Pari Chowk, Greater Noida</h4>
                        <p class="text-sm" style="color:var(--ace-gray-500);">~20 km — City centre &amp; commercial hub</p>
                    </div>
                </div>
                <div class="ace-card purple flex items-start gap-4">
                    <svg class="w-6 h-6 flex-shrink-0 mt-0.5" style="color:var(--accent-purple);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
                    <div>
                        <h4 class="font-semibold text-sm">Galgotias University</h4>
                        <p class="text-sm" style="color:var(--ace-gray-500);">~8 km — Leading educational institution</p>
                    </div>
                </div>
                <div class="ace-card flex items-start gap-4">
                    <svg class="w-6 h-6 flex-shrink-0 mt-0.5 ace-gold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/></svg>
                    <div>
                        <h4 class="font-semibold text-sm">Yamuna Expressway</h4>
                        <p class="text-sm" style="color:var(--ace-gray-500);">Direct frontage — Connects Delhi to Agra (~160 km)</p>
                    </div>
                </div>

                <details class="mt-4">
                    <summary class="text-sm font-600 uppercase tracking-wider py-2 border-b border-gray-200" style="font-weight:600;">More Connectivity Details</summary>
                    <p class="ace-body mt-4 text-sm">The Yamuna Expressway corridor is undergoing transformation driven by the Jewar Airport project, proposed Film City, Delhi-Mumbai Expressway interchange and planned metro extension. Ace Terra's direct expressway frontage and proximity to these infrastructure catalysts position it within one of North India's fastest-developing corridors. The proposed metro connectivity and upcoming expressway interchanges will further reduce travel times to Delhi, Noida and other NCR hubs.</p>
                </details>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [10] GALLERY
     ═══════════════════════════════════════════════ -->
<section id="gallery" class="py-20 md:py-28">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="ace-eyebrow mb-3">Gallery</p>
            <h2 class="ace-heading text-2xl md:text-3xl">A Visual Tour of Ace Terra</h2>
            <span class="ace-gold-line-center mt-3 block"></span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="overflow-hidden group">
                <img src="./assets/image3.webp" alt="Ace Terra luxury interior — Sector 22D" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
            </div>
            <div class="overflow-hidden group lg:col-span-2">
                <img src="./assets/image4.webp" alt="Ace Terra Club Spade clubhouse and amenities" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
            </div>
            <div class="overflow-hidden group sm:col-span-2 lg:col-span-2">
                <img src="./assets/image1.webp" alt="Ace Terra poolside view at dusk" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
            </div>
            <div class="overflow-hidden group">
                <img src="./assets/image5.webp" alt="Ace Terra landscaped greens and walking paths" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
            </div>
        </div>
        <div class="text-center mt-10">
            <button id="gallery-cta" class="btn-secondary" aria-label="Download full gallery">Download Full Gallery</button>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [11] ABOUT ACE GROUP — Short + read more
     ═══════════════════════════════════════════════ -->
<section id="developer" style="background:var(--ace-gray-50);" class="py-20 md:py-28">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <p class="ace-eyebrow mb-4">The Developer</p>
                <h2 class="ace-heading text-2xl md:text-3xl mb-2">ACE Group</h2>
                <span class="ace-gold-line mb-6 block"></span>

                <p class="ace-body mb-4">
                    ACE Group (ACE Infracity Developers Pvt. Ltd.) is a prominent real estate developer in the Delhi-NCR region with over two decades of experience. The group has delivered millions of square feet of residential and commercial space. Their portfolio includes Ace City, Ace Divino, Ace Parkway, Ace Platinum and Ace Golf Shire.
                </p>

                <details>
                    <summary class="text-sm font-600 uppercase tracking-wider py-2 border-b border-gray-200" style="font-weight:600;">Read More About ACE Group</summary>
                    <p class="ace-body mt-4">ACE Group has established itself as a trusted name in North Indian real estate. Founded by CMD Ajay Chaudhary, the company's portfolio spans residential townships, high-rise condominiums, commercial complexes and retail destinations across Greater Noida and the Yamuna Expressway corridor. With 20 projects (11 completed, 9 ongoing) and a commitment to sustainable development, modern design and community living, ACE Group continues to shape the region into a premium residential destination. Corporate office: 7th Floor, Plot No. 01B, Sector-126, Gautam Budh Nagar, UP 201303.</p>
                </details>
            </div>
            <div>
                <img src="./assets/image2.webp" alt="ACE Group — Developer of Ace Terra, Yamuna Expressway" class="w-full h-auto object-cover shadow-lg" loading="lazy">
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [12] FAQ — 12 Accordion Q&As
     ═══════════════════════════════════════════════ -->
<section id="faq" class="py-20 md:py-28">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="ace-eyebrow mb-3">FAQ</p>
            <h2 class="ace-heading text-2xl md:text-3xl">Frequently Asked Questions</h2>
            <span class="ace-gold-line-center mt-3 block"></span>
        </div>
        <div class="space-y-4">
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">What is Ace Terra and where is it located?</summary>
                <p class="mt-3 text-sm ace-body">Ace Terra is an 11-acre luxury residential project by ACE Group in Sector 22D, Yamuna Expressway, Greater Noida, Uttar Pradesh. It offers ~1,166 apartments across 12 towers (G+25 floors) with over 70% open green spaces. The project is approximately 15–20 km from the upcoming Jewar International Airport.</p>
            </details>
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">Who is the developer of Ace Terra?</summary>
                <p class="mt-3 text-sm ace-body">Ace Terra is developed by ACE Group (ACE Infracity Developers Pvt. Ltd.), a Delhi-NCR real estate developer with over two decades of experience. ACE Group has delivered millions of square feet across projects including Ace City, Ace Divino, Ace Parkway, Ace Platinum and Ace Golf Shire in Greater Noida and the Yamuna Expressway corridor.</p>
            </details>
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">What apartment sizes and configurations are available at Ace Terra?</summary>
                <p class="mt-3 text-sm ace-body">Ace Terra offers three configurations: 3 BHK (1,770 sq ft), 3 BHK with Servant Quarter (2,395 sq ft) and 4 BHK with Servant Quarter (3,025 sq ft). Each unit includes balconies, modular kitchen provisions and premium finishes. Towers have 4 units per floor served by 4 high-speed lifts.</p>
            </details>
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">What is the price of apartments in Ace Terra Yamuna Expressway?</summary>
                <p class="mt-3 text-sm ace-body">The 3 BHK (1,770 sq ft) starts from ₹1.77 Crore, the 3 BHK+SQ (2,395 sq ft) from approximately ₹2.40 Crore, and the 4 BHK+SQ (3,025 sq ft) from approximately ₹3.02 Crore. Prices are indicative and subject to change — contact the sales team for the current price sheet.</p>
            </details>
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">Is Ace Terra RERA registered?</summary>
                <p class="mt-3 text-sm ace-body">Yes. Ace Terra is registered with UP-RERA under registration number UPRERAPRJ683816. All project details can be verified on the official UP-RERA portal at up-rera.in.</p>
            </details>
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">When is the possession date for Ace Terra?</summary>
                <p class="mt-3 text-sm ace-body">The expected possession date is December 2028 as per the RERA filing. Construction began in February 2024. Buyers should verify the latest timeline with the developer or on the UP-RERA portal.</p>
            </details>
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">How many towers and apartments are there in Ace Terra?</summary>
                <p class="mt-3 text-sm ace-body">Ace Terra has 12 residential towers, each G+25 floors, with approximately 1,166 apartments across roughly 11 acres. Over 70% of the project area is dedicated to landscaped greens and open spaces.</p>
            </details>
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">What amenities does Ace Terra offer?</summary>
                <p class="mt-3 text-sm ace-body">The Club Spade clubhouse includes a swimming pool with cabanas, jacuzzi, tennis court, squash court, billiards room, basketball court, mini theatre, gym, banquet hall, cafeteria, business lounge, library and unisex salon. Outdoor amenities include themed gardens, yoga deck, amphitheatre, jogging track, cycling path, meditation zone, kids play area, water features and senior citizen area. The project has 24x7 security, CCTV, power backup, rainwater harvesting and STP.</p>
            </details>
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">How far is Ace Terra from Jewar Airport?</summary>
                <p class="mt-3 text-sm ace-body">Ace Terra in Sector 22D is approximately 15–20 km from the under-construction Noida International Airport at Jewar. The project has direct Yamuna Expressway frontage, is ~10 km from Buddh International Circuit and ~20 km from Pari Chowk, Greater Noida.</p>
            </details>
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">How can I get the Ace Terra brochure and floor plan?</summary>
                <p class="mt-3 text-sm ace-body">Click any "Enquire Now" or "Get Price Details" button on this page and submit your name, email and phone. The Ace Terra sales team will share the official brochure, detailed floor plans and the current price list.</p>
            </details>
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">What is the Ace Terra payment plan?</summary>
                <p class="mt-3 text-sm ace-body">Ace Terra uses a construction-linked payment plan (CLP): 10% on booking, 15% within 30 days, then payments at foundation, superstructure 50%, superstructure 100%, brickwork and plaster, flooring and fixtures, and final 10% plus charges at possession. Contact sales for the confirmed current schedule.</p>
            </details>
            <details class="border-b border-gray-200 pb-4">
                <summary class="font-medium text-sm py-2">Is Ace Terra a good investment near Jewar Airport?</summary>
                <p class="mt-3 text-sm ace-body">Ace Terra sits on the Yamuna Expressway, ~15–20 km from Jewar International Airport, near the proposed Film City and Delhi-Mumbai Expressway interchange. These infrastructure developments are expected to drive long-term corridor growth. ACE Group's established delivery track record and RERA registration (UPRERAPRJ683816) add credibility. All investment decisions should be made after independent due diligence.</p>
            </details>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [13] SEO LONG-FORM BLOCK
     ═══════════════════════════════════════════════ -->
<section id="seo-content" style="background:var(--ace-gray-50);" class="py-16 md:py-20">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="ace-heading text-xl md:text-2xl mb-4">Ace Terra by ACE Group — Luxury Living on Yamuna Expressway</h2>
        <span class="ace-gold-line mb-6 block"></span>
        <div class="ace-body text-sm">
            <p class="mb-4">Ace Terra by ACE Group is a landmark residential development on the Yamuna Expressway in Sector 22D, Greater Noida. Spanning approximately 11 acres with over 70% open green spaces, the project delivers 3 BHK, 3 BHK+SQ and 4 BHK+SQ apartments across 12 towers rising G+25 floors each. With roughly 1,166 homes, a Club Spade clubhouse, proximity to the upcoming Jewar International Airport and a construction-linked payment plan, Ace Terra combines ACE Group's two decades of Delhi-NCR real estate expertise with one of North India's most dynamic infrastructure corridors. RERA: UPRERAPRJ683816. Possession: December 2028. Starting ₹1.77 Crore.</p>
            <details>
                <summary class="text-sm font-600 uppercase tracking-wider py-2 border-b border-gray-200" style="font-weight:600;">Read Complete Overview</summary>
                <div class="mt-4 space-y-4">
                    <h3 class="font-semibold text-sm uppercase tracking-wider">Ace Terra Apartment Configurations and Pricing</h3>
                    <p>The entry-level 3 BHK at Ace Terra spans 1,770 sq ft, offering three bedrooms, a living-dining area, modular kitchen, utility area and balconies — starting from ₹1.77 Crore. The 3 BHK+SQ at 2,395 sq ft adds a dedicated servant quarter for households needing domestic staff, priced from approximately ₹2.40 Crore. The flagship 4 BHK+SQ at 3,025 sq ft is the most spacious configuration, featuring grand living areas, premium finishes and panoramic views of the landscaped campus — priced from approximately ₹3.02 Crore. Each tower has 4 units per floor and 4 high-speed lifts, maintaining a low-density, privacy-focused living experience.</p>

                    <h3 class="font-semibold text-sm uppercase tracking-wider">ACE Group — Developer Profile</h3>
                    <p>ACE Group, formally ACE Infracity Developers Pvt. Ltd., has been active in Delhi-NCR real estate for over two decades. The company's portfolio includes residential, commercial and township projects totalling millions of delivered square feet. Key completed and ongoing projects include Ace City, Ace Divino, Ace Parkway, Ace Platinum and Ace Golf Shire across Greater Noida and the Yamuna Expressway corridor. ACE Group's corporate office is at Plot No. 01B, 7th Floor, Sector-126, Gautam Budh Nagar, UP.</p>

                    <h3 class="font-semibold text-sm uppercase tracking-wider">Club Spade Amenities at Ace Terra</h3>
                    <p>Club Spade is the lifestyle clubhouse at the centre of the Ace Terra community. Indoor amenities include a state-of-the-art gym, mini theatre, banquet hall, squash court, billiards room, business lounge, library, multi-cuisine cafeteria and unisex salon. The outdoor experience includes a swimming pool with poolside cabanas and jacuzzi, tennis court, basketball court, multi-sport courts, themed gardens, yoga deck, amphitheatre, jogging track, cycling path, kids play area, water features, meditation zone and a dedicated senior citizen area. Infrastructure includes 24x7 manned security, CCTV surveillance, power backup, rainwater harvesting and STP.</p>

                    <h3 class="font-semibold text-sm uppercase tracking-wider">Ace Terra Location and Yamuna Expressway Connectivity</h3>
                    <p>Sector 22D sits on the Yamuna Expressway, one of India's key arterial highways connecting Delhi to Agra (~160 km). Ace Terra is approximately 15–20 km from the under-construction Noida International Airport at Jewar — expected to become one of India's largest airports. Buddh International Circuit is roughly 10 km away. Pari Chowk, Greater Noida's commercial centre, is approximately 20 km north. Galgotias University is about 8 km from the project. The proposed Film City, Delhi-Mumbai Expressway connectivity and planned metro expansion further position the corridor as one of North India's most promising growth zones.</p>

                    <h3 class="font-semibold text-sm uppercase tracking-wider">Ace Terra Construction and RERA Status</h3>
                    <p>Construction at Ace Terra commenced in February 2024. The project is registered with UP-RERA under number UPRERAPRJ683816, with expected possession in December 2028. Buyers can verify all registered details on the official UP-RERA portal (up-rera.in). The construction-linked payment plan aligns financial commitments with project milestones.</p>

                    <h3 class="font-semibold text-sm uppercase tracking-wider">Why Ace Terra on the Yamuna Expressway</h3>
                    <p>The convergence of Jewar Airport, proposed Film City, Delhi-Mumbai Expressway interchange and metro connectivity plans makes the Yamuna Expressway corridor one of the most actively developing zones in the NCR. Ace Terra, backed by ACE Group's established delivery track record and RERA registration, offers families a nature-rich, amenity-dense community. Prospective buyers should independently verify all project details with the developer and relevant authorities before making investment decisions.</p>
                </div>
            </details>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     [14] CONTACT / FINAL CTA
     ═══════════════════════════════════════════════ -->
<footer id="contact" class="ace-footer py-20 md:py-28">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Form side -->
            <div>
                <p class="ace-eyebrow mb-4">Get in Touch</p>
                <h2 class="ace-heading text-2xl md:text-3xl text-white mb-2">Begin Your Ace Terra Journey</h2>
                <span class="ace-gold-line mb-8 block"></span>
                <form id="contact-form" action="process-form.php" method="POST" novalidate>
                    <input type="hidden" name="form_source" value="contact_form">
                    <div class="mb-5">
                        <label class="block text-xs font-600 uppercase tracking-wider text-gray-400 mb-2" style="font-weight:600;">Full Name</label>
                        <input name="name" type="text" required class="w-full bg-transparent border-b-2 border-gray-600 px-0 py-3 text-white focus:outline-none focus:border-[var(--ace-gold)] transition-colors" aria-label="Full Name">
                    </div>
                    <div class="mb-5">
                        <label class="block text-xs font-600 uppercase tracking-wider text-gray-400 mb-2" style="font-weight:600;">Email Address</label>
                        <input name="email" type="email" required class="w-full bg-transparent border-b-2 border-gray-600 px-0 py-3 text-white focus:outline-none focus:border-[var(--ace-gold)] transition-colors" aria-label="Email Address">
                    </div>
                    <div class="mb-8">
                        <label class="block text-xs font-600 uppercase tracking-wider text-gray-400 mb-2" style="font-weight:600;">Phone Number</label>
                        <input name="phone" type="tel" required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}"  title="Please enter a valid 10-digit Indian mobile number" class="w-full bg-transparent border-b-2 border-gray-600 px-0 py-3 text-white focus:outline-none focus:border-[var(--ace-gold)] transition-colors" aria-label="Phone Number">
                    </div>
                    <button type="submit" class="btn-primary w-full py-4" aria-label="Submit Enquiry">Submit Enquiry</button>
                </form>
            </div>
            <!-- Info side -->
            <div class="flex flex-col justify-center space-y-8 lg:pl-10">
                <div>
                    <p class="ace-eyebrow mb-3">Address</p>
                    <p class="text-white text-sm" style="line-height:1.8;">Sector 22D, Yamuna Expressway<br>Greater Noida, Uttar Pradesh</p>
                </div>
                <div>
                    <p class="ace-eyebrow mb-3">Sales</p>
                    <a href="tel:+919412234688" class="text-white text-lg font-300 tracking-wider hover:text-[var(--ace-gold)] transition-colors" style="font-weight:300;">+91 94122 34688</a>
                </div>
                <div>
                    <p class="ace-eyebrow mb-3">RERA</p>
                    <p class="text-gray-400 text-sm">UPRERAPRJ683816 (UP-RERA)</p>
                </div>
                <div>
                    <p class="ace-eyebrow mb-3">Possession</p>
                    <p class="text-gray-400 text-sm">December 2028</p>
                </div>
            </div>
        </div>

        <!-- Footer bottom -->
        <div class="mt-20 pt-8 border-t border-gray-700">
            <p class="text-gray-400 text-xs text-center mb-4">&copy; 2026 Ace Terra by ACE Group (ACE Infracity Developers Pvt. Ltd.). All rights reserved.</p>
            <p class="text-gray-500 text-[10px] text-center leading-relaxed max-w-4xl mx-auto">
                <strong>Disclaimer:</strong> The information, images and materials on this website are for general informational purposes only and do not constitute an offer, solicitation, or contract. All project details including pricing, specifications, amenities, layouts and availability are subject to change without notice at the sole discretion of the developer. Visuals are artistic impressions; actual products may vary. Prospective buyers are advised to verify all details independently with the developer and on the UP-RERA portal (up-rera.in). RERA Registration No.: UPRERAPRJ683816.
            </p>
        </div>
    </div>
</footer>


<!-- ═══════════════════════════════════════════════
     FLOATING ELEMENTS
     ═══════════════════════════════════════════════ -->

<!-- WhatsApp -->
<a href="https://wa.me/919412234688?text=Hello!%20I'm%20interested%20in%20Ace%20Terra.%20Please%20provide%20more%20details." target="_blank" class="fixed bottom-6 right-6 bg-green-500 text-white p-3.5 rounded-full shadow-lg z-40 hidden sm:flex hover:scale-110 transition-transform" aria-label="WhatsApp Ace Terra Sales">
    <img src="./assets/whatsapp" alt="WhatsApp" width="28" height="28">
</a>

<!-- Mobile Bottom Bar -->
<div id="mobile-bottom-bar" class="fixed bottom-0 left-0 right-0 z-50 flex sm:hidden bg-white border-t border-gray-200 shadow-lg transition-transform duration-300" role="region" aria-label="Quick actions">
    <a href="tel:+919412234688" class="flex-1 flex flex-col items-center justify-center py-3 text-xs uppercase tracking-wider font-600" style="font-weight:600;color:var(--ace-navy);" aria-label="Call Sales">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        Call
    </a>
    <button id="mobile-enquire-btn" class="flex-1 flex flex-col items-center justify-center py-3 text-xs uppercase tracking-wider font-600 focus:outline-none" style="font-weight:600;color:var(--ace-navy);" aria-label="Enquire">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        Enquire
    </button>
    <a href="https://wa.me/919412234688?text=Hello!%20I'm%20interested%20in%20Ace%20Terra.%20Please%20provide%20more%20details." target="_blank" class="flex-1 flex flex-col items-center justify-center py-3 text-xs uppercase tracking-wider font-600 text-green-600" style="font-weight:600;" aria-label="WhatsApp">
        <img src="./assets/whatsapp" alt="WhatsApp" width="20" height="20">
        WhatsApp
    </a>
</div>


<!-- ═══════════════════════════════════════════════
     POPUP FORM — ACE style with purple gradient header
     ═══════════════════════════════════════════════ -->
<div id="popup-form" class="popup fixed inset-0 bg-black/60 backdrop-blur-sm z-50 items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="popup-title" aria-describedby="popup-desc">
    <div class="bg-white w-full max-w-md relative shadow-2xl" style="box-shadow:0 25px 50px rgba(0,0,0,0.25);">
        <button id="close-popup" class="absolute top-3 right-4 text-gray-400 hover:text-black text-3xl z-10" aria-label="Close">&times;</button>
        <!-- Purple gradient header — ACE signature -->
        <div class="py-6 px-8 text-center text-white" style="background:linear-gradient(135deg,var(--gradient-start),var(--gradient-end));">
            <h2 id="popup-title" class="ace-heading text-lg text-white">Interested in Ace Terra?</h2>
            <p id="popup-desc" class="text-white/80 text-xs mt-1">Get the brochure, floor plans and exclusive offers.</p>
        </div>
        <div class="p-8">
            <form id="popup-contact-form" action="process-form.php" method="POST" novalidate>
                <input type="hidden" name="form_source" value="popup_form">
                <div class="mb-5">
                    <label class="block text-[11px] font-600 uppercase tracking-wider mb-2" style="font-weight:600;color:var(--ace-gray-700);">Full Name</label>
                    <input name="name" type="text" required class="w-full border-2 border-gray-200 px-4 py-3 text-sm focus:outline-none focus:border-[var(--gradient-start)] transition-all" aria-label="Full Name">
                </div>
                <div class="mb-5">
                    <label class="block text-[11px] font-600 uppercase tracking-wider mb-2" style="font-weight:600;color:var(--ace-gray-700);">Email Address</label>
                    <input name="email" type="email" required class="w-full border-2 border-gray-200 px-4 py-3 text-sm focus:outline-none focus:border-[var(--gradient-start)] transition-all" aria-label="Email Address">
                </div>
                <div class="mb-6">
                    <label class="block text-[11px] font-600 uppercase tracking-wider mb-2" style="font-weight:600;color:var(--ace-gray-700);">Phone Number</label>
                    <input name="phone" type="tel" required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}"  title="Please enter a valid 10-digit Indian mobile number" class="w-full border-2 border-gray-200 px-4 py-3 text-sm focus:outline-none focus:border-[var(--gradient-start)] transition-all" aria-label="Phone Number">
                </div>
                <button type="submit" class="btn-secondary w-full py-3.5" aria-label="Get Ace Terra Details">Get Details</button>
            </form>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════
     STRUCTURED DATA (4 JSON-LD blocks)
     ═══════════════════════════════════════════════ -->

<!-- Schema 1: ApartmentComplex -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ApartmentComplex",
  "name": "Ace Terra",
  "alternateName": "Ace Terra Sector 22D Yamuna Expressway",
  "description": "Ace Terra is an 11-acre luxury residential project by ACE Group in Sector 22D, Yamuna Expressway, Greater Noida. ~1,166 residences of 3 BHK, 3 BHK+SQ and 4 BHK+SQ across 12 towers (G+25 floors). Starting ₹1.77 Cr. Possession December 2028. RERA: UPRERAPRJ683816.",
  "url": "https://aceterrayamunaexpressway.in/",
  "image": ["https://aceterrayamunaexpressway.in/assets/hero-bg.png","https://aceterrayamunaexpressway.in/assets/image1.webp","https://aceterrayamunaexpressway.in/assets/image2.webp"],
  "telephone": "+919412234688",
  "numberOfAccommodationUnits": 1166,
  "address": {"@type":"PostalAddress","streetAddress":"Plot P5 & P6, TS-02/A, Sector 22D, Yamuna Expressway","addressLocality":"Greater Noida","addressRegion":"Uttar Pradesh","postalCode":"203135","addressCountry":"IN"},
  "geo": {"@type":"GeoCoordinates","latitude":"28.384288","longitude":"77.597658"},
  "brand": {"@type":"Brand","name":"ACE Group","url":"https://www.acegroupindia.com/"},
  "hasMap": "https://www.google.com/maps/search/?api=1&query=Ace+Terra+Sector+22D+Yamuna+Expressway",
  "containsPlace": [
    {"@type":"Apartment","name":"3 BHK at Ace Terra","numberOfRooms":3,"floorSize":{"@type":"QuantitativeValue","value":1770,"unitCode":"FTK"}},
    {"@type":"Apartment","name":"3 BHK + SQ at Ace Terra","numberOfRooms":3,"floorSize":{"@type":"QuantitativeValue","value":2395,"unitCode":"FTK"}},
    {"@type":"Apartment","name":"4 BHK + SQ at Ace Terra","numberOfRooms":4,"floorSize":{"@type":"QuantitativeValue","value":3025,"unitCode":"FTK"}}
  ],
  "amenityFeature": [
    {"@type":"LocationFeatureSpecification","name":"Club Spade Clubhouse"},
    {"@type":"LocationFeatureSpecification","name":"Swimming Pool with Cabanas"},
    {"@type":"LocationFeatureSpecification","name":"Tennis Court"},
    {"@type":"LocationFeatureSpecification","name":"Mini Theatre"},
    {"@type":"LocationFeatureSpecification","name":"State-of-the-Art Gym"},
    {"@type":"LocationFeatureSpecification","name":"Banquet Hall"},
    {"@type":"LocationFeatureSpecification","name":"Themed Gardens & Yoga Deck"},
    {"@type":"LocationFeatureSpecification","name":"Multi-Sport Courts"},
    {"@type":"LocationFeatureSpecification","name":"Kids Play Area"},
    {"@type":"LocationFeatureSpecification","name":"Jacuzzi & Water Features"}
  ],
  "seller": {"@type":"Organization","name":"ACE Group","alternateName":"ACE Infracity Developers Pvt. Ltd.","url":"https://www.acegroupindia.com/"},
  "offers": {"@type":"AggregateOffer","lowPrice":"17700000","priceCurrency":"INR","availability":"https://schema.org/InStock"}
}
</script>

<!-- Schema 2: Organization -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "ACE Group",
  "alternateName": "ACE Infracity Developers Pvt. Ltd.",
  "url": "https://www.acegroupindia.com/",
  "description": "ACE Group is a prominent Delhi-NCR real estate developer with over two decades of experience, delivering residential, commercial and township projects across Greater Noida and Yamuna Expressway.",
  "address": {"@type":"PostalAddress","streetAddress":"7th Floor, Plot No. 01B, Sector-126","addressLocality":"Gautam Budh Nagar","addressRegion":"Uttar Pradesh","postalCode":"201303","addressCountry":"IN"}
}
</script>

<!-- Schema 3: FAQPage -->
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"FAQPage",
  "mainEntity":[
    {"@type":"Question","name":"What is Ace Terra and where is it located?","acceptedAnswer":{"@type":"Answer","text":"Ace Terra is an 11-acre luxury residential project by ACE Group in Sector 22D, Yamuna Expressway, Greater Noida, Uttar Pradesh. It offers ~1,166 apartments across 12 towers (G+25 floors) with over 70% open green spaces. The project is approximately 15–20 km from the upcoming Jewar International Airport."}},
    {"@type":"Question","name":"Who is the developer of Ace Terra?","acceptedAnswer":{"@type":"Answer","text":"Ace Terra is developed by ACE Group (ACE Infracity Developers Pvt. Ltd.), a Delhi-NCR real estate developer with over two decades of experience. ACE Group has delivered millions of square feet across projects including Ace City, Ace Divino, Ace Parkway, Ace Platinum and Ace Golf Shire."}},
    {"@type":"Question","name":"What apartment sizes and configurations are available at Ace Terra?","acceptedAnswer":{"@type":"Answer","text":"Ace Terra offers three configurations: 3 BHK (1,770 sq ft), 3 BHK with Servant Quarter (2,395 sq ft) and 4 BHK with Servant Quarter (3,025 sq ft). Each unit includes balconies, modular kitchen provisions and premium finishes. Towers have 4 units per floor served by 4 high-speed lifts."}},
    {"@type":"Question","name":"What is the price of apartments in Ace Terra Yamuna Expressway?","acceptedAnswer":{"@type":"Answer","text":"The 3 BHK (1,770 sq ft) starts from ₹1.77 Crore, the 3 BHK+SQ (2,395 sq ft) from approximately ₹2.40 Crore, and the 4 BHK+SQ (3,025 sq ft) from approximately ₹3.02 Crore. Prices are indicative — contact the sales team for the current price sheet."}},
    {"@type":"Question","name":"Is Ace Terra RERA registered?","acceptedAnswer":{"@type":"Answer","text":"Yes. Ace Terra is registered with UP-RERA under registration number UPRERAPRJ683816. All project details can be verified on the official UP-RERA portal at up-rera.in."}},
    {"@type":"Question","name":"When is the possession date for Ace Terra?","acceptedAnswer":{"@type":"Answer","text":"The expected possession date is December 2028 as per the RERA filing. Construction began in February 2024. Buyers should verify the latest timeline with the developer or on the UP-RERA portal."}},
    {"@type":"Question","name":"How many towers and apartments are there in Ace Terra?","acceptedAnswer":{"@type":"Answer","text":"Ace Terra has 12 residential towers, each G+25 floors, with approximately 1,166 apartments across roughly 11 acres. Over 70% of the project area is dedicated to landscaped greens."}},
    {"@type":"Question","name":"What amenities does Ace Terra offer?","acceptedAnswer":{"@type":"Answer","text":"The Club Spade clubhouse includes a swimming pool with cabanas, jacuzzi, tennis court, squash court, billiards room, basketball court, mini theatre, gym, banquet hall, cafeteria, business lounge, library and unisex salon. Outdoor amenities include themed gardens, yoga deck, amphitheatre, jogging track, cycling path, meditation zone, kids play area, water features and senior citizen area."}},
    {"@type":"Question","name":"How far is Ace Terra from Jewar Airport?","acceptedAnswer":{"@type":"Answer","text":"Ace Terra in Sector 22D is approximately 15–20 km from the under-construction Noida International Airport at Jewar. The project has direct Yamuna Expressway frontage, is ~10 km from Buddh International Circuit and ~20 km from Pari Chowk, Greater Noida."}},
    {"@type":"Question","name":"How can I get the Ace Terra brochure and floor plan?","acceptedAnswer":{"@type":"Answer","text":"Click any Enquire Now or Get Price Details button on this page and submit your name, email and phone. The Ace Terra sales team will share the official brochure, detailed floor plans and the current price list."}},
    {"@type":"Question","name":"What is the Ace Terra payment plan?","acceptedAnswer":{"@type":"Answer","text":"Ace Terra uses a construction-linked payment plan: 10% on booking, 15% within 30 days, then payments at foundation, superstructure, brickwork, flooring and possession stages. Contact sales for the confirmed schedule."}},
    {"@type":"Question","name":"Is Ace Terra a good investment near Jewar Airport?","acceptedAnswer":{"@type":"Answer","text":"Ace Terra sits on the Yamuna Expressway, ~15–20 km from Jewar International Airport, near the proposed Film City and Delhi-Mumbai Expressway interchange. ACE Group's established track record and RERA registration add credibility. All investment decisions should be made after independent due diligence."}}
  ]
}
</script>

<!-- Schema 4: BreadcrumbList -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type":"ListItem","position":1,"name":"Home","item":"https://aceterrayamunaexpressway.in/"},
    {"@type":"ListItem","position":2,"name":"Residences","item":"https://aceterrayamunaexpressway.in/#pricing"},
    {"@type":"ListItem","position":3,"name":"Amenities","item":"https://aceterrayamunaexpressway.in/#amenities"},
    {"@type":"ListItem","position":4,"name":"Location","item":"https://aceterrayamunaexpressway.in/#location"},
    {"@type":"ListItem","position":5,"name":"FAQ","item":"https://aceterrayamunaexpressway.in/#faq"},
    {"@type":"ListItem","position":6,"name":"Contact","item":"https://aceterrayamunaexpressway.in/#contact"}
  ]
}
</script>

<!-- Main JS -->
<script src="js/main.js"></script>
</body>
</html>
