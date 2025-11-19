Delcam Capital – WordPress Custom Theme

Custom Theme for delcamcapital.com
Developed by Black Lab Development

Overview

Delcam Capital’s WordPress custom theme is a lightweight,
performance‑optimized theme built for speed, clarity, and conversion. It
leverages modern WordPress best practices, custom blocks, dynamic
templates, and modular SCSS architecture.

This theme is fully bespoke and does not rely on heavy page builders. It
is built to integrate seamlessly with Delcam Capital’s brand identity,
focusing on clean UI, accessibility, and fast load times.

------------------------------------------------------------------------

Key Features

🔧 Custom Theme Architecture

-   Clean, modular file structure
-   Custom template parts for hero areas, content blocks, and CTA
    sections
-   SCSS compiled to minified production CSS
-   Custom JavaScript bundled and optimized

📦 Custom Gutenberg Blocks

-   Reusable content sections
-   Styled typography and layout controls
-   Theme‑specific options for consistent presentation

🎨 Brand‑Forward Design

-   Typography and colors aligned to Delcam Capital brand
-   Flexible hero components
-   Conversion‑optimized layout patterns

🧩 Custom Post Types (if applicable)

-   Services
-   Team Members
-   Portfolio / Case Studies
-   Locations or Offices

📈 Performance & SEO

-   Lean markup
-   No unused CSS bloat
-   Server‑side rendered templates
-   Schema markup where relevant
-   SEO‑friendly semantic structure

------------------------------------------------------------------------

File Structure

    theme/
    │
    ├── assets/
    │   ├── css/
    │   ├── js/
    │   └── images/
    │
    ├── inc/
    │   ├── setup.php        # Theme setup functions
    │   ├── enqueue.php      # Scripts & styles
    │   ├── custom-post-types.php
    │   ├── acf-fields.php   # ACF JSON definitions (if used)
    │   └── helpers.php
    │
    ├── template-parts/
    │   ├── hero/
    │   ├── sections/
    │   └── components/
    │
    ├── page-templates/
    │
    ├── functions.php
    ├── style.css
    └── index.php

------------------------------------------------------------------------

Installation

1.  Upload the theme directory to:
    wp-content/themes/delcam-theme/

2.  Activate the theme in WordPress Admin → Appearance → Themes.

3.  Ensure required plugins are installed (if used):

    -   Advanced Custom Fields Pro
    -   Yoast SEO
    -   WPForms (or alternative)
    -   Any plugin dependencies documented in /inc/

4.  If ACF JSON sync is enabled, go to:
    Custom Fields → Sync
    and sync available fields.

------------------------------------------------------------------------

Development

Requirements

-   Node.js (LTS)
-   NPM or Yarn
-   Sass compiler
-   Build tool (Vite, Gulp, or custom script depending on your setup)

Commands

These may vary depending on your build script:

    npm install
    npm run dev
    npm run build

Output is minified and placed in /assets/.

------------------------------------------------------------------------

Deployment Notes

-   Only compiled assets should be deployed to production.
-   Development files (/src, /node_modules, etc.) are excluded.
-   Pagely deployment workflow is supported through GitHub Actions (if
    configured).

------------------------------------------------------------------------

Editing & Extending

To customize: - Styles → /assets/src/scss/
- JS → /assets/src/js/
- Templates → /template-parts/ or root theme PHP files
- Custom Blocks → /inc/ + block-specific template folders

Follow WordPress best practices when extending functionality.

------------------------------------------------------------------------

Support

For updates, maintenance, or custom feature requests:
Black Lab Development
https://www.blacklabdev.com

------------------------------------------------------------------------

License

This theme is proprietary and licensed exclusively to Delcam Capital.
Redistribution or reuse is prohibited unless approved by Black Lab
Development.
