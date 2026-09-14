<?php

declare(strict_types=1);
/* Configure verified values here before launch. Keep indexable false until reviewed. */
$config = [
    'brand' => 'Synq Highlife',
    'url' => 'https://synqhighlife.com/',
    'indexable' => true,
];
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('X-Frame-Options: SAMEORIGIN');
session_set_cookie_params(['httponly' => true, 'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'), 'samesite' => 'Lax']);
session_start();
function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
// Enquiries are handled by process-form.php via the shared CRM lead handler;
// on return it flashes a result here through the session (see lead_form_finish()).
$success = $_SESSION['form_success'] ?? false;
$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_success'], $_SESSION['form_errors']);
$faqs = [
    ['What homes does Synq Highlife offer?', 'Synq Highlife is presented as fully furnished, AI-enabled 1 and 2 BHK apartments. Confirm the unit-specific layout, carpet area and availability with the project team before choosing a home.'],
    ['What is included in “fully furnished”?', 'The final furniture, appliance and finish schedule has not yet been published here. Request a written inventory for your chosen apartment, including brands, warranties and any exclusions.'],
    ['What does an AI-enabled home include?', 'The exact devices and integrations are awaiting confirmation. Before booking, ask which controls are included, whether internet or subscriptions are required, and how manual controls, privacy and ongoing support work.'],
    ['Where is the project, and what is the price?', 'The verified project address, price list and area statement have not yet been supplied for this website. Request these along with taxes, maintenance charges and other costs before making a decision.'],
    ['Where can I check RERA and possession details?', 'The developer identity, applicable RERA registration and possession schedule are awaiting verification. Obtain the official documents and check the relevant state RERA portal before making any payment.'],
];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Synq Highlife | Fully Furnished AI 1 &amp; 2 BHK Apartments</title>
    <meta name="description" content="Explore Synq Highlife fully furnished, AI-enabled 1 and 2 BHK apartments. Compare home options and learn what to verify about furnishing, smart features and project details.">
    <meta name="robots" content="<?= $config['indexable'] ? 'index, follow, max-image-preview:large' : 'noindex, follow' ?>">
    <link rel="canonical" href="<?= esc($config['url']) ?>">
    <meta name="theme-color" content="#005b52">
    <meta property="og:type" content="website">
    <meta property="og:title" content="SYNQ Highlife Greater Noida West | Smart AI Homes">
    <meta property="og:description" content="SYNQ Highlife in Greater Noida West with fully furnished 1 & 2 BHK homes, AI-enabled automation, premium interiors and modern amenities.">
    <meta property="og:url" content="<?= esc($config['url']) ?>">
    <link rel="icon" href="assets/favicon.svg" type="image/svg+xml">
    <link rel="preload" as="image" href="assets/interior.webp">
    <script type="application/ld+json">
        <?= json_encode(['@context' => 'https://schema.org', '@type' => 'WebSite', 'name' => $config['brand'], 'url' => $config['url'], 'description' => 'Fully furnished, AI-enabled 1 and 2 BHK apartments.'], JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) ?>
    </script>
    <style>
        :root {
            --green: #005b52;
            --dark: #073e38;
            --ink: #173c37;
            --muted: #65736c;
            --cream: #faf8f2;
            --sand: #f0ece2;
            --gold: #b59660;
            --line: #d9ddd3;
            --white: #fff;
            --radius: 20px
        }

        * {
            box-sizing: border-box
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 105px
        }

        body {
            margin: 0;
            background: var(--cream);
            color: var(--ink);
            font: 16px/1.65 Arial, Helvetica, sans-serif
        }

        body.modal-open {
            overflow: hidden
        }

        button,
        input,
        select {
            font: inherit
        }

        button,
        a,
        input,
        select,
        summary {
            touch-action: manipulation
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent
        }

        button {
            cursor: pointer
        }

        a {
            color: inherit
        }

        h1,
        h2,
        h3,
        p,
        figure {
            margin: 0
        }

        h1,
        h2,
        h3 {
            font-family: Georgia, 'Times New Roman', serif;
            font-weight: 400;
            line-height: 1.08
        }

        h1 {
            font-size: clamp(3.9rem, 6.3vw, 6.8rem);
            letter-spacing: -.055em
        }

        h2 {
            font-size: clamp(2.5rem, 4.5vw, 4.5rem);
            letter-spacing: -.035em
        }

        h3 {
            font-size: 1.8rem
        }

        em {
            font-weight: 400;
            color: var(--green)
        }

        img {
            display: block;
            max-width: 100%
        }

        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible,
        summary:focus-visible {
            outline: 3px solid #b18037;
            outline-offset: 5px
        }

        [hidden] {
            display: none !important
        }

        .wrap {
            width: min(1320px, 90%);
            margin: auto
        }

        .section {
            padding: 105px 0
        }

        .eyebrow {
            text-transform: uppercase;
            letter-spacing: .18em;
            font-size: .75rem;
            font-weight: 700;
            margin-bottom: 22px
        }

        .eyebrow .dash {
            display: inline-block;
            vertical-align: middle;
            width: 26px;
            height: 1px;
            background: var(--gold);
            margin-right: 12px
        }

        .muted {
            color: var(--muted)
        }

        .note {
            font-size: .8125rem;
            color: var(--muted);
            line-height: 1.6
        }

        .button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 32px;
            padding: 15px 23px;
            margin-top: 16px;
            min-height: 53px;
            border: 1px solid var(--green);
            border-radius: 5px;
            background: var(--green);
            color: #fff;
            text-decoration: none;
            font-size: .875rem;
            transition: transform .25s, box-shadow .25s, background .25s
        }

        .button:hover {
            background: var(--dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 24px #005b521c
        }

        .button.outline {
            background: transparent;
            color: var(--green);
            border-color: #adbab0
        }

        .button.light {
            background: var(--cream);
            color: var(--green);
            border-color: var(--cream)
        }

        .button:disabled {
            opacity: .65;
            cursor: not-allowed;
            transform: none;
            box-shadow: none
        }

        .text-link {
            font-size: .875rem;
            text-decoration: none;
            border-bottom: 1px solid var(--gold);
            padding-bottom: 7px;
            display: inline-block
        }

        .text-link:hover {
            color: #8c692f
        }

        .skip {
            position: absolute;
            top: -100px;
            z-index: 99;
            background: white;
            padding: 15px
        }

        .skip:focus {
            top: 10px
        }

        .topbar {
            text-align: center;
            font-size: .7rem;
            letter-spacing: .12em;
            padding: 8px 15px;
            background: #ebeade;
            color: #375b4c;
            text-transform: uppercase
        }

        header {
            position: sticky;
            top: 0;
            z-index: 30;
            background: #faf8f2f5;
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(18px)
        }

        .nav {
            min-height: 88px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px
        }

        .brand {
            display: flex;
            flex-direction: column;
            text-decoration: none;
            line-height: 1;
            flex-shrink: 0
        }

        .brand strong {
            font: 400 2.3rem/.9 Georgia, serif;
            letter-spacing: .1em
        }

        .brand span {
            font-size: .625rem;
            letter-spacing: .35em;
            margin-top: 9px
        }

        .links {
            display: flex;
            align-items: center;
            gap: 20px
        }

        .links a {
            font-size: .8125rem;
            text-decoration: none;
            white-space: nowrap;
            position: relative;
            padding: 8px 0
        }

        .links a:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: var(--green);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .25s
        }

        .links a[aria-current],
        .links a:hover {
            color: var(--green)
        }

        .links a[aria-current]:after,
        .links a:hover:after {
            transform: scaleX(1)
        }

        .nav .button {
            padding: 10px 18px;
            min-height: 44px
        }

        .menu {
            display: none;
            border: 1px solid var(--line);
            background: transparent;
            padding: 9px 14px;
            border-radius: 5px;
            color: var(--green)
        }

        .progress {
            position: absolute;
            left: 0;
            bottom: -1px;
            width: 100%;
            height: 2px;
            background: var(--gold);
            transform-origin: left;
            transform: scaleX(0)
        }

        .hero {
            padding: 60px 0 55px;
            overflow: clip
        }

        .hero-grid {
            display: grid;
            grid-template-columns: .83fr 1.17fr;
            gap: 45px;
            align-items: center
        }

        .hero-copy {
            padding: 20px 0 25px;
            position: relative;
            z-index: 2
        }

        .hero-copy h1 {
            margin-bottom: 28px
        }

        .hero-copy>p:not(.eyebrow) {
            max-width: 350px;
            color: var(--muted)
        }

        .hero-actions {
            display: flex;
            gap: 22px;
            align-items: center;
            margin-top: 32px;
            flex-wrap: wrap
        }

        .hero-actions .text-link {
            font-size: .8125rem
        }

        .mini {
            display: flex;
            gap: 32px;
            margin-top: 45px
        }

        .mini>div {
            border-left: 1px solid var(--gold);
            padding-left: 14px
        }

        .mini b {
            display: block;
            font: 1.7rem Georgia, serif
        }

        .mini span {
            font-size: .6875rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--muted)
        }

        .hero-stage {
            perspective: 1400px;
            position: relative;
            padding: 20px 0 48px
        }

        .scene {
            position: relative;
            transform-style: preserve-3d;
            transform: rotateX(var(--rx, 0deg)) rotateY(var(--ry, -3deg));
            transition: transform .22s ease-out;
            will-change: transform
        }

        .scene-frame {
            position: relative;
            border-radius: 130px 14px 14px 14px;
            overflow: hidden;
            box-shadow: 15px 24px 45px #113f3324;
            height: 590px;
            background: #dfdbcf;
            border: 7px solid #fff;
            isolation: isolate
        }

        .scene-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: filter 1s ease;
            filter: brightness(var(--brightness, 1)) saturate(var(--saturation, 1))
        }

        .scene-frame:after {
            content: '';
            position: absolute;
            inset: 0;
            border: 1px solid #ffffff40;
            pointer-events: none
        }

        .scene-label {
            position: absolute;
            top: 34px;
            right: 25px;
            transform: translateZ(45px);
            background: #ffffffd9;
            backdrop-filter: blur(15px);
            padding: 10px 17px;
            border: 1px solid white;
            border-radius: 50px;
            color: var(--green);
            font-size: .75rem;
            display: flex;
            align-items: center;
            gap: 10px
        }

        .signal {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--green);
            box-shadow: 0 0 0 5px #005b5210
        }

        .scene-card {
            position: absolute;
            left: -22px;
            bottom: 12px;
            transform: translateZ(70px);
            background: #fffcf4ed;
            backdrop-filter: blur(20px);
            width: 280px;
            padding: 22px 24px;
            border-radius: 15px;
            border: 1px solid #fff;
            box-shadow: 0 18px 55px #12392f24
        }

        .scene-card .eyebrow {
            font-size: .65rem;
            margin-bottom: 9px
        }

        .scene-card h2 {
            font-size: 1.9rem;
            margin: 0 0 18px;
            letter-spacing: -.02em
        }

        .mode-buttons {
            display: flex;
            background: #e8eee6;
            border-radius: 7px;
            padding: 4px;
            gap: 2px
        }

        .mode-buttons button {
            flex: 1;
            border: 0;
            background: transparent;
            color: var(--green);
            font-size: .75rem;
            padding: 8px;
            border-radius: 5px
        }

        .mode-buttons button[aria-pressed=true] {
            background: white;
            box-shadow: 0 2px 8px #002e2612
        }

        .scene-card .note {
            font-size: .6875rem;
            margin-top: 10px
        }

        .scene-feature {
            position: absolute;
            right: -13px;
            top: 49%;
            padding: 17px 20px;
            background: var(--green);
            color: white;
            box-shadow: 0 15px 30px #005b5225;
            border-radius: 12px;
            transform: translateZ(55px)
        }

        .scene-feature small {
            display: block;
            font-size: .65rem;
            letter-spacing: .13em
        }

        .scene-feature b {
            font: 1.35rem Georgia, serif;
            display: block;
            margin-top: 4px
        }

        .scene-caption {
            position: absolute;
            bottom: 13px;
            right: 0;
            font-size: .6875rem;
            color: var(--muted);
            max-width: 52%;
            text-align: right;
            line-height: 1.45
        }

        .scene-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 17px 0 0 35%;
            gap: 14px
        }

        .scene-toolbar label {
            font-size: .7rem;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0
        }

        .scene-toolbar input {
            width: 75px;
            accent-color: var(--green)
        }

        .motion-toggle {
            border: 0;
            background: transparent;
            color: var(--muted);
            font-size: .6875rem;
            padding: 7px 0;
            border-bottom: 1px solid var(--line);
            white-space: nowrap
        }

        .intro-strip {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line)
        }

        .intro-strip div {
            padding: 28px 30px;
            display: flex;
            align-items: center;
            gap: 16px
        }

        .intro-strip div+div {
            border-left: 1px solid var(--line)
        }

        .intro-strip svg {
            width: 30px;
            height: 30px;
            flex-shrink: 0;
            color: var(--green);
            stroke-width: 1.2
        }

        .intro-strip b {
            font: 1.25rem Georgia, serif;
            display: block
        }

        .intro-strip span {
            font-size: .75rem;
            color: var(--muted)
        }

        .section-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 50px;
            margin-bottom: 45px
        }

        .section-head>p {
            max-width: 350px;
            color: var(--muted)
        }

        .overview-grid {
            display: grid;
            grid-template-columns: 1.08fr .92fr;
            gap: 9%;
            align-items: center
        }

        .overview-copy p:not(.eyebrow) {
            color: var(--muted);
            margin-top: 25px;
            max-width: 550px
        }

        .overview-copy .text-link {
            margin-top: 28px
        }

        .overview-specs {
            background: #eef0e7;
            padding: 30px 35px;
            border-radius: var(--radius)
        }

        .overview-specs>p {
            font-size: .75rem;
            letter-spacing: .15em;
            margin-bottom: 13px
        }

        .overview-specs dl {
            margin: 0
        }

        .overview-specs dl div {
            display: flex;
            justify-content: space-between;
            gap: 25px;
            padding: 17px 0;
            border-top: 1px solid #d1d8cc
        }

        .overview-specs dt {
            font-size: .875rem;
            color: var(--muted)
        }

        .overview-specs dd {
            margin: 0;
            font-weight: 500;
            text-align: right
        }

        .soft-section {
            background: var(--sand)
        }

        .price-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px
        }

        .price-card {
            background: #fffefa;
            border: 1px solid #dddccd;
            border-radius: var(--radius);
            padding: 36px;
            transition: transform .3s, box-shadow .3s;
            position: relative;
            overflow: hidden
        }

        .price-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 40px #3848310c
        }

        .price-top {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 20px
        }

        .price-top h3 {
            font-size: 2.8rem
        }

        .tag {
            font-size: .6875rem;
            border: 1px solid #cbd7cb;
            border-radius: 30px;
            padding: 5px 11px;
            color: var(--green)
        }

        .price-card .subtitle {
            font-size: .875rem;
            color: var(--muted);
            margin-top: 15px
        }

        .price-value {
            margin: 33px 0 25px;
            font: 1.7rem Georgia, serif
        }

        .price-value small {
            font: normal .75rem Arial, serif;
            display: block;
            color: var(--muted);
            margin-top: 10px
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 13px 0;
            border-top: 1px solid var(--line);
            font-size: .8125rem
        }

        .price-row span:first-child {
            color: var(--muted)
        }

        .price-card .button {
            width: 100%;
            margin-top: 25px;
            justify-content: space-between
        }

        .cost-note {
            font-size: .8125rem;
            color: var(--muted);
            margin-top: 24px;
            max-width: 950px
        }

        .plan-switch {
            display: flex;
            gap: 10px
        }

        .plan-switch button {
            border: 1px solid #bec9be;
            background: transparent;
            padding: 12px 25px;
            color: var(--green);
            border-radius: 5px;
            min-height: 48px
        }

        .plan-switch button[aria-selected=true] {
            background: var(--green);
            color: #fff
        }

        .plan-panel {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            overflow: hidden;
            margin-top: 25px
        }

        .plan-document {
            padding: 45px;
            background: #e9eee4;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 340px
        }

        .plan-paper {
            background: #fafbf6;
            border: 1px solid #d2dacb;
            box-shadow: 14px 16px 0 #d8e0d2;
            padding: 38px;
            text-align: center;
            width: 100%;
            max-width: 330px;
            transform: perspective(900px) rotateY(-9deg) rotateX(4deg);
            transition: transform .6s
        }

        .plan-panel:hover .plan-paper {
            transform: perspective(900px) rotateY(0deg) rotateX(0deg)
        }

        .plan-paper svg {
            width: 40px;
            height: 40px;
            margin: auto auto 16px;
            color: #66816b;
            stroke-width: 1.3
        }

        .plan-paper p {
            font: 1.7rem Georgia, serif
        }

        .plan-paper small {
            font-size: .75rem;
            color: var(--muted);
            display: block;
            margin-top: 12px
        }

        .plan-info {
            padding: 45px;
            align-self: center
        }

        .plan-info h3 {
            font-size: 2.4rem;
            margin-bottom: 20px
        }

        .plan-info>p {
            color: var(--muted)
        }

        .plan-info ul {
            padding-left: 20px;
            font-size: .875rem;
            color: var(--muted);
            margin: 22px 0 25px
        }

        .amenity-intro {
            max-width: 690px;
            color: var(--muted);
            margin-top: 25px
        }

        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            margin-top: 40px;
            border-top: 1px solid #cbd5c6;
            border-left: 1px solid #cbd5c6
        }

        .amenity {
            padding: 33px;
            border-right: 1px solid #cbd5c6;
            border-bottom: 1px solid #cbd5c6;
            transition: background .3s
        }

        .amenity:hover {
            background: #fff8
        }

        .amenity svg {
            width: 30px;
            height: 30px;
            stroke-width: 1.3;
            margin-bottom: 25px;
            color: var(--green);
            transition: transform .3s
        }

        .amenity:hover svg {
            transform: translateY(-5px) rotate(-5deg)
        }

        .amenity h3 {
            font-size: 1.55rem;
            margin-bottom: 15px
        }

        .amenity p {
            font-size: .875rem;
            color: var(--muted)
        }

        .amenity small {
            display: block;
            color: #6c715e;
            font-size: .6875rem;
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: .08em
        }

        .sage {
            background: #eef1e8
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            grid-template-rows: 250px 250px;
            gap: 20px
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 13px;
            background: #ddd9d0;
            margin: 0
        }

        .gallery-item:first-child {
            grid-row: 1/3
        }

        .gallery-item>a {
            display: block;
            width: 100%;
            height: 100%;
            cursor: zoom-in
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .8s
        }

        .gallery-item:hover img {
            transform: scale(1.04)
        }

        .gallery-caption {
            position: absolute;
            left: 16px;
            right: 16px;
            bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            background: #fffef0eb;
            padding: 13px 17px;
            border-radius: 8px;
            pointer-events: none;
            color: var(--green);
            backdrop-filter: blur(12px)
        }

        .gallery-caption span {
            font: 1.3rem Georgia, serif
        }

        .gallery-caption small {
            font-size: .625rem;
            letter-spacing: .1em;
            text-transform: uppercase
        }

        .gallery-caption b {
            font-weight: 400;
            font-size: 1.5rem
        }

        .gallery-note {
            margin-top: 20px;
            font-size: .75rem;
            color: var(--muted)
        }

        .location-layout {
            display: grid;
            grid-template-columns: 1fr .95fr;
            gap: 8%;
            align-items: center
        }

        .location-layout h2 {
            margin-bottom: 28px
        }

        .location-layout p:not(.eyebrow) {
            color: var(--muted)
        }

        .location-panel {
            border: 1px solid #c8d3c3;
            border-radius: var(--radius);
            padding: 36px;
            background: #fcfcf5
        }

        .location-panel svg {
            width: 38px;
            height: 38px;
            stroke-width: 1.2;
            margin-bottom: 25px
        }

        .location-panel h3 {
            font-size: 1.8rem;
            margin-bottom: 18px
        }

        .location-panel dl {
            margin: 25px 0 0
        }

        .location-panel dl div {
            padding: 13px 0;
            border-top: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            gap: 20px;
            font-size: .8125rem
        }

        .location-panel dt {
            color: var(--muted)
        }

        .location-panel dd {
            margin: 0;
            text-align: right
        }

        .location-check {
            margin-top: 30px;
            display: grid;
            gap: 14px
        }

        .location-check span {
            font-size: .875rem;
            padding-left: 22px;
            position: relative
        }

        .location-check span:before {
            content: '↗';
            position: absolute;
            left: 0;
            color: var(--gold)
        }

        .about-grid {
            display: grid;
            grid-template-columns: .65fr 1.35fr;
            gap: 10%;
            align-items: start
        }

        .about-wordmark {
            border: 1px solid var(--line);
            min-height: 290px;
            border-radius: 50% 50% 8px 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eeeee3
        }

        .about-wordmark .brand strong {
            font-size: 3.8rem
        }

        .about-wordmark .brand span {
            font-size: .8rem;
            text-align: center
        }

        .about-copy>p:not(.eyebrow) {
            color: var(--muted);
            margin-top: 24px;
            max-width: 630px
        }

        .about-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 30px
        }

        .about-meta span {
            border-bottom: 1px solid var(--gold);
            font-size: .75rem;
            padding-bottom: 8px
        }

        .faq-layout {
            display: grid;
            grid-template-columns: .8fr 1.2fr;
            gap: 8%
        }

        .faq-layout h2 {
            margin-bottom: 25px
        }

        .faq-layout>div>p:not(.eyebrow) {
            color: var(--muted)
        }

        details {
            border-bottom: 1px solid var(--line);
            padding: 22px 0
        }

        details:first-child {
            border-top: 1px solid var(--line)
        }

        summary {
            cursor: pointer;
            list-style: none;
            display: flex;
            justify-content: space-between;
            gap: 25px;
            font-size: 1rem
        }

        summary::-webkit-details-marker {
            display: none
        }

        summary:after {
            content: '+';
            font-size: 1.3rem;
            line-height: 1.2;
            color: var(--green)
        }

        details[open] summary:after {
            content: '−'
        }

        details p {
            padding-top: 16px;
            color: var(--muted);
            font-size: .875rem
        }

        .enquire {
            background: var(--green);
            color: var(--cream)
        }

        .enquiry-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 9%
        }

        .enquiry-layout h2 {
            font-size: clamp(2.5rem, 4.5vw, 4.5rem)
        }

        .enquiry-layout>div>p:not(.eyebrow) {
            margin-top: 25px;
            color: #e0e9df
        }

        .enquire .eyebrow {
            color: #e8d6b1
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px
        }

        .enquiry-layout form .button {
            width: 100%
        }

        .field {
            font-size: .8125rem
        }

        .field input,
        .field select {
            width: 100%;
            display: block;
            margin-top: 8px;
            background: #ffffff10;
            border: 1px solid #b4cbb570;
            border-radius: 5px;
            padding: 12px;
            color: white;
            min-height: 48px
        }

        .field select option {
            color: var(--ink);
            background: white
        }

        .field input:focus,
        .field select:focus {
            background: #ffffff20
        }

        .consent {
            display: flex;
            align-items: start;
            gap: 10px;
            margin: 22px 0;
            font-size: .75rem
        }

        .consent input {
            width: 18px;
            height: 18px;
            flex-shrink: 0
        }

        .hp {
            position: absolute;
            left: -10000px
        }

        .privacy {
            font-size: .75rem;
            margin-top: 15px;
            color: #d4e3d2
        }

        .alert {
            padding: 16px;
            border: 1px solid #e6cca0;
            margin-bottom: 20px
        }

        .alert ul {
            margin: 0;
            padding-left: 20px
        }

        .legal {
            padding: 45px 0;
            font-size: .75rem;
            color: var(--muted)
        }

        .legal h3 {
            font: 700 .875rem Arial;
            margin-bottom: 13px
        }

        .legal>p {
            max-width: 1100px
        }

        .legal details {
            margin-top: 15px
        }

        .legal summary {
            font-size: .875rem
        }

        .legal details p {
            font-size: .75rem
        }

        .footer-inner {
            border-top: 1px solid var(--line);
            padding: 30px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px
        }

        .footer-inner p {
            font-size: .75rem;
            color: var(--muted)
        }

        .sticky-enquire {
            display: none
        }

        .lightbox {
            border: 0;
            padding: 0;
            background: var(--cream);
            color: var(--ink);
            border-radius: 12px;
            max-width: min(1050px, 94vw);
            width: 1050px;
            max-height: 92vh;
            overflow: auto
        }

        .lightbox::backdrop {
            background: #07241df0;
            backdrop-filter: blur(5px)
        }

        .lightbox-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            gap: 20px
        }

        .lightbox-bar p {
            font-size: .875rem
        }

        .lightbox button {
            background: transparent;
            border: 1px solid var(--line);
            border-radius: 5px;
            min-width: 44px;
            min-height: 44px;
            color: var(--green)
        }

        .lightbox img {
            width: 100%;
            max-height: 68vh;
            object-fit: contain;
            background: #e8e8df
        }

        .lightbox-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            gap: 15px
        }

        .lightbox-bottom p {
            font-size: .75rem
        }

        .lightbox-bottom div {
            display: flex;
            gap: 10px
        }

        .reveal {
            transition: opacity .8s, transform .8s
        }

        .animate .reveal.pending {
            opacity: 0;
            transform: translateY(22px)
        }

        .scene-feature {
            animation: float 6s ease-in-out infinite
        }

        .scene-card {
            animation: float 7s ease-in-out infinite reverse
        }

        body[data-motion=off] .scene-feature,
        body[data-motion=off] .scene-card {
            animation: none
        }

        body[data-motion=off] .scene {
            transform: none !important
        }

        .scene-mode-evening {
            --saturation: .82
        }

        .scene-mode-night {
            --saturation: .7
        }

        @keyframes float {

            0%,
            100% {
                translate: 0 0
            }

            50% {
                translate: 0 -9px
            }
        }

        @media(min-width:1600px) {
            .scene-frame {
                height: 650px
            }
        }

        @media(max-width:1200px) {
            .links {
                gap: 13px
            }

            .links a {
                font-size: .75rem
            }

            .nav {
                gap: 16px
            }

            .nav>.button {
                display: none
            }

            .hero-grid {
                gap: 35px
            }

            .scene-frame {
                height: 550px
            }

            .hero h1 {
                font-size: 5.1rem
            }

            .scene-feature {
                right: -10px
            }

            .scene-card {
                left: -10px
            }

            .scene-toolbar {
                margin-left: 45%
            }

            .scene-toolbar label {
                flex-wrap: wrap;
                gap: 0
            }

            .gallery-grid {
                grid-template-rows: 220px 220px
            }
        }

        @media(max-width:950px) {
            .menu {
                display: block
            }

            .links {
                display: none;
                position: absolute;
                top: 88px;
                left: 0;
                right: 0;
                flex-wrap: wrap;
                gap: 12px 25px;
                background: var(--cream);
                padding: 20px 5%;
                border-bottom: 1px solid var(--line)
            }

            .links.open {
                display: flex
            }

            .links a {
                font-size: .875rem
            }

            .hero-grid {
                grid-template-columns: 1fr 1.05fr;
                gap: 25px
            }

            .hero h1 {
                font-size: 4.1rem
            }

            .hero-actions {
                gap: 16px
            }

            .hero .eyebrow {
                font-size: .6875rem
            }

            .scene-frame {
                height: 520px
            }

            .scene-label {
                right: 20px;
                top: 25px;
                font-size: .65rem
            }

            .scene-card {
                width: 230px;
                padding: 18px
            }

            .scene-card h2 {
                font-size: 1.6rem
            }

            .scene-feature {
                font-size: .7rem;
                padding: 12px
            }

            .scene-feature b {
                font-size: 1rem
            }

            .scene-caption {
                bottom: 0;
                max-width: 47%
            }

            .scene-toolbar {
                margin: 25px 0 0;
                justify-content: end
            }

            .scene-toolbar label {
                flex-wrap: nowrap;
                gap: 10px
            }

            .mini {
                gap: 20px
            }

            .intro-strip div {
                padding: 25px 20px
            }

            .intro-strip b {
                font-size: 1.1rem
            }

            .intro-strip span {
                font-size: .6875rem
            }

            .section {
                padding: 80px 0
            }

            .overview-grid {
                gap: 40px
            }

            .overview-specs {
                padding: 25px
            }

            .price-card {
                padding: 27px
            }

            .plan-info,
            .plan-document {
                padding: 30px
            }

            .amenity {
                padding: 25px
            }

            .amenity h3 {
                font-size: 1.35rem
            }

            .gallery-grid {
                grid-template-rows: 190px 190px
            }

            .gallery-caption span {
                font-size: 1.1rem
            }

            .location-layout {
                gap: 40px
            }

            .faq-layout {
                gap: 40px
            }

            .enquiry-layout {
                gap: 40px
            }
        }

        @media(max-width:700px) {
            html {
                scroll-padding-top: 90px
            }

            .wrap {
                width: 88%
            }

            .topbar {
                font-size: .6rem
            }

            .nav {
                min-height: 75px
            }

            .brand strong {
                font-size: 2rem
            }

            .links {
                top: 75px
            }

            .hero {
                padding: 28px 0 38px
            }

            .hero-grid {
                grid-template-columns: 1fr;
                gap: 15px
            }

            .hero-copy {
                padding: 18px 0 8px
            }

            .hero h1 {
                font-size: clamp(3.6rem, 14vw, 5.8rem);
                line-height: 1.01;
                margin-bottom: 25px
            }

            .hero-copy>p:not(.eyebrow) {
                max-width: 400px
            }

            .hero-actions {
                margin-top: 26px
            }

            .mini {
                margin-top: 28px;
                gap: 35px
            }

            .mini b {
                font-size: 1.5rem
            }

            .hero-stage {
                padding-top: 18px;
                padding-bottom: 30px;
                margin-top: 10px
            }

            .scene {
                transform: none
            }

            .scene-frame {
                height: 490px;
                border-radius: 90px 12px 12px 12px;
                border-width: 5px
            }

            .scene-card {
                left: -8px;
                bottom: 0;
                width: 240px;
                padding: 20px
            }

            .scene-feature {
                right: -8px;
                top: 43%;
                padding: 14px
            }

            .scene-label {
                top: 25px;
                right: 15px
            }

            .scene-caption {
                max-width: 39%;
                font-size: .625rem;
                bottom: 0
            }

            .scene-toolbar {
                margin-top: 22px;
                gap: 18px;
                justify-content: space-between
            }

            .scene-toolbar label {
                font-size: .7rem
            }

            .scene-toolbar input {
                width: 100px
            }

            .intro-strip {
                grid-template-columns: 1fr
            }

            .intro-strip div {
                padding: 20px 0
            }

            .intro-strip div+div {
                border-left: 0;
                border-top: 1px solid var(--line)
            }

            .intro-strip b {
                font-size: 1.25rem
            }

            .intro-strip span {
                font-size: .75rem
            }

            .section {
                padding: 65px 0
            }

            .section-head {
                display: block;
                margin-bottom: 30px
            }

            .section-head>p {
                margin-top: 22px;
                max-width: none
            }

            .section-head .plan-switch {
                margin-top: 26px
            }

            .overview-grid,
            .price-cards,
            .plan-panel,
            .location-layout,
            .about-grid,
            .faq-layout,
            .enquiry-layout {
                grid-template-columns: 1fr;
                gap: 30px
            }

            .overview-specs {
                padding: 25px
            }

            .price-card {
                padding: 28px
            }

            .plan-panel {
                gap: 0
            }

            .plan-info {
                padding: 30px
            }

            .plan-document {
                min-height: 300px
            }

            .plan-paper {
                padding: 30px
            }

            .amenities-grid {
                grid-template-columns: 1fr 1fr
            }

            .amenity {
                padding: 24px 20px
            }

            .amenity h3 {
                font-size: 1.3rem
            }

            .amenity p {
                font-size: .8125rem
            }

            .gallery-grid {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: 360px 200px;
                gap: 12px
            }

            .gallery-item:first-child {
                grid-row: 1;
                grid-column: 1/3
            }

            .gallery-caption {
                left: 10px;
                right: 10px;
                bottom: 10px;
                padding: 10px;
                gap: 8px
            }

            .gallery-caption span {
                font-size: 1rem
            }

            .gallery-caption small {
                font-size: .6rem
            }

            .gallery-caption b {
                display: none
            }

            .location-panel {
                padding: 28px
            }

            .about-wordmark {
                min-height: 220px;
                width: 80%;
                margin: auto
            }

            .faq-layout h2 {
                margin-bottom: 18px
            }

            .enquiry-layout {
                gap: 35px
            }

            .form-grid {
                gap: 18px
            }

            .footer-inner {
                flex-wrap: wrap;
                padding-bottom: 95px
            }

            .sticky-enquire {
                display: flex;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 25;
                background: #faf8f2f5;
                backdrop-filter: blur(15px);
                border-top: 1px solid var(--line);
                padding: 10px 6%;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                padding-bottom: max(10px, env(safe-area-inset-bottom))
            }

            .sticky-enquire p {
                font-size: .7rem;
                color: var(--muted)
            }

            .sticky-enquire b {
                font: 1rem Georgia, serif;
                color: var(--ink);
                display: block
            }

            .sticky-enquire .button {
                padding: 10px 16px;
                min-height: 44px;
                font-size: .75rem;
                gap: 15px
            }

            .lightbox-bottom p {
                font-size: .6875rem
            }
        }

        @media(max-width:390px) {
            .hero h1 {
                font-size: 3.5rem
            }

            .scene-frame {
                height: 420px
            }

            .scene-card {
                width: 210px;
                padding: 16px
            }

            .scene-card h2 {
                font-size: 1.5rem
            }

            .scene-caption {
                max-width: 33%
            }

            .amenities-grid {
                grid-template-columns: 1fr
            }

            .gallery-grid {
                grid-template-rows: 300px 170px
            }

            .gallery-caption small {
                display: none
            }
        }

        @media(prefers-reduced-motion:reduce) {
            html {
                scroll-behavior: auto
            }

            *,
            *:before,
            *:after {
                animation: none !important;
                transition: none !important
            }

            .scene {
                transform: none !important
            }

            .animate .reveal.pending {
                opacity: 1;
                transform: none
            }
        }
    </style>
    <noscript>
        <style>
            .menu,
            .scene-toolbar,
            .mode-buttons,
            .plan-switch {
                display: none
            }

            .scene-card .note:after {
                content: " Enable JavaScript for the interactive demo."
            }

            @media(max-width:950px) {
                .nav {
                    flex-wrap: wrap;
                    padding: 15px 0
                }

                .links {
                    display: flex;
                    position: static;
                    padding: 5px 0;
                    border: 0;
                    gap: 8px 18px
                }
            }
        </style>
    </noscript>
