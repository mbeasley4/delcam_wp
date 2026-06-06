<?php
/**
 * ACF → Native Gutenberg Block Migration Script
 *
 * Converts ACF block comments to native delcam/* block comments, migrating
 * block attributes and copying repeater/relationship data to post meta so
 * get_field() works in the new render.php files.
 *
 * Usage (WP-CLI):
 *   wp eval-file wp-content/themes/delcam/tools/migrate-acf-blocks.php
 *   wp eval-file wp-content/themes/delcam/tools/migrate-acf-blocks.php live
 *
 * In dry-run mode (default), the script prints every change it would make but
 * writes nothing to the database. Pass --live to commit changes.
 */

// ─────────────────────────────────────────────────────────────────────────────
// Bootstrap — works both as a WP-CLI eval-file and as a direct PHP include
// inside WordPress (e.g., from a one-time admin page).
// ─────────────────────────────────────────────────────────────────────────────

if ( ! defined( 'ABSPATH' ) ) {
	// Loaded via WP-CLI eval-file; WordPress is already bootstrapped.
	if ( ! function_exists( 'add_action' ) ) {
		die( "This script must be run inside a WordPress environment.\n" );
	}
}

global $wpdb;

// WP-CLI passes positional args after the filename as $args.
// Run with: wp eval-file ... live
// $args is set by WP-CLI eval-file; fall back to empty array if not defined.
$script_args = isset( $args ) && is_array( $args ) ? $args : [];

$dry_run = ! in_array( 'live', $script_args, true );

// Also support running from a browser/admin context with ?live=1.
if ( isset( $_GET['live'] ) ) {
	$dry_run = false;
}

$log_prefix = $dry_run ? '[DRY-RUN] ' : '[LIVE] ';

function migrate_log( $msg ) {
	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		WP_CLI::log( $msg );
	} else {
		echo esc_html( $msg ) . "\n";
	}
}

migrate_log( '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━' );
migrate_log( 'DelCam ACF → Native Gutenberg Block Migration' );
migrate_log( $dry_run ? 'Mode: DRY-RUN (pass --live to write)' : 'Mode: LIVE — changes will be saved!' );
migrate_log( '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━' );

// ─────────────────────────────────────────────────────────────────────────────
// Block mapping definitions
//
// Each entry:
//   'acf_name'    => The ACF block name as stored in post_content (e.g. "acf/homepage-hero")
//   'native_name' => The new native block name (e.g. "delcam/homepage-hero")
//   'attr_map'    => [ 'acf_field' => 'nativeAttr' ]  (simple scalar fields)
//   'link_map'    => [ 'acf_field' => ['text' => 'nativeAttrText', 'url' => 'nativeAttrUrl', 'target' => 'nativeAttrTarget'] ]
//                    ACF link fields are objects { title, url, target }
//   'meta_keys'   => [ 'field_key' ]  – raw ACF data keys to save as post meta
//                    (use prefix matching: 'repeater_name' matches all repeater_name* keys)
//   'image_map'   => [ 'acf_field' => ['id' => 'nativeAttrId', 'url' => 'nativeAttrUrl', 'alt' => 'nativeAttrAlt'] ]
//                    ACF image fields store an attachment ID; we resolve to URL+alt.
// ─────────────────────────────────────────────────────────────────────────────

