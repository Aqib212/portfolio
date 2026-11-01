# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

Md. Zahiruddin Aqib's personal portfolio. It's a static site built on the BootstrapMade **iPortfolio** template (Bootstrap 5.3.3). There's no build step, package manager, linter or test suite: edit the files, then reload. Laragon serves it locally at `http://aqib_portfolio.test` (from `D:\laragon\www\aqib_portfolio`). Only the contact form needs PHP.

## Content sources of truth

- **The CV is the authority** for titles, dates, degrees, skills and project claims. Keep the site consistent with it. Experience is shown as "7+ years", counted from Feb 2019.
- **Cubix module descriptions** (Restaurant/F&B, Recipe, Inventory, Fixed Assets) follow Cubix Technology's product pages. The source data is in `https://cubixbd.com/js/product.js`; the pages render client-side, so fetch the JS, not the HTML. Each project card links to `https://cubixbd.com/projects.html?product=hotel|cudine|cupos|stockmaster|cufam`.
- **Publications:**
  - The crop-pattern paper and the Bangla-text review are published, with DOIs.
  - The recombination-hotspots paper is the owner's own unpublished research. Never give it a venue or DOI.
- **Don't publish on the site:** referee details, CGPA, birthday or age, street address.

## Structure

- `index.html` is a single page of anchored sections, in nav order:
  - `#hero`, `#about`, `#stats`, `#services` ("What I Do"), `#stack`, `#portfolio` ("Featured Projects"), `#resume` ("Experience"), `#research`, `#contact`.
  - A "Recommendations" section (`#testimonials`) is commented out, waiting for real quotes.
  - Sidebar nav `href`s must match the section ids: the scrollspy in `assets/js/main.js` matches `href="#id"` to sections.
- `portfolio-details.html` is the Hotel ERP modules case study. It has `#restaurant`, `#recipe`, `#inventory` and `#fixed-assets` anchors, which the project cards link to.
  - Its header and footer are copied from `index.html`, not shared, so nav and social changes have to be made in both files.
- `assets/css/main.css`:
  - The template's own sections come first. Theme tokens are at the top (`--accent-color` is #2563eb; Inter is the only font). `.light-background` and `.dark-background` override the tokens for a whole section.
  - Everything added for the redesign is in one block at the end ("Portfolio redesign additions" plus "Case study page"). `.products` (Cubix product pills) and `.tags` are global there, so both pages can use them.
  - There are no SCSS sources; those come only with the paid version of the template.
- `assets/js/main.js` initialises the vendor libraries from markup hooks:
  - `.typed` + `data-typed-items` (comma-separated, no spaces after the commas, because the split doesn't trim)
  - PureCounter `data-purecounter-*`
  - Isotope `.isotope-layout` / `.isotope-filters` (project filters are `filter-erp|api|oracle|laravel|research` classes on each item)
  - Swiper `.init-swiper` with an inner `.swiper-config` JSON
  - AOS `data-aos`

  To add behaviour, use these hooks rather than writing new JS.
- `assets/img/portfolio/*.svg` holds the hand-written project cover images (800×450). Cubix screenshots and logos belong to the company; don't use them without its permission.
- `assets/vendor/` contains vendored libraries. Don't edit them.
- `forms/contact.php` is a library-free handler. It validates the fields, strips CR/LF from header fields, calls `mail()` and echoes `OK`, which is the exact body `assets/vendor/php-email-form/validate.js` treats as success. Locally, Laragon's sendmail has no SMTP credentials configured, so messages land in `D:\laragon\bin\sendmail\output\` instead of being sent.

## Gotchas

- The hero image is tracked in git as `assets/img/hero-bg-aqib.JPG` (uppercase extension), and the HTML uses the same case. Linux hosts are case-sensitive.
- The "Download CV" links point to `assets/Zahiruddin_Aqib_CV.pdf`, which the owner supplies.
- Headless-Chrome screenshots don't render scrolled or AOS-animated content, and the hero is `min-height: 100vh`. To preview, use a temporary copy with `[data-aos]{opacity:1!important;transform:none!important}` and a fixed hero height, then delete it. The narrowest headless window is about 500px, so render phone widths inside a 390px iframe.
