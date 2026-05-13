# Real Estate Chatbot

A dynamic, AI-powered real estate chatbot that provides intelligent property insights and lead generation capabilities through an interactive conversational interface.

## Features

- **Real-time Property Data**: Integrates with live property API to provide up-to-date information
- **Lead Generation**: Captures visitor information after meaningful engagement
- **Embeddable Widget**: Easy integration on any website with a simple script
- **Responsive Design**: Mobile-friendly interface with clean aesthetics
- **Professional Tone**: Helpful and informative conversation style
- **File-based Data Storage**: No database required, but supports MySQL if needed
- **Admin Dashboard**: Manage leads and chat history

## Technology Stack

- PHP backend with API integration
- JavaScript frontend
- OpenAI conversational AI
- Responsive web design
- File-based data storage (with optional database support)
- REST API architecture

## Quick Installation

For detailed installation instructions, please refer to the [Installation Guide](INSTALLATION.md).

```html
<!-- Add this code to your website's HTML -->
<script src="https://yourdomain.com/assets/js/embed.js" 
        data-chatbot-color="#005b52"
        data-chatbot-name="MoneyTree Assistant"
        data-website-id="your-website-id">
</script>
```

## Configuration

The chatbot can be configured through the following files:

- `config/config.php`: Main configuration settings
- `config/storage.php`: Data storage settings
- `assets/js/chatbot.js`: Frontend behavior and appearance

## Property Data Integration

The chatbot uses a real-time API to fetch property information. It automatically connects to your property database through the API endpoint configured in `config/config.php`.

Key properties of the integration:
- Real-time data from your property management system
- Fallback mechanism if API is unavailable
- URL cleaning to ensure proper formatting of property links
- Simple API structure that's easy to customize

## Documentation

- [Installation Guide](INSTALLATION.md)
- [Hostinger Deployment](HOSTINGER_DEPLOYMENT.md)
- [Custom Domain Deployment](CUSTOM_DOMAIN_DEPLOYMENT.md)
- [Troubleshooting](TROUBLESHOOTING.md)
- [Customization Guide](CUSTOMIZATION.md)

## Admin Access

Access the admin dashboard at `/admin/` path with the following default credentials:
- Username: admin
- Password: password

*Make sure to change these credentials after installation!*

## Support

For support, contact us at support@moneytreerealty.com or open an issue on our GitHub repository.