<?php
/**
 * Block: Sectors (native Gutenberg — ACF repeaters for pills and stats)
 * Light section with a centered heading, sector pills, and a stat card row.
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * ACF Fields (per page):
 *   sector_pills  (repeater)
 *     ↳ pill_label (text)
 *   stat_cards    (repeater)
 *     ↳ stat_value       (text)
 *     ↳ is_gold          (true/false)
 *     ↳ stat_label       (text)
 *     ↳ stat_description (text)
 *
 * @package DelCam_Capital
 */

$section_label    = $attributes['sectionLabel']    ?? '// Target Sectors';
$section_headline = $attributes['sectionHeadline'] ?? "WE INVEST IN\nCRITICAL MANUFACTURING.";

$sector_pills = ! empty( $attributes['sectorPills'] ) && is_array( $attributes['sectorPills'] )
	? $attributes['sectorPills']
	: array(
		array( 'pill_label' => 'Precision Machining' ), array( 'pill_label' => 'Plastics Fabrication' ),
		array( 'pill_label' => 'Metal Forming' ),        array( 'pill_label' => 'Aerospace Components' ),
		array( 'pill_label' => 'Medical Device Manufacturing' ), array( 'pill_label' => 'Defense Supply Chain' ),
		array( 'pill_label' => 'Electronics Assembly' ), array( 'pill_label' => 'Industrial Automation' ),
		array( 'pill_label' => 'Specialty Coatings' ),   array( 'pill_label' => 'Composite Materials' ),
	);

$stat_cards = ! empty( $attributes['statCards'] ) && is_array( $attributes['statCards'] )
	? $attributes['statCards']
	: array(
		array( 'stat_value' => '$5M',    'is_gold' => true,  'stat_label' => 'Minimum EBITDA',      'stat_description' => 'Target company size for platform acquisitions' ),
		array( 'stat_value' => 'NE / SE','is_gold' => false, 'stat_label' => 'Primary Geographies', 'stat_description' => 'Northeast and Southeast United States' ),
		array( 'stat_value' => '3–7X',  'is_gold' => true,  'stat_label' => 'Hold Period (Years)',  'stat_description' => 'Long-term orientation, not a quick flip' ),
	);

$dark_bg = (bool) ( $attributes['darkBackground'] ?? false );
$s       = delcam_scheme( $dark_bg );

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'sectors-section ' . $s['section_class'] ) );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>; padding:7rem 1.5rem; position:relative; overflow:hidden;">

	<?php if ( $dark_bg ) : ?>
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute top-0 right-0 w-96 h-96 pointer-events-none glow-gold-lg" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto text-center relative z-10">

		<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; margin-bottom:1.25rem; border-left:2px solid <?php echo $s['label_border']; ?>; display:inline-block; padding-left:0.75rem;">
			<?php echo esc_html( $section_label ); ?>
		</p>

		<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(3rem,7vw,5.5rem); color:<?php echo $s['heading']; ?>; line-height:0.93; margin-bottom:3rem;">
			<?php echo wp_kses_post( format_headline( nl2br( $section_headline ) ) ); ?>
		</h2>

		<!-- Sector pills -->
		<div class="flex flex-wrap gap-3 justify-center mb-16">
			<?php foreach ( $sector_pills as $i => $pill ) : ?>
			<span style="background:<?php echo $s['pill_bg']; ?>; color:<?php echo $s['pill_text']; ?>; border:1px solid <?php echo $s['pill_border']; ?>; font-family:'DM Sans',sans-serif; font-size:0.8rem; font-weight:500; padding:0.625rem 1.25rem; border-radius:9999px; display:inline-block;"
				data-aos="fade-up" data-aos-duration="400" data-aos-delay="<?php echo esc_attr( $i * 40 ); ?>">
				<?php echo esc_html( $pill['pill_label'] ); ?>
			</span>
			<?php endforeach; ?>
		</div>

		<!-- Stat cards row -->
		<div class="grid md:grid-cols-3 gap-6 mt-4">
			<?php foreach ( $stat_cards as $i => $card ) :
				$is_gold = ! empty( $card['is_gold'] );
			?>
			<div class="<?php echo $s['card_class']; ?> p-8 rounded-xl text-center"
				style="background:<?php echo $s['card_bg']; ?>; border:1px solid <?php echo $s['card_border']; ?>;"
				data-aos="fade-up" data-aos-duration="500" data-aos-delay="<?php echo esc_attr( $i * 100 ); ?>">
				<div style="font-family:'Bebas Neue',cursive; font-size:3rem; line-height:1; color:<?php echo $is_gold ? 'var(--gold)' : $s['heading']; ?>; text-align:center;">
					<?php echo esc_html( $card['stat_value'] ); ?>
				</div>
				<div style="width:2rem; height:2px; background:<?php echo $is_gold ? 'var(--gold)' : 'var(--blue)'; ?>; margin:0.75rem auto;"></div>
				<p style="font-weight:600; font-size:0.875rem; color:<?php echo $s['heading']; ?>;">
					<?php echo esc_html( $card['stat_label'] ); ?>
				</p>
				<p style="font-size:0.75rem; margin-top:0.25rem; color:<?php echo $s['text_muted']; ?>;">
					<?php echo esc_html( $card['stat_description'] ); ?>
				</p>
			</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
