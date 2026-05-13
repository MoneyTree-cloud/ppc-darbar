<?php
require_once __DIR__ . '/../env.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];
$siteName  = env('SITE_NAME', 'Exotica One32');
$siteUrl   = env('SITE_URL',  'https://exoticaone32.org/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="index, follow, max-image-preview:large" />
    <meta name="author" content="Exotica Housing" />

    <title>Exotica One32 Sector 132 Noida | Grade A++ IT/ITES + Retail</title>
    <meta name="description" content="5 acres - Sector 132 Noida - Exotica Housing - INR 13,990 per sq ft - RERA UPRERAPRJ731857 - IGBC Gold - Jan 2030 possession." />
    <meta name="keywords" content="Exotica One32, Exotica One32 Sector 132 Noida, Exotica One32 price per sq ft, Exotica One32 RERA, Exotica Housing One32 commercial, commercial property Sector 132 Noida, Grade A++ office Noida Expressway" />

    <link rel="canonical" href="https://exoticaone32.org/" />

    <meta property="og:title" content="Exotica One32 Sector 132 Noida | Grade A++ IT/ITES + Retail" />
    <meta property="og:description" content="5 acres, 2 towers, 27 floors. Offices from INR 13,990/sq ft. RERA UPRERAPRJ731857. IGBC Gold. Exotica Housing." />
    <meta property="og:image" content="https://exoticaone32.org/assets/gallery-1.webp" />
    <meta property="og:url" content="https://exoticaone32.org/" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Exotica One32" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Exotica One32 Sector 132 Noida | Grade A++ IT/ITES + Retail" />
    <meta name="twitter:description" content="5 acres, 2 towers, 27 floors. RERA UPRERAPRJ731857. IGBC Gold. Exotica Housing." />
    <meta name="twitter:image" content="https://exoticaone32.org/assets/gallery-1.webp" />

    <meta name="geo.region" content="IN-UP" />
    <meta name="geo.placename" content="Noida" />
    <meta name="geo.position" content="28.5086;77.3962" />
    <meta name="ICBM" content="28.5086, 77.3962" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/favicon/favicon.ico" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="assets/favicon/site.webmanifest" />
    <meta name="theme-color" content="#0B1220" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/styles.css" />

    <!-- Schema.org: CommercialProperty -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "@id": "https://exoticaone32.org/#business",
      "name": "Exotica One32",
      "alternateName": "Exotica Housing One32",
      "description": "Grade A++ commercial IT/ITES offices and high-street retail by Exotica Housing on Noida Expressway, Sector 132.",
      "image": "https://exoticaone32.org/assets/gallery-1.webp",
      "logo": "https://exoticaone32.org/assets/favicon/apple-touch-icon.png",
      "url": "https://exoticaone32.org/",
      "telephone": "+919412234688",
      "priceRange": "INR 60L - INR 4.2Cr+",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Sector 132, Noida Expressway",
        "addressLocality": "Noida",
        "addressRegion": "Uttar Pradesh",
        "postalCode": "201304",
        "addressCountry": "IN"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 28.5086,
        "longitude": 77.3962
      },
      "areaServed": {
        "@type": "Place",
        "name": "Noida, NCR, Uttar Pradesh"
      },
      "openingHoursSpecification": [{
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
        "opens": "09:00",
        "closes": "20:00"
      }],
      "identifier": {
        "@type": "PropertyValue",
        "propertyID": "RERA",
        "value": "UPRERAPRJ731857"
      }
    }
    </script>

    <!-- Schema.org: Organization -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "@id": "https://exoticaone32.org/#developer",
      "name": "Exotica Housing",
      "url": "https://exoticaone32.org/",
      "description": "Exotica Housing is an Indian real estate developer delivering premium residential and commercial projects across the Delhi-NCR region.",
      "foundingLocation": {
        "@type": "Place",
        "name": "Noida, India"
      },
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Noida",
        "addressRegion": "Uttar Pradesh",
        "addressCountry": "IN"
      }
    }
    </script>

    <!-- Schema.org: FAQPage -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {"@type":"Question","name":"What is the price per sq ft at Exotica One32?","acceptedAnswer":{"@type":"Answer","text":"Office spaces at Exotica One32 are priced at INR 13,990 per sq ft. The starting ticket size is approximately INR 1.07 crore for a 1,000 sq ft office unit. Retail units start at around INR 60 lakh."}},
        {"@type":"Question","name":"What is the RERA number for Exotica One32?","acceptedAnswer":{"@type":"Answer","text":"Exotica One32 is registered under UP RERA with registration number UPRERAPRJ731857."}},
        {"@type":"Question","name":"When is possession of Exotica One32?","acceptedAnswer":{"@type":"Answer","text":"Phase 1 possession at Exotica One32 is scheduled for January 2030."}},
        {"@type":"Question","name":"Is Exotica One32 residential or commercial?","acceptedAnswer":{"@type":"Answer","text":"Exotica One32 is a 100 percent commercial project featuring Grade A++ IT/ITES office spaces and high-street retail units. There are no residential units."}},
        {"@type":"Question","name":"What office sizes are available at Exotica One32?","acceptedAnswer":{"@type":"Answer","text":"Office units range from 1,000 sq ft to 3,000 sq ft. Retail units range from 356 sq ft to 1,183 sq ft."}},
        {"@type":"Question","name":"Who is the developer of Exotica One32?","acceptedAnswer":{"@type":"Answer","text":"Exotica One32 is developed by Exotica Housing, an established real estate developer with a track record of residential and commercial projects in Delhi-NCR."}},
        {"@type":"Question","name":"Is Exotica One32 IGBC or LEED certified?","acceptedAnswer":{"@type":"Answer","text":"Yes. Exotica One32 is designed to IGBC Gold standards and LEED Platinum certification has been applied for. Sustainable features include solar energy, rainwater harvesting and low-VOC materials."}},
        {"@type":"Question","name":"What payment plans are available at Exotica One32?","acceptedAnswer":{"@type":"Answer","text":"A flexible payment plan is available on request. Please contact our investment desk at +91 9412 234 688 for the current schedule."}},
        {"@type":"Question","name":"How far is Exotica One32 from the metro?","acceptedAnswer":{"@type":"Answer","text":"Sector 137 Metro Station on the Aqua Line is approximately 5 minutes from Exotica One32. DND Flyway is about 20 minutes and Jewar International Airport is about 40 minutes away."}},
        {"@type":"Question","name":"How much parking is available at Exotica One32?","acceptedAnswer":{"@type":"Answer","text":"Exotica One32 offers 1,400 plus multi-level parking bays with AI-assisted parking management, covering both visitor and tenant requirements."}},
        {"@type":"Question","name":"What is the total size of Exotica One32?","acceptedAnswer":{"@type":"Answer","text":"Exotica One32 sits on a 5 acre land parcel with 2 towers of 27 floors each, featuring a 4.5 metre floor-to-floor height, and is backed by an investment of INR 500 crore."}},
        {"@type":"Question","name":"Are assured returns offered at Exotica One32?","acceptedAnswer":{"@type":"Answer","text":"No assured returns are offered. Any return potential depends on market conditions. We encourage buyers to conduct independent due diligence and review the RERA disclosures before investment."}}
      ]
    }
    </script>

    <!-- Schema.org: BreadcrumbList -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {"@type":"ListItem","position":1,"name":"Home","item":"https://exoticaone32.org/"},
        {"@type":"ListItem","position":2,"name":"Commercial - Sector 132 Noida","item":"https://exoticaone32.org/#overview"},
        {"@type":"ListItem","position":3,"name":"Exotica One32","item":"https://exoticaone32.org/#contact"}
      ]
    }
    </script>
