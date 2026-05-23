<?php
// M3M Jewel Crest Avenue — RETAIL ONLY landing page
$year = date('Y');
$phone = '9412-234-688';
$phoneTel = '+919412234688';
$siteUrl = 'https://jewelcrestavenue.com/';
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>M3M Jewel Crest Avenue, Sector 97 Noida | Luxury Retail</title>
  <meta name="description" content="M3M Jewel Crest Avenue — ~6-acre luxury retail, F&B and food court on the Noida Expressway, Sector 97 Noida. G+3 block, 680 ft frontage, starting ₹29,000/sq ft. RERA UPRERAPRJ690055/10/2025. Possession July 2030. Commercial only.">
  <meta name="keywords" content="M3M Jewel Crest Avenue, M3M Jewel Crest Avenue Sector 97 Noida, M3M Jewel Crest Avenue retail price per sq ft, M3M Jewel Crest Avenue RERA, M3M Jewel Crest Avenue Food Court, M3M retail Noida, high street retail Sector 97 Noida, Noida Expressway retail shops, M3M India Noida commercial, G+3 retail block Noida">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <meta name="author" content="M3M Jewel Crest Avenue — Authorized Channel Partner">

  <link rel="canonical" href="<?= $siteUrl ?>">
  <link rel="icon" href="favicon.ico" type="image/x-icon">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="M3M Jewel Crest Avenue">
  <meta property="og:title" content="M3M Jewel Crest Avenue, Sector 97 Noida | Luxury Retail">
  <meta property="og:description" content="Luxury high-street retail + F&B + food court by M3M India in Sector 97 Noida. ~6 acres, 680 ft frontage, G+3, starting ₹29,000/sq ft. Commercial only.">
  <meta property="og:url" content="<?= $siteUrl ?>">
  <meta property="og:image" content="<?= $siteUrl ?>img/banners/banner1.webp">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="M3M Jewel Crest Avenue, Sector 97 Noida">
  <meta name="twitter:description" content="Luxury high-street retail + F&B + food court by M3M India. Starting ₹29,000/sq ft. Commercial only.">
  <meta name="twitter:image" content="<?= $siteUrl ?>img/banners/banner1.webp">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,500&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/styles.css?v=2">

  <!-- Schema: LocalBusiness / ShoppingCenter -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ShoppingCenter",
    "@id": "<?= $siteUrl ?>#project",
    "name": "M3M Jewel Crest Avenue",
    "alternateName": "M3M Jewel Crest Avenue Sector 97 Noida",
    "description": "M3M Jewel Crest Avenue is a ~6-acre luxury high-street retail, F&B and food court destination by M3M India in Sector 97, Noida, on the Noida–Greater Noida Expressway. G+3 single retail block with 207m/680ft three-side open frontage and atrium-led circulation. Commercial only — not residential. RERA UPRERAPRJ690055/10/2025. Possession July 2030.",
    "url": "<?= $siteUrl ?>",
    "image": ["<?= $siteUrl ?>img/banners/banner1.webp","<?= $siteUrl ?>img/overview.webp","<?= $siteUrl ?>img/highlight.webp"],
    "telephone": "<?= $phoneTel ?>",
    "priceRange": "₹29,000 – ₹60,000 / sq ft",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Sector 97, Noida–Greater Noida Expressway",
      "addressLocality": "Noida",
      "addressRegion": "Uttar Pradesh",
      "postalCode": "201304",
      "addressCountry": "IN"
    },
    "geo": { "@type": "GeoCoordinates", "latitude": "28.5069", "longitude": "77.3946" },
    "areaServed": "Delhi NCR",
    "brand": { "@type": "Organization", "name": "M3M India" },
    "makesOffer": [
      { "@type": "Offer", "name": "Ground Floor Flagship Store", "priceCurrency": "INR", "price": "60000", "description": "Starting price per sq ft for triple-height flagship stores on the ground floor." },
      { "@type": "Offer", "name": "Ground Floor (standard)",     "priceCurrency": "INR", "price": "47000", "description": "Starting price per sq ft for standard ground floor retail." },
      { "@type": "Offer", "name": "Upper Ground Floor",          "priceCurrency": "INR", "price": "39000", "description": "Starting price per sq ft on the Upper Ground Floor." },
      { "@type": "Offer", "name": "Second Floor",                "priceCurrency": "INR", "price": "35000", "description": "Starting price per sq ft on the Second Floor." },
      { "@type": "Offer", "name": "Third Floor Food Court",      "priceCurrency": "INR", "price": "34000", "description": "Starting price per sq ft for third-floor food court kiosks." },
      { "@type": "Offer", "name": "Third Floor Restaurants",     "priceCurrency": "INR", "price": "29000", "description": "Starting price per sq ft for third-floor fine-dining restaurants." }
    ],
    "additionalProperty": [
      { "@type": "PropertyValue", "name": "Project Area",   "value": "~6 acres" },
      { "@type": "PropertyValue", "name": "Frontage",       "value": "207 m (680 ft)" },
      { "@type": "PropertyValue", "name": "Structure",      "value": "G+3 single retail block" },
      { "@type": "PropertyValue", "name": "Layout",         "value": "Three-side open, atrium-led" },
      { "@type": "PropertyValue", "name": "Payment Plan",   "value": "50:50" },
      { "@type": "PropertyValue", "name": "Possession",     "value": "July 2030" },
      { "@type": "PropertyValue", "name": "RERA Number",    "value": "UPRERAPRJ690055/10/2025" },
      { "@type": "PropertyValue", "name": "Starting Ticket","value": "₹65 Lacs onwards" },
      { "@type": "PropertyValue", "name": "Asset Type",     "value": "Commercial Retail (High-Street + F&B + Food Court)" }
    ]
  }
  </script>

  <!-- Schema: Organization (M3M India) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "@id": "https://m3mproperties.com/#org",
    "name": "M3M India",
    "legalName": "M3M India Private Limited",
    "foundingDate": "2010",
    "founder": [
      { "@type": "Person", "name": "Basant Bansal" },
      { "@type": "Person", "name": "Roop Kumar Bansal" },
      { "@type": "Person", "name": "Pankaj Bansal" }
    ],
    "url": "https://m3mproperties.com/",
    "description": "M3M India is a leading Delhi NCR real-estate developer, founded in 2010, with a portfolio of luxury residential and high-street retail / commercial projects across Gurugram and Noida."
  }
  </script>

  <!-- Schema: Breadcrumbs -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
      { "@type": "ListItem", "position": 1, "name": "Home", "item": "<?= $siteUrl ?>" },
      { "@type": "ListItem", "position": 2, "name": "Commercial", "item": "<?= $siteUrl ?>#pricing" },
      { "@type": "ListItem", "position": 3, "name": "Noida", "item": "<?= $siteUrl ?>#location" },
      { "@type": "ListItem", "position": 4, "name": "Sector 97", "item": "<?= $siteUrl ?>#location" },
      { "@type": "ListItem", "position": 5, "name": "M3M Jewel Crest Avenue", "item": "<?= $siteUrl ?>" }
    ]
  }
  </script>

  <!-- Schema: FAQ -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      { "@type": "Question", "name": "What is the price per sq ft at M3M Jewel Crest Avenue?", "acceptedAnswer": { "@type": "Answer", "text": "Starting prices per sq ft are: Ground Floor Flagship ₹60,000, Ground Floor ₹47,000, Upper Ground Floor ₹39,000, 2nd Floor ₹35,000, 3rd Floor Food Court ₹34,000, and 3rd Floor Restaurants ₹29,000. The headline starting price is ₹29,000/sq ft." } },
      { "@type": "Question", "name": "What is the RERA number for M3M Jewel Crest Avenue?", "acceptedAnswer": { "@type": "Answer", "text": "The UP RERA registration number for the retail component of M3M Jewel Crest Avenue is UPRERAPRJ690055/10/2025." } },
      { "@type": "Question", "name": "When is the possession of M3M Jewel Crest Avenue?", "acceptedAnswer": { "@type": "Answer", "text": "Possession is scheduled for July 2030 as per the developer." } },
      { "@type": "Question", "name": "Is M3M Jewel Crest Avenue a residential or commercial project?", "acceptedAnswer": { "@type": "Answer", "text": "M3M Jewel Crest Avenue is a COMMERCIAL retail project — high-street retail, F&B and a food court. It does not contain apartments, BHKs or residences." } },
      { "@type": "Question", "name": "What is the starting ticket size at M3M Jewel Crest Avenue?", "acceptedAnswer": { "@type": "Answer", "text": "The starting ticket size is ₹65 Lacs onwards. Final ticket depends on floor, unit size and location within the block." } },
      { "@type": "Question", "name": "How many floors does M3M Jewel Crest Avenue have?", "acceptedAnswer": { "@type": "Answer", "text": "M3M Jewel Crest Avenue is a single G+3 retail block — Ground Floor, Upper Ground Floor, Second Floor and Third Floor (restaurants and food court)." } },
      { "@type": "Question", "name": "What is the frontage of M3M Jewel Crest Avenue?", "acceptedAnswer": { "@type": "Answer", "text": "The project has a 207-metre (approximately 680-foot) three-side open frontage on the Noida–Greater Noida Expressway." } },
      { "@type": "Question", "name": "Is there a food court at M3M Jewel Crest Avenue?", "acceptedAnswer": { "@type": "Answer", "text": "Yes. The third floor features a dedicated food court (starting ₹34,000/sq ft) alongside fine-dining restaurants (starting ₹29,000/sq ft)." } },
      { "@type": "Question", "name": "Who is the developer of M3M Jewel Crest Avenue?", "acceptedAnswer": { "@type": "Answer", "text": "The developer is M3M India Private Limited, founded in 2010 by Basant, Roop and Pankaj Bansal, one of the largest real-estate groups in Delhi NCR." } },
      { "@type": "Question", "name": "What is the payment plan at M3M Jewel Crest Avenue?", "acceptedAnswer": { "@type": "Answer", "text": "A simple 50:50 plan — 50% at booking and 50% near possession (July 2030)." } },
      { "@type": "Question", "name": "Where is M3M Jewel Crest Avenue located?", "acceptedAnswer": { "@type": "Answer", "text": "Sector 97, Noida, directly on the Noida–Greater Noida Expressway in Gautam Buddha Nagar, Uttar Pradesh. Noida City Center is ~20 minutes away and Sector 18 Atta Market is ~15 minutes." } },
      { "@type": "Question", "name": "What is the distance from M3M Jewel Crest Avenue to Jewar Airport?", "acceptedAnswer": { "@type": "Answer", "text": "Noida International Airport at Jewar is approximately 30–40 minutes by road. IGI Airport / Dwarka is 30–45 minutes via the Noida Expressway." } },
      { "@type": "Question", "name": "Is M3M Jewel Crest Avenue the same as M3M Jacob & Co Residences?", "acceptedAnswer": { "@type": "Answer", "text": "No. M3M Jewel Crest Avenue is a separate COMMERCIAL retail project. The Jacob & Co Residences is a different, residential project by M3M and is not sold on this site." } }
    ]
  }
  </script>
