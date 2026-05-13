<?php
$siteUrl = 'https://jewelcrestavenue.com/';
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You — M3M Jewel Crest Avenue</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Raleway:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css?v=2">
  <style>
    .thanks {
      min-height: 100vh;
      background: var(--bg-ink);
      color: var(--text-ivory);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px;
      position: relative;
      overflow: hidden;
    }
    .thanks::before {
      content:""; position:absolute; inset:0;
      background:
        radial-gradient(1200px 600px at 50% 0%, rgba(201,169,106,0.14), transparent 60%),
        radial-gradient(900px 500px at 50% 100%, rgba(201,169,106,0.08), transparent 60%);
      pointer-events:none;
    }
    .thanks__card {
      position: relative;
      max-width: 640px;
      width: 100%;
      background: var(--bg-onyx);
      border: 1px solid var(--line-gold);
      border-top: 2px solid var(--gold);
      padding: 64px 48px;
      text-align: center;
      box-shadow: 0 40px 100px -40px rgba(0,0,0,0.6);
    }
    .thanks__mark {
      width: 72px;
      height: 72px;
      margin: 0 auto 32px;
      border: 1px solid var(--gold);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--gold);
    }
    .thanks__mark svg { width: 36px; height: 36px; }
    .thanks__eyebrow { display:inline-block; font-family:"Raleway",sans-serif; font-size:11px; letter-spacing:0.24em; text-transform:uppercase; color: var(--gold); margin-bottom: 20px; }
    .thanks h1 { font-family:"Playfair Display",serif; color: var(--text-ivory); font-size: clamp(36px, 5vw, 56px); font-weight: 500; margin: 0 0 16px; }
    .thanks p { color: var(--text-body-dark); font-size: 16px; line-height: 1.7; max-width: 480px; margin: 0 auto 24px; }
    .thanks .btn { margin-top: 16px; }
    .thanks__meta { margin-top: 40px; padding-top: 32px; border-top: 1px solid var(--line-dark); font-size: 12px; color: var(--text-muted); letter-spacing: 0.14em; text-transform: uppercase; }
    @media (max-width: 560px) { .thanks__card { padding: 48px 28px; } }
    @keyframes draw { from { stroke-dashoffset: 40; } to { stroke-dashoffset: 0; } }
    .check { stroke-dasharray: 40; stroke-dashoffset: 40; animation: draw .6s ease .2s forwards; }
  </style>
</head>
<body>
  <main class="thanks">
    <div class="thanks__card">
      <div class="thanks__mark">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <path class="check" d="M5 12.5 L10 17.5 L19 8"/>
        </svg>
      </div>

      <span class="thanks__eyebrow">M3M Jewel Crest Avenue</span>
      <h1>Thank you.</h1>
      <p>Your enquiry has been received. Our channel-partner team will call you within one business hour with the latest pricing, floor plans and a site-visit slot.</p>

      <a href="<?= $siteUrl ?>" class="btn">Return to Home</a>

      <div class="thanks__meta">
        Redirecting in <span id="countdown">6</span>s &nbsp;·&nbsp; Sector 97 Noida &nbsp;·&nbsp; UP RERA UPRERAPRJ690055/10/2025
      </div>
    </div>
  </main>

  <script>
    (function () {
      const el = document.getElementById('countdown');
      let s = 6;
      const t = setInterval(() => {
        s -= 1;
        if (el) el.textContent = s;
        if (s <= 0) {
          clearInterval(t);
          window.location.href = <?= json_encode($siteUrl) ?>;
        }
      }, 1000);
    })();
  </script>
</body>
</html>
