<?php
/**
 * Smartworld Elie Saab Residences — Landing Page
 * Sector 98, Noida Expressway
 */
$siteName     = 'Smartworld Elie Saab Residences';
$siteUrl      = 'https://eliesaab98.in/';
$projectRera  = 'UPRERAPRJ300532/12/2025';
$phone        = '+91-9412-234-688';
$phoneLink    = preg_replace('/[^0-9+]/', '', $phone);
$waNumber     = preg_replace('/[^0-9]/', '', $phone);

$metaTitle    = 'Smartworld Elie Saab Residences, Sector 98 Noida | 3 & 4 BHK';
$metaDesc     = 'Smartworld Elie Saab Branded Residences — 6.5-acre couture-inspired project in Sector 98, Noida Expressway by Smart World Developers. 3 & 4 BHK from ₹8 Cr. RERA ' . $projectRera . '.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($metaTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <meta name="geo.region" content="IN-UP">
  <meta name="geo.placename" content="Sector 98, Noida, Gautam Buddha Nagar">

  <link rel="canonical" href="<?= htmlspecialchars($siteUrl) ?>">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

  <!-- Open Graph -->
  <meta property="og:title" content="<?= htmlspecialchars($metaTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($metaDesc) ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= htmlspecialchars($siteUrl) ?>">
  <meta property="og:image" content="<?= htmlspecialchars($siteUrl) ?>images/bannerdesk.webp">
  <meta property="og:site_name" content="<?= htmlspecialchars($siteName) ?>">
  <meta name="twitter:card" content="summary_large_image">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Stylesheet -->
  <link rel="preload" as="image" href="images/bannerdesk.webp">
  <link rel="stylesheet" href="css/styles.css">

  <!-- Schema.org: ApartmentComplex -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ApartmentComplex",
    "name": "Smartworld Elie Saab Residences",
    "alternateName": "Smartworld Elie Saab Branded Residences",
    "description": "Couture-inspired ultra-luxury branded residences developed by Smart World Developers in association with M3M India and Elie Saab. 6.5-acre low-density development in Sector 98 on the Noida Expressway with 4 towers, G+32 floors, and approximately 496 units of 3 BHK and 4 BHK apartments.",
    "url": "https://eliesaab98.in/",
    "image": "https://eliesaab98.in/images/bannerdesk.webp",
    "telephone": "<?= htmlspecialchars($phone) ?>",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Sector 98, Noida Expressway",
      "addressLocality": "Noida",
      "addressRegion": "Uttar Pradesh",
      "postalCode": "201303",
      "addressCountry": "IN"
    },
    "geo": {
      "@type": "GeoCoordinates",
      "latitude": 28.5087,
      "longitude": 77.3925
    },
    "numberOfAccommodationUnits": 496,
    "brand": {
      "@type": "Brand",
      "name": "Elie Saab"
    },
    "containsPlace": [
      {
        "@type": "Apartment",
        "name": "3 BHK Residence",
        "numberOfRooms": 3,
        "floorSize": { "@type": "QuantitativeValue", "minValue": 2800, "maxValue": 3400, "unitCode": "FTK" }
      },
      {
        "@type": "Apartment",
        "name": "4 BHK Residence",
        "numberOfRooms": 4,
        "floorSize": { "@type": "QuantitativeValue", "minValue": 3800, "maxValue": 4500, "unitCode": "FTK" }
      }
    ],
    "amenityFeature": [
      { "@type": "LocationFeatureSpecification", "name": "1 lakh sq ft Clubhouse", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Infinity Swimming Pool", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Spa & Wellness", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Yoga Pavilion", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Concierge Service", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Tennis Court", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Meditation Garden", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Co-Working Lounge", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Landscaped Gardens", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Rainwater Harvesting", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Solar Panels", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Jogging Track", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Kids Play Zone", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Banquet Hall", "value": true },
      { "@type": "LocationFeatureSpecification", "name": "Library", "value": true }
    ],
    "additionalProperty": [
      { "@type": "PropertyValue", "name": "RERA", "value": "<?= $projectRera ?>" },
      { "@type": "PropertyValue", "name": "Project Area", "value": "6.5 acres" },
      { "@type": "PropertyValue", "name": "Towers", "value": 4 },
      { "@type": "PropertyValue", "name": "Floors", "value": "G+32" },
      { "@type": "PropertyValue", "name": "Units Per Floor", "value": 4 },
      { "@type": "PropertyValue", "name": "Possession", "value": "Tentative 2029–2031" }
    ]
  }
  </script>

  <!-- Schema.org: Organization (Developer) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Smart World Developers",
    "url": "https://smartworldgroup.in/",
    "description": "Smart World Developers is a real estate developer delivering luxury residential projects in the NCR region, in association with partners including M3M India."
  }
  </script>

  <!-- Schema.org: BreadcrumbList -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
      { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://eliesaab98.in/" },
      { "@type": "ListItem", "position": 2, "name": "Projects", "item": "https://eliesaab98.in/#residences" },
      { "@type": "ListItem", "position": 3, "name": "Noida", "item": "https://eliesaab98.in/#location" },
      { "@type": "ListItem", "position": 4, "name": "Sector 98", "item": "https://eliesaab98.in/#location" },
      { "@type": "ListItem", "position": 5, "name": "Smartworld Elie Saab Residences", "item": "https://eliesaab98.in/" }
    ]
  }
  </script>

  <!-- Schema.org: FAQPage -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      {
        "@type": "Question",
        "name": "What is the price of Smartworld Elie Saab Residences in Sector 98 Noida?",
        "acceptedAnswer": { "@type": "Answer", "text": "Smartworld Elie Saab Residences are priced from ₹8 Crore onwards for a 3 BHK apartment. The full range is approximately ₹8–12.4 Crore depending on unit size, tower, and floor." }
      },
      {
        "@type": "Question",
        "name": "What configurations are available at Smartworld Elie Saab?",
        "acceptedAnswer": { "@type": "Answer", "text": "Smartworld Elie Saab Residences offers 3 BHK and 4 BHK apartments only. 3 BHK units range approximately 2,800–3,400 sq ft and 4 BHK units range approximately 3,800–4,500 sq ft." }
      },
      {
        "@type": "Question",
        "name": "What is the RERA number for Smartworld Elie Saab Residences?",
        "acceptedAnswer": { "@type": "Answer", "text": "The RERA registration number for Smartworld Elie Saab Residences is UPRERAPRJ300532/12/2025, registered with the Uttar Pradesh Real Estate Regulatory Authority." }
      },
      {
        "@type": "Question",
        "name": "When is the possession date for Smartworld Elie Saab?",
        "acceptedAnswer": { "@type": "Answer", "text": "The tentative possession timeline for Smartworld Elie Saab Residences is 2029–2031. The possession date is indicative and subject to change as per the developer's construction schedule." }
      },
      {
        "@type": "Question",
        "name": "How many towers are there in Smartworld Elie Saab?",
        "acceptedAnswer": { "@type": "Answer", "text": "The project consists of 4 towers, each planned as G+32 floors, with approximately 496 total residences across a 6.5-acre low-density layout of 4 units per floor." }
      },
      {
        "@type": "Question",
        "name": "Who is the developer of Elie Saab Residences Noida?",
        "acceptedAnswer": { "@type": "Answer", "text": "Smartworld Elie Saab Residences is developed by Smart World Developers in association with M3M India and the fashion house Elie Saab, which provides the couture-inspired residential brand and design direction." }
      },
      {
        "@type": "Question",
        "name": "Where exactly is Smartworld Elie Saab located?",
        "acceptedAnswer": { "@type": "Answer", "text": "The project is located in Sector 98, Noida Expressway, Gautam Buddha Nagar, Uttar Pradesh 201303. It is positioned close to Noida Golf Course, Botanical Garden Metro on the Aqua Line, and the DND Flyway connecting to South Delhi." }
      },
      {
        "@type": "Question",
        "name": "What is the size of a 3 BHK at Smartworld Elie Saab?",
        "acceptedAnswer": { "@type": "Answer", "text": "3 BHK residences at Smartworld Elie Saab are approximately 2,800 to 3,400 sq ft in carpet configuration, with 4 spacious units per floor ensuring low density and privacy." }
      },
      {
        "@type": "Question",
        "name": "What is the size of a 4 BHK at Smartworld Elie Saab?",
        "acceptedAnswer": { "@type": "Answer", "text": "4 BHK residences range approximately 3,800 to 4,500 sq ft and include private lift lobbies, large balconies, and premium couture-inspired interiors." }
      },
      {
        "@type": "Question",
        "name": "What amenities are offered at Smartworld Elie Saab Residences?",
        "acceptedAnswer": { "@type": "Answer", "text": "Key amenities include a 1 lakh sq ft clubhouse, infinity pool, spa, yoga pavilion, concierge service, tennis court, meditation garden, co-working lounge, landscaped gardens, rainwater harvesting, solar panels, jogging track, kids play zone, banquet hall, and library." }
      },
      {
        "@type": "Question",
        "name": "What is the payment plan for Smartworld Elie Saab?",
        "acceptedAnswer": { "@type": "Answer", "text": "The primary payment plan is a 20:30:50 schedule — 20% on booking, 30% during construction milestones, and 50% on possession. Exact terms should be verified on the official sale agreement." }
      },
      {
        "@type": "Question",
        "name": "How far is Smartworld Elie Saab from the metro and airport?",
        "acceptedAnswer": { "@type": "Answer", "text": "Botanical Garden Metro station on the Aqua Line is approximately 12 minutes away, Noida Golf Course is 950 metres, IGI Airport is around 30 minutes via the DND Flyway, and the upcoming Jewar International Airport is about 45 minutes away." }
      },
      {
        "@type": "Question",
        "name": "Are 2 BHK apartments available at Smartworld Elie Saab?",
        "acceptedAnswer": { "@type": "Answer", "text": "No. Smartworld Elie Saab Residences does not offer 2 BHK units. The project is exclusively designed for 3 BHK and 4 BHK luxury residences." }
      }
    ]
  }
  </script>