</head>
<body id="top">

<?php include __DIR__ . '/includes/header.php'; ?>

<!-- =========== HERO =========== -->
<section class="hero" aria-label="Exotica One32 hero">
    <div class="container hero-grid">
        <div class="hero-copy reveal">
            <span class="eyebrow">Grade A++ &middot; Sector 132 Noida</span>
            <h1 class="display">Exotica One32</h1>
            <p class="hero-sub">
                A five-acre commercial address on the Noida Expressway by Exotica
                Housing. Two towers. Twenty seven floors. IT/ITES offices and
                high-street retail designed for India's next generation of businesses.
            </p>
            <div class="hero-meta">
                <span class="chip">RERA <strong>UPRERAPRJ731857</strong></span>
                <span class="chip">Jan <strong>2030</strong> Possession</span>
                <span class="chip"><strong>IGBC Gold</strong> &middot; LEED Platinum (Applied)</span>
            </div>
            <div class="hero-cta">
                <a href="#contact" class="btn btn-primary">Request Price Sheet</a>
                <a href="tel:+919412234688" class="btn btn-ghost-light">Call +91 9412 234 688</a>
            </div>
        </div>

        <aside class="hero-form reveal" aria-label="Enquiry form">
            <h3>Book a Private Walkthrough</h3>
            <p class="form-sub">Receive floor plans, price sheet and payment plan.</p>
            <form class="lead-form" method="POST" action="process-form.php" novalidate>
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                <input type="hidden" name="form_source" value="hero_form">

                <div class="form-field">
                    <label for="hero-name">Full Name</label>
                    <input id="hero-name" type="text" name="name" placeholder="Your name" required minlength="2" maxlength="100" autocomplete="name">
                </div>
                <div class="form-row">
                    <div class="form-field">
                        <label for="hero-email">Email</label>
                        <input id="hero-email" type="email" name="email" placeholder="you@example.com" required autocomplete="email">
                    </div>
                    <div class="form-field">
                        <label for="hero-phone">Phone</label>
                        <input id="hero-phone" type="tel" name="phone" placeholder="10-digit mobile" required autocomplete="tel" pattern="[0-9]{10,15}">
                    </div>
                </div>
                <div class="form-field">
                    <label for="hero-interest">Interested In</label>
                    <select id="hero-interest" name="interested_in">
                        <option value="Office Space">Office Space (1,000 - 3,000 sq ft)</option>
                        <option value="Retail Unit">Retail Unit (356 - 1,183 sq ft)</option>
                        <option value="Investment Enquiry">Investment Enquiry</option>
                        <option value="Site Visit">Site Visit</option>
                    </select>
                </div>
                <button class="btn btn-primary form-submit" type="submit">Send Enquiry</button>
                <p class="form-legal">By submitting, you agree to be contacted about Exotica One32. Your data is never sold.</p>
                <div class="form-msg" role="status" aria-live="polite"></div>
            </form>
        </aside>
    </div>