</head>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<!-- ============ HERO ============ -->
<section class="hero" id="hero">
  <div class="lux-container">
    <div class="hero__content reveal">
      <span class="eyebrow">M3M India Presents · Sector 97 Noida</span>
      <h1 class="display hero__title">M3M Jewel Crest<br><em>Avenue</em></h1>
      <p class="lead" style="color:#C9C4B8; max-width:560px;">
        A ~6-acre luxury high-street retail, F&amp;B and food-court destination on the Noida–Greater Noida Expressway. G+3 single block, 680 ft three-side open frontage, atrium-led circulation and triple-height flagship stores.
      </p>

      <div class="hero__meta">
        <div class="hero__meta-item">
          <span class="hero__meta-label">Starting</span>
          <span class="hero__meta-value">₹29,000/sq ft</span>
        </div>
        <div class="hero__meta-item">
          <span class="hero__meta-label">Ticket</span>
          <span class="hero__meta-value">₹65 L onwards</span>
        </div>
        <div class="hero__meta-item">
          <span class="hero__meta-label">Possession</span>
          <span class="hero__meta-value">Jul 2030</span>
        </div>
        <div class="hero__meta-item">
          <span class="hero__meta-label">UP RERA</span>
          <span class="hero__meta-value" style="font-size:14px;">UPRERAPRJ690055/10/2025</span>
        </div>
      </div>

      <div class="hero__ctas">
        <a href="#pricing" class="btn">View Pricing</a>
        <a href="tel:<?= $phoneTel ?>" class="btn">Call <?= $phone ?></a>
      </div>
    </div>

    <aside class="hero__form reveal">
      <h3>Enquire Now</h3>
      <p class="caption">Get the price list, floor plans and site-visit slot.</p>
      <form action="process-form.php" method="POST" data-ajax id="heroForm" novalidate>
        <input type="hidden" name="form_source" value="hero_form">
        <input type="hidden" name="interested_in" value="General Retail Enquiry">
        <div class="form-group">
          <label for="hero_name">Name</label>
          <input type="text" id="hero_name" name="name" placeholder="Full name" required>
        </div>
        <div class="form-group">
          <label for="hero_email">Email</label>
          <input type="email" id="hero_email" name="email" placeholder="you@example.com" required>
        </div>
        <div class="form-group">
          <label for="hero_phone">Phone</label>
          <input type="tel" id="hero_phone" name="phone" placeholder="10-digit mobile" required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}" title="Please enter a valid 10-digit Indian mobile number">
        </div>
        <div class="form-group">
          <label for="hero_interest">Interested In</label>
          <select name="interested_in" id="hero_interest">
            <option value="General Retail Enquiry">General Retail Enquiry</option>
            <option value="Ground Floor Flagship">Ground Floor Flagship</option>
            <option value="Ground Floor Retail">Ground Floor Retail</option>
            <option value="Upper Ground Floor">Upper Ground Floor</option>
            <option value="2nd Floor">2nd Floor</option>
            <option value="Food Court">Food Court</option>
            <option value="Restaurant Space">Restaurant Space</option>
          </select>
        </div>
        <button type="submit" class="btn btn--gold" style="width:100%; margin-top:8px;">Request Callback</button>
        <div class="form-msg" role="status" aria-live="polite"></div>
        <p class="caption" style="margin-top:12px; font-size:11px;">
          By submitting, you authorize our representatives to Call, SMS, Email or WhatsApp about this project. Overrides DNC/NDNC.
        </p>
      </form>
    </aside>
  </div>
