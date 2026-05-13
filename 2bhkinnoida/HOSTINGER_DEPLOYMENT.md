# Deploying Real Estate Chatbot on Hostinger Shared Hosting

This guide provides detailed instructions for deploying the Real Estate Chatbot specifically on Hostinger shared hosting.

## Prerequisites

- A Hostinger shared hosting account
- A registered domain name (either through Hostinger or another registrar)
- Access to Hostinger's hPanel
- FTP client (e.g., FileZilla) or hPanel File Manager
- Basic knowledge of web hosting

## Step 1: Prepare Your Domain

1. Log in to your Hostinger account and navigate to the hPanel
2. If you purchased your domain through Hostinger, it should already be configured
3. If you're using a domain from another registrar, you'll need to:
   - Update your domain's nameservers to point to Hostinger's nameservers
   - Or set up an A record pointing to your Hostinger hosting IP address

## Step 2: Access Your Hosting Environment

### Using File Manager

1. In hPanel, navigate to "Files" → "File Manager"
2. You'll be directed to the web file manager interface

### Using FTP (Alternative)

1. In hPanel, go to "Files" → "FTP Accounts"
2. Create an FTP account or use your main account credentials
3. Connect to your server using an FTP client like FileZilla with these details:
   - Host: Your FTP hostname (e.g., ftp.yourdomain.com)
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21 (default FTP port)

## Step 3: Upload Chatbot Files

### Option 1: Using File Manager

1. Navigate to the `public_html` directory (or the subdirectory where you want to install the chatbot)
2. Click "Upload" and select all the chatbot files from your local machine
3. Wait for the upload to complete

### Option 2: Using FTP

1. Connect to your FTP server
2. Navigate to the `public_html` directory (or your desired installation directory)
3. Drag and drop all chatbot files from your local machine to the server
4. Wait for the transfer to complete

## Step 4: Set Up Database (If Using Database Storage)

1. In hPanel, navigate to "Databases" → "MySQL Databases"
2. Create a new database:
   - Enter a database name
   - Create or select a database user
   - Assign a strong password
   - Give the user all privileges on the database

3. Note your database details:
   - Database Name
   - Database Username
   - Database Password
   - Database Host (usually "localhost")

## Step 5: Configure the Chatbot

1. Navigate to the chatbot files in File Manager or via FTP
2. Locate and edit `config/config.php`:
   
   ### If Using Database Storage
   ```php
   // Database Configuration
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'your_database_name'); // From Step 4
   define('DB_USER', 'your_database_username'); // From Step 4
   define('DB_PASS', 'your_database_password'); // From Step 4
   define('DB_TYPE', 'mysql'); // Hostinger uses MySQL
   define('STORAGE_TYPE', 'database');
   ```

   ### If Using File-Based Storage
   ```php
   // Storage Configuration
   define('STORAGE_TYPE', 'file');
   define('DATA_DIR', BASE_PATH . '/data');
   ```

3. Update the APP_URL setting:
   ```php
   define('APP_URL', getenv('APP_URL') ?: 'https://yourdomain.com');
   ```

4. Set your OpenAI API key (if using):
   ```php
   define('OPENAI_API_KEY', 'your_openai_api_key');
   ```

## Step 6: Set Proper File Permissions

Hostinger uses the Linux operating system, so proper file permissions are essential:

1. For directories:
   ```
   chmod 755 data/
   chmod 755 data/leads/
   ```

2. For files:
   ```
   chmod 644 data/leads.csv
   chmod 644 config/config.php
   ```

To set these permissions in File Manager:
1. Select the file or folder
2. Click "Permissions" or right-click and select "Change Permissions"
3. Set the appropriate permission values

## Step 7: Run the Installation

1. Open your web browser and navigate to:
   ```
   https://yourdomain.com/setup/install.php
   ```

2. Follow the installation wizard:
   - Welcome screen: Click "Start Installation"
   - Requirements check: Ensure all requirements are met
   - Database setup: Enter the database details from Step 4 (or skip if using file storage)
   - Admin account: Create your admin credentials
   - Finish: Installation complete

## Step 8: Secure Your Installation

1. Delete or restrict access to the installation directory:
   ```
   rm -rf setup/
   ```
   
   Or create a `.htaccess` file in the setup directory with:
   ```
   Deny from all
   ```

2. Ensure sensitive files are protected:
   - Make sure `config/config.php` has permissions set to 644
   - Verify data directory permissions are set correctly

## Step 9: Set Up PHP Configuration (Optional)

For optimal performance, you may want to adjust PHP settings in Hostinger:

1. In hPanel, go to "Advanced" → "PHP Configuration"
2. Recommended settings:
   - memory_limit: 128M or higher
   - upload_max_filesize: 10M
   - post_max_size: 10M
   - max_execution_time: 60 or higher

## Step 10: Configure SSL (HTTPS)

Hostinger offers free SSL certificates with most hosting plans:

1. In hPanel, navigate to "SSL/TLS" → "SSL Status"
2. Click "Setup" next to your domain
3. Select "Let's Encrypt SSL"
4. Click "Install" and wait for the certificate to be installed

## Step 11: Test the Chatbot

1. Visit your website to ensure the chatbot loads properly
2. Test sending messages to verify the chatbot responds
3. Test the lead capture form
4. Access the admin panel at `https://yourdomain.com/admin/` to verify you can see captured leads

## Step 12: Embedding on Other Websites

If you want to embed the chatbot on other websites, add this script before the closing `</body>` tag:

```html
<script src="https://yourdomain.com/assets/js/embed.js" 
        id="realestate-chatbot-embed" 
        data-website-id="default"
        data-color="#005b52"></script>
```

Replace `yourdomain.com` with your actual domain.

## Troubleshooting Hostinger-Specific Issues

### 500 Internal Server Error

If you encounter a 500 error:
1. Check the error logs in hPanel under "Logs" → "Error Logs"
2. Common causes include:
   - Incorrect file permissions
   - PHP version incompatibility (Chatbot requires PHP 7.4+)
   - .htaccess syntax errors

### Database Connection Issues

If you have trouble connecting to the database:
1. Verify your database credentials in `config/config.php`
2. Ensure the database user has proper permissions
3. Try the file-based storage option by setting `STORAGE_TYPE` to `'file'`

### PHP Version

Make sure you're using PHP 7.4 or higher:
1. In hPanel, go to "Advanced" → "PHP Configuration"
2. Select PHP 7.4 or higher from the dropdown menu
3. Click "Save"

### Memory Limitations

If you encounter memory errors:
1. In hPanel, go to "Advanced" → "PHP Configuration"
2. Increase the "memory_limit" value
3. Click "Save"

## Optimizing for Hostinger

### Caching

Hostinger offers LiteSpeed Cache, which can improve performance:
1. In hPanel, navigate to "Advanced" → "LiteSpeed Cache"
2. Enable caching for static assets

### CDN Integration

For faster loading times:
1. In hPanel, go to "Advanced" → "CDN"
2. Enable Hostinger CDN
3. This will serve static assets like CSS and JavaScript files faster

---

For further assistance with Hostinger-specific issues, contact Hostinger support or refer to their knowledge base.