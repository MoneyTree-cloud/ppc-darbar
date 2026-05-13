<?php
$projectRera = 'UPRERAPRJ300532/12/2025';
$siteUrl     = 'https://eliesaab98.in/';
$phone       = '+91-9412-234-688';
$phoneLink   = preg_replace('/[^0-9+]/', '', $phone);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You — Smartworld Elie Saab Residences</title>
  <meta name="robots" content="noindex, nofollow">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">

  <style>
    .ty-wrap {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 80px 24px;
      background:
        radial-gradient(ellipse at top, rgba(200,169,106,0.10) 0%, rgba(11,13,16,0) 55%),
        var(--bg-ink);
    }
    .ty-card {
      max-width: 620px;
      width: 100%;
      border: 1px solid var(--line-dark);
      background: var(--bg-panel);
      padding: 64px 56px;
      text-align: center;
      border-top: 2px solid var(--gold);
    }
    .ty-card .eyebrow { margin-bottom: 20px; }
    .ty-card h1 {
      font-family: var(--font-display);
      font-weight: 500;
      font-size: clamp(32px, 5vw, 46px);
      color: var(--text-high-dark);
      margin: 0 0 18px;
    }
    .ty-card p { color: var(--text-mid-dark); margin-bottom: 14px; }
    .ty-mark {
      width: 68px; height: 68px;
      border: 1px solid var(--gold);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 28px;
    }
    .ty-mark svg { width: 28px; height: 28px; stroke: var(--gold); }
    .ty-countdown {
      display: inline-block;
      margin-top: 14px;
      font-size: 11px;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--text-low);
    }
    .ty-countdown strong { color: var(--gold); font-weight: 500; }
    .ty-rera {
      margin-top: 32px;
      padding-top: 20px;
      border-top: 1px solid var(--line-dark);
      font-size: 10px;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--text-low);
    }
    .ty-rera strong { color: var(--gold); font-weight: 500; display: block; margin-top: 4px; }
    .ty-actions {
      display: flex; justify-content: center; gap: 14px; margin-top: 28px; flex-wrap: wrap;
    }
    @media (max-width: 560px) {
      .ty-card { padding: 44px 28px; }
    }
  </style>
</head>
<body>
  <div class="ty-wrap">
    <div class="ty-card">
      <div class="ty-mark" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 6L9 17l-5-5"></path>
        </svg>
      </div>
      <span class="eyebrow">Enquiry Received</span>
      <h1>Thank You</h1>
      <p>Your enquiry for <strong style="color:var(--text-high-dark);">Smartworld Elie Saab Residences</strong> has been received.</p>
      <p>Our client team will reach out to you shortly with pricing, floor plans, and a private preview slot.</p>

      <div class="ty-actions">
        <a href="tel:<?= htmlspecialchars($phoneLink) ?>" class="btn btn-solid">Call <?= htmlspecialchars($phone) ?></a>
        <a href="<?= htmlspecialchars($siteUrl) ?>" class="btn">Return Home</a>
      </div>

      <div class="ty-countdown">
        Redirecting in <strong id="ty-count">6</strong>s
      </div>

      <div class="ty-rera">
        RERA Registration
        <strong><?= htmlspecialchars($projectRera) ?></strong>
      </div>
    </div>
  </div>

  <script>
    (function () {
      var el = document.getElementById('ty-count');
      var s = 6;
      var t = setInterval(function () {
        s--;
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
