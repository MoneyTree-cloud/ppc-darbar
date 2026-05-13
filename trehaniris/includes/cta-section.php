<?php
/**
 * Final CTA Section — honest, value-driven
 */
?>
<section class="section cta-section" id="cta-final">
    <div class="container" style="text-align:center;max-width:640px;">
        <span class="label-sm" style="color:var(--accent-light);">Ready to Invest?</span>
        <div style="width:48px;height:1px;background:var(--accent-light);margin:0 auto 28px;opacity:0.4;"></div>
        <h2 class="cta-big-headline">See it for yourself — <em>book a free site visit</em></h2>
        <p class="cta-big-text">Visit the operational complex, meet existing tenants, see actual footfall, and get unit-wise pricing on the spot. Free pickup from your location.</p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;margin-top:36px;">
            <a href="#leadForm-card" class="cta-btn" style="width:auto;min-width:220px;" onclick="trackEvent('cta_click','final_section')">Book Free Site Visit</a>
            <a href="tel:<?= SITE_PHONE ?>" class="cta-btn cta-btn-outline" style="width:auto;min-width:220px;border-color:rgba(255,255,255,0.2);color:rgba(255,255,255,0.8);" onclick="trackEvent('click_to_call','final_section')">
                Call <?= SITE_PHONE_DISPLAY ?>
            </a>
        </div>
        <p style="margin-top:24px;font-size:11px;color:rgba(255,255,255,0.3);letter-spacing:1.5px;text-transform:uppercase;">
            No obligation. No spam. Just honest property guidance.
        </p>
    </div>
</section>
