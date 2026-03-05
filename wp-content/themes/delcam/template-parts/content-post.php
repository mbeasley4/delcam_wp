<?php
/**
 * Template part for displaying a standard post card in the blog archive.
 *
 * @package DelCam_Capital
 */

// Category for this post.
$categories = get_the_category();
$first_cat  = ! empty( $categories ) ? $categories[0] : null;

// Thumbnail.
$has_thumb = has_post_thumbnail();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'news-card card rounded-xl overflow-hidden flex flex-col' ); ?>>

	<!-- Thumbnail -->
	<a href="<?php the_permalink(); ?>" class="news-card__thumb block relative overflow-hidden" tabindex="-1" aria-hidden="true">
		<?php if ( $has_thumb ) : ?>
			<?php the_post_thumbnail( 'large', array( 'class' => 'news-card__img', 'alt' => esc_attr( get_the_title() ) ) ); ?>
		<?php else : ?>
			<div class="news-card__thumb-placeholder">
				<svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.15)" stroke-width="1" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
			</div>
		<?php endif; ?>
	</a>

	<!-- Card body -->
	<div class="news-card__body flex flex-col flex-1 p-6">

		<!-- Meta: category + date -->
		<div class="flex flex-col items-start gap-3 mb-4">
			<?php if ( $first_cat ) : ?>
				<a href="<?php echo esc_url( get_category_link( $first_cat->term_id ) ); ?>"
					class="badge px-2.5 py-1 rounded text-xs no-underline"
					onclick="event.stopPropagation()">
					<?php echo esc_html( $first_cat->name ); ?>
				</a>
			<?php endif; ?>
			<time class="news-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
			</time>
		</div>

		<!-- Title -->
		<h2 class="heading-card news-card__title mb-3">
			<a href="<?php the_permalink(); ?>" class="no-underline hover:text-blue-600" style="color:var(--navy);transition:color 0.2s;">
				<?php the_title(); ?>
			</a>
		</h2>

		<!-- Excerpt -->
		<p class="text-sm leading-relaxed text-mid flex-1 mb-5">
			<?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?>
		</p>

		<!-- CTA -->
		<a href="<?php the_permalink(); ?>" class="card-link-mono self-start">
			Read More &rarr;
		</a>

	</div>

</article>