</section>

<!-- =========== TRUST STRIP =========== -->
<section class="trust-strip" style="padding-top:28px;padding-bottom:28px">
    <div class="container">
        <div class="trust-item">
            <span class="t-label">RERA</span>
            <strong>UPRERAPRJ731857</strong>
        </div>
        <div class="trust-item">
            <span class="t-label">Certification</span>
            <strong>IGBC Gold</strong>
        </div>
        <div class="trust-item">
            <span class="t-label">Applied</span>
            <strong>LEED Platinum</strong>
        </div>
        <div class="trust-item">
            <span class="t-label">Investment</span>
            <strong>INR 500 Cr</strong>
        </div>
        <div class="trust-item">
            <span class="t-label">Developer</span>
            <strong>Exotica Housing</strong>
        </div>
    </div>
</section>

<!-- =========== KEY FACTS =========== -->
<section class="facts" id="facts" aria-labelledby="facts-head">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">At A Glance</span>
            <h2 id="facts-head">The Numbers</h2>
            <p>A five-acre canvas engineered for Grade A++ corporate occupiers.</p>
        </div>
        <div class="facts-grid">
            <div class="fact reveal"><div class="num">5</div><div class="lbl">Acres</div></div>
            <div class="fact reveal"><div class="num">2</div><div class="lbl">Towers</div></div>
            <div class="fact reveal"><div class="num">27</div><div class="lbl">Floors Each</div></div>
            <div class="fact reveal"><div class="num">4.5 m</div><div class="lbl">Floor To Floor</div></div>
            <div class="fact reveal"><div class="num">1,400+</div><div class="lbl">Car Parks</div></div>
            <div class="fact reveal"><div class="num">13,990</div><div class="lbl">INR / Sq Ft</div></div>
        </div>
    </div>
</section>

<!-- =========== OVERVIEW =========== -->
<section class="overview" id="overview">
    <div class="container overview-grid">
        <div class="reveal">
            <span class="eyebrow">Overview</span>
            <h2 style="text-align:left;margin-bottom:1rem">A Landmark Commercial Address on Noida Expressway.</h2>
        </div>
        <div class="reveal">
            <p class="overview-lede">
                Exotica One32 is a 5-acre Grade A++ IT/ITES and retail development by
                Exotica Housing in Sector 132, Noida Expressway. Two towers rise 27
                floors each with a 4.5 metre floor-to-floor height, delivering
                offices from 1,000 to 3,000 sq ft at INR 13,990 per sq ft and retail
                units from 356 to 1,183 sq ft. Registered under UP RERA as
                UPRERAPRJ731857, backed by INR 500 crore investment, certified to
                IGBC Gold with LEED Platinum applied, Phase 1 possession is
                scheduled for January 2030.
            </p>
            <details>
                <summary>Read full project context</summary>
                <p>
                    Sector 132 sits on the Noida Expressway corridor, one of the
                    fastest-growing commercial belts in the National Capital Region.
                    Exotica One32 is positioned to capture demand from IT/ITES
                    occupiers seeking large, column-free floor plates with 4.5 metre
                    slab heights, VRV-ready HVAC provisions, biometric access control
                    and a double-height entrance lobby. The project offers 1,400 plus
                    multi-level parking bays managed by an AI-assisted system, a
                    double-height drop off, landscaped plaza and direct visibility
                    from the expressway frontage.
                </p>
                <p>
                    Retail occupies the plaza level with 356 to 1,183 sq ft units
                    tailored for food and beverage, banking, wellness and lifestyle
                    brands servicing the captive office footfall plus the surrounding
                    residential micro-market. Connectivity is anchored by the Sector
                    137 Aqua Line metro (5 minutes), DND Flyway (20 minutes) and the
                    upcoming Jewar International Airport (40 minutes). Construction
                    targets the IGBC Gold framework with solar PV, rainwater
                    harvesting, low-VOC interiors and energy-efficient lighting;
                    LEED Platinum certification has been applied for. A flexible
                    payment plan is available on request.
                </p>
            </details>
        </div>
    </div>
</section>

