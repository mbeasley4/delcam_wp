<?php
/**
 * Template part for displaying a News & Press card in the archive loop.
 *
 * @package DelCam_Capital
 */

// Category terms for this post.
$terms      = get_the_terms( get_the_ID(), 'news_category' );
$first_term = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0] : null;

// Thumbnail — prefer the featured image, fall back to a branded placeholder.
$has_thumb = has_post_thumbnail();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'news-card card rounded-xl overflow-hidden flex flex-col' ); ?>>
	<!-- Card body -->
	<div class="news-card__body flex flex-col flex-1 p-6">

		<!-- Meta: category + date -->
		<div class="flex flex-col items-start gap-3 mb-4">
			<?php if ( $first_term ) : ?>
				<a href="<?php echo esc_url( get_term_link( $first_term ) ); ?>"
					class="badge px-2.5 py-1 rounded text-xs no-underline"
					onclick="event.stopPropagation()">
					<?php echo esc_html( $first_term->name ); ?>
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
			Read Article &rarr;
		</a>

	</div>

</article>
