<div id="popup-form" class="hidden" role="dialog" aria-modal="true" aria-labelledby="popup-form-title">
    <div id="popup-form__overlay"></div>

    <div class="glass-form">
        <button id="close-popup" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>

        <span class="form-eyebrow">Limited Residences</span>
        <h3 id="popup-form-title">Download E-Brochure</h3>
        <p class="form-sub">Receive the complete project brochure, floor plans and price list on your email.</p>

        <form action="process-form.php" method="POST" class="lead-form" id="popup-lead-form" novalidate>
            <input type="hidden" name="form_source" value="popup_form">
            <input type="hidden" name="form_type" id="popup-form-type" value="brochure">
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
                <input type="tel" name="phone" placeholder="Phone number" autocomplete="tel" inputmode="tel" aria-label="Phone number" required minlength="10" maxlength="10" pattern="\d{10}" title="Please enter a valid 10-digit mobile number">
                <span class="field-error" data-for="phone"></span>
            </div>

            <select name="interested_in" required aria-label="Residence of interest">
                <option value="" selected disabled>Residence of interest</option>
                <option value="3 BHK · 2,900 – 3,200 sq ft">3 BHK &middot; 2,900 – 3,200 sq ft</option>
                <option value="4 BHK · 3,450 – 3,883 sq ft">4 BHK &middot; 3,450 – 3,883 sq ft</option>
            </select>

            <textarea name="message" placeholder="Your message (optional)" rows="2" maxlength="500" aria-label="Message"></textarea>

            <button type="submit" class="btn btn--brass btn--full" style="margin-top:18px;">
                Download Brochure
            </button>

            <p class="form-rera">RERA &middot; GGM/865/597/2024/92</p>
        </form>
    </div>
</div>