$block_map = [

	// ── Homepage Hero ──────────────────────────────────────────────────────
	'acf/homepage-hero' => [
		'native_name' => 'delcam/homepage-hero',
		'attr_map'    => [
			'section_label' => 'sectionLabel',
			'headline'      => 'headline',
			'subhead'       => 'subhead',
		],
		'link_map'    => [
			'button_1' => [ 'text' => 'button1Text', 'url' => 'button1Url' ],
			'button_2' => [ 'text' => 'button2Text', 'url' => 'button2Url' ],
		],
		'meta_keys'   => [ 'stat_cards', 'background_video', 'background_image' ],
	],

	// ── Interior Page Hero ─────────────────────────────────────────────────
	'acf/interior-page-hero' => [
		'native_name' => 'delcam/interior-page-hero',
		'attr_map'    => [
			'section_label' => 'sectionLabel',
			'headline'      => 'headline',
			'content'       => 'subhead',      // ACF "content" → attr "subhead"
			'subhead'       => 'subhead',      // fallback if field was named subhead
		],
		'meta_keys'   => [ 'background_image' ],
	],

	// ── Content + Image ────────────────────────────────────────────────────
	'acf/content-image' => [
		'native_name' => 'delcam/content-image',
		'attr_map'    => [
			'section_label' => 'sectionLabel',
			'headline'      => 'headline',
			'content'       => 'bodyContent',
			'cta_label'     => 'ctaLabel',
			'swap_image'    => 'swapImage',
		],
		'link_map'    => [
			'cta_button' => [ 'text' => 'ctaLabel', 'url' => 'ctaUrl', 'target' => 'ctaTarget' ],
		],
		'image_map'   => [
			'image' => [ 'id' => 'imageId', 'url' => 'imageUrl', 'alt' => 'imageAlt' ],
		],
	],

	// ── Content + 3 Feature Boxes (try both possible ACF block names) ──────
	// ACF block name depends on the 'name' param passed to acf_register_block_type.
	'acf/content-3-blocks' => [
		'native_name' => 'delcam/content-3-blocks',
		'attr_map'    => [
			'headline'      => 'headline',
			'main_content'  => 'mainContent',
			'content'       => 'mainContent',   // fallback
			'headline_1'    => 'headline1',
			'content_1'     => 'content1',
			'headline_2'    => 'headline2',
			'content_2'     => 'content2',
			'headline_3'    => 'headline3',
			'content_3'     => 'content3',
		],
		'meta_keys'   => [ 'icon_1', 'icon_2', 'icon_3' ],
	],
	'acf/content-plus-3-feature-boxes' => [
		'native_name' => 'delcam/content-3-blocks',
		'attr_map'    => [
			'headline'      => 'headline',
			'main_content'  => 'mainContent',
			'content'       => 'mainContent',
			'headline_1'    => 'headline1',
			'content_1'     => 'content1',
			'headline_2'    => 'headline2',
			'content_2'     => 'content2',
			'headline_3'    => 'headline3',
			'content_3'     => 'content3',
		],
		'meta_keys'   => [ 'icon_1', 'icon_2', 'icon_3' ],
	],

	// ── Highlighted Boxes ──────────────────────────────────────────────────
	'acf/highlighted-boxes' => [
		'native_name' => 'delcam/highlighted-boxes',
		'attr_map'    => [
			'section_label' => 'sectionLabel',
			'headline'      => 'headline',
			'content'       => 'content',
		],
		'meta_keys'   => [ 'highlights' ],
	],

	// ── Content + Vertical Blocks (double-hyphen ACF name) ─────────────────
	'acf/content--vertical-blocks' => [
		'native_name' => 'delcam/vertical-blocks',
		'attr_map'    => [
			'section_label'    => 'sectionLabel',
			'headline'         => 'headline',
			'content'          => 'content',
			'countdown_number' => 'countdownNumber',
			'countdown_label'  => 'countdownLabel',
		],
		'meta_keys'   => [ 'vertical_blocks' ],
	],
	// Fallback in case the DB has a single-hyphen variant
	'acf/content-vertical-blocks' => [
		'native_name' => 'delcam/vertical-blocks',
		'attr_map'    => [
			'section_label'    => 'sectionLabel',
			'headline'         => 'headline',
			'content'          => 'content',
			'countdown_number' => 'countdownNumber',
			'countdown_label'  => 'countdownLabel',
		],
		'meta_keys'   => [ 'vertical_blocks' ],
	],

	// ── Company Portfolio ──────────────────────────────────────────────────
	'acf/company-portfolio' => [
		'native_name' => 'delcam/company-portfolio',
		'attr_map'    => [
			'section_label'    => 'sectionLabel',
			'section_headline' => 'sectionHeadline',
			'headline'         => 'sectionHeadline',  // ACF stored as "headline"
			'content'          => 'description',
			'description'      => 'description',
		],
	],

	// ── Selected Company Portfolio ─────────────────────────────────────────
	'acf/selected-company-portfolio' => [
		'native_name' => 'delcam/company-portfolio-selected',
		'attr_map'    => [
			'section_label'    => 'sectionLabel',
			'section_headline' => 'sectionHeadline',
			'headline'         => 'sectionHeadline',  // ACF stored as "headline"
			'content'          => 'description',
			'limit'            => 'limit',
		],
		'link_map'    => [
			'call-to-action_button' => [ 'text' => 'ctaButtonText', 'url' => 'ctaButtonUrl' ],
			'cta_button'            => [ 'text' => 'ctaButtonText', 'url' => 'ctaButtonUrl' ],
		],
		'meta_keys'   => [ 'selected_companies' ],
	],

	// ── Team Members ───────────────────────────────────────────────────────
	'acf/team-members' => [
		'native_name' => 'delcam/team-members',
		// No block attributes; all data is via ACF get_field() on CPT posts.
		'attr_map'    => [],
	],

	// ── Large Text Callout ─────────────────────────────────────────────────
	'acf/large-text-callout' => [
		'native_name' => 'delcam/large-text-callout',
		'attr_map'    => [
			'eyebrow_label' => 'sectionLabel',
			'section_label' => 'sectionLabel',
			'callout'       => 'callout',
			'subtext'       => 'subtext',
		],
		'link_map'    => [
			'button_1' => [ 'text' => 'button1Label', 'url' => 'button1Url', 'target' => 'button1Target' ],
			'button_2' => [ 'text' => 'button2Label', 'url' => 'button2Url', 'target' => 'button2Target' ],
		],
	],

	// ── Portfolio Marquee ──────────────────────────────────────────────────
	'acf/portfolio-marquee' => [
		'native_name' => 'delcam/portfolio-marquee',
		// No block attributes; all ACF repeater.
		'attr_map'    => [],
		'meta_keys'   => [ 'companies' ],
	],

	// ── Investment Strategy ────────────────────────────────────────────────
	'acf/investment-strategy' => [
		'native_name' => 'delcam/investment-strategy',
		'attr_map'    => [
			'section_label'    => 'sectionLabel',
			'section_headline' => 'sectionHeadline',
			'description'      => 'description',
			'banner_badge'     => 'bannerBadge',
			'banner_headline'  => 'bannerHeadline',
			'cta_label'        => 'ctaLabel',
			'cta_headline'     => 'ctaHeadline',
			'cta_content'      => 'ctaContent',
		],
		'link_map'    => [
			'cta_button' => [ 'text' => 'ctaButtonText', 'url' => 'ctaButtonUrl' ],
		],
		'meta_keys'   => [ 'strategy_cards' ],
	],

	// ── Sectors ────────────────────────────────────────────────────────────
	'acf/sectors' => [
		'native_name' => 'delcam/sectors',
		'attr_map'    => [
			'section_label'    => 'sectionLabel',
			'section_headline' => 'sectionHeadline',
		],
		'meta_keys'   => [ 'sector_pills', 'stat_cards' ],
	],

	// ── Funds Overview ─────────────────────────────────────────────────────
	'acf/funds-overview' => [
		'native_name' => 'delcam/funds-overview',
		'attr_map'    => [
			'section_label'    => 'sectionLabel',
			'section_headline' => 'sectionHeadline',
		],
		'link_map'    => [
			'button_1' => [ 'text' => 'button1Text', 'url' => 'button1Url' ],
			'button_2' => [ 'text' => 'button2Text', 'url' => 'button2Url' ],
		],
		'meta_keys'   => [ 'funds' ],
	],

	// ── Firm Values ────────────────────────────────────────────────────────
	'acf/firm-values' => [
		'native_name' => 'delcam/firm-values',
		'attr_map'    => [
			'section_label'    => 'sectionLabel',
			'section_headline' => 'sectionHeadline',
		],
		'meta_keys'   => [ 'values' ],
	],
];

