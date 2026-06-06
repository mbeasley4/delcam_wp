<?php
/**
 * Block: Company Portfolio (native Gutenberg — no ACF required)
 * Displays all portfolio companies in a card grid.
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * Portfolio CPT meta fields (per post):
 *   company_url        (string)  — optional external link
 *   company_card_image (integer) — override card photo; falls back to featured image
 *   company_logo       (integer) — logo shown in card body and on company page
 *
 * @package DelCam_Capital
 */

$section_label    = $attributes['sectionLabel']    ?? '// Our Companies';
$section_headline = $attributes['sectionHeadline'] ?? 'OUR PORTFOLIO';
$description      = $attributes['description']     ?? '';

$portfolio_query = new WP_Query( array(
	'post_type'      => 'portfolio',
	'posts_per_page' => -1,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
) );

$placeholder_companies = array(
	array( 'name' => 'Portfolio Company A', 'category' => 'Precision Manufacturing', 'excerpt' => 'A leading precision manufacturer serving aerospace and defense customers across the Northeast.' ),
	array( 'name' => 'Portfolio Company B', 'category' => 'Industrial Services',     'excerpt' => 'Provider of critical industrial maintenance and repair services across the Southeast.' ),
	array( 'name' => 'Portfolio Company C', 'category' => 'Business Services',       'excerpt' => 'Tech-enabled business services platform with strong recurring revenue and loyal customer base.' ),
);

$dark_bg = (bool) ( $attributes['darkBackground'] ?? false );
$s       = delcam_scheme( $dark_bg );

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'company-portfolio-section ' . $s['section_class'] ) );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>; padding:7rem 1.5rem; position:relative; overflow:hidden;">

	<?php if ( $dark_bg ) : ?>
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute top-0 right-0 w-96 h-96 pointer-events-none glow-gold-lg" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto relative z-10">

		<!-- Section header -->
		<div class="mb-16">
			<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:var(--gold); border-left:2px solid rgba(200,146,42,0.4); padding-left:0.75rem; margin-bottom:1.25rem;">
				<?php echo esc_html( $section_label ); ?>
			</p>
			<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(3rem,7vw,5.5rem); line-height:0.93; color:<?php echo $s['heading']; ?>;">
				<?php echo wp_kses_post( format_headline( $section_headline ) ); ?>
			</h2>
			<?php if ( ! empty( $description ) ) : ?>
			<p style="line-height:1.75; margin-top:1rem; font-size:0.95rem; color:<?php echo $s['text']; ?>;">
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
				$company_id    = get_the_ID();
				$terms         = get_the_terms( $company_id, 'portfolio_category' );
				$company_url   = get_post_meta( $company_id, 'company_url',       true );
				$excerpt       = get_the_excerpt();
				$company_page  = get_permalink( $company_id );
				$card_image_id = (int) get_post_meta( $company_id, 'company_card_image', true );
				$has_card_image = $card_image_id > 0;
				$logo_id       = (int) get_post_meta( $company_id, 'company_logo', true );
				$has_logo      = $logo_id > 0;
			?>
			<a href="<?php echo esc_url( $company_page ); ?>" class="card rounded-xl overflow-hidden flex flex-col"
				data-aos="fade-up" data-aos-duration="500" style="text-decoration:none;">

				<!-- Card photo — override, then featured image, then gradient fallback -->
				<div class="overflow-hidden" style="height:220px;">
					<?php
					// Cards display at ~405px (desktop 3-col), ~600px (tablet 2-col), 100vw (mobile).
					$card_sizes = '(max-width: 767px) 100vw, (max-width: 1023px) calc(50vw - 3rem), 405px';
					?>
					<?php if ( $has_card_image ) : ?>
						<?php echo wp_get_attachment_image( $card_image_id, 'large', false, array( 'class' => 'w-full h-full object-cover', 'alt' => esc_attr( get_the_title() ), 'sizes' => $card_sizes ) ); ?>
					<?php elseif ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover', 'alt' => esc_attr( get_the_title() ), 'sizes' => $card_sizes ) ); ?>
					<?php else : ?>
						<div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg,var(--navy) 0%,var(--blue) 100%);">
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
						<?php echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'style' => 'height:36px; width:auto; object-fit:contain; display:block;', 'alt' => esc_attr( get_the_title() ) . ' logo', 'sizes' => '72px' ) ); ?>
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

		<?php else : ?>

		<!-- Placeholder cards when no CPT data exists -->
		<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php foreach ( $placeholder_companies as $i => $company ) : ?>
			<div class="card rounded-xl overflow-hidden flex flex-col"
				style="animation-delay:<?php echo esc_attr( $i * 80 ); ?>ms; border:1px solid <?php echo $s['card_border']; ?>;">
				<div class="overflow-hidden" style="height:220px; background:linear-gradient(135deg,var(--navy) 0%,var(--blue) 100%); display:flex; align-items:center; justify-content:center;">
					<span style="font-family:'Bebas Neue',cursive; font-size:2rem; color:rgba(255,255,255,0.7); letter-spacing:0.05em;">
						<?php echo esc_html( $company['name'] ); ?>
					</span>
				</div>
				<div class="p-8 flex flex-col gap-4 flex-1" style="background:<?php echo $s['card_bg']; ?>;">
					<div class="flex flex-wrap gap-2">
						<span style="background:<?php echo $s['pill_bg']; ?>; color:<?php echo $s['pill_text']; ?>; border:1px solid <?php echo $s['pill_border']; ?>; font-size:0.7rem; font-family:'JetBrains Mono',monospace; letter-spacing:0.06em; text-transform:uppercase; padding:0.25rem 0.75rem; border-radius:9999px; display:inline-block;">
							<?php echo esc_html( $company['category'] ); ?>
						</span>
					</div>
					<h3 style="font-family:'Bebas Neue',cursive; font-size:1.6rem; color:<?php echo $s['heading']; ?>; line-height:1.1;">
						<?php echo esc_html( $company['name'] ); ?>
					</h3>
					<p style="font-size:0.875rem; line-height:1.75; flex:1; color:<?php echo $s['text']; ?>;">
						<?php echo esc_html( $company['excerpt'] ); ?>
					</p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>

		<?php endif; ?>

	</div>
</section>
