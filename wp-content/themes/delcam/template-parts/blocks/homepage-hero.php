<?php
/**
 * Block: Homepage Hero
 * Sections: section label, headline, subhead, two buttons, and a 2×2 stat card grid.
 *
 * ACF Fields:
 *   section_label  (text)    — e.g. "// Private Equity"
 *   headline       (text)
 *   subhead        (text)
 *   button_1       (link)
 *   button_2       (link)
 *   stat_cards     (repeater)
 *     ↳ stat_value       (text)   — e.g. "$2B+"
 *     ↳ is_gold          (true/false)
 *     ↳ stat_label       (text)   — e.g. "Assets Under Management"
 *     ↳ stat_description (text)
 *
 * @package DelCam_Capital
 */

$section_label = ! empty( get_field( 'section_label' ) ) ? get_field( 'section_label' ) : '// Private Equity';
$headline      = ! empty( get_field( 'headline' ) ) ? get_field( 'headline' ) : 'Building Enduring<br>Manufacturing Value.';
$subhead       = ! empty( get_field( 'subhead' ) ) ? get_field( 'subhead' ) : 'Long-term capital partnerships with precision manufacturers across the United States';
$button_1      = get_field( 'button_1' );
$button_2      = get_field( 'button_2' );
$stat_cards    = ! empty( get_field( 'stat_cards' ) ) ? get_field( 'stat_cards' ) : array();

// Default stat cards if none are set.
if ( empty( $stat_cards ) ) {
	$stat_cards = array(
		array(
			'stat_value'       => '$2B+',
			'is_gold'          => true,
			'stat_label'       => 'Assets Under Management',
			'stat_description' => 'Deployed across platform companies',
		),
		array(
			'stat_value'       => '30+',
			'is_gold'          => false,
			'stat_label'       => 'Portfolio Companies',
			'stat_description' => 'Precision manufacturing focus',
		),
		array(
			'stat_value'       => '25+',
			'is_gold'          => false,
			'stat_label'       => 'Years of Experience',
			'stat_description' => 'Investing in manufacturing since 1998',
		),
		array(
			'stat_value'       => '100%',
			'is_gold'          => false,
			'stat_label'       => 'Made in America',
			'stat_description' => 'Domestic manufacturing portfolio',
		),
	);
}
?>

<section class="hero-bg hero-grid relative flex items-center overflow-hidden" style="max-height:75vh; min-height:480px;">

	<!-- Ambient glow -->
	<div class="absolute right-0 top-1/4 w-96 h-96 rounded-full pointer-events-none"
		style="background:radial-gradient(circle, rgba(200,146,42,0.1) 0%, transparent 70%); filter:blur(60px);"></div>

	<div class="max-w-7xl mx-auto px-6 lg:px-12 w-full py-12">
		<div class="grid lg:grid-cols-2 gap-16 items-center">

			<!-- Left: Text + CTAs -->
			<div>
				<p class="section-label mb-4 fade-up d1"><?php echo esc_html( $section_label ); ?></p>

				<h1 class="mb-4 fade-up d2"
					style="font-family:'Bebas Neue',cursive; font-size:clamp(2.8rem,7vw,6rem); color:var(--navy); line-height:0.95;">
					<?php echo wp_kses_post( format_headline( $headline ) ); ?>
				</h1>

				<h2 class="mb-8 fade-up d3"
					style="font-size:clamp(1rem,2vw,1.25rem); font-weight:400; color:var(--mid); line-height:1.5;">
					<?php echo esc_html( $subhead ); ?>
				</h2>

				<div class="flex gap-4 flex-wrap fade-up d4">
					<?php if ( ! empty( $button_1 ) ) : ?>
						<a href="<?php echo esc_url( $button_1['url'] ); ?>"
							class="btn-primary px-8 py-3.5 rounded-md text-sm inline-block"
							<?php echo $button_1['target'] ? 'target="' . esc_attr( $button_1['target'] ) . '"' : ''; ?>>
							<?php echo esc_html( $button_1['title'] ); ?>
						</a>
					<?php else : ?>
						<a href="/strategy/" class="btn-primary px-8 py-3.5 rounded-md text-sm inline-block">Our Strategy</a>
					<?php endif; ?>

					<?php if ( ! empty( $button_2 ) ) : ?>
						<a href="<?php echo esc_url( $button_2['url'] ); ?>"
							class="btn-ghost px-8 py-3.5 rounded-md text-sm inline-block"
							<?php echo $button_2['target'] ? 'target="' . esc_attr( $button_2['target'] ) . '"' : ''; ?>>
							<?php echo esc_html( $button_2['title'] ); ?>
						</a>
					<?php else : ?>
						<a href="/portfolio/" class="btn-ghost px-8 py-3.5 rounded-md text-sm inline-block">View Portfolio</a>
					<?php endif; ?>
				</div>
			</div>

			<!-- Right: 2×2 stat card grid -->
			<div class="grid grid-cols-2 gap-4">
				<?php
				foreach ( $stat_cards as $i => $card ) :
					$is_gold = ! empty( $card['is_gold'] );
					$last    = ( count( $stat_cards ) - 1 === $i );
					?>
				<div class="card <?php echo $is_gold ? 'card-gold' : ''; ?> p-6 rounded-xl
					<?php echo ( $last && ! $is_gold ) ? '' : ''; ?>"
					<?php if ( $last && ! $is_gold ) : ?>
						style="border-color:rgba(30,95,168,0.35); background:rgba(30,95,168,0.04);"
					<?php endif; ?>>
					<div class="stat-number <?php echo $is_gold ? 'gold' : ''; ?>">
						<?php echo esc_html( $card['stat_value'] ); ?>
					</div>
					<div class="<?php echo $is_gold ? 'accent-line-gold' : 'accent-line'; ?> my-3"></div>
					<p class="font-semibold text-sm" style="color:var(--navy);">
						<?php echo esc_html( $card['stat_label'] ); ?>
					</p>
					<p class="text-xs mt-1" style="color:var(--mid);">
						<?php echo esc_html( $card['stat_description'] ); ?>
					</p>
				</div>
				<?php endforeach; ?>
			</div>

		</div><!-- .grid -->
	</div>
</section>
