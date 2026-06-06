<?php
/**
 * DelCam Capital — Site Seed Script
 *
 * Creates all pages, navigation menus, taxonomy terms, and ACF options
 * needed to launch the WordPress site.
 *
 * Usage (from WordPress root):
 *   wp eval-file wp-content/themes/delcam/tools/seed-site.php
 *
 * Safe to re-run: skips items that already exist by slug/name.
 *
 * @package DelCam_Capital
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Run via WP-CLI: wp eval-file wp-content/themes/delcam/tools/seed-site.php' );
}

WP_CLI::log( '' );
WP_CLI::log( '══════════════════════════════════════════' );
WP_CLI::log( '  DelCam Capital — Site Seed' );
WP_CLI::log( '══════════════════════════════════════════' );

// ─────────────────────────────────────────────────────────────────────────────
// HELPER
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Create a page if it doesn't already exist.
 * Returns the post ID.
 */
function seed_page( string $title, string $slug, string $content = '', int $parent = 0, string $template = '' ): int {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		WP_CLI::log( "  ↳ skip  '{$slug}' (already exists, ID {$existing->ID})" );
		return $existing->ID;
	}
	$id = wp_insert_post( array(
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_parent'  => $parent,
		'page_template'=> $template,
	) );
	if ( is_wp_error( $id ) ) {
		WP_CLI::warning( "  ✗ failed to create '{$slug}': " . $id->get_error_message() );
		return 0;
	}
	WP_CLI::log( "  ✓ created '{$slug}' (ID {$id})" );
	return $id;
}

// ─────────────────────────────────────────────────────────────────────────────
// 1. FLUSH REWRITE RULES (needed after CPT registration changes)
// ─────────────────────────────────────────────────────────────────────────────
WP_CLI::log( "\n▸ Flushing rewrite rules…" );
flush_rewrite_rules( true );
WP_CLI::log( '  ✓ done' );

// ─────────────────────────────────────────────────────────────────────────────
// 2. PAGES
// ─────────────────────────────────────────────────────────────────────────────
WP_CLI::log( "\n▸ Creating pages…" );

// Home
$home_content = <<<BLOCKS
<!-- wp:delcam/homepage-hero /-->
<!-- wp:delcam/portfolio-marquee /-->
<!-- wp:delcam/investment-strategy /-->
<!-- wp:delcam/vertical-blocks /-->
<!-- wp:delcam/sectors /-->
<!-- wp:delcam/large-text-callout /-->
BLOCKS;

$home_id = seed_page( 'Home', 'home', $home_content );

// About (parent)
$about_content = <<<BLOCKS
<!-- wp:delcam/interior-page-hero {"sectionLabel":"// About Us","headline":"BUILT BY OPERATORS, FOCUSED ON MANUFACTURING.","subhead":"DelCam Capital is a private equity firm partnering with founders and management teams to build enduring precision manufacturing businesses."} /-->
<!-- wp:delcam/content-image /-->
<!-- wp:delcam/firm-values /-->
<!-- wp:delcam/highlighted-boxes /-->
<!-- wp:delcam/large-text-callout {"eyebrowLabel":"// Get In Touch","callout":"READY TO START A CONVERSATION?","subtext":"Whether you're considering a transition or want to learn more about our approach, we'd love to hear from you.","button1":{"label":"Contact Us","url":"/contact/"},"button2":{"label":"Our Strategy","url":"/strategy/"}} /-->
BLOCKS;
$about_id = seed_page( 'About', 'about', $about_content );

// Our Team
$team_content = <<<BLOCKS
<!-- wp:delcam/interior-page-hero {"sectionLabel":"// Our People","headline":"LEADERSHIP &\nADVISORY TEAM","subhead":"The DelCam Capital team brings decades of operational experience in precision manufacturing and private equity."} /-->
<!-- wp:delcam/team-members /-->
BLOCKS;
$team_id = seed_page( 'Our Team', 'our-team', $team_content, $about_id );

// Firm Values
$values_content = <<<BLOCKS
<!-- wp:delcam/interior-page-hero {"sectionLabel":"// Our Values","headline":"WHAT WE STAND FOR","subhead":"Our values are not just words on a wall — they define how we operate and build lasting businesses."} /-->
<!-- wp:delcam/firm-values /-->
<!-- wp:delcam/highlighted-boxes /-->
BLOCKS;
$values_id = seed_page( 'Firm Values', 'firm-values', $values_content, $about_id );

