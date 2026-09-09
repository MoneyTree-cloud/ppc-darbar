<?php

declare(strict_types=1);
header('Content-Type: text/html; charset=UTF-8');
/* SYNQ: PHP 7.4+ / XAMPP. Keep index.php beside assets/.
 * Edit page data in these arrays. HTML, bundled Tailwind CSS, custom CSS and JS
 * are all contained in this file. No build tools or external CDN required.
 * heroSlides title/description allow trusted inline HTML (<br>, <em>).
 * presentationArchive retains the original extracted deck text, including
 * historical offers. It is not displayed as verified current pricing.
 */

$config = [
    'title' => 'IQ Homes Highlife | AI Homes in Greater Noida West',
    'description' => 'IQ Homes Highlife in Greater Noida West, offering fully furnished 1 & 2 BHK smart homes with AI automation, premium interiors and modern living.',
    'robots' => 'noindex,nofollow',
    'whatsapp' => '919412234688',
    'phone_display' => '+91 94122 34688',
];

session_start();
// Enquiries are handled by process-form.php via the shared CRM lead handler;
// on return it flashes a result here through the session (see lead_form_finish()).
$success = $_SESSION['form_success'] ?? false;
$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_success'], $_SESSION['form_errors']);

$images = [
    'interior' => [
        'src' => 'assets/interior.webp',
        'alt' => 'Illustrative connected living room',
    ],
    'bedroom' => [
        'src' => 'assets/bedroom.webp',
        'alt' => 'Illustrative furnished bedroom',
    ],
    'dining' => [
        'src' => 'assets/dining.webp',
        'alt' => 'Illustrative dining space',
    ],
    'lounge' => [
        'src' => 'assets/lounge.webp',
        'alt' => 'Illustrative lounge with a green outlook',
    ],
];

$heroSlides = [
    [
        // 'title' => 'Your home.<br>In sync with <em>you.</em>',
        'title' => 'SYNQ IQ.<br> Homes Highlife <br> Techzone 4',
        'description' => 'Fully furnished 1 & 2 BHK residences designed for effortless,<br> connected living. Smart control, elevated comfort,<br> and everything you need—beautifully in sync.',
        'card' => 'Welcome home',
        'status' => 'Scene ready',
        'climate' => '24°',
        'light' => 'Warm',
        'curtain' => 'Open',
        'note' => 'One touch. Everything feels right.',
        'src' => 'assets/interior.webp',
        'alt' => 'Illustrative connected living room',
    ],
    [
        'title' => 'Your space.<br>Your kind of <em>calm.</em>',
        'description' => 'A quiet retreat. A softer setting.<br>Let your home slow down with you.',
        'card' => 'Unwind mode',
        'status' => 'Relax scene',
        'climate' => '24°',
        'light' => 'Soft',
        'curtain' => 'Closed',
        'note' => 'A quieter setting for your evening.',
        'src' => 'assets/bedroom.webp',
        'alt' => 'Illustrative furnished bedroom',
    ],
    [
        'title' => 'Come together.<br>Stay <em>connected.</em>',
        'description' => 'A table for conversation. Space for company.<br>Make everyday moments feel special.',
        'card' => 'Gather together',
        'status' => 'Party scene',
        'climate' => '23°',
        'light' => 'Bright',
        'curtain' => 'Open',
        'note' => 'Set the scene for your favourite people.',
        'src' => 'assets/dining.webp',
        'alt' => 'Illustrative dining space',
    ],
    [
        'title' => 'Open your day.<br>Live a little <em>more.</em>',
        'description' => 'A brighter outlook. An easier routine.<br>Connected living, from morning onwards.',
        'card' => 'A fresh beginning',
        'status' => 'Routine scene',
        'climate' => '25°',
        'light' => 'Natural',
        'curtain' => 'Open',
        'note' => 'Let the light in. Let the day begin.',
        'src' => 'assets/lounge.webp',
        'alt' => 'Illustrative lounge with a green outlook',
    ],
];

$scenes = [
    'relax' => [
        'time' => '07:00 PM',
        'title' => 'Settle into your evening.',
        'light' => 'Warm white',
        'curtains' => 'Half drawn',
        'filter' => 'sepia(.15) brightness(.85)',
        'tint' => '#d0871320',
        'label' => 'Relax',
        'subtitle' => 'Slow down, settle in',
        'icon' => '☾',
    ],
    'routine' => [
        'time' => '08:00 AM',
        'title' => 'A brighter beginning.',
        'light' => 'Natural white',
        'curtains' => 'Open',
        'filter' => 'brightness(1.08)',
        'tint' => 'transparent',
        'label' => 'Routine',
        'subtitle' => 'A fresh beginning',
        'icon' => '☀',
    ],
    'work' => [
        'time' => '10:00 AM',
        'title' => 'Find your focus.',
        'light' => 'Cool white',
        'curtains' => 'Scene controlled',
        'filter' => 'saturate(.65) brightness(.98)',
        'tint' => '#7fb2ff18',
        'label' => 'Work',
        'subtitle' => 'Room to focus',
        'icon' => '⌘',
    ],
    'party' => [
        'time' => '09:00 PM',
        'title' => 'Bring everyone together.',
        'light' => 'All lights on',
        'curtains' => 'Scene controlled',
        'filter' => 'saturate(1.2) brightness(1.08)',
        'tint' => '#d7a34515',
        'label' => 'Party',
        'subtitle' => 'Make it an occasion',
        'icon' => '✧',
    ],
];

$plans = [
    '1' => [
        'label' => '1 BHK',
        'title' => 'Your own private retreat.',
        'description' => 'An intuitive home for your everyday rhythm, with connected controls and thoughtfully planned living space.',
        'image' => 'assets/bedroom.webp',
        'alt' => 'Illustrative furnished bedroom, not a measured floor plan',
    ],
    '2' => [
        'label' => '2 BHK',
        'title' => 'A little more room for life.',
        'description' => 'Space for shared moments and personal routines, with fully furnished living and integrated smart-home controls.',
        'image' => 'assets/dining.webp',
        'alt' => 'Illustrative dining space, not a measured floor plan',
    ],
];

$messages = [
    'hello_i_would_like_to_enquire_about_synq_ai_homes' => 'Hello, I would like to enquire about SYNQ AI Homes.',
    'please_share_the_approved_1_bhk_floor_plan_for_syn' => 'Please share the approved 1 BHK floor plan for SYNQ',
    'please_share_the_exact_synq_location_and_site_visi' => 'Please share the exact SYNQ location and site visit details',
    'hello_please_share_synq_ai_homes_current_price_lis' => 'Hello, please share SYNQ AI Homes current price list, availability and offer terms.',
];

$content = [
    'global' => [
        'skip_to_content' => 'Skip to content',
        'synq' => 'synq',
        'aria_label_synq_home' => 'SYNQ home',
        'ai_homes_by_highlife' => 'AI HOMES BY HIGHLIFE',
        'aria_label_main_navigation' => 'Main navigation',
        'let_s_connect' => 'Let’s connect ↗',
        'text' => '☰',
        'aria_label_open_navigation' => 'Open navigation',
        'aria_label_synq_residences' => 'SYNQ residences',
        'text_2' => '✕',
        'aria_label_close_enlarged_image' => 'Close enlarged image',
        'alt_enlarged_illustrative_interior' => 'Enlarged illustrative interior',
        'illustrative_interior' => 'Illustrative interior',
    ],
    'hero' => [
        'greater_noida_west_1_2_bhk_residences' => 'GREATER NOIDA WEST · 1 & 2 BHK RESIDENCES',
        'experience_connected_living' => 'Experience connected living',
        'text' => '↗',
        'synq_living' => 'SYNQ LIVING',
        'climate' => 'CLIMATE',
        'lighting' => 'LIGHTING',
        'curtains' => 'CURTAINS',
        'aria_label_slideshow_controls' => 'Slideshow controls',
        'text_2' => '←',
        'aria_label_previous_slide' => 'Previous slide',
        'text_3' => '→',
        'aria_label_next_slide' => 'Next slide',
        'pause' => 'Pause',
        'aria_label_pause_slideshow' => 'Pause slideshow',
        'architecture_for_living_technology_for_life' => 'Architecture for living. Technology for life.',
        'illustrative_interior_scroll_to_explore' => 'Illustrative interior · Scroll to explore ↓',
    ],
    'overview' => [
        '01_a_new_way_home' => '01 / A NEW WAY HOME',
        'more_than_a_space' => 'More than a space.',
        'a_feeling_of_ease' => 'A feeling of ease.',
        'a_home_that_brings_your_lights_curtains_and_climat' => 'A home that brings your lights, curtains and climate together. So the little things take care of themselves, and your day has room for more.',
        'synq_brings_fully_furnished_1_and_2_bhk_living_to_' => 'SYNQ brings fully furnished 1 and 2 BHK living to Greater Noida West, combining thoughtfully planned interiors with connected home controls.',
        'find_your_space' => 'Find your space ↗',
    ],
    'experience' => [
        '02_make_yourself_at_home' => '02 / MAKE YOURSELF AT HOME',
        'one_room' => 'One room.',
        'every_version_of_you' => 'Every version of you.',
        'from_a_focused_morning_to_a_relaxed_evening' => 'From a focused morning to a relaxed evening.',
        'choose_a_scene_and_feel_the_difference' => 'Choose a scene and feel the difference.',
        'alt_illustrative_living_room_showing_a_selected_li' => 'Illustrative living room showing a selected lighting atmosphere',
        'interactive_illustration_not_a_live_device_connect' => 'Interactive illustration, not a live device connection',
        'synq' => 'synq',
        'home_control' => 'HOME CONTROL',
        'choose_your_scene' => 'CHOOSE YOUR SCENE',
        'aria_label_room_scene' => 'Room scene',
        'lighting' => 'Lighting',
        'curtains' => 'Curtains',
        'control' => 'Control',
        'one_touch' => 'One touch',
        'app_voice_touch_panel_automation' => 'APP · VOICE · TOUCH PANEL · AUTOMATION',
    ],
    'technology' => [
        '03_quietly_intelligent' => '03 / QUIETLY INTELLIGENT',
        'designed_to_simplify' => 'Designed to simplify',
        'your_everyday' => 'your everyday.',
    ],
    'plans' => [
        '04_space_to_be_yourself' => '04 / SPACE TO BE YOURSELF',
        'small_details' => 'SYNQ IQ. Homes. ',
        'a_bigger_way_to_live' => 'Designed Around You.',
        'alt_illustrative_furnished_bedroom_not_a_measured_' => 'Illustrative furnished bedroom, not a measured floor plan',
        'illustrative_interior_layout_subject_to_confirmati' => 'Illustrative interior · Layout subject to confirmation',
        'aria_label_apartment_configuration' => 'Apartment configuration',
        'fully_furnished_ai_enabled' => 'FULLY FURNISHED · AI ENABLED',
        'configuration' => 'Configuration',
        'furnishing' => 'Furnishing',
        'fully_furnished' => 'Fully furnished',
        'area_dimensions' => 'Area & dimensions',
        'request_approved_plan' => 'Request approved plan',
        'request_floor_plan' => 'Request floor plan ↗',
        'approved_floor_plan_drawings_and_unit_areas_are_aw' => 'Approved floor-plan drawings and unit areas are awaiting confirmation.',
    ],
    'amenities' => [
        '05_life_beyond_your_front_door' => '05 / LIFE BEYOND YOUR FRONT DOOR',
        'room_for_everything' => 'SYNQ IQ. Homes. ',
        'you_love' => 'Elevated Living. ',
    ],
    'gallery' => [
        '06_a_closer_look' => '06 / A CLOSER LOOK',
        'picture_your' => 'SYNQ IQ. Home ',
        'everyday' => 'Highlife.',
        'illustrative_interiors' => '',
        'final_specifications_may_differ' => '',
    ],
    'location' => [
        '07_connected_to_what_matters' => '07 / CONNECTED TO WHAT MATTERS',
        'a_greener_outlook' => 'SYNQ IQ. Homes. ',
        'a_connected_address' => 'A Greener, Smarter Life.',
        'greater_noida_west' => 'Greater Noida West',
        'a_130_metre_wide_road_and_an_adjacent_100_metre_gr' => 'A 130-metre-wide road and an adjacent 100-metre green belt bring connectivity and a greener setting together.',
        'request_exact_location' => 'Request exact location ↗',
    ],
    'price' => [
        '08_your_next_chapter' => '08 / YOUR NEXT CHAPTER',
        'make_room' => 'Plan & Pricing',
        'for_what_s' => '',
        'next' => 'for SYNQ IQ Homes',
        'explore_available_residences_current_pricing' => 'Explore available residences, current pricing',
        'and_the_payment_plan_that_suits_you' => 'and the payment plan that suits you.',
        '1_2_bhk_ai_homes' => '1 & 2 BHK AI HOMES',
        'your_home' => 'Your home.',
        'your_possibilities' => 'Your possibilities.',
        'current_pricing' => 'Current pricing',
        'on_request' => 'On request',
        'payment_options' => 'Payment options',
        '40_40_20_clp' => '40:40:20 / CLP',
        'ask_for_the_current_developer_price_list_unit_avai' => 'Ask for the current developer price list, unit availability, possession schedule and complete offer terms.',
        'get_the_current_price_list' => 'Get the current price list ↗',
    ],
    'about' => [
        '09_ai_homes_by_highlife' => '09 / AI HOMES BY HIGHLIFE',
        'thoughtful_spaces' => 'Thoughtful spaces.',
        'connected_living' => 'Connected living.',
        'synq_brings_home_design_and_everyday_technology_in' => 'SYNQ brings thoughtful home design and everyday technology together for a more effortless way of living.',
        'the_project_presentation_introduces_furnished_resi' => 'Each residence features integrated lighting, motorised curtains, climate control, and smart-home access—designed to make everyday comfort feel seamless.',
    ],
    'faq' => [
        '10_a_few_things_to_know' => '10 / A FEW THINGS TO KNOW',
        'let_s_make' => 'Let’s make',
        'it_clear' => 'it clear.',
    ],
    'footer' => [
        'synq' => 'synq',
        'ai_homes_by_highlife' => 'AI HOMES BY HIGHLIFE',
        'a_home_in_sync_with_you' => '© 2026 Synq Highlife ',
        'design_preview_based_on_the_supplied_project_prese' => 'Design preview based on the supplied project presentation. Interiors are illustrative and are not extracted project photographs. Specifications, availability, approvals, pricing and offers require developer confirmation. Proposed infrastructure is subject to approvals and execution.',
        'synq_greater_noida_west' => 'SYNQ · Greater Noida West',
        'enquiries_through_moneytree_realty' => 'Enquiries through MoneyTree Realty',
        'back_to_top' => 'Back to top ↑',
    ],
];

