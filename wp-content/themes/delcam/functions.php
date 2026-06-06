<?php
/**
 * DelCam Capital functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DelCam_Capital
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.8' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function delcam_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on DelCam Capital, use a find and replace
		* to change 'delcam' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'delcam', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'delcam' ),
			'menu-2' => esc_html__( 'Footer', 'delcam' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'delcam_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Load theme stylesheet and fonts in the block editor so all blocks match the front-end.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&family=JetBrains+Mono:wght@400;500&display=block' );
	add_editor_style( 'dist/delcam.css' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'delcam_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function delcam_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'delcam_content_width', 640 );
}
add_action( 'after_setup_theme', 'delcam_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function delcam_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'delcam' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'delcam' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'delcam_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function delcam_scripts() {
	// Google Fonts: Bebas Neue, DM Sans, JetBrains Mono.
	// font-display=swap: show fallback text immediately; swap in web font when ready.
	wp_enqueue_style(
		'delcam-google-fonts',
		'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;700&family=JetBrains+Mono:wght@400;500&display=swap',
		array(),
		null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- External Google Fonts URL; version not applicable.
	);

	// Compiled Tailwind CSS (dist/delcam.css, built via npm run build:css).
	// delcam-main intentionally depends on delcam-google-fonts so the link
	// element order is preserved even after the async-load filter below.
	wp_enqueue_style(
		'delcam-main',
		get_template_directory_uri() . '/dist/delcam.css',
		array(),
		_S_VERSION
	);

	wp_enqueue_script( 'delcam-site', get_template_directory_uri() . '/js/site.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'delcam_scripts' );

// Load Google Fonts asynchronously so it doesn't block initial render.
// The preload+onload pattern is the standard non-JS-framework approach;
// the <noscript> fallback covers browsers with JS disabled.
add_filter( 'style_loader_tag', function ( string $html, string $handle ): string {
	if ( $handle !== 'delcam-google-fonts' ) {
		return $html;
	}
	$preload = str_replace( "rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $html );
	return $preload . '<noscript>' . $html . '</noscript>';
}, 10, 2 );

// The custom logo (uploaded via Customizer) is 1266×371 but displayed at 150×44.
// Override the `sizes` hint so the browser picks the smallest srcset candidate
// instead of downloading the full original (~42 KB wasted).
add_filter( 'wp_get_attachment_image_attributes', function ( array $attrs ): array {
	if ( isset( $attrs['class'] ) && strpos( $attrs['class'], 'custom-logo' ) !== false ) {
		$attrs['sizes'] = '150px';
	}
	return $attrs;
} );

/**
 * Make the block editor canvas full-width so DelCam section blocks render
 * at their true width rather than being constrained by the content column.
 */
