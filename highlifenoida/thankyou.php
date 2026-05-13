<?php
session_start();
$msg = $_SESSION['form_success'] ?? "Thank you for your interest in Great Value High Life. Our team will contact you shortly.";
unset($_SESSION['form_success']);
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thank You — Great Value High Life</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/styles.css">
<link rel="icon" href="favicon.png">
</head>
<body>

<main style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:80px 24px;background:radial-gradient(circle at 50% 30%, rgba(197,165,114,0.08), transparent 60%), var(--bg-ink);">
  <div class="card card--lg" style="max-width:560px;width:100%;text-align:center;">
    <span class="eyebrow">Enquiry received</span>
    <div style="margin:24px auto 32px;width:72px;height:72px;border:1px solid var(--gold);display:grid;place-items:center;color:var(--gold);">
      <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M5 13l4 4L19 7"/>
      </svg>
    </div>
    <h1 style="font-size:clamp(36px,5vw,56px);">Thank you.</h1>
    <p class="lead" style="max-width:420px;margin:0 auto 32px;color:var(--text-body-dark);"><?= htmlspecialchars($msg) ?></p>

    <div style="display:flex;gap:14px;flex-wrap:wrap;justify-content:center;margin-bottom:28px;">
      <a href="tel:+919412234688" class="btn btn--filled">Call Sales</a>
      <a href="index.php" class="btn">Back to Home</a>
    </div>

    <p class="caption" style="margin:0;color:var(--text-body-dark);">
      Redirecting in <span id="countdown" style="color:var(--gold);font-weight:500;">6</span> seconds…
    </p>

    <div class="rera-block" style="margin-top:28px;text-align:left;">
      <strong>RERA</strong>
      Project registration under process with UP RERA. Contact sales for latest status. This advertisement is for information purposes only and does not constitute an offer for sale.
    </div>
  </div>
</main>

<script>
  let s = 6;
  const el = document.getElementById('countdown');
  const t = setInterval(() => {
    s--;
    if (el) el.textContent = s;
    if (s <= 0) { clearInterval(t); window.location.href = 'index.php'; }
  }, 1000);
</script>

</body>
</html>