// Strategy (parent)
$strategy_content = <<<BLOCKS
<!-- wp:delcam/interior-page-hero {"sectionLabel":"// Our Strategy","headline":"ACQUIRE. OPERATE. GROW.","subhead":"We invest in precision manufacturing businesses with proven operations, strong customer relationships, and clear paths to growth."} /-->
<!-- wp:delcam/investment-strategy /-->
<!-- wp:delcam/vertical-blocks /-->
<!-- wp:delcam/sectors /-->
BLOCKS;
$strategy_id = seed_page( 'Strategy', 'strategy', $strategy_content );

// Investment Criteria
$criteria_content = <<<BLOCKS
<!-- wp:delcam/interior-page-hero {"sectionLabel":"// Investment Criteria","headline":"WHAT WE LOOK FOR","subhead":"DelCam Capital targets established precision manufacturing businesses that are ready for their next chapter."} /-->
<!-- wp:delcam/funds-overview /-->
<!-- wp:delcam/sectors /-->
<!-- wp:delcam/large-text-callout {"eyebrowLabel":"// Sell Your Business","callout":"IS YOUR COMPANY A FIT?","subtext":"We move quickly, close on time, and take a hands-on approach to every partnership.","button1":{"label":"Contact Us","url":"/contact/"},"button2":{"label":"Our Process","url":"/strategy/our-process/"}} /-->
BLOCKS;
$criteria_id = seed_page( 'Investment Criteria', 'investment-criteria', $criteria_content, $strategy_id );

// Our Process
$process_content = <<<BLOCKS
<!-- wp:delcam/interior-page-hero {"sectionLabel":"// Our Process","headline":"FROM FIRST CALL TO CLOSE.","subhead":"We operate with speed and transparency. From initial call to close in 60–90 days."} /-->
<!-- wp:delcam/vertical-blocks /-->
<!-- wp:delcam/large-text-callout {"eyebrowLabel":"// Let's Talk","callout":"START THE CONVERSATION TODAY.","subtext":"Reach out to learn more about our process and how we partner with business owners.","button1":{"label":"Contact Us","url":"/contact/"}} /-->
BLOCKS;
$process_id = seed_page( 'Our Process', 'our-process', $process_content, $strategy_id );

// Portfolio
$portfolio_content = <<<BLOCKS
<!-- wp:delcam/interior-page-hero {"sectionLabel":"// Our Portfolio","headline":"PORTFOLIO COMPANIES","subhead":"A growing family of precision manufacturing businesses across the Northeast and Southeast."} /-->
<!-- wp:delcam/company-portfolio /-->
BLOCKS;
$portfolio_id = seed_page( 'Portfolio', 'portfolio-page', $portfolio_content );
// Rename the slug to 'portfolio' if CPT hasn't claimed it yet
wp_update_post( array( 'ID' => $portfolio_id, 'post_name' => 'portfolio-companies' ) );

// News (parent / archive landing)
$news_content = <<<BLOCKS
<!-- wp:delcam/interior-page-hero {"sectionLabel":"// News & Press","headline":"NEWS &\nPRESS","subhead":"Coverage, insights, and firm updates from DelCam Capital."} /-->
BLOCKS;
$news_id = seed_page( 'News', 'news-page', $news_content );

// Press Releases
$press_content = <<<BLOCKS
<!-- wp:delcam/interior-page-hero {"sectionLabel":"// Press Releases","headline":"PRESS RELEASES","subhead":"Official announcements and press releases from DelCam Capital."} /-->
BLOCKS;
$press_id = seed_page( 'Press Releases', 'press-releases', $press_content, $news_id );

// In the News
$in_news_content = <<<BLOCKS
<!-- wp:delcam/interior-page-hero {"sectionLabel":"// In the News","headline":"IN THE NEWS","subhead":"Media coverage and industry features on DelCam Capital and our portfolio companies."} /-->
BLOCKS;
$in_news_id = seed_page( 'In the News', 'in-the-news', $in_news_content, $news_id );

// Contact
$contact_content = <<<BLOCKS
<!-- wp:delcam/interior-page-hero {"sectionLabel":"// Contact","headline":"GET IN TOUCH","subhead":"Whether you're a business owner considering a sale or a potential investor — we'd love to hear from you."} /-->
BLOCKS;
$contact_id = seed_page( 'Contact', 'contact', $contact_content );

// Legal pages
$privacy_content = '<!-- wp:delcam/prose-content --><!-- /wp:delcam/prose-content -->';
seed_page( 'Privacy Policy',      'privacy-policy',       $privacy_content );
seed_page( 'Terms & Conditions',  'terms-and-conditions', $privacy_content );
seed_page( 'Disclaimer',          'disclaimer',           $privacy_content );

