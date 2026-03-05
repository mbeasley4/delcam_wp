<?php
/**
 * The header for our theme
 *
 * Displays <head> and everything up until the main content area.
 *
 * @package DelCam_Capital
 */

$eyebrow_message = get_field( 'eyebrow_message', 'option' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
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
	<div class="site-topbar py-2 px-4">
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
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3">
				<!-- Logo mark -->
				<div style="position:relative; width:42px; height:42px; border-radius:9px; background:linear-gradient(145deg, var(--navy) 0%, var(--blue) 100%); display:flex; align-items:center; justify-content:center; box-shadow:0 4px 18px rgba(30,95,168,0.35), 0 0 0 1px rgba(30,95,168,0.25); flex-shrink:0;">
					<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="2" y="14" width="4" height="6" rx="1" fill="rgba(255,255,255,0.45)"/>
						<rect x="8" y="9" width="4" height="11" rx="1" fill="rgba(255,255,255,0.7)"/>
						<rect x="14" y="4" width="4" height="16" rx="1" fill="#E8B84B"/>
					</svg>
				</div>
				<!-- Wordmark -->
				<div style="line-height:1;">
					<div style="font-family:'Bebas Neue',cursive; font-size:1.65rem; letter-spacing:0.06em; line-height:1;">
						<span style="color:var(--gold);">DEL</span><span style="color:var(--navy);">CAM</span>
					</div>
					<div style="font-family:'DM Sans',sans-serif; font-size:0.6rem; font-weight:600; letter-spacing:0.22em; text-transform:uppercase; color:var(--mid); margin-top:-2px;">CAPITAL</div>
				</div>
			</a>

			<!-- Desktop Nav Links -->
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

			<!-- Right side CTAs -->
			<div class="flex items-center gap-4">
				<a href="/contact" class="hidden md:flex items-center gap-2 text-sm font-semibold" style="color:var(--navy);">
					<svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
					Contact Us
				</a>
				<a href="/investor-relations/" class="btn-gold text-xs px-5 py-2.5 rounded-md">Investor Relations</a>

				<!-- Mobile menu toggle -->
				<button class="mobile-menu-toggle lg:hidden flex flex-col gap-1.5 p-2" aria-controls="mobile-menu" aria-expanded="false">
					<span class="block w-6 h-0.5 bg-navy" style="background:var(--navy);"></span>
					<span class="block w-6 h-0.5 bg-navy" style="background:var(--navy);"></span>
					<span class="block w-6 h-0.5 bg-navy" style="background:var(--navy);"></span>
					<span class="screen-reader-text">Menu</span>
				</button>
			</div>

		</div><!-- .max-w-7xl -->

		<!-- Mobile Menu -->
		<div id="mobile-menu" class="lg:hidden hidden border-t mt-4 pt-4" style="border-color:var(--border);">
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