</head>
<body id="top">

<?php include __DIR__ . '/includes/header.php'; ?>

<!-- ============================================================ -->
<!-- [2] HERO                                                       -->
<!-- ============================================================ -->
<section class="hero" id="hero">
  <div class="hero-bg" aria-hidden="true"></div>
  <div class="container hero-grid">
    <div class="hero-copy reveal">
      <span class="eyebrow">Couture-Inspired Branded Residences</span>
      <h1>Smartworld Elie Saab Residences</h1>
      <p class="hero-sub">
        Sector 98, Noida Expressway · A 6.5-acre editorial address by Smart
        World Developers in association with M3M India and the house of Elie
        Saab — four towers, G+32, four residences per floor.
      </p>
      <div class="hero-price">
        <span class="amount">₹8 Cr*</span>
        <span class="amount-label">Onwards · 3 &amp; 4 BHK</span>
      </div>
      <div class="hero-signals">
        <div>
          <span class="label">RERA</span>
          <span class="value" style="font-size:14px; letter-spacing:0.08em;"><?= htmlspecialchars($projectRera) ?></span>
        </div>
        <div>
          <span class="label">Total Land</span>
          <span class="value">6.5 Acres</span>
        </div>
        <div>
          <span class="label">Possession</span>
          <span class="value">2029–2031<sup style="font-size:10px; color:var(--text-mid-dark); margin-left:4px;">Tentative</sup></span>
        </div>
      </div>
    </div>

    <aside class="hero-form reveal" aria-label="Enquiry form">
      <span class="eyebrow">Express Interest</span>
      <h3>Request a Private Preview</h3>
      <p class="form-sub">Our client team will share pricing, availability, and private walk-through slots.</p>

      <form action="process-form.php" method="POST" data-ajax="true" novalidate>
        <div class="form-field">
          <label for="heroName">Name</label>
          <input type="text" id="heroName" name="name" placeholder="Your full name" required>
        </div>
        <div class="form-field">
          <label for="heroEmail">Email</label>
          <input type="email" id="heroEmail" name="email" placeholder="you@example.com" required>
        </div>
        <div class="form-field">
          <label for="heroPhone">Phone</label>
          <input type="tel" id="heroPhone" name="phone" placeholder="10-digit mobile" required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}" title="Please enter a valid 10-digit Indian mobile number">
        </div>
        <div class="form-field">
          <label for="heroInterest">Interested In</label>
          <select id="heroInterest" name="interested_in">
            <option value="3 BHK">3 BHK Residence</option>
            <option value="4 BHK">4 BHK Residence</option>
            <option value="Both">Both Configurations</option>
          </select>
        </div>
        <input type="hidden" name="form_source" value="hero_form">
        <button type="submit" class="btn btn-solid btn-block">Request Callback</button>
        <p class="form-consent">
          By submitting, you agree to be contacted by our sales team regarding this project.
          No spam. RERA <?= htmlspecialchars($projectRera) ?>.
        </p>
        <div class="form-status" role="status" aria-live="polite"></div>
      </form>
    </aside>
  </div>
