<script><?php
date_default_timezone_set('Asia/Kolkata'); // Indian time

$today = new DateTime();
$today->setTime(0, 0, 0); // Reset time

$eventDate = new DateTime('2025-08-15');
$eventDate->setTime(0, 0, 0); // Reset time

$diff = $today->diff($eventDate);
$diffDays = (int)$diff->format('%r%a'); // Relative difference (can be negative)

if ($diffDays > 1) {
    $days_remain = "$diffDays Days to go";
} elseif ($diffDays === 1) {
    $days_remain = "Tomorrow!";
} elseif ($diffDays === 0) {
    $days_remain = "Today!";
} else {
    $days_remain = "Event Over";
}
?>
</script>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>PropTree Mela 2.0 - Countdown!</title>
    <script type='module' src='https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js'></script>
    <script nomodule src='https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js'></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Poppins', Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 20px 10px;">
        <tr>
            <td align="center">
                <table width="100%" style="max-width: 480px; background: linear-gradient(to bottom, #FF9933 33.3%, #FFFFFF 33.3%, #FFFFFF 66.6%, #138808 66.6%); color: #2c3e50; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.2); border: 1px solid #ddd;">
                    
                    <!-- Header -->
                    <!-- <tr>
                        <td align="center" style="padding: 24px; background-color: #FF9933;">
                            <img src="../assets/img/proptree.png" alt="PropTree Logo" style="width: 180px; height: auto; filter: brightness(0.9);">
                            <h1 style="margin: 10px 0 0; font-size: 28px; letter-spacing: 1px; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Mela 2.0</h1>
                        </td>
                    </tr> -->

                    <!-- Countdown Timer -->
                    <tr>
                        <td align="center" style="padding: 20px; background-color: #FF9933;">
                             <h2 style="margin: 0; font-size: 36px; color: #000080; font-weight: 700;" id="countdown"><?php echo  $days_remain; ?></h2>
                             <p style="margin: 5px 0 0; font-size: 26px; color: #000080;">For 
                                <!-- <img src="../assets/img/proptree.png" alt="PropTree Logo" style="width: 180px; height: auto; filter: brightness(0.9);"> -->
                                PropTree Mela 2.0!</p>
                        </td>
                    </tr>

                    <!-- Date & Venue Info -->
                    <tr>
                        <td style="padding: 20px; background-color: #f9f9f9; color: #333;">
                            <h2 style="margin-top: 0; text-align: center; font-size: 20px; color: #000080;"><ion-icon name="calendar"></ion-icon> Celebrate with Us!</h2>
                            <p style="text-align: center; font-size: 18px; margin: 5px 0;"><strong>15th August 2025</strong></p>
                            <p style="text-align: center; font-size: 16px; margin: 0;">At <strong>10:00 AM</strong></p>
                            <hr style="margin: 20px 0; border: none; border-top: 1px solid #ccc;">
                            <p style="text-align: center; font-size: 16px; color: #000080;"><strong>Venue:</strong> 
                                <!-- <img style="width: 120px; transform: translateY(8px);" src="../assets/img/Radisson_Blu_logo.png" alt="Radisson Blu Logo">  -->
                                Radisson Blu, Sector 18, Noida</p>
                        </td>
                    </tr>

                    <!-- Name and Contact -->
                    <tr>
                        <td style="padding: 20px; background-color: #138808; color: white;">
                            <h3 style="margin: 0; font-size: 18px; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px;"><ion-icon name="person-outline" style="font-size: 20px;"></ion-icon> Invited By: Akash Sahu</h3>
                            <a href="tel:+919412234688" style="margin: 10px 0 0; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px; color: white; text-decoration: none;"><ion-icon name="call-outline" style="font-size: 20px;"></ion-icon> +91 9412234688</a>
                        </td>
                    </tr>

                    <!-- Call to Action -->
                    <tr>
                        <td align="center" style="padding: 20px; background-color: #138808;">
                            <a href="#" style="background-color: #000080; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">Add to Calendar</a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #2c3e50; color: #aaa; font-size: 12px; padding: 15px;">
                            © 2024 <a href="https://moneytreerealty.com/" style="color: white; text-decoration: none;">MoneyTree Realty Services Ltd</a>. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <!-- <script>
        // Calculate days remaining
        const eventDate = new Date('2025-08-15');
        const today = new Date();
        // Reset time part to compare dates only
        today.setHours(0, 0, 0, 0);
        eventDate.setHours(0, 0, 0, 0);

        const diffTime = eventDate - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        const countdownEl = document.getElementById('countdown');
        if (diffDays > 1) {
            countdownEl.textContent = `${diffDays} Days to go`;
        } else if (diffDays === 1) {
            countdownEl.textContent = 'Tomorrow!';
        } else if (diffDays === 0) {
            countdownEl.textContent = 'Today!';
        } else {
            countdownEl.textContent = 'Event Over';
        }
    </script> -->
</body>
</html>
