<?php
/**
 * Great Value High Life — site header / navigation
 * Included at the top of every page.
 */
if (!isset($activePage)) { $activePage = ''; }
?>
<header class="site-header">
  <div class="container">
    <a href="index.php" class="brand" aria-label="Great Value High Life — Home">
      <img src="assets/images/logo/Logo-light.svg" alt="Great Value High Life" class="brand-mark" width="46" height="46" loading="eager">
      <span class="brand-text">
        Great Value <em>High Life</em>
        <small>Tech Zone IV · Greater Noida West</small>
      </span>
    </a>

    <nav aria-label="Primary navigation">
      <ul class="nav-list">
        <li><a href="index.php#overview">Overview</a></li>
        <li><a href="index.php#residences">Residences</a></li>
        <li><a href="index.php#plans">Floor Plans</a></li>
        <li><a href="index.php#amenities">Amenities</a></li>
        <li><a href="index.php#location">Location</a></li>
        <li><a href="index.php#faq">FAQ</a></li>
      </ul>
    </nav>

    <div class="nav-cta">
      <a href="tel:+919412234688" class="phone-pill" aria-label="Call sales">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.9.34 1.78.63 2.63a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.45-1.2a2 2 0 0 1 2.11-.45c.85.29 1.73.5 2.63.63A2 2 0 0 1 22 16.92z"/></svg>
        9412-234-688
      </a>
      <a href="#contact" class="btn btn--filled" data-modal-open="enquireModal">Enquire</a>
      <button type="button" class="nav-toggle" aria-label="Open menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>