</section>

<!-- ============================================================ -->
<!-- [3] TRUST STRIP                                                -->
<!-- ============================================================ -->
<div class="trust-strip">
  <div class="container trust-inner">
    <span>RERA <strong><?= htmlspecialchars($projectRera) ?></strong></span>
    <span>Developer <strong>Smart World</strong></span>
    <span>In Association With <strong>M3M India</strong></span>
    <span>Branded By <strong>Elie Saab</strong></span>
    <span>Sustainability <strong>IGBC Aligned</strong></span>
  </div>
</div>

<!-- ============================================================ -->
<!-- [4] KEY FACTS BAND                                             -->
<!-- ============================================================ -->
<section id="key-facts">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Project At A Glance</span>
      <h2>A 6.5-Acre Private Address, Sculpted For The Few</h2>
      <p>Low density, high privacy, and couture-level detailing across four towers of residences on the Noida Expressway.</p>
    </div>
    <div class="facts-grid reveal">
      <div class="fact">
        <span class="value">6.5</span>
        <span class="label">Acres</span>
      </div>
      <div class="fact">
        <span class="value">4</span>
        <span class="label">Towers · G+32</span>
      </div>
      <div class="fact">
        <span class="value">~496</span>
        <span class="label">Residences</span>
      </div>
      <div class="fact">
        <span class="value">3 &amp; 4</span>
        <span class="label">BHK Only</span>
      </div>
      <div class="fact">
        <span class="value">₹8 Cr*</span>
        <span class="label">Starting Price</span>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- [5] OVERVIEW                                                   -->
<!-- ============================================================ -->
<section id="overview" class="section-alt">
  <div class="container two-col">
    <div class="reveal">
      <span class="eyebrow">Overview</span>
      <h2>An Editorial Lifestyle, Authored By Elie Saab</h2>
      <p>
        Smartworld Elie Saab Residences is a 6.5-acre ultra-luxury branded residential
        development in Sector 98 on the Noida Expressway, delivered by Smart World
        Developers in association with M3M India and the Beirut couture house Elie Saab.
        The project comprises four G+32 towers with approximately 496 apartments and a
        low-density layout of only four residences per floor. Configurations are limited
        to 3 BHK (approximately 2,800–3,400 sq ft) and 4 BHK (approximately 3,800–4,500
        sq ft), priced from ₹8 Crore onwards with a 20:30:50 payment plan. Registered
        under RERA <?= htmlspecialchars($projectRera) ?>, the project targets a tentative
        possession window of 2029–2031 and features couture-inspired interiors, a 1-lakh
        sq ft clubhouse, and signature lifestyle amenities across the masterplan.
      </p>

      <details class="disclose">
        <summary>Read the extended overview</summary>
        <div class="disclose-body">
          <p>
            Smartworld Elie Saab Residences is positioned as one of the most distinctive
            luxury launches on the Noida Expressway — the first branded residence in the
            region associated with a global couture house. Every apartment is designed to
            feel like a standalone residence: private lift lobbies, entry foyers, corner
            orientations, and panoramic balconies framing the Noida skyline and green
            reserves. The architecture draws on Elie Saab's couture vocabulary — soft
            verticality, light-filtering facades, ivory and rose-gold interiors, and a
            muted palette that mirrors the brand's atelier aesthetic.
          </p>
          <h3>Design Intent</h3>
          <p>
            Elie Saab's involvement extends from lobby design to signature detailing on
            entrance doors, fittings, and shared spaces — a full-envelope branded
            experience rather than a name-licensing exercise. Interiors are delivered in
            a restrained couture palette, with premium imported fittings, large-format
            stone, and a curated finishing package.
          </p>
          <h3>Who It's For</h3>
          <p>
            The project is aimed at end-users and long-horizon HNI buyers seeking a
            primary or second residence in NCR with a recognisable global brand
            association — a segment currently underserved in Noida, historically dominated
            by unbranded luxury inventory.
          </p>
          <h3>Key Investment Considerations</h3>
          <p>
            Limited supply (approximately 496 units), a tight 3 BHK / 4 BHK-only mix, a
            6.5-acre low-density parcel, and direct Expressway frontage are the structural
            factors behind the project's positioning. Prospective buyers should verify
            all details on the official sale agreement and the RERA public portal before
            booking.
          </p>
        </div>
      </details>
    </div>

    <div class="reveal">
      <span class="eyebrow">Project Facts</span>
      <h2>Specifications Table</h2>
      <table class="facts-table">
        <tbody>
          <tr><th>Project Name</th><td>Smartworld Elie Saab Residences</td></tr>
          <tr><th>Developer</th><td>Smart World Developers (with M3M India &amp; Elie Saab)</td></tr>
          <tr><th>Location</th><td>Sector 98, Noida Expressway, UP 201303</td></tr>
          <tr><th>Land Area</th><td>6.5 Acres</td></tr>
          <tr><th>Towers</th><td>4</td></tr>
          <tr><th>Floors</th><td>G+32 each</td></tr>
          <tr><th>Total Units</th><td>~496</td></tr>
          <tr><th>Units Per Floor</th><td>4 (low density)</td></tr>
          <tr><th>Configurations</th><td>3 BHK &amp; 4 BHK</td></tr>
          <tr><th>3 BHK Size</th><td>~2,800–3,400 sq ft</td></tr>
          <tr><th>4 BHK Size</th><td>~3,800–4,500 sq ft</td></tr>
          <tr><th>Starting Price</th><td>₹8 Cr onwards</td></tr>
          <tr><th>Payment Plan</th><td>20:30:50</td></tr>
          <tr><th>Possession</th><td>Tentative 2029–2031</td></tr>
          <tr><th>RERA</th><td><?= htmlspecialchars($projectRera) ?></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- [6] RESIDENCES & PRICING                                       -->