<!-- =========== OPPORTUNITIES =========== -->
<section class="opps" id="opportunities">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Investment Opportunities</span>
            <h2>Two Ways To Own Exotica One32</h2>
            <p>Whether you are an end-user, investor or HNI, there is a footprint sized for you.</p>
        </div>
        <div class="opp-grid">
            <article class="opp-card reveal">
                <span class="eyebrow">Offices</span>
                <h3>Grade A++ IT/ITES Workspaces</h3>
                <div class="price">INR 13,990 / sq ft</div>
                <ul>
                    <li><span>Unit Sizes</span><span>1,000 - 3,000 sq ft</span></li>
                    <li><span>Starting Ticket</span><span>INR 1.07 Cr</span></li>
                    <li><span>Floor to Floor</span><span>4.5 metres</span></li>
                    <li><span>HVAC</span><span>VRV AC Ready</span></li>
                    <li><span>Access</span><span>Biometric + Card</span></li>
                </ul>
                <a href="#contact" class="btn btn-ghost">Request Office Floor Plan</a>
            </article>

            <article class="opp-card reveal">
                <span class="eyebrow">Retail</span>
                <h3>High-Street Retail on Plaza Level</h3>
                <div class="price">Starting INR 60 Lakh</div>
                <ul>
                    <li><span>Unit Sizes</span><span>356 - 1,183 sq ft</span></li>
                    <li><span>Frontage</span><span>Double Height</span></li>
                    <li><span>Footfall</span><span>Captive + Walk-in</span></li>
                    <li><span>Ideal For</span><span>F&amp;B, Bank, Wellness</span></li>
                    <li><span>Positioning</span><span>Plaza Level</span></li>
                </ul>
                <a href="#contact" class="btn btn-ghost">Request Retail Brochure</a>
            </article>
        </div>
    </div>
</section>

<!-- =========== FLOOR PLANS =========== -->
<section class="plans" id="plans">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Floor Plans</span>
            <h2>Configurations</h2>
            <p>Flexible footprints for startups, mid-caps and global occupiers.</p>
        </div>

        <div class="tabs" role="tablist">
            <button class="tab-btn active" data-tab="office" role="tab">Office Plans</button>
            <button class="tab-btn" data-tab="retail" role="tab">Retail Plans</button>
        </div>

        <div class="tab-panel plan-grid active" data-panel="office">
            <div class="plan-card reveal">
                <div class="size">1,000 Sq Ft</div>
                <div class="type">Starter Office</div>
                <div class="cost">From INR 1.07 Cr</div>
                <a href="#contact" class="btn btn-ghost">Request Plan</a>
            </div>
            <div class="plan-card reveal">
                <div class="size">1,800 Sq Ft</div>
                <div class="type">Mid Office</div>
                <div class="cost">From INR 2.51 Cr</div>
                <a href="#contact" class="btn btn-ghost">Request Plan</a>
            </div>
            <div class="plan-card reveal">
                <div class="size">3,000 Sq Ft</div>
                <div class="type">Large Floor</div>
                <div class="cost">From INR 4.19 Cr</div>
                <a href="#contact" class="btn btn-ghost">Request Plan</a>
            </div>
        </div>

        <div class="tab-panel plan-grid" data-panel="retail">
            <div class="plan-card reveal">
                <div class="size">356 Sq Ft</div>
                <div class="type">Kiosk Retail</div>
                <div class="cost">Starting INR 60 L</div>
                <a href="#contact" class="btn btn-ghost">Request Plan</a>
            </div>
            <div class="plan-card reveal">
                <div class="size">720 Sq Ft</div>
                <div class="type">Boutique Retail</div>
                <div class="cost">On Request</div>
                <a href="#contact" class="btn btn-ghost">Request Plan</a>
            </div>
            <div class="plan-card reveal">
                <div class="size">1,183 Sq Ft</div>
                <div class="type">Flagship Retail</div>
                <div class="cost">On Request</div>
                <a href="#contact" class="btn btn-ghost">Request Plan</a>
            </div>
        </div>
    </div>
</section>

<!-- =========== AMENITIES =========== -->
<section class="amenities" id="amenities">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Amenities</span>
            <h2>Everything Grade A++ Demands</h2>
            <p>Infrastructure, access and comfort engineered for corporate occupiers.</p>
        </div>

        <div class="amen-grid">
            <div class="amen-tile reveal">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><rect x="3" y="7" width="18" height="12" rx="1"/><path d="M7 7V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/></svg>
                <h4>1,400+ Parking Bays</h4>
                <p>Multi-level parking with AI-assisted slot allocation for tenants and visitors.</p>
            </div>
            <div class="amen-tile reveal">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M12 2 4 6v6c0 5 3.5 9.5 8 10 4.5-.5 8-5 8-10V6l-8-4Z"/></svg>
                <h4>Biometric Security</h4>
                <p>24x7 manned security with biometric + card access to every floor.</p>
            </div>
            <div class="amen-tile reveal">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M13 2 3 14h8l-1 8 10-12h-8l1-8Z"/></svg>
                <h4>100% Power Backup</h4>
                <p>Dual-source power with DG backup on every floor for uninterrupted operations.</p>
            </div>
            <div class="amen-tile reveal">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <h4>Double-Height Lobby</h4>
                <p>Grand double-height entrance lobby and drop-off that signals arrival.</p>
            </div>
            <div class="amen-tile reveal">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
                <h4>Solar + Sustainable</h4>
                <p>Rooftop solar, rainwater harvesting, low-VOC interiors, IGBC Gold framework.</p>
            </div>
            <div class="amen-tile reveal">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><rect x="3" y="4" width="18" height="14" rx="1"/><path d="M8 20h8M12 16v4"/></svg>
                <h4>Smart Conferencing</h4>
                <p>Dedicated conference zones, video-ready rooms and tenant-only business lounges.</p>
            </div>
        </div>

        <details class="amen-more">
            <summary>View All Amenities</summary>
            <ul>
                <li>High-speed passenger + service elevators</li>
                <li>Landscaped plaza and podium garden</li>
                <li>Food court and retail high street</li>
                <li>Electric vehicle charging bays</li>
                <li>Centralised VRV HVAC provisions</li>
                <li>Double-glazed facade for thermal efficiency</li>
                <li>Fire detection and wet-riser system per NBC</li>
                <li>CCTV coverage across all public areas</li>
                <li>Rainwater harvesting and grey-water recycling</li>
                <li>Dedicated drop-off and pickup zones</li>
                <li>Turnstile access at lobby entry</li>
                <li>Low-VOC materials across common areas</li>
            </ul>
        </details>
    </div>
