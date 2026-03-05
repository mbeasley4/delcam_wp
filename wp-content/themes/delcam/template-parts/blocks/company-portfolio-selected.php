<?php
/**
 * Block: Selected Company Portfolio
 * Hand-picks specific portfolio companies to feature (e.g. homepage highlight).
 *
 * ACF Block Fields:
 *   section_label       (text)
 *   section_headline    (text)
 *   description         (textarea)
 *   selected_companies  (relationship → portfolio CPT)
 *   limit               (number)  — max cards to show, default 3
 *   cta_button          (link)    — optional "View All" button below grid
 *
 * ACF Per-Post Fields (on portfolio CPT):
 *   company_url  (url) — optional external link for the company
 *
 * @package DelCam_Capital
 */

$section_label    = ! empty( get_field( 'section_label' ) ) ? get_field( 'section_label' ) : '// Featured Companies';
$section_headline = ! empty( get_field( 'section_headline' ) ) ? get_field( 'section_headline' ) : 'FROM OUR<br>PORTFOLIO';
$description      = ! empty( get_field( 'description' ) ) ? get_field( 'description' ) : 'A selection of the precision manufacturing businesses we\'ve partnered with.';
$selected_ids     = ! empty( get_field( 'selected_companies' ) ) ? wp_list_pluck( get_field( 'selected_companies' ), 'ID' ) : array();
$limit            = ! empty( get_field( 'limit' ) ) ? (int) get_field( 'limit' ) : 3;
$cta_button       = ! empty( get_field( 'cta_button' ) ) ? get_field( 'cta_button' ) : '';

$portfolio_query = new WP_Query(
	array(
		'post_type'      => 'portfolio',
		'post__in'       => ! empty( $selected_ids ) ? $selected_ids : array( 0 ),
		'posts_per_page' => $limit,
		'orderby'        => 'post__in',
		'order'          => 'ASC',
	)
);

// Default placeholder cards shown when no companies are selected.
$default_cards = array(
	array(
		'name'       => 'PlasTech Machining',
		'categories' => array( 'Precision Machining' ),
		'desc'       => 'A leading provider of precision CNC machined components for the aerospace and defense supply chain.',
	),
	array(
		'name'       => 'NEFM',
		'categories' => array( 'Metal Forming' ),
		'desc'       => 'Northeast Fabricated Metals — custom metal fabrication serving industrial and commercial markets across New England.',
	),
	array(
		'name'       => 'PlasTech Molding',
		'categories' => array( 'Plastics Fabrication' ),
		'desc'       => 'High-volume injection molding and tooling services for medical device and consumer product manufacturers.',
	),
);
$default_cards = array_slice( $default_cards, 0, $limit );
?>

<section class="py-28 px-6 lg:px-12" style="background:var(--light);">
	<div class="max-w-7xl mx-auto">

		<!-- Section header -->
		<div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 gap-8">
			<div>
				<p class="section-label mb-4"><?php echo esc_html( $section_label ); ?></p>
				<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(3rem,7vw,5.5rem); color:var(--navy); line-height:0.93;">
					<?php echo wp_kses_post( $section_headline ); ?>
				</h2>
			</div>
			<?php if ( ! empty( $description ) ) : ?>
			<p class="text-sm max-w-xs leading-relaxed" style="color:var(--mid);"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>
		</div>

		<!-- Portfolio grid -->
		<?php if ( $portfolio_query->have_posts() ) : ?>
		<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			while ( $portfolio_query->have_posts() ) :
				$portfolio_query->the_post();
				$company_id  = get_the_ID();
				$terms       = get_the_terms( $company_id, 'portfolio_category' );
				$company_url = get_field( 'company_url', $company_id );
				$excerpt     = get_the_excerpt();
				?>
			<div class="card rounded-xl overflow-hidden flex flex-col">

				<!-- Featured image -->
				<div class="overflow-hidden" style="height:220px;">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php
						the_post_thumbnail(
							'large',
							array(
								'class' => 'w-full h-full object-cover',
								'alt'   => esc_attr( get_the_title() ),
							)
						);
						?>
					<?php else : ?>
						<div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%);">
							<span style="font-family:'Bebas Neue',cursive; font-size:2rem; color:rgba(255,255,255,0.7); letter-spacing:0.05em;">
								<?php the_title(); ?>
							</span>
						</div>
					<?php endif; ?>
				</div>

				<!-- Card body -->
				<div class="p-8 flex flex-col gap-4 flex-1">

					<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
					<div class="flex flex-wrap gap-2">
						<?php foreach ( $terms as $portfolio_term ) : ?>
						<span class="pill px-3 py-1 rounded-full" style="font-size:0.7rem;"><?php echo esc_html( $portfolio_term->name ); ?></span>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

					<h3 style="font-family:'Bebas Neue',cursive; font-size:1.6rem; color:var(--navy); line-height:1.1;">
						<?php the_title(); ?>
					</h3>

					<?php if ( ! empty( $excerpt ) ) : ?>
					<p class="text-sm leading-relaxed flex-1" style="color:var(--mid);"><?php echo esc_html( $excerpt ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $company_url ) ) : ?>
					<a href="<?php echo esc_url( $company_url ); ?>" target="_blank" rel="noopener"
						class="card-link-mono mt-auto inline-block">
						Visit Company →
					</a>
					<?php endif; ?>

				</div>
			</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>

		<?php else : ?>

		<!-- Default placeholder grid -->
		<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php foreach ( $default_cards as $card ) : ?>
			<div class="card rounded-xl overflow-hidden flex flex-col">

				<div class="overflow-hidden flex items-center justify-center" style="height:220px; background:linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%);">
					<span style="font-family:'Bebas Neue',cursive; font-size:2rem; color:rgba(255,255,255,0.7); letter-spacing:0.05em;">
						<?php echo esc_html( $card['name'] ); ?>
					</span>
				</div>

				<div class="p-8 flex flex-col gap-4 flex-1">

					<div class="flex flex-wrap gap-2">
						<?php foreach ( $card['categories'] as $portfolio_cat ) : ?>
						<span class="pill px-3 py-1 rounded-full" style="font-size:0.7rem;"><?php echo esc_html( $portfolio_cat ); ?></span>
						<?php endforeach; ?>
					</div>

					<h3 style="font-family:'Bebas Neue',cursive; font-size:1.6rem; color:var(--navy); line-height:1.1;">
						<?php echo esc_html( $card['name'] ); ?>
					</h3>

					<p class="text-sm leading-relaxed flex-1" style="color:var(--mid);"><?php echo esc_html( $card['desc'] ); ?></p>

				</div>
			</div>
			<?php endforeach; ?>
		</div>

		<?php endif; ?>

		<!-- CTA button -->
		<div class="mt-6 flex justify-center">
			<?php if ( ! empty( $cta_button ) ) : ?>
			<a href="<?php echo esc_url( $cta_button['url'] ); ?>"
				class="btn-primary text-sm px-10 py-4 rounded-md"
				<?php echo ! empty( $cta_button['target'] ) ? 'target="' . esc_attr( $cta_button['target'] ) . '"' : ''; ?>>
				<?php echo esc_html( $cta_button['title'] ); ?>
			</a>
			<?php else : ?>
			<a href="/portfolio/" class="btn-primary text-sm px-10 py-4 rounded-md">View All Companies →</a>
			<?php endif; ?>
		</div>

	</div>
</section>