<!-- ============================================================ -->
<section id="residences">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Residences</span>
      <h2>Two Configurations, Endless Detail</h2>
      <p>Every floor holds only four residences. Every residence is detailed at couture level. Both configurations feature private lift lobbies, deep balconies, and panoramic glazing.</p>
    </div>

    <div class="residences-grid">
      <article class="res-card reveal">
        <span class="eyebrow">Configuration 01</span>
        <h3>3 BHK Residence</h3>
        <p class="spec">Approximately 2,800 – 3,400 sq ft · 3 bed · 4 bath · servant</p>
        <div class="price">₹8 Cr<span style="font-size:14px; letter-spacing:0.1em; color:var(--text-mid-dark); margin-left:8px;">onwards</span></div>
        <ul>
          <li>Typology <strong>3 BHK + Servant</strong></li>
          <li>Units Per Floor <strong>4</strong></li>
          <li>Facing <strong>Corner / Park / Expressway</strong></li>
          <li>Entry <strong>Private Lift Lobby</strong></li>
          <li>Balconies <strong>Deep · Panoramic</strong></li>
        </ul>
        <a href="#hero" class="btn">Get 3 BHK Details</a>
      </article>

      <article class="res-card reveal">
        <span class="eyebrow">Configuration 02</span>
        <h3>4 BHK Residence</h3>
        <p class="spec">Approximately 3,800 – 4,500 sq ft · 4 bed · 5 bath · servant</p>
        <div class="price">₹11 Cr<span style="font-size:14px; letter-spacing:0.1em; color:var(--text-mid-dark); margin-left:8px;">onwards</span></div>
        <ul>
          <li>Typology <strong>4 BHK + Servant</strong></li>
          <li>Units Per Floor <strong>4</strong></li>
          <li>Facing <strong>Corner · Double-Height Lobby</strong></li>
          <li>Entry <strong>Private Lift Lobby</strong></li>
          <li>Balconies <strong>Wrap-Around · Premium</strong></li>
        </ul>
        <a href="#hero" class="btn">Get 4 BHK Details</a>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- [7] FLOOR PLANS                                                -->
<!-- ============================================================ -->
<section id="floor-plans" class="section-alt">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Floor Plans</span>
      <h2>Master Plan &amp; Typologies</h2>
      <p>Request the detailed floor plate PDF after enquiry — dimensions shown in marketing collateral are indicative and subject to final approval.</p>
    </div>

    <div class="fp-tabs reveal" role="tablist">
      <button class="fp-tab is-active" data-target="fp-master" type="button">Master Plan</button>
      <button class="fp-tab" data-target="fp-3bhk" type="button">3 BHK</button>
      <button class="fp-tab" data-target="fp-4bhk" type="button">4 BHK</button>
    </div>

    <div id="fp-master" class="fp-panel is-active">
      <div class="fp-image">Master Plan — Request for Detailed PDF</div>
      <div>
        <h3>6.5-Acre Master Plan</h3>
        <p>
          The masterplan lays four G+32 towers across 6.5 acres with a central landscape
          spine, clubhouse podium, and perimeter landscaped gardens. Roughly 70 percent
          of the parcel is reserved for open and green space.
        </p>
        <a href="#hero" class="btn">Request Master Plan</a>
      </div>
    </div>

    <div id="fp-3bhk" class="fp-panel">
      <div class="fp-image">3 BHK Floor Plate — Available On Enquiry</div>
      <div>
        <h3>3 BHK Typology</h3>
        <p>
          3 BHK floor plates range approximately 2,800 to 3,400 sq ft with private lift
          lobbies, 4 units per floor, deep balconies, and a separate servant entry.
        </p>
        <a href="#hero" class="btn">Request 3 BHK Plan</a>
      </div>
    </div>

    <div id="fp-4bhk" class="fp-panel">
      <div class="fp-image">4 BHK Floor Plate — Available On Enquiry</div>
      <div>
        <h3>4 BHK Typology</h3>
        <p>
          4 BHK floor plates range approximately 3,800 to 4,500 sq ft, positioned as
          corner residences with double-aspect glazing, wrap-around balconies, and
          premium couture-inspired interiors.
        </p>
        <a href="#hero" class="btn">Request 4 BHK Plan</a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- [8] AMENITIES                                                  -->
