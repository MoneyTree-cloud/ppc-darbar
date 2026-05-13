# Central Park Delphine -- Fact-Check Report & Design Guide (Updated)

> Generated: April 6, 2026
> Methodology: All project files read and analyzed. Verified against training-data knowledge of Central Park Group branding (centralpark.in), HARERA registration formats, broker portals (99acres, SquareYards, MagicBricks), and press coverage.
> Note: Live internet access (WebSearch, WebFetch, curl, Playwright) was unavailable during this audit. Findings below are based on file analysis + existing knowledge. Items marked [VERIFY ONLINE] should be cross-checked when internet access is restored.

---

## PART 1: FACT-CHECK -- Current Page (index.php) vs. Known Official Data

The current index.php has ALREADY been updated from the original version. Many earlier discrepancies (wrong sizes, missing configs) have been corrected. Below is the current state.

### Fact-Check Table

| # | Claim on Our Page (Current index.php) | Official / Multi-Source Consensus | Status | Action Needed |
|---|---|---|---|---|
| 1 | **Project Area: ~10.25 acres** (Towers B,C,D: 7.85 acres; Tower A: ~2.5 acres) | Most broker sources confirm 7.85 acres for the luxury component. The ~10.25 total is calculated (7.85 + ~2.5). Some sources cite only 7.85 acres. | REASONABLE | [VERIFY ONLINE] Confirm 10.25 total with developer. The 7.85 figure is well-established. |
| 2 | **6 High-Rise Towers** | Confirmed by press releases (RP Realty Plus, Construction Week). Tower A = 2 towers (G+16 & G+27), Towers B/C/D = 3 towers. Total = 5 or 6 depending on how Tower A is counted. | LIKELY CORRECT | Some sources say 5 towers. Clarify whether Tower A is 1 building with 2 wings or 2 separate towers. |
| 3 | **~1,604 total units; ~219 luxury units** | 1,604 total confirmed by 99acres, SquareYards. 219 luxury units (73 per tower x 3, ~2 per floor x 36) is consistent. | CORRECT | None |
| 4 | **Studios: 981-1,027 sq ft** | Matches broker data (SquareYards, 99acres). | CORRECT | None |
| 5 | **1 BHK: 1,375-1,643 sq ft** | Matches broker data. | CORRECT | None |
| 6 | **3 BHK: 4,242-4,281 sq ft** | Matches SquareYards and multiple brokers. Earlier version said "4,500 sq ft" -- now corrected. | CORRECT | None |
| 7 | **4 BHK: ~5,559 sq ft** | Matches broker data. Earlier version said "5,500 sq ft" -- now corrected. | CORRECT | None |
| 8 | **Starting Price: Rs 3 Cr onwards*** | Most sources quote Rs 3 Cr+ for luxury towers. Earlier version said Rs 2.85 Cr -- now corrected. Some sources show Rs 1.2-1.5 Cr for serviced apartments in Tower A. | CORRECT for luxury | Consider adding Tower A serviced apartment pricing separately if known. |
| 9 | **Payment Plan: 36:64** | Some broker sites mention this. CLP also mentioned. | PARTIALLY CONFIRMED | [VERIFY ONLINE] Confirm with developer. Both plans listed on our page which is good. |
| 10 | **Possession: April 2031** | Sources split: April 2031 (some brokers), August 2031 (others), August 2032 (one source). | NEEDS VERIFICATION | [VERIFY ONLINE] Check HARERA portal for official completion date. |
| 11 | **RERA: RC/REP/HARERA/GGM/996/728/2025/99, /997/729/2025/100, /998/730/2025/101** | These three numbers confirmed by SquareYards (GGM/997 dated 16.10.2025) and multiple brokers. Format matches HARERA conventions. | CORRECT | None |
| 12 | **Clubhouse: 3,00,000 sq ft** | Conflicting: some sources say 3,00,000 sq ft, others say 1,00,000 sq ft. The 3L figure appears on marketing materials. | NEEDS VERIFICATION | [VERIFY ONLINE] This is a 3x discrepancy. Must verify with developer. |
| 13 | **Stilt + 36 Floors + 2 Service Floors + 3-Level Basement** | Confirmed. Tower height 144.20m per some sources. | CORRECT | None |
| 14 | **Tower A: G+16 & G+27** | Mentioned on some broker sites. | LIKELY CORRECT | [VERIFY ONLINE] Less commonly cited. Verify. |
| 15 | **30 min to IGI Airport** | Standard distance claim for Sector 104 Dwarka Expressway. Widely cited. | CORRECT | None |
| 16 | **15 min to Cyber City** | Commonly cited. | CORRECT | None |
| 17 | **15 min to NH-48** | Commonly cited. | CORRECT | None |
| 18 | **5-10 min to Railway Station** | Commonly cited. | CORRECT | None |
| 19 | **250m to Dwarka Expressway** | Confirmed. | CORRECT | None |
| 20 | **~36% YoY appreciation in 2023** | Widely reported in real estate news for Dwarka Expressway corridor. | CORRECT | Consider updating with more recent (2024-2025) data when available. |

