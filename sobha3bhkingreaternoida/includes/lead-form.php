<?php
/**
 * Reusable lead form.
 * Pass $formSource to identify where on the page this submitted from (hero_form, floor_plan, final_cta).
 * Pass $heading and $subline to customise context.
 */
$formSource = $formSource ?? 'hero_form';
$heading    = $heading    ?? 'Priority Allotment — SOBHA 3 BHK';
$subline    = $subline    ?? 'Floor plan · price sheet · payment plan shared within 24 hours';
$interestOptions = [
    'SOBHA Aurum · 3 BHK (1,570–1,901 sq ft)',
    'SOBHA Rivana · 3 BHK (1,752 sq ft)',
    'SOBHA Rivana · 4 BHK (2,715 sq ft)',
    'Open to best SOBHA option',
];
$formId = 'leadForm_' . preg_replace('/[^a-z0-9_]/i', '', $formSource);
?>
<form class="lead-form" id="<?= htmlspecialchars($formId) ?>" data-ajax="true" action="process-form.php" method="POST" novalidate autocomplete="on">
    <h3><?= htmlspecialchars($heading) ?></h3>
    <p class="form-sub"><?= htmlspecialchars($subline) ?></p>

    <div class="form-success" role="status" aria-live="polite"></div>

    <div class="form-group" data-field="name">
        <input type="text" name="name" placeholder="Full name" required minlength="2" maxlength="100" autocomplete="name" aria-label="Full name" aria-required="true">
        <span class="field-error" aria-live="polite"></span>
    </div>
    <div class="form-group" data-field="email">
        <input type="email" name="email" placeholder="Email address (optional)" maxlength="120" autocomplete="email" aria-label="Email address">
        <span class="field-error" aria-live="polite"></span>
    </div>
    <div class="form-group" data-field="phone">
        <input type="tel" name="phone" placeholder="Mobile number" required autocomplete="tel" inputmode="numeric" aria-label="Mobile number" aria-required="true" required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}" title="Please enter a valid 10-digit Indian mobile number">
        <span class="field-error" aria-live="polite"></span>
    </div>
    <div class="form-group" data-field="interested_in">
        <select name="interested_in" aria-label="Interested in">
            <option value="">Interested in…</option>
            <?php foreach ($interestOptions as $opt): ?>
                <option value="<?= htmlspecialchars($opt) ?>"><?= htmlspecialchars($opt) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Honeypots (kept off-screen; bots fill them, humans don't) -->
    <div class="hp-field" aria-hidden="true" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden">
        <label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        <label>Company<input type="text" name="company_website" tabindex="-1" autocomplete="off"></label>
    </div>

    <input type="hidden" name="form_source" value="<?= htmlspecialchars($formSource) ?>">

    <button type="submit" class="btn btn-primary" style="width:100%">
        <i class="fas fa-paper-plane"></i> Request Details
    </button>
    <p class="form-note">Your details are sent only to the SOBHA sales advisor. No spam.</p>
</form>
