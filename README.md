# Xhat Blog — WordPress Theme

A custom WordPress theme for the Xhat blog, built to match the dark branding of
<https://xhat.com/>.

Posts are **native WordPress posts** — add, edit and publish everything from
the normal dashboard (Posts → Add New). No page builder, no custom post type,
no plugin dependency.

**Version:** 1.0.0

---

## 1. Installation

1. **Appearance → Themes → Add New → Upload Theme** → choose
   `xhat-blog.zip` → **Install Now** → **Activate**.
2. **Settings → Permalinks** → click **Save Changes** (flushes rewrite rules —
   do this or category/date archives may 404).
3. **Settings → Reading** → set **"Blog pages show at most"** to **12**.
   The card grid is fluid (2 columns around 1440px, 3 on wider screens), and
   12 divides evenly either way.

That is all that is required.

### Optional

| Step | Where | Notes |
|---|---|---|
| Menu | Appearance → Menus | Assign a menu to **Primary Menu (header)**. Without one the theme shows its built-in nav (Home, Blog). Sub-menus render as a dropdown. |
| Logo | Appearance → Customize → Site Identity | Optional — the bundled Xhat mark is used if you set nothing. |
| Favicon | Appearance → Customize → Site Identity → Site Icon | Optional — the theme uses the Xhat mark. A Site Icon set here overrides it. |
| Sidebar | Appearance → Widgets → **Blog Sidebar** | **Leave empty** to get the theme's own sidebar (branded search, latest posts with thumbnails, topics, "Try Xhat free" CTA). Any widgets you add replace it — core blocks are styled to match. |
| Categories | Posts → Categories | e.g. *Product*, *Privacy*, *Guides*. The default "Uncategorized" is hidden everywhere on purpose. |

---

## 2. Branding (read from the live site, not invented)

| Token | Value | Source |
|---|---|---|
| Brand mint | `#00FFC6` | most-used accent in the xhat.com CSS bundle |
| Mint deep | `#04BA93` | header "Launch Now" button border/text |
| Background | `#0A0A0A` | `--background` custom property |
| Surface / border | `#101312`, `#1F2523` | card and panel treatment |
| Heading / body | `#FFFFFF`, `#B2BAB8` | hero and body copy |
| Typeface | **Inter** (Google Fonts) | `__Inter_*` font classes |
| Container | `min(1440px, 89.58%)` | shared with the main site layout |
| Header logo | `xhat-logo.png` (394×378) | live header `<img>` |

Text on a mint background uses `--xhat-on-accent` (`#04140F`), never white —
white on `#00FFC6` fails contrast.

### Switching the palette

Every colour is a custom property in the `:root` block at the top of
`style.css`. Change those values and the whole theme follows; nothing else
hard-codes a brand colour.

---

## 3. Templates

| File | Purpose |
|---|---|
| `style.css` | Theme metadata + the complete stylesheet. |
| `functions.php` | Setup, asset enqueueing, image sizes, menu, widget area, favicon, comment disabling. |
| `header.php` | Sticky dark header: logo, nav, mint "Launch Now" pill, mobile menu. |
| `footer.php` | Closes the page wrappers and fires `wp_footer()`. **There is no visible footer** — do not delete this file or that call. |
| `index.php` | Blog listing — featured images, titles, excerpts, dates, pagination. Also serves as the front page. |
| `single.php` | Single post — breadcrumbs, meta, featured image, content, tags, share, prev/next, related posts. |
| `archive.php` | Category / tag / author / date archives. |
| `search.php` | Search results. |
| `page.php` | Static pages. |
| `404.php` | Not-found page. |
| `sidebar.php` | Widget area + the theme's own fallback sidebar. |
| `searchform.php` | Branded search form. |
| `template-parts/card.php` | Reusable post card. |
| `template-parts/content-none.php` | Empty state for listings and search. |
| `inc/template-tags.php` | Helpers: icons, logo, nav, card meta, reading time, breadcrumbs, pagination, share links, related posts. |
| `assets/` | `css/editor-style.css`, `js/main.js`, `images/xhat-logo.png`. |

---

## 4. Deliberate design decisions

These are intentional. If something looks "missing", it is probably here.

- **No visible footer.** `footer.php` still exists because `wp_footer()` must run.
- **No comments anywhere.** Disabled at theme level in `functions.php` — this
  covers existing posts too, which Settings → Discussion does not. The admin
  Comments menu, dashboard widget and toolbar bubble are hidden. To restore,
  delete the "Comments are disabled site-wide" block.
- **No author bylines.** Cards and single posts show date and reading time only.
- **"Uncategorized" is hidden** from breadcrumbs, topic lists and the sidebar
  (it is WordPress's default category, not a real topic).
- **No "featured" oversized card** — all cards are uniform.
- **Home and the logo link to the main Next.js site**, not to WordPress.
  **Blog** is this WordPress site.
- **The editor canvas is dark too**, so drafting looks like the published page.

### Changing the external links without editing the theme

```php
// Where the logo and "Home" point.
add_filter( 'xhat_home_url', function () { return home_url( '/' ); } );

// Base URL of the main Xhat site.
add_filter( 'xhat_main_site_url', function () { return 'https://xhat.com'; } );

// Where every "Launch Now" button goes.
add_filter( 'xhat_launch_url', function () { return 'https://xhat.com/'; } );

// The whole default header menu.
add_filter( 'xhat_default_nav_items', function ( $items ) { return $items; } );
```

---

## 5. Standards

- All dynamic output escaped (`esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`).
- All URLs dynamic (`home_url()`, `get_permalink()`, `get_template_directory_uri()`).
  No hard-coded site URLs anywhere.
- CSS and JS registered via `wp_enqueue_style()` / `wp_enqueue_script()`.
- Translation ready — text domain `xhat-blog`.
- Accessible — skip link, ARIA on nav/dropdown toggles, visible focus rings,
  `prefers-reduced-motion` support, dark `color-scheme`.
- Standard template hierarchy.

---

## 6. Requirements

- WordPress 6.0+
- PHP 7.4+
- An internet connection on first load for the Inter webfont (falls back to
  Segoe UI / system sans without it).