<!-- ============================================================ -->
<section id="amenities">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Amenities</span>
      <h2>A One-Lakh Sq Ft Clubhouse. Sixteen Curated Experiences.</h2>
      <p>Every amenity on the masterplan is designed to feel residential, not civic — intimate lounges, quiet wellness studios, and private outdoor rooms.</p>
    </div>

    <div class="amenities-grid reveal">
      <div class="amenity">
        <span class="num">01</span>
        <h3>One-Lakh Sq Ft Clubhouse</h3>
        <p>Double-height arrival lobby, lounges, and private dining rooms.</p>
      </div>
      <div class="amenity">
        <span class="num">02</span>
        <h3>Infinity Pool &amp; Spa</h3>
        <p>Temperature-controlled infinity pool with spa and thermal suite.</p>
      </div>
      <div class="amenity">
        <span class="num">03</span>
        <h3>Concierge Service</h3>
        <p>Resident concierge desk for bookings, logistics, and hospitality.</p>
      </div>
      <div class="amenity">
        <span class="num">04</span>
        <h3>Yoga &amp; Meditation</h3>
        <p>Dedicated yoga pavilion and a quiet meditation garden.</p>
      </div>
      <div class="amenity">
        <span class="num">05</span>
        <h3>Tennis &amp; Sports</h3>
        <p>Tennis court, jogging track, and outdoor fitness zones.</p>
      </div>
      <div class="amenity">
        <span class="num">06</span>
        <h3>Landscape &amp; Gardens</h3>
        <p>Deep landscaped gardens wrapping the podium and perimeter.</p>
      </div>
    </div>

    <details class="disclose">
      <summary>View The Full Amenities List (15+)</summary>
      <div class="disclose-body">
        <ul class="amenity-list">
          <li>1 lakh sq ft clubhouse</li>
          <li>Infinity swimming pool</li>
          <li>Spa &amp; thermal suite</li>
          <li>Yoga pavilion</li>
          <li>24x7 concierge service</li>
          <li>Tennis court</li>
          <li>Meditation garden</li>
          <li>Co-working lounge</li>
          <li>Landscaped gardens</li>
          <li>Rainwater harvesting</li>
          <li>Solar panels</li>
          <li>Jogging track</li>
          <li>Kids play zone</li>
          <li>Banquet hall</li>
          <li>Private library</li>
          <li>Private dining rooms</li>
        </ul>
      </div>
    </details>
  </div>
</section>

<!-- ============================================================ -->
<!-- [9] LIFESTYLE STRIP                                            -->
<!-- ============================================================ -->
<section class="lifestyle" aria-labelledby="lifestyleHead">
  <div class="container">
    <span class="eyebrow">The Lifestyle</span>
    <h2 id="lifestyleHead">A Private Address Where Every Hour Is Couture.</h2>
    <p>Mornings in the meditation garden. Afternoons in the private library.
       Evenings by the infinity pool with the Noida skyline at dusk. An
       editorial life, authored in ivory and champagne.</p>
  </div>
</section>

<!-- ============================================================ -->
<!-- [10] LOCATION & CONNECTIVITY                                   -->
<!-- ============================================================ -->
<section id="location" class="section-alt">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Location</span>
      <h2>Sector 98, Noida Expressway</h2>
      <p>A central Noida address positioned near the Noida Golf Course, Botanical Garden Metro on the Aqua Line, and direct access to South Delhi via the DND Flyway.</p>
    </div>

    <div class="location-grid">
      <div class="location-map reveal">
        <iframe
          src="https://maps.google.com/maps?q=Sector%2098%2C%20Noida&t=&z=14&ie=UTF8&iwloc=&output=embed"
          loading="lazy"
          title="Smartworld Elie Saab Residences — Sector 98, Noida"></iframe>
      </div>

      <div class="reveal">
        <ul class="location-list">
          <li>Noida Golf Course <strong>950 m</strong></li>
          <li>World Trade Tower <strong>~3.5 km</strong></li>
          <li>Ryan International School <strong>1.8 km</strong></li>
          <li>Botanical Garden Metro (Aqua Line) <strong>~12 min</strong></li>
          <li>DLF Mall of India <strong>~12 min</strong></li>
          <li>IGI Airport (via DND Flyway) <strong>~30 min</strong></li>
          <li>Jewar International Airport <strong>~45 min</strong></li>
        </ul>

        <details class="disclose">
          <summary>Full Connectivity Overview</summary>
          <div class="disclose-body">
            <p>
              Sector 98 sits on the Noida Expressway corridor, one of NCR's most
              developed real-estate stretches. The project enjoys direct access to
              South Delhi via the DND Flyway (IGI Airport reachable in around 30
              minutes off-peak) and to Greater Noida and the upcoming Jewar (Noida
              International) Airport via the Expressway itself (~45 minutes).
              Botanical Garden Metro on the Aqua Line anchors public transit
              connectivity; Noida Golf Course is under a kilometre away, and World
              Trade Tower — the commercial spine of central Noida — is within 3.5
              kilometres. Schools, hospitals, and retail (DLF Mall of India) are all
              within a 12-minute drive.
            </p>
          </div>
        </details>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- [11] PAYMENT PLAN                                              -->
