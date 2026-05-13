<?php
/**
 * Real Estate Chatbot - Properties API Integration
 * This file handles the integration with real property data APIs.
 */

// Include configuration
require_once __DIR__ . '/../config/config.php';

/**
 * Fetch properties from the external API
 * 
 * @param array $filters Optional filters (location, price_min, price_max, property_type, etc.)
 * @return array|null Array of properties or null on error
 */
function fetchPropertiesFromAPI($filters = []) {
    // API endpoint URL - Replace with your actual API endpoint
    $apiUrl = API_PROPERTIES_ENDPOINT;
    
    // Add API key to requests if needed
    $headers = [
        'Authorization: Bearer ' . API_PROPERTIES_KEY,
        'Content-Type: application/json'
    ];
    
    // Prepare request
    $ch = curl_init();
    
    // Build query string from filters
    if (!empty($filters)) {
        $queryString = http_build_query($filters);
        $apiUrl .= '?' . $queryString;
    }
    
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 10 seconds timeout
    
    // Execute request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);

    // Check for errors
    if ($error || $httpCode !== 200) {
        error_log("API Error: $error, HTTP Code: $httpCode");

        // If API is not available, return fallback data
        return getFallbackProperties();
    }
    
    // Parse response
    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON Error: " . json_last_error_msg());
        return getFallbackProperties();
    }
    
    return $data;
}

/**
 * Get a specific property by ID from the API
 * 
 * @param string $propertyId The ID of the property to retrieve
 * @return array|null Property data or null if not found
 */
function getPropertyByIdFromAPI($propertyId) {
    // API endpoint URL for a specific property
    $apiUrl = API_PROPERTIES_ENDPOINT . '/' . urlencode($propertyId);
    
    // Add API key to requests if needed
    $headers = [
        'Authorization: Bearer ' . API_PROPERTIES_KEY,
        'Content-Type: application/json'
    ];
    
    // Prepare request
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 10 seconds timeout
    
    // Execute request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);

    // Check for errors
    if ($error || $httpCode !== 200) {
        error_log("API Error: $error, HTTP Code: $httpCode");

        // If API is not available, return fallback data for this property
        $fallbackProperties = getFallbackProperties();
        foreach ($fallbackProperties as $property) {
            if ($property['id'] === $propertyId) {
                return $property;
            }
        }
        
        return null;
    }
    
    // Parse response
    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON Error: " . json_last_error_msg());
        return null;
    }
    
    return $data;
}

/**
 * Search properties based on user query
 * 
 * @param string $query The search query
 * @return array Array of matching properties
 */
function searchPropertiesByQuery($query) {
    // Convert query to lowercase for case-insensitive matching
    $query = strtolower($query);
    
    // Extract possible location information using keyword analysis
    $locations = ['noida', 'gurgaon', 'gurugram', 'mumbai', 'lucknow', 'delhi', 'ncr'];
    $propertyTypes = ['apartment', 'flat', 'house', 'villa', 'plot', 'land', 'commercial', 'office', 'shop', 'retail'];
    $priceKeywords = ['budget', 'affordable', 'luxury', 'premium', 'cheap', 'expensive', 'crore', 'lac', 'lakh'];
    
    $filters = [];
    
    // Check for location
    foreach ($locations as $location) {
        if (strpos($query, $location) !== false) {
            $filters['location'] = $location;
            break;
        }
    }
    
    // Check for property type
    foreach ($propertyTypes as $type) {
        if (strpos($query, $type) !== false) {
            $filters['property_type'] = $type;
            break;
        }
    }
    
    // Simple price range detection - can be enhanced for better accuracy
    if (strpos($query, 'luxury') !== false || strpos($query, 'premium') !== false) {
        $filters['price_min'] = 10000000; // 1 crore+
    } elseif (strpos($query, 'affordable') !== false || strpos($query, 'budget') !== false) {
        $filters['price_max'] = 5000000; // Up to 50 lakh
    }
    
    // Fetch properties with these filters
    return fetchPropertiesFromAPI($filters);
}

/**
 * Provide fallback property data when API is unavailable
 * 
 * @return array Array of hardcoded property data
 */
function getFallbackProperties() {
    return [
        [
            'id' => 'paras-avenue-sector-129-noida',
            'name' => 'Paras Avenue',
            'location' => 'Sector 129, Noida',
            'price' => '60 Lac+',
            'type' => 'Commercial',
            'description' => 'Premium commercial spaces at Paras Avenue in Noida Sector 129. Excellent investment opportunity with modern amenities and strategic location.',
            'details_url' => 'https://moneytreerealty.com/propertydetail/paras-avenue-sector-129-noida',
            'builder' => 'Paras Buildtech',
            'amenities' => ['24/7 Security', 'Power Backup', 'Parking', 'High-speed Elevators'],
            'area' => '500-2000 sq.ft.'
        ],
        [
            'id' => 'paras-estate-meerut',
            'name' => 'Paras Estate',
            'location' => 'Near Meerut Bypass, Meerut',
            'price' => 'Price on Request',
            'type' => 'Residential',
            'description' => 'Luxurious residential development by Paras Buildtech in Meerut. Premium living spaces with modern amenities and strategic location.',
            'details_url' => 'https://moneytreerealty.com/propertydetail/paras-estate-meerut',
            'builder' => 'Paras Buildtech',
            'amenities' => ['Swimming Pool', 'Gym', 'Club House', '24/7 Security', 'Power Backup'],
            'area' => '1200-2500 sq.ft.'
        ]
    ];
}