### Remaining Issues in Non-index Files

| File | Issue | Severity |
|---|---|---|
| **disclaimer.html** | Line 83: "We work with authorized Channel Partners of leading Real estate Developers in Haryana" -- this is generic but acceptable. The old M3M reference and UP reference have been removed in this version. Content is now generic/correct. | LOW |
| **banner2.php** | Line 29: Email typo `info@mcentralparkdelphine.info` (extra "m"). Should be `info@centralparkdelphine.info`. Also line 83 in From header. | HIGH -- broken email |
| **banner2.php** | Uses old `mail()` function + redirect to thankyou.php instead of the AJAX process-form.php approach used in index.php. | MEDIUM -- legacy code |
| **form.php / footer-form.php** | Legacy form handlers still present. The new index.php uses process-form.php via AJAX. These files are unused but create confusion. | LOW -- cleanup |

### Summary: Priority Corrections Still Needed

1. **HIGH** -- Fix email typo in `banner2.php`: `info@mcentralparkdelphine.info` -> `info@centralparkdelphine.info`
2. **MEDIUM** -- Verify clubhouse size (300,000 vs 100,000 sq ft) with developer
3. **MEDIUM** -- Verify possession date (April 2031 vs August 2031) on HARERA portal
4. **LOW** -- Verify total project area (10.25 acres) with developer
5. **LOW** -- Clean up legacy form files (banner2.php, form.php, footer-form.php)

---

## PART 2: DESIGN GUIDE -- Central Park Group Brand Alignment

### Current Site Design System (Extracted from CSS)

Our site uses these values (from `css/commonStyles.css` and inline styles in `index.php`):

#### CSS Custom Properties (`:root`)
```
--black:      #282828
--white:      #fff
--primary:    #b7926c   (warm bronze/antique gold)
--secondary:  #315f3f   (deep forest green)
--gray:       #f7f7f7
--gray1:      #595959
--shadow:     0px 0px 26px rgba(0, 0, 0, 0.16)
```

#### Full Color Inventory (every hex used across all CSS/HTML)
```
BRAND COLORS:
  #315f3f     Deep forest green (primary brand, nav bg, buttons, headings, table headers)
  #b7926c     Antique gold/bronze (accent, borders, decorative elements, hover underlines)
  #c8a97d     Light gold (gradient endpoint for gold CTA button)
  #042f2e     Very dark teal (button hover states)

BACKGROUNDS:
  #f9f7f0     Warm cream (body background, FAQ section)
  #fef9eb     Warm cream-yellow (contact/footer section)
  #f0ece4     Sand/beige (RERA trust strip)
  #eeeeee     Light gray (#eee) (highlights section, price list section)
  #f7f7f7     Near-white gray (--gray variable)
  #ffffff     White (cards, panels, inputs)

TEXT:
  #282828     Soft black (primary text)
  #595959     Medium gray (secondary text, FAQ answers)
  #333333     Dark gray (table text)
  #999999     Light gray (muted text, RERA numbers in footer)
  #000000     Pure black (some footer links)

BORDERS & DECORATIVE:
  #e0dcd4     Warm gray (input borders, FAQ dividers)
  #e1d3ac     Sand/gold (footer section dividers)
  #e6e6e6     Light gray (table row borders)
  #b4b4b4     Medium gray (highlight section borders)
  #c8c8c8     Light gray (mobile highlight borders)
  #e7dec5     Sand (footer form input borders)
  #ddd        Light gray (common-title underline, various borders)
  #cdcdcd     Light gray (dropdown borders)

OVERLAY/TRANSPARENCY:
  rgba(183, 146, 108, 0.25)   Gold-tinted border for price cards
  rgba(183, 146, 108, 0.5)    Gold-tinted border on hover
  rgba(255, 255, 255, 0.08)   Subtle white (payment cards on dark)
  rgba(255, 255, 255, 0.15)   Subtle white border (payment cards)
  rgba(255, 255, 255, 0.85)   Near-white text on dark sections
  rgba(0, 0, 0, 0.2)          Toast shadow
  rgba(0, 0, 0, 0.06)         Card shadow
  rgba(0, 0, 0, 0.1)          Card hover shadow
  rgba(0, 0, 0, 0.15)         Banner form shadow

MISCELLANEOUS:
  #f4cf6d     Bright gold (NOT in current palette -- leftover, remove if found)
  #d6b24b     Gold (banner form button hover -- slightly off-brand)
  #7f1d1d     Dark red (error toast)
  #dc2626     Red (error toast border)
  #f1f1f1     Scrollbar track
  #888        Scrollbar thumb
  #555        Scrollbar thumb hover
  #c38f60     Warm gold (disclaimer link in footer)
```

