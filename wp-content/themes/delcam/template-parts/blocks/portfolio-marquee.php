<?php
/**
 * Block: Portfolio Marquee (Scrolling Ticker)
 * Navy bar with an infinitely scrolling list of portfolio company names.
 *
 * ACF Fields:
 *   companies (repeater)
 *     ↳ company_name (text)
 *
 * @package DelCam_Capital
 */

$companies = ! empty( get_field( 'companies' ) ) ? get_field( 'companies' ) : array();

// Default companies if none set.
if ( empty( $companies ) ) {
	$companies = array(
		array( 'company_name' => 'PLASTECH MACHINING' ),
		array( 'company_name' => 'NEFM' ),
		array( 'company_name' => 'PLASTECH MOLDING' ),
		array( 'company_name' => 'PRECISION PLASTICS' ),
		array( 'company_name' => 'AEROSPACE FABRICATION' ),
	);
}

// Duplicate the list for seamless looping.
$duplicated = array_merge( $companies, $companies );
?>

<div class="py-4 marquee-overflow" style="background:var(--navy);">
	<div class="marquee-track" style="color:rgba(255,255,255,0.4);">
		<?php foreach ( $duplicated as $company ) : ?>
			<span style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.15em;">
				<?php echo esc_html( $company['company_name'] ); ?>
			</span>
			<span style="color:var(--gold);">&#10022;</span>
		<?php endforeach; ?>
	</div>
</div>
