<div id="popup-form" class="hidden" role="dialog" aria-modal="true" aria-labelledby="popup-form-title">
    <div id="popup-form__overlay"></div>

    <div class="glass-form">
        <button id="close-popup" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>

        <span class="form-eyebrow">Limited Units Available</span>
        <h3 id="popup-form-title">Download E-Brochure</h3>
        <p class="form-sub">Receive the complete project brochure, floor plans and price list on your email.</p>

        <form action="process-form.php" method="POST" class="lead-form" id="popup-lead-form" novalidate>
            <input type="hidden" name="form_source" value="popup_form">
            <input type="hidden" name="form_type"   id="popup-form-type" value="brochure">
            <input type="text"   name="website"     tabindex="-1" autocomplete="off" aria-hidden="true" class="hp-field">

            <div class="field">
                <input type="text"  name="name"  placeholder="Full name"     required minlength="2" maxlength="80"  autocomplete="name"  inputmode="text"  aria-label="Full name">
                <span class="field-error" data-for="name"></span>
            </div>
            <div class="field">
                <input type="email" name="email" placeholder="Email address" required maxlength="120" autocomplete="email" inputmode="email" aria-label="Email address">
                <span class="field-error" data-for="email"></span>
            </div>
            <div class="field">
                <input type="tel"   name="phone" placeholder="Phone number"  required minlength="10" maxlength="10" autocomplete="tel" inputmode="tel" aria-label="Phone number" pattern="[6-9][0-9]{9}">
                <span class="field-error" data-for="phone"></span>
            </div>

            <button type="submit" class="btn btn--green btn--full" style="margin-top:18px;">
                Download Brochure
            </button>

            <p class="form-rera">MahaRERA &middot; Coming Soon</p>
        </form>
    </div>
</div>
