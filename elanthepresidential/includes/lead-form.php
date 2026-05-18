<?php
// Initialize variables for form validation
$nameErr = $emailErr = $phoneErr = $messageErr = '';
$name = $email = $phone = $message = '';
$formSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lead_form'])) {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        if (strlen($name) < 2) $nameErr = "Name must be at least 2 characters long";
        elseif (!preg_match("/^[a-zA-Z\s\p{L}.'\\-]*$/u", $name)) $nameErr = "Name contains invalid characters";
    }
    if (empty($_POST["email"])) { $emailErr = "Email is required"; }
    else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $emailErr = "Invalid email format";
    }
    if (empty($_POST["phone"])) { $phoneErr = "Phone number is required"; }
    else {
        $phone = test_input($_POST["phone"]);
        $phone_digits = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone_digits) < 10 || strlen($phone_digits) > 15) $phoneErr = "Phone number must be between 10 and 15 digits";
    }
    if (!empty($_POST["message"])) $message = test_input($_POST["message"]);

    if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($messageErr)) {
        $formSubmitted = true;
        $_SESSION['form_success'] = "Thank you for your enquiry. Our relationship manager will contact you within 24 hours.";
        header("Location: " . $_SERVER['PHP_SELF'] . "#contact");
        exit();
    }
}

if (!function_exists('test_input')) {
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
?>

<div style="background:#fff; border:1px solid var(--stone-300); border-top:2px solid var(--gold-500); padding:48px 40px;">
    <span class="eyebrow">Schedule A Private Viewing</span>
    <h3 class="display-sm" style="margin:0 0 8px;">Register Your Interest</h3>
    <p class="body-sm" style="margin:0 0 28px;">A dedicated relationship manager will reach out to you within 24 hours with floor plans, pricing and a private site-visit slot.</p>

    <form action="process-form.php" method="POST">
        <input type="hidden" name="lead_form" value="1">
        <input type="hidden" name="form_source" value="contact_section">

        <div class="form-control">
            <label for="lf-name">Full Name</label>
            <input type="text" id="lf-name" name="name" placeholder="Your name" value="<?php echo htmlspecialchars($name); ?>" required minlength="2" pattern="[a-zA-Z\s\p{L}.'\\-]*" title="Name can only contain letters, spaces, dots, hyphens and apostrophes">
            <?php if (!empty($nameErr)): ?><p class="error-message"><?php echo $nameErr; ?></p><?php endif; ?>
        </div>

        <div class="form-control">
            <label for="lf-email">Email Address</label>
            <input type="email" id="lf-email" name="email" placeholder="you@email.com" value="<?php echo htmlspecialchars($email); ?>" required>
            <?php if (!empty($emailErr)): ?><p class="error-message"><?php echo $emailErr; ?></p><?php endif; ?>
        </div>

        <div class="form-control">
            <label for="lf-phone">Phone Number</label>
            <input type="tel" id="lf-phone" name="phone" placeholder="+91" value="<?php echo htmlspecialchars($phone); ?>" required minlength="10" maxlength="15" pattern="\d{10}" title="Please enter a valid phone number with at least 10 digits">
            <?php if (!empty($phoneErr)): ?><p class="error-message"><?php echo $phoneErr; ?></p><?php endif; ?>
        </div>

        <div class="form-control">
            <label for="lf-interest">Residence of Interest</label>
            <select id="lf-interest" name="interested_in" required>
                <option value="" selected disabled>Select a configuration</option>
                <option value="3 BHK · 2,500 sq ft">3 BHK &middot; 2,500 sq ft</option>
                <option value="4 BHK + SQ · 4,000 sq ft">4 BHK + SQ &middot; 4,000 sq ft</option>
                <option value="5 BHK + SQ · 4,499 sq ft">5 BHK + SQ &middot; 4,499 sq ft</option>
                <option value="Signature Penthouse">Signature Penthouse</option>
                <option value="Schedule Site Visit">Schedule Site Visit</option>
            </select>
        </div>

        <div class="form-control">
            <label for="lf-message">Your Message</label>
            <textarea id="lf-message" name="message" rows="3" placeholder="Anything we should know?"><?php echo htmlspecialchars($message); ?></textarea>
        </div>

        <button type="submit" class="btn btn--gold" style="width:100%; margin-top:8px;">
            Request Details
        </button>

        <p style="margin-top:20px; font-family:var(--font-sans); font-size:10px; letter-spacing:0.18em; text-transform:uppercase; color:var(--stone-500); text-align:center;">
            RERA &middot; GGM/626/358/2022/101
        </p>
    </form>
</div>
