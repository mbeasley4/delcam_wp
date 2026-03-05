<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package DelCam_Capital
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="section-dark relative overflow-hidden py-32 px-6 lg:px-12" style="min-height: 72vh; display: flex; align-items: center;">

		<!-- Background gradient -->
		<div class="absolute inset-0 callout-overlay"></div>

		<!-- Grid overlay -->
		<div class="absolute inset-0 pointer-events-none grid-overlay"></div>

		<!-- Ambient glow (gold, top-right) -->
		<div class="absolute top-0 right-0 w-96 h-96 pointer-events-none glow-gold-lg"></div>

		<!-- Ambient glow (blue, bottom-left) -->
		<div class="absolute bottom-0 left-0 w-72 h-72 pointer-events-none" style="background: radial-gradient(circle, rgba(30,95,168,0.18) 0%, transparent 70%);"></div>

		<div class="max-w-7xl mx-auto relative z-10 text-center w-full">

			<!-- 404 number -->
			<div class="font-display text-gold mb-2 leading-none" style="font-size: clamp(7rem, 20vw, 16rem); letter-spacing: 0.04em; opacity: 0.85;">
				404
			</div>

			<!-- Eyebrow label -->
			<p class="section-label mb-6">// PAGE NOT FOUND</p>

			<!-- Headline -->
			<h1 class="heading-display-xl mb-6" style="font-size: clamp(2rem, 5vw, 3.5rem);">
				THIS PAGE DOESN'T EXIST
			</h1>

			<!-- Supporting copy -->
			<p class="max-w-md mx-auto leading-relaxed mb-10 text-white/70">
				The page you're looking for may have moved, been removed, or never existed. Let's get you back on track.
			</p>

			<!-- CTAs -->
			<div class="flex flex-col sm:flex-row gap-4 justify-center">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-gold inline-block text-sm px-10 py-4 rounded-md">
					Return Home
				</a>
				<a href="/contact/" class="btn-ghost-white inline-block text-sm px-10 py-4 rounded-md">
					Contact Us
				</a>
			</div>

		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