$navigation = [
    [
        'label' => 'Overview',
        'href' => '#overview',
    ],
    [
        'label' => 'Price List',
        'href' => '#price',
    ],
    [
        'label' => 'Floor Plans',
        'href' => '#plans',
    ],
    [
        'label' => 'Amenities',
        'href' => '#amenities',
    ],
    [
        'label' => 'Gallery',
        'href' => '#gallery',
    ],
    [
        'label' => 'Location',
        'href' => '#location',
    ],
    [
        'label' => 'About',
        'href' => '#about',
    ],
    [
        'label' => 'FAQ',
        'href' => '#faq',
    ],
    [
        'label' => 'Enquire',
        'href' => '#enquire',
    ],
];

$facts = [
    [
        'value' => '1 & 2 BHK',
        'label' => 'Fully furnished homes',
    ],
    [
        'value' => 'G + 18',
        'label' => 'High-rise living',
    ],
    [
        'value' => '100 m',
        'label' => 'Adjacent green belt',
    ],
    [
        'value' => 'One touch',
        'label' => 'A connected everyday',
    ],
];

$technology = [
    [
        'number' => '01',
        'title' => 'Your home, from anywhere',
        'description' => 'Control connected lights, curtains and AC through your phone, whether you’re at home or on your way.',
    ],
    [
        'number' => '02',
        'title' => 'Just say the word',
        'description' => 'An 8-inch touchscreen with built-in Alexa brings voice and touch control together.',
    ],
    [
        'number' => '03',
        'title' => 'Light that follows your mood',
        'description' => '17 smart tunable lighting points and glass touch switches create a setting for every moment.',
    ],
    [
        'number' => '04',
        'title' => 'A connected sense of security',
        'description' => 'Door and motion sensors, cameras with person detection, and welcome and away scenes.',
    ],
];

$amenities = [
    [
        'eyebrow' => '01 / UNWIND',
        'title' => 'A little more',
        'title_line_2' => 'leisure. Every day.',
        'description' => 'Clubhouse, swimming pool, gym, banquet hall and yoga facilities.',
    ],
    [
        'eyebrow' => '02 / BREATHE',
        'title' => 'Greener moments',
        'description' => 'Landscaped gardens, lawn, topiary garden, water features and a jogging track.',
    ],
    [
        'eyebrow' => '03 / PLAY',
        'title' => 'Let the day unfold',
        'description' => 'Toddlers’ play area, multiplay court and chip-and-putt area.',
    ],
    [
        'eyebrow' => '04 / CONNECT',
        'title' => 'A place to pause',
        'description' => 'Senior citizen garden, sitout plaza, stepped seating and poolside deck seating.',
    ],
];

$gallery = [
    [
        'caption' => '01 / Living in harmony ↗',
        'data_gallery' => 'assets/interior.webp',
        'aria_label' => 'Enlarge illustrative living room',
        'src' => 'assets/interior.webp',
        'alt' => 'Illustrative luxury living area',
    ],
    [
        'caption' => '02 / Your quiet corner ↗',
        'data_gallery' => 'assets/bedroom.webp',
        'aria_label' => 'Enlarge illustrative bedroom',
        'src' => 'assets/bedroom.webp',
        'alt' => 'Illustrative serene bedroom',
    ],
    [
        'caption' => '03 / Made for gathering ↗',
        'data_gallery' => 'assets/dining.webp',
        'aria_label' => 'Enlarge illustrative dining area',
        'src' => 'assets/dining.webp',
        'alt' => 'Illustrative furnished dining area',
    ],
];

$location = [
    [
        'number' => '01',
        'title' => 'Regional connectivity',
        'description' => 'NH-24 & Noida–Greater Noida Link Road',
    ],
    [
        'number' => '02',
        'title' => 'A greener neighbourhood',
        'description' => '100-metre green belt alongside the project',
    ],
    [
        'number' => '03',
        'title' => 'Everyday essentials nearby',
        'description' => 'Schools, malls and hospitals in the vicinity',
    ],
    [
        'number' => '04',
        'title' => 'Future connections',
        'description' => 'Proposed metro station nearby; subject to approvals',
    ],
];

$faqs = [
    [
        'question' => 'What residences are available at SYNQ?',
        'answer' => 'SYNQ offers fully furnished 1 & 2 BHK residences in Greater Noida West, thoughtfully designed for modern, connected living. Explore the latest availability, approved layouts, and carpet areas to find the right home for you.',
    ],
    [
        'question' => 'How do I control the smart-home features?',
        'answer' => 'The proposed system offers phone-app access, voice control, an 8-inch digital panel and automated scenes. Final compatibility, connectivity requirements and included devices should be confirmed.',
    ],
    [
        'question' => 'What comes included with the furnishing?',
        'answer' => 'Find the RERA registration, project address, approved plans, and possession timeline for SYNQ in the project details.',
    ],
    [
        'question' => 'What are the price and payment options?',
        'answer' => 'The presentation mentions 40:40:20 and construction-linked plans. Please obtain the current price list, all additional charges and written promotional terms before making a decision.',
    ],
    [
        'question' => 'Where can I find RERA and possession details?',
        'answer' => 'Request the project’s RERA registration, exact address, approved plans and contractual possession date from the sales team. These details are awaiting confirmation for this preview.',
    ],
];

$ui = [
    'openMenu' => 'Open navigation',
    'closeMenu' => 'Close navigation',
    'play' => 'Play',
    'pause' => 'Pause',
    'playSlideshow' => 'Play slideshow',
    'pauseSlideshow' => 'Pause slideshow',
    'planRequest' => 'Please share the approved {plan} floor plan for SYNQ',
];

