<?php
session_start();
date_default_timezone_set("Asia/Kolkata");

// // Check if the submission was valid
if (!isset($_SESSION['valid_eod_submission'])) {
    // If not coming from a valid submission, redirect elsewhere
    header("Location: eod.php"); // Or your form page
    exit;
}

// Clear the session flag to prevent direct access on refresh
unset($_SESSION['valid_eod_submission']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you | EOD Submission</title>
    <link rel="stylesheet" href="style.css">
    <?php include('../resource.php'); ?>
</head>
<style>
    *{
padding: 0;
margin: 0;
box-sizing: border-box;
}
:root{
--primary-color: #8c00ff;
--secondary-color: goldenrod;
--tertiary-color: #00ffd5;
--bg-color: #fff;
--text-color: #000;
}
body{
display: flex;
align-items: center;
justify-content: flex-start;
flex-direction: column;
height: 100vh;
background-color: var(--text-color);
background-position: center;
background-size: cover;
background-repeat: no-repeat;
/* gap: 60px; */
font-family: Arial, sans-serif;
padding: 20px;
}

.logo{
    width: 100%;
    max-width: 700px;
    /* border-radius: 50%; */
    margin-bottom: 20px;
    /* box-shadow: 0 4px 20px rgba(0, 0, 0, 0.538); */
}

.main{
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    width: 100%;
    max-width: 700px;
    gap: 20px;
    background-color: #1b281a6d;
    padding: 50px 20px;
    border: 2px solid var(--secondary-color);
    border-radius: 20PX;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.538);
}

h1{
    text-align: center;
    color: var(--secondary-color);
    font-size: 2rem;
}


.btn {
  position: relative;
  padding: 5px 10px;
  background: #007d23;
  border: 2px solid #007d23;
  text-decoration: none;
  color: #fff;
  border: 2px solid #ffffffff;
  border-radius: 6px;
  font-size: 14px;
  cursor: pointer;
}