</section>

<!-- =========== SUSTAINABILITY =========== -->
<section class="sustain">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Sustainability</span>
            <h2>Built Green, By Design</h2>
            <p>Certifications and systems that cut operating cost and embodied carbon.</p>
        </div>
        <div class="sustain-row">
            <div class="sustain-item reveal"><h4>IGBC Gold</h4><p>Framework targeted</p></div>
            <div class="sustain-item reveal"><h4>LEED Platinum</h4><p>Application filed</p></div>
            <div class="sustain-item reveal"><h4>Solar PV</h4><p>Rooftop generation</p></div>
            <div class="sustain-item reveal"><h4>Rainwater Harvest</h4><p>On-site recharge</p></div>
        </div>
    </div>
</section>

<!-- =========== LOCATION =========== -->
<section class="location" id="location">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Location</span>
            <h2>Sector 132, Noida Expressway</h2>
            <p>Five minutes from the metro. Twenty minutes from DND. Forty from Jewar.</p>
        </div>
        <div class="loc-grid">
            <ul class="loc-list reveal">
                <li><span>Sector 137 Metro Station (Aqua Line)</span><span>5 Min</span></li>
                <li><span>Noida Expressway (frontage)</span><span>0 Min</span></li>
                <li><span>DND Flyway</span><span>20 Min</span></li>
                <li><span>Kalindi Kunj</span><span>25 Min</span></li>
                <li><span>Connaught Place, Delhi</span><span>35 Min</span></li>
                <li><span>Jewar International Airport</span><span>40 Min</span></li>
                <li><span>Fortis Hospital, Sector 62</span><span>15 Min</span></li>
                <li><span>Jaypee Greens Golf Course</span><span>10 Min</span></li>
            </ul>
            <div class="loc-hero reveal">
                <span class="eyebrow">Connectivity</span>
                <h3>At the heart of Noida's commercial corridor.</h3>
                <p>
                    Exotica One32 fronts the Noida-Greater Noida Expressway with a
                    five-minute approach to Sector 137 metro on the Aqua Line, giving
                    tenants and retail customers seamless access from Noida, Greater
                    Noida, Delhi and the upcoming Jewar Airport catchment.
                </p>
                <p style="margin-top:1rem">
                    <a href="https://www.google.com/maps/search/Sector+132+Noida" target="_blank" rel="noopener" class="btn btn-ghost-light">Open In Maps</a>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- =========== SPECIFICATIONS =========== -->
<section class="specs" id="specifications">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Specifications</span>
            <h2>Engineered To Grade A++ Standards</h2>
            <p>Floor plates, systems and finishes that corporate occupiers demand.</p>
        </div>
        <div class="spec-grid">
            <div class="spec-item reveal"><h4>4.5 m Floor To Floor</h4><p>Full slab-to-slab height allowing raised floors, acoustic ceilings and flexible MEP routing.</p></div>
            <div class="spec-item reveal"><h4>VRV HVAC Ready</h4><p>Provision for variable refrigerant volume air conditioning with dedicated AHU cutouts per floor.</p></div>
            <div class="spec-item reveal"><h4>Biometric Access</h4><p>Biometric and card-based access control at lobby, turnstiles, elevators and office entries.</p></div>
            <div class="spec-item reveal"><h4>Double-Height Lobby</h4><p>Imposing entrance lobby with stone finishes, tenant signage zones and visitor management.</p></div>
            <div class="spec-item reveal"><h4>High-Speed Elevators</h4><p>Passenger and dedicated service elevators with destination-dispatch control for peak loads.</p></div>
            <div class="spec-item reveal"><h4>DG + UPS Provision</h4><p>Full power backup with dedicated DG sets; tenant UPS provision for mission-critical floors.</p></div>
        </div>
    </div>
</section>

<!-- =========== GALLERY =========== -->
<section class="gallery" id="gallery">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Gallery</span>
            <h2>A Visual Walkthrough</h2>
            <p>Renderings of architecture, plaza, lobby and surrounds.</p>
        </div>
        <div class="gal-grid">
            <div class="gal-item reveal"><img src="assets/gallery-1.webp" alt="Exotica One32 facade rendering" loading="lazy"></div>
            <div class="gal-item reveal"><img src="assets/gallery-2.webp" alt="Exotica One32 plaza level retail" loading="lazy"></div>
            <div class="gal-item reveal"><img src="assets/gallery-3.webp" alt="Exotica One32 double height lobby" loading="lazy"></div>
            <div class="gal-item reveal"><img src="assets/gallery-1.webp" alt="Exotica One32 tower elevation" loading="lazy"></div>
            <div class="gal-item reveal"><img src="assets/gallery-2.webp" alt="Exotica One32 office floor plate" loading="lazy"></div>
            <div class="gal-item reveal"><img src="assets/gallery-3.webp" alt="Exotica One32 landscape podium" loading="lazy"></div>
        </div>
    </div>
