# Elan The Statement -- Complete Audit & Design Guide
## Generated: 2026-04-06

> **NOTE:** All internet access tools (WebSearch, WebFetch, curl, Playwright, Chrome DevTools) were denied during this session. Official source verification against elangroup.co.in and HARERA portal could not be performed live. The "Official / Likely Correct" column below is based on (a) cross-referencing internal claims across the site's own pages, (b) the author's knowledge of publicly available Elan Group project information, and (c) logical analysis of which claims are more specific/credible. **You MUST verify these against the official Elan Group website and HARERA portal before making changes.**

---

## PART 1: FACTUAL DISCREPANCY TABLE

### A. The 5 Originally Identified Internal Inconsistencies

| # | Claim | Location on Site | What It Says | Conflicting Location | What It Says There | Assessment / Likely Correct Value |
|---|-------|-----------------|-------------|---------------------|-------------------|----------------------------------|
| 1 | **Tower Count** | Banner (index.html line 467) | "Five towers rising up to 39 floors" | FAQ (index.html line 2331) + JSON-LD Schema (line 151) | "5 towers with G+42 floors and one tower with G+43 floors" (= 6 towers total) | **Likely 6 towers total** (5 + 1). The FAQ answer is more detailed and specific. The banner should say "Six towers" or clarify the structure. Verify with official brochure. |
| 2 | **Floor Count** | Banner (index.html line 467) | "up to 39 floors" | FAQ (index.html line 2331) | "G+42 / G+43" (i.e., 43-44 floors total) | **Likely G+42/G+43 is correct.** The 4-BHK subpage (line 445) says "G+39" which adds a third conflicting value. The FAQ's G+42/G+43 is the most specific claim. Highlights section (line 1173) says "36-39 floors" -- yet another variant. Verify with official source. |
| 3 | **BHK Configurations** | Meta description (index.html line 8) | "luxury 4 & 5 BHK apartments" | FAQ (index.html line 143, line 2291) | "3 & 4 BHK residences" | **See extended analysis below -- at least 4 different claims exist.** |
| 4 | **Lobby Height** | Banner (index.html line 463) | "Grand triple height entrance lobby" | Highlights section (index.html line 1169) | "Grand double-height entrance lobbies" | **Unknown without official source.** Both "double-height" and "triple-height" appear. The JSON-LD FAQ schema (line 215) also says "double-height lobbies." Two locations say "double" vs one says "triple." Likely "double-height" is correct. |
| 5 | **Land Area** | Banner + Highlights (lines 466, 1172) | "6 acre land parcel" / "6-acre project with 80% open space" | FAQ (index.html line 2445) + JSON-LD (line 199) | "75-acre integrated luxury development" | **Both may be correct in different contexts.** 6 acres = the specific Elan The Statement plot. 75 acres = the larger integrated township/development it sits within. However, these need clarification on the page to avoid confusion. |

### B. BHK Configuration -- Extended Analysis (4 Conflicting Claims)

| Location | Claim |
|----------|-------|
| Meta description (index.html line 8) | "4 & 5 BHK" |
| FAQ answer (index.html line 143 + line 2291) | "3 & 4 BHK" |
| Price section (index.html lines 969-1005) | "4 BHK + Penthouse" (no 3 BHK or 5 BHK listed) |
| Review section (index.html line 1681) | "I booked a 3.5 BHK" |
| Specs bar (index.html line 613) | "4 BHK" only |
| Overview text (index.html line 738) | "ultra-luxurious 4 BHK apartments" |
| H1 heading (index.html line 459) | "Luxury 4 BHK Apartments" |
| Penthouse page meta (penthouse line 8) | "4 & 5 BHK sky homes" |
| Penthouse page price cards (penthouse line 797, 816) | "4 BHK Penthouse" + "5 BHK Penthouse" |
| 4-BHK page schema (4-bhk line 156) | "4 BHK luxury residences" only |