<!-- ============================================================ -->
<section id="payment">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Payment Plan</span>
      <h2>A Transparent 20 : 30 : 50 Schedule</h2>
      <p>Primary payment plan — simple, milestone-driven, and aligned to construction progress. Final terms as per the sale agreement.</p>
    </div>
    <div class="timeline reveal">
      <div class="tl-step">
        <span class="percent">20%</span>
        <h3>On Booking</h3>
        <p>Initial commitment on application and allotment letter.</p>
      </div>
      <div class="tl-step">
        <span class="percent">30%</span>
        <h3>During Construction</h3>
        <p>Across defined milestones as construction progresses on site.</p>
      </div>
      <div class="tl-step">
        <span class="percent">50%</span>
        <h3>On Possession</h3>
        <p>Balance payable at the time of handover and registration.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- [12] GALLERY                                                   -->
<!-- ============================================================ -->
<section id="gallery" class="section-alt">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Gallery</span>
      <h2>Renders &amp; Atelier References</h2>
      <p>A preview of the masterplan, couture interiors, and lifestyle moments. Full architectural brochure on enquiry.</p>
    </div>

    <div class="gallery-grid reveal">
      <a href="images/bannerdesk.webp" data-lightbox="gallery" data-alt="Tower facade render"><img src="images/bannerdesk.webp" alt="Smartworld Elie Saab tower facade" loading="lazy"></a>
      <a href="images/banner-1.webp" data-lightbox="gallery" data-alt="Lobby render"><img src="images/banner-1.webp" alt="Couture-inspired arrival lobby" loading="lazy"></a>
      <a href="images/banner3.webp" data-lightbox="gallery" data-alt="Amenity deck"><img src="images/banner3.webp" alt="Amenity deck and pool" loading="lazy"></a>
      <a href="images/location.webp" data-lightbox="gallery" data-alt="Location plan"><img src="images/location.webp" alt="Location plan Sector 98 Noida" loading="lazy"></a>
      <a href="images/tab-banner-1.webp" data-lightbox="gallery" data-alt="Landscape podium"><img src="images/tab-banner-1.webp" alt="Landscape podium render" loading="lazy"></a>
      <a href="images/mob.webp" data-lightbox="gallery" data-alt="Skyline view"><img src="images/mob.webp" alt="Noida skyline view" loading="lazy"></a>
    </div>
  </div>
</section>

<div id="lightbox" class="lightbox" aria-hidden="true">
  <button id="lightboxClose" class="lightbox-close" type="button" aria-label="Close">×</button>
  <img id="lightboxImg" src="" alt="">
</div>

<!-- ============================================================ -->
<!-- [13] ABOUT DEVELOPER                                           -->
<!-- ============================================================ -->
<section id="developer">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Developer &amp; Brand</span>
      <h2>Smart World · M3M India · Elie Saab</h2>
    </div>

    <div class="dev-grid">
      <div class="reveal">
        <p>
          Smartworld Elie Saab Residences is the result of a three-way
          collaboration. Smart World Developers leads development and delivery,
          M3M India partners as investment and execution collaborator, and
          Beirut-headquartered couture house Elie Saab lends its brand, design
          vocabulary, and envelope detailing. Together, the partnership sets out
          to deliver Noida's first truly branded couture residence.
        </p>

        <details class="disclose">
          <summary>Read The Full Developer Story</summary>
          <div class="disclose-body">
            <p>
              <strong>Smart World Developers</strong> is a Gurugram-headquartered
              real-estate developer with a growing portfolio of luxury residential
              communities across NCR. The company focuses on large-format, premium
              gated residences with high landscape ratios and well-specified
              common areas.
            </p>
            <p>
              <strong>M3M India</strong> joins as an execution partner. M3M has a
              long track record of delivering premium and branded projects across
              Gurugram, Noida, and the wider NCR region, and brings in experience
              in large-format launches and international brand associations.
            </p>
            <p>
              <strong>Elie Saab</strong> is an internationally recognised fashion
              and couture house founded in Beirut. Its design vocabulary — soft
              ivory tones, champagne gold, light-filtering fabrics, and restrained
              ornament — is translated into the architecture, interiors and
              detailing of the residences.
            </p>
          </div>
        </details>
      </div>

      <div class="dev-brands reveal">
        <div class="dev-brand">
          <span class="label">Developer</span>
          <h4>Smart World</h4>
        </div>
        <div class="dev-brand">
          <span class="label">Association</span>
          <h4>M3M India</h4>
        </div>
        <div class="dev-brand">
          <span class="label">Branded By</span>
          <h4>Elie Saab</h4>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- [14] FAQ                                                       -->
