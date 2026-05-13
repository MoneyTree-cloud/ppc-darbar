# Real Estate Chatbot - Manual Installation Guide

This document provides step-by-step instructions for manually installing the Real Estate Chatbot on your server.

## System Requirements

- PHP 7.4 or higher
- Web server (Apache, Nginx, etc.)
- MySQL or PostgreSQL database (optional - file-based storage available)
- OpenAI API key (optional - built-in fallback responses available)

## Installation Steps

### 1. Download and Extract Files

1. Download the latest release from the repository
2. Extract the files to your web server directory
3. Ensure the web server has read/write permissions for the entire directory

### 2. Configure the Application

#### Option A: File-based Storage (No Database Required)

1. Open `config/config.php` and set the following:
   ```php
   define('STORAGE_TYPE', 'file');
   ```

2. Create a `data` directory in the root folder if it doesn't exist:
   ```
   mkdir -p data/leads
   chmod 755 data
   chmod 755 data/leads
   ```

3. Create an empty leads.csv file:
   ```
   echo "id,name,phone,email,requirements,status,created_at" > data/leads.csv
   chmod 644 data/leads.csv
   ```

#### Option B: Database Storage

1. Create a new database for the chatbot
2. Open `config/config.php` and update the database configuration:
   ```php
   define('DB_HOST', 'localhost'); // Your database host
   define('DB_NAME', 'realestate_chatbot'); // Your database name
   define('DB_USER', 'root'); // Your database username
   define('DB_PASS', ''); // Your database password
   define('DB_TYPE', 'mysql'); // Use 'pgsql' for PostgreSQL
   define('STORAGE_TYPE', 'database'); // Use database storage
   ```

3. Import the database schema:
   - For MySQL: Import `setup/db.sql` into your database
   - For PostgreSQL: The schema will be created automatically on first run

### 3. Set Up Admin Account

1. Open `config/config.php` and update the admin settings:
   ```php
   define('ADMIN_USERNAME', 'admin'); // Your desired admin username
   define('ADMIN_EMAIL', 'your-email@example.com'); // Your admin email
   define('ADMIN_PASSWORD', password_hash('your-password', PASSWORD_DEFAULT)); // Your password
   ```

### 4. Configure OpenAI API (Optional)

1. Get your API key from [OpenAI](https://platform.openai.com/account/api-keys)
2. Open `config/config.php` and update:
   ```php
   define('OPENAI_API_KEY', 'your-openai-api-key'); // Your OpenAI API key
   ```
3. If you don't provide an API key, the system will use built-in fallback responses

### 5. Install Completion Marker

Create the installation completion marker:
```
echo "<?php // Installation completed on $(date)" > config/installed.php
```

### 6. Finalize Installation

1. Visit your website to confirm the chatbot is working
2. Access the admin dashboard at `/admin/` (default credentials: username `admin`, password `password`)
3. Change the default admin password immediately after logging in (feature coming soon)

## Embedding on External Websites

To add the chatbot to another website, add the following code before the closing `</body>` tag:

```html
<script src="https://your-chatbot-domain.com/assets/js/embed.js" 
        id="realestate-chatbot-embed" 
        data-website-id="default"
        data-color="#005b52"></script>
```

Customize the attributes:
- `data-website-id`: Unique identifier for the website (default: "default")
- `data-color`: Primary color for the chatbot UI (default: "#005b52")

## Troubleshooting

### File Permissions
Ensure the web server has write permissions for:
- `data/` directory and all subdirectories
- `config/installed.php` file

### Database Connection Issues
If using database storage and encountering connection issues:
1. Verify database credentials in `config/config.php`
2. Ensure the database server is running and accessible
3. As a fallback, switch to file-based storage by setting `STORAGE_TYPE` to `'file'`

### OpenAI API Issues
If experiencing issues with OpenAI API:
1. Verify your API key is correct and has sufficient credits
2. Check API status at [OpenAI Status](https://status.openai.com/)
3. The chatbot will automatically use fallback responses if the API is unavailable

## Security Notes

1. After installation, restrict access to sensitive files:
   ```
   chmod 600 config/config.php
   ```

2. Remove or protect the setup directory:
   ```
   rm -rf setup/
   ```

3. Use HTTPS for your website to ensure secure communication

## Support

For additional help or custom installation support, please contact us.