**Assessment:** The main product is 4 BHK apartments. Penthouses come in 4 BHK and 5 BHK variants. There is NO evidence of a 3 BHK or 3.5 BHK anywhere in floor plans or pricing. The FAQ claim of "3 & 4 BHK" and the review mentioning "3.5 BHK" are likely incorrect. The correct offering is probably **4 BHK apartments + 4/5 BHK penthouses**.

### C. Additional Inconsistencies Found During Audit

| # | Issue | Details |
|---|-------|---------|
| 6 | **Possession Date** | index.html says **"October 2029"** (FAQ line 2377, Quick Details table line 928, JSON-LD schema line 167). BUT both 4-bhk-49-gurgaon.html AND penthouse-in-sector-49-gurgaon.html say **"March 2030"** in their tables AND JSON-LD schemas (dateAvailable: "2030-03-31"). These cannot both be correct. |
| 7 | **RERA Status** | index.html says **"Under Process"** in the Quick Details table (line 932) and FAQ (line 2256). BUT 4-bhk-49-gurgaon.html FAQ (line 180) says **"Yes, Elan The Statement is fully compliant and RERA registered"** -- directly contradicting the main page. This is a serious compliance issue. |
| 8 | **Apartment Size (minimum)** | index.html FAQ (line 191 and 2428) says sizes "begin from **2407 sq. ft.**" BUT the price section on index.html (line 633, 975) says **4300 Sq.Ft.** for 4 BHK. The 4-BHK page lists sizes of 4150, 4252, and 4500 sq ft. Where does 2407 sq ft come from? No unit on the site matches this size. |
| 9 | **Starting Price** | index.html consistently says **Rs 9 Cr onwards**. The 4-BHK page schema says **"On Request"** (line 115). Minor inconsistency but should be aligned. |
| 10 | **Apartment Size in Schema** | index.html JSON-LD schema (line 67) says floor size is **4300 sq ft**. The 4-BHK page schema (lines 100-101) says range is **4150-4500 sq ft**. These should be consistent. |
| 11 | **"3 side open"** | Banner (line 462) claims "3 side open luxury residences." This is a specific architectural claim that should be verified -- it implies corner plots or specific tower positioning. |
| 12 | **Clubhouse size** | 4-BHK page (line 721) and penthouse page (line 1174) both reference a **"70,000 sq.ft."** clubhouse. This is not mentioned on the main index.html page -- should be added as a selling point. |
| 13 | **Nav link colors** | Multiple nav links (lines 265-334) have `color:white` which would be invisible against the white navbar background. Only the first link ("Overview") has `color:#00324e`. This appears to be a bug. |

### D. Priority Fix List

| Priority | Issue | Risk Level |
|----------|-------|-----------|
| CRITICAL | RERA status contradiction (Under Process vs "fully registered") | Legal/compliance risk |
| CRITICAL | BHK configs inconsistency (removes buyer trust) | Conversion risk |
| HIGH | Possession date mismatch (Oct 2029 vs Mar 2030) | Legal/trust risk |
| HIGH | Tower count (5 vs 6) and floor count (39 vs 42/43) | Factual credibility |
| MEDIUM | Apartment min size 2407 sq ft claim (no matching unit) | SEO/trust issue |
| MEDIUM | Lobby height (triple vs double) | Minor factual error |
| LOW | Land area needs clarification (6 acres vs 75 acres) | Context needed |
| LOW | Nav link color bug (white on white) | UX bug |

---

## PART 2: COMPREHENSIVE DESIGN GUIDE

### Current Site Design System (Extracted from CSS)

#### Color Palette -- Currently Used

