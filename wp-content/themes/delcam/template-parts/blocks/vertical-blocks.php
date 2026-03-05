<?php
/**
 * Block: Content + Vertical Blocks (Process / Approach)
 * Dark navy section with numbered process steps on the right
 * and a headline + countdown inset on the left.
 *
 * ACF Fields:
 *   section_label     (text)     — "// Our Approach"
 *   headline          (text)     — display headline
 *   content           (textarea) — intro paragraph
 *   countdown_number  (text)     — e.g. "60–90"
 *   countdown_label   (text)     — e.g. "DAYS TO CLOSE"
 *   vertical_blocks   (repeater)
 *     ↳ title   (text)
 *     ↳ content (textarea)
 *
 * @package DelCam_Capital
 */

$section_label    = ! empty( get_field( 'section_label' ) ) ? get_field( 'section_label' ) : '// Our Approach';
$headline         = ! empty( get_field( 'headline' ) ) ? get_field( 'headline' ) : 'FROM FIRST CALL<br>TO CLOSE.';
$content          = ! empty( get_field( 'content' ) ) ? get_field( 'content' ) : 'We move with certainty and respect your time. No re-trades, no surprises. Our process reflects how we will operate as your partner.';
$countdown_number = ! empty( get_field( 'countdown_number' ) ) ? get_field( 'countdown_number' ) : '60–90';
$countdown_label  = ! empty( get_field( 'countdown_label' ) ) ? get_field( 'countdown_label' ) : 'DAYS TO CLOSE';
$vertical_blocks  = ! empty( get_field( 'vertical_blocks' ) ) ? get_field( 'vertical_blocks' ) : array();

// Default process steps if none are set in ACF.
if ( empty( $vertical_blocks ) ) {
	$vertical_blocks = array(
		array(
			'title'   => 'Introductory Conversation',
			'content' => 'A confidential, no-pressure discussion about your business, your goals, and whether we\'re the right fit. We listen first.',
		),
		array(
			'title'   => 'Indication of Interest',
			'content' => 'A non-binding letter outlining valuation range and deal structure within 2–3 weeks of receiving financials. No delays, no games.',
		),
		array(
			'title'   => 'Diligence & LOI',
			'content' => 'Focused, efficient due diligence with a dedicated team. We aim to be respectful of your time and management bandwidth.',
		),
		array(
			'title'   => 'Close & Partnership',
			'content' => 'We close on time, every time. Day one begins a partnership built on trust, transparency, and shared upside.',
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
		<div class="grid lg:grid-cols-2 gap-20 items-center">

			<!-- Left: Headline + countdown inset -->
			<div class="flex flex-col gap-8">
				<div>
					<p class="section-label mb-2"><?php echo esc_html( $section_label ); ?></p>
					<h2 class="heading-display-dark mb-6">
						<?php echo wp_kses_post( format_headline( $headline ) ); ?>
					</h2>
					<div class="leading-relaxed max-w-sm">
						<?php echo wp_kses_post( $content ); ?>
					</div>
				</div>

				<!-- Countdown inset -->
				<div class="countdown-inset rounded-xl overflow-hidden relative">
					<div class="absolute inset-0 pointer-events-none grid-overlay-white"></div>
					<div class="absolute inset-0 flex items-center justify-center">
						<div class="text-center">
							<div class="countdown-number">
								<?php echo esc_html( $countdown_number ); ?>
							</div>
							<div class="mono-label-dim">
								<?php echo esc_html( $countdown_label ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Right: 3 Feature boxes -->
			<div class="flex flex-col gap-4">
				<?php
				foreach ( array_slice( $vertical_blocks, 0, 3 ) as $i => $block ) :
					$step_num = str_pad( $i + 1, 2, '0', STR_PAD_LEFT );
					?>
				<div class="step-card rounded-xl p-6">
					<span class="mono-label-gold mb-3 block">
						<?php echo esc_html( $step_num ); ?>
					</span>
					<h4 class="heading-step mb-2">
						<?php echo esc_html( $block['title'] ); ?>
					</h4>
					<p>
						<?php echo wp_kses_post( $block['content'] ); ?>
					</p>
				</div>
				<?php endforeach; ?>
			</div>

		</div><!-- .grid -->
	</div>
</section>
