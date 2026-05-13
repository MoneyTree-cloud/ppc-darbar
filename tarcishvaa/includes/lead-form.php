<div class="glass-form">
    <span class="form-eyebrow">Schedule a Private Viewing</span>
    <h3>Register Your Interest</h3>
    <p class="form-sub">A dedicated relationship manager will contact you within 24 hours with floor plans, pricing and a private site-visit slot.</p>

    <form action="process-form.php" method="POST" class="lead-form" id="main-lead-form" novalidate>
        <input type="hidden" name="lead_form" value="1">
        <input type="hidden" name="form_source" value="contact_section">
        <!-- Honeypot — hidden from humans, bots fill it -->
        <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" class="hp-field">

        <div class="field">
            <input type="text" name="name" placeholder="Full name" required minlength="2" maxlength="80" autocomplete="name" inputmode="text" aria-label="Full name">
            <span class="field-error" data-for="name"></span>
        </div>
        <div class="field">
            <input type="email" name="email" placeholder="Email address" required maxlength="120" autocomplete="email" inputmode="email" aria-label="Email address">
            <span class="field-error" data-for="email"></span>
        </div>
        <div class="field">
            <input type="tel" name="phone" placeholder="Phone number (+91)" required minlength="10" maxlength="17" autocomplete="tel" inputmode="tel" aria-label="Phone number">
            <span class="field-error" data-for="phone"></span>
        </div>

        <select name="interested_in" required aria-label="Residence of interest">
            <option value="" selected disabled>Residence of interest</option>
            <option value="3 BHK · 2,900 – 3,200 sq ft">3 BHK &middot; 2,900 – 3,200 sq ft</option>
            <option value="4 BHK · 3,450 – 3,883 sq ft">4 BHK &middot; 3,450 – 3,883 sq ft</option>
            <option value="Schedule Site Visit">Schedule Site Visit</option>
            <option value="Download Brochure">Download Brochure</option>
        </select>

        <textarea name="message" placeholder="Your message (optional)" rows="2" maxlength="500" aria-label="Message"></textarea>

        <button type="submit" class="btn btn--brass btn--full" style="margin-top:18px;">
            Request Details
        </button>

        <p class="form-rera">RERA &middot; GGM/865/597/2024/92</p>
    </form>
</div>