| Token / Usage | Hex Value | RGB | Usage |
|--------------|-----------|-----|-------|
| **Primary Blue (Brand)** | `#005581` | 0, 85, 129 | Buttons, headings, form backgrounds, CTA gradients, banner overlay |
| **Primary Blue Dark** | `#002f47` | 0, 47, 71 | Gradient endpoints, premium glass form bg |
| **Primary Blue Hover** | `#003f5c` | 0, 63, 92 | Disclaimer link hover |
| **Primary Blue Alt** | `#00374a` | 0, 55, 74 | Overview title, price title |
| **Primary Blue Nav** | `#00324e` | 0, 50, 78 | Footer bg, nav text, section headings |
| **Primary Blue Light** | `#007aa1` | 0, 122, 161 | Gradient secondary, footer borders |
| **Primary Blue Lighter** | `#0073a8` | 0, 115, 168 | Button gradient secondary |
| **Gold Accent** | `#C5A45A` | 197, 164, 90 | Underline accents, input focus borders, FAQ active state |
| **Gold Accent Dark** | `#b08a47` / `#b08a48` | 176, 138, 71/72 | Gold gradient endpoints |
| **Gold Accent (Suncity)** | `#caa94e` | 202, 169, 78 | Hamburger icon, nav hover |
| **Card Border Left Hover** | `#b1914d` | 177, 145, 77 | Luxury card hover border |
| **Teal Accent** | `#005079` | 0, 80, 121 | Card icons, card borders |
| **Banner Blue** | `#005a86` | 0, 90, 134 | Banner left content box bg |
| **Banner Blue Alt** | `#015381` | 1, 83, 129 | Banner h1, form heading |
| **Section BG Light** | `#f8f9fa` | 248, 249, 250 | Amenities, location section bg |
| **Section BG Gradient Start** | `#f7f9fc` / `#f6f8fb` | varies | Overview, price section backgrounds |
| **Section BG Gradient End** | `#eef1f6` / `#eef2f6` | varies | Gradient endpoints |
| **Body Text Dark** | `#212529` | 33, 37, 41 | Body text (Bootstrap default) |
| **Body Text Medium** | `#333` | 51, 51, 51 | Paragraph text, disclaimer |
| **Body Text Light** | `#444` / `#555` | varies | Secondary text, subtitles |
| **Body Text Lighter** | `#666` | 102, 102, 102 | Card descriptions |
| **Footer Dark** | `#00324e` | 0, 50, 78 | Footer section bg |
| **Footer Black** | `#000` | 0, 0, 0 | Footer bottom |
| **Footer Link** | `#cccccc` | 204, 204, 204 | Footer text/links |
| **Footer Accent** | `#00bcd4` | 0, 188, 212 | Footer bottom links |
| **White** | `#ffffff` | 255, 255, 255 | Card bg, form bg, text on dark |

**ISSUE:** The site uses approximately 8-10 different shades of blue that are almost but not exactly the same. This should be consolidated.

#### Typography

| Element | Font Family | Weight | Size (Desktop) | Size (Mobile) | Line Height |
|---------|-------------|--------|----------------|---------------|-------------|
| **Body** | Poppins | 400 | 1rem (16px) | 1rem | 1.5 |
| **H1** | Cormorant | 900 | calc(1.375rem + 1.5vw) => ~2.5rem (40px) | 29px (banner) | 1.2-1.3 |
| **H2 (Section Title)** | Cormorant | 700-900 | 32-38px | 26-35px | 1.2 |
| **H3** | Cormorant | 900 | calc(1.3rem + 0.6vw) => ~1.75rem | -- | 1.2 |
| **H4** | Cormorant | 900 | calc(1.275rem + 0.3vw) | -- | 1.2 |
| **Nav Links** | Poppins (implied) | 500 | 13px | 16px | -- |
| **Banner H1** | Inline override | 700 | 30px (inline) / 40px (class) | 29px | 1.3 |
| **Price Card Title** | Cormorant (implied) | 700 | 26px | -- | -- |
| **Card Body Text** | Poppins | 500 | 15-17px | -- | 1.6 |
| **Button Text** | Poppins | 600 | 15-17px | -- | -- |
| **Disclaimer** | Poppins | 400 | 14px | 13px | 1.8 |
| **FAQ Question** | Poppins | 700 | 17px | -- | -- |
| **FAQ Answer** | Poppins | 400 | 15px | -- | 1.7 |
| **Form Heading** | Cormorant | 900 | 26px | -- | -- |