$presentationArchive = [
    'AI MATLAB KYA HAI',
    'TECHNOLOGY JO SEEKHTI HAIN',
    'SAMAJHTI HAIN',
    'AAPKE LIYE BETTER',
    'DECIDE KARTI BHAI',
    'PHONE',
    'CAR',
    'APPS',
    'MOVIES AND MUSIC',
    'PHONE SE CAR TAK',
    'APPS SE MOVIES TAK',
    'AI IS EVERYWHERE',
    'AI IN DAILY LIFE ACTIVITIES',
    'AI SE PUCHE KAHIN BHI KABHI BHI',
    'TRENDING REELS ON YOUR FEED',
    'ALL MANAGED BY AI',
    'AB PHONE UNLOCK SE LEKAR ATTENDANCE TAK SAB AI FACE RECOGNITION SE',
    'REPORT BANANI HO YA IMAGES GENERATE KARNI HO AI HAI NA',
    'HIGHWAY OR CITY, AI DE AAPKO BEST SHORTEST ROUTE ALONG WITH TRAFFIC UPDATES',
    'AI IN DAILY LIFE ACTIVITIES',
    'AI SE PUCHE KAHIN BHI KABHI BHI',
    'TRENDING REELS ON YOUR FEED',
    'ALL MANAGED BY AI',
    'AB PHONE UNLOCK SE LEKAR ATTENDANCE TAK SAB AI FACE RECOGNITION SE',
    'REPORT BANANI HO YA IMAGES GENERATE KARNI HO AI HAI NA',
    'HIGHWAY OR CITY, AI DE AAPKO BEST SHORTEST ROUTE ALONG WITH TRAFFIC UPDATES',
    'JO AAPKE HAATH MEIN HAI, WOH BHI AI HAI',
    'CAR',
    '',
    'Parking help',
    '',
    'Lane warning',
    '',
    'Traffic detection',
    '',
    'Smart navigation',
    'SHOPPING APPS KO PATA HAI AAP KYA KHAREED SAKTE HAIN',
    'MOVIES MEIN EDITING, ANIMATION AUR VFX, SAB AI KE SAATH TEZ',
    'Pata hai kaunsi reel rokegi',
    'Pata hai aap kya dekhoge',
    'Pata hai aapka mood kya hai',
    'WOH AAPKO, AAPSE BEHTAR JAANTA HAI',
    '6',
    'AI KA',
    'SABSE BADA FAYDA',
    'TIME',
    'GHANTE KA KAAM MINUTE MEIN',
    'EFFORT',
    'REPETITIVE KAAM MACHINE KARTI HAI',
    'IDEAS',
    'MORE NEW IDEAS',
    'AB LOG CREATIVITY PAR FOCUS KARTE HAI',
    'AB EK SEEDHA SAWAAL',
    'PHONE SMART, CAR SMART,',
    'APPS SMART',
    'TOH GHAR KYUN NAHI',
    'JAHAN HUM',
    'SABSE ZYADA TIME',
    'BITATE HAIN',
    'LIFE INSIDE AN AI HOME',
    'THE HOME RUNS THE DAY',
    'YOU JUST LIVE IN IT',
    'ONE SCREEN / ONE VOICE / FROM ANYWHERE',
    'EVERYTHING ON YOUR FINGERTIPS',
    'MY HOME',
    'All secure',
    '',
    '',
    'LIGHTS',
    '17 ON',
    '',
    'CLIMATE',
    '24 C',
    '',
    'CURTAINS',
    'OPEN',
    '',
    'CAMERAS',
    'LIVE',
    'CONTROL IT HOWEVER YOU LIKE',
    '',
    'APP',
    'On your phone',
    '',
    'VOICE',
    'Alexa, built in',
    '',
    'DIGITAL PANEL',
    '8-inch digital screen',
    '',
    'AUTO',
    'Scenes, no touch',
    '',
    'YOUR HOME, FROM ANYWHERE',
    '',
    'Contact sensor on the entry door',
    '',
    'Live video with person detection',
    '',
    'Motion sensor in the washroom',
    '',
    'Geofencing sets it as you leave',
    'THE SAME SQUARE FEET',
    'ONE ROOM, FOUR IDENTITIES',
    'GUEST ROOM',
    'ROUTINE',
    'Natural white across every point, the flat at its most open',
    'FAMILY ROOM',
    'RELAX',
    'Warm light, curtains drawn halfway, the evening settling in',
    'PARTY ROOM',
    'MASTER',
    'Everything up at once, the whole floor lit in a single press',
    'WORK ROOM',
    'WORK',
    'Cool white over the desk, the rest of the room stepping back',
    'TAP ONCE AND THE WHOLE ROOM CHANGES TOGETHER, LIGHT AND CURTAIN AND CLIMATE AT THE SAME TIME',
    'WHAT CHANGES EVERY DAY',
    'THINGS YOU FEEL FROM DAY ONE',
    '',
    'EACH ROOM, FOUR IDENTITIES',
    'Guest room, family room, party room or work room',
    '',
    'GLASS TOUCH SWITCHES',
    'Touch based, with no exposed mechanical contacts',
    '',
    'MOTORISED CURTAINS',
    'Luxury, scene integration and energy saving in one',
    '',
    'AC CONTROL VIA APP',
    'Turn on the AC before you are even home',
    '',
    'GEOFENCING',
    'The home knows when you are near or far',
    '',
    'WELCOME AND AWAY SCENES',
    'One tap for total peace of mind',
    '',
    'THE LIGHT',
    'COVE, SPOTS AND LAMPS, ONE CIRCUIT',
    '',
    'THE PANEL',
    'ONE SCREEN FOR LIGHT AND CLIMATE',
    '',
    'THE CURTAINS',
    'A MOTORISED TRACK, RUN BY A SCENE',
    '',
    'THE SWITCHES',
    'TOUCH GLASS, NOTHING MECHANICAL',
    'THE SYSTEM',
    'WHAT GOES INTO IT',
    '',
    'SYNQ SWITCHES',
    'Gold Bezel',
    '',
    'SYNQ LIGHTING',
    '17 Points, Smart Tunable',
    '',
    'SYNQ INTERFACE',
    '8-inch Touch Screen with built-in Alexa',
    '',
    'SYNQ MOTION',
    'Curtain Motor and Track',
    '',
    'SYNQ CLIMATE',
    'IR Blaster',
    '',
    'SYNQ SENSE',
    'Contact and Motion Sensor',
    '',
    'WIFI CAMERAS',
    'Motion and person detection',
    '',
    'SYNQ RETROFIT',
    'Retrofit Relay, 40A Variant',
    '',
    'SYNQ GATEWAY',
    'Zigbee Wired Gateway',
    'THE EXPERIENCE',
    'WHAT IT CHANGES, EVERY DAY',
    '',
    'ONE ROOM, FOUR IDENTITIES',
    'Guest, family, party or work room',
    '',
    'TOTALLY SHOCKPROOF SWITCHES',
    'No exposed mechanical contacts',
    '',
    'MOTORISED CURTAINS',
    'Light, time or voice, and energy saved',
    '',
    'AC CONTROL VIA APP',
    'Turn on the AC before you are home',
    '',
    'COMPLETE PEACE OF MIND',
    'Sensors and cameras, never unmonitored',
    '',
    'CONTROL FROM ANYWHERE',
    'Remote access from anywhere in the world',
    '',
    'GEOFENCING',
    'The home knows when you are near or far',
    '',
    'VOICE COMMANDS',
    'Effortless living, no app and no switch',
    '',
    'ENERGY SAVING, BUILT IN',
    'A real cut in the monthly utility bill',
    '',
    'WELCOME AND AWAY SCENES',
    'One tap for total peace of mind',
    'OWN',
    'AI HOMES',
    '@JUST',
    '40 LAKHS',
    '₹',
    'GET',
    '₹40,000/MONTH',
    'TILL POSSESSION',
    'A PROVEN',
    'LOCATION',
    'A BRAND WITH',
    '18 YEARS OF LEGACY',
    'PRESENTS',
    'AI HOMES BY HIGHLIFE',
    'PRESENTS',
    'AI HOMES BY HIGHLIFE',
    '1 & 2 BHK STUDIO APARTMENTS',
    'Greater Noida West',
    'AI HOMES BY HIGHLIFE',
    '1 & 2 BHK STUDIO APARTMENTS',
    'Greater Noida West',
    'AI HOMES BY HIGHLIFE',
    'PROJECTS USP',
    'PRIME',
    'LOCATION',
    'IN THE HEART OF GREATER',
    'NOIDA WEST',
    'SEAMLESS CONNECTIVITY',
    'VIA NH 24, VIA NOIDA GR. NOIDA LINK ROAD & VIA F&G',
    'THOUGHTFULLY PLANNED',
    'BETTER DESIGN AND',
    'SPACIOUS LAYOUTS',
    'LOCATION',
    'LOCATION ADVANTAGE',
    'LAYOUT ADVANTAGE',
    'MORE',
    'USABLE AREA',
    'LOWER SALEABLE RATIO',
    'SMART PLANNING',
    'GREEN ADVANTAGE',
    'FACING 100 METRE',
    'GREEN BELT',
    'AMENITIES',
    '01',
    'CLUB WITH SWIMMING POOL',
    '02',
    'GREEN LANDSCAPE AREA',
    '03',
    'TODDLERS’ PLAY AREA',
    '04',
    'LAWN',
    '05',
    'WATER FEATURE',
    '06',
    'TOPIARY GARDEN',
    '07',
    'CHIP AND PUT',
    '08',
    'SITOUT PLAZA',
    '09',
    'SENIOR CITIZEN GARDEN',
    '10',
    'STEPPED SEATING',
    '11',
    'MULTIPLAY COURT',
    '12',
    'SWIMMING POOL',
    '13',
    'WATER FEATURE AND DECK SEATING',
    'JOGGING TRACK',
    '14',
    'YOU KNOW THE LOCATION',
    'YOU KNOW THE LAYOUT',
    'YOU KNOW THE AMENITIES',
    'NOW… LET’S TALK ABOUT THE PRICE',
    'BASIC PRICE',
    '₹11,600',
    'PER SQFT.',
    'FOR LIMITED TIME OFFER',
    '₹ 11,600 PER SQFT.',
    '₹ 10,600',
    'PER SQFT.',
    'NPV DISCOUNT',
    '₹',
    '1,000',
    'PER SQFT.',
    'BASIC PRICE',
    'POST NPV DISCOUNT',
    '₹ 10,600 PER SQFT.',
    '₹ 9,600',
    'PER SQFT.',
    '₹10,600',
    'PER SQFT.',
    'PAYMENT PLAN',
    '40:40:20',
    'AS MENTIONED IN PRICE LIST',
    'CONSTRUCTION LINK PLAN',
    'AS MENTIONED IN PRICE LIST',
    'PREMIUM HIGH-RISE',
    'G + 18 FLOORS',
    'FLOOR',
    'PLAN',
    'UNIT',
    'PLAN',
    'FULLY FURNISHED',
    'AI HOMES',
    'LOCATED ON A',
    '130 M',
    'WIDE ROAD',
    'NEAR THE PROPOSED',
    'METRO STATION',
    'ADJACENT TO A 100 M FULLY DEVELOPED GREEN BELT',
    'INTERNATIONAL SCHOOL',
    'IN THE VICINITY',
    'MALLS AND HOSPITALS',
    'IN CLOSE PROXIMITY',
    'CLUB HOUSE EQUIPPED WITH GYM, PLAY AREA, BANQUET HALL, YOGA',
    'POWER BACKUP',
    'FREE',
    '2 YEAR MAINTANANCE',
    'FREE',
    'GST',
    'FREE',
    'CAR PARKING FREE*',
    '(2BHK ONLY)',
];

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
function whatsapp(string $message): string
{
    global $config;
    return 'https://wa.me/' . preg_replace('/\D/', '', $config['whatsapp']) . '?text=' . rawurlencode($message);
}
function jsonForScript(array $data): string
{
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR);
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width,initial-scale=1" name="viewport" />
    <title><?= e($config['title']) ?></title>
    <meta content="<?= e($config['description']) ?>" name="description" />
    <meta content="<?= e($config['robots']) ?>" name="robots" />


    <style>
        /*! tailwindcss v4.3.3 | MIT License | https://tailwindcss.com */
        @layer properties {
            @supports (((-webkit-hyphens:none)) and (not (margin-trim:inline))) or ((-moz-orient:inline) and (not (color:rgb(from red r g b)))) {

                *,
                :before,
                :after,
                ::backdrop {
                    --tw-blur: initial;
                    --tw-brightness: initial;
                    --tw-contrast: initial;
                    --tw-grayscale: initial;
                    --tw-hue-rotate: initial;
                    --tw-invert: initial;
                    --tw-opacity: initial;
                    --tw-saturate: initial;
                    --tw-sepia: initial;
                    --tw-drop-shadow: initial;
                    --tw-drop-shadow-color: initial;
                    --tw-drop-shadow-alpha: 100%;
                    --tw-drop-shadow-size: initial
                }
            }
        }

        @layer theme {

            :root,
            :host {
                --font-sans: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                --font-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
                --default-font-family: var(--font-sans);
                --default-mono-font-family: var(--font-mono)
            }
        }

        @layer base {

            *,
            :after,
            :before,
            ::backdrop {
                box-sizing: border-box;
                border: 0 solid;
                margin: 0;
                padding: 0
            }

            ::file-selector-button {
                box-sizing: border-box;
                border: 0 solid;
                margin: 0;
                padding: 0
            }

            html,
            :host {
                -webkit-text-size-adjust: 100%;
                tab-size: 4;
                line-height: 1.5;
                font-family: var(--default-font-family, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji");
                font-feature-settings: var(--default-font-feature-settings, normal);
                font-variation-settings: var(--default-font-variation-settings, normal);
                -webkit-tap-highlight-color: transparent
            }

            hr {
                height: 0;
                color: inherit;
                border-top-width: 1px
            }

            abbr:where([title]) {
                -webkit-text-decoration: underline dotted;
                text-decoration: underline dotted
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-size: inherit;
                font-weight: inherit
            }

            a {
                color: inherit;
                -webkit-text-decoration: inherit;
                -webkit-text-decoration: inherit;
                -webkit-text-decoration: inherit;
                text-decoration: inherit
            }

            b,
            strong {
                font-weight: bolder
            }

            code,
            kbd,
            samp,
            pre {
                font-family: var(--default-mono-font-family, ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace);
                font-feature-settings: var(--default-mono-font-feature-settings, normal);
                font-variation-settings: var(--default-mono-font-variation-settings, normal);
                font-size: 1em
            }

            small {
                font-size: 80%
            }

            sub,
            sup {
                vertical-align: baseline;
                font-size: 75%;
                line-height: 0;
                position: relative
            }

            sub {
                bottom: -.25em
            }

            sup {
                top: -.5em
            }

            table {
                text-indent: 0;
                border-color: inherit;
                border-collapse: collapse
            }

            :-moz-focusring:where(:not(iframe)) {
                outline: auto
            }

            progress {
                vertical-align: baseline
            }

            summary {
                display: list-item
            }

            ol,
            ul,
            menu {
                list-style: none
            }

            img,
            svg,
            video,
            canvas,
            audio,
            iframe,
            embed,
            object {
                vertical-align: middle;
                display: block
            }

            img,
            video {
                max-width: 100%;
                height: auto
            }

            button,
            input,
            select,
            optgroup,
            textarea {
                font: inherit;
                font-feature-settings: inherit;
                font-variation-settings: inherit;
                letter-spacing: inherit;
                color: inherit;
                opacity: 1;
                background-color: #0000;
                border-radius: 0
            }

            ::file-selector-button {
                font: inherit;
                font-feature-settings: inherit;
                font-variation-settings: inherit;
                letter-spacing: inherit;
                color: inherit;
                opacity: 1;
                background-color: #0000;
                border-radius: 0
            }

            :where(select:is([multiple], [size])) optgroup {
                font-weight: bolder
            }

            :where(select:is([multiple], [size])) optgroup option {
                padding-inline-start: 20px
            }

            ::file-selector-button {
                margin-inline-end: 4px
            }

            ::placeholder {
                opacity: 1
            }

            @supports (not ((-webkit-appearance:-apple-pay-button))) or (contain-intrinsic-size:1px) {
                ::placeholder {
                    color: currentColor
                }

                @supports (color:color-mix(in lab, red, red)) {
                    ::placeholder {
                        color: color-mix(in oklab, currentcolor 50%, transparent)
                    }
                }
            }

            textarea {
                resize: vertical
            }

            ::-webkit-search-decoration {
                -webkit-appearance: none
            }

            ::-webkit-date-and-time-value {
                min-height: 1lh;
                text-align: inherit
            }

            ::-webkit-datetime-edit {
                display: inline-flex
            }

            ::-webkit-datetime-edit-fields-wrapper {
                padding: 0
            }

            ::-webkit-datetime-edit {
                padding-block: 0
            }

            ::-webkit-datetime-edit-year-field {
                padding-block: 0
            }

            ::-webkit-datetime-edit-month-field {
                padding-block: 0
            }

            ::-webkit-datetime-edit-day-field {
                padding-block: 0
            }

            ::-webkit-datetime-edit-hour-field {
                padding-block: 0
            }

            ::-webkit-datetime-edit-minute-field {
                padding-block: 0
            }

            ::-webkit-datetime-edit-second-field {
                padding-block: 0
            }

            ::-webkit-datetime-edit-millisecond-field {
                padding-block: 0
            }

            ::-webkit-datetime-edit-meridiem-field {
                padding-block: 0
            }

            ::-webkit-calendar-picker-indicator {
                line-height: 1
            }

            :-moz-ui-invalid {
                box-shadow: none
            }

            button,
            input:where([type=button], [type=reset], [type=submit]) {
                appearance: button
            }

            ::file-selector-button {
                appearance: button
            }

            ::-webkit-inner-spin-button {
                height: auto
            }

            ::-webkit-outer-spin-button {
                height: auto
            }

            [hidden]:where(:not([hidden=until-found])) {
                display: none !important
            }
        }

        @layer components;

        @layer utilities {
            .relative {
                position: relative
            }

            .static {
                position: static
            }

            .contents {
                display: contents
            }

            .flex {
                display: flex
            }

            .grid {
                display: grid
            }

            .table {
                display: table
            }

            .overflow-hidden {
                overflow: hidden
            }

            .filter {
                filter: var(--tw-blur, ) var(--tw-brightness, ) var(--tw-contrast, ) var(--tw-grayscale, ) var(--tw-hue-rotate, ) var(--tw-invert, ) var(--tw-saturate, ) var(--tw-sepia, ) var(--tw-drop-shadow, )
            }
        }

        @property --tw-blur {
            syntax: "*";
            inherits: false
        }

        @property --tw-brightness {
            syntax: "*";
            inherits: false
        }

        @property --tw-contrast {
            syntax: "*";
            inherits: false
        }

        @property --tw-grayscale {
            syntax: "*";
            inherits: false
        }

        @property --tw-hue-rotate {
            syntax: "*";
            inherits: false
        }

        @property --tw-invert {
            syntax: "*";
            inherits: false
        }

        @property --tw-opacity {
            syntax: "*";
            inherits: false
        }

        @property --tw-saturate {
            syntax: "*";
            inherits: false
        }

        @property --tw-sepia {
            syntax: "*";
            inherits: false
        }

        @property --tw-drop-shadow {
            syntax: "*";
            inherits: false
        }

        @property --tw-drop-shadow-color {
            syntax: "*";
            inherits: false
        }

        @property --tw-drop-shadow-alpha {
            syntax: "<percentage>";
            inherits: false;
            initial-value: 100%
        }

        @property --tw-drop-shadow-size {
            syntax: "*";
            inherits: false
        }

        /* 500;
        600;
        700;

        800&display=swap'); */
        :root {
            --ink: #163932;
            --green: #005b52;
            --cream: #f6f4ef;
            --muted: #68736d;
            --line: #d9ded7;
            --gold: #b79e6c;
        }

        * {
            box-sizing: border-box
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px
        }

        body {
            margin: 0;
            background: var(--cream);
            color: var(--ink);
            font: 16px/1.65 Manrope, Arial, sans-serif
        }

        a {
            color: inherit;
            text-decoration: none
        }

        button {
            font: inherit;
            cursor: pointer
        }

        button,
        a {
            -webkit-tap-highlight-color: transparent
        }

        button:focus-visible,
        a:focus-visible,
        summary:focus-visible {
            outline: 3px solid #b79e6c;
            outline-offset: 5px
        }

        img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        header {
            height: 96px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 4%;
            background: rgba(246, 244, 239, .97);
            position: sticky;
            top: 0;
            z-index: 30;
            border-bottom: 1px solid var(--line)
        }

        .brand {
            font-size: 48px;
            font-weight: 800;
            letter-spacing: -5px;
            line-height: .8;
            display: block
        }

        .brand span {
            display: block;
            font-size: 9px;
            letter-spacing: 1.8px;
            margin-top: 14px;
            font-weight: 700
        }

        nav {
            display: flex;
            gap: 20px;
            font-size: 12px;
            font-weight: 600
        }

        nav a:hover {
            color: var(--gold)
        }

        .header-cta {
            font-size: 13px;
            border-bottom: 1px solid var(--ink);
            padding: 10px 0
        }



        #menu {
            display: none
        }

        .hero {
            height: min(760px, 83vh);
            min-height: 610px;
            position: relative;
            color: white;
            overflow: hidden
        }

        .hero-image {
            position: absolute;
            animation: zoom 14s ease-out both
        }

        .hero-shade {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(11, 25, 22, .75), rgba(11, 25, 22, .12) 85%), linear-gradient(0deg, rgba(11, 25, 22, .5), transparent 30%)
        }

        .hero-copy {
            position: absolute;
            top: 17%;
            left: 6%;
            max-width: 730px
        }

        .eyebrow {
            font-size: 11px;
            letter-spacing: 2px;
            font-weight: 700;
            margin: 0 0 25px;
            color: var(--green)
        }

        .light {
            color: #efdfbd
        }

        h1 {
            font-size: clamp(50px, 6.8vw, 100px);
            line-height: 1.06;
            letter-spacing: -5px;
            font-weight: 500;
            margin: 0 0 28px
        }

        h1 em,
        h2 em {
            font-style: normal;
            color: #e2d1af
        }

        .hero-copy>p:not(.eyebrow) {
            font-size: 18px;
            color: #eee9e1
        }

        .button {
            display: inline-flex;
            gap: 35px;
            align-items: center;
            justify-content: space-between;
            padding: 17px 23px;
            font-weight: 600;
            font-size: 13px;
            transition: transform .2s, background .2s
        }

        .button:hover {
            transform: translateY(-3px)
        }

        .cream {
            background: var(--cream);
            color: var(--ink);
            margin-top: 22px
        }

        .green {
            background: var(--green);
            color: white
        }

        .hero-panel {
            position: absolute;
            right: 6%;
            bottom: 100px;
            width: 315px;
            background: rgba(255, 255, 255, .11);
            border: 1px solid #ffffff50;
            padding: 24px;
            backdrop-filter: blur(24px);
            border-radius: 14px
        }

        .panel-top {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            letter-spacing: 2px;
            color: #e3ddce
        }

        .panel-row {
            display: flex;
            justify-content: space-between;
            margin: 22px 0;
            font-size: 16px
        }

        .status {
            font-size: 10px;
            background: #ffffff25;
            padding: 3px 8px;
            border-radius: 20px
        }

        .panel-metrics {
            display: flex;
            justify-content: space-between;
            font-size: 23px
        }

        .panel-metrics small {
            display: block;
            font-size: 8px;
            letter-spacing: 1px;
            margin-top: 6px
        }

        .hero-panel>p {
            font-size: 11px;
            margin: 22px 0 0;
            color: #ddd
        }

        .hero-bottom {
            position: absolute;
            bottom: 26px;
            left: 6%;
            right: 6%;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #eee
        }

        .facts {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            padding: 38px 6%;
            border-bottom: 1px solid var(--line)
        }

        .facts>div {
            padding-left: 35px;
            border-left: 1px solid var(--line)
        }

        .facts>div:first-child {
            padding: 0;
            border: 0
        }

        .facts strong {
            display: block;
            font-size: 26px;
            font-weight: 500;
            letter-spacing: -1px
        }

        .facts span {
            font-size: 12px;
            color: var(--muted)
        }

        .section {
            padding: 40px;
            scroll-margin-top: 0
        }

        h2 {
            font-size: clamp(35px, 4vw, 59px);
            font-weight: 500;
            line-height: 1.15;
            letter-spacing: -2.5px;
            margin: 0 0 30px
        }

        h2 span {
            color: #899489
        }

        h3 {
            font-weight: 500;
            line-height: 1.3;
            letter-spacing: -.6px
        }

        .overview {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10%
        }

        .lead {
            font-size: 21px;
            color: var(--ink);
            line-height: 1.6
        }

        .overview p:not(.eyebrow),
        .location p:not(.eyebrow) {
            color: var(--muted)
        }

        .text-link {
            display: inline-block;
            border-bottom: 1px solid var(--ink);
            margin-top: 20px;
            padding-bottom: 8px;
            font-size: 13px;
            font-weight: 600
        }

        .experience {
            background: #e9ede7
        }

        .experience-head,
        .gallery-head {
            display: flex;
            justify-content: space-between;
            align-items: end;
            margin-bottom: 32px
        }

        .experience-head>p,
        .gallery-head>p {
            font-size: 14px;
            color: var(--muted)
        }

        .scene-layout {
            display: grid;
            grid-template-columns: 1fr 360px;
            min-height: 560px;
            gap: 18px
        }

        .scene-image-wrap {
            position: relative;
            overflow: hidden;
            border-radius: 4px
        }

        .scene-image-wrap img {
            position: absolute;
            transition: filter .7s
        }

        .scene-image-wrap:after {
            content: '';
            position: absolute;
            inset: 50% 0 0;
            background: linear-gradient(transparent, #09251caa);
            pointer-events: none
        }

        #scene-tint {
            position: absolute;
            inset: 0;
            background: #d0871320;
            transition: background .7s
        }

        .scene-caption {
            position: absolute;
            bottom: 25px;
            left: 30px;
            z-index: 2;
            color: white
        }

        .scene-caption span {
            font-size: 11px;
            letter-spacing: 2px
        }

        .scene-caption h3 {
            font-size: 28px;
            margin: 8px 0
        }

        .image-note {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #ffffffdf;
            padding: 5px 10px;
            font-size: 10px;
            color: #375246;
            z-index: 3
        }

        .scene-controller {
            background: #fff;
            padding: 30px;
            border-radius: 4px
        }

        .controller-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 34px;
            font-size: 9px;
            letter-spacing: 1px
        }

        .mini-brand {
            font-size: 32px;
            letter-spacing: -3px;
            font-weight: 800
        }

        .scene-controller .eyebrow {
            font-size: 9px;
            margin-bottom: 12px
        }

        .scene-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px
        }

        .scene-buttons button {
            display: flex;
            gap: 9px;
            align-items: center;
            background: #f4f5f0;
            border: 1px solid #e9ece6;
            padding: 16px 10px;
            text-align: left;
            color: var(--ink)
        }

        .scene-buttons button.active {
            background: var(--green);
            color: white;
            border-color: var(--green)
        }

        .scene-buttons span {
            font-size: 13px
        }

        .scene-buttons small {
            display: block;
            font-size: 9px;
            opacity: .7
        }

        .scene-settings {
            margin-top: 27px;
            font-size: 12px
        }

        .scene-settings>div {
            display: flex;
            justify-content: space-between;
            padding: 13px 0;
            border-bottom: 1px solid #eee
        }

        .scene-settings b {
            font-weight: 500
        }

        .controller-footer {
            font-size: 8px;
            letter-spacing: .7px;
            margin-top: 25px;
            color: var(--muted)
        }

        .tech-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 35px;
            margin-top: 55px
        }

        .tech-grid article {
            border-top: 1px solid var(--line);
            padding-top: 25px
        }

        .tech-icon {
            font-size: 13px;
            color: var(--gold)
        }

        .tech-grid h3 {
            font-size: 21px;
            margin: 30px 0 15px
        }

        .tech-grid p {
            color: var(--muted);
            font-size: 14px
        }

        .plans {
            background: #fff
        }

        .plan-layout {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 7%;
            align-items: center;
            margin-top: 45px
        }

        .plan-photo {
            height: 580px;
            position: relative;
            overflow: hidden
        }

        .plan-info .eyebrow {
            font-size: 10px;
            margin: 30px 0 10px
        }

        .plan-tabs {
            display: flex;
            border-bottom: 1px solid var(--line)
        }

        .plan-tabs button {
            background: transparent;
            border: 0;
            padding: 12px 30px;
            color: var(--muted)
        }

        .plan-tabs button.active {
            border-bottom: 2px solid var(--green);
            color: var(--green)
        }

        .plan-info h3 {
            font-size: 32px;
            margin: 10px 0 20px
        }

        .plan-info p {
            font-size: 14px;
            color: var(--muted)
        }

        dl {
            font-size: 13px;
            margin: 30px 0
        }

        dl>div {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid var(--line);
            padding: 13px 0
        }

        dd {
            margin: 0
        }

        .plan-info>small {
            display: block;
            font-size: 11px;
            color: var(--muted);
            margin-top: 17px
        }

        .amenity-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 18px;
            margin-top: 50px
        }

        .amenity-grid article {
            padding: 35px;
            background: #ebece5
        }

        .amenity-grid article>span {
            font-size: 10px;
            letter-spacing: 1px
        }

        .amenity-grid article h3 {
            font-size: 26px;
            margin-top: 42px
        }

        .amenity-grid article p {
            font-size: 14px;
            opacity: .8
        }

        .amenity-grid .amenity-feature {
            grid-row: span 2;
            background: var(--green);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between
        }

        .amenity-feature h3 {
            font-size: 43px !important
        }

        .amenity-grid article:last-child {
            grid-column: 2 / 4
        }

        .gallery {
            padding-top: 50px
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr 1fr;
            gap: 20px
        }

        .gallery-grid button {
            background: none;
            padding: 0;
            border: 0;
            text-align: left;
            overflow: hidden;
            color: var(--ink)
        }

        .gallery-grid img {
            height: 350px;
            transition: transform .5s
        }

        .gallery-grid button:hover img {
            transform: scale(1.025)
        }

        .gallery-grid span {
            display: block;
            padding-top: 18px;
            font-size: 12px
        }

        .location {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12%;
            border-top: 1px solid var(--line)
        }

        .location-list>div {
            display: flex;
            align-items: start;
            border-bottom: 1px solid var(--line);
            padding: 23px 0;
            gap: 25px
        }

        .location-list>div>span {
            color: var(--gold);
            font-size: 12px
        }

        .location-list p {
            margin: 0;
            color: var(--ink) !important
        }

        .location-list small {
            display: block;
            font-size: 12px;
            color: var(--muted);
            margin-top: 8px
        }

        .price {
            background: var(--green);
            color: #fff;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15%;
            align-items: center
        }

        .price h2 {
            font-size: 66px
        }

        .price>div>p:not(.eyebrow) {
            color: #cddbd1;
            font-size: 15px
        }

        .price-card {
            padding: 40px;
            background: var(--cream);
            color: var(--ink)
        }

        .price-card h3 {
            font-size: 34px;
            margin: 0 0 28px
        }

        .price-line {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            border-bottom: 1px solid var(--line);
            padding: 15px 0
        }

        .price-card p:not(.eyebrow) {
            font-size: 12px !important;
            color: var(--muted) !important;
            margin: 25px 0
        }

        .price-card .button {
            width: 100%
        }

        .faq {
            padding-top: 25px;
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 10%
        }

        details {
            border-bottom: 1px solid var(--line);
            padding: 20px 0
        }

        summary {
            cursor: pointer;
            list-style: none;
            font-size: 15px;
            font-weight: 600;
            padding-right: 30px;
            position: relative
        }

        summary:after {
            content: '+';
            position: absolute;
            right: 4px
        }

        details[open] summary:after {
            content: '−'
        }

        details p {
            font-size: 14px;
            color: var(--muted);
            max-width: 600px
        }

        .enquire {
            background: var(--green);
            color: #fff;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15%;
            align-items: center
        }

        .enquire h2 {
            font-size: 66px
        }

        .enquire>div>p:not(.eyebrow) {
            color: #cddbd1;
            font-size: 15px
        }

        .enquire-card {
            padding: 40px;
            background: var(--cream);
            color: var(--ink)
        }

        .enquire-card .field {
            font-size: 13px;
            display: block;
            margin-bottom: 18px
        }

        .enquire-card .field input {
            width: 100%;
            display: block;
            margin-top: 8px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 4px;
            padding: 13px;
            color: var(--ink);
            min-height: 46px
        }

        .enquire-card .field input:focus {
            border-color: var(--green)
        }

        .enquire-card .hp {
            position: absolute;
            left: -10000px
        }

        .enquire-card .button {
            width: 100%;
            border: 0
        }

        .enquire-card .privacy-note {
            font-size: 11px;
            color: var(--muted);
            margin-top: 15px
        }

        .enquire-alert {
            padding: 14px 16px;
            border: 1px solid var(--gold);
            background: #fff;
            font-size: 13px;
            margin-bottom: 20px
        }

        .enquire-alert ul {
            margin: 0;
            padding-left: 18px
        }

        @media(max-width:760px) {
            .enquire {
                grid-template-columns: 1fr;
                gap: 30px;
                padding: 40px 6%
            }

            .enquire h2 {
                font-size: 42px
            }

            .enquire-card {
                padding: 26px
            }
        }

        footer {
            background: #e7ebe4;
            padding: 65px 6% 25px
        }

        .footer-top {
            display: flex;
            align-items: center;
            justify-content: space-between
        }

        .footer-top>p {
            font-size: 14px;
            letter-spacing: -.6px
        }

        .footer-top>a:last-child {
            font-size: 18px
        }

        .footer-note {
            font-size: 11px;
            color: var(--muted);
            max-width: 950px;
            margin: 45px 0 30px
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            border-top: 1px solid #cbd3c8;
            padding-top: 20px
        }

        dialog {
            border: 0;
            background: #f6f4ef;
            padding: 15px;
            max-width: 90vw;
            width: 1100px
        }

        dialog::backdrop {
            background: #001b15cf
        }

        dialog img {
            max-height: 78vh;
            object-fit: contain
        }

        dialog p {
            text-align: center;
            font-size: 12px
        }

        #close-lightbox {
            position: absolute;
            right: 20px;
            top: 20px;
            border: 0;
            background: #fff;
            padding: 10px 15px;
            z-index: 1
        }

        .skip {
            position: fixed;
            top: -100px;
            z-index: 100;
            background: white;
            padding: 10px
        }

        .skip:focus {
            top: 0
        }

        @keyframes zoom {
            from {
                transform: scale(1.07)
            }

            to {
                transform: scale(1)
            }
        }

        @media(min-width:1450px) {
            nav {
                font-size: 14px;
                gap: 24px
            }
        }

        @media(max-width:1100px) {
            nav {
                gap: 12px;
                font-size: 11px
            }

            .header-cta {
                display: none
            }

            .hero-panel {
                width: 275px;
                right: 4%;
                bottom: 85px
            }

            .hero-copy {
                max-width: 65%
            }

            .hero-copy h1 {
                font-size: 70px
            }

            .scene-layout {
                grid-template-columns: 1fr 320px
            }

            .tech-grid {
                gap: 20px
            }

            .section {
                padding: 75px 5%
            }

            .price {
                gap: 7%
            }

            .price h2 {
                font-size: 55px
            }

            .plan-photo {
                height: 500px
            }
        }

        @media(max-width:760px) {
            header {
                height: 78px;
                padding: 0 6%
            }

            .brand {
                font-size: 40px
            }

            .brand span {
                font-size: 8px
            }

            #menu {
                display: block;
                background: none;
                border: 1px solid var(--line);
                padding: 6px 12px;
                color: var(--green);
                font-size: 22px
            }

            nav {
                display: none;
                position: absolute;
                top: 78px;
                left: 0;
                right: 0;
                background: var(--cream);
                padding: 20px 6%;
                font-size: 16px;
                box-shadow: 0 15px 20px #0001
            }

            nav.open {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px
            }

            .hero {
                height: 720px;
                min-height: 0
            }

            .hero-copy {
                top: 60px;
                left: 6%;
                max-width: 88%
            }

            .hero-copy h1 {
                font-size: 58px;
                letter-spacing: -3px
            }

            .hero-copy .eyebrow {
                font-size: 9px
            }

            .hero-copy>p:not(.eyebrow) {
                font-size: 16px
            }

            .hero-panel {
                bottom: 64px;
                left: 6%;
                right: auto;
                width: 280px;
                padding: 18px
            }

            .panel-row {
                margin: 14px 0
            }

            .panel-metrics {
                font-size: 18px
            }

            .hero-panel>p {
                margin-top: 14px
            }

            .hero-bottom {
                font-size: 9px;
                bottom: 20px
            }

            .hero-bottom>span:first-child {
                display: none
            }

            .hero-image {
                object-position: 60% center
            }

            .facts {
                grid-template-columns: 1fr 1fr;
                gap: 26px;
                padding: 28px 6%
            }

            .facts>div {
                padding: 0;
                border: 0
            }

            .facts strong {
                font-size: 22px
            }

            .facts span {
                font-size: 11px
            }

            .section {
                padding: 65px 6%
            }

            h2 {
                font-size: 39px;
                letter-spacing: -1.8px
            }

            .overview,
            .location,
            .price,
            .faq {
                grid-template-columns: 1fr;
                gap: 20px
            }

            .lead {
                font-size: 18px
            }

            .overview p {
                font-size: 15px
            }

            .experience-head,
            .gallery-head {
                display: block
            }

            .scene-layout {
                grid-template-columns: 1fr;
                gap: 0
            }

            .scene-image-wrap {
                height: 360px
            }

            .scene-controller {
                padding: 25px
            }

            .controller-heading {
                margin-bottom: 18px
            }

            .scene-buttons {
                grid-template-columns: repeat(4, 1fr)
            }

            .scene-buttons button {
                display: block;
                padding: 10px 6px;
                text-align: center
            }

            .scene-buttons span {
                display: block;
                font-size: 11px
            }

            .scene-buttons small {
                display: none
            }

            .scene-settings {
                margin-top: 15px
            }

            .scene-caption h3 {
                font-size: 23px
            }

            .tech-grid {
                grid-template-columns: 1fr 1fr;
                gap: 20px
            }

            .tech-grid h3 {
                font-size: 18px;
                margin-top: 20px
            }

            .tech-grid p {
                font-size: 13px
            }

            .plan-layout {
                grid-template-columns: 1fr;
                gap: 30px
            }

            .plan-photo {
                height: 400px
            }

            .plan-info h3 {
                font-size: 30px
            }

            .amenity-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px
            }

            .amenity-grid .amenity-feature {
                grid-column: span 2;
                grid-row: auto;
                min-height: 300px
            }

            .amenity-grid article {
                padding: 25px
            }

            .amenity-grid article:last-child {
                grid-column: span 2
            }

            .amenity-grid article h3 {
                font-size: 23px
            }

            .amenity-feature h3 {
                font-size: 36px !important
            }

            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 25px
            }

            .gallery-grid img {
                height: 330px
            }

            .price h2 {
                font-size: 52px
            }

            .price-card {
                padding: 28px;
                margin-top: 25px
            }

            .faq {
                padding-top: 0
            }

            .footer-top {
                align-items: start;
                gap: 30px;
                flex-direction: column
            }

            .footer-top p {
                margin: 0
            }

            .footer-note {
                margin-top: 30px
            }

            .footer-bottom {
                flex-wrap: wrap;
                gap: 15px
            }

            .image-note {
                font-size: 9px;
                max-width: 90%
            }

            .header-cta {
                display: none
            }
        }

        @media(prefers-reduced-motion:reduce) {
            html {
                scroll-behavior: auto
            }

            *,
            *:before,
            *:after {
                animation: none !important;
                transition: none !important
            }
        }

        /* Synchronized hero carousel */
        .hero-image {
            opacity: 0;
            animation: none;
            transition: opacity 1s ease;
            pointer-events: none
        }

        .hero-image.is-active {
            opacity: 1
        }

        .hero-copy {
            z-index: 2
        }

        .hero-panel {
            z-index: 2
        }

        .hero-controls {
            position: absolute;
            z-index: 4;
            left: 6%;
            bottom: 90px;
            display: flex;
            align-items: center;
            gap: 12px
        }

        .hero-controls button {
            border: 1px solid #ffffff70;
            background: #153a3270;
            color: white;
            min-width: 36px;
            height: 36px;
            backdrop-filter: blur(10px);
            border-radius: 50%;
            font-size: 16px
        }

        .hero-dots {
            display: flex;
            gap: 10px;
            align-items: center
        }

        .hero-dots button {
            min-width: 9px;
            width: 9px;
            height: 9px;
            padding: 0;
            background: transparent;
            border-color: #fff;
            border-radius: 50%
        }

        .hero-dots button.active {
            background: #fff;
            box-shadow: 0 0 0 4px #ffffff25
        }

        .hero-controls #hero-pause {
            border-radius: 20px;
            font-size: 11px;
            min-width: 60px;
            padding: 0 10px
        }

        .hero-bottom {
            z-index: 3
        }

        @media(max-width:760px) {
            .hero {
                height: 800px
            }

            .hero-panel {
                bottom: 85px
            }

            .hero-controls {
                bottom: 38px
            }

            .hero-bottom {
                bottom: 12px
            }

            .hero-copy h1 {
                font-size: clamp(43px, 8vw, 58px)
            }

            .hero-controls button {
                min-width: 32px;
                height: 32px
            }

            .hero-dots button {
                min-width: 9px;
                height: 9px
            }

            .hero-copy {
                top: 45px
            }
        }

        /* Responsive overrides: fluid content height, touch targets and safe areas. */
        body {
            font-family: Arial, "Helvetica Neue", sans-serif;
            overflow-wrap: break-word
        }

        html {
            -webkit-text-size-adjust: 100%;
            scroll-padding-top: 110px
        }

        header {
            gap: 24px
        }

        .brand {
            flex-shrink: 0
        }

        nav {
            flex-wrap: wrap;
            justify-content: center
        }

        main,
        section,
        section>div,
        .scene-layout>div,
        .plan-layout>div,
        .tech-grid>article,
        .amenity-grid>article {
            min-width: 0
        }

        a,
        button,
        summary {
            touch-action: manipulation
        }

        button {
            min-height: 44px
        }

        .button {
            max-width: 100%;
            min-height: 48px;
            gap: 18px
        }

        .text-link {
            min-height: 44px
        }

        .hero {
            height: auto;
            min-height: 690px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 315px;
            column-gap: 5%;
            row-gap: 36px;
            align-items: center;
            padding: 85px 6% 28px
        }

        .hero-image,
        .hero-shade {
            inset: 0;
            width: 100%;
            height: 100%
        }

        .hero-image {
            object-fit: cover
        }

        .hero-copy {
            position: relative;
            top: auto;
            left: auto;
            max-width: none
        }

        .hero-copy h1 {
            font-size: clamp(44px, 5.9vw, 94px);
            letter-spacing: -.055em
        }

        .hero-panel {
            position: relative;
            right: auto;
            bottom: auto;
            left: auto;
            width: 100%;
            align-self: end;
            padding: 24px;
            background: rgba(14, 39, 33, .65);
            -webkit-backdrop-filter: blur(24px)
        }

        .hero-controls {
            position: relative;
            left: auto;
            bottom: auto;
            grid-column: 1/-1;
            gap: 6px;
            flex-wrap: wrap
        }

        .hero-controls button {
            min-width: 44px;
            width: 44px;
            height: 44px;
            min-height: 44px
        }

        .hero-dots {
            gap: 0
        }

        .hero-dots button {
            border: 0;
            background: transparent;
            box-shadow: none;
            position: relative
        }

        .hero-dots button:after {
            content: "";
            position: absolute;
            left: 17px;
            top: 17px;
            width: 10px;
            height: 10px;
            border: 1px solid white;
            border-radius: 50%
        }

        .hero-dots button.active {
            background: transparent;
            box-shadow: none
        }

        .hero-dots button.active:after {
            background: white;
            box-shadow: 0 0 0 3px #ffffff25
        }

        .hero-controls #hero-pause {
            width: auto;
            min-width: 62px
        }

        .hero-bottom {
            position: relative;
            bottom: auto;
            left: auto;
            right: auto;
            grid-column: 1/-1;
            gap: 16px;
            flex-wrap: wrap
        }

        .panel-row,
        .panel-top,
        .scene-settings>div,
        dl>div,
        .price-line {
            gap: 12px
        }

        .panel-row {
            flex-wrap: wrap
        }

        .status {
            align-self: center
        }

        .panel-metrics>div {
            min-width: 0
        }

        .panel-metrics>div>span {
            font-size: clamp(16px, 2vw, 23px)
        }

        .scene-settings b,
        dd,
        .price-line strong {
            text-align: right
        }

        .scene-settings b,
        dd {
            min-width: 0
        }

        .scene-image-wrap {
            min-height: 340px
        }

        .image-note {
            right: 15px;
            width: fit-content;
            max-width: calc(100% - 30px)
        }

        .scene-caption {
            right: 20px
        }

        .gallery-grid button {
            align-self: start
        }

        .gallery-grid span {
            line-height: 1.5
        }

        summary {
            min-height: 44px;
            display: flex;
            align-items: center
        }

        summary::-webkit-details-marker {
            display: none
        }

        dialog {
            position: fixed;
            inset: 0;
            margin: auto;
            max-height: 90vh;
            max-height: 90dvh;
            overflow: auto;
            width: min(1100px, 92vw);
            max-width: 92vw;
            border-radius: 6px
        }

        dialog:not([open]) {
            display: none
        }

        dialog[open] {
            display: block
        }

        dialog img {
            height: auto;
            width: 100%;
            max-height: 76vh;
            object-fit: contain
        }

        #close-lightbox {
            min-width: 44px;
            min-height: 44px
        }

        .footer-bottom a {
            min-height: 44px;
            display: inline-flex;
            align-items: center
        }

        @media(min-width:1600px) {
            header {
                padding-inline: max(6%, calc((100vw - 1600px)/2))
            }

            .section,
            .facts,
            footer,
            .hero {
                padding-left: max(6%, calc((100vw - 1500px)/2));
                padding-right: max(6%, calc((100vw - 1500px)/2))
            }
        }

        @media(max-width:1100px) {
            .scene-layout {
                grid-template-columns: minmax(0, 1fr) 300px
            }

            .scene-controller {
                padding: 22px
            }

            .plan-layout {
                gap: 5%
            }

            .hero {
                grid-template-columns: minmax(0, 1fr) 275px;
                column-gap: 4%
            }

            .hero-copy h1 {
                font-size: clamp(44px, 5.6vw, 65px)
            }
        }

        @media(max-width:1000px) {
            header {
                height: 78px;
                padding: 0 5%
            }

            .brand {
                font-size: 40px
            }

            .brand span {
                font-size: 8px
            }

            #menu {
                display: block;
                background: none;
                border: 1px solid var(--line);
                padding: 6px 12px;
                color: var(--green);
                font-size: 22px;
                min-width: 48px
            }

            nav {
                display: none;
                position: absolute;
                top: 78px;
                left: 0;
                right: 0;
                background: var(--cream);
                padding: 18px 5%;
                font-size: 16px;
                box-shadow: 0 15px 20px #0001;
                max-height: calc(100vh - 78px);
                max-height: calc(100dvh - 78px);
                overflow: auto
            }

            nav.open {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 6px 18px
            }

            nav a {
                display: flex;
                align-items: center;
                min-height: 44px
            }

            .header-cta {
                display: none
            }

            .hero {
                min-height: 0;
                grid-template-columns: 1fr;
                padding-top: 56px;
                row-gap: 28px
            }

            .hero-copy {
                max-width: 680px
            }

            .hero-copy h1 {
                font-size: clamp(43px, 7.6vw, 74px)
            }

            .hero-panel {
                max-width: 380px;
                align-self: start
            }

            .tech-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .scene-layout {
                grid-template-columns: 1fr
            }

            .scene-image-wrap {
                height: 420px
            }

            .scene-buttons {
                grid-template-columns: repeat(4, minmax(0, 1fr))
            }

            .scene-controller {
                padding: 26px
            }

            .price {
                gap: 5%
            }

            .price h2 {
                font-size: 48px
            }

            .price-card {
                padding: 26px
            }

            html {
                scroll-padding-top: 90px
            }
        }

        @media(max-width:760px) {
            .hero {
                padding: 42px 6% 22px;
                row-gap: 26px
            }

            .hero-copy .eyebrow {
                line-height: 1.8
            }

            .hero-copy h1 {
                font-size: clamp(40px, 8vw, 58px)
            }

            .hero-panel {
                max-width: 360px;
                padding: 20px
            }

            .hero-controls {
                gap: 2px
            }

            .hero-bottom>span:first-child {
                display: none
            }

            .facts {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                column-gap: 20px
            }

            .section {
                padding: 56px 6%
            }

            .overview,
            .location,
            .price,
            .faq,
            .plan-layout {
                grid-template-columns: minmax(0, 1fr)
            }

            .scene-buttons button {
                display: block;
                text-align: center;
                padding: 12px 6px
            }

            .scene-buttons span {
                display: block
            }

            .scene-buttons small {
                display: none
            }

            .plan-photo {
                height: auto;
                aspect-ratio: 4/3
            }

            .scene-image-wrap {
                height: 360px;
                min-height: 0
            }

            .gallery-grid {
                grid-template-columns: minmax(0, 1fr)
            }

            .gallery-grid img {
                height: auto;
                aspect-ratio: 4/3
            }

            .price h2 {
                font-size: clamp(40px, 9vw, 52px)
            }

            .price-card {
                margin-top: 16px
            }

            .price-card h3 {
                font-size: 30px
            }

            .amenity-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .amenity-grid article {
                padding: 24px
            }

            .faq {
                padding-top: 30px
            }

            .footer-top>a:last-child {
                font-size: 18px
            }
        }

        @media(max-width:400px) {
            .hero-controls {
                gap: 0
            }

            .hero-controls button {
                min-width: 44px
            }

            .hero-dots {
                gap: 0
            }

            .hero-panel {
                padding: 18px
            }

            .tech-grid,
            .amenity-grid {
                grid-template-columns: minmax(0, 1fr)
            }

            .amenity-grid .amenity-feature,
            .amenity-grid article:last-child {
                grid-column: auto
            }

            .amenity-grid .amenity-feature {
                min-height: 270px
            }

            .scene-controller {
                padding: 18px
            }

            .scene-caption {
                left: 20px
            }

            .scene-caption h3 {
                font-size: 22px
            }

            .price-card {
                padding: 20px
            }

            .price-line,
            dl>div {
                flex-wrap: wrap
            }

            .facts strong {
                font-size: 20px
            }

            .section h2 {
                font-size: 35px
            }

            .button {
                padding: 15px 18px;
                font-size: 12px
            }

            .hero-copy>p:not(.eyebrow) {
                font-size: 15px
            }
        }

        @media(orientation:landscape) and (max-height:600px) {
            header {
                position: relative
            }

            html {
                scroll-padding-top: 16px
            }

            .hero {
                padding-top: 36px
            }

            .scene-image-wrap {
                height: 300px
            }

            dialog img {
                max-height: 65vh
            }
        }

        @supports(padding:max(0px)) {
            header {
                padding-left: max(5%, env(safe-area-inset-left));
                padding-right: max(5%, env(safe-area-inset-right))
            }

            footer {
                padding-bottom: max(25px, env(safe-area-inset-bottom))
            }
        }

        @media(prefers-reduced-motion:reduce) {
            html {
                scroll-behavior: auto
            }

            *,
            *:before,
            *:after {
                animation: none !important;
                transition: none !important
            }

            .button:hover {
                transform: none
            }
        }
    </style>
