<?php
$projectRera = $projectRera ?? 'UPRERAPRJ300532/12/2025';
$phone       = $phone       ?? '+91-9412-234-688';
$phoneLink   = preg_replace('/[^0-9+]/', '', $phone);
$waNumber    = preg_replace('/[^0-9]/', '', $phone);
?>
<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <h4>Smartworld Elie Saab</h4>
        <p style="color:var(--text-mid-dark); font-size:13px; max-width:360px;">
          Couture-inspired branded residences in Sector 98, Noida Expressway — a
          Smart World Developers project in association with M3M India and Elie Saab.
        </p>
        <div class="footer-rera">
          RERA Registration
          <strong><?= htmlspecialchars($projectRera) ?></strong>
        </div>
      </div>

      <div>
        <h4>Explore</h4>
        <ul>
          <li><a href="#overview">Overview</a></li>
          <li><a href="#residences">Residences</a></li>
          <li><a href="#floor-plans">Floor Plans</a></li>
          <li><a href="#amenities">Amenities</a></li>
          <li><a href="#location">Location</a></li>
        </ul>
      </div>

      <div>
        <h4>Information</h4>
        <ul>
          <li><a href="#payment">Payment Plan</a></li>
          <li><a href="#developer">Developer</a></li>
          <li><a href="#faq">FAQ</a></li>
          <li><a href="privacy-policy.html">Privacy Policy</a></li>
        </ul>
      </div>

      <div>
        <h4>Contact</h4>
        <ul>
          <li><a href="tel:<?= htmlspecialchars($phoneLink) ?>"><?= htmlspecialchars($phone) ?></a></li>
          <li><a href="https://wa.me/<?= htmlspecialchars($waNumber) ?>" target="_blank" rel="noopener">WhatsApp</a></li>
          <li>Sector 98, Noida Expressway<br>Gautam Buddha Nagar, UP 201303</li>
        </ul>
      </div>
    </div>

    <div class="footer-disclaimer">
      <p>
        <strong style="color:var(--text-mid-dark);">Disclaimer:</strong>
        This website is for informational purposes only and does not constitute an offer,
        invitation, or solicitation to purchase property. All project details including
        specifications, amenities, dimensions, prices, and tentative possession dates are
        indicative and subject to change at the sole discretion of the developer, Smart
        World Developers, without notice. Nothing on this website should be construed as
        legal, financial, or investment advice, and no assurance or guarantee of any return
        on investment is offered, implied, or intended. The project name, design, and
        brand association with Elie Saab are used per the agreement between the developer
        and brand partners. Prospective buyers should independently verify all information,
        review the RERA registration (<?= htmlspecialchars($projectRera) ?>), and consult
        the official sale agreement before making any purchase decision. Images shown may
        be artistic impressions and may vary from final construction.
      </p>
      <p style="margin-top:18px;">
        &copy; <span id="currentYear"></span> Smartworld Elie Saab Residences. All rights reserved.
      </p>
    </div>
  </div>
</footer>

<div class="floating-actions" aria-label="Quick contact">
  <a href="https://wa.me/<?= htmlspecialchars($waNumber) ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.52 3.48A11.9 11.9 0 0012.06 0C5.5 0 .17 5.32.17 11.88c0 2.09.55 4.13 1.6 5.93L0 24l6.35-1.66a11.87 11.87 0 005.7 1.45h.01c6.56 0 11.89-5.32 11.89-11.88 0-3.17-1.24-6.15-3.43-8.43zM12.06 21.3h-.01a9.42 9.42 0 01-4.8-1.31l-.34-.2-3.77.99 1.01-3.67-.22-.37a9.39 9.39 0 01-1.43-4.86c0-5.19 4.23-9.42 9.44-9.42 2.52 0 4.88.98 6.66 2.77a9.34 9.34 0 012.76 6.66c0 5.19-4.24 9.41-9.3 9.41zm5.17-7.04c-.28-.14-1.68-.83-1.94-.92-.26-.1-.45-.14-.63.14-.19.28-.72.92-.88 1.11-.16.19-.32.21-.6.07-.28-.14-1.2-.44-2.29-1.41-.85-.76-1.42-1.69-1.59-1.97-.16-.28-.02-.43.12-.57.13-.13.28-.33.42-.5.14-.16.18-.28.28-.46.09-.19.05-.35-.02-.5-.07-.14-.63-1.51-.86-2.07-.23-.54-.47-.47-.63-.48l-.54-.01c-.18 0-.49.07-.74.35-.25.28-.97.95-.97 2.31 0 1.36.99 2.68 1.13 2.87.14.19 1.95 2.98 4.73 4.18.66.28 1.18.45 1.58.58.66.21 1.27.18 1.75.11.53-.08 1.68-.69 1.92-1.35.24-.66.24-1.22.17-1.34-.07-.12-.26-.19-.54-.33z"/></svg>
  </a>
  <a href="tel:<?= htmlspecialchars($phoneLink) ?>" aria-label="Call">
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 15.5c-1.25 0-2.45-.2-3.57-.57a1 1 0 00-1.02.24l-2.2 2.2a15.05 15.05 0 01-6.58-6.58l2.2-2.21a1 1 0 00.25-1A11.36 11.36 0 018.5 4a1 1 0 00-1-1H4a1 1 0 00-1 1c0 9.39 7.61 17 17 17a1 1 0 001-1v-3.5a1 1 0 00-1-1z"/></svg>
  </a>
</div>