// ─────────────────────────────────────────────────────────────────────────────
// Helper: extract all block data keys that match a given prefix (for repeaters)
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Given a flat ACF data array and a list of root key prefixes, return
 * all entries whose key starts with any of those prefixes.
 *
 * ACF repeater storage format:
 *   stat_cards   => 3            (count)
 *   stat_cards_0_label => "..."
 *   stat_cards_1_label => "..."
 *   etc.
 */
function acf_data_keys_for_meta( array $data, array $prefixes ): array {
	$out = [];
	foreach ( $prefixes as $prefix ) {
		foreach ( $data as $key => $value ) {
			// Match exact key OR prefix_ (repeater sub-keys and count)
			if ( $key === $prefix || strpos( $key, $prefix . '_' ) === 0 ) {
				$out[ $key ] = $value;
			}
		}
	}
	return $out;
}

// ─────────────────────────────────────────────────────────────────────────────
// Helper: resolve ACF link field (stored as JSON object or PHP array)
// ─────────────────────────────────────────────────────────────────────────────

function acf_parse_link( $value ): array {
	if ( is_string( $value ) ) {
		$decoded = json_decode( $value, true );
		if ( is_array( $decoded ) ) {
			$value = $decoded;
		}
	}
	if ( ! is_array( $value ) ) {
		return [ 'title' => '', 'url' => '', 'target' => '' ];
	}
	return [
		'title'  => $value['title']  ?? '',
		'url'    => $value['url']    ?? '',
		'target' => $value['target'] ?? '',
	];
}