<!-- ============================================================ -->
<section id="faq" class="section-alt">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">Frequently Asked</span>
      <h2>Everything You Should Know Before Booking</h2>
      <p>Answers to the most common questions about pricing, configurations, RERA, possession, and amenities.</p>
    </div>

    <div class="faq reveal">
      <details>
        <summary>What is the price of Smartworld Elie Saab Residences in Sector 98 Noida?</summary>
        <div class="faq-body">Smartworld Elie Saab Residences are priced from ₹8 Crore onwards for a 3 BHK apartment. The full range is approximately ₹8–12.4 Crore depending on unit size, tower, and floor.</div>
      </details>
      <details>
        <summary>What configurations are available at Smartworld Elie Saab?</summary>
        <div class="faq-body">Smartworld Elie Saab Residences offers 3 BHK and 4 BHK apartments only. 3 BHK units range approximately 2,800–3,400 sq ft and 4 BHK units range approximately 3,800–4,500 sq ft.</div>
      </details>
      <details>
        <summary>What is the RERA number for Smartworld Elie Saab Residences?</summary>
        <div class="faq-body">The RERA registration number is <strong><?= htmlspecialchars($projectRera) ?></strong>, registered with the Uttar Pradesh Real Estate Regulatory Authority.</div>
      </details>
      <details>
        <summary>When is the possession date for Smartworld Elie Saab?</summary>
        <div class="faq-body">The tentative possession timeline is 2029–2031. The possession date is indicative and subject to change as per the developer's construction schedule.</div>
      </details>
      <details>
        <summary>How many towers are there in Smartworld Elie Saab?</summary>
        <div class="faq-body">The project consists of 4 towers, each planned as G+32 floors, with approximately 496 total residences across a 6.5-acre low-density layout of 4 units per floor.</div>
      </details>
      <details>
        <summary>Who is the developer of Elie Saab Residences Noida?</summary>
        <div class="faq-body">The project is developed by Smart World Developers in association with M3M India and the couture house Elie Saab, which provides the branded residential identity and design direction.</div>
      </details>
      <details>
        <summary>Where exactly is Smartworld Elie Saab located?</summary>
        <div class="faq-body">Sector 98, Noida Expressway, Gautam Buddha Nagar, Uttar Pradesh 201303. It is close to Noida Golf Course, Botanical Garden Metro on the Aqua Line, and the DND Flyway to South Delhi.</div>
      </details>
      <details>
        <summary>What is the size of a 3 BHK at Smartworld Elie Saab?</summary>
        <div class="faq-body">3 BHK residences are approximately 2,800 to 3,400 sq ft, with 4 residences per floor, private lift lobbies, deep balconies, and corner configurations.</div>
      </details>
      <details>
        <summary>What is the size of a 4 BHK at Smartworld Elie Saab?</summary>
        <div class="faq-body">4 BHK residences range approximately 3,800 to 4,500 sq ft and include private lift lobbies, large balconies, and premium couture-inspired interiors.</div>
      </details>
      <details>
        <summary>What amenities are offered at Smartworld Elie Saab?</summary>
        <div class="faq-body">A 1 lakh sq ft clubhouse, infinity pool, spa, yoga pavilion, concierge service, tennis court, meditation garden, co-working lounge, landscaped gardens, rainwater harvesting, solar panels, jogging track, kids play zone, banquet hall, and private library.</div>
      </details>
      <details>
        <summary>What is the payment plan for Smartworld Elie Saab?</summary>
        <div class="faq-body">The primary plan is a 20:30:50 schedule — 20% on booking, 30% during construction milestones, and 50% on possession. Exact terms should be verified on the sale agreement.</div>
      </details>
      <details>
        <summary>How far is Smartworld Elie Saab from the metro and airport?</summary>
        <div class="faq-body">Botanical Garden Metro (Aqua Line) is approximately 12 minutes away, Noida Golf Course is 950 metres, IGI Airport is around 30 minutes via the DND Flyway, and the upcoming Jewar International Airport is about 45 minutes away.</div>
      </details>
      <details>
        <summary>Are 2 BHK apartments available at Smartworld Elie Saab?</summary>
        <div class="faq-body">No. Smartworld Elie Saab Residences does not offer 2 BHK units. The project is exclusively designed for 3 BHK and 4 BHK luxury residences.</div>
      </details>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- [15] SEO LONG-FORM                                             -->