#### Spacing & Layout

| Element | Padding / Margin |
|---------|-----------------|
| **Sections** | padding: 60-80px top/bottom, 0-20px left/right |
| **Container** | Bootstrap container-xl (max-width: 1320px) |
| **Cards** | padding: 25-30px, border-radius: 14-18px |
| **Buttons** | padding: 14-18px vertical, 25-35px horizontal |
| **Form Inputs** | padding: 12-20px, margin-bottom: 12-17px |
| **Card Gap** | 20-25px (via Bootstrap row g-4 = 1.5rem) |
| **Section Title Bottom Margin** | 15-40px |
| **Gold Underline Accent** | width: 80-90px, height: 3px, margin: 12px auto |

#### Button Styles

| Button Type | Background | Color | Border-Radius | Padding | Shadow |
|-------------|-----------|-------|---------------|---------|--------|
| **Primary CTA** | linear-gradient(135deg, #005581, #0073a8) | #fff | 10-14px | 14px 25px | 0 8px 22px rgba(0,0,0,0.2) |
| **Dark CTA** | linear-gradient(135deg, #000, #333) | #fff | 14px | 14px 28px | 0 8px 18px rgba(0,0,0,0.35) |
| **Premium Submit** | linear-gradient(135deg, #005581, #003d58) | #fff | 14px | 15px | box-shadow with gold glow |
| **Nav Phone** | linear-gradient(135deg, #005581, #007aa1) | #fff | 40px (pill) | 8px 12px | 0 4px 15px rgba(0,85,129,0.4) |
| **Tag Chip** | #005581 solid | #fff | 20px (pill) | 6px 14px | none |

#### Card Styles

| Card Type | Background | Border | Border-Radius | Shadow | Hover Effect |
|-----------|-----------|--------|---------------|--------|-------------|
| **Glass Card (Spec)** | rgba(255,255,255,0.25) + blur(10px) | 1px solid rgba(255,255,255,0.45) | 18px | 0 8px 25px rgba(0,0,0,0.1) | translateY(-8px) scale(1.03) |
| **Price Card** | rgba(255,255,255,0.18) + blur(12px) | 1px solid rgba(255,255,255,0.5) | 18px | 0 12px 30px rgba(0,0,0,0.12) | translateY(-10px) scale(1.03) |
| **Feature Card** | #ffffff | 1px solid rgba(0,0,0,0.06) | 14px | 0 4px 20px rgba(0,0,0,0.07) | translateY(-10px) |
| **Luxury Card** | rgba(255,255,255,0.8) + blur(10px) | border-left: 5px solid #005079 | 14px | 0 4px 20px rgba(0,0,0,0.07) | translateY(-6px), border goes gold |
| **Review Card** | (inherits from review-content) | -- | -- | -- | -- |
| **FAQ Accordion** | #fff | 1px solid rgba(0,0,0,0.07) | 14px | 0 4px 14px rgba(0,0,0,0.06) | translateY(-4px) |

#### Animation Patterns

| Animation | CSS | Usage |
|-----------|-----|-------|
| **Fade In** | from { opacity:0; translateY(20px) } to { opacity:1; translateY(0) } | Sections, cards |
| **Slide In Left** | from { translateX(-50px); opacity:0 } | Banner left |
| **Slide In Right** | from { translateX(50px); opacity:0 } | Banner form |
| **Float Up** | from { translateY(30px); opacity:0 } | Contact form |
| **Hover Lift** | translateY(-4px to -10px) | All cards, buttons |
| **Hover Scale** | scale(1.02-1.05) | Logo, cards |

---

### Elan Group Official Branding (Based on Known Brand Identity)

> **CAVEAT:** The following is based on the author's knowledge of Elan Group's public-facing brand identity. Live verification from elangroup.co.in was not possible due to tool access restrictions. These values should be confirmed before implementation.

#### Known Elan Group Brand Colors

| Color | Hex (Estimated) | Usage |
|-------|-----------------|-------|
| **Elan Navy / Deep Blue** | `#003049` to `#00324e` | Primary brand color, headers |
| **Elan Gold** | `#C5A45A` to `#D4AF37` | Accent, luxury signifiers |
| **Elan White** | `#FFFFFF` | Clean backgrounds |
| **Elan Off-White** | `#F5F5F5` to `#F8F9FA` | Section backgrounds |
| **Elan Black** | `#1A1A1A` to `#222222` | Text, footer |

#### Elan Group Typography Approach

Elan Group's official website and marketing materials typically use:
- **Serif headings** for luxury feel (the site's use of Cormorant is aligned with this)
- **Clean sans-serif body text** (Poppins is a reasonable choice)
- **Restrained, minimal typography** -- not too many sizes

#### Recommended Design Consolidation

**Consolidate Blues to 4 tokens:**
```
--elan-navy:       #00324e;  /* Primary: headers, footer, nav text */
--elan-blue:       #005581;  /* Secondary: buttons, CTAs, links */
--elan-blue-light: #0073a8;  /* Tertiary: gradient endpoints, accents */
--elan-blue-pale:  #e8f4f8;  /* Background tints */
```

**Consolidate Golds to 2 tokens:**
```
--elan-gold:       #C5A45A;  /* Primary gold accent */
--elan-gold-dark:  #b08a47;  /* Hover/gradient gold */
```

**Consolidate Backgrounds to 3 tokens:**
```
--elan-bg-white:   #ffffff;
--elan-bg-light:   #f8f9fa;
--elan-bg-section: #f5f7fa;
```

**Consolidate Text to 4 tokens:**
```
--elan-text-dark:    #1b1b1b;  /* Headings */
--elan-text-body:    #333333;  /* Body text */
--elan-text-muted:   #555555;  /* Subtitles */
--elan-text-light:   #666666;  /* Card descriptions */
```

---

### Luxury Design Principles for Elan Branding

1. **White space is premium.** Increase section padding from 60-70px to 80-100px.
2. **Fewer gradients.** Current site overuses linear-gradient. Luxury = solid colors with subtle depth.
3. **Gold as accent only.** Gold should appear in small touches (underlines, borders, hover states) -- never as primary button color.
4. **Consistent shadows.** Standardize to 2-3 shadow levels instead of the current 10+ variants.
5. **Glass morphism sparingly.** The site uses backdrop-filter blur on nearly everything. Reserve it for 1-2 hero elements only.
6. **Typography hierarchy.** Cormorant for H1-H3 only. Everything else in Poppins. Current site occasionally breaks this.
7. **Hover animations.** Standardize to translateY(-6px) for cards and translateY(-3px) for buttons. Remove scale transforms on cards.

---

## PART 3: IMMEDIATE ACTION ITEMS

### Before Making Any Changes:
1. Visit https://www.elangroup.co.in/the-statement and verify: tower count, floor count, BHK types, lobby height, land area, RERA number, possession date
2. Check https://haryanarera.gov.in/ for the actual RERA registration status
3. Download the official Elan The Statement brochure and cross-reference all claims

### Critical Fixes (Do Immediately):
1. **Resolve RERA contradiction:** Either it is "Under Process" or "Registered" -- cannot be both. The 4-BHK page claim of "fully compliant and RERA registered" could be a legal liability if untrue.
2. **Standardize possession date:** Pick one (October 2029 OR March 2030) based on official RERA filing.
3. **Standardize BHK offerings:** Remove "3 & 4 BHK" from FAQs, remove "3.5 BHK" from review. Align with actual offering: 4 BHK apartments + 4/5 BHK penthouses.
4. **Fix nav link colors:** Change `color:white` to `color:#00324e` for all nav links (lines 265-334).

### Medium Priority:
5. Standardize tower/floor counts across all pages.
6. Clarify land area (6 acres project + part of 75-acre township).
7. Resolve lobby height (double vs triple).
8. Remove the "2407 sq ft" minimum size claim if no unit exists at that size.
9. Align starting price across all pages and schemas.