</section>

<!-- =========== ABOUT DEVELOPER =========== -->
<section class="about" id="about">
    <div class="container about-grid">
        <div class="reveal">
            <img src="assets/gallery-2.webp" alt="Exotica Housing developer profile" loading="lazy">
        </div>
        <div class="reveal">
            <span class="eyebrow">About the Developer</span>
            <h2 style="text-align:left;margin-bottom:1rem">Exotica Housing</h2>
            <p style="color:var(--text-muted);margin-bottom:1rem">
                Exotica Housing is a Delhi-NCR real estate developer with a track
                record of residential and commercial projects across Noida, Ghaziabad
                and the NCR corridor. With Exotica One32, the group enters the
                Grade A++ commercial market on Noida Expressway, committing INR 500
                crore of investment to a 5-acre IT/ITES and retail landmark.
            </p>
            <p style="color:var(--text-muted);margin-bottom:1.5rem">
                The project is registered under UP RERA (UPRERAPRJ731857) and
                designed to IGBC Gold standards, with LEED Platinum certification
                applied for.
            </p>
            <a href="#contact" class="btn btn-ghost">Speak to the Team</a>
        </div>
    </div>
</section>

<!-- =========== FAQ =========== -->
<section class="faq" id="faq">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">Frequently Asked</span>
            <h2>Answers, Straight Up</h2>
            <p>Everything buyers and tenants ask before booking Exotica One32.</p>
        </div>
        <div class="faq-list">
            <details class="faq-item reveal"><summary>What is the price per sq ft at Exotica One32?</summary><div class="faq-body">Office spaces at Exotica One32 are priced at INR 13,990 per sq ft. The starting ticket size is approximately INR 1.07 crore for a 1,000 sq ft office unit. Retail units start at around INR 60 lakh.</div></details>
            <details class="faq-item reveal"><summary>What is the RERA number for Exotica One32?</summary><div class="faq-body">Exotica One32 is registered under UP RERA with registration number <strong>UPRERAPRJ731857</strong>. Please verify this directly on the UP RERA portal before any transaction.</div></details>
            <details class="faq-item reveal"><summary>When is possession of Exotica One32?</summary><div class="faq-body">Phase 1 possession at Exotica One32 is scheduled for January 2030 as per the developer's RERA disclosure.</div></details>
            <details class="faq-item reveal"><summary>Is Exotica One32 residential or commercial?</summary><div class="faq-body">Exotica One32 is a 100 percent commercial project. It comprises Grade A++ IT/ITES office spaces across two towers and high-street retail units at plaza level. There are no residential units.</div></details>
            <details class="faq-item reveal"><summary>What office unit sizes are available?</summary><div class="faq-body">Office units range from 1,000 sq ft to 3,000 sq ft, giving flexibility for startups, mid-caps and larger corporate occupiers. Retail units range from 356 sq ft to 1,183 sq ft.</div></details>
            <details class="faq-item reveal"><summary>Who is the developer of Exotica One32?</summary><div class="faq-body">The developer is <strong>Exotica Housing</strong>, an established Delhi-NCR real estate group delivering residential and commercial projects. Exotica One32 represents the group's commitment to the Noida Expressway commercial market.</div></details>
            <details class="faq-item reveal"><summary>Is Exotica One32 IGBC and LEED certified?</summary><div class="faq-body">Yes. Exotica One32 is designed to IGBC Gold standards and LEED Platinum certification has been applied for. Sustainability features include rooftop solar, rainwater harvesting, low-VOC materials and energy-efficient lighting.</div></details>
            <details class="faq-item reveal"><summary>What payment plans are available?</summary><div class="faq-body">A flexible payment plan is available on request. Contact our investment desk at <a href="tel:+919412234688">+91 9412 234 688</a> for the current schedule.</div></details>
            <details class="faq-item reveal"><summary>How far is Exotica One32 from the metro?</summary><div class="faq-body">Sector 137 Metro Station on the Noida Aqua Line is approximately 5 minutes from Exotica One32. DND Flyway is about 20 minutes and Jewar International Airport is about 40 minutes away.</div></details>
            <details class="faq-item reveal"><summary>How much parking is available?</summary><div class="faq-body">Exotica One32 offers 1,400 plus multi-level parking bays with AI-assisted parking management, covering both visitor and tenant requirements.</div></details>
            <details class="faq-item reveal"><summary>What is the total project size?</summary><div class="faq-body">The project sits on a 5 acre land parcel with 2 towers of 27 floors each, featuring a 4.5 metre floor-to-floor height. Total committed investment is INR 500 crore.</div></details>
            <details class="faq-item reveal"><summary>Are assured returns offered?</summary><div class="faq-body">No assured returns are offered. Any return potential depends on market conditions. We encourage buyers to conduct independent due diligence and review the RERA disclosures before investment.</div></details>
        </div>
    </div>
</section>

