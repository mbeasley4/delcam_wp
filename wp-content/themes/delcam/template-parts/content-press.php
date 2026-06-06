<?php
/**
 * Template part for displaying a Press Release card in the archive loop.
 *
 * @package DelCam_Capital
 */

$source_name = get_post_meta( get_the_ID(), 'source_name', true );
$source_url  = get_post_meta( get_the_ID(), 'source_url',  true );
$press_date  = get_post_meta( get_the_ID(), 'press_date',  true );
$news_types  = get_the_terms( get_the_ID(), 'news_type' );
$first_type  = ( ! empty( $news_types ) && ! is_wp_error( $news_types ) ) ? $news_types[0] : null;
$post_date   = ! empty( $press_date ) ? $press_date : get_the_date( 'M j, Y' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'news-card card rounded-xl overflow-hidden flex flex-col' ); ?>>
	<div class="news-card__body flex flex-col flex-1 p-6">

		<!-- Meta: type badge + date -->
		<div class="flex flex-wrap items-center gap-3 mb-4">
			<?php if ( $first_type ) : ?>
				<span style="font-family:'JetBrains Mono',monospace; font-size:0.65rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--gold-light); border:1px solid rgba(200,146,42,0.3); padding:0.2rem 0.75rem; border-radius:99px; background:rgba(200,146,42,0.08);">
					<?php echo esc_html( $first_type->name ); ?>
				</span>
			<?php endif; ?>
			<time class="news-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( $post_date ); ?>
			</time>
		</div>

		<!-- Title -->
		<h2 class="heading-card news-card__title mb-3">
			<a href="<?php the_permalink(); ?>" class="no-underline" style="color:var(--navy); transition:color 0.2s;">
				<?php the_title(); ?>
			</a>
		</h2>

		<!-- Excerpt -->
		<p class="text-sm leading-relaxed text-mid flex-1 mb-5">
			<?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?>
		</p>

		<!-- Source + CTA -->
		<div class="flex items-center justify-between gap-4 mt-auto">
			<?php if ( ! empty( $source_name ) ) : ?>
				<span style="font-family:'JetBrains Mono',monospace; font-size:0.65rem; color:var(--mid); letter-spacing:0.05em;">
					<?php echo esc_html( $source_name ); ?>
				</span>
			<?php else : ?>
				<span></span>
			<?php endif; ?>

			<?php if ( ! empty( $source_url ) ) : ?>
				<a href="<?php echo esc_url( $source_url ); ?>" target="_blank" rel="noopener" class="card-link-mono self-start">
					View Source &rarr;
				</a>
			<?php else : ?>
				<a href="<?php the_permalink(); ?>" class="card-link-mono self-start">
					Read More &rarr;
				</a>
			<?php endif; ?>
		</div>

	</div>
</article>
