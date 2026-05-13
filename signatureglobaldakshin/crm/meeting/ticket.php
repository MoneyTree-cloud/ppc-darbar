<?php
include '../php/config.php'; // connect to DB
$ticket_id = $_GET['ticket_id'] ?? '';
// $ticket_id = '97802819';

if (!$ticket_id) {
    die("Ticket ID missing!");
}

$stmt = $conn->prepare("SELECT * FROM event WHERE ticket_id = ?");
$stmt->bind_param("s", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid Ticket ID!");
}

$data = $result->fetch_assoc();

/*  
   ============================
   OPTION 1: Redirect to expired page
   (Default behavior – Active)
   ============================
*/
header("Location: ticket-expired.php");
// exit;

/*  
   ============================
   OPTION 2: Show ticket details
   (Uncomment below block when needed)
   ============================

// echo "<h2>Ticket Details</h2>";
// echo "Ticket ID: " . htmlspecialchars($data['ticket_id']) . "<br>";
// echo "Name: " . htmlspecialchars($data['name']) . "<br>";
// echo "Event: " . htmlspecialchars($data['event_name']) . "<br>";
// echo "Date: " . htmlspecialchars($data['event_date']) . "<br>";
// echo "Venue: " . htmlspecialchars($data['venue']) . "<br>";
// exit;

*/
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PROPTREE Mela Event Pass</title>
  <link rel="stylesheet" href="style.css?v=<?=filemtime('style.css');?>">

  <!-- JsBarcode library is still needed for the core functionality -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

     <style>
        body{
          flex-direction: column;
        }

        /* Styles for the download button */
        .download-container {
            text-align: center;
            padding: 20px;
        }
        #downloadBtn {
            background-color: #138808;
            color: #ffffff;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #downloadBtn:hover {
            background-color: #117707;
        }
    </style>

</head>
<body>
<div class="ticket">
  <div class="curtain-container">
    <!--<img src="assets/img/side curtain-nobg.png" class="curtain">-->
  </div>

  <div class="hotel-img">
    <!-- <img src="assets/img/radisson.png" alt="Radisson Hotel"> -->
  </div>

  <div class="main-content">
    <div class="header">
      <img src="assets/img/logo.png" class="logo">
    </div>

    <div class="event-details">
      <div class="event-title"><img src="assets/img/proptree.png" alt="Proptree"> Mela <span>2.</span> <img src="assets/img/ashok-chakra.png" class="ashok-chakra" alt="Ashok Chakra"></div>
      <div class="venue">
        <img src="assets/img/Radisson_Blu_logo.png" class="radisson-logo">
        <p>SECTOR 18, NOIDA</p>
      </div>
    </div>

    <div class="date-section">
      on <span>15<sup>th</sup></span> AUGUST
      <p>From 9 AM onwards</p>
    </div>
    
    <div class="footer">
        <div class="heart">❤</div>
      <div class="barcode-section">
        <div class="barcode">
          <svg id="barcode-svg"></svg>
          <p id="error-message"></p>
        </div>
        <?php echo htmlspecialchars($data['ticket_id']); ?>
      </div>
      <div class="heart">❤</div>
      <div class="contact-info">
        <?php echo htmlspecialchars($data['invited_by']) . ' +91 ' . htmlspecialchars($data['inviter_phone']); ?>
      </div>
    </div>
  </div>

  <div class="stub">
    <div class="invitation-text">
      YOU ARE INVITED TO THE<br>PROPTREE MELA 2.0
    </div>

    <div class="guest-name">
      <?php echo htmlspecialchars($data['name']); ?>
    </div>
    <div class="meeting">
      At <span><?php echo htmlspecialchars($data['timing']); ?></span>
    </div>

    <div class="save-the-date">
      <div class="text">SAVE THE DATE</div>
      <div class="date-stamp">15/08/2025</div>
      <img src="assets/img/buildings.png" class="skyline">
      <img src="assets/img/girl-img.jpg" alt="freedom girl" class="girl-img">
    </div>
  </div>
</div>


<div class="download-container">
    <button id="downloadBtn">Download Ticket (PNG)</button>
</div>

<script>
        // --- Element References ---
        const barcodeSvg = document.getElementById('barcode-svg');
        const errorMessage = document.getElementById('error-message');

        // --- Core Function to Generate Barcode ---
        const generateBarcode = () => {
            const inputText = '<?php echo htmlspecialchars($data['ticket_id']); ?>';
            errorMessage.textContent = ''; // Clear previous errors

            if (!inputText.trim()) {
                errorMessage.textContent = 'Please enter some text to generate a barcode.';
                barcodeSvg.innerHTML = ''; // Clear the SVG
                return;
            }

            try {
                // Use JsBarcode to generate the barcode
                JsBarcode(barcodeSvg, inputText, {
                    format: "CODE128",
                    lineColor: "#000",
                    width: 8,
                    height: 150,
                    displayValue: true,
                    background: 'transparent',
                    fontOptions: "bold",
                    font: "Inter"
                });
            } catch (e) {
                // Handle errors from the JsBarcode library
                console.error(e);
                errorMessage.textContent = 'Could not generate barcode. Please check your input.';
                barcodeSvg.innerHTML = ''; // Clear the SVG on error
            }
        };
        generateBarcode();


        // --- Download Ticket Functionality ---
    document.getElementById('downloadBtn').addEventListener('click', function() {
        const ticketElement = document.querySelector(".ticket");
        const downloadButton = this;

        // Temporarily hide the button to avoid it appearing in the screenshot
        downloadButton.style.display = 'none';

        html2canvas(ticketElement, {
            // Options to improve image quality
            scale: 2, 
            useCORS: true 
        }).then(canvas => {
            // Create a link element
            const link = document.createElement('a');
            
            // Set the download filename using the ticket ID
            link.download = 'PROPTREE-Mela-Pass-<?php echo htmlspecialchars($data['ticket_id']); ?>.png';
            
            // Set the href to the generated image data
            link.href = canvas.toDataURL("image/png");
            
            // Trigger the download
            link.click();

            // Show the button again after the download is initiated
            downloadButton.style.display = 'block';
        }).catch(err => {
            console.error("Oops, something went wrong!", err);
            // Ensure the button is shown again even if there's an error
            downloadButton.style.display = 'block';
        });
    });
    </script>
</body>
</html>