</section>

<!-- ============ TRUST STRIP ============ -->
<div class="trust-strip">
  <div class="lux-container">
    <div class="trust-strip__inner">
      <span class="trust-strip__item"><span class="trust-strip__dot"></span>M3M India</span>
      <span class="trust-strip__item"><span class="trust-strip__dot"></span>UPRERAPRJ690055/10/2025</span>
      <span class="trust-strip__item"><span class="trust-strip__dot"></span>680 ft Frontage</span>
      <span class="trust-strip__item"><span class="trust-strip__dot"></span>~6 Acres</span>
      <span class="trust-strip__item"><span class="trust-strip__dot"></span>50:50 Plan</span>
      <span class="trust-strip__item"><span class="trust-strip__dot"></span>Possession Jul 2030</span>
    </div>
  </div>
</div>

<!-- ============ KEY FACTS BAND ============ -->
<div class="facts-band">
  <div class="lux-container">
    <div class="grid grid--6">
      <div class="fact reveal"><div class="fact__value">~6</div><div class="fact__label">Acres</div></div>
      <div class="fact reveal"><div class="fact__value">680</div><div class="fact__label">Feet Frontage</div></div>
      <div class="fact reveal"><div class="fact__value">G+3</div><div class="fact__label">Retail Block</div></div>
      <div class="fact reveal"><div class="fact__value">3</div><div class="fact__label">Sides Open</div></div>
      <div class="fact reveal"><div class="fact__value">Atrium</div><div class="fact__label">Led Design</div></div>
      <div class="fact reveal"><div class="fact__value">₹29k–60k</div><div class="fact__label">Per Sq Ft</div></div>
    </div>
  </div>
</div>

<!-- ============ OVERVIEW ============ -->
<section class="section overview" id="overview">
  <div class="lux-container">
    <div class="grid overview-grid">
      <div class="overview-text reveal">
        <span class="eyebrow eyebrow--ink">Project Overview</span>
        <h2 class="h1">A crown-jewel <em>high street</em> for Sector 97 Noida.</h2>
        <p class="lead">
          M3M Jewel Crest Avenue is a <strong>commercial-only</strong> luxury retail destination by M3M India on the Noida–Greater Noida Expressway. Spread across approximately 6 acres in Sector 97 Noida, the project is a single G+3 retail block with a rare three-side open layout, a 207 m (680 ft) frontage and an atrium-led experiential design that pulls footfall seamlessly across every level — from ground-floor flagships to the third-floor food court and restaurants. Starting ₹29,000/sq ft; UP RERA UPRERAPRJ690055/10/2025; possession July 2030.
        </p>

        <details>
          <summary>Read the full brief</summary>
          <p>
            Positioned at one of the highest-visibility stretches of the Noida Expressway, M3M Jewel Crest Avenue is designed as a single, visually unified retail block rather than a cluster of scattered shops. The three-sided open layout means every façade receives direct road and pedestrian visibility — a structural advantage for brand storefronts and flagship-format retail.
          </p>
          <p>
            The atrium-led circulation is the architectural backbone: a central void connects all four levels optically, ensuring that customers on the ground floor can see activity on the upper levels and vice versa. Triple-height flagship stores on the ground floor are sized and spec'd for international brand rollouts. The upper ground and second floors house standard retail and anchor stores. The third floor is dedicated to F&amp;B — fine-dining restaurants (starting ₹29,000/sq ft) and a food court (starting ₹34,000/sq ft) — with a multiplex zone to drive evening and weekend footfall.
          </p>
          <p>
            Payment is a simple 50:50 plan (50% at booking, 50% near possession). Unit sizes are not yet published publicly — our channel-partner team will share layouts and availability on request.
          </p>
        </details>

        <div style="margin-top:32px;">
          <a href="#pricing" class="btn btn--ink">View Pricing Matrix</a>
        </div>
      </div>

      <div class="overview-img reveal">
        <img src="img/overview.webp" alt="M3M Jewel Crest Avenue — architectural render" loading="lazy">
      </div>
    </div>
  </div>
</section>

