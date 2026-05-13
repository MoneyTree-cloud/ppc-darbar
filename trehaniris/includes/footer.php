    <!-- ── Footer (Omara-inspired minimal) ── -->
    <footer style="background:var(--bg-dark);color:rgba(255,255,255,0.5);padding:64px 0 32px;font-size:13px;">
        <div class="container">
            <!-- Top: Contact info -->
            <div style="text-align:center;margin-bottom:48px;">
                <span class="label-sm" style="color:var(--accent-light);display:block;margin-bottom:16px;">Contact Us</span>
                <p style="font-family:var(--font-serif);font-size:16px;color:rgba(255,255,255,0.8);margin-bottom:12px;font-weight:300;">
                    Use the details below to connect and stay informed about the latest events, news, and exclusive offers.
                </p>
                <div style="display:flex;justify-content:center;gap:32px;flex-wrap:wrap;margin-top:20px;">
                    <a href="tel:<?= SITE_PHONE ?>" style="color:rgba(255,255,255,0.7);font-size:13px;letter-spacing:1.5px;text-transform:uppercase;" onclick="trackEvent('click_to_call','footer')"><?= SITE_PHONE_DISPLAY ?></a>
                    <a href="mailto:<?= SITE_EMAIL ?>" style="color:rgba(255,255,255,0.7);font-size:13px;letter-spacing:1.5px;text-transform:uppercase;"><?= SITE_EMAIL ?></a>
                </div>
            </div>

            <!-- Divider -->
            <div style="height:1px;background:rgba(255,255,255,0.08);margin-bottom:32px;"></div>

            <!-- Bottom: Meta -->
            <div style="text-align:center;">
                <p style="font-family:var(--font-serif);font-size:15px;color:rgba(255,255,255,0.6);margin-bottom:8px;"><?= PROPERTY_NAME ?></p>
                <p style="font-size:11px;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:6px;"><?= PROPERTY_LOCATION ?> &middot; <?= PROPERTY_DEVELOPER ?></p>
                <p style="font-size:11px;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:20px;">RERA No. <?= PROPERTY_RERA ?></p>

                <!-- Category tags (Omara-style) -->
                <div style="display:flex;justify-content:center;gap:8px;flex-wrap:wrap;margin-bottom:24px;">
                    <?php
                    $tags = ['Retail', 'Food Court', 'Commercial', 'Office Space', 'Entertainment', 'Investment'];
                    foreach ($tags as $tag):
                    ?>
                    <span style="font-size:10px;letter-spacing:1.5px;text-transform:uppercase;padding:6px 14px;border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.4);"><?= $tag ?></span>
                    <?php endforeach; ?>
                </div>

                <p style="font-size:11px;color:rgba(255,255,255,0.45);letter-spacing:0.5px;">&copy; <?= date('Y') ?> <?= COMPANY_NAME ?>. All rights reserved. &middot; <a href="/privacy-policy" style="color:rgba(255,255,255,0.45);">Privacy Policy</a></p>
            </div>
        </div>
    </footer>

    <!-- Mobile Sticky CTA Bar -->
    <div class="mobile-sticky">
        <div class="btns">
            <a href="tel:<?= SITE_PHONE ?>" class="btn-call" onclick="trackEvent('click_to_call','mobile_sticky')">
                Call Now
            </a>
            <a href="https://api.whatsapp.com/send?phone=<?= SITE_WHATSAPP ?>&text=Hi%20I%20am%20interested%20in%20<?= urlencode(PROPERTY_NAME) ?>%20<?= urlencode(PROPERTY_LOCATION) ?>.%20Please%20share%20details." target="_blank" class="btn-whatsapp" onclick="trackEvent('whatsapp_click','mobile_sticky')">
                WhatsApp
            </a>
        </div>
    </div>

    <!-- WhatsApp Floating Button (desktop) -->
    <a href="https://api.whatsapp.com/send?phone=<?= SITE_WHATSAPP ?>&text=Hi%20I%20am%20interested%20in%20<?= urlencode(PROPERTY_NAME) ?>%20<?= urlencode(PROPERTY_LOCATION) ?>.%20Please%20share%20details." target="_blank" class="whatsapp-float" onclick="trackEvent('whatsapp_click','floating')" aria-label="Chat on WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#fff" viewBox="0 0 16 16"><path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.116.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.116-.198-.012-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/></svg>
    </a>

    <!-- Header scroll effect -->
    <script>
    (function(){
        var h = document.getElementById('siteHeader');
        if(h) window.addEventListener('scroll', function(){
            h.classList.toggle('scrolled', window.scrollY > 40);
        }, {passive:true});
    })();
    </script>

    <!-- Main JS -->
    <script defer src="/ppc-darbar/trehaniris/assets/js/main.js"></script>

    <!-- GA4 (if not using GTM) -->
    <?php if (GA4_ID !== 'G-XXXXXXXXXX' && GTM_ID === 'GTM-XXXXXXX'): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= GA4_ID ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?= GA4_ID ?>');
    </script>
    <?php endif; ?>

    <!-- Facebook Pixel -->
    <?php if (FB_PIXEL_ID !== ''): ?>
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?= FB_PIXEL_ID ?>');
        fbq('track', 'PageView');
    </script>
    <?php endif; ?>
</body>
</html>
