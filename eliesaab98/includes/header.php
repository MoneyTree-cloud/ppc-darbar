<?php
/**
 * Site header — sticky, transparent → solid on scroll.
 * Expects $siteName, $projectRera in scope (optional).
 */
$projectRera = $projectRera ?? 'UPRERAPRJ300532/12/2025';
$siteName    = $siteName    ?? 'Smartworld Elie Saab Residences';
?>
<header id="siteHeader" class="site-header">
  <div class="container header-inner">
    <a href="#top" class="site-brand" aria-label="<?= htmlspecialchars($siteName) ?>">
      <span class="brand-mark">Smartworld Elie Saab</span>
      <span class="brand-sub">Sector 98 · Noida</span>
    </a>

    <nav id="siteNav" class="site-nav" aria-label="Primary">
      <a href="#overview">Overview</a>
      <a href="#residences">Residences</a>
      <a href="#amenities">Amenities</a>
      <a href="#location">Location</a>
      <a href="#payment">Payment</a>
      <a href="#faq">FAQ</a>
    </nav>

    <div class="header-rera" aria-label="RERA registration">
      RERA
      <strong><?= htmlspecialchars($projectRera) ?></strong>
    </div>

    <button id="navToggle" class="nav-toggle" type="button" aria-label="Toggle navigation">
      <span></span>
    </button>
  </div>
</header>