<!-- =========== SEO LONG FORM =========== -->
<section class="seo-long" id="seo-long">
    <div class="container">
        <div class="section-head reveal" style="text-align:left">
            <span class="eyebrow">Deep Dive</span>
            <h2 style="text-align:left">Exotica One32 in Detail</h2>
        </div>

        <p class="lede">
            Exotica One32 is a 5-acre Grade A++ IT/ITES and retail development by
            Exotica Housing in Sector 132, Noida Expressway. Two towers rise 27
            floors each with a 4.5 metre floor-to-floor height, delivering offices
            from 1,000 to 3,000 sq ft at INR 13,990 per sq ft and retail units from
            356 to 1,183 sq ft. Registered under UP RERA as UPRERAPRJ731857, backed
            by INR 500 crore investment, certified to IGBC Gold with LEED Platinum
            applied, Phase 1 possession is scheduled for January 2030.
        </p>

        <table class="facts-table" aria-label="Exotica One32 key facts">
            <tbody>
                <tr><th>Project</th><td>Exotica One32</td></tr>
                <tr><th>Developer</th><td>Exotica Housing</td></tr>
                <tr><th>Location</th><td>Sector 132, Noida Expressway, UP 201304</td></tr>
                <tr><th>Type</th><td>Grade A++ Commercial (IT/ITES + Retail)</td></tr>
                <tr><th>RERA</th><td>UPRERAPRJ731857</td></tr>
                <tr><th>Land Area</th><td>5 acres</td></tr>
                <tr><th>Configuration</th><td>2 towers, 27 floors each</td></tr>
                <tr><th>Floor to Floor</th><td>4.5 metres</td></tr>
                <tr><th>Office Sizes</th><td>1,000 - 3,000 sq ft</td></tr>
                <tr><th>Office Price</th><td>INR 13,990 per sq ft</td></tr>
                <tr><th>Office Ticket</th><td>From INR 1.07 Cr</td></tr>
                <tr><th>Retail Sizes</th><td>356 - 1,183 sq ft</td></tr>
                <tr><th>Retail Ticket</th><td>From INR 60 Lakh</td></tr>
                <tr><th>Parking</th><td>1,400+ (AI-assisted)</td></tr>
                <tr><th>Investment</th><td>INR 500 Crore</td></tr>
                <tr><th>Certifications</th><td>IGBC Gold; LEED Platinum (applied)</td></tr>
                <tr><th>Possession</th><td>January 2030 (Phase 1)</td></tr>
                <tr><th>Payment Plan</th><td>Flexible (on request)</td></tr>
            </tbody>
        </table>

        <details>
            <summary>Read full long-form guide</summary>
            <article>
                <h3>Why Sector 132 Noida Matters</h3>
                <p>
                    Sector 132 is part of the Noida-Greater Noida Expressway corridor, a
                    16-kilometre commercial belt that has emerged as the primary
                    Grade A office destination in the eastern NCR. The corridor stretches
                    from Kalindi Kunj in the north to Pari Chowk in the south and is
                    anchored by the Noida Aqua Line metro, a 29-station rapid-transit
                    route linking the expressway with Sector 51 in central Noida.
                    Sector 132 itself sits between Sectors 137 and 168, with direct
                    expressway frontage and the Sector 137 Aqua Line metro approximately
                    five minutes away - making it one of the best-connected sub-markets
                    for corporate occupiers.
                </p>

                <h3>The Exotica One32 Design Brief</h3>
                <p>
                    Exotica One32 is designed to meet the infrastructure expectations
                    of global IT/ITES occupiers: large floor plates, column-optimised
                    layouts, generous slab-to-slab heights and MEP routing capacity
                    for high-density tenant build-outs. The two towers rise 27 floors
                    each, delivering offices sized between 1,000 and 3,000 sq ft
                    priced at INR 13,990 per sq ft. The 4.5 metre floor-to-floor
                    height accommodates raised floors, acoustic ceilings, generous
                    cable trays and dedicated AHU cutouts for variable refrigerant
                    volume HVAC installations - the specification GCCs and large SaaS
                    occupiers now expect as standard.
                </p>

                <h3>Retail, Plaza and Placemaking</h3>
                <p>
                    The plaza level is given over to 356 to 1,183 sq ft retail units
                    engineered for F&amp;B, banking, pharmacy, wellness and lifestyle
                    brands that serve the captive office footfall as well as the
                    surrounding Sector 132/137 residential micro-market. Double-height
                    frontages, an open landscaped plaza and a pedestrian-friendly
                    drop-off zone create the conditions for a genuine high-street
                    experience rather than a service podium. Retail units start at
                    approximately INR 60 lakh.
                </p>

                <h3>Connectivity and Drive Times</h3>
                <p>
                    Exotica One32 is built on the expressway frontage itself, which
                    places it five minutes from Sector 137 metro on the Noida Aqua
                    Line, about 20 minutes from the DND Flyway and 35 minutes from
                    Connaught Place at normal traffic. The upcoming Jewar (Noida
                    International) Airport is approximately 40 minutes away - an
                    important factor for multinational tenants expecting same-day
                    airport access for senior executives. Nearby anchors include
                    Jaypee Greens Golf Course (10 minutes), Fortis Hospital Sector 62
                    (15 minutes) and the Advant Navis Business Park (10 minutes).
                </p>

                <h3>Sustainability Commitments</h3>
                <p>
                    Construction targets the IGBC Gold framework with rooftop solar
                    photovoltaic generation, rainwater harvesting and on-site
                    recharge, grey-water recycling, low-VOC interior materials,
                    double-glazed facade glazing for thermal efficiency and
                    energy-efficient LED lighting across common areas. LEED Platinum
                    certification has been applied for. These commitments translate
                    into measurable reductions in operating cost for occupiers as
                    well as alignment with the ESG reporting obligations that most
                    corporate tenants now carry.
                </p>

                <h3>Investment Thesis</h3>
                <p>
                    At INR 13,990 per sq ft, Exotica One32 sits competitively against
                    other Grade A office addresses on the Noida Expressway corridor.
                    Buyer categories include self-use occupiers from the IT/ITES,
                    BFSI and professional services sectors, HNI investors seeking
                    rental yield from captive corporate demand, and end-users from
                    F&amp;B and retail brands targeting the plaza frontage. No
                    assured returns are offered. Payment is structured on a flexible
                    payment plan available on request. Buyers should independently
                    review the UP RERA disclosure (UPRERAPRJ731857), the builder
                    buyer agreement and construction milestones before any
                    transaction.
                </p>

                <h3>Why Exotica Housing</h3>
                <p>
                    Exotica Housing brings a Delhi-NCR delivery track record to the
                    Noida Expressway commercial market with Exotica One32. The group
                    has committed INR 500 crore of investment to the 5-acre site and
                    is executing the project with the RERA disclosure and IGBC Gold
                    framework in place from day one. For buyers, this means
                    regulatory visibility, a credible construction timeline and a
                    sustainability proposition baked into the core specification
                    rather than bolted on as an afterthought.
                </p>
            </article>
        </details>
    </div>
