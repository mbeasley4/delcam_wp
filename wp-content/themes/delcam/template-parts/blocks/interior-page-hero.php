<?php
/**
 * Block: Interior Page Hero
 * Compact dark-navy hero for interior pages with eyebrow, headline, and optional subhead.
 *
 * ACF Fields:
 *   section_label (text)     — e.g. "// Strategy"
 *   headline      (text)     — page title
 *   subhead       (textarea) — optional supporting description
 *
 * @package DelCam_Capital
 */

$section_label = ! empty( get_field( 'section_label' ) ) ? get_field( 'section_label' ) : '';
$headline      = ! empty( get_field( 'headline' ) ) ? get_field( 'headline' ) : get_the_title();
$subhead       = ! empty( get_field( 'subhead' ) ) ? get_field( 'subhead' ) : '';
?>

<section class="min-h-[400px] section-dark relative overflow-hidden py-20 lg:py-28 px-6 lg:px-12 flex items-center">

	<!-- Background grid -->
	<div class="absolute inset-0 pointer-events-none grid-overlay"></div>

	<!-- Subtle blue ambient glow left -->
	<div class="absolute -left-24 top-1/2 -translate-y-1/2 w-96 h-96 rounded-full pointer-events-none"
		style="background:radial-gradient(circle, rgba(30,95,168,0.18) 0%, transparent 70%); filter:blur(60px);"></div>

	<!-- Gold accent glow top-right -->
	<div class="absolute top-0 right-0 w-72 h-72 pointer-events-none glow-gold-lg"></div>

	<div class="w-full max-w-7xl mx-auto relative z-10">

		<!-- Eyebrow label -->
		<?php if ( ! empty( $section_label ) ) : ?>
			<p class="section-label mb-2 fade-up d1"><?php echo esc_html( $section_label ); ?></p>
		<?php endif; ?>

		<!-- Headline -->
		<h1 class="heading-display-dark mb-6 fade-up d2"
			style="font-size:clamp(3rem,8vw,6.5rem);">
			<?php echo wp_kses_post( format_headline( $headline ) ); ?>
		</h1>

		<!-- Optional gold accent rule -->
		<div class="accent-line-gold mb-6 fade-up d3"></div>

		<!-- Optional subhead -->
		<?php if ( ! empty( $subhead ) ) : ?>
			<p class="fade-up d4" style="max-width:55ch; color:rgba(255,255,255,0.6); font-size:1.05rem; line-height:1.7;">
				<?php echo esc_html( $subhead ); ?>
			</p>
		<?php endif; ?>

	</div>
</section>