// ─────────────────────────────────────────────────────────────────────────────
// Main migration logic
// ─────────────────────────────────────────────────────────────────────────────

// Fetch all posts/pages that contain an ACF block comment.
$posts = $wpdb->get_results(
	"SELECT ID, post_title, post_type, post_content
	 FROM {$wpdb->posts}
	 WHERE post_content LIKE '%<!-- wp:acf/%'
	   AND post_status IN ('publish','draft','private','pending')"
);

if ( empty( $posts ) ) {
	migrate_log( 'No posts found containing ACF blocks. Nothing to migrate.' );
	return;
}

migrate_log( sprintf( 'Found %d post(s) containing ACF blocks.', count( $posts ) ) );
migrate_log( '' );

$total_blocks_converted = 0;
$total_posts_updated    = 0;
$unknown_blocks         = [];

foreach ( $posts as $post ) {
	$original_content = $post->post_content;
	$new_content      = $original_content;
	$post_changed     = false;

	migrate_log( sprintf( '── Post #%d: "%s" (%s)', $post->ID, $post->post_title, $post->post_type ) );

	// Match all ACF block comments (self-closing and open+close variants).
	// Matches: <!-- wp:acf/block-name {...} /--> or <!-- wp:acf/block-name {...} -->..<!-- /wp:acf/block-name -->
	preg_match_all(
		'/<!--\s*wp:acf\/([\w\-]+)\s+(\{.*?\})\s*\/-->/s',
		$original_content,
		$matches,
		PREG_SET_ORDER | PREG_OFFSET_CAPTURE
	);

	foreach ( $matches as $match ) {
		$full_comment = $match[0][0];
		$block_slug   = $match[1][0];           // e.g. "homepage-hero"
		$json_str     = $match[2][0];

		$acf_block_name = 'acf/' . $block_slug;

		// Decode the block JSON.
		$block_json = json_decode( $json_str, true );
		if ( ! is_array( $block_json ) ) {
			migrate_log( sprintf( '  [SKIP] Could not parse JSON for block %s', $acf_block_name ) );
			continue;
		}

		$acf_data = isset( $block_json['data'] ) ? $block_json['data'] : [];

		// Look up the mapping for this block.
		if ( ! isset( $block_map[ $acf_block_name ] ) ) {
			if ( ! in_array( $acf_block_name, $unknown_blocks, true ) ) {
				$unknown_blocks[] = $acf_block_name;
			}
			migrate_log( sprintf( '  [UNKNOWN] No mapping defined for %s — skipped', $acf_block_name ) );
			continue;
		}

		$mapping     = $block_map[ $acf_block_name ];
		$native_name = $mapping['native_name'];
		$attr_map    = $mapping['attr_map']  ?? [];
		$link_map    = $mapping['link_map']  ?? [];
		$image_map   = $mapping['image_map'] ?? [];
		$meta_keys   = $mapping['meta_keys'] ?? [];

		// ── Build new block attributes ──────────────────────────────────

		$new_attrs = [];

		// 1. Scalar attribute mappings.
		foreach ( $attr_map as $acf_key => $native_attr ) {
			if ( isset( $acf_data[ $acf_key ] ) && $acf_data[ $acf_key ] !== '' ) {
				$value = $acf_data[ $acf_key ];
				// Handle boolean-ish values (swap_image stored as "1"/"0" or true/false).
				if ( $native_attr === 'swapImage' || $native_attr === 'swap_image' ) {
					$value = (bool) $value;
				}
				// Handle numeric "limit" field.
				if ( $native_attr === 'limit' ) {
					$value = (int) $value;
				}
				$new_attrs[ $native_attr ] = $value;
			}
		}

		// 2. Link field mappings (ACF link = { title, url, target }).
		foreach ( $link_map as $acf_key => $native_parts ) {
			if ( isset( $acf_data[ $acf_key ] ) ) {
				$link = acf_parse_link( $acf_data[ $acf_key ] );
				if ( isset( $native_parts['text'] ) && $link['title'] !== '' ) {
					$new_attrs[ $native_parts['text'] ] = $link['title'];
				}
				if ( isset( $native_parts['url'] ) && $link['url'] !== '' ) {
					$new_attrs[ $native_parts['url'] ] = $link['url'];
				}
				if ( isset( $native_parts['target'] ) && $link['target'] !== '' ) {
					$new_attrs[ $native_parts['target'] ] = $link['target'];
				}
			}
		}

		// 3. Image field mappings (ACF image = attachment ID).
		foreach ( $image_map as $acf_key => $native_parts ) {
			if ( ! empty( $acf_data[ $acf_key ] ) ) {
				$attach_id = (int) $acf_data[ $acf_key ];
				if ( $attach_id > 0 ) {
					$new_attrs[ $native_parts['id'] ] = $attach_id;
					$src = wp_get_attachment_image_src( $attach_id, 'full' );
					if ( $src ) {
						$new_attrs[ $native_parts['url'] ] = $src[0];
					}
					$alt = get_post_meta( $attach_id, '_wp_attachment_image_alt', true );
					$new_attrs[ $native_parts['alt'] ] = $alt ?: '';
				}
			}
		}

		// ── Save repeater/relationship data to post meta ─────────────────

		if ( ! empty( $meta_keys ) && ! empty( $acf_data ) ) {
			$meta_to_save = acf_data_keys_for_meta( $acf_data, $meta_keys );

			// Special case: selected_companies is a flat array of post IDs.
			if ( isset( $acf_data['selected_companies'] ) && is_array( $acf_data['selected_companies'] ) ) {
				$meta_to_save['selected_companies'] = $acf_data['selected_companies'];
			}

			foreach ( $meta_to_save as $meta_key => $meta_value ) {
				migrate_log( sprintf(
					'  [META] post #%d → update_post_meta( %s, %s )',
					$post->ID,
					$meta_key,
					is_array( $meta_value ) ? json_encode( $meta_value ) : var_export( $meta_value, true )
				) );
				if ( ! $dry_run ) {
					// Delete first to avoid stale indexed rows, then update.
					delete_post_meta( $post->ID, $meta_key );
					update_post_meta( $post->ID, $meta_key, $meta_value );
				}
			}
		}

		// ── Build the new block comment ──────────────────────────────────

		$new_comment = '<!-- wp:' . $native_name;
		if ( ! empty( $new_attrs ) ) {
			$new_comment .= ' ' . wp_json_encode( $new_attrs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
		}
		$new_comment .= ' /-->';

		migrate_log( sprintf( '  [BLOCK] %s → %s', $acf_block_name, $native_name ) );
		if ( ! empty( $new_attrs ) ) {
			migrate_log( '    attrs: ' . wp_json_encode( $new_attrs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) );
		}

		// Replace in the new content string (replace first occurrence).
		$pos = strpos( $new_content, $full_comment );
		if ( $pos !== false ) {
			$new_content = substr_replace( $new_content, $new_comment, $pos, strlen( $full_comment ) );
			$post_changed = true;
			$total_blocks_converted++;
		}
	}

	// ── Also handle non-self-closing ACF blocks (open + close tags) ────────
	// Format: <!-- wp:acf/name {...} -->..content..<!-- /wp:acf/name -->
	preg_match_all(
		'/<!--\s*wp:acf\/([\w\-]+)\s+(\{.*?\})\s*-->(.*?)<!--\s*\/wp:acf\/[\w\-]+\s*-->/s',
		$original_content,
		$open_matches,
		PREG_SET_ORDER
	);

	foreach ( $open_matches as $match ) {
		$full_comment   = $match[0];
		$block_slug     = $match[1];
		$json_str       = $match[2];
		$inner_content  = $match[3];

		$acf_block_name = 'acf/' . $block_slug;

		$block_json = json_decode( $json_str, true );
		if ( ! is_array( $block_json ) ) {
			continue;
		}
		$acf_data = isset( $block_json['data'] ) ? $block_json['data'] : [];

		if ( ! isset( $block_map[ $acf_block_name ] ) ) {
			continue; // Already reported above in self-closing loop.
		}

		$mapping     = $block_map[ $acf_block_name ];
		$native_name = $mapping['native_name'];
		$attr_map    = $mapping['attr_map']  ?? [];
		$link_map    = $mapping['link_map']  ?? [];
		$image_map   = $mapping['image_map'] ?? [];
		$meta_keys   = $mapping['meta_keys'] ?? [];

		$new_attrs = [];

		foreach ( $attr_map as $acf_key => $native_attr ) {
			if ( isset( $acf_data[ $acf_key ] ) && $acf_data[ $acf_key ] !== '' ) {
				$value = $acf_data[ $acf_key ];
				if ( $native_attr === 'swapImage' ) {
					$value = (bool) $value;
				}
				if ( $native_attr === 'limit' ) {
					$value = (int) $value;
				}
				$new_attrs[ $native_attr ] = $value;
			}
		}

		foreach ( $link_map as $acf_key => $native_parts ) {
			if ( isset( $acf_data[ $acf_key ] ) ) {
				$link = acf_parse_link( $acf_data[ $acf_key ] );
				if ( isset( $native_parts['text'] ) && $link['title'] !== '' ) {
					$new_attrs[ $native_parts['text'] ] = $link['title'];
				}
				if ( isset( $native_parts['url'] ) && $link['url'] !== '' ) {
					$new_attrs[ $native_parts['url'] ] = $link['url'];
				}
				if ( isset( $native_parts['target'] ) && $link['target'] !== '' ) {
					$new_attrs[ $native_parts['target'] ] = $link['target'];
				}
			}
		}

		foreach ( $image_map as $acf_key => $native_parts ) {
			if ( ! empty( $acf_data[ $acf_key ] ) ) {
				$attach_id = (int) $acf_data[ $acf_key ];
				if ( $attach_id > 0 ) {
					$new_attrs[ $native_parts['id'] ] = $attach_id;
					$src = wp_get_attachment_image_src( $attach_id, 'full' );
					if ( $src ) {
						$new_attrs[ $native_parts['url'] ] = $src[0];
					}
					$alt = get_post_meta( $attach_id, '_wp_attachment_image_alt', true );
					$new_attrs[ $native_parts['alt'] ] = $alt ?: '';
				}
			}
		}

		if ( ! empty( $meta_keys ) && ! empty( $acf_data ) ) {
			$meta_to_save = acf_data_keys_for_meta( $acf_data, $meta_keys );
			if ( isset( $acf_data['selected_companies'] ) && is_array( $acf_data['selected_companies'] ) ) {
				$meta_to_save['selected_companies'] = $acf_data['selected_companies'];
			}
			foreach ( $meta_to_save as $meta_key => $meta_value ) {
				migrate_log( sprintf(
					'  [META] post #%d → update_post_meta( %s, ... )',
					$post->ID,
					$meta_key
				) );
				if ( ! $dry_run ) {
					delete_post_meta( $post->ID, $meta_key );
					update_post_meta( $post->ID, $meta_key, $meta_value );
				}
			}
		}

		$new_comment = '<!-- wp:' . $native_name;
		if ( ! empty( $new_attrs ) ) {
			$new_comment .= ' ' . wp_json_encode( $new_attrs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
		}
		$new_comment .= ' /-->';

		migrate_log( sprintf( '  [BLOCK] %s → %s (open/close tag)', $acf_block_name, $native_name ) );

		$pos = strpos( $new_content, $full_comment );
		if ( $pos !== false ) {
			$new_content = substr_replace( $new_content, $new_comment, $pos, strlen( $full_comment ) );
			$post_changed = true;
			$total_blocks_converted++;
		}
	}

	// ── Write updated post_content ──────────────────────────────────────────

	if ( $post_changed ) {
		if ( ! $dry_run ) {
			$result = $wpdb->update(
				$wpdb->posts,
				[ 'post_content' => $new_content ],
				[ 'ID' => $post->ID ],
				[ '%s' ],
				[ '%d' ]
			);
			if ( $result !== false ) {
				wp_cache_delete( $post->ID, 'posts' );
				clean_post_cache( $post->ID );
				migrate_log( sprintf( '  [SAVED] Post #%d updated successfully.', $post->ID ) );
				$total_posts_updated++;
			} else {
				migrate_log( sprintf( '  [ERROR] Failed to update post #%d.', $post->ID ) );
			}
		} else {
			migrate_log( sprintf( '  [DRY-RUN] Would update post #%d.', $post->ID ) );
			$total_posts_updated++;
		}
	} else {
		migrate_log( '  No changes needed for this post.' );
	}

	migrate_log( '' );
}

// ─────────────────────────────────────────────────────────────────────────────
// Summary
// ─────────────────────────────────────────────────────────────────────────────

migrate_log( '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━' );
migrate_log( 'Migration complete.' );
migrate_log( sprintf( '  Blocks converted : %d', $total_blocks_converted ) );
migrate_log( sprintf( '  Posts updated    : %d', $total_posts_updated ) );

if ( ! empty( $unknown_blocks ) ) {
	migrate_log( '' );
	migrate_log( 'WARNING — The following ACF block names were found but have no mapping:' );
	foreach ( $unknown_blocks as $name ) {
		migrate_log( '  ' . $name );
	}
	migrate_log( 'Add entries to $block_map in the script to handle them.' );
}

if ( $dry_run ) {
	migrate_log( '' );
	migrate_log( 'This was a DRY-RUN. Re-run with "live" argument to apply changes:' );
	migrate_log( '  wp eval-file wp-content/themes/delcam/tools/migrate-acf-blocks.php live' );
}

migrate_log( '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━' );
