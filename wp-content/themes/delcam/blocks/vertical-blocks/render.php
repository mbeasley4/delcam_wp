<?php
/**
 * Block: Content + Vertical Blocks (native Gutenberg — ACF repeater for steps)
 * Dark navy section with a headline and countdown inset on the left
 * and numbered process steps on the right.
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * ACF Fields (per page):
 *   vertical_blocks  (repeater)
 *     ↳ title   (text)
 *     ↳ content (textarea)
 *
 * @package DelCam_Capital
 */

$section_label    = $attributes['sectionLabel']    ?? '// Our Approach';
$headline         = $attributes['headline']        ?? "FROM FIRST CALL\nTO CLOSE.";
$content          = $attributes['content']         ?? '';
$countdown_number = $attributes['countdownNumber'] ?? '60–90';
$countdown_label  = $attributes['countdownLabel']  ?? 'DAYS TO CLOSE';

$vertical_blocks = ! empty( $attributes['verticalBlocks'] ) && is_array( $attributes['verticalBlocks'] )
	? $attributes['verticalBlocks']
	: array(
		array( 'title' => 'Introductory Conversation', 'content' => "A confidential, no-pressure discussion about your business, your goals, and whether we're the right fit. We listen first." ),
		array( 'title' => 'Indication of Interest',    'content' => 'A non-binding letter outlining valuation range and deal structure within 2–3 weeks of receiving financials. No delays, no games.' ),
		array( 'title' => 'Diligence & LOI',           'content' => 'Focused, efficient due diligence with a dedicated team. We aim to be respectful of your time and management bandwidth.' ),
		array( 'title' => 'Close & Partnership',       'content' => 'We close on time, every time. Day one begins a partnership built on trust, transparency, and shared upside.' ),
	);

$dark_bg = (bool) ( $attributes['darkBackground'] ?? true );
$s       = delcam_scheme( $dark_bg );

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'vertical-blocks-section ' . $s['section_class'] . ' relative overflow-hidden' ) );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>; padding:7rem 1.5rem;">

	<?php if ( $dark_bg ) : ?>
	<!-- Grid overlay -->
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<!-- Ambient glow -->
	<div class="absolute right-0 top-0 w-96 h-96 pointer-events-none glow-gold" aria-hidden="true"></div>
	<?php else : ?>
	<!-- Light mode subtle texture -->
	<div class="absolute inset-0 pointer-events-none" aria-hidden="true"
		style="background-image:linear-gradient(rgba(30,95,168,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(30,95,168,0.04) 1px,transparent 1px);background-size:56px 56px;"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto relative z-10">
		<div class="grid lg:grid-cols-5 gap-10 lg:gap-14 items-stretch">

			<!-- Left: tall image with countdown badge overlaid -->
			<div class="lg:col-span-2 rounded-2xl overflow-hidden relative fade-up d2" style="min-height:520px;">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/images/strategy-facility.jpg' ); ?>"
					 alt="DelCam Capital — deal process"
					 class="absolute inset-0 w-full h-full object-cover object-center"
					 loading="lazy">
				<!-- dark gradient: heavier at bottom for badge legibility -->
				<div class="absolute inset-0" style="background:linear-gradient(to top, rgba(10,30,53,0.97) 0%, rgba(10,30,53,0.55) 45%, rgba(10,30,53,0.18) 100%);"></div>
				<div class="absolute inset-0 pointer-events-none grid-overlay-white" aria-hidden="true"></div>

				<!-- Countdown badge -->
				<div class="absolute inset-x-0 bottom-0 p-8">
					<div class="inline-block rounded-xl px-6 py-5" style="background:rgba(10,30,53,0.7); border:1px solid rgba(200,146,42,0.3); backdrop-filter:blur(8px);">
						<div style="font-family:'Bebas Neue',cursive; font-size:3rem; color:var(--gold-light); line-height:1;">
							<?php echo esc_html( $countdown_number ); ?>
						</div>
						<div style="font-family:'JetBrains Mono',monospace; font-size:0.68rem; letter-spacing:0.2em; color:rgba(255,255,255,0.5); margin-top:2px;">
							<?php echo esc_html( $countdown_label ); ?>
						</div>
					</div>
				</div>
			</div>

			<!-- Right: section header + all process steps -->
			<div class="lg:col-span-3 flex flex-col justify-center gap-10">

				<!-- Header -->
				<div>
					<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; border-left:2px solid <?php echo $s['label_border']; ?>; padding-left:0.75rem; margin-bottom:1.25rem;" class="fade-up d1">
						<?php echo esc_html( $section_label ); ?>
					</p>
					<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(2.5rem,5vw,4rem); line-height:0.95; color:<?php echo $s['heading']; ?>; margin-bottom:<?php echo ! empty( $content ) ? '1.25rem' : '0'; ?>;" class="fade-up d2">
						<?php echo wp_kses_post( format_headline( nl2br( $headline ) ) ); ?>
					</h2>
					<?php if ( ! empty( $content ) ) : ?>
					<p style="font-size:0.875rem; line-height:1.75; color:<?php echo $s['text']; ?>; max-width:38ch;" class="fade-up d3">
						<?php echo wp_kses_post( $content ); ?>
					</p>
					<?php endif; ?>
				</div>

				<!-- Process steps — left-border timeline style -->
				<div class="flex flex-col">
					<?php foreach ( $vertical_blocks as $i => $step ) :
						$is_last = ( $i === count( $vertical_blocks ) - 1 );
					?>
					<div class="fade-up" style="padding-left:2rem; border-left:2px solid rgba(200,146,42,0.25); <?php echo $is_last ? '' : 'padding-bottom:2rem;'; ?>"
						data-aos="fade-up" data-aos-duration="400" data-aos-delay="<?php echo esc_attr( $i * 80 ); ?>">
						<span style="font-family:'JetBrains Mono',monospace; font-size:0.7rem; letter-spacing:0.12em; color:var(--gold); display:block; margin-bottom:0.4rem;">
							<?php echo esc_html( str_pad( $i + 1, 2, '0', STR_PAD_LEFT ) ); ?>
						</span>
						<h4 style="font-family:'Bebas Neue',cursive; font-size:1.3rem; letter-spacing:0.04em; color:<?php echo $s['heading']; ?>; margin-bottom:0.4rem;">
							<?php echo esc_html( $step['title'] ); ?>
						</h4>
						<p style="font-size:0.875rem; line-height:1.7; color:<?php echo $s['text']; ?>;">
							<?php echo wp_kses_post( $step['content'] ); ?>
						</p>
					</div>
					<?php endforeach; ?>
				</div>

			</div><!-- /right -->

		</div><!-- .grid -->
	</div>
</section>
