<?php
/**
 * Block: Content + Image (native Gutenberg — no ACF required)
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * @package DelCam_Capital
 */

$section_label = $attributes['sectionLabel'] ?? '// Our Story';
$headline      = $attributes['headline']     ?? 'BUILT BY<br>OPERATORS.';
$body_content  = $attributes['bodyContent']  ?? '<p>DelCam Capital partners with founders and management teams to build enduring precision manufacturing businesses.</p>';
$image_url     = $attributes['imageUrl']     ?? '';
$image_alt     = $attributes['imageAlt']     ?? '';
$swap_image    = $attributes['swapImage']    ?? false;
$cta_label     = $attributes['ctaLabel']     ?? '';
$cta_url       = $attributes['ctaUrl']       ?? '';
$cta_target    = ! empty( $attributes['ctaTarget'] ) ? ' target="' . esc_attr( $attributes['ctaTarget'] ) . '"' : '';

// true = image on left (natural row order); false = image on right (reversed).
$reverse_class = ! $swap_image ? 'lg:flex-row-reverse' : '';

$dark_bg = (bool) ( $attributes['darkBackground'] ?? false );
$s       = delcam_scheme( $dark_bg );

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => $s['section_class'],
] );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>; padding:7rem 1.5rem; position:relative; overflow:hidden;">

	<?php if ( $dark_bg ) : ?>
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute bottom-0 left-0 w-96 h-96 pointer-events-none glow-gold-lg" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto relative z-10">
		<div class="flex flex-col lg:flex-row <?php echo esc_attr( $reverse_class ); ?> gap-16 lg:gap-24 items-center">

			<!-- Image column (first in DOM = top on mobile) -->
			<div class="flex-1 relative">
				<?php if ( $image_url ) : ?>
					<img
						src="<?php echo esc_url( $image_url ); ?>"
						alt="<?php echo esc_attr( $image_alt ); ?>"
						class="w-full rounded-2xl object-cover aspect-[4/3]"
						style="box-shadow:0 24px 60px rgba(0,0,0,0.18);"
					/>
					<div class="absolute -bottom-4 -right-4 w-32 h-32 rounded-2xl -z-10 pointer-events-none"
						style="background:linear-gradient(135deg,var(--sky),var(--accent)); opacity:0.15;"></div>
				<?php else : ?>
					<div class="w-full aspect-[4/3] rounded-2xl flex items-center justify-center"
						style="background:<?php echo $s['card_bg']; ?>; border:1px solid <?php echo $s['card_border']; ?>;">
						<span style="font-family:'JetBrains Mono',monospace; font-size:0.75rem; color:<?php echo $s['text_muted']; ?>;">[ Image ]</span>
					</div>
				<?php endif; ?>
			</div>

			<!-- Content column -->
			<div class="flex-1">
				<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; border-left:2px solid <?php echo $s['label_border']; ?>; padding-left:0.75rem; margin-bottom:1.25rem;">
					<?php echo esc_html( $section_label ); ?>
				</p>
				<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(2.25rem,5vw,3.75rem); line-height:1; color:<?php echo $s['heading']; ?>; margin-bottom:1.5rem;">
					<?php echo wp_kses_post( format_headline( $headline ) ); ?>
				</h2>
				<div style="color:<?php echo $s['text']; ?>; line-height:1.75; margin-bottom:2rem;">
					<?php echo wp_kses_post( $body_content ); ?>
				</div>
				<?php if ( $cta_label && $cta_url ) : ?>
					<a href="<?php echo esc_url( $cta_url ); ?>"
						class="<?php echo $s['btn_primary']; ?> text-sm px-10 py-4 rounded-md inline-block"
						<?php echo $cta_target; ?>>
						<?php echo esc_html( $cta_label ); ?> &rarr;
					</a>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>