// ─────────────────────────────────────────────────────────────────────────────
// 3. READING SETTINGS — set front page
// ─────────────────────────────────────────────────────────────────────────────
WP_CLI::log( "\n▸ Setting front page…" );
if ( $home_id ) {
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
	WP_CLI::log( "  ✓ front page → '{$home_id}'" );
}

// ─────────────────────────────────────────────────────────────────────────────
// 4. PRIMARY NAVIGATION MENU
// ─────────────────────────────────────────────────────────────────────────────
WP_CLI::log( "\n▸ Building primary navigation menu…" );

$menu_name     = 'Primary Navigation';
$menu_location = 'menu-1';

$existing_menu = wp_get_nav_menu_object( $menu_name );
if ( $existing_menu ) {
	WP_CLI::log( "  ↳ skip  menu '{$menu_name}' (already exists)" );
	$menu_id = $existing_menu->term_id;
} else {
	$menu_id = wp_create_nav_menu( $menu_name );
	WP_CLI::log( "  ✓ created menu '{$menu_name}' (ID {$menu_id})" );
}

/**
 * Add a menu item; returns the item ID.
 */
function seed_menu_item( int $menu_id, string $title, string $url, int $parent = 0, int $order = 0 ): int {
	return wp_update_nav_menu_item( $menu_id, 0, array(
		'menu-item-title'     => $title,
		'menu-item-url'       => $url,
		'menu-item-status'    => 'publish',
		'menu-item-parent-id' => $parent,
		'menu-item-position'  => $order,
	) );
}

$site_url = untrailingslashit( get_site_url() );

// Top-level items
$mi_about    = seed_menu_item( $menu_id, 'About',     $site_url . '/about/',    0, 10 );
$mi_strategy = seed_menu_item( $menu_id, 'Strategy',  $site_url . '/strategy/', 0, 20 );
$mi_port     = seed_menu_item( $menu_id, 'Portfolio', $site_url . '/portfolio-companies/', 0, 30 );
$mi_news     = seed_menu_item( $menu_id, 'News',      $site_url . '/news-page/', 0, 40 );
$mi_contact  = seed_menu_item( $menu_id, 'Contact',   $site_url . '/contact/',  0, 50 );

// About sub-menu
seed_menu_item( $menu_id, 'Our Team',    $site_url . '/about/our-team/',    $mi_about,    11 );
seed_menu_item( $menu_id, 'Firm Values', $site_url . '/about/firm-values/', $mi_about,    12 );

// Strategy sub-menu
seed_menu_item( $menu_id, 'Investment Criteria', $site_url . '/strategy/investment-criteria/', $mi_strategy, 21 );
seed_menu_item( $menu_id, 'Our Process',         $site_url . '/strategy/our-process/',         $mi_strategy, 22 );

// News sub-menu
seed_menu_item( $menu_id, 'Press Releases', $site_url . '/news-page/press-releases/', $mi_news, 41 );
seed_menu_item( $menu_id, 'In the News',    $site_url . '/news-page/in-the-news/',    $mi_news, 42 );

// Assign menu to location
$locations                    = get_theme_mod( 'nav_menu_locations', array() );
$locations[ $menu_location ]  = $menu_id;
set_theme_mod( 'nav_menu_locations', $locations );
WP_CLI::log( "  ✓ assigned to location '{$menu_location}'" );

// ─────────────────────────────────────────────────────────────────────────────
// 5. FOOTER MENU (menu-2) — mirrors primary without dropdowns
// ─────────────────────────────────────────────────────────────────────────────
WP_CLI::log( "\n▸ Building footer navigation menu…" );

$footer_menu_name = 'Footer Navigation';
$footer_existing  = wp_get_nav_menu_object( $footer_menu_name );

if ( $footer_existing ) {
	WP_CLI::log( "  ↳ skip  menu '{$footer_menu_name}' (already exists)" );
	$footer_menu_id = $footer_existing->term_id;
} else {
	$footer_menu_id = wp_create_nav_menu( $footer_menu_name );
	WP_CLI::log( "  ✓ created menu '{$footer_menu_name}' (ID {$footer_menu_id})" );
}