<!-- ============ PRICING MATRIX ============ -->
<section class="section section--bone" id="pricing">
  <div class="lux-container">
    <div class="section-head reveal">
      <span class="eyebrow eyebrow--ink">Opportunity Matrix</span>
      <h2 class="h1">Six ways to own the high street.</h2>
      <p class="lead">Verified starting prices per sq ft. Unit sizes are shared on request by our channel-partner team.</p>
    </div>

    <div class="grid grid--3">
      <article class="card pricing-card reveal">
        <span class="pricing-card__tag">GF — Flagship</span>
        <h3 class="pricing-card__title">Ground Floor Flagship Store</h3>
        <p class="pricing-card__sub">Triple-height, direct-entry flagships sized for international brands.</p>
        <div class="pricing-card__price">₹60,000</div>
        <span class="pricing-card__per">per sq ft — starting</span>
        <ul>
          <li>Triple-height ceilings</li>
          <li>Direct road-side entry</li>
          <li>Prime façade visibility</li>
          <li>Unit size: on request</li>
        </ul>
        <a href="#contact" class="btn btn--sm">Enquire</a>
      </article>

      <article class="card pricing-card reveal">
        <span class="pricing-card__tag">Ground Floor</span>
        <h3 class="pricing-card__title">Ground Floor (Standard)</h3>
        <p class="pricing-card__sub">Primary retail level with the highest natural footfall.</p>
        <div class="pricing-card__price">₹47,000</div>
        <span class="pricing-card__per">per sq ft — starting</span>
        <ul>
          <li>Direct pedestrian access</li>
          <li>Anchor-store adjacency</li>
          <li>Double-height fronts</li>
          <li>Unit size: on request</li>
        </ul>
        <a href="#contact" class="btn btn--sm">Enquire</a>
      </article>

      <article class="card pricing-card reveal">
        <span class="pricing-card__tag">UGF</span>
        <h3 class="pricing-card__title">Upper Ground Floor</h3>
        <p class="pricing-card__sub">Atrium-facing boutiques with seamless escalator circulation.</p>
        <div class="pricing-card__price">₹39,000</div>
        <span class="pricing-card__per">per sq ft — starting</span>
        <ul>
          <li>Atrium frontage</li>
          <li>Escalator circulation</li>
          <li>Boutique footprints</li>
          <li>Unit size: on request</li>
        </ul>
        <a href="#contact" class="btn btn--sm">Enquire</a>
      </article>

      <article class="card pricing-card reveal">
        <span class="pricing-card__tag">2nd Floor</span>
        <h3 class="pricing-card__title">Second Floor Retail</h3>
        <p class="pricing-card__sub">Lifestyle zone — fashion, accessories, experience stores.</p>
        <div class="pricing-card__price">₹35,000</div>
        <span class="pricing-card__per">per sq ft — starting</span>
        <ul>
          <li>Lifestyle anchor zone</li>
          <li>Atrium view</li>
          <li>Flexible unit shells</li>
          <li>Unit size: on request</li>
        </ul>
        <a href="#contact" class="btn btn--sm">Enquire</a>
      </article>

      <article class="card pricing-card pricing-card--featured reveal">
        <span class="pricing-card__tag">3rd Floor · F&amp;B</span>
        <h3 class="pricing-card__title">Third Floor Food Court</h3>
        <p class="pricing-card__sub">Dedicated food-court kiosks beside the multiplex zone.</p>
        <div class="pricing-card__price">₹34,000</div>
        <span class="pricing-card__per">per sq ft — starting</span>
        <ul>
          <li>Food-court kiosk format</li>
          <li>Multiplex-driven footfall</li>
          <li>Shared seating deck</li>
          <li>Unit size: on request</li>
        </ul>
        <a href="#contact" class="btn btn--sm">Enquire</a>
      </article>

      <article class="card pricing-card reveal">
        <span class="pricing-card__tag">3rd Floor · Fine Dining</span>
        <h3 class="pricing-card__title">Third Floor Restaurants</h3>
        <p class="pricing-card__sub">Fine-dining restaurants with terrace potential — headline entry price.</p>
        <div class="pricing-card__price">₹29,000</div>
        <span class="pricing-card__per">per sq ft — starting</span>
        <ul>
          <li>Fine-dining format</li>
          <li>Terrace potential</li>
          <li>Lowest entry price</li>
          <li>Unit size: on request</li>
        </ul>
        <a href="#contact" class="btn btn--sm">Enquire</a>
      </article>
    </div>
  </div>
</section>

