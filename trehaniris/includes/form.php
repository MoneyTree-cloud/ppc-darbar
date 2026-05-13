<?php
/**
 * Reusable Lead Capture Form Component
 * Fixed: phone first, no fake FOMO, WhatsApp alt, honest language
 */
$form_id    = $form_id ?? 'leadForm';
$form_cta   = $form_cta ?? 'Download Floor Plan & Price List';
$form_title = $form_title ?? 'Get Floor Plan & Price List';
$form_sub   = $form_sub ?? 'Instantly receive the brochure. Our expert calls within 30 min.';
$variant    = $variant ?? getVariant('hero_cta');
$utm        = $utm ?? getUTMParams();
$csrf_token = $csrf_token ?? generateCSRFToken();
$show_whatsapp = $show_whatsapp ?? true;
?>

<div class="lead-form-card" id="<?= $form_id ?>-card">
    <?php if ($form_title): ?>
    <h3><?= $form_title ?></h3>
    <?php endif; ?>
    <?php if ($form_sub): ?>
    <p class="form-sub"><?= $form_sub ?></p>
    <?php endif; ?>

    <div class="form-error" id="<?= $form_id ?>-error"></div>

    <form class="lead-form" id="<?= $form_id ?>" data-variant="<?= $variant ?>" novalidate>
        <!-- Hidden tracking fields -->
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <input type="hidden" name="utm_source" value="<?= $utm['utm_source'] ?>">
        <input type="hidden" name="utm_medium" value="<?= $utm['utm_medium'] ?>">
        <input type="hidden" name="utm_campaign" value="<?= $utm['utm_campaign'] ?>">
        <input type="hidden" name="utm_term" value="<?= $utm['utm_term'] ?>">
        <input type="hidden" name="utm_content" value="<?= $utm['utm_content'] ?>">
        <input type="hidden" name="gclid" value="<?= $utm['gclid'] ?>">
        <input type="hidden" name="landing_page" value="<?= sanitize($_SERVER['REQUEST_URI']) ?>">
        <input type="hidden" name="variant" value="<?= $variant ?>">

        <!-- Honeypot -->
        <div class="hp-field" aria-hidden="true">
            <input type="text" name="website" tabindex="-1" autocomplete="off">
        </div>

        <!-- Phone FIRST — the only field that truly matters for callback -->
        <div class="form-group">
            <input type="tel" name="phone" placeholder="Mobile Number *" required pattern="[6-9]\d{9}" maxlength="10" autocomplete="tel">
        </div>
        <div class="form-group">
            <input type="text" name="name" placeholder="Your Name *" required autocomplete="name">
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="Email (Optional)" autocomplete="email">
        </div>
        <button type="submit" class="cta-btn" id="<?= $form_id ?>-btn"><?= $form_cta ?></button>

        <!-- WhatsApp alternative -->
        <?php if ($show_whatsapp): ?>
        <div class="form-whatsapp-alt">
            <span>or</span>
            <a href="https://api.whatsapp.com/send?phone=<?= SITE_WHATSAPP ?>&text=Hi%2C%20I%20am%20interested%20in%20<?= urlencode(PROPERTY_NAME) ?>%20<?= urlencode(PROPERTY_LOCATION) ?>.%20Please%20share%20floor%20plan%20and%20price%20list." target="_blank" onclick="trackEvent('whatsapp_click','form_alt_<?= $form_id ?>')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#25D366" viewBox="0 0 16 16" style="vertical-align:middle;margin-right:4px;"><path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.116.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.116-.198-.012-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/></svg>
                Get Details on WhatsApp
            </a>
        </div>
        <?php endif; ?>

        <!-- Trust badges -->
        <div class="form-trust-row">
            <div class="form-trust-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/><path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/></svg>
                RERA: <?= PROPERTY_RERA ?>
            </div>
            <div class="form-trust-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/></svg>
                No Spam, Guaranteed
            </div>
        </div>
    </form>

    <!-- Success state -->
    <div class="form-success" id="<?= $form_id ?>-success">
        <div class="check">&#10003;</div>
        <h4>Thank You!</h4>
        <p>Your floor plan and price list are on the way. Our expert will call within 30 minutes.</p>
    </div>
</div>