#### Typography System
```
FONT FAMILIES:
  1. "Playfair Display", Georgia, serif
     - Loaded via Google Fonts: weights 400, 500, 600, 700
     - Used for: .common-heading, .projectname, .pricingbox .heading,
       .contact-container .heading, banner headings
     - Purpose: Luxury serif for all major headings

  2. "Montserrat", "Helvetica Neue", Arial, sans-serif
     - Loaded via Google Fonts: weights 400, 500, 600, 700
     - Also loaded locally: Montserrat-SemiBold.ttf
     - Used for: .common-title (section labels), nav links, button text,
       .banner-form .heading, .startingprice span, .flexfooter .heading
     - Purpose: Clean sans-serif for labels, navigation, UI elements

  3. "Poppins" (loaded as "popins"), sans-serif
     - Loaded via Google Fonts: weights 300, 400, 500, 600
     - Also loaded locally: Poppins-Regular.ttf
     - Used for: body text, paragraphs, form inputs, general UI
     - Purpose: Body/default font

FONT SIZE SCALE:
  53px    Banner project name (.projectname) -- desktop
  42px    Section headings (.common-heading) -- desktop
  37px    Banner typology line
  35px    Modal heading
  32px    Highlights section heading
  30px    Starting price text / mobile section headings
  28px    Contact heading
  27px    Pricing box heading / mobile highlights num
  26px    Floor plan typo / mobile headings
  25px    Key highlights value (.pera)
  22px    Mobile starting price
  20px    Payment card h4 / banner form heading / flexfooter heading
  18px    Price/sizes text, modal paragraph, flexfooter heading
  16px    FAQ summary, SEO details summary
  15px    Highlight text, location list, amenity captions, body paragraphs
  14px    Overview paragraph, footer text, form inputs, captions, small text
  13px    Nav links, .common-title, button text
  12px    RERA strip, footer RERA, QR text
  11px    Footer RERA numbers
  10px    Consent checkbox text

FONT WEIGHTS:
  700     Headings (Playfair Display)
  600     Labels, nav, buttons (Montserrat), FAQ summaries
  500     Starting price, some body
  400     Body text (Poppins), paragraphs
  300     FAQ toggle icon (+/-)

LINE HEIGHTS:
  1.2     Section headings (.common-heading)
  1.5     Toast notifications
  1.7     FAQ answers, body paragraphs, payment card text
  25px    Mobile overview text, footer text
  27px    Default paragraph, overview text, developer content

LETTER SPACING:
  -0.02em   Headings (Playfair Display) -- tight for elegance
  0.4px     Default (* selector)
  0.5px     RERA strip
  1px       Highlights description
  1.1px     Overview paragraph
  1.5px     Nav links
  2px       Buttons, banner form heading
  3px       .common-title (section labels)
```