<!-- ============ FLOOR PLANS ============ -->
<section class="section" id="floor-plans">
  <div class="lux-container">
    <div class="section-head reveal">
      <span class="eyebrow eyebrow--ink">Floor Plans</span>
      <h2 class="h1">Master plan &amp; level layouts.</h2>
      <p class="lead">Distinct plans per level. Detailed unit-level plans are shared on request after a brief qualification.</p>
    </div>

    <div class="fp-tabs reveal">
      <button class="fp-tab active" data-target="fp-master">Master Plan</button>
      <button class="fp-tab" data-target="fp-gf">Ground Floor</button>
      <button class="fp-tab" data-target="fp-ugf">Upper Ground</button>
      <button class="fp-tab" data-target="fp-2f">2nd Floor</button>
      <button class="fp-tab" data-target="fp-3f-fc">3F · Food Court</button>
      <button class="fp-tab" data-target="fp-3f-rest">3F · Restaurants</button>
    </div>

    <div class="fp-panel active" id="fp-master">
      <div class="fp-panel__img"><div class="plan-note">Master Plan<small>Available on request</small></div></div>
      <div>
        <h3 class="h3">Master Layout</h3>
        <p>Single G+3 retail block on ~6 acres, three-side open, 207 m frontage. Central atrium connects all levels; multi-level parking below grade.</p>
        <ul>
          <li><span>Project area</span><strong>~6 acres</strong></li>
          <li><span>Frontage</span><strong>207 m / 680 ft</strong></li>
          <li><span>Structure</span><strong>G+3 single block</strong></li>
          <li><span>Layout</span><strong>Three-side open, atrium-led</strong></li>
        </ul>
      </div>
    </div>

    <div class="fp-panel" id="fp-gf">
      <div class="fp-panel__img"><div class="plan-note">Ground Floor<small>Plan on request</small></div></div>
      <div>
        <h3 class="h3">Ground Floor</h3>
        <p>Flagship zone with triple-height, direct-entry stores and a standard retail core at the centre. Highest natural footfall level.</p>
        <ul>
          <li><span>Flagship price</span><strong>₹60,000 / sq ft</strong></li>
          <li><span>Standard price</span><strong>₹47,000 / sq ft</strong></li>
          <li><span>Unit sizes</span><strong>On request</strong></li>
        </ul>
      </div>
    </div>

    <div class="fp-panel" id="fp-ugf">
      <div class="fp-panel__img"><div class="plan-note">Upper Ground Floor<small>Plan on request</small></div></div>
      <div>
        <h3 class="h3">Upper Ground Floor</h3>
        <p>Atrium-facing boutiques connected to ground floor by escalators. Ideal for fashion, jewellery and lifestyle boutiques.</p>
        <ul>
          <li><span>Price</span><strong>₹39,000 / sq ft</strong></li>
          <li><span>Format</span><strong>Boutique retail</strong></li>
          <li><span>Unit sizes</span><strong>On request</strong></li>
        </ul>
      </div>
    </div>

    <div class="fp-panel" id="fp-2f">
      <div class="fp-panel__img"><div class="plan-note">Second Floor<small>Plan on request</small></div></div>
      <div>
        <h3 class="h3">Second Floor</h3>
        <p>Lifestyle retail level — fashion, accessories, electronics and experience stores.</p>
        <ul>
          <li><span>Price</span><strong>₹35,000 / sq ft</strong></li>
          <li><span>Format</span><strong>Lifestyle retail</strong></li>
          <li><span>Unit sizes</span><strong>On request</strong></li>
        </ul>
      </div>
    </div>

    <div class="fp-panel" id="fp-3f-fc">
      <div class="fp-panel__img"><div class="plan-note">3F · Food Court<small>Plan on request</small></div></div>
      <div>
        <h3 class="h3">Third Floor — Food Court</h3>
        <p>Dedicated food-court kiosks adjacent to the multiplex zone — high evening and weekend footfall.</p>
        <ul>
          <li><span>Price</span><strong>₹34,000 / sq ft</strong></li>
          <li><span>Format</span><strong>Food-court kiosk</strong></li>
          <li><span>Unit sizes</span><strong>On request</strong></li>
        </ul>
      </div>
    </div>

    <div class="fp-panel" id="fp-3f-rest">
      <div class="fp-panel__img"><div class="plan-note">3F · Restaurants<small>Plan on request</small></div></div>
      <div>
        <h3 class="h3">Third Floor — Restaurants</h3>
        <p>Fine-dining restaurants with terrace potential. Headline entry price for the entire project.</p>
        <ul>
          <li><span>Price</span><strong>₹29,000 / sq ft</strong></li>
          <li><span>Format</span><strong>Fine dining</strong></li>
          <li><span>Unit sizes</span><strong>On request</strong></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ AMENITIES ============ -->
<section class="section section--bone amenities" id="amenities">
  <div class="lux-container">
    <div class="section-head reveal">
      <span class="eyebrow eyebrow--ink">Retail Amenities</span>
      <h2 class="h1">Designed for brands, built for footfall.</h2>
    </div>

    <div class="grid grid--3">
      <div class="amenity reveal">
        <div class="amenity__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 21V3h18v18M3 9h18M3 15h18"/></svg></div>
        <h4>Triple-Height Flagships</h4><p>Direct-entry stores engineered for international brand rollouts.</p>
      </div>
      <div class="amenity reveal">
        <div class="amenity__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20"/></svg></div>
        <h4>Atrium-Led Circulation</h4><p>Four-level visual connectivity pulls footfall across every floor.</p>
      </div>
      <div class="amenity reveal">
        <div class="amenity__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="7" width="18" height="11" rx="1"/><path d="M7 7V4h10v3M3 12h18"/></svg></div>
        <h4>Multi-Level Parking</h4><p>Dedicated basement parking sized for peak weekend demand.</p>
      </div>
      <div class="amenity reveal">
        <div class="amenity__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16v4H4zM6 8v12h12V8"/></svg></div>
        <h4>Food Court &amp; Fine Dining</h4><p>Third-floor F&amp;B zone with multiplex-driven footfall.</p>
      </div>
      <div class="amenity reveal">
        <div class="amenity__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="3"/></svg></div>
        <h4>Multiplex Zone</h4><p>Entertainment anchor to extend dwell time into evenings.</p>
      </div>
      <div class="amenity reveal">
        <div class="amenity__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l9 4v6c0 5-4 9-9 10-5-1-9-5-9-10V6z"/></svg></div>
        <h4>24×7 Security &amp; CCTV</h4><p>Manned security, complete CCTV coverage, fire-safety systems.</p>
      </div>
    </div>

    <details class="reveal">
      <summary>View all retail amenities</summary>
      <div class="grid grid--3" style="margin-top:32px;">
        <div class="amenity"><h4>High-Speed Wi-Fi</h4><p>Tenant-grade connectivity across every floor.</p></div>
        <div class="amenity"><h4>Elevators &amp; Escalators</h4><p>Redundant vertical circulation across all levels.</p></div>
        <div class="amenity"><h4>Power Backup</h4><p>100% DG backup for common areas and retail units.</p></div>
        <div class="amenity"><h4>Wide Pedestrian Walkways</h4><p>Three-side open walkways for window-shop dwell.</p></div>
        <div class="amenity"><h4>Premium Architectural Lighting</h4><p>Night-time façade and atrium illumination.</p></div>
        <div class="amenity"><h4>Concierge Services</h4><p>Tenant concierge at ground level for brand support.</p></div>
      </div>
    </details>
  </div>
</section>

<!-- ============ ARCHITECTURE STRIP ============ -->
<section class="arch-strip">
  <div class="lux-container reveal">
    <span class="eyebrow">Architecture</span>
    <h2 class="h1">Three sides open. Triple-height flagships. One unified high street.</h2>
    <p>The atrium is the architectural gesture that binds the block. Every level reads every other level, footfall is visible from the outside, and brand storefronts get the kind of billboard-grade visibility you normally only get on standalone highway retail.</p>
    <ul>
      <li><strong>Structure</strong><span>G+3 single retail block, ~6 acres</span></li>
      <li><strong>Frontage</strong><span>207 m / 680 ft, three-side open</span></li>
      <li><strong>Circulation</strong><span>Central atrium + escalators + elevators</span></li>
      <li><strong>Flagship Ceilings</strong><span>Triple-height, direct-entry</span></li>
    </ul>
  </div>
</section>

