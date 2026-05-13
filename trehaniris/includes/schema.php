<?php
/**
 * JSON-LD Structured Data Generator
 * Includes: RealEstateAgent, LocalBusiness, FAQPage, Product, WebPage
 */
function generateSchema(array $page_data = []): string {
    $faqs_schema = [];
    if (!empty($page_data['faqs'])) {
        foreach ($page_data['faqs'] as $faq) {
            $faqs_schema[] = [
                '@type' => 'Question',
                'name' => $faq['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['a']
                ]
            ];
        }
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            // RealEstateAgent (organization)
            [
                '@type' => 'RealEstateAgent',
                'name' => COMPANY_NAME,
                'url' => SITE_URL,
                'telephone' => SITE_PHONE,
                'email' => SITE_EMAIL,
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Sector 85',
                    'addressLocality' => 'Gurugram',
                    'addressRegion' => 'Haryana',
                    'postalCode' => COMPANY_ZIP,
                    'addressCountry' => 'IN'
                ],
                'geo' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => '28.4089',
                    'longitude' => '76.9450'
                ],
                'areaServed' => [
                    ['@type' => 'City', 'name' => 'Gurugram'],
                    ['@type' => 'City', 'name' => 'Gurgaon'],
                    ['@type' => 'City', 'name' => 'Delhi NCR'],
                ],
                'knowsAbout' => ['Commercial Real Estate', 'Retail Shops', 'Office Spaces', 'Commercial Investment'],
                'aggregateRating' => [
                    '@type' => 'AggregateRating',
                    'ratingValue' => '4.7',
                    'bestRating' => '5',
                    'reviewCount' => '850'
                ],
                'sameAs' => []
            ],

            // LocalBusiness (the property itself)
            [
                '@type' => 'LocalBusiness',
                'name' => PROPERTY_NAME,
                'description' => 'Premium commercial retail shops, office spaces, and food courts at Sector 85, Gurgaon on Dwarka Expressway by ' . PROPERTY_DEVELOPER . '. RERA No. ' . PROPERTY_RERA,
                'url' => SITE_URL,
                'telephone' => SITE_PHONE,
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Sector 85, Dwarka Expressway',
                    'addressLocality' => 'Gurugram',
                    'addressRegion' => 'Haryana',
                    'postalCode' => COMPANY_ZIP,
                    'addressCountry' => 'IN'
                ],
                'geo' => [
                    '@type' => 'GeoCoordinates',
                    'latitude' => '28.4089',
                    'longitude' => '76.9450'
                ],
                'hasMap' => 'https://maps.google.com/?q=28.4089,76.9450',
                'openingHoursSpecification' => [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    'opens' => '10:00',
                    'closes' => '21:00'
                ]
            ],

            // WebPage
            [
                '@type' => 'WebPage',
                'name' => $page_data['title'] ?? PROPERTY_NAME,
                'description' => $page_data['description'] ?? '',
                'url' => $page_data['url'] ?? SITE_URL,
                'speakable' => [
                    '@type' => 'SpeakableSpecification',
                    'cssSelector' => ['h1', '.subhead', '.section-title']
                ],
                'breadcrumb' => [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        [
                            '@type' => 'ListItem',
                            'position' => 1,
                            'name' => 'Home',
                            'item' => SITE_URL
                        ]
                    ]
                ]
            ],

            // Product (commercial property offering)
            [
                '@type' => 'Product',
                'name' => PROPERTY_NAME . ' — Commercial Shops & Office Spaces',
                'description' => 'Premium retail shops, office spaces, and food court units in ' . PROPERTY_LOCATION . ' by ' . PROPERTY_DEVELOPER . '. RERA No. ' . PROPERTY_RERA,
                'brand' => [
                    '@type' => 'Brand',
                    'name' => PROPERTY_DEVELOPER
                ],
                'offers' => [
                    '@type' => 'AggregateOffer',
                    'priceCurrency' => 'INR',
                    'lowPrice' => '4500000',
                    'availability' => 'https://schema.org/InStock',
                    'seller' => [
                        '@type' => 'Organization',
                        'name' => COMPANY_NAME
                    ]
                ],
                'aggregateRating' => [
                    '@type' => 'AggregateRating',
                    'ratingValue' => '4.7',
                    'bestRating' => '5',
                    'reviewCount' => '850'
                ]
            ],
        ]
    ];

    // Add FAQPage if FAQs exist
    if (!empty($faqs_schema)) {
        $schema['@graph'][] = [
            '@type' => 'FAQPage',
            'mainEntity' => $faqs_schema
        ];
    }

    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</script>';
}
