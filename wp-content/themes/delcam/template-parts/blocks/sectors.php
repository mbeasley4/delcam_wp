<?php
/**
 * Block: Sectors
 * Light-bg section with a centered heading, clickable sector pills,
 * and a 3-column stat card row.
 *
 * ACF Fields:
 *   section_label    (text)
 *   section_headline (text)
 *   sector_pills     (repeater)
 *     ↳ pill_label (text)
 *   stat_cards       (repeater)
 *     ↳ stat_value       (text)
 *     ↳ is_gold          (true/false)
 *     ↳ stat_label       (text)
 *     ↳ stat_description (text)
 *
 * @package DelCam_Capital
 */

$section_label    = ! empty( get_field( 'section_label' ) ) ? get_field( 'section_label' ) : '// Target Sectors';
$section_headline = ! empty( get_field( 'section_headline' ) ) ? get_field( 'section_headline' ) : 'WE INVEST IN<br>CRITICAL MANUFACTURING.';
$sector_pills     = ! empty( get_field( 'sector_pills' ) ) ? get_field( 'sector_pills' ) : array();
$stat_cards       = ! empty( get_field( 'stat_cards' ) ) ? get_field( 'stat_cards' ) : array();

// Defaults.
if ( empty( $sector_pills ) ) {
	$sector_pills = array(
		array( 'pill_label' => 'Precision Machining' ),
		array( 'pill_label' => 'Plastics Fabrication' ),
		array( 'pill_label' => 'Metal Forming' ),
		array( 'pill_label' => 'Aerospace Components' ),
		array( 'pill_label' => 'Medical Device Manufacturing' ),
		array( 'pill_label' => 'Defense Supply Chain' ),
		array( 'pill_label' => 'Electronics Assembly' ),
		array( 'pill_label' => 'Industrial Automation' ),
		array( 'pill_label' => 'Specialty Coatings' ),
		array( 'pill_label' => 'Composite Materials' ),
	);
}

if ( empty( $stat_cards ) ) {
	$stat_cards = array(
		array(
			'stat_value'       => '$5M',
			'is_gold'          => true,
			'stat_label'       => 'Minimum EBITDA',
			'stat_description' => 'Target company size for platform acquisitions',
		),
		array(
			'stat_value'       => 'NE / SE',
			'is_gold'          => false,
			'stat_label'       => 'Primary Geographies',
			'stat_description' => 'Northeast and Southeast United States',
		),
		array(
			'stat_value'       => '3–7X',
			'is_gold'          => true,
			'stat_label'       => 'Hold Period (Years)',
			'stat_description' => 'Long-term orientation, not a quick flip',
		),
	);
}
?>

<section class="py-28 px-6 lg:px-12 section-light">
	<div class="max-w-7xl mx-auto text-center">

		<p class="section-label mb-4"><?php echo esc_html( $section_label ); ?></p>

		<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(3rem,7vw,5.5rem); color:var(--navy); line-height:0.93;" class="mb-12">
			<?php echo wp_kses_post( format_headline( $section_headline ) ); ?>
		</h2>

		<!-- Sector pills -->
		<div class="flex flex-wrap gap-3 justify-center mb-16">
			<?php foreach ( $sector_pills as $pill ) : ?>
				<span class="pill px-5 py-2.5 rounded-full">
					<?php echo esc_html( $pill['pill_label'] ); ?>
				</span>
			<?php endforeach; ?>
		</div>

		<!-- Stat cards row -->
		<div class="grid md:grid-cols-3 gap-6 mt-4">
			<?php
			foreach ( $stat_cards as $card ) :
				$is_gold = ! empty( $card['is_gold'] );
				?>
			<div class="card p-8 rounded-xl text-center">
				<div class="stat-number <?php echo $is_gold ? 'gold' : ''; ?> text-center" style="justify-content:center;">
					<?php echo esc_html( $card['stat_value'] ); ?>
				</div>
				<div class="<?php echo $is_gold ? 'accent-line-gold' : 'accent-line'; ?> my-3 mx-auto"></div>
				<p class="font-semibold text-sm" style="color:var(--navy);">
					<?php echo esc_html( $card['stat_label'] ); ?>
				</p>
				<p class="text-xs mt-1" style="color:var(--mid);">
					<?php echo esc_html( $card['stat_description'] ); ?>
				</p>
			</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