<!-- ============ LOCATION ============ -->
<section class="section" id="location">
  <div class="lux-container">
    <div class="section-head align-left reveal">
      <span class="eyebrow eyebrow--ink">Location</span>
      <h2 class="h1">Sector 97 Noida — directly on the Expressway.</h2>
      <p class="lead">Positioned on the Noida–Greater Noida Expressway in Gautam Buddha Nagar, Uttar Pradesh. Sector 97 sits at a high-visibility stretch with direct expressway connectivity.</p>
    </div>

    <div class="grid location-grid">
      <div class="location-map reveal">
        <iframe
          src="https://www.google.com/maps?q=Sector+97+Noida&hl=en&z=14&output=embed"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="M3M Jewel Crest Avenue Sector 97 Noida map">
        </iframe>
      </div>

      <div class="location-list reveal">
        <h3 class="h3">Distances &amp; Connectivity</h3>
        <ul>
          <li><strong>Noida City Center</strong><span>~20 min</span></li>
          <li><strong>Sector 18 / Atta Market</strong><span>~15 min</span></li>
          <li><strong>DLF Mall of India</strong><span>~20 min</span></li>
          <li><strong>Gardens Galleria, Noida</strong><span>~20 min</span></li>
          <li><strong>Greater Noida</strong><span>~25 min</span></li>
          <li><strong>Noida Intl. Airport (Jewar)</strong><span>~30–40 min</span></li>
          <li><strong>IGI Airport / Dwarka</strong><span>~30–45 min</span></li>
          <li><strong>Gurgaon</strong><span>~40 min</span></li>
          <li><strong>Noida–Gr. Noida Expressway</strong><span>Direct access</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ PAYMENT PLAN ============ -->
<section class="section section--bone" id="payment">
  <div class="lux-container">
    <div class="section-head reveal">
      <span class="eyebrow eyebrow--ink">Payment Plan</span>
      <h2 class="h1">A simple 50:50 plan.</h2>
      <p class="lead">Pay half at booking, half near possession. Entry ticket ₹65 Lacs onwards.</p>
    </div>

    <div class="payment-timeline reveal">
      <div class="payment-step">
        <div class="payment-step__pct">50%</div>
        <div class="payment-step__label">Stage 01 · Booking</div>
        <p>Paid at the time of booking — confirms your unit and locks the price.</p>
      </div>
      <div class="payment-arrow">→</div>
      <div class="payment-step">
        <div class="payment-step__pct">50%</div>
        <div class="payment-step__label">Stage 02 · Near Possession</div>
        <p>Paid near possession — July 2030 (as per the developer).</p>
      </div>
    </div>

    <p class="caption reveal" style="text-align:center; margin-top:32px;">
      Entry ticket: <strong style="color:var(--text-ink);">₹65 Lacs onwards</strong> &nbsp;·&nbsp; Possession: <strong style="color:var(--text-ink);">July 2030</strong> &nbsp;·&nbsp; RERA: <strong style="color:var(--text-ink);">UPRERAPRJ690055/10/2025</strong>
    </p>
  </div>
</section>

<!-- ============ GALLERY ============ -->
<section class="section" id="gallery">
  <div class="lux-container">
    <div class="section-head reveal">
      <span class="eyebrow eyebrow--ink">Gallery</span>
      <h2 class="h1">Renders &amp; architecture.</h2>
      <p class="lead">Artistic impressions. Final built form subject to minor variation.</p>
    </div>

    <div class="grid grid--3 gallery-grid">
      <figure class="gallery-item reveal"><img src="img/banners/banner1.webp" alt="Facade render"><figcaption class="gallery-item__label">Expressway Facade</figcaption></figure>
      <figure class="gallery-item reveal"><img src="img/overview.webp" alt="Atrium render"><figcaption class="gallery-item__label">Atrium</figcaption></figure>
      <figure class="gallery-item reveal"><img src="img/highlight.webp" alt="Night render"><figcaption class="gallery-item__label">Night View</figcaption></figure>
      <figure class="gallery-item reveal"><img src="img/gallery/g1.webp" alt="Retail render"><figcaption class="gallery-item__label">Retail Floor</figcaption></figure>
      <figure class="gallery-item reveal"><img src="img/gallery/g2.webp" alt="Food court render"><figcaption class="gallery-item__label">Food Court</figcaption></figure>
      <figure class="gallery-item reveal"><img src="img/gallery/g3.webp" alt="Flagship render"><figcaption class="gallery-item__label">Flagship Store</figcaption></figure>
    </div>
  </div>
</section>

