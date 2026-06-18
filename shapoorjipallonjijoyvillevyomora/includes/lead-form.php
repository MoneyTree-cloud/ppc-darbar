<div class="sun-form">
    <h2 class="form-heading">Request Floor Plans<br>&amp; Price Sheet</h2>
    <p class="form-sub">No spam. Our team at Joyville Vyomora will reach you within a few hours.</p>

    <form action="process-form.php" method="POST" class="lead-form" id="hero-lead-form" novalidate>
        <input type="hidden" name="lead_form" value="1">
        <input type="hidden" name="form_source" value="hero_form">
        <!-- Honeypot -->
        <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" class="hp-field">

        <div class="form-group">
            <label for="f-name">Full Name</label>
            <input type="text" id="f-name" name="name" placeholder="Your name"
                required minlength="2" maxlength="80"
                autocomplete="name" inputmode="text" aria-label="Full name">
            <span class="field-error" data-for="name"></span>
        </div>

        <div class="form-group">
            <label for="f-phone">Mobile Number</label>
            <input type="tel" id="f-phone" name="phone" placeholder="9412234688"
                required minlength="10" maxlength="10"
                autocomplete="tel" inputmode="tel" aria-label="Phone number"
                pattern="[6-9][0-9]{9}">
            <span class="field-error" data-for="phone"></span>
        </div>

        <div class="form-group">
            <label for="f-email">Email Address</label>
            <input type="email" id="f-email" name="email" placeholder="you@email.com"
                required maxlength="120"
                autocomplete="email" inputmode="email" aria-label="Email address">
            <span class="field-error" data-for="email"></span>
        </div>

        <button type="submit" class="form-submit">Send My Query to Joyville Vyomora</button>
    </form>

    <p class="form-note">By submitting, you agree to be contacted by Joyville Vyomora regarding this property. Your information is not shared with third parties.</p>
    <div class="rera-badge">MahaRERA: Coming Soon &nbsp;|&nbsp; Shapoorji Pallonji</div>
</div>
