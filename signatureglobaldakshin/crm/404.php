<?php
// We include the session check to maintain the context of the logged-in user,
// but it's not strictly necessary for a 404 page if you want it to be public.
// include('php/check_login.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: rgba(0, 88, 79, 1);
            --accent-gold: #f8c200;
            --light-background: #f0f5f5;
            --dark-text: #222222;
            --light-text: #555555;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-background);
            color: var(--dark-text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            text-align: center;
        }
        .container {
            background-color: #fff;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            border-top: 5px solid var(--primary-green);
        }
        h1 {
            color: var(--primary-green);
            font-size: 6rem;
            margin: 0;
            line-height: 1;
        }
        h2 {
            font-size: 1.75rem;
            margin: 10px 0 15px;
            color: var(--dark-text);
        }
        p {
            color: var(--light-text);
            font-size: 1rem;
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: var(--primary-green);
            color: white;
            font-size: 1.1rem;
        }
        .btn-primary:hover {
            background-color: #004d43;
            box-shadow: 0 4px 10px rgba(0, 88, 79, 0.3);
            transform: translateY(-2px);
        }
        .other-links {
            margin-top: 30px;
        }
        .other-links a {
            color: var(--light-text);
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
        }
        .other-links a:hover {
            color: var(--accent-gold);
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h2>Page Not Found</h2>
        <p>Sorry, the page you are looking for does not exist or has been moved.</p>
        
        <a href="index.php" class="btn btn-primary">
            <ion-icon name="home-outline" style="vertical-align: middle; margin-right: 5px;"></ion-icon>
            Go to Homepage
        </a>

        <!--<div class="other-links">-->
        <!--    <a href="edit_kra_report.php">KRA Report</a> |-->
        <!--    <a href="all_leads.php">All Leads</a> |-->
        <!--    <a href="ip_captured.php">IP Logs</a>-->
        <!--</div>-->
    </div>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
