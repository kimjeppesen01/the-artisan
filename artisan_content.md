# The Artisan — Content Template Instructions

> **Purpose**: This document is the single source of truth for an AI agent creating webpage content for The Artisan (theartisan.dk). Follow every rule exactly. Output valid HTML ready to paste into an Elementor HTML widget.

---

## 1. Brand & Voice

| Property | Value |
|----------|-------|
| Brand | The Artisan |
| Domain | theartisan.dk |
| Primary language | Danish (da-DK) |
| Tone | Knowledgeable, approachable, craft-focused. Never salesy. |
| Author attribution | "The Artisan" (never a person's name unless quoting) |
| Currency | Danish kroner — format: `155,00 kr.` |
| Date format | `Februar 2026` (month + year, Danish month names) |

### Writing rules
- Write all user-facing content in **Danish** unless the article is explicitly English.
- Use **æ ø å** — never substitutes like ae, oe, aa.
- Keep paragraphs short (2-4 sentences).
- Use `<strong>` for emphasis, never `<b>` or `<em>` for product names.
- Reading time formula: count words, divide by 200, round to nearest integer, append `min. læsning`.

---

## 2. Technical Context

### Platform stack
WordPress + WooCommerce + Elementor + Saren theme (PeThemes) + ACF

### Where to put content
All HTML goes into **Elementor HTML widgets** on the relevant page. CSS is in `saren-child/style.css`. Shortcodes are in `saren-child/functions.php`.

### CSS class prefix
All custom classes use `sa-` prefix. Never invent classes outside this namespace.

### CSS variables (available globally)
```
--mainColor          (text / foreground)
--mainBackground     (page background)
--secondaryColor     (muted text)
--secondaryBackground (card/surface backgrounds)
--linesColor         (borders, dividers)
--radius             (border-radius, default 7.5px)
```

---

## 3. Button System

The site uses Saren's native `pe--button` component. **Never use `<button>` or `<a class="sa-btn">` for action buttons.** Always use this exact structure:

```html
<div class="pe--button {{VARIANT}} {{SIZE}}">
  <div class="pe--button--wrapper">
    <a href="{{URL}}">
      <span class="pb__main">{{LABEL}}<span class="pb__hover">{{LABEL}}</span></span>
    </a>
  </div>
</div>
```

> The `pb__hover` span must contain the **same text** as `pb__main`.

### Variants
| Class | Use for |
|-------|---------|
| `pb--background` | Primary CTA (filled background) |
| `pb--bordered` | Secondary action (outline) |
| `pb--underlined` | Inline text links |

### Sizes
| Class | Use for |
|-------|---------|
| `pb--small` | Sidebar, inline, compact contexts |
| `pb--normal` | Default — body-level CTAs |
| `pb--medium` | Hero banners, emphasized CTAs |

### Non-link buttons
For non-navigation actions (feedback votes, timer controls), add `onclick="return false;"` to the `<a>` tag.

### Visibility fix for `pb--bordered`
The `pb--bordered` variant can appear invisible when placed inside containers with matching backgrounds (e.g. `.sa-product-widget`, `.sa-product-page`). CSS fix is applied globally via `style.css` — it adds an explicit `border: 1px solid var(--mainColor)` to the anchor element. No action needed in HTML; just be aware that `pb--bordered` now always shows a visible border.

---

## 4. Available Shortcodes

Use these instead of hardcoded HTML when the data is dynamic.

| Shortcode | Output | When to use |
|-----------|--------|-------------|
| `[sa_featured_image]` | `<figure>` with WP featured image | Article hero — always use this, never hardcode `<img>` |
| `[sa_article_header]` | Breadcrumbs + category + h1 + meta | Article header — replaces manual breadcrumb/title HTML |
| `[sa_product_schema id=""]` | JSON-LD Product markup | Every product page — invisible, SEO only |
| `[sa_faq_schema]` + `[sa_faq_item question=""]...[/sa_faq_item]` | FAQ accordion + FAQPage JSON-LD | FAQ sections — replaces `<details>` + manual schema |
| `[sa_freshness id=""]` | Pulsing freshness badge | Product pages — reads ACF `roast_date` |
| `[sa_coffee_table]` | Searchable product list | Product category pages |
| `[sa_category_hero]` | Full-width hero with auto-featured product | Category page headers — replaces manual hero HTML |
| `[sa_product_showcase]` | Immersive product card grid | Mid-page product features — auto-pulls from WooCommerce |
| `[breadcrumb]` | Schema.org BreadcrumbList | Non-article pages needing breadcrumbs |

### Shortcode attributes
```
[sa_featured_image caption="{{CAPTION}}" max="500px"]
[sa_product_schema id="{{PRODUCT_ID}}"]
[sa_freshness id="{{PRODUCT_ID}}"]
[sa_coffee_table category="{{SLUG}}" limit="10" orderby="title" order="ASC"]
[sa_faq_item question="{{QUESTION}}"]{{ANSWER}}[/sa_faq_item]
[sa_category_hero category="{{SLUG}}" heading="{{H1}}" subtitle="{{SUBTITLE}}" cta_text="{{LABEL}}" cta_url="{{URL}}"]
[sa_product_showcase category="{{SLUG}}" count="3" heading="{{HEADING}}" exclude="{{IDS}}" orderby="total_sales"]
```

### Automation notes

**`[sa_category_hero]`** and **`[sa_product_showcase]`** are fully automated:
- **Product selection:** Auto-selects products by featured status → best-selling → newest. Use `product_id` to force a specific product in the hero.
- **Images:** Auto-fetched from WooCommerce product thumbnails. No hardcoded image URLs needed.
- **Specs/meta:** Auto-pulled from ACF fields (`origin_country`) and WooCommerce product attributes (`pa_origin`, `pa_process`, `pa_roast`).
- **Tasting notes / highlights:** Auto-pulled from ACF fields (`highlight_1`, `highlight_2`, `highlight_3`).
- Never hardcode product data — always use these shortcodes so content stays in sync with the product catalog.

---

## 5. Page Type: Article (Guide / Blog Post)

### Page structure

```
.sa-progress                     ← reading progress bar (fixed top)
.saren-article                   ← outer wrapper
  header.sa-header               ← breadcrumbs, category, h1, subtitle, meta
  [sa_featured_image]            ← hero image via shortcode
  .sa-box.sa-box--takeaways      ← key takeaways (full-width, above columns)
  .sa-layout                     ← 2-column grid
    main.sa-main                 ← content column
      nav.sa-toc-inline          ← mobile-only table of contents
      section#{{ID}} (repeated)  ← article sections with components
      .sa-disclosure             ← affiliate/transparency notice
      .sa-feedback               ← helpful? yes/no
      .sa-author                 ← author box
      .sa-sources                ← numbered source list
      .sa-related                ← related article cards
    aside.sa-sidebar             ← sidebar column
      nav.sa-toc                 ← desktop table of contents
      .sa-sidebar-widget         ← featured product card
      .sa-newsletter             ← newsletter signup
      .sa-share-links            ← social share
.sa-back-to-top                  ← back to top button
<script>                         ← progress bar + back-to-top JS
```

### Layout behavior
- **Desktop**: 2-column (content + sticky sidebar)
- **Tablet**: Sidebar becomes 2-column grid below content
- **Phone**: Single column, sidebar stacks below content

### Required elements (every article)
1. Reading progress bar
2. Header (breadcrumbs, category, title, subtitle, meta)
3. Hero image via `[sa_featured_image]`
4. Key takeaways box
5. At least 3 content sections
6. Feedback component
7. Author box
8. Back-to-top button + script

### Optional elements (use as appropriate)
All components listed in the Component Catalog below.

---

## 6. Page Type: Product Category Page

### Purpose
Category landing pages (e.g. `/da/butik/kaffebonner/hele-bonner/`, `/da/butik/kaffebonner/espresso/`). Combines product browsing with educational SEO content.

### Setup
Wrap everything in `<div class="sa-product-page">`.

### Page structure
```
.sa-product-page                 ← outer wrapper
  [breadcrumb]                   ← breadcrumb schema
  [sa_category_hero]             ← hero with auto-featured product (has sticky-header padding)
  .sa-box.sa-box--takeaways      ← key takeaways
  .sa-trust-bar                  ← trust signals (static content)
  [sa_coffee_table]              ← searchable product list (primary conversion)
  section#{{ID}} (repeated)      ← educational content sections
  [sa_product_showcase]          ← mid-page immersive product cards (automated)
  section#{{ID}} (continued)     ← more content sections
  .sa-cta-banner                 ← call to action
  [sa_faq_schema]                ← FAQ with JSON-LD
  .sa-author                     ← author box
  .sa-related                    ← related guide cards
```

### Required elements (every category page)
1. Breadcrumbs via `[breadcrumb]`
2. Hero via `[sa_category_hero]` — auto-fetches product, accounts for sticky header
3. Key takeaways box
4. Trust signals bar (static copy, never change)
5. Product table via `[sa_coffee_table]`
6. At least 3 content sections
7. Product showcase via `[sa_product_showcase]` mid-page
8. FAQ section with schema
9. Author box

### Key automation rules
- **Never hardcode product images or data** — use `[sa_category_hero]` and `[sa_product_showcase]`
- Products are auto-selected based on: featured status → sales count → newest
- Images, prices, specs are pulled live from WooCommerce + ACF
- Content stays in sync when products change — no manual updates needed

---

## 7. Page Type: Product Page (Single)

### Setup
Add class `sa-product-page` to the outermost Elementor container.

### Available components
Product page components can be mixed and matched. The order below is recommended but not required.

---

## 8. Page Type: Recipe Page (QR Brew Guide)

### Purpose
Single-page interactive brew guide accessed by scanning QR codes on coffee bags. Mobile-first, app-like experience.

### Setup
Wrap everything in a single `<div class="sa-recipe">`.

### Supported brew methods
Espresso, Pour Over, Aeropress, French Press. Each method needs its own: parameters, steps, grind position, timer duration, and pro tip.

### Structure
```
.sa-recipe
  .sa-recipe__hero               ← coffee identity (roast badge, title, origin)
  .sa-recipe__methods             ← tab selector (4 brew methods)
  .sa-recipe__card                ← switches content per method
    .sa-recipe__params-wrap       ← recipe parameter grids (one per method)
    .sa-recipe__grind             ← grind size visualizer
    .sa-recipe__steps-wrap        ← step checklists (one per method)
    .sa-recipe__timer             ← SVG ring countdown timer
    .sa-recipe__tip (x4)          ← pro tips (one per method)
  .sa-recipe__profile             ← coffee origin/process/variety/tasting notes
  .sa-recipe__guides              ← read more guide cards
  .sa-recipe__footer              ← CTA to shop
<script>                          ← tab switching, timer, step tracking JS
```

### Recipe data model
When creating a recipe page, fill in these values per brew method:

| Field | Espresso | Pour Over | Aeropress | French Press |
|-------|----------|-----------|-----------|--------------|
| Dose | `{{DOSE}}` | `{{DOSE}}` | `{{DOSE}}` | `{{DOSE}}` |
| Grind | `{{GRIND}}` | `{{GRIND}}` | `{{GRIND}}` | `{{GRIND}}` |
| Ratio | `{{RATIO}}` | `{{RATIO}}` | `{{RATIO}}` | `{{RATIO}}` |
| Temp | `{{TEMP}}` | `{{TEMP}}` | `{{TEMP}}` | `{{TEMP}}` |
| Time | `{{TIME}}` | `{{TIME}}` | `{{TIME}}` | `{{TIME}}` |
| Grind position (%) | 12 | 45 | 50 | 85 |
| Timer default (sec) | 30 | 180 | 120 | 240 |
| Steps | 5 steps | 5 steps | 5 steps | 5 steps |
| Pro tip | 1 paragraph | 1 paragraph | 1 paragraph | 1 paragraph |

### Coffee identity block
Replace with the specific coffee's data:
```html
<div class="sa-recipe__hero">
  <div class="sa-recipe__hero-inner">
    <span class="sa-recipe__roast-badge">{{ROAST_LEVEL}}</span>
    <h1 class="sa-recipe__title">Din brygguide</h1>
    <p class="sa-recipe__origin">Single-origin &middot; {{COUNTRY}} &middot; {{PROCESS}}</p>
  </div>
</div>
```

---

## 9. Component Catalog

Every component below can be used inside an article's `<main>` column. Components marked **Product** can also be used on product pages. Components marked **Category** can be used on category pages. Components marked **Recipe** are recipe-page only.

### 9A-0. Category Hero (Shortcode) | **Category**

Full-width hero with auto-featured product card. Accounts for sticky header padding. All product data (image, name, price, specs) is auto-fetched from WooCommerce.

```
[sa_category_hero category="hele-bonner" heading="Hele Kaffebønner" subtitle="Friskristede kaffebønner til enhver smag og bryggemetode" cta_text="Se alle produkter" cta_url="#sa-coffee-table"]
```

| Attribute | Default | Description |
|-----------|---------|-------------|
| `category` | `''` | Product category slug — used to auto-select featured product |
| `heading` | Category name | h1 text override |
| `subtitle` | `''` | Subtitle paragraph text |
| `cta_text` | `Se alle produkter` | CTA button label |
| `cta_url` | `#sa-coffee-table` | CTA link target |
| `product_id` | auto | Force a specific product ID instead of auto-selection |

**Auto-selection logic:** Featured product → Best-selling → Newest in category.

### 9A-1. Product Showcase (Shortcode) | **Category**

Mid-page immersive product cards with hover effects and tasting note tags. All data auto-fetched from WooCommerce + ACF.

```
[sa_product_showcase category="hele-bonner" count="3" heading="Udvalgte kaffer" orderby="total_sales"]
```

| Attribute | Default | Description |
|-----------|---------|-------------|
| `category` | `''` | Product category slug(s), comma-separated |
| `count` | `3` | Number of products to show |
| `heading` | `Udvalgte kaffer` | Section heading |
| `exclude` | `''` | Comma-separated product IDs to skip |
| `orderby` | `total_sales` | Sort: `total_sales`, `date`, `rand`, `menu_order` |

**Features:**
- Product images with aspect-ratio crop and hover zoom
- Roast level badge overlay
- Origin + process meta
- Tasting note tags from ACF `highlight_1/2/3` fields
- Price + CTA button per card
- Responsive: 3-col → 2-col → 1-col

### 9A. Content Boxes

Four variants, all sharing the same structure. Use the one that matches intent.

```html
<div class="sa-box sa-box--{{VARIANT}}">
  <h3>{{HEADING}}</h3>
  <p>{{BODY}}</p>
</div>
```

| Variant | `{{HEADING}}` | When to use |
|---------|---------------|-------------|
| `takeaways` | `Vigtigste pointer` | Top of article — 3-5 bullet key findings. Use `<ul>` instead of `<p>`. |
| `tip` | `Tip` | Helpful advice, best practice |
| `warning` | `Advarsel` | Something to avoid, common mistake |
| `info` | `Godt at vide` | Background information, context |

### 8B. Stat Highlights

Row of 2-4 data points. Use when you have compelling numbers.

```html
<div class="sa-stat-row">
  <div class="sa-stat">
    <span class="sa-stat__number">{{VALUE}}</span>
    <span class="sa-stat__label">{{LABEL}}</span>
  </div>
  <!-- repeat 2-4 times -->
</div>
```

### 8C. Inline Product Widget

Contextual product recommendation within an article. Links to a product page.

```html
<div class="sa-product-widget">
  <div class="sa-product-widget__image">
    <img src="{{IMAGE_URL}}" alt="{{PRODUCT_NAME}}">
  </div>
  <div class="sa-product-widget__content">
    <span class="sa-product-widget__badge">{{BADGE_TEXT}}</span>
    <h4>{{PRODUCT_NAME}}</h4>
    <p class="sa-product-widget__desc">{{DESCRIPTION}}</p>
    <ul class="sa-product-widget__specs">
      <li><strong>Oprindelse:</strong> {{ORIGIN}}</li>
      <li><strong>Proces:</strong> {{PROCESS}}</li>
      <li><strong>Ristning:</strong> {{ROAST}}</li>
      <li><strong>Pris:</strong> {{PRICE}}</li>
    </ul>
    <!-- pe--button here with pb--bordered pb--normal -->
  </div>
</div>
```

- `{{BADGE_TEXT}}` examples: "Vores anbefaling", "Bestseller", "Ny"
- Always include a pe--button linking to the product page.

### 8D. Blockquote

Standard quote with attribution.

```html
<blockquote>
  <p>"{{QUOTE_TEXT}}"</p>
  <cite>— {{AUTHOR_NAME}}, {{AUTHOR_TITLE}}</cite>
</blockquote>
```

### 8E. Pull Quote

Larger, visually distinct quote. Use for key insight or memorable statement.

```html
<blockquote class="sa-pullquote">
  <p>"{{QUOTE_TEXT}}"</p>
  <cite>{{AUTHOR_NAME}}, {{AUTHOR_TITLE}}</cite>
</blockquote>
```

### 8F. Expert Opinion

Quote with avatar. Use for The Artisan team or industry experts.

```html
<div class="sa-expert">
  <div class="sa-expert__avatar">
    <img src="{{AVATAR_URL}}" alt="{{NAME}}">
  </div>
  <div class="sa-expert__content">
    <div class="sa-expert__name">{{NAME}}</div>
    <div class="sa-expert__title">{{TITLE}}</div>
    <p>"{{QUOTE_TEXT}}"</p>
  </div>
</div>
```

For customer reviews without an image, use an initial circle instead of `<img>`:
```html
<div class="sa-expert__avatar">
  <div style="width:48px;height:48px;border-radius:50%;background:var(--mainColor);color:var(--mainBackground);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:1.1rem;">{{INITIAL}}</div>
</div>
```

### 8G. Image with Caption

```html
<figure class="sa-image">
  <img src="{{IMAGE_URL}}" alt="{{ALT_TEXT}}">
  <figcaption>{{CAPTION}}</figcaption>
</figure>
```

### 8H. Video Embed

```html
<div class="sa-video">
  <iframe src="{{YOUTUBE_EMBED_URL}}" title="{{VIDEO_TITLE}}" allowfullscreen></iframe>
</div>
```

### 8I. Rating / Score Box

Use for product reviews or recommendations.

```html
<div class="sa-rating">
  <div class="sa-rating__score">
    <span class="sa-rating__number">{{SCORE}}</span>
    <span class="sa-rating__of">af 10</span>
  </div>
  <div class="sa-rating__details">
    <h4>{{PRODUCT_NAME}}</h4>
    <p>{{SHORT_DESCRIPTION}}</p>
    <ul class="sa-rating__bars">
      <li>
        <span>{{CRITERION}}</span>
        <span class="sa-rating__bar-track"><span class="sa-rating__bar-fill" style="width: {{PERCENT}}%"></span></span>
      </li>
      <!-- repeat for each criterion (3-5 bars) -->
    </ul>
  </div>
</div>
```

### 8J. Pros / Cons

Always pair with a Rating box.

```html
<div class="sa-proscons">
  <div class="sa-proscons__col sa-proscons__col--pro">
    <h4>Fordele</h4>
    <ul>
      <li>{{PRO_1}}</li>
      <li>{{PRO_2}}</li>
      <!-- 3-5 items -->
    </ul>
  </div>
  <div class="sa-proscons__col sa-proscons__col--con">
    <h4>Ulemper</h4>
    <ul>
      <li>{{CON_1}}</li>
      <li>{{CON_2}}</li>
      <!-- 2-4 items -->
    </ul>
  </div>
</div>
```

### 8K. Comparison Table

Responsive table for product or feature comparisons.

```html
<div class="sa-table-wrap">
  <table>
    <thead>
      <tr>
        <th>{{COL_1}}</th>
        <th>{{COL_2}}</th>
        <!-- 3-5 columns -->
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><strong>{{ROW_LABEL}}</strong></td>
        <td>{{VALUE}}</td>
        <!-- match column count -->
      </tr>
      <!-- repeat rows -->
    </tbody>
  </table>
</div>
```

### 8L. CTA Banner

Full-width call to action. Use 1-2 per article max.

```html
<div class="sa-cta-banner">
  <h3>{{HEADING}}</h3>
  <p>{{BODY}}</p>
  <!-- pe--button with pb--background pb--normal -->
</div>
```

### 8M. Numbered Steps (How-to)

Ordered instructional steps. Typically 3-7 steps.

```html
<ol class="sa-steps">
  <li>
    <strong>{{STEP_TITLE}}</strong>
    <p>{{STEP_DESCRIPTION}}</p>
  </li>
  <!-- repeat -->
</ol>
```

### 8N. FAQ Accordion (with Schema)

Use the shortcode version for automatic FAQPage JSON-LD:

```
[sa_faq_schema]
[sa_faq_item question="{{QUESTION_1}}"]{{ANSWER_1}}[/sa_faq_item]
[sa_faq_item question="{{QUESTION_2}}"]{{ANSWER_2}}[/sa_faq_item]
[/sa_faq_schema]
```

For a plain accordion without schema (rare), use:
```html
<div class="sa-faq">
  <details class="sa-faq__item">
    <summary>{{QUESTION}}</summary>
    <p>{{ANSWER}}</p>
  </details>
</div>
```

### 8O. Disclosure / Transparency Notice

Required at the end of any article with affiliate links or product mentions.

```html
<div class="sa-disclosure">
  <strong>Affiliate-oplysning:</strong> {{DISCLOSURE_TEXT}}
</div>
```

Standard text: `Nogle links i denne artikel er affiliate-links. Det betyder, at vi kan modtage en lille kommission, hvis du køber via linket — uden ekstra omkostninger for dig. Vi anbefaler kun produkter, vi selv har testet og stoler på.`

### 8P. Feedback

```html
<div class="sa-feedback">
  <p>Var denne guide nyttig?</p>
  <div class="sa-feedback-btns">
    <!-- pe--button pb--bordered pb--small, label: "Ja, tak!" -->
    <!-- pe--button pb--bordered pb--small, label: "Kunne være bedre" -->
  </div>
</div>
```

Both buttons use `onclick="return false;"`.

### 8Q. Author Box

```html
<div class="sa-author">
  <img src="/wp-content/uploads/author-avatar.jpg" alt="The Artisan team" class="sa-author__avatar">
  <div class="sa-author__info">
    <strong>The Artisan</strong>
    <p>{{AUTHOR_BIO}}</p>
  </div>
</div>
```

Standard bio: `Vi er specialister i kvalitetskaffe og -udstyr. Vores redaktion tester og anmelder kaffeprodukter med fokus på håndværk, kvalitet og bæredygtighed.`

### 8R. Sources

Numbered list of references. Include for any article making factual claims.

```html
<div class="sa-sources">
  <h3>Kilder</h3>
  <ol>
    <li>{{SOURCE_1}}</li>
    <li>{{SOURCE_2}}</li>
  </ol>
</div>
```

### 8S. Related Articles

Grid of 3 related article cards.

```html
<div class="sa-related">
  <h3>Relaterede guides</h3>
  <div class="sa-related-grid">
    <a href="{{URL}}" class="sa-related-card">
      <img src="{{IMAGE_URL}}" alt="{{TITLE}}">
      <div class="sa-related-card__title">{{TITLE}}</div>
      <div class="sa-related-card__meta">{{READING_TIME}} min. læsning</div>
    </a>
    <!-- repeat 3 times -->
  </div>
</div>
```

---

## 10. Product Page Components

These are used on product pages (inside `.sa-product-page`) and can also be embedded in articles.

### 9A. Coffee Info Card | **Product**

Structured product card with Schema.org microdata. One per product page.

```html
<div class="sa-coffee-card" itemscope itemtype="https://schema.org/Product">
  <div class="sa-coffee-card__header">
    <img class="sa-coffee-card__image" src="{{IMAGE_URL}}" alt="{{NAME}}" itemprop="image">
    <div>
      <h3 class="sa-coffee-card__title" itemprop="name">{{NAME}}</h3>
      <p class="sa-coffee-card__subtitle" itemprop="description">{{DESCRIPTION}}</p>
    </div>
  </div>
  <div class="sa-coffee-card__specs">
    <div class="sa-coffee-card__spec">
      <span class="sa-coffee-card__spec-label">Oprindelse</span>
      <span class="sa-coffee-card__spec-value">{{ORIGIN}}</span>
    </div>
    <div class="sa-coffee-card__spec">
      <span class="sa-coffee-card__spec-label">Proces</span>
      <span class="sa-coffee-card__spec-value">{{PROCESS}}</span>
    </div>
    <div class="sa-coffee-card__spec">
      <span class="sa-coffee-card__spec-label">Højde</span>
      <span class="sa-coffee-card__spec-value">{{ALTITUDE}}</span>
    </div>
    <div class="sa-coffee-card__spec">
      <span class="sa-coffee-card__spec-label">Varietet</span>
      <span class="sa-coffee-card__spec-value">{{VARIETY}}</span>
    </div>
  </div>
  <div class="sa-coffee-card__notes">
    <div class="sa-coffee-card__notes-label">Smagsnoter</div>
    <div class="sa-coffee-card__tags">
      <span class="sa-coffee-card__tag">{{NOTE_1}}</span>
      <span class="sa-coffee-card__tag">{{NOTE_2}}</span>
      <span class="sa-coffee-card__tag">{{NOTE_3}}</span>
    </div>
  </div>
  <div class="sa-coffee-card__action">
    <div class="sa-coffee-card__price">{{PRICE}}<small>inkl. moms</small></div>
    <!-- pe--button with pb--background pb--normal linking to product -->
  </div>
</div>
```

### 9B. Process Comparison | **Product**

Side-by-side washed vs natural coffee explainer. Educational + SEO targeting "vasket vs natural kaffe".

```html
<div class="sa-process-compare">
  <div class="sa-process-col">
    <div class="sa-process-col__title">
      <span class="sa-process-col__icon">W</span>
      Vasket (Washed)
    </div>
    <p class="sa-process-col__desc">{{WASHED_DESCRIPTION}}</p>
    <ol class="sa-process-steps">
      <li>{{STEP_1}}</li>
      <li>{{STEP_2}}</li>
      <li>{{STEP_3}}</li>
      <li>{{STEP_4}}</li>
    </ol>
    <div class="sa-process-col__flavor"><strong>Smag:</strong> {{WASHED_FLAVOR}}</div>
  </div>
  <div class="sa-process-col">
    <div class="sa-process-col__title">
      <span class="sa-process-col__icon">N</span>
      Natural (Tør)
    </div>
    <p class="sa-process-col__desc">{{NATURAL_DESCRIPTION}}</p>
    <ol class="sa-process-steps">
      <li>{{STEP_1}}</li>
      <li>{{STEP_2}}</li>
      <li>{{STEP_3}}</li>
      <li>{{STEP_4}}</li>
    </ol>
    <div class="sa-process-col__flavor"><strong>Smag:</strong> {{NATURAL_FLAVOR}}</div>
  </div>
</div>
```

### 9C. Brewing Recommendation | **Product**

Quick-reference brew parameters.

```html
<div class="sa-brew-rec">
  <div class="sa-brew-rec__label">Anbefalet bryggemetode</div>
  <div class="sa-brew-rec__method">{{METHOD_NAME}}</div>
  <div class="sa-brew-rec__params">
    <div class="sa-brew-rec__param">
      <span class="sa-brew-rec__param-value">{{GRIND}}</span>
      <span class="sa-brew-rec__param-label">Kværning</span>
    </div>
    <div class="sa-brew-rec__param">
      <span class="sa-brew-rec__param-value">{{RATIO}}</span>
      <span class="sa-brew-rec__param-label">Ratio</span>
    </div>
    <div class="sa-brew-rec__param">
      <span class="sa-brew-rec__param-value">{{TEMP}}</span>
      <span class="sa-brew-rec__param-label">Temperatur</span>
    </div>
    <div class="sa-brew-rec__param">
      <span class="sa-brew-rec__param-value">{{TIME}}</span>
      <span class="sa-brew-rec__param-label">Tid</span>
    </div>
  </div>
</div>
```

### 9D. Trust Signals Bar | **Product**

Horizontal strip of brand trust signals. Use once per product page.

```html
<div class="sa-trust-bar">
  <div class="sa-trust-item">
    <span class="sa-trust-item__icon">&#9749;</span>
    <div><strong>Ristet til ordre</strong>Altid frisk kaffe</div>
  </div>
  <div class="sa-trust-item">
    <span class="sa-trust-item__icon">&#9203;</span>
    <div><strong>Sendes inden 48 timer</strong>Hurtig levering</div>
  </div>
  <div class="sa-trust-item">
    <span class="sa-trust-item__icon">&#128666;</span>
    <div><strong>Gratis fragt over 320 kr.</strong>GLS til døren</div>
  </div>
  <div class="sa-trust-item">
    <span class="sa-trust-item__icon">&#127465;&#127466;</span>
    <div><strong>Ristet i København</strong>Lokalt håndværk</div>
  </div>
</div>
```

> This component's content is **static** — do not change the trust signal copy.

### 9E. Taste Profile | **Product**

Visual bar chart for flavor dimensions. Each value is 1-5, percentage = value * 20.

```html
<div class="sa-taste-profile">
  <div class="sa-taste-profile__title">Smagsprofil</div>
  <div class="sa-taste-row">
    <span class="sa-taste-row__label">Syre</span>
    <div class="sa-taste-row__track"><div class="sa-taste-row__fill" style="width: {{ACIDITY_PCT}}%"></div></div>
    <span class="sa-taste-row__value">{{ACIDITY}}/5</span>
  </div>
  <div class="sa-taste-row">
    <span class="sa-taste-row__label">Krop</span>
    <div class="sa-taste-row__track"><div class="sa-taste-row__fill" style="width: {{BODY_PCT}}%"></div></div>
    <span class="sa-taste-row__value">{{BODY}}/5</span>
  </div>
  <div class="sa-taste-row">
    <span class="sa-taste-row__label">Sødme</span>
    <div class="sa-taste-row__track"><div class="sa-taste-row__fill" style="width: {{SWEETNESS_PCT}}%"></div></div>
    <span class="sa-taste-row__value">{{SWEETNESS}}/5</span>
  </div>
  <div class="sa-taste-row">
    <span class="sa-taste-row__label">Bitterhed</span>
    <div class="sa-taste-row__track"><div class="sa-taste-row__fill" style="width: {{BITTERNESS_PCT}}%"></div></div>
    <span class="sa-taste-row__value">{{BITTERNESS}}/5</span>
  </div>
</div>
```

### 9F. Freshness Badge | **Product**

Static version (for when no product ID is available):
```html
<span class="sa-freshness">
  <span class="sa-freshness__dot"></span>
  <span class="sa-freshness__text">Ristet <strong>{{DATE}}</strong> &mdash; sendes inden 48 timer</span>
</span>
```

Dynamic version (preferred — reads ACF field):
```
[sa_freshness id="{{PRODUCT_ID}}"]
```

### 9G. Pairs Well With | **Product**

Horizontal scrollable row of 2-4 related products.

```html
<h3 style="font-size:0.85rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin:2rem 0 0.75rem;">Passer godt til</h3>
<div class="sa-pairs">
  <a href="{{PRODUCT_URL}}" class="sa-pairs__item">
    <img src="{{IMAGE_URL}}" alt="{{PRODUCT_NAME}}">
    <div class="sa-pairs__name">{{PRODUCT_NAME}}</div>
    <div class="sa-pairs__why">{{PAIRING_REASON}}</div>
  </a>
  <!-- repeat 2-4 times -->
</div>
```

`{{PAIRING_REASON}}` should be 2-3 words explaining the contrast or complement (e.g., "Frugtagtig kontrast", "Klassisk balance", "Aften-alternativ").

### 9H. Expandable Brew Guide | **Product**

Collapsible brewing instructions using existing FAQ + steps pattern.

```html
<details class="sa-faq__item">
  <summary>Sådan brygger du denne kaffe</summary>
  <div style="padding: 0 0 1rem;">
    <ol class="sa-steps">
      <li><strong>{{STEP_TITLE}}</strong><p>{{STEP_BODY}}</p></li>
      <!-- 3-5 steps -->
    </ol>
  </div>
</details>
```

### 9I. Searchable Coffee Table | **Product**

Dynamic shortcode — queries WooCommerce products automatically.

```
[sa_coffee_table]
[sa_coffee_table category="kaffebønner" limit="10"]
[sa_coffee_table category="kaffebønner,koffeinfri" orderby="title" order="ASC"]
```

| Attribute | Default | Description |
|-----------|---------|-------------|
| `category` | `''` (all) | Product category slug(s), comma-separated |
| `limit` | `-1` (all) | Max products to show |
| `orderby` | `menu_order` | WP_Query orderby field |
| `order` | `ASC` | Sort direction |

Features: real-time search, expandable rows with 3 bullet highlights, quick add-to-cart popup, SEO-crawlable descriptions.

Data per product is pulled automatically from WooCommerce + ACF fields (`origin_country`, `highlight_1`, `highlight_2`, `highlight_3`).

---

## 11. Sidebar Components

Used inside `<aside class="sa-sidebar">`. Each widget wraps in `.sa-sidebar-widget`.

### 10A. Table of Contents (Desktop)

```html
<nav class="sa-sidebar-widget sa-toc">
  <h3>Indhold</h3>
  <ol>
    <li><a href="#{{SECTION_ID}}">{{SHORT_TITLE}}</a></li>
    <!-- match article sections -->
  </ol>
</nav>
```

Short titles: max 3 words per entry. Must match `id` attributes on `<section>` elements.

### 10B. Featured Product Card

Uses Saren's native product card markup.

```html
<div class="sa-sidebar-widget">
  <h3>Anbefalet produkt</h3>
  <div class="saren--product--wrap">
    <div class="saren--product--image--wrap">
      <div class="saren--product--image">
        <a href="{{PRODUCT_URL}}">
          <img loading="lazy" class="product-image-front" width="640" height="853" src="{{IMAGE_URL}}" alt="{{PRODUCT_NAME}}" sizes="(max-width: 640px) 100vw, 640px">
        </a>
      </div>
    </div>
    <div class="saren--product--meta">
      <div class="saren--product--main">
        <div class="product-name woocommerce-loop-product__title">{{PRODUCT_NAME}}</div>
        <div class="product-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">kr.</span>&nbsp;{{PRICE}}</bdi></span></div>
      </div>
      <!-- pe--button pb--bordered pb--small linking to product -->
    </div>
  </div>
</div>
```

### 10C. Newsletter Signup

```html
<div class="sa-sidebar-widget sa-newsletter">
  <h3>Nyhedsbrev</h3>
  <p>Få kaffetrends, nye produkter og eksklusive tilbud direkte i din indbakke.</p>
  <input type="email" placeholder="Din e-mail">
  <!-- pe--button pb--background pb--small sa-btn--full, label: "Tilmeld" -->
</div>
```

### 10D. Share Links

```html
<div class="sa-sidebar-widget">
  <h3>Del artiklen</h3>
  <div class="sa-share-links">
    <a href="#" title="Facebook">f</a>
    <a href="#" title="X / Twitter">𝕏</a>
    <a href="#" title="LinkedIn">in</a>
    <a href="#" title="Email">@</a>
    <a href="#" title="Kopiér link">&#128279;</a>
  </div>
</div>
```

---

## 12. Scripts

### Reading Progress + Back-to-Top (Article pages)

Include at the bottom of every article template:

```html
<button class="sa-back-to-top" id="sa-back-to-top" title="Tilbage til toppen">&uarr;</button>

<script>
(function() {
  var progress = document.getElementById('sa-progress');
  if (progress) {
    window.addEventListener('scroll', function() {
      var scrollTop = window.pageYOffset;
      var docHeight = document.documentElement.scrollHeight - window.innerHeight;
      var pct = (scrollTop / docHeight) * 100;
      progress.style.width = pct + '%';
    });
  }
  var btn = document.getElementById('sa-back-to-top');
  if (btn) {
    window.addEventListener('scroll', function() {
      btn.classList.toggle('visible', window.pageYOffset > 600);
    });
    btn.addEventListener('click', function() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }
})();
</script>
```

### Recipe Page Script (Recipe pages only)

The recipe page requires a script block that handles:
1. **Method switching** — toggling `active` class on params, steps, tips by `data-method`
2. **Grind visualizer** — moving marker position and resizing particle dots
3. **Step completion** — toggling `completed` class, updating progress counter
4. **Brew timer** — SVG ring countdown with start/pause/reset

Configuration object to customize per coffee:
```javascript
var grindPositions = { espresso: 12, pourover: 45, aeropress: 50, frenchpress: 85 };
var grindSizes = {
  espresso:    [2,3,2,3,2,2,3,2],
  pourover:    [3,5,4,5,3,4,5,3],
  aeropress:   [4,5,4,6,5,4,5,4],
  frenchpress: [6,8,7,9,6,8,7,8]
};
var timerDefaults = { espresso: 30, pourover: 180, aeropress: 120, frenchpress: 240 };
```

The full script is included in the recipe page template in `functions.php`. When creating new recipe pages, only the configuration values and content placeholders need to change — the JS logic is reusable as-is.

---

## 13. Content Assembly Checklist

When creating a new page, follow this checklist:

### Article
- [ ] Choose topic, keyword target, and 5-7 sections
- [ ] Write header: breadcrumbs path, category label, h1, subtitle, author, date, reading time
- [ ] Write key takeaways (3-5 bullets)
- [ ] For each section: h2 with number prefix, 2-4 paragraphs, at least 1 component
- [ ] Add 1-2 product widgets linking to The Artisan products
- [ ] Add 1 CTA banner mid-article or at end
- [ ] Write 3-5 FAQ items using `[sa_faq_schema]`
- [ ] Add disclosure if any affiliate/product links
- [ ] Add feedback component
- [ ] Add author box (use standard bio)
- [ ] Add sources
- [ ] Add 3 related articles
- [ ] Build sidebar: TOC, featured product, newsletter, share
- [ ] Include progress bar + back-to-top script

### Category Page
- [ ] Wrap in `.sa-product-page`
- [ ] Add `[breadcrumb]` shortcode
- [ ] Add `[sa_category_hero]` with category slug, heading, subtitle (hero is fully automated)
- [ ] Add key takeaways box
- [ ] Add trust signals bar (static — never change copy)
- [ ] Add `[sa_coffee_table]` with correct category slug
- [ ] Write 3-5 educational content sections with components
- [ ] Add `[sa_product_showcase]` mid-page (automated product cards)
- [ ] Add CTA banner
- [ ] Write 4-6 FAQ items using `[sa_faq_schema]`
- [ ] Add author box
- [ ] Add 3 related guide cards
- [ ] **Do NOT hardcode product images** — shortcodes handle it

### Product Page
- [ ] Add `.sa-product-page` class to outermost container
- [ ] Coffee info card with all specs and Schema.org microdata
- [ ] Taste profile bar chart
- [ ] Brewing recommendation
- [ ] Trust signals bar
- [ ] Freshness badge via `[sa_freshness]`
- [ ] Process comparison (if relevant to this coffee)
- [ ] Pairs well with (2-4 related products)
- [ ] Expandable brew guide
- [ ] Customer review highlight
- [ ] CTA banner (subscription)
- [ ] FAQ with schema
- [ ] Product schema via `[sa_product_schema]`

### Recipe Page
- [ ] Coffee identity hero (roast level, origin, process)
- [ ] All 4 brew method tabs with params
- [ ] 5 steps per method with descriptive titles and instructions
- [ ] Pro tip per method
- [ ] Timer with correct defaults per method
- [ ] Grind visualizer with positions
- [ ] Coffee profile (origin, process, altitude, variety, tasting notes)
- [ ] 6 guide cards with links
- [ ] Footer CTA
- [ ] Script block with correct configuration

---

## 14. URL Conventions

| Page type | URL pattern | Example |
|-----------|-------------|---------|
| Article (DA) | `/da/guide/{{SLUG}}/` | `/da/guide/komplet-guide-til-kaffekværning-2026/` |
| Article (EN) | `/en/guide/{{SLUG}}/` | `/en/guide/complete-coffee-grinding-guide-2026/` |
| Product | `/butik/{{PRODUCT_SLUG}}/` | `/butik/da-koffeinfri-kaffe-chevere/` |
| Category | `/da/{{CATEGORY}}/` | `/da/kaffeboenner-fra-koebenhavn/` |
| Subscription | `/da/abonnement/` | — |
| Shop | `/butik/` | — |
| About | `/da/om-os/` | — |

### Internal linking rules
- Always use relative URLs for internal links (e.g., `/butik/` not `https://theartisan.dk/butik/`).
- Exception: `[sa_featured_image]` and product images use full URLs because they reference uploaded media.
- Guide cross-links should use descriptive anchor text, never "klik her".
