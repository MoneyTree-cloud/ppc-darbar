<div class="glass-form">
    <span class="form-eyebrow">Book a Site Visit</span>
    <h3>Register Your Interest</h3>
    <p class="form-sub">Our relationship manager will call you within 24 hours with floor plans, pricing and a site-visit slot.</p>

    <form action="process-form.php" method="POST" class="lead-form" id="main-lead-form" novalidate>
        <input type="hidden" name="lead_form"   value="1">
        <input type="hidden" name="form_source" value="contact_section">
        <!-- Honeypot — invisible to humans, bots fill it -->
        <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" class="hp-field">

        <div class="field">
            <input type="text"  name="name"  placeholder="Full name"  required minlength="2" maxlength="80"  autocomplete="name"  inputmode="text"  aria-label="Full name">
            <span class="field-error" data-for="name"></span>
        </div>
        <div class="field">
            <input type="email" name="email" placeholder="Email address" required maxlength="120" autocomplete="email" inputmode="email" aria-label="Email address">
            <span class="field-error" data-for="email"></span>
        </div>
        <div class="field">
            <input type="tel"   name="phone" placeholder="Phone number" required minlength="10" maxlength="10" autocomplete="tel" inputmode="tel" aria-label="Phone number" pattern="[6-9][0-9]{9}" title="Please enter a valid 10-digit Indian mobile number">
            <span class="field-error" data-for="phone"></span>
        </div>

        <button type="submit" class="btn btn--green btn--full" style="margin-top:18px;">
            Request Details
        </button>

        <p class="form-rera">MahaRERA &middot; Coming Soon</p>
    </form>
</div>
