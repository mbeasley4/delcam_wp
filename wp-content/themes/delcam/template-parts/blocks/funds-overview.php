<?php
/**
 * Block: Funds Overview
 * Displays a list of funds, each with a name, portfolio companies, and description.
 *
 * ACF Fields:
 *   section_label    (text)
 *   section_headline (text)
 *   funds            (repeater)
 *     ↳ fund_name            (text)
 *     ↳ fund_description     (textarea)
 *     ↳ portfolio_companies  (repeater)
 *         ↳ company_name (text)
 *
 * @package DelCam_Capital
 */

$section_label    = ! empty( get_field( 'section_label' ) ) ? get_field( 'section_label' ) : '// Our Funds';
$section_headline = ! empty( get_field( 'section_headline' ) ) ? get_field( 'section_headline' ) : 'FUNDS<br>OVERVIEW';
$funds            = ! empty( get_field( 'funds' ) ) ? get_field( 'funds' ) : array();

// Default fund data.
if ( empty( $funds ) ) {
	$funds = array(
		array(
			'fund_name'           => 'DelCam Fund I, LP',
			'fund_description'    => 'Fund I focused on building a diversified portfolio of manufacturing businesses with strong operational foundations and growth potential.',
			'portfolio_companies' => array(
				array( 'company_name' => 'PlasTech Machining & Fabrication' ),
				array( 'company_name' => 'PlasTech Molding Solutions' ),
				array( 'company_name' => 'New England Fabricated Metals' ),
				array( 'company_name' => 'Howard Products' ),
				array( 'company_name' => 'Shortening Shuttle' ),
			),
		),
		array(
			'fund_name'           => 'DelCam Fund II, LP',
			'fund_description'    => 'Fund II continues the firm\'s strategy of acquiring and scaling niche manufacturers while building integrated platforms in specialized industries such as life safety systems and electronics manufacturing.',
			'portfolio_companies' => array(
				array( 'company_name' => 'Space Age Electronics' ),
				array( 'company_name' => 'Gaston Electronics' ),
			),
		),
	);
}
?>

<section class="section-dark py-28 px-6 lg:px-12 relative overflow-hidden">

	<!-- Grid overlay -->
	<div class="absolute inset-0 pointer-events-none grid-overlay"></div>

	<!-- Ambient glow -->
	<div class="absolute right-0 top-0 w-96 h-96 pointer-events-none glow-gold"></div>

	<div class="max-w-7xl mx-auto relative z-10">

		<!-- Section heading -->
		<div class="mb-12">
			<p class="section-label mb-2"><?php echo esc_html( $section_label ); ?></p>
			<h2 class="heading-display-dark">
				<?php echo wp_kses_post( format_headline( $section_headline ) ); ?>
			</h2>
		</div>

		<!-- Fund cards -->
		<div class="grid md:grid-cols-2 gap-8">

			<?php foreach ( $funds as $i => $fund ) : ?>
			<div class="step-card rounded-xl p-8 flex flex-col gap-6">

				<!-- Fund number badge + name -->
				<div>
					<span class="mono-label-dim mb-3 block">
						<?php printf( 'FUND %s', esc_html( strtoupper( $i > 0 ? 'II' : 'I' ) ) ); ?>
					</span>
					<h3 class="heading-card-dark">
						<?php echo esc_html( $fund['fund_name'] ); ?>
					</h3>
				</div>

				<!-- Portfolio companies -->
				<?php if ( ! empty( $fund['portfolio_companies'] ) ) : ?>
				<div>
					<p class="mono-label-gold mb-3 block uppercase tracking-widest">Portfolio Companies</p>
					<div class="flex flex-wrap gap-2">
						<?php foreach ( $fund['portfolio_companies'] as $company ) : ?>
						<span class="inline-block px-3 py-1.5 rounded text-xs font-['JetBrains_Mono'] bg-[var(--gold)]/10 border border-[var(--gold)]/30 text-[var(--gold-light)]">
							<?php echo esc_html( $company['company_name'] ); ?>
						</span>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- Description -->
				<?php if ( ! empty( $fund['fund_description'] ) ) : ?>
				<p class="text-sm leading-relaxed opacity-60 border-t border-white/10 pt-4">
					<?php echo esc_html( $fund['fund_description'] ); ?>
				</p>
				<?php endif; ?>

			</div>
			<?php endforeach; ?>

		</div><!-- .grid -->
	</div>
</section>
