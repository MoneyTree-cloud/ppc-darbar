<?php
/**
 * Trehan Iris Broadway — Main PPC Landing Page
 * Lean, image-forward, conversion-optimized
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/schema.php';

serveCache();
ob_start();

$page_title       = 'Trehan Iris Broadway Sector 85 Gurgaon | Commercial Shops & Office Spaces';
$page_description = 'Trehan Iris Broadway, Sector 85, Gurgaon — premium retail shops, office spaces & food courts on Dwarka Expressway by Trehan Group. RERA No. ' . PROPERTY_RERA . '. Starting ' . PROPERTY_PRICE_START . '. Call ' . SITE_PHONE_DISPLAY;
$page_url         = SITE_URL;
$page_headline    = 'Trehan Iris Broadway — Premium Commercial Spaces in Sector 85, Gurgaon';

$variant = getVariant('hero_headline');

include __DIR__ . '/includes/header.php';

$faq_data = [
    ['q' => 'What is Trehan Iris Broadway Sector 85 Gurgaon?', 'a' => 'Trehan Iris Broadway is a premium commercial development by Trehan Group located in Sector 85, Gurgaon offering retail shops, office spaces, food courts, and entertainment zones. RERA No. ' . PROPERTY_RERA . '.'],
    ['q' => 'What is the price of commercial shops in Trehan Iris Broadway?', 'a' => 'Retail shops start from ' . PROPERTY_PRICE_START . ' onwards (approx. Rs 28,000-35,000/sq.ft.). Payment plans include CLP, down payment, and EMI options.'],
    ['q' => 'Is Trehan Iris Broadway ready for possession?', 'a' => 'Yes. The complex is fully operational with anchor tenants like Haldirams, KFC, and INOX already running. You can visit and see the footfall today.'],
    ['q' => 'Where exactly is Trehan Iris Broadway located?', 'a' => 'Sector 85, Gurgaon — on the Dwarka Expressway corridor. 5 min from NH-8, 25 min from IGI Airport, surrounded by 50,000+ families.'],
    ['q' => 'Is Trehan Iris Broadway RERA registered?', 'a' => 'Yes — Haryana RERA No. ' . PROPERTY_RERA . '. Freehold property with clear title. Verify at haryanarera.gov.in.'],
];

echo generateSchema([
    'title' => $page_title, 'description' => $page_description,
    'url' => $page_url, 'faqs' => $faq_data,
]);
?>

    <!-- ============================================ -->
    <!-- HERO — brighter image, see the product      -->
    <!-- ============================================ -->
    <section class="hero hero-bright" id="hero">
        <div class="hero-bg" style="background-image:url('/ppc-darbar/trehaniris/assets/img/hero.jpg');"></div>
        <div class="hero-overlay"></div>
        <div class="hero-inner">
            <div class="container">
                <div class="hero-grid">
                    <div class="hero-content">
                        <span class="label-sm">Ready for Possession &middot; Dwarka Expressway</span>
                        <h1><?= $headline ?></h1>
                        <p class="subhead">Retail shops, offices &amp; food courts with Haldirams, KFC, INOX already operational. RERA registered. Freehold.</p>

                        <ul class="hero-usps">
                            <li><span class="usp-icon"></span> From <?= PROPERTY_PRICE_START ?> (~Rs 28,000/sq.ft.)</li>
                            <li><span class="usp-icon"></span> Dwarka Expressway, <?= PROPERTY_LOCATION ?></li>
                            <li><span class="usp-icon"></span> Haldirams, KFC, INOX &amp; 20+ brands operational</li>
                            <li><span class="usp-icon"></span> RERA <?= PROPERTY_RERA ?> &middot; Freehold &middot; Ready to Move</li>
                        </ul>
                    </div>

                    <div>
                        <?php
                        $form_id    = 'leadForm';
                        $form_title = 'Get Floor Plan & Price List';
                        $form_sub   = 'Receive the brochure instantly. Our expert calls within 30 min.';
                        $form_cta   = 'Download Floor Plan & Price List';
                        include __DIR__ . '/includes/form.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Status Ribbon -->
    <div class="urgency-ribbon">
        <div class="container">
            <div class="urgency-inner">
                <div class="urgency-item"><span class="urgency-pulse"></span> <span>Project Status: <strong>Ready for Possession</strong></span></div>
                <div class="urgency-item"><span class="urgency-icon">&#127970;</span> <span>Anchor tenants <strong>Haldirams, KFC, INOX</strong> operational</span></div>
                <div class="urgency-item urgency-cta-wrap"><a href="#leadForm-card" class="urgency-cta">Get Price List &rarr;</a></div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-bar">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item"><div class="stat-number">500<sup>+</sup></div><div class="stat-label">Units Sold</div></div>
                <div class="stat-item"><div class="stat-number">25<sup>+</sup></div><div class="stat-label">Years Legacy</div></div>
                <div class="stat-item"><div class="stat-number">4.7<sup>/5</sup></div><div class="stat-label">Google Rating</div></div>
                <div class="stat-item"><div class="stat-number">50K<sup>+</sup></div><div class="stat-label">Families Nearby</div></div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- FULL-WIDTH IMAGE GALLERY (see the product)  -->
    <!-- ============================================ -->
    <section class="gallery-section" id="gallery">
        <div class="gallery-grid">
            <div class="gallery-item gallery-large">
                <img src="/ppc-darbar/trehaniris/assets/img/retail.webp" alt="Trehan Iris Broadway night view — retail shops, Haldirams, entertainment zone lit up in Sector 85 Gurgaon" loading="eager" width="800" height="600">
                <div class="gallery-label">Retail &amp; Entertainment Zone — Operational</div>
            </div>
            <div class="gallery-item">
                <img src="/ppc-darbar/trehaniris/assets/img/office.webp" alt="Trehan Iris Broadway — modern glass commercial tower exterior with Iris branding" loading="lazy" width="400" height="400">
                <div class="gallery-label">Commercial Tower</div>
            </div>
            <div class="gallery-item">
                <img src="/ppc-darbar/trehaniris/assets/img/lifestyle.webp" alt="Trehan Iris Broadway — shoppers at premium fashion retail stores" loading="lazy" width="400" height="400">
                <div class="gallery-label">Premium Retail Experience</div>
            </div>
            <div class="gallery-item">
                <img src="/ppc-darbar/trehaniris/assets/img/quote-bg.jpg" alt="Trehan Iris Broadway — KFC and IRIS BROADWAY signage on building exterior" loading="lazy" width="400" height="400">
                <div class="gallery-label">KFC &amp; Brand Outlets</div>
            </div>
            <div class="gallery-item">
                <img src="/ppc-darbar/trehaniris/assets/img/hero.jpg" alt="Trehan Iris Broadway aerial view — full commercial complex in Sector 85 Gurgaon" loading="lazy" width="400" height="400">
                <div class="gallery-label">Aerial View — Sector 85</div>
            </div>
        </div>
        <div style="text-align:center;padding:28px 24px 0;">
            <a href="#leadForm-card" class="cta-btn" style="width:auto;display:inline-block;padding:14px 36px;" onclick="trackEvent('cta_click','gallery')">Get Detailed Brochure With All Images</a>
        </div>
    </section>

    <!-- ============================================ -->
    <!-- KEY FACTS (compact, scannable)              -->
    <!-- ============================================ -->
    <section class="section section-cream" id="key-facts">
        <div class="container">
            <h2 class="section-title">Why <em><?= PROPERTY_NAME ?></em></h2>
            <p class="section-subtitle">A ready commercial complex with proven footfall — not a promise, a reality you can visit today.</p>

            <div class="highlights-grid">
                <div class="highlight-card"><div class="icon">&#128205;</div><h3><?= PROPERTY_LOCATION ?></h3><p>Dwarka Expressway. NH-8 in 5 min. IGI Airport 25 min. 50,000+ families in catchment.</p></div>
                <div class="highlight-card"><div class="icon">&#128176;</div><h3>Rs 28K - 35K/sq.ft.</h3><p>Ground floor premium. CLP, down payment &amp; EMI options. Freehold ownership.</p></div>
                <div class="highlight-card"><div class="icon">&#127942;</div><h3>Proven Footfall</h3><p>Haldirams, KFC, INOX &amp; 20+ brands operational. 5,000+ daily visitors.</p></div>
                <div class="highlight-card"><div class="icon">&#128200;</div><h3>Rs 50-100/sq.ft. Rental</h3><p>Expected monthly rental yield for ground &amp; first floor retail units.</p></div>
                <div class="highlight-card"><div class="icon">&#128203;</div><h3>RERA Freehold</h3><p>No. <?= PROPERTY_RERA ?>. Clear title. All approvals. <a href="https://haryanarera.gov.in" target="_blank" rel="noopener" style="color:var(--accent);text-decoration:underline;">Verify</a>.</p></div>
                <div class="highlight-card"><div class="icon">&#127968;</div><h3>Ready to Move</h3><p>No construction wait. Start earning rental income immediately.</p></div>
            </div>
        </div>
    </section>

    <!-- Social Proof -->
    <?php include __DIR__ . '/includes/trust-signals.php'; ?>

    <!-- CTA Strip -->
    <div class="cta-strip cta-strip-dark">
        <div class="cta-strip-inner">
            <span><strong>Visit the property yourself.</strong> Book a free site visit with pickup.</span>
            <a href="#leadForm-card" class="cta-btn" style="width:auto;padding:12px 28px;font-size:12px;">Book Free Site Visit</a>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- PRICING (specific, no "On Request")         -->
    <!-- ============================================ -->
    <section class="section" id="pricing">
        <div class="container">
            <h2 class="section-title"><?= PROPERTY_NAME ?> <em>Price List</em></h2>
            <p class="section-subtitle">Indicative pricing. Get the exact unit-wise price sheet with floor plans.</p>

            <div class="price-table-wrap">
                <table class="price-table">
                    <thead><tr><th>Unit Type</th><th>Size Range</th><th>Approx. Rate</th><th>Starting Price</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Ground Floor Retail</strong></td><td>150 - 500 sq.ft.</td><td>Rs 32,000 - 35,000/sq.ft.</td><td>Rs 48 Lac onwards</td></tr>
                        <tr><td><strong>First Floor Retail</strong></td><td>150 - 400 sq.ft.</td><td>Rs 28,000 - 30,000/sq.ft.</td><td><?= PROPERTY_PRICE_START ?> onwards</td></tr>
                        <tr><td><strong>Food Court Unit</strong></td><td>200 - 400 sq.ft.</td><td>Rs 25,000 - 30,000/sq.ft.</td><td>Rs 50 Lac onwards</td></tr>
                        <tr><td><strong>Office Space</strong></td><td>300 - 1000 sq.ft.</td><td>Rs 18,000 - 22,000/sq.ft.</td><td>Rs 54 Lac onwards</td></tr>
                    </tbody>
                </table>
            </div>

            <p style="text-align:center;font-size:12px;color:var(--text-muted);margin-top:16px;font-style:italic;">Payment plans: CLP, down payment with discount, EMI via all major banks.</p>
            <div style="text-align:center;margin-top:28px;">
                <a href="#leadForm-card" class="cta-btn" style="max-width:400px;display:inline-block;">Get Unit-Wise Price Sheet (PDF)</a>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <?php include __DIR__ . '/includes/faq-section.php'; ?>

    <!-- Mid-Page Form -->
    <section class="section section-alt" id="contact">
        <div class="container" style="max-width:480px;">
            <?php
            $form_id    = 'midForm';
            $form_title = 'Get Brochure &amp; Site Visit Details';
            $form_sub   = 'Floor plans, unit pricing, and payment options.';
            $form_cta   = 'Send Me the Brochure';
            include __DIR__ . '/includes/form.php';
            ?>
        </div>
    </section>

    <!-- Final CTA -->
    <?php include __DIR__ . '/includes/cta-section.php'; ?>

    <!-- ============================================ -->
    <!-- SEO CONTENT (trimmed, below fold)           -->
    <!-- ============================================ -->
    <section class="section section-cream" id="about">
        <div class="container seo-content">
            <h2>About Trehan Iris Broadway Sector 85 Gurgaon</h2>
            <p><strong>Trehan Iris Broadway</strong> is a fully operational <strong>commercial property in Sector 85, Gurgaon</strong> by <strong>Trehan Group</strong> on <strong>Dwarka Expressway</strong>. The complex features <strong>retail shops</strong>, <strong>office spaces</strong>, <strong>food courts</strong>, and entertainment zones with anchor tenants like Haldirams, KFC, and INOX already drawing thousands of daily visitors.</p>

            <h3>Investment Details</h3>
            <p>Prices range from <strong>Rs 28,000 to Rs 35,000/sq.ft.</strong> for retail and <strong>Rs 18,000 to Rs 22,000/sq.ft.</strong> for offices. Total investment starts from <strong><?= PROPERTY_PRICE_START ?></strong>. <strong>Freehold</strong> property, RERA No. <strong><?= PROPERTY_RERA ?></strong>, ready for possession with flexible payment plans.</p>

            <h3>Location &amp; Connectivity</h3>
            <ul>
                <li><strong>Dwarka Expressway</strong> — direct access to Delhi and IGI Airport</li>
                <li><strong>NH-8</strong> — 5 minutes drive</li>
                <li><strong>Huda City Centre Metro</strong> — 15 minutes</li>
                <li><strong>IGI Airport</strong> — 25 minutes</li>
                <li>50,000+ families across sectors 82-86</li>
            </ul>

            <p>Whether you seek a <strong>retail shop in Gurgaon</strong> or <strong>commercial property on Dwarka Expressway</strong>, Trehan Iris Broadway is a proven choice backed by operational data, not marketing promises.</p>
        </div>
    </section>

    <!-- Exit-Intent Popup -->
    <div class="exit-popup-overlay" id="exitPopup" role="dialog" aria-label="Special offer">
        <div class="exit-popup">
            <button class="exit-popup-close" id="exitPopupClose" aria-label="Close">&times;</button>
            <div class="exit-popup-body">
                <span class="label-sm" style="color:var(--accent);">Before you go</span>
                <h3 style="font-family:var(--font-serif);font-size:26px;font-weight:400;margin:12px 0 8px;color:var(--text-dark);">Get the <em>Floor Plan &amp; Price Sheet</em></h3>
                <p style="font-size:14px;color:var(--text-muted);margin-bottom:24px;">Unit-wise pricing, layouts, and payment options — delivered to your WhatsApp.</p>
                <?php
                $form_id = 'exitForm'; $form_title = ''; $form_sub = '';
                $form_cta = 'Send Me the PDF'; $show_whatsapp = false;
                include __DIR__ . '/includes/form.php';
                $show_whatsapp = true;
                ?>
            </div>
        </div>
    </div>

    <!-- Social Proof Toast -->
    <div class="toast-notification" id="socialToast" role="status" aria-live="polite">
        <div class="toast-icon">&#9733;</div>
        <div class="toast-text">
            <strong id="toastName"></strong>
            <span id="toastAction"></span>
            <small id="toastTime"></small>
        </div>
    </div>

    <!-- Sticky Desktop CTA -->
    <div class="sticky-cta-bar" id="stickyCta">
        <div class="container">
            <div class="sticky-cta-inner">
                <div class="sticky-cta-text">
                    <strong><?= PROPERTY_NAME ?></strong>
                    <span>From <?= PROPERTY_PRICE_START ?> &middot; Ready &middot; RERA: <?= PROPERTY_RERA ?></span>
                </div>
                <div class="sticky-cta-btns">
                    <a href="tel:<?= SITE_PHONE ?>" class="cta-btn cta-btn-dark" style="width:auto;padding:10px 24px;font-size:11px;">Call <?= SITE_PHONE_DISPLAY ?></a>
                    <a href="#leadForm-card" class="cta-btn" style="width:auto;padding:10px 24px;font-size:11px;">Get Floor Plan</a>
                </div>
            </div>
        </div>
    </div>

<?php
include __DIR__ . '/includes/footer.php';
$output = ob_get_contents();
saveCache($output);
?>