</head>

<body data-whatsapp="<?= e($config['whatsapp']) ?>"><a class="skip" href="#overview"><?= e($content['global']['skip_to_content']) ?></a>
    <header><a aria-label="<?= e($content['global']['aria_label_synq_home']) ?>" class="brand" href="#"><?= e($content['global']['synq']) ?><span><?= e($content['global']['ai_homes_by_highlife']) ?></span></a>
        <nav aria-label="<?= e($content['global']['aria_label_main_navigation']) ?>" id="nav"><?php foreach ($navigation as $index => $item): ?>
                <a href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a>
            <?php endforeach; ?>
        </nav><a class="header-cta" href="<?= e(whatsapp($messages['hello_i_would_like_to_enquire_about_synq_ai_homes'])) ?>"><?= e($content['global']['let_s_connect']) ?></a><button aria-controls="nav" aria-expanded="false" aria-label="<?= e($content['global']['aria_label_open_navigation']) ?>" id="menu"><?= e($content['global']['text']) ?></button>
    </header>
    <main>
        <section aria-label="<?= e($content['global']['aria_label_synq_residences']) ?>" aria-roledescription="carousel" class="hero relative overflow-hidden"><?php foreach ($heroSlides as $index => $slide): ?>
                <img class="hero-image<?= $index === 0 ? ' is-active' : '' ?>" src="<?= e($slide['src']) ?>" alt="<?= e($slide['alt']) ?>" aria-hidden="<?= $index === 0 ? 'false' : 'true' ?>" <?= $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>>
            <?php endforeach; ?>
            <div class="hero-shade"></div>
            <div class="hero-copy">
                <p class="eyebrow light"><?= e($content['hero']['greater_noida_west_1_2_bhk_residences']) ?></p>
                <h1 id="hero-title"><?= $heroSlides[0]['title'] ?></h1>
                <p id="hero-description"><?= $heroSlides[0]['description'] ?></p><a class="button cream" href="#experience"><?= e($content['hero']['experience_connected_living']) ?> <span><?= e($content['hero']['text']) ?></span></a>
            </div>
            <div class="hero-panel"><span class="panel-top"><?= e($content['hero']['synq_living']) ?> <span id="hero-counter"><?= e('01 / ' . str_pad((string) count($heroSlides), 2, '0', STR_PAD_LEFT)) ?></span></span>
                <div class="panel-row"><span id="hero-card-title"><?= e($heroSlides[0]['card']) ?></span><span class="status" id="hero-status"><?= e($heroSlides[0]['status']) ?></span></div>
                <div class="panel-metrics">
                    <div><span id="hero-climate"><?= e($heroSlides[0]['climate']) ?></span><small><?= e($content['hero']['climate']) ?></small></div>
                    <div><span id="hero-light"><?= e($heroSlides[0]['light']) ?></span><small><?= e($content['hero']['lighting']) ?></small></div>
                    <div><span id="hero-curtain"><?= e($heroSlides[0]['curtain']) ?></span><small><?= e($content['hero']['curtains']) ?></small></div>
                </div>
                <p id="hero-card-note"><?= e($heroSlides[0]['note']) ?></p>
            </div>
            <div aria-label="<?= e($content['hero']['aria_label_slideshow_controls']) ?>" class="hero-controls"><button aria-label="<?= e($content['hero']['aria_label_previous_slide']) ?>" id="hero-prev"><?= e($content['hero']['text_2']) ?></button>
                <div class="hero-dots"><?php foreach ($heroSlides as $index => $slide): ?><button data-hero-slide="<?= e($index) ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-pressed="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="<?= e($slide['card']) ?>"></button><?php endforeach; ?></div><button aria-label="<?= e($content['hero']['aria_label_next_slide']) ?>" id="hero-next"><?= e($content['hero']['text_3']) ?></button><button aria-label="<?= e($content['hero']['aria_label_pause_slideshow']) ?>" id="hero-pause"><?= e($content['hero']['pause']) ?></button>
            </div>
            <div class="hero-bottom"><span><?= e($content['hero']['architecture_for_living_technology_for_life']) ?></span><span><?= e($content['hero']['illustrative_interior_scroll_to_explore']) ?></span></div>
        </section>
        <div class="facts grid"><?php foreach ($facts as $index => $item): ?>
                <div><strong><?= e($item['value']) ?></strong><span><?= e($item['label']) ?></span></div>
            <?php endforeach; ?>
        </div>
        <section class="section overview" id="overview">
            <div class="reveal">
                <p class="eyebrow"><?= e($content['overview']['01_a_new_way_home']) ?></p>
                <h2><?= e($content['overview']['more_than_a_space']) ?><br /><span><?= e($content['overview']['a_feeling_of_ease']) ?></span></h2>
            </div>
            <div class="reveal">
                <p class="lead"><?= e($content['overview']['a_home_that_brings_your_lights_curtains_and_climat']) ?></p>
                <p><?= e($content['overview']['synq_brings_fully_furnished_1_and_2_bhk_living_to_']) ?></p><a class="text-link" href="#plans"><?= e($content['overview']['find_your_space']) ?></a>
            </div>
        </section>
        <section class="experience section" id="experience">
            <div class="experience-head reveal">
                <div>
                    <p class="eyebrow"><?= e($content['experience']['02_make_yourself_at_home']) ?></p>
                    <h2><?= e($content['experience']['one_room']) ?><br /><span><?= e($content['experience']['every_version_of_you']) ?></span></h2>
                </div>
                <!-- <p><?= e($content['experience']['from_a_focused_morning_to_a_relaxed_evening']) ?><br /><?= e($content['experience']['choose_a_scene_and_feel_the_difference']) ?></p> -->
            </div>
            <div class="scene-layout">
                <div class="scene-image-wrap"><img alt="<?= e($content['experience']['alt_illustrative_living_room_showing_a_selected_li']) ?>" id="scene-image" loading="lazy" src="<?= e($images['interior']['src']) ?>" />
                    <div id="scene-tint"></div><span class="image-note"><?= e($content['experience']['interactive_illustration_not_a_live_device_connect']) ?></span>
                    <div class="scene-caption"><span id="scene-time"><?= e($scenes['relax']['time']) ?></span>
                        <h3 id="scene-title"><?= e($scenes['relax']['title']) ?></h3>
                    </div>
                </div>
                <div class="scene-controller">
                    <div class="controller-heading"><span class="mini-brand"><?= e($content['experience']['synq']) ?></span><span><?= e($content['experience']['home_control']) ?></span></div>
                    <p class="eyebrow"><?= e($content['experience']['choose_your_scene']) ?></p>
                    <div aria-label="<?= e($content['experience']['aria_label_room_scene']) ?>" class="scene-buttons" role="group"><?php foreach ($scenes as $key => $scene): ?><button data-scene="<?= e($key) ?>" class="<?= $key === 'relax' ? 'active' : '' ?>" aria-pressed="<?= $key === 'relax' ? 'true' : 'false' ?>"><?= e($scene['icon']) ?> <span><?= e($scene['label']) ?><small><?= e($scene['subtitle']) ?></small></span></button><?php endforeach; ?></div>
                    <div aria-live="polite" class="scene-settings">
                        <div><span><?= e($content['experience']['lighting']) ?></span><b id="lighting"><?= e($scenes['relax']['light']) ?></b></div>
                        <div><span><?= e($content['experience']['curtains']) ?></span><b id="curtains"><?= e($scenes['relax']['curtains']) ?></b></div>
                        <div><span><?= e($content['experience']['control']) ?></span><b><?= e($content['experience']['one_touch']) ?></b></div>
                    </div>
                    <p class="controller-footer"><?= e($content['experience']['app_voice_touch_panel_automation']) ?></p>
                </div>
            </div>
        </section>
        <section class="section technology">
            <div class="section-heading reveal">
                <p class="eyebrow"><?= e($content['technology']['03_quietly_intelligent']) ?></p>
                <h2><?= e($content['technology']['designed_to_simplify']) ?><br /><span><?= e($content['technology']['your_everyday']) ?></span></h2>
            </div>
            <div class="tech-grid grid"><?php foreach ($technology as $index => $item): ?>
                    <article><span class="tech-icon"><?= e($item['number']) ?></span>
                        <h3><?= e($item['title']) ?></h3>
                        <p><?= e($item['description']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="section plans" id="plans">
            <div class="section-heading">
                <p class="eyebrow"><?= e($content['plans']['04_space_to_be_yourself']) ?></p>
                <h2><?= e($content['plans']['small_details']) ?><br /><span><?= e($content['plans']['a_bigger_way_to_live']) ?></span></h2>
            </div>
            <div class="plan-layout">
                <div class="plan-photo"><img alt="<?= e($content['plans']['alt_illustrative_furnished_bedroom_not_a_measured_']) ?>" id="plan-image" loading="lazy" src="<?= e($images['bedroom']['src']) ?>" /><span class="image-note"><?= e($content['plans']['illustrative_interior_layout_subject_to_confirmati']) ?></span></div>
                <div class="plan-info">
                    <div aria-label="<?= e($content['plans']['aria_label_apartment_configuration']) ?>" class="plan-tabs flex" role="group"><?php foreach ($plans as $key => $plan): ?><button data-plan="<?= e($key) ?>" class="<?= (string) $key === '1' ? 'active' : '' ?>" aria-pressed="<?= (string) $key === '1' ? 'true' : 'false' ?>"><?= e($plan['label']) ?></button><?php endforeach; ?></div>
                    <p class="eyebrow"><?= e($content['plans']['fully_furnished_ai_enabled']) ?></p>
                    <h3 id="plan-title"><?= e($plans['1']['title']) ?></h3>
                    <p id="plan-description"><?= e($plans['1']['description']) ?></p>
                    <dl>
                        <div>
                            <dt><?= e($content['plans']['configuration']) ?></dt>
                            <dd id="plan-config"><?= e($plans['1']['label']) ?></dd>
                        </div>
                        <div>
                            <dt><?= e($content['plans']['furnishing']) ?></dt>
                            <dd><?= e($content['plans']['fully_furnished']) ?></dd>
                        </div>
                        <div>
                            <dt><?= e($content['plans']['area_dimensions']) ?></dt>
                            <dd><?= e($content['plans']['request_approved_plan']) ?></dd>
                        </div>
                    </dl><a class="button green" href="<?= e(whatsapp($messages['please_share_the_approved_1_bhk_floor_plan_for_syn'])) ?>" id="plan-link"><?= e($content['plans']['request_floor_plan']) ?></a><small><?= e($content['plans']['approved_floor_plan_drawings_and_unit_areas_are_aw']) ?></small>
                </div>
            </div>
        </section>
        <section class="section amenities" id="amenities">
            <div class="section-heading">
                <p class="eyebrow"><?= e($content['amenities']['05_life_beyond_your_front_door']) ?></p>
                <h2><?= e($content['amenities']['room_for_everything']) ?><br /><span><?= e($content['amenities']['you_love']) ?></span></h2>
            </div>
            <div class="amenity-grid"><?php foreach ($amenities as $index => $item): ?>
                    <article<?= $index === 0 ? ' class="amenity-feature"' : '' ?>><span><?= e($item['eyebrow']) ?></span>
                        <h3><?= e($item['title']) ?><?php if (isset($item['title_line_2'])): ?><br><?= e($item['title_line_2']) ?><?php endif; ?></h3>
                        <p><?= e($item['description']) ?></p>
                        </article>
                    <?php endforeach; ?>
            </div>
        </section>
        <section class="section gallery" id="gallery">
            <div class="gallery-head">
                <div>
                    <p class="eyebrow"><?= e($content['gallery']['06_a_closer_look']) ?></p>
                    <h2><?= e($content['gallery']['picture_your']) ?> <span><?= e($content['gallery']['everyday']) ?></span></h2>
                </div>
                <p><?= e($content['gallery']['illustrative_interiors']) ?><br /><?= e($content['gallery']['final_specifications_may_differ']) ?></p>
            </div>
            <div class="gallery-grid grid"><?php foreach ($gallery as $index => $item): ?>
                    <button aria-label="<?= e($item['aria_label']) ?>" data-gallery="<?= e($item['data_gallery']) ?>"><img alt="<?= e($item['alt']) ?>" loading="lazy" src="<?= e($item['src']) ?>" /><span><?= e($item['caption']) ?></span></button>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="section location" id="location">
            <div>
                <p class="eyebrow"><?= e($content['location']['07_connected_to_what_matters']) ?></p>
                <h2><?= e($content['location']['a_greener_outlook']) ?><br /><span><?= e($content['location']['a_connected_address']) ?></span></h2>
                <p class="lead"><?= e($content['location']['greater_noida_west']) ?></p>
                <p><?= e($content['location']['a_130_metre_wide_road_and_an_adjacent_100_metre_gr']) ?></p><a class="text-link" href="<?= e(whatsapp($messages['please_share_the_exact_synq_location_and_site_visi'])) ?>"><?= e($content['location']['request_exact_location']) ?></a>
            </div>
            <div class="location-list"><?php foreach ($location as $index => $item): ?>
                    <div><span><?= e($item['number']) ?></span>
                        <p><?= e($item['title']) ?><small><?= e($item['description']) ?></small></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="section price" id="price">
            <div>
                <p class="eyebrow light"><?= e($content['price']['08_your_next_chapter']) ?></p>
                <h2><?= e($content['price']['make_room']) ?><br /><?= e($content['price']['for_what_s']) ?> <em><?= e($content['price']['next']) ?></em></h2>
                <p><?= e($content['price']['explore_available_residences_current_pricing']) ?><br /><?= e($content['price']['and_the_payment_plan_that_suits_you']) ?></p>
            </div>
            <div class="price-card">
                <p class="eyebrow"><?= e($content['price']['1_2_bhk_ai_homes']) ?></p>
                <h3><?= e($content['price']['your_home']) ?><br /><?= e($content['price']['your_possibilities']) ?></h3>
                <div class="price-line"><span><?= e($content['price']['current_pricing']) ?></span><strong><?= e($content['price']['on_request']) ?></strong></div>
                <div class="price-line"><span><?= e($content['price']['payment_options']) ?></span><strong><?= e($content['price']['40_40_20_clp']) ?></strong></div>
                <p><?= e($content['price']['ask_for_the_current_developer_price_list_unit_avai']) ?></p><a class="button green" href="<?= e(whatsapp($messages['hello_please_share_synq_ai_homes_current_price_lis'])) ?>"><?= e($content['price']['get_the_current_price_list']) ?></a>
            </div>
        </section>
        <section class="section overview" id="about">
            <div>
                <p class="eyebrow"><?= e($content['about']['09_ai_homes_by_highlife']) ?></p>
                <h2><?= e($content['about']['thoughtful_spaces']) ?><br /><span><?= e($content['about']['connected_living']) ?></span></h2>
            </div>
            <div>
                <p class="lead"><?= e($content['about']['synq_brings_home_design_and_everyday_technology_in']) ?></p>
                <p><?= e($content['about']['the_project_presentation_introduces_furnished_resi']) ?></p>
            </div>
        </section>
        <section class="section faq" id="faq">
            <div>
                <p class="eyebrow"><?= e($content['faq']['10_a_few_things_to_know']) ?></p>
                <h2><?= e($content['faq']['let_s_make']) ?><br /><span><?= e($content['faq']['it_clear']) ?></span></h2>
            </div>
            <div><?php foreach ($faqs as $index => $item): ?>
                    <details<?= $index === 0 ? " open" : "" ?>>
                        <summary><?= e($item['question']) ?></summary>
                        <p><?= e($item['answer']) ?></p>
                        </details>
                    <?php endforeach; ?>
            </div>
        </section>
        <section class="section enquire" id="enquire">
            <div>
                <p class="eyebrow light">11 / YOUR NEXT STEP</p>
                <h2>Let's find<br /><em>your home.</em></h2>
                <p>Share your details and our SYNQ advisor will call you with the current price list, floor plans and availability.</p>
            </div>
            <div class="enquire-card">
                <?php if ($success): ?><div class="enquire-alert" role="status"><?= e((string) $success) ?></div><?php endif; ?>
                <?php if ($errors): ?><div class="enquire-alert" role="alert">
                        <ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
                    </div><?php endif; ?>
                <form method="post" action="process-form.php" aria-label="SYNQ enquiry">
                    <input type="hidden" name="lead_form" value="1">
                    <input type="hidden" name="form_source" value="enquire_section">
                    <div class="hp" aria-hidden="true"><label>Leave empty<input name="website" tabindex="-1" autocomplete="off"></label></div>
                    <label class="field">Full name<input name="name" autocomplete="name" required minlength="2" maxlength="80"></label>
                    <label class="field">Mobile number<input name="phone" type="tel" autocomplete="tel" inputmode="tel" required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}"></label>
                    <label class="field">Email address<input name="email" type="email" autocomplete="email" required maxlength="120"></label>
                    <button class="button green" type="submit">Send Enquiry <span>↗</span></button>
                    <p class="privacy-note">Enquiry only. Not a booking or payment request.</p>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-top"><a class="brand" href="#"><?= e($content['footer']['synq']) ?><span><?= e($content['footer']['ai_homes_by_highlife']) ?></span></a>
            <p><?= e($content['footer']['a_home_in_sync_with_you']) ?></p><a href="<?= e(whatsapp($messages['hello_i_would_like_to_enquire_about_synq_ai_homes'])) ?>"><?= e($config['phone_display']) ?> ↗</a>
        </div>
        <!-- <p class="footer-note"><?= e($content['footer']['design_preview_based_on_the_supplied_project_prese']) ?></p> -->
        <!-- <div class="footer-bottom"><span><?= e($content['footer']['synq_greater_noida_west']) ?></span><span><?= e($content['footer']['enquiries_through_moneytree_realty']) ?></span><a href="#"><?= e($content['footer']['back_to_top']) ?></a></div> -->
    </footer>
    <dialog id="lightbox"><button aria-label="<?= e($content['global']['aria_label_close_enlarged_image']) ?>" id="close-lightbox"><?= e($content['global']['text_2']) ?></button><img alt="<?= e($content['global']['alt_enlarged_illustrative_interior']) ?>" id="lightbox-image" />
        <p><?= e($content['global']['illustrative_interior']) ?></p>
    </dialog>

    <script>
        window.SYNQ_DATA = {
            heroScenes: <?= jsonForScript($heroSlides) ?>,
            scenes: <?= jsonForScript($scenes) ?>,
            plans: <?= jsonForScript($plans) ?>,
            ui: <?= jsonForScript($ui) ?>
        };
    </script>
    <script src="js/main.js" defer></script>
</body>

</html>