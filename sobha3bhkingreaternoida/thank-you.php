<?php
session_start();
$message = $_SESSION['form_message']['text'] ?? 'Thank you! Our SOBHA advisor will call you within 24 hours.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you — SOBHA 3 BHK Greater Noida</title>
    <meta name="robots" content="noindex, follow">
    <link rel="icon" type="image/png" href="assets/favicon/favicon-32x32.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Lato:wght@400;700&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background:var(--sobha-cream)">
    <main style="min-height:100dvh;display:grid;place-items:center;padding:2rem">
        <div style="max-width:560px;background:#fff;padding:3rem;border-radius:var(--radius-md);text-align:center;border:1px solid var(--sobha-light-grey);box-shadow:var(--shadow-lg);position:relative">
            <div style="position:absolute;top:0;left:0;right:0;height:3px;background:var(--sobha-gold);border-radius:var(--radius-md) var(--radius-md) 0 0"></div>
            <div style="width:72px;height:72px;margin:0 auto 1.5rem;border:2px solid var(--sobha-gold);border-radius:50%;display:grid;place-items:center;color:var(--sobha-gold);font-size:1.8rem">
                <i class="fas fa-check"></i>
            </div>
            <span class="eyebrow">Request Received</span>
            <h1 style="font-size:1.8rem;margin-bottom:1rem">Thank you!</h1>
            <p style="color:var(--sobha-stone);margin-bottom:2rem"><?= htmlspecialchars($message) ?></p>
            <div style="display:flex;gap:0.75rem;justify-content:center;flex-wrap:wrap">
                <a href="tel:+919412234688" class="btn btn-primary"><i class="fas fa-phone-alt"></i> Call Now</a>
                <a href="index.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to site</a>
            </div>
        </div>
    </main>
<?php unset($_SESSION['form_message']); ?>
</body>
</html>
