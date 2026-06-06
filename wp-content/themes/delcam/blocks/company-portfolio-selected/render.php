<?php
/**
 * Block: Selected Company Portfolio (native Gutenberg — ACF relationship for company selection)
 * Hand-picks specific portfolio companies to feature (e.g. homepage highlight).
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * Block attributes:
 *   selectedPostIds — if set, shows those specific posts in order; otherwise shows most recent published portfolio posts.
 *
 * Portfolio CPT meta fields (per post):
 *   company_url        (url)     — optional external link for the company
 *   company_card_image (integer) — attachment ID; full-bleed card cover photo (distinct from the featured image/logo)
 *
 * @package DelCam_Capital
 */

$section_label    = $attributes['sectionLabel']    ?? '// Featured Companies';
$section_headline = $attributes['sectionHeadline'] ?? "FROM OUR\nPORTFOLIO";
$description      = $attributes['description']     ?? 'We partner with industry-leading manufacturing companies across diverse, essential sectors.';
$limit            = isset( $attributes['limit'] ) ? (int) $attributes['limit'] : 3;
$cta_button_text  = $attributes['ctaButtonText']   ?? 'View All Companies →';
$cta_button_url   = $attributes['ctaButtonUrl']    ?? '/portfolio/';

$selected_ids = ! empty( $attributes['selectedPostIds'] ) && is_array( $attributes['selectedPostIds'] )
	? array_map( 'intval', $attributes['selectedPostIds'] )
	: array();

$query_args = array(
	'post_type'      => 'portfolio',
	'posts_per_page' => $limit,
	'post_status'    => 'publish',
);

if ( ! empty( $selected_ids ) ) {
	$query_args['post__in'] = $selected_ids;
	$query_args['orderby']  = 'post__in';
	$query_args['order']    = 'ASC';
} else {
	$query_args['orderby'] = 'date';
	$query_args['order']   = 'DESC';
}

$portfolio_query = new WP_Query( $query_args );

$dark_bg = (bool) ( $attributes['darkBackground'] ?? false );
$s       = delcam_scheme( $dark_bg );

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'company-portfolio-selected-section ' . $s['section_class'] ) );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>; padding:7rem 1.5rem; position:relative; overflow:hidden;">

	<?php if ( $dark_bg ) : ?>
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute top-0 right-0 w-96 h-96 pointer-events-none glow-gold-lg" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto relative z-10">

		<!-- Section header -->
		<div class="mb-16">
			<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; border-left:2px solid <?php echo $s['label_border']; ?>; padding-left:0.75rem; margin-bottom:1.25rem;">
				<?php echo esc_html( $section_label ); ?>
			</p>
			<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(3rem,7vw,5.5rem); color:<?php echo $s['heading']; ?>; line-height:0.93;">
				<?php echo wp_kses_post( format_headline( nl2br( $section_headline ) ) ); ?>
			</h2>
			<?php if ( ! empty( $description ) ) : ?>
			<p style="font-size:0.95rem; line-height:1.75; color:<?php echo $s['text']; ?>; margin-top:1rem;">
				<?php echo esc_html( $description ); ?>
			</p>
			<?php endif; ?>
		</div>

		<!-- Portfolio grid -->
		<?php if ( $portfolio_query->have_posts() ) : ?>
		<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			while ( $portfolio_query->have_posts() ) :
				$portfolio_query->the_post();
				$company_id        = get_the_ID();
				$terms             = get_the_terms( $company_id, 'portfolio_category' );
				$company_url       = get_post_meta( $company_id, 'company_url', true );
				$excerpt           = get_the_excerpt();
				$company_page      = get_permalink( $company_id );
				$card_image_id     = (int) get_post_meta( $company_id, 'company_card_image', true );
				$has_card_image    = $card_image_id > 0;
				$logo_id           = (int) get_post_meta( $company_id, 'company_logo', true );
				$has_logo          = $logo_id > 0;
			?>
			<a href="<?php echo esc_url( $company_page ); ?>" class="card rounded-xl overflow-hidden flex flex-col"
				data-aos="fade-up" data-aos-duration="500" style="text-decoration:none;">

				<!-- Card image (full-bleed cover) — uses company_card_image if set, falls back to featured image -->
				<div class="overflow-hidden" style="height:220px;">
					<?php if ( $has_card_image ) : ?>
						<?php echo wp_get_attachment_image( $card_image_id, 'large', false, array( 'class' => 'w-full h-full object-cover', 'alt' => esc_attr( get_the_title() ) ) ); ?>
					<?php elseif ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover', 'alt' => esc_attr( get_the_title() ) ) ); ?>
					<?php else : ?>
						<div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%);">
							<span style="font-family:'Bebas Neue',cursive; font-size:2rem; color:rgba(255,255,255,0.7); letter-spacing:0.05em;">
								<?php the_title(); ?>
							</span>
						</div>
					<?php endif; ?>
				</div>

				<!-- Card body -->
				<div class="p-8 flex flex-col gap-4 flex-1"
					style="background:<?php echo $s['card_bg']; ?>; border:1px solid <?php echo $s['card_border']; ?>; border-top:none;">

					<?php if ( $has_logo ) : ?>
					<div style="display:inline-flex; align-items:center; background:#fff; border-radius:8px; padding:0.5rem 1rem; align-self:flex-start;">
						<?php echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'style' => 'height:36px; width:auto; object-fit:contain; display:block;', 'alt' => esc_attr( get_the_title() ) . ' logo' ) ); ?>
					</div>
					<?php endif; ?>

					<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
					<div class="flex flex-wrap gap-2">
						<?php foreach ( $terms as $portfolio_term ) : ?>
						<span style="background:<?php echo $s['pill_bg']; ?>; color:<?php echo $s['pill_text']; ?>; border:1px solid <?php echo $s['pill_border']; ?>; font-size:0.7rem; font-family:'JetBrains Mono',monospace; letter-spacing:0.06em; text-transform:uppercase; padding:0.25rem 0.75rem; border-radius:9999px; display:inline-block;">
							<?php echo esc_html( $portfolio_term->name ); ?>
						</span>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

					<h3 style="font-family:'Bebas Neue',cursive; font-size:1.6rem; color:<?php echo $s['heading']; ?>; line-height:1.1;">
						<?php the_title(); ?>
					</h3>

					<?php if ( ! empty( $excerpt ) ) : ?>
					<p style="font-size:0.875rem; line-height:1.75; flex:1; color:<?php echo $s['text']; ?>;">
						<?php echo esc_html( $excerpt ); ?>
					</p>
					<?php endif; ?>

					<?php if ( ! empty( $company_url ) ) : ?>
					<a href="<?php echo esc_url( $company_url ); ?>" target="_blank" rel="noopener"
						style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase; color:<?php echo $s['label']; ?>; text-decoration:none; margin-top:auto; display:inline-block;">
						Visit Company &rarr;
					</a>
					<?php endif; ?>

				</div>
			</a>
			<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>

		<?php endif; ?>

		<!-- CTA button -->
		<div class="mt-6 flex justify-center">
			<a href="<?php echo esc_url( $cta_button_url ); ?>" class="<?php echo $s['btn_primary']; ?> text-sm px-10 py-4 rounded-md">
				<?php echo esc_html( $cta_button_text ); ?>
			</a>
		</div>

	</div>
</section>
