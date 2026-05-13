# Real Estate Chatbot - Troubleshooting Guide

This document helps resolve common issues you might encounter with the Real Estate Chatbot.

## Common Issues and Solutions

### 1. Installation Issues

#### Database Connection Errors

**Problem**: Error connecting to database during installation or operation.

**Solutions**:
- Verify database credentials in `config/config.php`
- Ensure database server is running
- Check if the database and user exist with proper permissions
- **Recommended**: Use the file-based storage option by setting `STORAGE_TYPE` to `'file'` in `config/config.php`

#### 500 Server Error During Installation

**Problem**: Server returns a 500 error when running the installation script.

**Solutions**:
- Check PHP error logs for specific errors
- Ensure PHP version is 7.4 or higher
- Verify file permissions (see File Permission Issues below)
- Use manual installation following the steps in INSTALLATION.md

### 2. OpenAI API Issues

#### API Key Not Working

**Problem**: Chatbot returns an error about the OpenAI API key.

**Solutions**:
- Verify the API key is correct in `config/config.php`
- Check if your OpenAI account has sufficient credits
- The system includes fallback responses that work without an API key

#### Slow Responses or Timeouts

**Problem**: Chatbot takes too long to respond or times out.

**Solutions**:
- OpenAI API might be experiencing high traffic
- Increase the server timeout limit in your web server configuration
- The system will automatically switch to fallback responses after a timeout

### 3. File Permission Issues

#### Cannot Write to Data Directory

**Problem**: Errors about writing to files in the data directory.

**Solutions**:
- Ensure the web server has write permissions:
  ```
  chown -R www-data:www-data data/
  chmod -R 755 data/
  ```
  (Replace www-data with your web server user)

#### Cannot Modify Configuration

**Problem**: Unable to save configuration changes.

**Solutions**:
- Check permissions on `config/` directory:
  ```
  chmod 755 config/
  chmod 644 config/*.php
  ```

### 4. Chatbot UI Issues

#### Chatbot Not Appearing

**Problem**: The chatbot widget doesn't appear on the page.

**Solutions**:
- Check browser console for JavaScript errors
- Verify the embed script is included correctly before the closing `</body>` tag
- Make sure the path to `embed.js` is correct

#### Styling Problems

**Problem**: Chatbot doesn't match your website's style.

**Solutions**:
- Update the `data-color` attribute in the embed script
- Customize CSS by modifying `assets/css/chatbot.css`

### 5. Lead Capture Issues

#### Lead Form Not Appearing

**Problem**: The lead form doesn't show up after conversation.

**Solutions**:
- The form appears after LEAD_CAPTURE_THRESHOLD messages (default: 6)
- Check `config/config.php` and adjust the threshold if needed

#### Cannot Save Leads

**Problem**: Leads are not being saved.

**Solutions**:
- Check if `data/leads` directory exists and is writable
- Verify the `data/leads.csv` file exists and is writable
- Check for PHP errors in the server logs

### 6. Admin Dashboard Issues

#### Cannot Log In

**Problem**: Unable to log in to the admin dashboard.

**Solutions**:
- Verify admin credentials in `config/config.php`
- Reset password by updating the ADMIN_PASSWORD constant
- Check for cookie or session issues in your browser

#### No Leads Showing in Dashboard

**Problem**: Admin dashboard shows no leads.

**Solutions**:
- Verify leads exist in `data/leads.csv` or database
- Check file permissions on the data directory
- Ensure the admin account has proper permissions

## Advanced Troubleshooting

### Enabling Debug Mode

To get more detailed error information:

1. Open `config/config.php`
2. Find or add these lines:
   ```php
   // Error reporting in development, comment out in production
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   ```

### PHP Error Logs

Check your PHP error logs for detailed error messages:
- Apache: `/var/log/apache2/error.log` (Linux)
- NGINX: `/var/log/nginx/error.log` (Linux)
- XAMPP: `xampp/php/logs/php_error_log` (Windows)

### Testing API Connection

To test the OpenAI API connection directly:

```php
<?php
$apiKey = 'your-openai-api-key';
$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'model' => 'gpt-3.5-turbo',
    'messages' => [['role' => 'user', 'content' => 'Hello']]
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
$response = curl_exec($ch);
curl_close($ch);
echo $response;
?>
```

## Still Having Issues?

If you've tried these solutions and are still experiencing problems:

1. Check for updates to the chatbot system
2. Review the complete documentation
3. Contact support for further assistance

---

For additional help or to report bugs, please contact us.