<!-- ============================================================ -->
<section id="about-project">
  <div class="container">
    <div class="section-head reveal">
      <span class="eyebrow">About The Project</span>
      <h2>Smartworld Elie Saab Residences — Sector 98 Noida</h2>
    </div>
    <div class="reveal" style="max-width: 900px;">
      <p>
        Smartworld Elie Saab Residences is a 6.5-acre ultra-luxury branded
        residential development in Sector 98, Noida, delivered by Smart World
        Developers in association with M3M India and couture house Elie Saab.
        The project features four G+32 towers with approximately 496 apartments,
        a low-density layout of four residences per floor, and 3 BHK and 4 BHK
        configurations ranging from approximately 2,800 to 4,500 sq ft. Priced
        from ₹8 Crore onwards with a 20:30:50 payment plan and registered under
        RERA <?= htmlspecialchars($projectRera) ?>, Smartworld Elie Saab targets
        a tentative possession window of 2029–2031 and anchors its lifestyle
        around a 1 lakh sq ft clubhouse and signature amenities.
      </p>

      <details class="disclose">
        <summary>Read The Full Project Guide (800+ Words)</summary>
        <div class="disclose-body">
          <h3>Location — Sector 98, Noida Expressway</h3>
          <p>
            Smartworld Elie Saab Residences is located in Sector 98, one of the
            most mature sectors along the Noida Expressway. The stretch is
            characterised by established gated residential communities, premium
            commercial towers (including World Trade Tower within 3.5 km), and
            strong social infrastructure. The project sits 950 metres from Noida
            Golf Course, within a short drive of Botanical Garden Metro on the
            Aqua Line, and enjoys direct access to the DND Flyway for connectivity
            to South Delhi and Connaught Place. IGI Airport is reachable in around
            30 minutes off-peak, while the upcoming Jewar International Airport is
            accessible via the Noida Expressway in roughly 45 minutes. Ryan
            International School is 1.8 km away, and DLF Mall of India is
            approximately 12 minutes by road.
          </p>

          <h3>Architecture &amp; Design</h3>
          <p>
            The architectural concept is authored by Elie Saab's design team in
            collaboration with Smart World's internal studios. Four G+32 towers
            are placed across the 6.5-acre parcel with generous setbacks, a
            central clubhouse podium, and layered landscaping reserved across the
            perimeter. The facades reference the house's couture signature —
            vertical fluting, light-filtering screens, and a muted ivory and
            champagne gold palette. Residences open onto deep balconies framing
            the Expressway skyline and the green reserves of central Noida, with
            full-height glazing, private lift lobbies, and couture-finish lobbies.
          </p>

          <h3>Residence Configurations</h3>
          <p>
            Two typologies define the project: 3 BHK residences at approximately
            2,800–3,400 sq ft, and 4 BHK residences at approximately 3,800–4,500
            sq ft. Every floor holds only four residences, ensuring corner
            exposure, cross ventilation, and a genuine sense of privacy.
            Apartments are delivered with a premium couture finishing package,
            imported sanitaryware and fittings, modular kitchens, wardrobes, and
            VRV-ready air-conditioning in living areas and bedrooms.
          </p>

          <h3>Amenities &amp; Clubhouse</h3>
          <p>
            The centrepiece of the masterplan is a 1 lakh sq ft clubhouse
            designed as a collection of intimate, residential rooms rather than a
            single civic hall. Inside, residents have access to a temperature-
            controlled infinity pool, spa and thermal suite, yoga and meditation
            pavilions, a private library, banquet hall, co-working lounge, and
            private dining rooms. Outdoor amenities include a tennis court,
            jogging track, landscaped gardens, a kids play zone, and a meditation
            garden. A 24x7 concierge desk coordinates bookings, logistics, and
            guest hospitality for residents.
          </p>

          <h3>Sustainability</h3>
          <p>
            The project integrates rainwater harvesting, rooftop solar panels for
            common-area loads, low-flow fixtures, and extensive landscape areas
            for passive cooling. Construction practices target IGBC-aligned
            standards across the development.
          </p>

          <h3>Pricing &amp; Payment</h3>
          <p>
            Prices start from ₹8 Crore onwards for a 3 BHK, with 4 BHK
            residences typically in the ₹11 Crore+ range. The full spread is
            approximately ₹8 to ₹12.4 Crore depending on tower, floor, and
            facing. The headline payment plan is a clean 20:30:50 — 20% on
            booking, 30% across construction milestones, and 50% on possession.
            Terms and conditions apply and are governed by the final sale
            agreement and the RERA-registered documentation.
          </p>

          <h3>About The Developer &amp; Brand</h3>
          <p>
            Smart World Developers is a Gurugram-headquartered real-estate
            company focused on premium, large-format residential communities. For
            this project, Smart World partners with M3M India — one of NCR's
            largest luxury developers with experience in international brand
            associations — and with Elie Saab, the Beirut couture house that
            lends its name, design vocabulary, and branded detailing to the
            residences.
          </p>

          <h3>RERA &amp; Legal</h3>
          <p>
            The project is registered under RERA
            <?= htmlspecialchars($projectRera) ?> with the Uttar Pradesh Real
            Estate Regulatory Authority. Prospective buyers are encouraged to
            verify registration details, sanctioned plans, and construction
            progress on the UP RERA public portal before booking. All prices,
            areas, and specifications mentioned on this website are indicative
            and subject to the final executed agreement.
          </p>

          <h3>Neighbourhood &amp; Why Sector 98</h3>
          <p>
            Sector 98 is one of the most established residential pockets along
            the Noida Expressway. Its position — close to the Noida Golf Course,
            within 3.5 km of the World Trade Tower commercial belt, and within a
            12-minute drive of Botanical Garden Metro and DLF Mall of India —
            places it at the intersection of premium living and urban access.
            For HNI end-users seeking a primary or secondary NCR residence, this
            stretch offers the strongest combination of social infrastructure,
            connectivity, and future capital appreciation.
          </p>
        </div>
      </details>
    </div>
  </div>
</section>

<!-- ============================================================ -->
<!-- [16] FINAL CTA                                                 -->
<!-- ============================================================ -->
<section class="final-cta" id="final-cta">
  <div class="container">
    <div class="section-head center reveal" style="margin-left:auto; margin-right:auto;">
      <span class="eyebrow">Private Viewing</span>
      <h2>Reserve A Private Preview</h2>
      <p>Join the priority list to receive the detailed price sheet, floor plans, and private walk-through invitation.</p>
    </div>

    <div class="cta-actions reveal">
      <a href="tel:<?= htmlspecialchars($phoneLink) ?>" class="btn btn-solid">Call <?= htmlspecialchars($phone) ?></a>
      <a href="https://wa.me/<?= htmlspecialchars($waNumber) ?>" target="_blank" rel="noopener" class="btn">WhatsApp Us</a>
    </div>

    <form action="process-form.php" method="POST" data-ajax="true" class="reveal" novalidate>
      <div class="form-row-2">
        <div class="form-field">
          <label for="ctaName">Name</label>
          <input type="text" id="ctaName" name="name" placeholder="Your full name" required>
        </div>
        <div class="form-field">
          <label for="ctaPhone">Phone</label>
          <input type="tel" id="ctaPhone" name="phone" placeholder="10-digit mobile" required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}" title="Please enter a valid 10-digit Indian mobile number">
        </div>
      </div>
      <div class="form-row-2">
        <div class="form-field">
          <label for="ctaEmail">Email</label>
          <input type="email" id="ctaEmail" name="email" placeholder="you@example.com" required>
        </div>
        <div class="form-field">
          <label for="ctaInterest">Interested In</label>
          <select id="ctaInterest" name="interested_in">
            <option value="3 BHK">3 BHK Residence</option>
            <option value="4 BHK">4 BHK Residence</option>
            <option value="Both">Both Configurations</option>
            <option value="Floor Plan">Floor Plan</option>
          </select>
        </div>
      </div>
      <input type="hidden" name="form_source" value="final_cta_form">
      <button type="submit" class="btn btn-solid btn-block">Request Private Preview</button>
      <p class="form-consent">
        By submitting this form, you consent to be contacted regarding Smartworld Elie Saab Residences.
        RERA <?= htmlspecialchars($projectRera) ?>.
      </p>
      <div class="form-status" role="status" aria-live="polite"></div>
    </form>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script src="js/main.js"></script>
</body>
</html>
