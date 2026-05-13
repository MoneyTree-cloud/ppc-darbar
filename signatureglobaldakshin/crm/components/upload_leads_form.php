<style>
    /* Popup Overlay Styles */
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: none; /* Hidden by default */
        justify-content: center;
        align-items: center;
        z-index: 1000;
        backdrop-filter: blur(5px);
    }

    /* Styles for the main popup content box */
    .upload-container {
        background-color: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        text-align: center;
        max-width: 500px;
        width: 90%;
        border-top: 5px solid #006400; /* Green */
        position: relative; /* Needed for the close button */
        transform: scale(0.95);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }
    
    /* Active state for popup */
    .popup-overlay.active {
        display: flex;
    }
    .popup-overlay.active .upload-container {
        transform: scale(1);
        opacity: 1;
    }

    

    /* Your existing Green & Golden Theme Styles */
    :root {
        --primary-green: rgba(0, 88, 79, 1); --accent-gold: #D4AF37; --light-background: #F0FDF4;
        --dark-text: #222222; --light-text: #555555; --success-bg: #D1F2EB;
        --success-text: #0E6655; --error-bg: #FADBD8; --error-text: #78281F;
    }
    .upload-container h2 { margin-top: 0; color: var(--dark-text); }
    .upload-container p { color: var(--light-text); line-height: 1.5; }
    .file-input { border: 2px dashed var(--accent-gold); border-radius: 8px; padding: 30px; margin-top: 20px; cursor: pointer; background-color: #FFFDF5; transition: background-color 0.3s; }
    .file-input:hover { background-color: #FEF9E7; }
    .file-input input[type="file"] { display: none; }
    .file-input label { color: var(--primary-green); font-weight: bold; }
    .submit-btn { background-color: var(--primary-green); color: white; padding: 12px 25px; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; margin-top: 20px; transition: background-color 0.3s; font-weight: bold; }
    .submit-btn:hover { background-color: #004d00; }
    /*.message { padding: 15px; margin-bottom: 20px; border-radius: 8px; font-weight: bold; text-align: left; }*/
    .success { background-color: var(--success-bg); color: var(--success-text); }
    .error { background-color: var(--error-bg); color: var(--error-text); }
</style>

<!-- This is the main popup container -->
<div class="popup-overlay" id="uploadPopup">
    <div class="upload-container">
        <button class="popup-close" onclick="closeUploadPopup()">&times;</button>
        
        <h2>Upload Bulk Leads</h2>
        <p>Please select an Excel file (.xlsx or .xls). Ensure the columns are in the order: Name, Mobile, Email, Domain, Remark.</p>

        <?php if (isset($_GET['message'])): ?>
            <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <form action="php/upload_excel.php" method="post" enctype="multipart/form-data">
            <div class="file-input">
                <input type="file" name="excel_file" id="excel_file" accept=".xlsx, .xls" required>
                <label for="excel_file" id="file-label">Click here to choose a file</label>
            </div>
            <button type="submit" name="upload" class="submit-btn">Upload Leads</button>
        </form>
    </div>
</div>

<script>
    const uploadPopup = document.getElementById('uploadPopup');

    function openUploadPopup() {
        uploadPopup.classList.add('active');
    }

    function closeUploadPopup() {
        uploadPopup.classList.remove('active');
    }
    
    // Optional: Close the popup if the user clicks on the overlay background
    uploadPopup.addEventListener('click', function(event) {
        if (event.target === uploadPopup) {
            closeUploadPopup();
        }
    });

    // Update file label with the name of the chosen file
    document.getElementById('excel_file').onchange = function () {
        document.getElementById('file-label').textContent = this.files[0].name;
    };
</script>