seed_menu_item( $footer_menu_id, 'About',                $site_url . '/about/',                          0, 10 );
seed_menu_item( $footer_menu_id, 'Our Team',             $site_url . '/about/our-team/',                 0, 11 );
seed_menu_item( $footer_menu_id, 'Firm Values',          $site_url . '/about/firm-values/',              0, 12 );
seed_menu_item( $footer_menu_id, 'Strategy',             $site_url . '/strategy/',                       0, 20 );
seed_menu_item( $footer_menu_id, 'Investment Criteria',  $site_url . '/strategy/investment-criteria/',   0, 21 );
seed_menu_item( $footer_menu_id, 'Our Process',          $site_url . '/strategy/our-process/',           0, 22 );
seed_menu_item( $footer_menu_id, 'Portfolio',            $site_url . '/portfolio-companies/',            0, 30 );
seed_menu_item( $footer_menu_id, 'News',                 $site_url . '/news-page/',                      0, 40 );
seed_menu_item( $footer_menu_id, 'Press Releases',       $site_url . '/news-page/press-releases/',       0, 41 );
seed_menu_item( $footer_menu_id, 'In the News',          $site_url . '/news-page/in-the-news/',          0, 42 );
seed_menu_item( $footer_menu_id, 'Contact',              $site_url . '/contact/',                        0, 50 );

$locations['menu-2'] = $footer_menu_id;
set_theme_mod( 'nav_menu_locations', $locations );
WP_CLI::log( "  ✓ assigned to location 'menu-2'" );

// ─────────────────────────────────────────────────────────────────────────────
// 6. NEWS TYPE TAXONOMY TERMS
// ─────────────────────────────────────────────────────────────────────────────
WP_CLI::log( "\n▸ Creating news type taxonomy terms…" );
$news_types = array(
	array( 'name' => 'Press Release', 'slug' => 'press-release' ),
	array( 'name' => 'In the News',   'slug' => 'in-the-news'   ),
	array( 'name' => 'White Paper',   'slug' => 'white-paper'   ),
);
foreach ( $news_types as $term ) {
	if ( ! term_exists( $term['slug'], 'news_type' ) ) {
		$result = wp_insert_term( $term['name'], 'news_type', array( 'slug' => $term['slug'] ) );
		if ( is_wp_error( $result ) ) {
			WP_CLI::warning( "  ✗ {$term['name']}: " . $result->get_error_message() );
		} else {
			WP_CLI::log( "  ✓ news type: '{$term['name']}'" );
		}
	} else {
		WP_CLI::log( "  ↳ skip  news type '{$term['name']}' (exists)" );
	}
}

// ─────────────────────────────────────────────────────────────────────────────
// 7. PORTFOLIO CATEGORY TERMS
// ─────────────────────────────────────────────────────────────────────────────
WP_CLI::log( "\n▸ Creating portfolio category terms…" );
$portfolio_categories = array(
	'Precision Machining',
	'Metal Fabrication',
	'Plastics Fabrication',
	'Electronics Manufacturing',
	'Aerospace & Defense',
	'Industrial Services',
);
foreach ( $portfolio_categories as $cat ) {
	$slug = sanitize_title( $cat );
	if ( ! term_exists( $slug, 'portfolio_category' ) ) {
		$result = wp_insert_term( $cat, 'portfolio_category', array( 'slug' => $slug ) );
		if ( ! is_wp_error( $result ) ) {
			WP_CLI::log( "  ✓ category: '{$cat}'" );
		}
	} else {
		WP_CLI::log( "  ↳ skip  '{$cat}' (exists)" );
	}
}

// ─────────────────────────────────────────────────────────────────────────────
// 8. ACF OPTIONS (eyebrow message + footer address)
// ─────────────────────────────────────────────────────────────────────────────
WP_CLI::log( "\n▸ Setting ACF options…" );
if ( function_exists( 'update_field' ) ) {
	update_field( 'eyebrow_message', 'PRIVATE EQUITY · PRECISION MANUFACTURING · UNITED STATES', 'option' );
	WP_CLI::log( "  ✓ eyebrow_message" );
	update_field( 'footer_address', "50 Mellen Street\nHopedale, MA 01747", 'option' );
	WP_CLI::log( "  ✓ footer_address" );
} else {
	WP_CLI::warning( '  ACF not active — options skipped' );
}

// ─────────────────────────────────────────────────────────────────────────────
// DONE
// ─────────────────────────────────────────────────────────────────────────────
WP_CLI::log( '' );
WP_CLI::success( 'Site seed complete. Next steps:' );
WP_CLI::log( '  1. Go to Settings → Permalinks and save (finalises rewrite rules)' );
WP_CLI::log( '  2. Add team members via Admin → Team' );
WP_CLI::log( '  3. Add portfolio companies via Admin → Portfolio' );
WP_CLI::log( '  4. Add news posts via Admin → News & Press' );
WP_CLI::log( '  5. Upload a site logo via Appearance → Customize' );
WP_CLI::log( '' );