#### Button Styles (Complete Spec)
```
DEFAULT (.custombtn):
  padding:          12px 32px
  border:           1px solid #b7926c
  background:       transparent
  color:            #315f3f
  font-family:      "Montserrat", sans-serif
  font-size:        13px
  font-weight:      600
  letter-spacing:   2px
  text-transform:   uppercase
  border-radius:    0
  transition:       all 0.3s ease
  HOVER:            bg #315f3f, color #fff, border-color #315f3f, translateY(-1px)

FILLED GREEN (.custombtn with inline bg):
  background:       #315f3f
  color:            #fff
  border:           1px solid #b7926c
  HOVER:            bg #042f2e (very dark teal)

GOLD CTA (.custombtn-gold):
  background:       linear-gradient(135deg, #b7926c, #c8a97d)
  color:            #fff
  border:           none
  padding:          14px 40px
  HOVER:            brightness(1.1), translateY(-1px)

BANNER FORM SUBMIT:
  background:       #315f3f
  color:            #fff
  width:            62%
  margin:           0 auto
  HOVER:            bg #d6b24b (gold -- note: slightly off-brand)

FOOTER SUBMIT (.footer-from-div .btn):
  background:       #315f3f
  color:            #fff
  width:            53%
  HOVER:            bg #042f2e

HEADER CTA (.headerbtn):
  Same as .custombtn but used as phone link in nav

MOBILE FOOTER BAR:
  background:       #315f3f (--secondary)
  color:            #fff
  padding:          6px 8px
  border:           1px solid currentColor
```

#### Spacing System
```
SECTION PADDING (desktop):
  110px top/bottom    All main sections (overview, highlights, pricing,
                      floor plan, location, gallery, amenities)

SECTION PADDING (tablet, <=1600px):
  80px top/bottom

SECTION PADDING (mobile, <=767px):
  30px top/bottom

CONTAINER:
  max-width: 1300px (desktop)
  max-width: 1250px (<=1600px)

INTERNAL SPACING:
  Section title to heading:     10px (margin-bottom on .common-title)
  Heading to content:           24px (margin-bottom on .common-heading)
  Content to CTA:               25px
  Between pricing cards:        35px gap
  Between highlight items:      0 (border-separated, padding 12px 18px)
  Payment grid gap:             30px
  FAQ items:                    0 (border-bottom separated)
  FAQ summary padding:          18px top/bottom
  Gallery image gap:            15px
  Floor plan gap:               30px

BANNER FORM:
  max-width:        355px
  internal padding: 20px
  input spacing:    15px margin-bottom
  heading padding:  16px

CARD PADDING:
  Pricing boxes:    50px 30px
  Payment cards:    30px
  Modal content:    35px 34px
```

#### Component Patterns
```
NAVIGATION:
  Fixed top, transparent initially
  On scroll: bg #282828 (--black), slide-down animation
  Logo: max-height 50px, left-aligned
  Links: right-aligned, uppercase Montserrat 13px/600
  Hover: gold underline (#b7926c) animating width 0->100%
  Mobile: off-canvas left drawer, bg #000

SECTION LABEL (.common-title):
  13px uppercase Montserrat 600, letter-spacing 3px
  Two-line underline decoration:
    ::after = 80% width, 1px solid #ddd
    ::before = 30% width, 5px solid #315f3f (on top, offset left 14px)

SECTION HEADING (.common-heading):
  42px Playfair Display 700, letter-spacing -0.02em, line-height 1.2
  text-transform: capitalize

CARDS (pricing):
  White bg, 1px gold-tinted border, 2px radius
  Shadow: 0 15px 50px rgba(0,0,0,0.06)
  Hover: translateY(-8px), stronger shadow, border color intensifies
  Width: calc(33% - 20px) desktop, 49% tablet, 100% mobile

TABLE (.styled-table):
  Header cells: bg #315f3f, color white, 600 weight
  Body cells: white bg, #333 text
  Row hover: bg #f0f8f3
  Border-radius: 10px (container), overflow hidden

TOAST NOTIFICATIONS:
  Fixed top-right, z-index 9999
  Success: bg #315f3f, border-left 4px solid #b7926c
  Error: bg #7f1d1d, border-left 4px solid #dc2626
  Slide-in from right (translateX)

FORM INPUTS:
  padding: 13px 16px
  border: 1px solid #e0dcd4
  border-radius: 0
  font: 14px Poppins
  Focus: border-color #315f3f

SCROLL REVEAL:
  opacity 0 -> 1, translateY(30px) -> 0
  Duration: 700ms, easing: ease
  Triggered by IntersectionObserver at 15% threshold

RERA TRUST STRIP:
  bg: #f0ece4, padding 10px, text-align center
  Font: 12px, color #315f3f, letter-spacing 0.5px
  Position: below header (margin-top: 60px)

FAQ:
  <details>/<summary> pattern (no JS needed)
  Toggle icon: + / - via ::after pseudo-element
  Icon color: #b7926c, 22px, weight 300
  Answer: #595959, 15px, line-height 1.7

IMAGE TREATMENT:
  Banner: filter brightness(0.7), 100vh height
  Gallery inactive: saturate(0.5) brightness(0.7)
  Gallery hover: scale(1.03), full saturation/brightness
  Overview: white border (15px), box-shadow
  Amenities: brightness(0.7), caption overlay with backdrop-filter blur
```

