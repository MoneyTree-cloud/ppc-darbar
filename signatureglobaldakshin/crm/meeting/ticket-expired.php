<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Status</title>
    <style>
        /* Sets the background and centers the content */
        body {
            background-color: #f0f2f5; /* Light gray background */
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        /* The main dialog box styling */
        .dialog-box {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 450px;
            width: 100%;
        }

        /* Styling for the main title */
        .dialog-box h1 {
            color: #d9534f; /* A red color to indicate an expired status */
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 15px;
        }

        /* Styling for the descriptive text */
        .dialog-box p {
            color: #555555;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <div class="dialog-box">
        <h1>Event Over</h1>
        <p>Your pass has been expired.</p>
    </div>

</body>
</html>