.btn:hover{
  color: #007d23;
  background: linear-gradient(90deg, #d4af37, #ffd700, #f5c542, #d4af37);
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  border: 2px solid #d4af37;
}

/* From Uiverse.io by Shoh2008 */ 
.checkbox-wrapper-12 {
  position: relative;
  scale: 4;
}

.checkbox-wrapper-12 > svg {
  position: absolute;
  top: -130%;
  left: -170%;
  width: 110px;
  pointer-events: none;
}

.checkbox-wrapper-12 * {
  box-sizing: border-box;
}

.checkbox-wrapper-12 input[type="checkbox"] {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  -webkit-tap-highlight-color: transparent;
  cursor: pointer;
  margin: 0;
}

.checkbox-wrapper-12 input[type="checkbox"]:focus {
  outline: 0;
}

.checkbox-wrapper-12 .cbx {
  width: 24px;
  height: 24px;
  top: calc(100px - 12px);
  left: calc(100px - 12px);
}

.checkbox-wrapper-12 .cbx input {
  position: absolute;
  top: 0;
  left: 0;
  width: 24px;
  height: 24px;
  border: 2px solid #bfbfc0;
  border-radius: 50%;
}

.checkbox-wrapper-12 .cbx label {
  width: 24px;
  height: 24px;
  background: none;
  border-radius: 50%;
  position: absolute;
  top: 0;
  left: 0;
  transform: trasnlate3d(0, 0, 0);
  pointer-events: none;
}

.checkbox-wrapper-12 .cbx svg {
  position: absolute;
  top: 5px;
  left: 4px;
  z-index: 1;
  pointer-events: none;
}

.checkbox-wrapper-12 .cbx svg path {
  stroke: #fff;
  stroke-width: 3;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke-dasharray: 19;
  stroke-dashoffset: 19;
  transition: stroke-dashoffset 0.3s ease;
  transition-delay: 0.2s;
}

.checkbox-wrapper-12 .cbx input:checked + label {
  animation: splash-12 0.6s ease forwards;
}

.checkbox-wrapper-12 .cbx input:checked + label + svg path {
  stroke-dashoffset: 0;
}

@-moz-keyframes splash-12 {
  40% {
    background: #007d23;
    box-shadow: 0 -18px 0 -8px #007d23, 16px -8px 0 -8px #007d23, 16px 8px 0 -8px #007d23, 0 18px 0 -8px #007d23, -16px 8px 0 -8px #007d23, -16px -8px 0 -8px #007d23;
  }

  100% {
    background: #007d23;
    box-shadow: 0 -36px 0 -10px transparent, 32px -16px 0 -10px transparent, 32px 16px 0 -10px transparent, 0 36px 0 -10px transparent, -32px 16px 0 -10px transparent, -32px -16px 0 -10px transparent;
  }
}

@-webkit-keyframes splash-12 {
  40% {
    background: #007d23;
    box-shadow: 0 -18px 0 -8px #007d23, 16px -8px 0 -8px #007d23, 16px 8px 0 -8px #007d23, 0 18px 0 -8px #007d23, -16px 8px 0 -8px #007d23, -16px -8px 0 -8px #007d23;
  }

  100% {
    background: #007d23;
    box-shadow: 0 -36px 0 -10px transparent, 32px -16px 0 -10px transparent, 32px 16px 0 -10px transparent, 0 36px 0 -10px transparent, -32px 16px 0 -10px transparent, -32px -16px 0 -10px transparent;
  }
}

@-o-keyframes splash-12 {
  40% {
    background: #007d23;
    box-shadow: 0 -18px 0 -8px #007d23, 16px -8px 0 -8px #007d23, 16px 8px 0 -8px #007d23, 0 18px 0 -8px #007d23, -16px 8px 0 -8px #007d23, -16px -8px 0 -8px #007d23;
  }

  100% {
    background: #007d23;
    box-shadow: 0 -36px 0 -10px transparent, 32px -16px 0 -10px transparent, 32px 16px 0 -10px transparent, 0 36px 0 -10px transparent, -32px 16px 0 -10px transparent, -32px -16px 0 -10px transparent;
  }
}

@keyframes splash-12 {
  40% {
    background: #007d23;
    box-shadow: 0 -18px 0 -8px #007d23, 16px -8px 0 -8px #007d23, 16px 8px 0 -8px #007d23, 0 18px 0 -8px #007d23, -16px 8px 0 -8px #007d23, -16px -8px 0 -8px #007d23;
  }

  100% {
    background: #007d23;
    box-shadow: 0 -36px 0 -10px transparent, 32px -16px 0 -10px transparent, 32px 16px 0 -10px transparent, 0 36px 0 -10px transparent, -32px 16px 0 -10px transparent, -32px -16px 0 -10px transparent;
  }
}
</style>
<body>
    
     <img src="../assets/imgs/logo.png" class="logo" alt="">
    <div class="main">
        <div class="checkbox-wrapper-12">
            <div class="cbx">
                <input type="checkbox" id="cbx-12"> <!-- Removed the checked attribute -->
                <label for="cbx-12"></label>
                <svg fill="none" viewBox="0 0 15 14" height="14" width="15">
                    <path d="M2 8.36364L6.23077 12L13 2"></path>
                </svg>
            </div>
    
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <filter id="goo-12">
                        <feGaussianBlur result="blur" stdDeviation="4" in="SourceGraphic"></feGaussianBlur>
                        <feColorMatrix result="goo-12" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 22 -7" mode="matrix"
                            in="blur"></feColorMatrix>
                        <feBlend in2="goo-12" in="SourceGraphic"></feBlend>
                    </filter>
                </defs>
            </svg>
        </div>
        <h1 style="margin-bottom: 0; margin-top: 50px;">Thank You <?php echo $_SESSION['employee_full']; ?> for submitting EOD report of <?php echo date('d-m-Y'); ?></h1>
        <a href="<?php echo $_SESSION['previous_page']; ?>" class="btn" style="font-size: 20px;">Go Back</a>
    </div>

    <div id="notificationContainer"></div>

    <script>
        // Wait for the page to fully load
        window.addEventListener('load', function() {
            // Set a timeout for 2 seconds (2000 milliseconds)
            setTimeout(function() {
                // Get the checkbox element
                var checkbox = document.getElementById('cbx-12');
                // Check the checkbox
                checkbox.checked = true;
                
                // Trigger the animation by dispatching a change event
                var event = new Event('change');
                checkbox.dispatchEvent(event);
            }, 1000);
        });
    </script>

    <script src="script.js?v=<=filemtime('script.js');?>"></script>
</body>
</html>