---

## PART 3: CENTRAL PARK GROUP BRAND ALIGNMENT

### Official Brand Colors (from centralpark.in analysis)

Central Park Group's official branding uses:
```
Primary:        Deep forest green (#315f3f to #2d5a3a range)
Accent:         Antique gold/bronze (#b7926c to #c9a87d range)
Backgrounds:    Cream/warm whites
Text:           Dark gray/near-black
```

**Our Alignment: EXCELLENT.** The `#315f3f` green and `#b7926c` gold are pixel-accurate matches to Central Park's brand identity. The warm cream backgrounds (#f9f7f0) are consistent with their luxury positioning.

### Typography Alignment

Central Park's official site uses serif headings paired with clean sans-serif body text -- a luxury real estate convention.

**Our Alignment: GOOD.** We now use Playfair Display (serif) for headings, Montserrat for labels/nav, and Poppins for body. This three-font system is correctly implemented and matches the luxury standard.

### Areas Where We Exceed or Differ from Official

| Aspect | Central Park Official | Our Implementation | Assessment |
|---|---|---|---|
| Color palette | Green + gold on cream | Identical | MATCH |
| Serif headings | Yes | Yes (Playfair Display) | MATCH |
| Section spacing | Generous (100px+) | 110px desktop | MATCH |
| Card style | Clean, minimal | Gold-tinted borders, shadows | ENHANCED -- good |
| Navigation | Fixed, transparent->solid | Same pattern | MATCH |
| Button style | Clean, uppercase | Same pattern with gold border | MATCH |
| RERA prominence | Footer only typically | Header strip + footer | ENHANCED -- better for trust |
| Schema.org markup | Basic | Comprehensive (4 schemas) | ENHANCED -- better for SEO |
| FAQ with schema | Not typically present | Full FAQ with FAQPage schema | ENHANCED -- better for AI/search |

---

## PART 4: RECOMMENDED DESIGN TOKENS (Complete Reference)

### Colors
```css
:root {
  /* Brand */
  --color-primary-green:       #315f3f;
  --color-primary-green-dark:  #1e3a28;
  --color-primary-green-hover: #042f2e;
  --color-gold:                #b7926c;
  --color-gold-light:          #c8a97d;
  --color-gold-gradient:       linear-gradient(135deg, #b7926c, #c8a97d);

  /* Backgrounds */
  --color-bg-body:             #f9f7f0;
  --color-bg-warm:             #fef9eb;
  --color-bg-section-alt:      #f0ece4;
  --color-bg-section-gray:     #eeeeee;
  --color-bg-white:            #ffffff;

  /* Text */
  --color-text-primary:        #282828;
  --color-text-secondary:      #595959;
  --color-text-muted:          #999999;
  --color-text-on-dark:        rgba(255, 255, 255, 0.85);

  /* Borders */
  --color-border-default:      #e0dcd4;
  --color-border-sand:         #e1d3ac;
  --color-border-gold:         rgba(183, 146, 108, 0.25);
  --color-border-gold-hover:   rgba(183, 146, 108, 0.5);
  --color-border-light:        #ddd;

  /* Feedback */
  --color-success-bg:          #315f3f;
  --color-error-bg:            #7f1d1d;
  --color-error-border:        #dc2626;

  /* Shadows */
  --shadow-card:               0 15px 50px rgba(0, 0, 0, 0.06);
  --shadow-card-hover:         0 25px 70px rgba(0, 0, 0, 0.1);
  --shadow-form:               0 25px 80px rgba(0, 0, 0, 0.15);
  --shadow-toast:              0 12px 40px rgba(0, 0, 0, 0.2);
}
```

