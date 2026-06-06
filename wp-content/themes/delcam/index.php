<?php
/**
 * The main template file — Blog / Insights archive.
 *
 * ACF Options fields used:
 *   insights_headline (text)    — hero heading, bracket notation supported
 *   insights_content  (textarea)— optional subhead
 *
 * @package DelCam_Capital
 */

get_header();

$headline = get_option( 'delcam_insights_headline', 'INSIGHTS &[br]PERSPECTIVES' );
$subhead  = get_option( 'delcam_insights_subhead',  'Analysis, perspectives, and firm updates from the DelCam Capital team.' );
?>

<main id="primary" class="site-main">

	<!-- ── Hero ──────────────────────────────────────────────────────── -->
	<section class="section-dark relative overflow-hidden py-24 lg:py-32 px-6 lg:px-12" style="min-height:340px;">

		<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>

		<div class="absolute -left-24 top-1/2 -translate-y-1/2 w-96 h-96 rounded-full pointer-events-none"
			style="background:radial-gradient(circle,rgba(30,95,168,0.18) 0%,transparent 70%);filter:blur(60px);" aria-hidden="true"></div>

		<div class="absolute top-0 right-0 w-72 h-72 pointer-events-none glow-gold-lg" aria-hidden="true"></div>

		<div class="max-w-7xl mx-auto relative z-10">
			<p class="section-label mb-4 fade-up d1">// Insights &amp; Perspectives</p>
			<h1 class="heading-display-dark mb-6 fade-up d2" style="font-size:clamp(3rem,8vw,6.5rem);">
				<?php echo wp_kses_post( format_headline( $headline ) ); ?>
			</h1>
			<div class="accent-line-gold mb-6 fade-up d3"></div>
			<?php if ( ! empty( $subhead ) ) : ?>
				<div class="fade-up d4" style="max-width:55ch;color:rgba(255,255,255,0.6);font-size:1.05rem;line-height:1.7;">
					<?php echo $subhead; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<!-- ── Posts Grid ────────────────────────────────────────────────── -->
	<section class="bg-white py-20 px-6 lg:px-12">
		<div class="max-w-7xl mx-auto">

			<?php if ( have_posts() ) : ?>

				<div class="news-archive-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/content', 'post' ); ?>
					<?php endwhile; ?>
				</div>

				<!-- Pagination -->
				<nav class="news-pagination" aria-label="Posts pages">
					<?php
					echo wp_kses_post(
						paginate_links(
							array(
								'prev_text' => '&larr; Newer',
								'next_text' => 'Older &rarr;',
								'type'      => 'list',
							)
						)
					);
					?>
				</nav>

			<?php else : ?>

				<div class="text-center py-24">
					<p class="section-label mb-4">// No results</p>
					<p class="text-mid">No posts have been published yet. Check back soon.</p>
				</div>

			<?php endif; ?>

		</div>
	</section>

</main>

<?php get_footer(); ?>
