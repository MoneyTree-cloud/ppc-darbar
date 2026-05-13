# Property Assets Information

This directory contains various assets used by the Real Estate Chatbot, including property images and text descriptions for demonstration purposes.

## Attached Assets

The `attached_assets` directory contains text files with property information that can be used by the chatbot. These are sample property listings for Paras Estate properties that the AI can reference when answering questions.

### Paras Avenue Sector 129, Noida

This is a premium commercial property development located in Sector 129, Noida. The key details include:
- Location: Sector 129, Noida
- Type: Commercial Spaces
- Starting Price: 60 Lac+
- Developer: Paras Buildtech

### Paras Estate Meerut

This property is located near the Meerut Bypass:
- Location: Near Meerut Bypass, Meerut 250001
- Price: On Request
- Features: Convenient location with good connectivity

## Using Property Information

The chatbot is configured to provide information about these properties based on user inquiries. The system prompt includes basic details about these properties, but for more comprehensive responses, you can:

1. Add more detailed information to the system prompt in config/config.php
2. Implement an API connection to your property listing database
3. Add more property text files to the attached_assets directory

## Adding New Properties

To add new property information:

1. Create a new text file in the attached_assets directory
2. Name it descriptively (e.g., property-name-location.txt)
3. Include key details like location, price, features, and amenities
4. Update the system prompt in config/config.php to reference the new property

## Images

When adding property images:

1. Use the assets/images directory for storing property images
2. Optimize images for web (reduce file size while maintaining quality)
3. Use descriptive filenames that match the property names

---

Note: All property information is provided for demonstration purposes only. Actual property details should be verified with the developer or real estate agent.