</section>

<!-- =========== FINAL CTA =========== -->
<section class="cta-final" id="contact">
    <div class="container">
        <div class="cta-grid">
            <div class="cta-info reveal">
                <span class="eyebrow">Book A Walkthrough</span>
                <h2 style="text-align:left">Let's talk numbers, floor plans and payment plans.</h2>
                <p>
                    Our senior investment team will share the current price sheet,
                    inventory status, floor plans and the flexible payment plan. All
                    enquiries are routed to a human, not a chatbot.
                </p>
                <div class="cta-contact">
                    <a href="tel:+919412234688">
                        <span class="ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.86 19.86 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.86 19.86 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
                        </span>
                        <span><strong>+91 9412 234 688</strong><br><small style="color:rgba(239,233,220,.6)">Direct call to investment desk</small></span>
                    </a>
                    <a href="https://wa.me/919412234688?text=Hi%2C%20I%27m%20interested%20in%20Exotica%20One32%20Sector%20132%20Noida" target="_blank" rel="noopener">
                        <span class="ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11.78 11.78 0 0 0 12 0a11.9 11.9 0 0 0-10.3 17.9L0 24l6.3-1.65A11.92 11.92 0 0 0 12 23.9c6.6 0 11.93-5.35 11.93-11.94 0-3.17-1.24-6.18-3.43-8.46Z"/></svg>
                        </span>
                        <span><strong>WhatsApp Us</strong><br><small style="color:rgba(239,233,220,.6)">Instant brochure + floor plans</small></span>
                    </a>
                </div>
            </div>

            <div class="hero-form reveal" style="background:rgba(17,26,46,.8)">
                <h3>Request Private Walkthrough</h3>
                <p class="form-sub">Our team will call you within 24 hours.</p>
                <form class="lead-form" method="POST" action="process-form.php" novalidate>
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                    <input type="hidden" name="form_source" value="final_cta_form">

                    <div class="form-field">
                        <label for="cta-name">Full Name</label>
                        <input id="cta-name" type="text" name="name" required minlength="2" maxlength="100" autocomplete="name" placeholder="Your name">
                    </div>
                    <div class="form-row">
                        <div class="form-field">
                            <label for="cta-email">Email</label>
                            <input id="cta-email" type="email" name="email" required autocomplete="email" placeholder="you@example.com">
                        </div>
                        <div class="form-field">
                            <label for="cta-phone">Phone</label>
                            <input id="cta-phone" type="tel" name="phone" required autocomplete="tel" placeholder="10-digit mobile" pattern="[0-9]{10,15}">
                        </div>
                    </div>
                    <div class="form-field">
                        <label for="cta-interest">Interested In</label>
                        <select id="cta-interest" name="interested_in">
                            <option value="Office Space">Office Space (1,000 - 3,000 sq ft)</option>
                            <option value="Retail Unit">Retail Unit (356 - 1,183 sq ft)</option>
                            <option value="Investment Enquiry">Investment Enquiry</option>
                            <option value="Site Visit">Site Visit</option>
                        </select>
                    </div>
                    <button class="btn btn-primary form-submit" type="submit">Request Callback</button>
                    <p class="form-legal">By submitting, you agree to be contacted about Exotica One32.</p>
                    <div class="form-msg" role="status" aria-live="polite"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
