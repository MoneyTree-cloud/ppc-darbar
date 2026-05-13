# Real Estate Chatbot - Customization Guide

This document explains how to customize the appearance, behavior, and content of the Real Estate Chatbot to match your brand and requirements.

## Appearance Customization

### Theme Color

The primary color of the chatbot can be customized in two ways:

1. **Via Embed Code**: Add the `data-color` attribute to the embed script:
   ```html
   <script src="assets/js/embed.js" 
           id="realestate-chatbot-embed" 
           data-color="#005b52"></script>
   ```
   Use any valid hex color code.

2. **Via CSS**: Edit the `assets/css/chatbot.css` file to change various style elements:
   ```css
   :root {
     --chatbot-primary-color: #005b52;
     --chatbot-text-color: #333333;
     --chatbot-bg-color: #ffffff;
     /* Add more custom variables as needed */
   }
   ```

### Logo Customization

To change the chatbot logo:

1. Replace the default logo file at `assets/images/logo.png` with your own logo
   - Recommended size: 40px × 40px
   - Transparent background preferred

2. If you need to use a different file path or name, update the logo path in `assets/js/chatbot.js`:
   ```javascript
   // Find this line in createChatbotElements() function
   logoImg.src = 'assets/images/logo.png';
   ```

### Custom Fonts

To use custom fonts:

1. Add your preferred font in the `assets/css/chatbot.css` file:
   ```css
   @import url('https://fonts.googleapis.com/css2?family=Your+Font+Name&display=swap');
   
   .re-chatbot-container {
     font-family: 'Your Font Name', sans-serif;
   }
   ```

### Widget Position

By default, the chatbot appears in the bottom-right corner. To change this:

1. Add the `data-position` attribute to the embed script:
   ```html
   <script src="assets/js/embed.js" 
           id="realestate-chatbot-embed" 
           data-position="left"></script>
   ```
   Options: `"right"` (default) or `"left"`

## Behavior Customization

### Initial Message

Customize the first message the chatbot sends:

1. **Via Embed Code**: Add the `data-initial-message` attribute:
   ```html
   <script src="assets/js/embed.js" 
           id="realestate-chatbot-embed" 
           data-initial-message="Hello! How can I help you find your dream property today?"></script>
   ```

2. **Via Configuration**: Update the initial message in the system prompt in `config/config.php`

### Auto-Open Timing

By default, the chatbot opens automatically after 3 seconds. To change this:

1. Edit `assets/js/chatbot.js` and modify the timeout value:
   ```javascript
   // Find this section in the init() function
   setTimeout(() => {
     this.toggleChat(true);
   }, 3000); // Change 3000 to your desired time in milliseconds
   ```
   
   Set to `0` to disable auto-opening.

### Lead Capture Threshold

Control how many exchanges happen before showing the lead form:

1. Edit `config/config.php` and update the threshold:
   ```php
   define('LEAD_CAPTURE_THRESHOLD', 6); // Change to your preferred number
   ```

## Content Customization

### System Prompt (AI Instructions)

The most important customization is the system prompt, which controls how the AI responds:

1. Edit `config/config.php` and locate the `SYSTEM_PROMPT` definition
2. Modify the text to:
   - Update property information
   - Change tone and style
   - Add specific responses for common questions
   - Include your company details

```php
define('SYSTEM_PROMPT', 'You are a real estate assistant for [Your Company]. Keep your responses SHORT and HELPFUL. We have premium properties in our portfolio including [Property Names and Details].

Your main goals are:
1. Answer property questions briefly
2. Only after 5-6 exchanges, politely ask for user contact info

Our properties include:
1. [Property 1] - [Details]
2. [Property 2] - [Details]
3. [Property 3] - [Details]

Our Contact Information:
- Phone: [Your Phone]
- Email: [Your Email]

Our Office Locations:
1. [Office 1 Address]
2. [Office 2 Address]
');
```

### Response Suggestions

To modify the suggested responses that appear after chatbot messages:

1. Edit `api/chat.php` and locate the `generateSuggestions()` function
2. Modify the suggestions within this function:
   ```php
   function generateSuggestions($response, $userMessage) {
       // Add your custom suggestions here
       return [
           "Tell me more about [Property Name]",
           "What's the price range?",
           "Do you have properties in [Location]?",
           // Add more suggestions
       ];
   }
   ```

### Fallback Responses

If the OpenAI API is unavailable, the chatbot uses fallback responses:

1. Edit `api/chat.php` and find the `getDefaultResponse()` function
2. Customize the fallback responses:
   ```php
   function getDefaultResponse($messages) {
       // Get the last user message
       $lastMessage = end($messages);
       $userMessage = $lastMessage['content'] ?? '';
       
       // Simple pattern matching for common user queries
       if (stripos($userMessage, 'property') !== false) {
           return "We have several premium properties in our portfolio, including [Your Properties]. Would you like more details?";
       }
       // Add more custom fallback responses
   }
   ```

## Advanced Customization

### Adding New Features

To add new features to the chatbot:

1. **New Question Types**: Update the system prompt to include instructions for handling new types of questions
2. **Custom Actions**: Edit `assets/js/chatbot.js` to add new interactive elements or functionality
3. **Integration with APIs**: Modify `api/chat.php` to integrate with other property databases or services

### Multilingual Support

To add multilingual support:

1. Create language files in a new `assets/lang/` directory:
   ```php
   // en.php (English)
   return [
       'welcome_message' => 'Welcome! How can I help you?',
       'lead_form_title' => 'Contact Information',
       // Add more translations
   ];
   
   // es.php (Spanish)
   return [
       'welcome_message' => '¡Bienvenido! ¿Cómo puedo ayudarte?',
       'lead_form_title' => 'Información de contacto',
       // Add more translations
   ];
   ```

2. Detect the user's language preference and load the appropriate translations

### Custom Analytics

To add custom analytics:

1. Create a new file `api/analytics.php` to track user interactions
2. Add code in `assets/js/chatbot.js` to send analytics data
3. Create a new dashboard page to visualize the analytics data

## Testing Your Customizations

After making changes:

1. Clear your browser cache
2. Restart the PHP server
3. Test the chatbot in different browsers and devices
4. Verify lead capture still works correctly

---

For further customization options or custom development, please contact us.