</head>

<body data-motion="on">
    <a class="skip" href="#main">Skip to content</a>
    <div class="topbar">Synq Highlife &nbsp; / &nbsp; Fully furnished, AI-enabled 1 &amp; 2 BHK residences</div>
    <header>
        <nav class="wrap nav" aria-label="Main navigation"><a class="brand" href="./" aria-label="Synq Highlife home"><strong>SYNQ</strong><span>H I G H L I F E</span></a><button class="menu" type="button" aria-expanded="false" aria-controls="nav-links">Menu +</button>
            <div class="links" id="nav-links"><a href="#overview">Overview</a><a href="#price-list">Price List</a><a href="#floor-plans">Floor Plans</a><a href="#amenities">Amenities</a><a href="#gallery">Gallery</a><a href="#location">Location</a><a href="#about">About</a><a href="#faq">FAQ</a></div><a class="button" href="#enquire">Enquire ↗</a>
        </nav>
        <div class="progress" aria-hidden="true"></div>
    </header>
    <main id="main">
        <section class="hero" aria-labelledby="hero-title">
            <div class="wrap hero-grid">
                <div class="hero-copy">
                    <p class="eyebrow"><span class="dash"></span>A new rhythm of living</p>
                    <h1 id="hero-title">Synq Highlife<em> <br>AI Homes<br> in Greater Noida West</em></h1>
                    <p>Fully furnished, AI-enabled 1 &amp; 2 BHK apartments greater noida west?. For a life that feels more like you.</p>
                    <div class="hero-actions"><a class="button" href="#floor-plans">Find your residence <span aria-hidden="true">↗</span></a><a class="text-link" href="#gallery">Explore the gallery</a></div>
                    <div class="mini">
                        <div><b>1 &amp; 2 BHK</b><span>Request Price & Details</span></div>
                        <div><b>AI-enabled</b><span>Your lifestyle</span></div>
                    </div>
                </div>
                <div class="hero-stage">
                    <div class="scene" id="ai-scene">
                        <figure class="scene-frame"><img src="assets/interior.webp" width="1536" height="1024" alt="AI-generated concept living room with ivory seating, walnut finishes and a deep green accent chair" fetchpriority="high"></figure>
                        <div class="scene-label"><span class="signal" aria-hidden="true"></span>AI HOME / CONCEPT EXPERIENCE</div>
                        <div class="scene-feature"><small>SPACE TO BE YOU</small><b>Thoughtfully furnished.</b></div>
                        <div class="scene-card">
                            <p class="eyebrow">Try a living mood</p>
                            <h2 id="scene-title">A brighter beginning.</h2>
                            <div class="mode-buttons" role="group" aria-label="Illustrative lighting mood"><button type="button" data-mode="day" aria-pressed="true">Day</button><button type="button" data-mode="evening" aria-pressed="false">Evening</button><button type="button" data-mode="night" aria-pressed="false">Night</button></div>
                            <p class="note" id="scene-status" aria-live="polite">Daylight visual simulation. Not a confirmed project feature.</p>
                        </div>
                    </div>
                    <div class="scene-toolbar"><label for="brightness">Light level <input id="brightness" type="range" min="35" max="110" value="100" aria-label="Concept image light level"><output id="light-value" for="brightness">100%</output></label><button class="motion-toggle" type="button" aria-pressed="false">Pause motion</button></div>
                    <p class="scene-caption">AI-generated concept interior.<br>Not an actual project photograph.</p>
                </div>
            </div>
        </section>
        <div class="wrap intro-strip">
            <div><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z" />
                    <path d="M9 21v-8h6v8" />
                </svg>
                <p><b>A space for your life</b><span>1 &amp; 2 BHK residences</span></p>
            </div>
            <div><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v5M3 18h18v-5a2 2 0 0 0-4 0v2H7v-2a2 2 0 0 0-4 0zm2 0v3m14-3v3" />
                </svg>
                <p><b>Designed to feel like home</b><span>Fully furnished positioning</span></p>
            </div>
            <div><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="6" y="6" width="12" height="12" rx="2" />
                    <path d="M9 1v5m6-5v5M9 18v5m6-5v5M1 9h5m-5 6h5m12-6h5m-5 6h5" />
                    <rect x="9" y="9" width="6" height="6" rx="1" />
                </svg>
                <p><b>A connected perspective</b><span>AI-enabled living concept</span></p>
            </div>
        </div>
        <section class="section wrap" id="overview">
            <div class="overview-grid">
                <div class="overview-copy reveal">
                    <p class="eyebrow"><span class="dash"></span>01 / Overview</p>
                    <h2>A home for today.<br><em>A mindset for tomorrow.</em></h2>
                    <p>Synq Highlife brings fully furnished homes and AI-enabled living into one residential concept. Choose between 1 and 2 BHK apartments, then explore the details that matter to your everyday life.</p>
                    <p>From your furnishing inventory to the way your smart controls work, every decision begins with understanding what is included in your chosen home.</p><a class="text-link" href="#price-list">Explore your home options ↗</a>
                </div>
                <div class="overview-specs reveal">
                    <p>THE PROJECT, AT A GLANCE</p>
                    <dl>
                        <div>
                            <dt>Brand</dt>
                            <dd>Synq Highlife</dd>
                        </div>
                        <div>
                            <dt>Residences</dt>
                            <dd>1 &amp; 2 BHK</dd>
                        </div>
                        <div>
                            <dt>Furnishing</dt>
                            <dd>Fully furnished</dd>
                        </div>
                        <div>
                            <dt>Home concept</dt>
                            <dd>AI-enabled</dd>
                        </div>
                        <div>
                            <dt>Official specifications</dt>
                            <dd>Awaiting confirmation</dd>
                        </div>
                    </dl>
                    <p class="note" style="letter-spacing:0;margin:15px 0 0">Unit-specific inclusions will be confirmed against the approved project documents.</p>
                </div>
            </div>
        </section>
        <section class="section soft-section" id="price-list">
            <div class="wrap">
                <div class="section-head reveal">
                    <div>
                        <p class="eyebrow"><span class="dash"></span>02 / Price List</p>
                        <h2>Choose Your SYNQ Home.<br><em>Know the full picture.</em></h2>
                    </div>
                    <p>Compare the SYNQ AI Home residence options. Request the official price list and a complete cost sheet before making a decision.</p>
                </div>
                <div class="price-cards">
                    <article class="price-card reveal">
                        <div class="price-top">
                            <h3>1 BHK</h3><span class="tag">Fully furnished</span>
                        </div>
                        <p class="subtitle">A separate bedroom. A place to make your own.</p>
                        <p class="price-value">Price details awaited<small>Official unit-wise pricing has not yet been supplied.</small></p>
                        <div class="price-row"><span>Carpet area</span><span>To be confirmed</span></div>
                        <div class="price-row"><span>AI specifications</span><span>To be confirmed</span></div>
                        <div class="price-row"><span>Availability</span><span>To be confirmed</span></div><a class="button outline" href="#enquire">Request 1 BHK Price & Details <span aria-hidden="true">↗</span></a>
                    </article>
                    <article class="price-card reveal">
                        <div class="price-top">
                            <h3>2 BHK</h3><span class="tag">Fully furnished</span>
                        </div>
                        <p class="subtitle">An additional bedroom. More possibilities for your life.</p>
                        <p class="price-value">Price details awaited<small>Official unit-wise pricing has not yet been supplied.</small></p>
                        <div class="price-row"><span>Carpet area</span><span>To be confirmed</span></div>
                        <div class="price-row"><span>AI specifications</span><span>To be confirmed</span></div>
                        <div class="price-row"><span>Availability</span><span>To be confirmed</span></div><a class="button outline" href="#enquire">Request 2 BHK Price & Details <span aria-hidden="true">↗</span></a>
                    </article>
                </div>
                <p class="cost-note">Your final cost sheet should itemise the base price, applicable taxes, registration, maintenance, deposits and any additional charges. No price, discount or investment return is claimed on this page.</p>
            </div>
        </section>
        <section class="section wrap" id="floor-plans">
            <div class="section-head reveal">
                <div>
                    <p class="eyebrow"><span class="dash"></span>03 / Floor Plans</p>
                    <h2>SYNQ AI homes room for your<br><em>everyday rituals.</em></h2>
                </div>
                <div class="plan-switch" role="tablist" aria-label="Residence floor plans"><button id="tab-one" role="tab" type="button" aria-selected="true" aria-controls="plan-one" data-plan="plan-one">1 BHK</button><button id="tab-two" role="tab" type="button" aria-selected="false" aria-controls="plan-two" data-plan="plan-two" tabindex="-1">2 BHK</button></div>
            </div>
            <div class="plan-panel" id="plan-one" role="tabpanel" aria-labelledby="tab-one" tabindex="0">
                <div class="plan-document">
                    <div class="plan-paper"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M14 2H5v20h14V7zM14 2v5h5M8 11h8m-8 4h8m-8 4h5" />
                        </svg>
                        <p>1 BHK floor plan</p><small>Official drawing awaited</small><small>Understand the proposed layout, room dimensions, carpet area, orientation and access before choosing your residence.</small>
                    </div>
                </div>
                <div class="plan-info">
                    <p class="eyebrow">Your 1 BHK residence</p>
                    <h3>Know your home,<br>down to the details.</h3>
                    <p>Review the approved drawing for the exact apartment you are considering.</p>
                    <ul>
                        <li>Confirm the carpet area and room dimensions.</li>
                        <li>Check orientation, ventilation and access.</li>
                        <li>Match the furniture inventory to the final layout.</li>
                    </ul><a class="button outline" href="#enquire">Request the official plan ↗</a>
                </div>
            </div>
            <div class="plan-panel" id="plan-two" role="tabpanel" aria-labelledby="tab-two" tabindex="0">
                <div class="plan-document">
                    <div class="plan-paper"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M14 2H5v20h14V7zM14 2v5h5M8 11h8m-8 4h8m-8 4h5" />
                        </svg>
                        <p>2 BHK floor plan</p><small>Official drawing awaited</small><small>2 BHK layout and compare the available space with your requirements.</small>
                    </div>
                </div>
                <div class="plan-info">
                    <p class="eyebrow">Your 2 BHK residence</p>
                    <h3>Know your home,<br>down to the details.</h3>
                    <p>Review the approved drawing for the exact apartment you are considering.</p>
                    <ul>
                        <li>Confirm the carpet area and room dimensions.</li>
                        <li>Check orientation, ventilation and access.</li>
                        <li>Match the furniture inventory to the final layout.</li>
                    </ul><a class="button outline" href="#enquire">Request the official plan ↗</a>
                </div>
            </div>
        </section>
        <section class="section sage" id="amenities">
            <div class="wrap">
                <div class="reveal">
                    <p class="eyebrow"><span class="dash"></span>04 / Amenities</p>
                    <h2>The little things.<br><em>The way you live.</em></h2>
                    <p class="amenity-intro">Explore what to look for in a furnished, connected home. The final amenity list and AI specifications are awaiting verification; the categories below are a guide to the details to confirm.</p>
                </div>
                <div class="amenities-grid">
                    <article class="amenity reveal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v5M3 18h18v-5a2 2 0 0 0-4 0v2H7v-2a2 2 0 0 0-4 0zm2 0v3m14-3v3" />
                        </svg>
                        <h3>Furnished comfort</h3>
                        <p>SYNQ AI Home Highlife's concept goes beyond the traditional furniture, appliance and finish inventory for the selected residence.</p><small>Inventory awaited</small>
                    </article>
                    <article class="amenity reveal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="6" y="6" width="12" height="12" rx="2" />
                            <path d="M9 1v5m6-5v5M9 18v5m6-5v5M1 9h5m-5 6h5m12-6h5m-5 6h5" />
                            <rect x="9" y="9" width="6" height="6" rx="1" />
                        </svg>
                        <h3>AI integrations</h3>
                        <p>Understand which connected-home AI devices features, supported controls and manual alternatives are included.</p><small>Device list awaited</small>
                    </article>
                    <article class="amenity reveal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="4" />
                            <path d="M12 1v3m0 16v3M1 12h3m16 0h3M4 4l2 2m12 12 2 2M4 20l2-2M18 6l2-2" />
                        </svg>
                        <h3>Everyday convenience</h3>
                        <p>Review hi-power backup, high speed internet provision and includes all applicable ongoing service charges.</p><small>Services awaited</small>
                    </article>
                    <article class="amenity reveal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z" />
                            <path d="M9 21v-8h6v8" />
                        </svg>
                        <h3>Resident facilities</h3>
                        <p>Ask which shared spaces and facilities are included in the approved project.</p><small>Amenity list awaited</small>
                    </article>
                    <article class="amenity reveal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m12 2 9 4v6c0 5-9 10-9 10S3 17 3 12V6z" />
                            <path d="m8 12 3 3 5-6" />
                        </svg>
                        <h3>Privacy & access</h3>
                        <p>Check access systems, data handling and who manages connected devices.</p><small>Specifications awaited</small>
                    </article>
                    <article class="amenity reveal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 15v-3a8 8 0 0 1 16 0v6a3 3 0 0 1-3 3h-5" />
                            <rect x="2" y="11" width="4" height="7" rx="2" />
                            <rect x="18" y="11" width="4" height="7" rx="2" />
                        </svg>
                        <h3>Care after move-in</h3>
                        <p>Clarify warranties, maintenance responsibilities and support availability.</p><small>Support terms awaited</small>
                    </article>
                </div>
            </div>
        </section>
        <section class="section wrap" id="gallery">
            <div class="section-head reveal">
                <div>
                    <p class="eyebrow"><span class="dash"></span>05 / Gallery</p>
                    <h2>A feeling of SYNQ AI Homes.<br><em>Before you step inside.</em></h2>
                </div>
                <p>An illustrative look at the design mood. Open any image to explore it in detail.</p>
            </div>
            <div class="gallery-grid">
                <figure class="gallery-item reveal"><a href="assets/interior.webp" data-gallery data-caption="Living, beautifully" aria-label="Open Living, beautifully concept image"><img src="assets/interior.webp" width="1536" height="1024" loading="lazy" alt="AI-generated concept living room with ivory sofa and green accent chair"></a>
                    <figcaption class="gallery-caption">
                        <div><small>Concept interior</small><br><span>Living, beautifully</span></div><b aria-hidden="true">↗</b>
                    </figcaption>
                </figure>
                <figure class="gallery-item reveal"><a href="assets/bedroom.webp" data-gallery data-caption="Your quiet retreat" aria-label="Open Your quiet retreat concept image"><img src="assets/bedroom.webp" width="1536" height="1024" loading="lazy" alt="AI-generated concept bedroom with green upholstered headboard and warm ivory linens"></a>
                    <figcaption class="gallery-caption">
                        <div><small>Concept interior</small><br><span>Your quiet retreat</span></div><b aria-hidden="true">↗</b>
                    </figcaption>
                </figure>
                <figure class="gallery-item reveal"><a href="assets/dining.webp" data-gallery data-caption="The everyday, elevated" aria-label="Open The everyday, elevated concept image"><img src="assets/dining.webp" width="1536" height="1024" loading="lazy" alt="AI-generated concept kitchen and dining area in warm walnut, ivory and green"></a>
                    <figcaption class="gallery-caption">
                        <div><small>Concept interior</small><br><span>The everyday, elevated</span></div><b aria-hidden="true">↗</b>
                    </figcaption>
                </figure>
            </div>
            <p class="gallery-note">All gallery images are AI-generated concepts, not actual project photographs, approved floor plans or promised furnishing specifications.</p>
        </section>
        <section class="section sage" id="location">
            <div class="wrap location-layout">
                <div class="reveal">
                    <p class="eyebrow"><span class="dash"></span>06 / Location</p>
                    <h2>SYNQ Highlife<br><em>Techzone 4 Location</em></h2>
                    <p>The right address starts with the journeys you make every day. The verified Synq Highlife project location has not yet been supplied, so a map pin and travel-time claims are not published here.</p>
                    <div class="location-check"><span>Check your commute at the times you actually travel.</span><span>Confirm nearby transport, healthcare and daily essentials.</span><span>Verify the official address against project documents.</span></div>
                </div>
                <div class="location-panel reveal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    <h3>The address comes first.</h3>
                    <p class="note">The location map will be available once the official project address is confirmed.</p>
                    <dl>
                        <div>
                            <dt>City &amp; locality</dt>
                            <dd>Awaiting confirmation</dd>
                        </div>
                        <div>
                            <dt>Project address</dt>
                            <dd>Awaiting verification</dd>
                        </div>
                        <div>
                            <dt>Nearby landmarks</dt>
                            <dd>To be verified</dd>
                        </div>
                    </dl><a class="text-link" href="#enquire" style="margin-top:25px">Ask for verified location details ↗</a>
                </div>
            </div>
        </section>
        <section class="section wrap" id="about">
            <div class="about-grid">
                <div class="about-wordmark reveal">
                    <div class="brand"><strong>SYNQ</strong><span>H I G H L I F E</span></div>
                </div>
                <div class="about-copy reveal">
                    <p class="eyebrow"><span class="dash"></span>07 / About Synq Highlife</p>
                    <h2>Beautiful SYNQ AI homes.<br><em>A connected outlook.</em></h2>
                    <p>Synq Highlife is a residential brand presented around fully furnished, AI-enabled 1 and 2 BHK apartments. This website brings the available information together so you can explore the concept and ask informed questions.</p>
                    <p>The developer identity, applicable RERA registration, approvals and possession schedule are awaiting official verification. Review these documents before making any payment or booking commitment.</p>
                    <div class="about-meta"><span>Fully furnished positioning</span><span>AI-enabled concept</span><span>1 &amp; 2 BHK options</span></div>
                </div>
            </div>
        </section>
        <section class="section soft-section" id="faq">
            <div class="wrap faq-layout">
                <div class="reveal">
                    <p class="eyebrow"><span class="dash"></span>08 / FAQ</p>
                    <h2>Good questions.<br><em>Clear answers.</em></h2>
                    <p>Know what is available today, and what still needs confirmation.</p><a class="text-link" href="#enquire" style="margin-top:25px">Have another question? ↗</a>
                </div>
                <div><?php foreach ($faqs as [$q, $a]): ?><details>
                            <summary><?= esc($q) ?></summary>
                            <p><?= esc($a) ?></p>
                        </details><?php endforeach; ?></div>
            </div>
        </section>
        <section class="section enquire" id="enquire">
            <div class="wrap enquiry-layout">
                <div>
                    <p class="eyebrow">Your next chapter / Synq Highlife</p>
                    <h2>Let’s find the home<br>that feels like <em style="color:#dfc69a">you.</em></h2>
                    <p>Request the official price list, floor plan and project specifications for the residence that interests you.</p>
                </div>
                <form method="post" action="process-form.php" aria-label="Residence enquiry">
                    <?php if ($success): ?><div class="alert" role="status"><?= esc((string)$success) ?></div><?php endif; ?>
                    <?php if ($errors): ?><div class="alert" role="alert">
                            <ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul>
                        </div><?php endif; ?>
                    <input type="hidden" name="form_source" value="enquire_section">
                    <div class="hp" aria-hidden="true"><label>Leave empty<input name="website" tabindex="-1" autocomplete="off"></label></div>
                    <div class="form-grid"><label class="field">Your name<input name="name" autocomplete="name" required minlength="2" maxlength="100"></label><label class="field">Mobile number<input name="phone" type="tel" autocomplete="tel" required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}"></label><label class="field">Email address<input name="email" type="email" autocomplete="email" required maxlength="200"></label></div><button class="button light" type="submit">Request project details <span aria-hidden="true">↗</span></button>
                    <p class="privacy">Enquiry only. This is not a booking or a payment request.</p>
                </form>
            </div>
        </section>
        <section class="wrap legal">
            <h3>Project information &amp; imagery</h3>
            <p>This page introduces Synq Highlife using the currently supplied description: fully furnished, AI-enabled 1 and 2 BHK apartments. Concept imagery is illustrative and does not represent a confirmed layout, view or furnishing commitment. Location, developer, approvals, RERA applicability, availability, areas, inclusions, prices and possession must be verified against official documents.</p>
            <details id="privacy">
                <summary>Privacy information</summary>
                <p>The enquiry form requests your name, email and phone number to respond to your request. Submissions are sent to our CRM so the sales team can follow up. A necessary session cookie protects the form and supports submission feedback. No advertising, analytics or third-party font scripts are included. Contact information for the responsible operator, retention period and privacy requests must be published before enquiries are enabled.</p>
            </details>
        </section>

    </main>
    <footer>
        <div class="wrap footer-inner"><a class="brand" href="./"><strong>SYNQ</strong><span>H I G H L I F E</span></a>
            <p>© <?= date('Y') ?> Synq Highlife · synqhighlife.com</p><a class="text-link" href="#main">Back to top ↑</a>
        </div>
    </footer>
    <div class="sticky-enquire">
        <p><b>Synq Highlife</b>Fully furnished 1 &amp; 2 BHK</p><a class="button" href="#enquire">Enquire now ↗</a>
    </div>
    <dialog class="lightbox" aria-labelledby="lightbox-title">
        <div class="lightbox-bar">
            <p id="lightbox-title">Concept interior</p><button type="button" data-close aria-label="Close gallery">×</button>
        </div><img src="assets/interior.webp" width="1536" height="1024" alt="Concept interior">
        <div class="lightbox-bottom">
            <p>AI-generated concept. Not an actual project photograph.</p>
            <div><button type="button" data-prev aria-label="Previous image">←</button><button type="button" data-next aria-label="Next image">→</button></div>
        </div>
    </dialog>
    <script src="js/main.js" defer></script>
</body>

</html>