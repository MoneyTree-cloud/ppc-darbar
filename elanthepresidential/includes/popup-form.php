<!-- Popup Enquiry Form -->
<style>
  #popup-form { position:fixed; inset:0; align-items:center; justify-content:center; z-index:2000; display:flex; }
  #popup-form.hidden { display:none !important; }
</style>
<div id="popup-form" class="hidden">
    <div style="position:absolute; inset:0; background:rgba(11,18,32,0.78); backdrop-filter:blur(8px);"></div>

    <div class="glass-form" style="position:relative; width:100%; max-width:460px; margin:0 20px;">
        <button id="close-popup" aria-label="Close" style="position:absolute; top:20px; right:20px; background:transparent; border:none; color:var(--gold-400); font-size:26px; cursor:pointer;">
            <i class="fas fa-times"></i>
        </button>

        <span class="form-eyebrow">Limited Residences</span>
        <h3>Download E-Brochure</h3>
        <p class="form-sub">Receive the complete project brochure, floor plans and price list on your email.</p>

        <form action="process-form.php" method="POST">
            <input type="hidden" name="form_source" value="popup_form">
            <input type="hidden" name="form_type" id="popup-form-type" value="general">

            <input type="text" name="name" placeholder="Your name" required minlength="2" pattern="[a-zA-Z\s\p{L}.'\\-]*" title="Name can only contain letters, spaces, dots, hyphens and apostrophes">
            <input type="email" name="email" placeholder="Email address" required>
            <input type="tel" name="phone" placeholder="Phone number" required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}" title="Please enter a valid 10-digit Indian mobile number">

            <select name="interested_in" required>
                <option value="" selected disabled>Residence of interest</option>
                <option value="3 BHK · 2,500 sq ft">3 BHK · 2,500 sq ft</option>
                <option value="4 BHK + SQ · 4,000 sq ft">4 BHK + SQ · 4,000 sq ft</option>
                <option value="5 BHK + SQ · 4,499 sq ft">5 BHK + SQ · 4,499 sq ft</option>
                <option value="Signature Penthouse">Signature Penthouse</option>
            </select>

            <textarea name="message" placeholder="Your message (optional)" rows="2"></textarea>

            <button type="submit" class="btn btn--gold" style="width:100%; margin-top:18px;">
                Download Brochure
            </button>

            <p class="form-rera">RERA · GGM/626/358/2022/101</p>
        </form>
    </div>
</div>
