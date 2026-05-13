<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];
?>
<header class="site-header" id="site-header">
    <div class="container nav">
        <a href="#top" class="brand" aria-label="Exotica One32 home">
            Exotica One32
            <small>Sector 132</small>
        </a>
        <nav aria-label="Primary">
            <ul class="nav-links">
                <li><a href="#overview">Overview</a></li>
                <li><a href="#opportunities">Spaces</a></li>
                <li><a href="#plans">Floor Plans</a></li>
                <li><a href="#amenities">Amenities</a></li>
                <li><a href="#location">Location</a></li>
                <li><a href="#faq">FAQ</a></li>
            </ul>
        </nav>
        <div class="nav-cta">
            <a href="tel:+919412234688" class="nav-phone" aria-label="Call Exotica One32">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.86 19.86 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.86 19.86 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
                9412-234-688
            </a>
            <a href="#contact" class="btn btn-primary" style="padding:12px 22px">Enquire</a>
            <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>