function delcam_editor_fullwidth_css() {
	wp_add_inline_style(
		'wp-edit-blocks',
		'.is-root-container.block-editor-block-list__layout {
			max-width: none !important;
			padding-left: 0 !important;
			padding-right: 0 !important;
		}
		.is-root-container > .wp-block {
			max-width: none !important;
			margin-left: 0 !important;
			margin-right: 0 !important;
		}
		.editor-styles-wrapper {
			padding: 0 !important;
		}'
	);
}
add_action( 'enqueue_block_editor_assets', 'delcam_editor_fullwidth_css' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



/**
 * Register the "delcam" block category so both ACF and native blocks can use it.
 */
add_filter( 'block_categories_all', function ( $categories ) {
	return array_merge(
		[ [ 'slug' => 'delcam', 'title' => 'DelCam Capital', 'icon' => null ] ],
		$categories
	);
} );

/**
 * Register native Gutenberg blocks (no ACF required).
 */
add_action( 'init', function () {
	register_block_type( get_template_directory() . '/blocks/large-text-callout' );
	register_block_type( get_template_directory() . '/blocks/basic' );
	register_block_type( get_template_directory() . '/blocks/content-image' );
	register_block_type( get_template_directory() . '/blocks/team-members' );
	register_block_type( get_template_directory() . '/blocks/firm-values' );
	register_block_type( get_template_directory() . '/blocks/funds-overview' );
	register_block_type( get_template_directory() . '/blocks/content-3-blocks' );
	register_block_type( get_template_directory() . '/blocks/company-portfolio' );
	register_block_type( get_template_directory() . '/blocks/company-portfolio-selected' );
	register_block_type( get_template_directory() . '/blocks/interior-page-hero' );
	register_block_type( get_template_directory() . '/blocks/prose-content' );
	register_block_type( get_template_directory() . '/blocks/highlighted-boxes' );
	register_block_type( get_template_directory() . '/blocks/sectors' );
	register_block_type( get_template_directory() . '/blocks/vertical-blocks' );
	register_block_type( get_template_directory() . '/blocks/homepage-hero' );
	register_block_type( get_template_directory() . '/blocks/portfolio-marquee' );
	register_block_type( get_template_directory() . '/blocks/investment-strategy' );
	register_block_type( get_template_directory() . '/blocks/news-feed' );
} );

/**
 * Register post meta for CPTs so fields are available via REST API and get_post_meta().
 */
add_action( 'init', function () {
	// Team Member meta.
	$team_meta = array( 'job_title', 'email_address', 'phone_number', 'linkedin_url' );
	foreach ( $team_meta as $key ) {
		register_post_meta(
			'team_member',
			$key,
			array(
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => 'string',
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}

	// Portfolio Company meta.
	$portfolio_meta = array( 'company_url', 'company_founded', 'company_location', 'company_employees', 'company_overview' );
	foreach ( $portfolio_meta as $key ) {
		register_post_meta(
			'portfolio',
			$key,
			array(
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => 'string',
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}

	// Card image (attachment ID) — optional override photo; falls back to featured image.
	register_post_meta(
		'portfolio',
		'company_card_image',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'integer',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);

	// Logo (attachment ID) — shown in cards and on the single company page.
	register_post_meta(
		'portfolio',
		'company_logo',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'integer',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);

	// Press Mentions meta.
	$press_meta = array( 'source_name', 'source_url', 'press_date' );
	foreach ( $press_meta as $key ) {
		register_post_meta(
			'press_mentions',
			$key,
			array(
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => 'string',
				'auth_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}
} );

/**
 * Theme settings admin page (replaces ACF options page).
 * Manages: delcam_eyebrow_message, delcam_footer_address.
 */
add_action( 'admin_menu', function () {
	add_theme_page(
		'DelCam Theme Settings',
		'Theme Settings',
		'manage_options',
		'delcam-settings',
		'delcam_render_settings_page'
	);
} );

add_action( 'admin_init', function () {
	register_setting( 'delcam_settings_group', 'delcam_eyebrow_message',   array( 'sanitize_callback' => 'wp_kses_post' ) );
	register_setting( 'delcam_settings_group', 'delcam_footer_address',    array( 'sanitize_callback' => 'wp_kses_post' ) );
	register_setting( 'delcam_settings_group', 'delcam_news_headline',     array( 'sanitize_callback' => 'sanitize_text_field' ) );
	register_setting( 'delcam_settings_group', 'delcam_news_subhead',      array( 'sanitize_callback' => 'sanitize_textarea_field' ) );
	register_setting( 'delcam_settings_group', 'delcam_insights_headline', array( 'sanitize_callback' => 'sanitize_text_field' ) );
	register_setting( 'delcam_settings_group', 'delcam_insights_subhead',  array( 'sanitize_callback' => 'sanitize_textarea_field' ) );
} );

/**
 * Portfolio admin meta boxes.
 *
 * Company Details (normal, high) — text fields for all company meta.
 * Card Image      (side,   low)  — media uploader for the card cover photo.
 * Both share a single nonce and save hook.
 */
add_action( 'add_meta_boxes', function () {
	add_meta_box(
		'delcam_company_details',
		'Company Details',
		'delcam_company_details_meta_box',
		'portfolio',
		'normal',
		'high'
	);
	add_meta_box(
		'delcam_company_media',
		'Company Media',
		'delcam_company_media_meta_box',
		'portfolio',
		'side',
		'low'
	);
	// Remove the native Excerpt box — Card Description is in Company Details.
	remove_meta_box( 'postexcerpt', 'portfolio', 'normal' );
} );

function delcam_company_details_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'delcam_portfolio_save', 'delcam_portfolio_nonce' );

	$url       = get_post_meta( $post->ID, 'company_url',       true );
	$founded   = get_post_meta( $post->ID, 'company_founded',   true );
	$location  = get_post_meta( $post->ID, 'company_location',  true );
	$employees = get_post_meta( $post->ID, 'company_employees', true );
	$overview  = get_post_meta( $post->ID, 'company_overview',  true );
	$excerpt   = $post->post_excerpt;
	?>
	<style>
	.delcam-fields { display:grid; grid-template-columns:1fr 1fr; gap:16px 24px; padding:4px 0 8px; }
	.delcam-fields .full { grid-column:1/-1; }
	.delcam-fields label { display:block; font-weight:600; font-size:12px; text-transform:uppercase; letter-spacing:.04em; color:#1d2327; margin-bottom:4px; }
	.delcam-fields input[type=text],
	.delcam-fields input[type=url],
	.delcam-fields textarea { width:100%; box-sizing:border-box; }
	.delcam-fields .field-note { font-size:11px; color:#646970; margin-top:3px; }
	.delcam-fields .section-rule { grid-column:1/-1; border:none; border-top:1px solid #dcdcde; margin:4px 0; }
	</style>
	<div class="delcam-fields">

		<div>
			<label for="company_url">Website URL</label>
			<input type="url" id="company_url" name="company_url"
				   value="<?php echo esc_attr( $url ); ?>"
				   placeholder="https://example.com">
		</div>

		<div>
			<label for="company_founded">Acquired Year</label>
			<input type="text" id="company_founded" name="company_founded"
				   value="<?php echo esc_attr( $founded ); ?>"
				   placeholder="e.g. 2021">
		</div>

		<div>
			<label for="company_location">Location</label>
			<input type="text" id="company_location" name="company_location"
				   value="<?php echo esc_attr( $location ); ?>"
				   placeholder="City, State">
		</div>

		<div>
			<label for="company_employees">Employees</label>
			<input type="text" id="company_employees" name="company_employees"
				   value="<?php echo esc_attr( $employees ); ?>"
				   placeholder="e.g. 150–200">
		</div>

		<hr class="section-rule">

		<div class="full">
			<label for="company_excerpt">Card Description</label>
			<textarea id="company_excerpt" name="excerpt" rows="3"
					  placeholder="Short description shown on portfolio cards (2–3 sentences)."><?php echo esc_textarea( $excerpt ); ?></textarea>
			<p class="field-note">Shown on portfolio card previews and search results.</p>
		</div>

		<div class="full">
			<label for="company_overview">Full Overview</label>
			<textarea id="company_overview" name="company_overview" rows="6"
					  placeholder="Longer description for the company's individual page."><?php echo esc_textarea( $overview ); ?></textarea>
			<p class="field-note">Displayed on the individual company page. Leave blank to use the Card Description above.</p>
		</div>

	</div>
	<?php
}

function delcam_company_media_meta_box( WP_Post $post ): void {
	$card_image_id = (int) get_post_meta( $post->ID, 'company_card_image', true );
	$logo_id       = (int) get_post_meta( $post->ID, 'company_logo',       true );
	?>
	<style>
	.delcam-media-section { margin-bottom:16px; }
	.delcam-media-section:last-child { margin-bottom:0; }
	.delcam-media-section h4 { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.05em; color:#1d2327; margin:0 0 8px; }
	.delcam-media-section .delcam-rule { border:none; border-top:1px solid #dcdcde; margin:16px 0; }
	</style>

	<?php
	// Helper — renders a single image-upload control.
	$render_uploader = function ( string $id_prefix, string $meta_key, string $title, string $description, int $current_id ) use ( $post ): void {
		$preview_url = $current_id ? wp_get_attachment_image_url( $current_id, 'medium' ) : '';
		?>
		<div class="delcam-media-section">
			<h4><?php echo esc_html( $title ); ?></h4>
			<img id="<?php echo esc_attr( $id_prefix ); ?>-preview"
				 src="<?php echo esc_url( $preview_url ); ?>"
				 style="width:100%; height:auto; border-radius:4px; margin-bottom:8px; display:<?php echo $current_id ? 'block' : 'none'; ?>;">
			<input type="hidden" name="<?php echo esc_attr( $meta_key ); ?>"
				   id="<?php echo esc_attr( $id_prefix ); ?>-id"
				   value="<?php echo esc_attr( $current_id ?: '' ); ?>">
			<button type="button" class="delcam-upload button button-secondary"
					data-prefix="<?php echo esc_attr( $id_prefix ); ?>"
					data-title="<?php echo esc_attr( $title ); ?>"
					style="width:100%; margin-bottom:4px;">
				<?php echo $current_id ? 'Change ' . esc_html( $title ) : 'Upload ' . esc_html( $title ); ?>
			</button>
			<button type="button" class="delcam-remove button"
					data-prefix="<?php echo esc_attr( $id_prefix ); ?>"
					style="width:100%; color:#b32d2e; display:<?php echo $current_id ? '' : 'none'; ?>;">
				Remove
			</button>
			<p class="description" style="font-size:11px; margin-top:6px;"><?php echo esc_html( $description ); ?></p>
		</div>
		<?php
	};

	$render_uploader( 'delcam-card-image', 'company_card_image', 'Card Photo',    'Full-bleed photo at the top of portfolio cards. Falls back to Featured Image.', $card_image_id );
	echo '<hr class="delcam-rule">';
	$render_uploader( 'delcam-logo',       'company_logo',       'Company Logo',  'Logo shown on cards and the company page. Upload on a transparent or white background.', $logo_id );
	?>
	<script>
	( function() {
		var frames = {};

		document.querySelectorAll( '.delcam-upload' ).forEach( function( btn ) {
			btn.addEventListener( 'click', function() {
				var prefix = btn.dataset.prefix;
				var title  = btn.dataset.title;
				if ( ! frames[ prefix ] ) {
					frames[ prefix ] = wp.media( { title: 'Select ' + title, button: { text: 'Use this image' }, multiple: false } );
					frames[ prefix ].on( 'select', function() {
						var att      = frames[ prefix ].state().get( 'selection' ).first().toJSON();
						var preview  = document.getElementById( prefix + '-preview' );
						var idInput  = document.getElementById( prefix + '-id' );
						var removeBtn = document.querySelector( '.delcam-remove[data-prefix="' + prefix + '"]' );
						idInput.value          = att.id;
						preview.src            = att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url;
						preview.style.display  = 'block';
						btn.textContent        = 'Change ' + title;
						removeBtn.style.display = '';
					} );
				}
				frames[ prefix ].open();
			} );
		} );

		document.querySelectorAll( '.delcam-remove' ).forEach( function( btn ) {
			btn.addEventListener( 'click', function() {
				var prefix   = btn.dataset.prefix;
				var preview  = document.getElementById( prefix + '-preview' );
				var idInput  = document.getElementById( prefix + '-id' );
				var uploadBtn = document.querySelector( '.delcam-upload[data-prefix="' + prefix + '"]' );
				idInput.value           = '';
				preview.src             = '';
				preview.style.display   = 'none';
				uploadBtn.textContent   = 'Upload ' + uploadBtn.dataset.title;
				btn.style.display       = 'none';
			} );
		} );
	} )();
	</script>
	<?php
}

add_action( 'save_post_portfolio', function ( int $post_id ): void {
	if (
		! isset( $_POST['delcam_portfolio_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['delcam_portfolio_nonce'] ) ), 'delcam_portfolio_save' ) ||
		( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
		! current_user_can( 'edit_post', $post_id )
	) {
		return;
	}

	// Text fields.
	$string_fields = array( 'company_url', 'company_founded', 'company_location', 'company_employees', 'company_overview' );
	foreach ( $string_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			$value = sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) );
			if ( $value !== '' ) {
				update_post_meta( $post_id, $key, $value );
			} else {
				delete_post_meta( $post_id, $key );
			}
		}
	}

	// Image fields (attachment IDs).
	foreach ( array( 'company_card_image', 'company_logo' ) as $img_key ) {
		if ( isset( $_POST[ $img_key ] ) ) {
			$attachment_id = absint( $_POST[ $img_key ] );
			if ( $attachment_id ) {
				update_post_meta( $post_id, $img_key, $attachment_id );
			} else {
				delete_post_meta( $post_id, $img_key );
			}
		}
	}
} );

function delcam_render_settings_page() {
	?>
	<div class="wrap">
		<h1>DelCam Theme Settings</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'delcam_settings_group' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="delcam_eyebrow_message">Eyebrow Message</label></th>
					<td>
						<input type="text" id="delcam_eyebrow_message" name="delcam_eyebrow_message"
							value="<?php echo esc_attr( get_option( 'delcam_eyebrow_message', '' ) ); ?>"
							class="regular-text">
						<p class="description">Displayed in the top bar. Leave blank to show the default tagline.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="delcam_footer_address">Footer Address</label></th>
					<td>
						<textarea id="delcam_footer_address" name="delcam_footer_address" rows="4" class="regular-text"><?php echo esc_textarea( get_option( 'delcam_footer_address', '' ) ); ?></textarea>
						<p class="description">Address shown in the footer. HTML allowed (e.g. line breaks).</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="delcam_news_headline">News Archive Headline</label></th>
					<td>
						<input type="text" id="delcam_news_headline" name="delcam_news_headline"
							value="<?php echo esc_attr( get_option( 'delcam_news_headline', 'PRESS[br]RELEASES' ) ); ?>"
							class="regular-text">
						<p class="description">Bracket notation supported, e.g. <code>&amp;[br]</code> for a line break with gold styling.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="delcam_news_subhead">News Archive Subhead</label></th>
					<td>
						<textarea id="delcam_news_subhead" name="delcam_news_subhead" rows="2" class="regular-text"><?php echo esc_textarea( get_option( 'delcam_news_subhead', '' ) ); ?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="delcam_insights_headline">Insights Archive Headline</label></th>
					<td>
						<input type="text" id="delcam_insights_headline" name="delcam_insights_headline"
							value="<?php echo esc_attr( get_option( 'delcam_insights_headline', 'INSIGHTS &[br]PERSPECTIVES' ) ); ?>"
							class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="delcam_insights_subhead">Insights Archive Subhead</label></th>
					<td>
						<textarea id="delcam_insights_subhead" name="delcam_insights_subhead" rows="2" class="regular-text"><?php echo esc_textarea( get_option( 'delcam_insights_subhead', '' ) ); ?></textarea>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}


/**
 * Format headline text by converting bracket notation to HTML tags.
 *
 * @param string $headline_text The raw headline text with bracket notation.
 * @return string Formatted headline with HTML span/em tags.
 */
function format_headline( $headline_text ) {
	$headline_text = str_replace( '[', '<', str_replace( ']', '>', $headline_text ) );
	return $headline_text;
}


/**
 * Register custom post types: Team Member, Portfolio, and DelCam News.
 * Also registers associated taxonomies for each post type.
 */
function register_team_member_cpt() {
	// Register the Team Member CPT.
	$labels = array(
		'name'               => 'Team Members',
		'singular_name'      => 'Team Member',
		'menu_name'          => 'Team',
		'name_admin_bar'     => 'Team Member',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Team Member',
		'new_item'           => 'New Team Member',
		'edit_item'          => 'Edit Team Member',
		'view_item'          => 'View Team Member',
		'all_items'          => 'All Team Members',
		'search_items'       => 'Search Team Members',
		'not_found'          => 'No team members found',
		'not_found_in_trash' => 'No team members found in Trash',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'has_archive'        => false, // No archive page.
		'rewrite'            => false, // No pretty URLs.
		'publicly_queryable' => false, // Prevents individual pages.
		'show_ui'            => true, // Still show in admin.
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'          => 'dashicons-groups',
	);

	register_post_type( 'team_member', $args );

	// Register the custom taxonomy.
	$taxonomy_labels = array(
		'name'              => 'Team Categories',
		'singular_name'     => 'Team Category',
		'search_items'      => 'Search Team Categories',
		'all_items'         => 'All Team Categories',
		'parent_item'       => 'Parent Category',
		'parent_item_colon' => 'Parent Category:',
		'edit_item'         => 'Edit Category',
		'update_item'       => 'Update Category',
		'add_new_item'      => 'Add New Category',
		'new_item_name'     => 'New Category Name',
		'menu_name'         => 'Team Categories',
	);

	$taxonomy_args = array(
		'hierarchical'      => true,
		'labels'            => $taxonomy_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'team-category' ),
		'show_in_rest'      => true,
	);

	register_taxonomy( 'team_category', array( 'team_member' ), $taxonomy_args );

	// Register Portfolio CPT (public — individual company pages at /portfolio/{slug}).
	$labels = array(
		'name'               => 'Portfolio Companies',
		'singular_name'      => 'Portfolio Company',
		'menu_name'          => 'Portfolio',
		'name_admin_bar'     => 'Portfolio Company',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Company',
		'new_item'           => 'New Company',
		'edit_item'          => 'Edit Company',
		'view_item'          => 'View Company',
		'all_items'          => 'All Companies',
		'search_items'       => 'Search Companies',
		'not_found'          => 'No companies found',
		'not_found_in_trash' => 'No companies found in Trash',
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'has_archive'         => false,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'rewrite'             => array( 'slug' => 'portfolio' ),
		'menu_icon'           => 'dashicons-portfolio',
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	);

	register_post_type( 'portfolio', $args );

	// Register taxonomy for Portfolio.
	$tax_labels = array(
		'name'              => 'Portfolio Categories',
		'singular_name'     => 'Portfolio Category',
		'search_items'      => 'Search Categories',
		'all_items'         => 'All Categories',
		'edit_item'         => 'Edit Category',
		'update_item'       => 'Update Category',
		'add_new_item'      => 'Add New Category',
		'new_item_name'     => 'New Category Name',
		'menu_name'         => 'Categories',
	);

	$tax_args = array(
		'hierarchical'      => true,
		'labels'            => $tax_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'portfolio-category' ),
		'show_in_rest'      => true,
	);

	register_taxonomy( 'portfolio_category', array( 'portfolio' ), $tax_args );

	// Register Press Mentions CPT (news posts at /news/{slug}).
	$news_labels = array(
		'name'               => 'News & Press',
		'singular_name'      => 'News Item',
		'menu_name'          => 'News & Press',
		'add_new_item'       => 'Add News Item',
		'edit_item'          => 'Edit News Item',
		'view_item'          => 'View News Item',
		'all_items'          => 'All News Items',
		'search_items'       => 'Search News',
		'not_found'          => 'No news items found',
		'not_found_in_trash' => 'No news items found in Trash',
	);

	$news_args = array(
		'labels'              => $news_labels,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'has_archive'         => 'press-releases',
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'rewrite'             => array( 'slug' => 'press-releases' ),
		'menu_icon'           => 'dashicons-megaphone',
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'author' ),
	);

	register_post_type( 'press_mentions', $news_args );

	// Taxonomy for news type (Press Release, In the News, White Paper).
	$news_tax_args = array(
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'news-type' ),
		'show_in_rest'      => true,
		'labels'            => array(
			'name'          => 'News Types',
			'singular_name' => 'News Type',
			'menu_name'     => 'News Types',
			'add_new_item'  => 'Add New Type',
			'edit_item'     => 'Edit Type',
			'all_items'     => 'All Types',
		),
	);

	register_taxonomy( 'news_type', array( 'press_mentions' ), $news_tax_args );
}
add_action( 'init', 'register_team_member_cpt' );


/**
 * Return a color-scheme token array for block render.php files.
 *
 * Usage in render.php:
 *   $s = delcam_scheme( (bool) ( $attributes['darkBackground'] ?? false ) );
 *   echo '<section style="background:' . $s['bg'] . ';">';
 *
 * @param bool $dark True for navy/dark scheme, false for light/white scheme.
 * @return array<string, string>
 */
function delcam_scheme( bool $dark ): array {
	if ( $dark ) {
		return array(
			'bg'            => 'var(--navy)',
			'section_class' => 'section-dark',
			'heading'       => '#fff',
			'heading_class' => 'heading-display-dark',
			'text'          => 'rgba(255,255,255,0.65)',
			'text_muted'    => 'rgba(255,255,255,0.4)',
			'label'         => 'var(--gold-light)',
			'label_border'  => 'rgba(200,146,42,0.4)',
			'card_bg'       => 'rgba(255,255,255,0.04)',
			'card_border'   => 'rgba(200,146,42,0.2)',
			'card_hover'    => 'rgba(255,255,255,0.07)',
			'card_class'    => 'card-dark',
			'pill_bg'       => 'rgba(200,146,42,0.12)',
			'pill_text'     => 'var(--gold-light)',
			'pill_border'   => 'rgba(200,146,42,0.3)',
			'btn_primary'   => 'btn-gold',
			'btn_secondary' => 'btn-ghost-white',
			'grid_overlay'  => true,
			'glow'          => true,
		);
	}
	return array(
		'bg'            => '#fff',
		'section_class' => 'section-light',
		'heading'       => 'var(--navy)',
		'heading_class' => 'heading-display',
		'text'          => 'rgba(11,37,69,0.75)',
		'text_muted'    => 'var(--mid)',
		'label'         => 'var(--blue)',
		'label_border'  => 'rgba(30,95,168,0.3)',
		'card_bg'       => '#fff',
		'card_border'   => 'rgba(30,95,168,0.1)',
		'card_hover'    => 'var(--light)',
		'card_class'    => 'card',
		'pill_bg'       => 'var(--light)',
		'pill_text'     => 'var(--navy)',
		'pill_border'   => 'rgba(30,95,168,0.2)',
		'btn_primary'   => 'btn-primary',
		'btn_secondary' => 'btn-ghost',
		'grid_overlay'  => false,
		'glow'          => false,
	);
}


/**
 * Get a word-limited excerpt for the current post.
 *
 * @param int $limit Maximum number of words to include.
 * @return string Trimmed excerpt string.
 */
function excerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );

	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( ' ', $excerpt ) . '...';
	} else {
		$excerpt = implode( ' ', $excerpt );
	}

	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );

	return $excerpt;
}

/**
 * Get a word-limited version of the current post content.
 *
 * @param int $limit Maximum number of words to include.
 * @return string Trimmed and filtered content string.
 */
function content( $limit ) {
	$content = explode( ' ', get_the_content(), $limit );

	if ( count( $content ) >= $limit ) {
		array_pop( $content );
		$content = implode( ' ', $content ) . '...';
	} else {
		$content = implode( ' ', $content );
	}

	$content = preg_replace( '/\[.+\]/', '', $content );
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );

	return $content;
}



add_filter(
	'render_block',
	function ( $block_content, $block ) {
		if ( is_admin() || wp_is_json_request() ) {
			return $block_content; // Don't affect the editor or REST.
		}
		if ( empty( $block_content ) || empty( $block['blockName'] ) ) {
			return $block_content;
		}

		$targets = array(
			'core/paragraph',
			'core/heading',
			'core/separator',
			'core/list',
			'core/accordion',
		);
		if ( $block['blockName'] === 'core/paragraph' ) {
			// Use regular expression to extract the <p> tag content
			// and return just the <p> tag, effectively removing any surrounding div.
			if ( preg_match( '/<p\b[^>]*>(.*?)<\/p>/is', $block_content, $matches ) ) {
				return $matches[0];
			}
		}

		if ( in_array( $block['blockName'], $targets, true ) ) {
			// Avoid double-wrapping if something else already added this class.
			if ( preg_match( '/class="[^"]*\bmy-block-wrap\b/', $block_content ) ) {
				return $block_content;
			}

			$block_slug = str_replace( '/', '-', $block['blockName'] ); // e.g. core-heading.
			$classes    = 'container wrap-' . $block_slug;

			return '<div class="' . esc_attr( $classes ) . '">' . $block_content . '</div>';
		}

		return $block_content;
	},
	10,
	2
);


function remove_empty_p( $content ) {
    $content = force_balance_tags( $content );
    $content = preg_replace( '#<p>\\s*(<br\\s*/*>)?\\s*</p>#i', '', $content );
    $content = preg_replace( '~\\s?<p>(\\s|&nbsp;)+</p>\\s?~', '', $content );
    return $content;
}
add_filter( 'the_content', 'remove_empty_p', 20 );

// Force press_mentions archive to always order by most recent first,
// overriding any drag-and-drop ordering from the Post Types Order plugin.
add_action( 'pre_get_posts', function ( WP_Query $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive( 'press_mentions' ) ) {
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'DESC' );
		$query->set( 'ignore_custom_sort', true );
	}
}, 20 );
