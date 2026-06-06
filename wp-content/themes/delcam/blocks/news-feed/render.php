<?php
/**
 * Block: News Feed
 * Displays press_mentions posts optionally filtered by a news_type taxonomy term.
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * Attributes:
 *   newsTypeSlug  — news_type term slug to filter; empty = show all
 *   postsPerPage  — how many posts to show
 *   darkBackground — toggle color scheme
 *
 * @package DelCam_Capital
 */

$section_label    = $attributes['sectionLabel']    ?? '// News & Press';
$section_headline = $attributes['sectionHeadline'] ?? "NEWS &\nPRESS";
$description      = $attributes['description']     ?? '';
$news_type_slug   = trim( $attributes['newsTypeSlug'] ?? '' );
$posts_per_page   = isset( $attributes['postsPerPage'] ) ? (int) $attributes['postsPerPage'] : 9;

$dark_bg = (bool) ( $attributes['darkBackground'] ?? false );
$s       = delcam_scheme( $dark_bg );

// Build query — filter by news_type if a slug is provided.
$query_args = array(
	'post_type'           => 'press_mentions',
	'posts_per_page'      => $posts_per_page,
	'post_status'         => 'publish',
	'orderby'             => 'date',
	'order'               => 'DESC',
	'ignore_custom_sort'  => true,
);

if ( $news_type_slug !== '' ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'news_type',
			'field'    => 'slug',
			'terms'    => $news_type_slug,
		),
	);
}

$news_query = new WP_Query( $query_args );

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'news-feed-section' ) );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>; padding:5rem 1.5rem; position:relative; overflow:hidden;">

	<?php if ( $dark_bg ) : ?>
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute top-0 right-0 w-96 h-96 pointer-events-none glow-gold-lg" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto relative z-10">

		<!-- Section header -->
		<div class="mb-14">
			<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; border-left:2px solid <?php echo $s['label_border']; ?>; padding-left:0.75rem; margin-bottom:1.25rem;">
				<?php echo esc_html( $section_label ); ?>
			</p>
			<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(2.5rem,6vw,4.5rem); color:<?php echo $s['heading']; ?>; line-height:0.93;">
				<?php echo wp_kses_post( format_headline( nl2br( $section_headline ) ) ); ?>
			</h2>
			<?php if ( ! empty( $description ) ) : ?>
			<p style="font-size:0.95rem; line-height:1.75; color:<?php echo $s['text']; ?>; margin-top:1rem; max-width:60ch;">
				<?php echo esc_html( $description ); ?>
			</p>
			<?php endif; ?>
		</div>

		<!-- News grid -->
		<?php if ( $news_query->have_posts() ) : ?>
		<div class="news-archive-grid">
			<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
				<?php
				$source_name = get_post_meta( get_the_ID(), 'source_name', true );
				$source_url  = get_post_meta( get_the_ID(), 'source_url',  true );
				$press_date  = get_post_meta( get_the_ID(), 'press_date',  true );
				$news_types  = get_the_terms( get_the_ID(), 'news_type' );
				$first_type  = ( ! empty( $news_types ) && ! is_wp_error( $news_types ) ) ? $news_types[0] : null;
				$post_date   = ! empty( $press_date ) ? $press_date : get_the_date( 'M j, Y' );
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'news-card card rounded-xl overflow-hidden flex flex-col' ); ?>>
					<div class="news-card__body flex flex-col flex-1 p-6">

						<!-- Type badge + date -->
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
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

		<?php else : ?>

		<!-- Empty state -->
		<div class="text-center py-24">
			<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; margin-bottom:1rem;">
				// Nothing here yet
			</p>
			<p style="font-size:1.05rem; color:<?php echo $s['text']; ?>; opacity:0.6;">
				Check back soon — new content is on the way.
			</p>
		</div>

		<?php endif; ?>

	</div>
</section>
