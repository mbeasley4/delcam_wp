<?php
/**
 * The header for our theme
 *
 * Displays <head> and everything up until the main content area.
 *
 * @package DelCam_Capital
 */

$eyebrow_message = get_option( 'delcam_eyebrow_message', '' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<style>.custom-logo-link img{height:44px;width:auto;display:block;}</style>
	<?php wp_head(); ?>
	<!-- Google Analytics -->
	<?php // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript -- GA snippet must be inline. ?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-5RKT81XXEH"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag() { dataLayer.push(arguments); }
	gtag('js', new Date());
	gtag('config', 'G-5RKT81XXEH');
	</script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'delcam' ); ?></a>

	<!-- TOP BAR -->
	<div class="site-topbar">
		<span>
			<?php if ( ! empty( $eyebrow_message ) ) : ?>
				<?php echo wp_kses_post( $eyebrow_message ); ?>
			<?php else : ?>
				PRIVATE EQUITY &nbsp;&middot;&nbsp; MANUFACTURING FOCUS &nbsp;&middot;&nbsp; UNITED STATES
			<?php endif; ?>
		</span>
	</div>

	<!-- NAV -->
	<nav id="masthead" class="site-nav sticky top-0 z-50 px-6 lg:px-12 py-3">
		<div class="max-w-7xl mx-auto flex items-center justify-between">

			<!-- Logo -->
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center">
					<img
						src="<?php echo esc_url( get_template_directory_uri() . '/images/dcc-logo.png' ); ?>"
						alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
						style="height:44px; width:auto; display:block;"
					>
				</a>
			<?php endif; ?>

			<!-- Desktop Nav + Mobile Toggle (right-aligned) -->
			<div class="flex items-center gap-6">

				<div class="hidden lg:block">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'items_wrap'     => '<ul id="%1$s" class="flex items-center gap-6 list-none m-0 p-0">%3$s</ul>',
							'item_spacing'   => 'discard',
							'fallback_cb'    => false,
						)
					);
					?>
				</div>

				<!-- Mobile menu toggle -->
				<button class="mobile-menu-toggle lg:hidden flex flex-col gap-1.5 p-2" aria-controls="mobile-menu" aria-expanded="false" aria-label="Toggle menu">
					<span class="hamburger-bar"></span>
					<span class="hamburger-bar"></span>
					<span class="hamburger-bar"></span>
				</button>

			</div>

		</div><!-- .max-w-7xl -->

		<!-- Mobile Menu -->
		<div id="mobile-menu" class="lg:hidden hidden mt-4 pt-4">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'mobile-menu-items',
					'container'      => false,
					'items_wrap'     => '<ul id="%1$s" class="flex flex-col gap-1 px-2 pb-4">%3$s</ul>',
					'fallback_cb'    => false,
				)
			);
			?>
		</div>

	</nav><!-- #masthead -->
