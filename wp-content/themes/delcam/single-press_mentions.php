<?php
/**
 * Template for displaying a single News & Press post.
 *
 * ACF Fields (per press_mentions post):
 *   source_name   (text) — publication name (e.g. "Wall Street Journal")
 *   source_url    (url)  — link to original article (for "In the News" items)
 *   press_date    (date) — publication / release date
 *
 * @package DelCam_Capital
 */

get_header();

while ( have_posts() ) :
	the_post();
	$source_name = get_post_meta( get_the_ID(), 'source_name', true );
	$source_url  = get_post_meta( get_the_ID(), 'source_url',  true );
	$press_date  = get_post_meta( get_the_ID(), 'press_date',  true );
	$news_types  = get_the_terms( get_the_ID(), 'news_type' );
	$post_date   = ! empty( $press_date ) ? $press_date : get_the_date( 'F j, Y' );
endwhile;
?>

<main id="primary" class="site-main">

	<!-- ── Hero ─────────────────────────────────────────────────────── -->
	<section class="section-dark relative overflow-hidden py-20 lg:py-24 px-6 lg:px-12" style="min-height:360px;">

		<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
		<div class="absolute top-0 right-0 w-72 h-72 pointer-events-none glow-gold-lg" aria-hidden="true"></div>

		<div class="w-full max-w-7xl mx-auto relative z-10">

			<a href="/press-releases/" class="inline-flex items-center gap-2 mb-8 fade-up d1"
				style="font-family:'JetBrains Mono',monospace; font-size:0.7rem; letter-spacing:0.12em; text-transform:uppercase; color:rgba(255,255,255,0.45); text-decoration:none; transition:color 0.2s;"
				onmouseover="this.style.color='rgba(200,146,42,0.9)'" onmouseout="this.style.color='rgba(255,255,255,0.45)'">
				&larr; Press Releases
			</a>

			<!-- Type badge -->
			<?php if ( ! empty( $news_types ) && ! is_wp_error( $news_types ) ) : ?>
			<div class="flex flex-wrap gap-2 mb-4 fade-up d2">
				<?php foreach ( $news_types as $news_type ) : ?>
				<span style="font-family:'JetBrains Mono',monospace; font-size:0.65rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--gold-light); border:1px solid rgba(200,146,42,0.3); padding:0.2rem 0.75rem; border-radius:99px; background:rgba(200,146,42,0.08);">
					<?php echo esc_html( $news_type->name ); ?>
				</span>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<h1 class="heading-display-dark fade-up d3" style="font-size:clamp(2rem,5vw,3.5rem);">
				<?php the_title(); ?>
			</h1>
			<div class="accent-line-gold my-5 fade-up d4"></div>

			<!-- Meta row -->
			<div class="flex flex-wrap gap-6 fade-up d5">
				<span style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.08em; color:rgba(255,255,255,0.45);">
					<?php echo esc_html( $post_date ); ?>
				</span>
				<?php if ( ! empty( $source_name ) ) : ?>
				<span style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.08em; color:rgba(255,255,255,0.45);">
					<?php echo esc_html( $source_name ); ?>
				</span>
				<?php endif; ?>
			</div>

		</div>
	</section>

	<!-- ── Article body ─────────────────────────────────────────────── -->
	<section class="bg-white py-20 px-6 lg:px-12">
		<div class="max-w-4xl mx-auto">

			<?php if ( ! empty( $source_url ) ) : ?>
			<div class="mb-8 p-5 rounded-xl flex items-center justify-between gap-4"
				style="background:var(--light); border:1px solid var(--border);">
				<span style="font-size:0.9rem; color:var(--mid);">
					<?php echo ! empty( $source_name ) ? 'Originally published by <strong>' . esc_html( $source_name ) . '</strong>' : 'View original article'; ?>
				</span>
				<a href="<?php echo esc_url( $source_url ); ?>" target="_blank" rel="noopener"
					class="btn-primary rounded-md py-2 px-5 flex-shrink-0" style="font-size:0.8rem;">
					Read Original &rarr;
				</a>
			</div>
			<?php endif; ?>

			<!-- Featured image -->
			<?php if ( has_post_thumbnail() ) : ?>
			<div class="mb-10 rounded-xl overflow-hidden" style="max-height:480px;">
				<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover', 'alt' => esc_attr( get_the_title() ) ) ); ?>
			</div>
			<?php endif; ?>

			<!-- Post content -->
			<div class="prose-content" style="padding:0; max-width:none;">
				<?php
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
				?>
			</div>

		</div>
	</section>

	<!-- ── Back to news CTA ────────────────────────────────────────── -->
	<section class="py-16 px-6" style="background:var(--light); border-top:1px solid var(--border);">
		<div class="max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6">
			<div>
				<p class="section-label mb-1">// Press Releases</p>
				<p style="font-size:1rem; color:var(--mid);">Read more updates from DelCam Capital.</p>
			</div>
			<a href="/press-releases/" class="btn-outline rounded-md py-3 px-8">
				All Press Releases &rarr;
			</a>
		</div>
	</section>

</main>

<?php get_footer(); ?>
