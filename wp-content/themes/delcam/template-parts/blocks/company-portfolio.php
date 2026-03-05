<?php
/**
 * Block: Company Portfolio
 * Displays all portfolio companies in a card grid.
 *
 * ACF Block Fields:
 *   section_label    (text)
 *   section_headline (text)
 *   description      (textarea)
 *
 * ACF Per-Post Fields (on portfolio CPT):
 *   company_url  (url) — optional external link for the company
 *
 * @package DelCam_Capital
 */

$section_label    = ! empty( get_field( 'section_label' ) ) ? get_field( 'section_label' ) : '// Our Companies';
$section_headline = ! empty( get_field( 'section_headline' ) ) ? get_field( 'section_headline' ) : 'OUR<br>PORTFOLIO';
$description      = ! empty( get_field( 'description' ) ) ? get_field( 'description' ) : 'Precision manufacturing businesses we\'ve acquired and partnered with across the Northeast and Southeast.';

$portfolio_query = new WP_Query(
	array(
		'post_type'      => 'portfolio',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

// Default placeholder cards shown when no portfolio posts exist.
$default_cards = array(
	array(
		'name'       => 'PlasTech Machining',
		'categories' => array( 'Precision Machining' ),
		'desc'       => 'A leading provider of precision CNC machined components for the aerospace and defense supply chain.',
		'url'        => '',
	),
	array(
		'name'       => 'NEFM',
		'categories' => array( 'Metal Forming' ),
		'desc'       => 'Northeast Fabricated Metals — custom metal fabrication serving industrial and commercial markets across New England.',
		'url'        => '',
	),
	array(
		'name'       => 'PlasTech Molding',
		'categories' => array( 'Plastics Fabrication' ),
		'desc'       => 'High-volume injection molding and tooling services for medical device and consumer product manufacturers.',
		'url'        => '',
	),
	array(
		'name'       => 'Diamond Dog',
		'categories' => array( 'Specialty Coatings' ),
		'desc'       => 'Specialty industrial coatings and surface treatment for precision-manufactured components.',
		'url'        => '',
	),
);
?>

<section class="py-28 px-6 lg:px-12 bg-white">
	<div class="max-w-7xl mx-auto">
		<!-- Section header -->
		<div class="flex flex-col mb-16 gap-8">
			<div>
				<p class="section-label mb-4"><?php echo esc_html( $section_label ); ?></p>
				<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(3rem,7vw,5.5rem); color:var(--navy); line-height:0.93;">
					<?php echo wp_kses_post( $section_headline ); ?>
				</h2>
			</div>
			<?php if ( ! empty( $description ) ) : ?>
			<div class="leading-relaxed text-mid">
			<?php echo $description?>
			</div>
			<?php endif; ?>
		</div>

		<!-- Portfolio grid -->
		<?php if ( $portfolio_query->have_posts() ) : ?>
		<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php
			while ( $portfolio_query->have_posts() ) :
				$portfolio_query->the_post();
				$company_id  = get_the_ID();
				$terms       = get_the_terms( $company_id, 'portfolio_category' );
				$company_url = get_field( 'company_url', $company_id );
				$excerpt     = get_the_excerpt();
				?>
			<div class="card rounded-xl overflow-hidden flex flex-col">

				<!-- Logo / identity area -->
				<div class="flex items-center justify-center p-8 border-b" style="border-color:var(--border); min-height:140px; background:var(--light);">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php
						the_post_thumbnail(
							'medium',
							array(
								'class' => 'max-h-16 w-auto object-contain',
								'alt'   => esc_attr( get_the_title() ),
							)
						);
						?>
					<?php else : ?>
						<span style="font-family:'Bebas Neue',cursive; font-size:2rem; color:var(--navy); letter-spacing:0.05em;">
							<?php the_title(); ?>
						</span>
					<?php endif; ?>
				</div>

				<!-- Card body -->
				<div class="p-6 flex flex-col flex-1">

					<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
					<div class="flex flex-wrap gap-2 mb-3">
						<?php foreach ( $terms as $portfolio_term ) : ?>
						<span class="pill px-3 py-1 rounded-full" style="font-size:0.7rem;"><?php echo esc_html( $portfolio_term->name ); ?></span>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

					<h3 style="font-family:'Bebas Neue',cursive; font-size:1.5rem; color:var(--navy);" class="mb-2">
						<?php the_title(); ?>
					</h3>

					<?php if ( ! empty( $excerpt ) ) : ?>
					<p class="text-sm leading-relaxed flex-1" style="color:var(--mid);"><?php echo esc_html( $excerpt ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $company_url ) ) : ?>
					<a href="<?php echo esc_url( $company_url ); ?>" target="_blank" rel="noopener"
						class="card-link-mono mt-5 inline-block">
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

		<!-- Default placeholder grid (shown before any portfolio CPT entries are added) -->
		<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php foreach ( $default_cards as $card ) : ?>
			<div class="card rounded-xl overflow-hidden flex flex-col">

				<div class="flex items-center justify-center p-8 border-b" style="border-color:var(--border); min-height:140px; background:var(--light);">
					<span style="font-family:'Bebas Neue',cursive; font-size:2rem; color:var(--navy); letter-spacing:0.05em;">
						<?php echo esc_html( $card['name'] ); ?>
					</span>
				</div>

				<div class="p-6 flex flex-col flex-1">

					<div class="flex flex-wrap gap-2 mb-3">
						<?php foreach ( $card['categories'] as $portfolio_cat ) : ?>
						<span class="pill px-3 py-1 rounded-full" style="font-size:0.7rem;"><?php echo esc_html( $portfolio_cat ); ?></span>
						<?php endforeach; ?>
					</div>

					<h3 style="font-family:'Bebas Neue',cursive; font-size:1.5rem; color:var(--navy);" class="mb-2">
						<?php echo esc_html( $card['name'] ); ?>
					</h3>

					<p class="text-sm leading-relaxed flex-1" style="color:var(--mid);"><?php echo esc_html( $card['desc'] ); ?></p>

				</div>
			</div>
			<?php endforeach; ?>
		</div>

		<?php endif; ?>

	</div>
</section>