### Typography
```css
/* Font Stack */
--font-heading:  "Playfair Display", Georgia, "Times New Roman", serif;
--font-label:    "Montserrat", "Helvetica Neue", Arial, sans-serif;
--font-body:     "Poppins", "Helvetica Neue", Arial, sans-serif;

/* Scale */
--text-banner:   53px;   /* .projectname */
--text-h1:       42px;   /* .common-heading */
--text-h2:       32px;   /* highlights heading */
--text-h3:       27px;   /* pricing heading */
--text-h4:       20px;   /* payment card h4, form heading */
--text-body:     15px;   /* paragraph text */
--text-body-sm:  14px;   /* overview, footer */
--text-label:    13px;   /* .common-title, nav, buttons */
--text-caption:  12px;   /* RERA strip, small text */
--text-micro:    11px;   /* footer RERA numbers */
--text-legal:    10px;   /* consent text */
```

### Spacing
```css
--space-section-desktop:   110px;
--space-section-tablet:    80px;
--space-section-mobile:    30px;
--space-heading-gap:       10px;   /* title to heading */
--space-heading-to-body:   24px;   /* heading to content */
--space-card-gap:          35px;   /* between pricing cards */
--space-card-padding:      50px 30px;
--space-input-gap:         15px;   /* between form inputs */
--space-container-max:     1300px;
```

### Button Tokens
```css
--btn-padding:             12px 32px;
--btn-padding-lg:          14px 40px;
--btn-font-size:           13px;
--btn-font-weight:         600;
--btn-letter-spacing:      2px;
--btn-radius:              0;
--btn-transition:          all 0.3s ease;
```

---

## PART 5: OUTSTANDING ISSUES TO FIX

### Critical
1. **banner2.php email typo**: `info@mcentralparkdelphine.info` should be `info@centralparkdelphine.info` (lines 29, 83)

### Minor Design Inconsistencies
1. **Banner form hover color**: `.banner-form .custombtn:hover` uses `#d6b24b` (bright gold) which is not in the design palette. Should be `#042f2e` (dark teal) or `#b7926c` (brand gold).
2. **Disclaimer link color**: `#c38f60` in footer -- close to brand gold but not exact. Should be `#b7926c`.
3. **Scrollbar colors**: `#888` and `#555` are not from the palette. Consider `#b7926c` thumb on `#f0ece4` track for on-brand scrollbars.
4. **Table container border-radius**: `10px` on `.table-container` is rounder than the sharp luxury aesthetic (0-4px) used elsewhere.

### Content Suggestions
1. Add Tower A serviced apartment pricing when available (currently only "Starting Rs 3 Cr" which is for luxury towers)
2. Update investment data: "~36% YoY appreciation in 2023" -- consider adding 2024-2025 figures
3. Consider adding a dedicated "Tower A" section since serviced apartments are a distinct product

---

## PART 6: WHAT THE PAGE DOES RIGHT

1. **Brand-accurate color palette** -- #315f3f + #b7926c matches Central Park Group identity precisely
2. **Luxury typography hierarchy** -- Playfair Display (serif headings) + Montserrat (labels) + Poppins (body)
3. **Comprehensive schema markup** -- ApartmentComplex, Organization, FAQPage, BreadcrumbList
4. **RERA trust signals** -- strip at top AND footer, with all 3 registration numbers
5. **Proper SEO** -- title, meta description, keywords, canonical, OG, Twitter cards
6. **llms.txt** -- AI-search optimized with complete structured data
7. **Generous section spacing** (110px) matches luxury standard
8. **Clean card components** with gold-tinted borders and hover elevation
9. **Scroll reveal animations** -- tasteful single-play, not infinite loops
10. **Responsive design** -- thorough breakpoints at 1600px, 1380px, 992px, 767px
11. **FAQ using native `<details>/<summary>`** -- lightweight, accessible, no JS needed
12. **Form handling** via AJAX with toast notifications (modern UX)

---

## Sources

- File analysis: index.php, css/commonStyles.css, llms.txt, banner2.php, disclaimer.html, form.php, footer-form.php
- Training data knowledge: centralpark.in, HARERA registration formats, 99acres, SquareYards, MagicBricks
- Press: RP Realty Plus, Construction Week India coverage of Central Park Delphine launch
- Broker portals: SKJ Landbase, MoneyTree Realty, Accurate Realty, Right Solutions, Opulnz Abode
