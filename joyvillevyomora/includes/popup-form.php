<div id="popup-form" class="hidden" role="dialog" aria-modal="true" aria-labelledby="popup-form-title">
    <div id="popup-form__overlay"></div>

    <div class="popup-inner">
        <button id="close-popup" aria-label="Close">&times;</button>

        <span class="popup-eyebrow">Limited Units Available</span>
        <h3 class="popup-heading" id="popup-form-title">Download E-Brochure</h3>
        <p class="popup-sub">Receive the complete project brochure, floor plans and price list on your email.</p>

        <form action="process-form.php" method="POST" class="lead-form" id="popup-lead-form" novalidate>
            <input type="hidden" name="form_source" value="popup_form">
            <input type="hidden" name="form_type"   id="popup-form-type" value="brochure">
            <input type="text"   name="website"     tabindex="-1" autocomplete="off" aria-hidden="true" class="hp-field">

            <div class="form-group">
                <label for="popup-name">Full Name</label>
                <input type="text" id="popup-name" name="name" placeholder="Your name"
                       required minlength="2" maxlength="80"
                       autocomplete="name" inputmode="text" aria-label="Full name">
                <span class="field-error" data-for="name"></span>
            </div>
            <div class="form-group">
                <label for="popup-email">Email Address</label>
                <input type="email" id="popup-email" name="email" placeholder="you@email.com"
                       required maxlength="120"
                       autocomplete="email" inputmode="email" aria-label="Email address">
                <span class="field-error" data-for="email"></span>
            </div>
            <div class="form-group">
                <label for="popup-phone">Phone Number</label>
                <input type="tel" id="popup-phone" name="phone" placeholder="9412234688"
                       required minlength="10" maxlength="10"
                       autocomplete="tel" inputmode="tel" aria-label="Phone number"
                       pattern="[6-9][0-9]{9}">
                <span class="field-error" data-for="phone"></span>
            </div>

            <button type="submit" class="popup-submit">Download Brochure</button>

            <p class="popup-rera">RERA Approved &middot; Shapoorji Pallonji</p>
        </form>
    </div>
</div>
