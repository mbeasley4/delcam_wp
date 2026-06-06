<?php
/**
 * Block: Portfolio Marquee (native Gutenberg — ACF repeater for companies)
 * Navy bar with an infinitely scrolling ticker of portfolio company names.
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * ACF Fields (per page):
 *   companies  (repeater)
 *     ↳ company_name (text)
 *
 * @package DelCam_Capital
 */

$companies = ! empty( $attributes['companies'] ) && is_array( $attributes['companies'] )
	? $attributes['companies']
	: array(
		array( 'company_name' => 'PLASTECH MACHINING' ),
		array( 'company_name' => 'NEFM' ),
		array( 'company_name' => 'PLASTECH MOLDING' ),
		array( 'company_name' => 'PRECISION PLASTICS' ),
		array( 'company_name' => 'AEROSPACE FABRICATION' ),
	);

// Duplicate for seamless looping.
$duplicated = array_merge( $companies, $companies );

$dark_bg = (bool) ( $attributes['darkBackground'] ?? true );
$s       = delcam_scheme( $dark_bg );

// Marquee-specific colors.
$marquee_bg     = $dark_bg ? 'var(--navy)' : 'var(--light)';
$marquee_text   = $dark_bg ? 'rgba(255,255,255,0.4)' : 'rgba(11,37,69,0.5)';
$marquee_dot    = 'var(--gold)';

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'portfolio-marquee-section py-4 marquee-overflow' ) );
?>

<div <?php echo $wrapper_attrs; ?> style="background:<?php echo $marquee_bg; ?>; border-top:1px solid <?php echo $dark_bg ? 'rgba(255,255,255,0.06)' : 'rgba(30,95,168,0.1)'; ?>; border-bottom:1px solid <?php echo $dark_bg ? 'rgba(255,255,255,0.06)' : 'rgba(30,95,168,0.1)'; ?>;">
	<div class="marquee-track" style="color:<?php echo $marquee_text; ?>;">
		<?php foreach ( $duplicated as $company ) : ?>
		<span style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.15em;">
			<?php echo esc_html( $company['company_name'] ); ?>
		</span>
		<span style="color:<?php echo $marquee_dot; ?>;">&#10022;</span>
		<?php endforeach; ?>
	</div>
</div>