<!-- ============ DEVELOPER ============ -->
<section class="section section--bone" id="about-builder">
  <div class="lux-container">
    <div class="developer">
      <div class="reveal">
        <span class="eyebrow eyebrow--ink">The Developer</span>
        <h2 class="h1">M3M India.</h2>
        <p class="lead">Founded in 2010 by the Bansal family (Basant, Roop and Pankaj Bansal), M3M India is one of the largest real-estate developers in Delhi NCR, with a portfolio spanning luxury residences and landmark high-street retail / commercial projects across Gurugram and Noida.</p>

        <ul class="developer__facts">
          <li><strong>Founded</strong> 2010</li>
          <li><strong>Promoters</strong> Basant, Roop &amp; Pankaj Bansal</li>
          <li><strong>Head office</strong> Gurugram, Haryana</li>
          <li><strong>Focus</strong> Luxury residential &amp; high-street retail across NCR</li>
        </ul>

        <a href="#contact" class="btn btn--ink">Enquire About Retail Units</a>
      </div>
      <div class="overview-img reveal">
        <img src="img/highlight.webp" alt="M3M India projects" loading="lazy">
      </div>
    </div>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="section" id="faq">
  <div class="lux-container">
    <div class="section-head reveal">
      <span class="eyebrow eyebrow--ink">Frequently Asked</span>
      <h2 class="h1">Everything buyers ask us.</h2>
    </div>

    <div class="faq-list">
      <details class="faq-item reveal"><summary>What is the price per sq ft at M3M Jewel Crest Avenue?</summary><p>Starting prices per sq ft are: Ground Floor Flagship ₹60,000, Ground Floor ₹47,000, Upper Ground Floor ₹39,000, 2nd Floor ₹35,000, 3rd Floor Food Court ₹34,000, and 3rd Floor Restaurants ₹29,000. The headline starting price is ₹29,000 per sq ft.</p></details>
      <details class="faq-item reveal"><summary>What is the RERA number for M3M Jewel Crest Avenue?</summary><p>The UP RERA registration number for the retail component is <strong>UPRERAPRJ690055/10/2025</strong>. Verify directly on up-rera.in before booking.</p></details>
      <details class="faq-item reveal"><summary>When is the possession of M3M Jewel Crest Avenue?</summary><p>Possession is scheduled for <strong>July 2030</strong> as per the developer.</p></details>
      <details class="faq-item reveal"><summary>Is M3M Jewel Crest Avenue a residential or commercial project?</summary><p><strong>Commercial only.</strong> It is a high-street retail + F&amp;B + food-court project. It does not contain apartments, BHKs or residences. The residential Jacob &amp; Co Residences is a separate M3M project and is not sold on this site.</p></details>
      <details class="faq-item reveal"><summary>What is the starting ticket size?</summary><p><strong>₹65 Lacs onwards.</strong> Final ticket depends on floor, unit size and position within the block. Unit sizes are shared on request by our channel-partner team.</p></details>
      <details class="faq-item reveal"><summary>How many floors does M3M Jewel Crest Avenue have?</summary><p>It is a single <strong>G+3 retail block</strong> — Ground Floor, Upper Ground Floor, Second Floor and Third Floor (food court and restaurants).</p></details>
      <details class="faq-item reveal"><summary>What is the frontage of the project?</summary><p><strong>207 metres (approximately 680 feet)</strong>, three-side open, on the Noida–Greater Noida Expressway.</p></details>
      <details class="faq-item reveal"><summary>Is there a food court at M3M Jewel Crest Avenue?</summary><p>Yes. The third floor houses a dedicated food court (starting ₹34,000/sq ft) alongside fine-dining restaurants (starting ₹29,000/sq ft) and a multiplex zone.</p></details>
      <details class="faq-item reveal"><summary>Who is the developer?</summary><p><strong>M3M India Private Limited</strong>, founded in 2010 by Basant, Roop and Pankaj Bansal. One of NCR's largest real-estate developers, with marquee projects across Gurugram and Noida.</p></details>
      <details class="faq-item reveal"><summary>What is the payment plan?</summary><p>A simple <strong>50:50 plan</strong> — 50% at booking and 50% near possession (July 2030).</p></details>
      <details class="faq-item reveal"><summary>Where is M3M Jewel Crest Avenue located?</summary><p>Sector 97, Noida, directly on the Noida–Greater Noida Expressway in Gautam Buddha Nagar, Uttar Pradesh. Noida City Center is ~20 min, Sector 18 (Atta Market) ~15 min, Greater Noida ~25 min and Jewar Airport ~30–40 min.</p></details>
      <details class="faq-item reveal"><summary>Is M3M Jewel Crest Avenue the same as M3M Jacob &amp; Co Residences?</summary><p>No — they are <strong>different projects</strong>. M3M Jewel Crest Avenue (this site) is a commercial retail project. The Jacob &amp; Co Residences is a separate residential project. Buyers often confuse the two; the correct RERA for the retail block is <strong>UPRERAPRJ690055/10/2025</strong>.</p></details>
      <details class="faq-item reveal"><summary>Are there assured returns?</summary><p>No. No assured-return or guaranteed-rental promise is made by the developer or by this channel partner. Pricing is straightforward under a 50:50 plan.</p></details>
    </div>
  </div>
</section>

