<?php
// Initialize variables for form validation
$nameErr = $emailErr = $phoneErr = '';
$name = $email = $phone = '';
$formSubmitted = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lead_form'])) {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // Check if name is at least 2 characters long
        if (strlen($name) < 2) {
            $nameErr = "Name must be at least 2 characters long";
        }
        // Check if name contains valid characters (allow international names)
        elseif (!preg_match("/^[a-zA-Z\s\p{L}.'\\-]*$/u", $name)) {
            $nameErr = "Name contains invalid characters";
        }
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate phone
    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
        // Remove any non-digit characters for validation
        $phone_digits = preg_replace('/[^0-9]/', '', $phone);
        // Check if phone number is valid (between 10 and 15 digits)
        if (strlen($phone_digits) < 10 || strlen($phone_digits) > 15) {
            $phoneErr = "Phone number must be between 10 and 15 digits";
        }
    }

    // If no errors, process form
    if (empty($nameErr) && empty($emailErr) && empty($phoneErr)) {
        // Process the form data
        $formSubmitted = true;

        // Set success message in session
        $_SESSION['form_success'] = "Thank you for your inquiry! We will contact you shortly.";

        // Redirect to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF'] . "#contact");
        exit();
    }
}

// Function to sanitize form data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<div class="bg-white rounded-lg shadow-xl p-8">
    <h3 class="text-2xl font-semibold mb-6">Get In Touch</h3>

    <form action="process-form.php" method="POST" class="space-y-4">
        <input type="hidden" name="lead_form" value="1">

        <div class="form-control">
            <label for="name" class="sr-only">Full Name</label>
            <input
                type="text"
                id="name"
                name="name"
                placeholder="Your Name*"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50 transition duration-300"
                value="<?php echo htmlspecialchars($name); ?>"
                required
                minlength="2"
                pattern="[a-zA-Z\s\p{L}.'\\-]*"
                title="Name can only contain letters, spaces, dots, hyphens and apostrophes">
            <?php if (!empty($nameErr)): ?>
                <p class="text-red-500 text-sm mt-1"><?php echo $nameErr; ?></p>
            <?php endif; ?>
        </div>

        <div class="form-control">
            <label for="email" class="sr-only">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Email Address*"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50 transition duration-300"
                value="<?php echo htmlspecialchars($email); ?>"
                required>
            <?php if (!empty($emailErr)): ?>
                <p class="text-red-500 text-sm mt-1"><?php echo $emailErr; ?></p>
            <?php endif; ?>
        </div>

        <div class="form-control">
            <label for="phone" class="sr-only">Phone Number</label>
            <input
                type="tel"
                id="phone"
                name="phone"
                placeholder="Phone Number*"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50 transition duration-300"
                value="<?php echo htmlspecialchars($phone); ?>"
                required
                minlength="10"
                maxlength="15"
                pattern="[0-9\+\-\s\(\)]{10,}"
                title="Please enter a valid phone number with at least 10 digits">
            <?php if (!empty($phoneErr)): ?>
                <p class="text-red-500 text-sm mt-1"><?php echo $phoneErr; ?></p>
            <?php endif; ?>
        </div>

        <button
            type="submit"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            SUBMIT
        </button>
    </form>
</div>