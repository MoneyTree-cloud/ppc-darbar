<?php
session_start();
$msg = $_SESSION['form_success'] ?? "Thank you for your interest in M3M × Jacob & Co Residences. Our authorized channel partner team will contact you within the hour.";
unset($_SESSION['form_success']);
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thank You — M3M × Jacob &amp; Co Residences</title>
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/styles.css">
</head>
<body>

<main style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:88px 24px;background:radial-gradient(circle at 50% 30%, rgba(212,175,55,0.12), transparent 60%), radial-gradient(circle at 70% 70%, rgba(92,26,26,0.18), transparent 60%), var(--bg-ink);">
  <div style="max-width:600px;width:100%;text-align:center;background:var(--bg-panel);border:1px solid var(--line-gold);padding:64px 48px;position:relative;box-shadow:0 40px 80px -30px rgba(0,0,0,0.8);">
    <div style="position:absolute;inset:-1px -1px auto -1px;height:2px;background:var(--gold);"></div>

    <span class="eyebrow">Enquiry received</span>

    <div style="margin:24px auto 36px;width:84px;height:84px;border:1px solid var(--gold);display:grid;place-items:center;color:var(--gold);box-shadow:0 0 24px rgba(212,175,55,0.3);">
      <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M5 13l4 4L19 7"/>
      </svg>
    </div>

    <h1 style="font-size:clamp(40px,6vw,64px);">Thank you.</h1>
    <p class="lead" style="max-width:460px;margin:16px auto 36px;color:var(--text-body);"><?= htmlspecialchars($msg) ?></p>

    <div style="display:flex;gap:14px;flex-wrap:wrap;justify-content:center;margin-bottom:32px;">
      <a href="tel:+919412234688" class="btn btn--gold">Call Sales</a>
      <a href="index.php" class="btn">Back to Home</a>
    </div>

    <p class="caption" style="margin:0;color:var(--text-muted);">
      Redirecting in <span id="countdown" style="color:var(--gold);font-weight:500;">7</span> seconds…
    </p>

    <div style="margin-top:32px;padding:20px 24px;border:1px solid var(--line-gold);background:rgba(212,175,55,0.05);text-align:left;font-size:11px;color:var(--text-muted);line-height:1.7;">
      <strong style="color:var(--gold);display:block;font-size:10px;letter-spacing:0.22em;text-transform:uppercase;margin-bottom:6px;">RERA &amp; Channel Partner Disclosure</strong>
      RERA: UPRERAPRJ690055/10/2025 (UP RERA). This website is operated by an authorized channel partner of M3M India. Verify all project details on up-rera.in before booking.
    </div>
  </div>
</main>

<script>
  let s = 7;
  const el = document.getElementById('countdown');
  const t = setInterval(() => {
    s--;
    if (el) el.textContent = s;
    if (s <= 0) { clearInterval(t); window.location.href = 'index.php'; }
  }, 1000);
</script>

</body>
</html>