<!-- ============ SEO LONG FORM ============ -->
<section class="section section--bone">
  <div class="lux-container">
    <div class="section-head reveal">
      <span class="eyebrow eyebrow--ink">Project Analysis</span>
      <h2 class="h1">Why Sector 97 Noida, and why now.</h2>
    </div>

    <div class="seo-block reveal">
      <p class="lead">
        M3M Jewel Crest Avenue is a ~6-acre commercial retail project by M3M India on the Noida–Greater Noida Expressway in Sector 97, Noida. It is a single G+3 block with a 207 m (680 ft) three-side open frontage, atrium-led circulation, and six distinct pricing tiers ranging from ₹29,000/sq ft (3rd-floor restaurants) to ₹60,000/sq ft (ground-floor flagships). Entry ticket is ₹65 Lacs onwards on a 50:50 payment plan, with possession scheduled for July 2030 under UP RERA registration UPRERAPRJ690055/10/2025.
      </p>

      <table>
        <thead>
          <tr><th>Key Fact</th><th>Value</th></tr>
        </thead>
        <tbody>
          <tr><td>Project name</td><td>M3M Jewel Crest Avenue</td></tr>
          <tr><td>Developer</td><td>M3M India Private Limited</td></tr>
          <tr><td>Asset type</td><td>Commercial retail — high-street + F&amp;B + food court</td></tr>
          <tr><td>Location</td><td>Sector 97, Noida, Noida–Greater Noida Expressway, UP</td></tr>
          <tr><td>Project area</td><td>~6 acres</td></tr>
          <tr><td>Frontage</td><td>207 m / 680 ft, three-side open</td></tr>
          <tr><td>Structure</td><td>G+3 single retail block, atrium-led</td></tr>
          <tr><td>Starting price</td><td>₹29,000 per sq ft</td></tr>
          <tr><td>Starting ticket</td><td>₹65 Lacs onwards</td></tr>
          <tr><td>Payment plan</td><td>50:50</td></tr>
          <tr><td>Possession</td><td>July 2030</td></tr>
          <tr><td>RERA number</td><td>UPRERAPRJ690055/10/2025</td></tr>
        </tbody>
      </table>

      <details>
        <summary>Read the full investment analysis</summary>

        <h3>Sector 97 retail positioning</h3>
        <p>Sector 97 sits on the Noida–Greater Noida Expressway, one of Delhi NCR's busiest corridors by both vehicle count and residential catchment. The expressway is flanked by high-income residential stock in Sectors 74, 75, 76, 77, 78, 79, 96, 97, 98, 100 and 104, a captive demand base of several hundred thousand households within a 10-minute drive. Organised retail supply in this micro-market is thin — the area is anchored mostly by standalone shops and small neighbourhood commercial plots rather than a proper high-street format. M3M Jewel Crest Avenue is one of the first large-format, branded high-street retail offerings directly on this stretch of the expressway, which is exactly why the ground-floor flagship price (₹60,000/sq ft) is set well above the upper-floor averages — the scarcity premium is real.</p>

        <h3>Atrium architecture and floor-by-floor thesis</h3>
        <p>The architectural decision that matters most commercially is the central atrium. In multi-level retail, the hardest problem is moving footfall beyond the ground floor — most consumers stop at GF and UGF, and second and third floors bleed tenants. An atrium that is visually connected across all four levels forces upper-floor visibility from below and lower-floor visibility from above, which measurably improves upper-floor dwell. Combined with triple-height flagship stores on the ground floor — the kind of volumes international brands like Apple, Nike, H&amp;M and Zara specify for their flagship formats — this is a block designed for brand storefronts rather than small shop-in-shop counters.</p>

        <h3>F&amp;B and food court thesis</h3>
        <p>Placing fine-dining restaurants (₹29,000/sq ft) and a food court (₹34,000/sq ft) on the third floor alongside a multiplex zone is a deliberate move. It extends the retail dwell window into the evening and weekend, which is when F&amp;B and entertainment drive the bulk of mall footfall. The inverted price ladder — third floor cheapest, ground floor most expensive — is also standard high-street pricing, rewarding F&amp;B investors with a lower entry price for floors that will nevertheless be the last to empty out each day.</p>

        <h3>Per-sq-ft pricing tiers</h3>
        <p>The six starting prices are ₹60,000 (GF Flagship), ₹47,000 (GF standard), ₹39,000 (UGF), ₹35,000 (2F), ₹34,000 (3F Food Court) and ₹29,000 (3F Restaurants). The delta between flagship and standard ground-floor units is about 27%, which is the market reading of how much premium a triple-height direct-entry storefront commands. The delta between GF standard and the third-floor restaurants is about 38%, a typical high-street vertical discount.</p>

        <h3>M3M retail portfolio context</h3>
        <p>M3M India, founded in 2010 by Basant Bansal, Roop Kumar Bansal and Pankaj Bansal, has built a strong pipeline of high-street retail projects in Gurugram — M3M Urbana, M3M Cosmopolitan, M3M 65th Avenue and M3M IFC are well-known references in the NCR retail market. M3M Jewel Crest Avenue is the group's stake in the Noida expressway retail market and is positioned as their flagship Noida high-street play.</p>

        <h3>Noida Expressway connectivity</h3>
        <p>Noida City Center is ~20 minutes by road, Sector 18 (Atta Market — the traditional Noida shopping hub) is ~15 minutes, Greater Noida is ~25 minutes, IGI/Dwarka is ~30–45 minutes and Noida International Airport at Jewar is ~30–40 minutes. DLF Mall of India and Gardens Galleria — the two major organised retail assets in Noida — sit on the same corridor and, rather than competing, set the footfall benchmark that a new high street on the expressway must improve upon. The Noida Metro Aqua Line runs parallel to the expressway with Sector 97 catchment accessible from nearby stations.</p>

        <h3>Investment thesis (objective, no assured-return promise)</h3>
        <p>The fundamentals are straightforward: thin organised-retail supply on the expressway, heavy residential catchment, a branded developer with a proven high-street track record, a transparent per-sq-ft grid with a 50:50 payment plan, and a four-and-a-half-year runway to possession. None of this constitutes an assured-return commitment — this project does not carry any guaranteed-rental programme, and any such promise should be treated as a red flag. Buyers should verify RERA, frontage, unit sizes and delivery timelines directly with the developer and on the UP RERA portal (up-rera.in) before booking.</p>

        <p class="caption" style="margin-top:32px;">All information is indicative and subject to change. Verify with the developer and on the UP RERA portal before any booking.</p>
      </details>
    </div>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="final-cta" id="contact">
  <div class="lux-container">
    <div class="reveal">
      <span class="eyebrow">Book A Site Visit</span>
      <h2 class="h1">Ready to walk the high street.</h2>
      <p class="lead">Share your details — we'll confirm pricing, floor plans and a site-visit slot within a business day.</p>

      <div class="final-cta__contact">
        <a href="tel:<?= $phoneTel ?>"><strong>Phone</strong> <?= $phone ?></a>
        <a href="https://wa.me/919412234688" rel="noopener"><strong>WhatsApp</strong> 9412-234-688</a>
        <a href="#location"><strong>Location</strong> Sector 97, Noida Expressway</a>
        <a href="#pricing"><strong>Pricing</strong> ₹29,000 – ₹60,000 / sq ft</a>
      </div>
      <p class="caption" style="margin-top:32px; color:var(--text-muted);">
        Authorized Channel Partner line — we receive brokerage from the developer on successful bookings; no fees are charged to end buyers.
      </p>
    </div>

    <div class="hero__form reveal">
      <h3>Request Callback</h3>
      <p class="caption">Our team replies within one business hour.</p>
      <form action="process-form.php" method="POST" data-ajax id="contactForm" novalidate>
        <input type="hidden" name="form_source" value="contact_form">
        <div class="form-group">
          <label for="c_name">Name</label>
          <input type="text" id="c_name" name="name" placeholder="Full name" required>
        </div>
        <div class="form-group">
          <label for="c_email">Email</label>
          <input type="email" id="c_email" name="email" placeholder="you@example.com" required>
        </div>
        <div class="form-group">
          <label for="c_phone">Phone</label>
          <input type="tel" id="c_phone" name="phone" placeholder="10-digit mobile" required minlength="10" maxlength="10" pattern="[6-9][0-9]{9}" title="Please enter a valid 10-digit Indian mobile number">
        </div>
        <div class="form-group">
          <label for="c_interest">Interested In</label>
          <select name="interested_in" id="c_interest">
            <option value="General Retail Enquiry">General Retail Enquiry</option>
            <option value="Ground Floor Flagship">Ground Floor Flagship</option>
            <option value="Ground Floor Retail">Ground Floor Retail</option>
            <option value="Upper Ground Floor">Upper Ground Floor</option>
            <option value="2nd Floor">2nd Floor</option>
            <option value="Food Court">Food Court</option>
            <option value="Restaurant Space">Restaurant Space</option>
          </select>
        </div>
        <button type="submit" class="btn btn--gold" style="width:100%;">Submit Enquiry</button>
        <div class="form-msg" role="status" aria-live="polite"></div>
      </form>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<!-- lightbox -->
<div class="lb" aria-hidden="true"><button class="lb__close" aria-label="Close">&times;</button><img src="" alt="Gallery image"></div>

<script src="js/main.js?v=2" defer></script>
</body>
</html>
