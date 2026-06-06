<?php
/**
 * Block: Large Text Callout (native Gutenberg — no ACF required)
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused — no InnerBlocks)
 *   $block       (WP_Block) — the block instance
 *
 * @package DelCam_Capital
 */

$eyebrow     = $attributes['sectionLabel'] ?? '// FOR BUSINESS OWNERS';
$callout     = $attributes['callout']      ?? 'IS IT TIME<br>TO TALK?';
$subtext     = $attributes['subtext']      ?? "Whether you're thinking about retirement, bringing on a growth partner, or just exploring options — we're a straightforward call. Confidential and obligation-free.";
$btn1_label  = $attributes['button1Label']  ?? 'Schedule a Conversation';
$btn1_url    = $attributes['button1Url']    ?? '/contact/';
$btn1_target = ! empty( $attributes['button1Target'] ) ? ' target="' . esc_attr( $attributes['button1Target'] ) . '"' : '';
$btn2_label  = $attributes['button2Label']  ?? 'View Our Portfolio';
$btn2_url    = $attributes['button2Url']    ?? '/portfolio/';
$btn2_target = ! empty( $attributes['button2Target'] ) ? ' target="' . esc_attr( $attributes['button2Target'] ) . '"' : '';

$dark_bg = (bool) ( $attributes['darkBackground'] ?? true );
$s       = delcam_scheme( $dark_bg );

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => $s['section_class'] . ' relative overflow-hidden',
] );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>; padding:6rem 1.5rem;">

	<?php if ( $dark_bg ) : ?>
	<!-- Background gradient overlay -->
	<div class="absolute inset-0 callout-overlay" aria-hidden="true"></div>
	<!-- Grid overlay -->
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<!-- Ambient glow -->
	<div class="absolute top-0 right-0 w-96 h-96 pointer-events-none glow-gold-lg" aria-hidden="true"></div>
	<?php else : ?>
	<!-- Light accent bar -->
	<div class="absolute top-0 left-0 right-0 h-1 pointer-events-none" aria-hidden="true"
		style="background:linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 50%, transparent 100%);"></div>
	<!-- Subtle background shape -->
	<div class="absolute bottom-0 right-0 w-[500px] h-[500px] pointer-events-none" aria-hidden="true"
		style="background:radial-gradient(circle at 70% 80%, rgba(30,95,168,0.06) 0%, transparent 70%);"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto relative z-10 text-center">

		<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; margin-bottom:1.5rem; border-left:2px solid <?php echo $s['label_border']; ?>; display:inline-block; padding-left:0.75rem;">
			<?php echo esc_html( $eyebrow ); ?>
		</p>

		<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(3rem,8vw,6rem); line-height:0.95; letter-spacing:0.02em; color:<?php echo $s['heading']; ?>; margin-bottom:1.5rem;">
			<?php echo wp_kses_post( $callout ); ?>
		</h2>

		<p style="max-width:36rem; margin:0 auto 2.5rem; line-height:1.75; color:<?php echo $s['text']; ?>;">
			<?php echo esc_html( $subtext ); ?>
		</p>

		<div class="flex flex-col sm:flex-row gap-4 justify-center">

			<a href="<?php echo esc_url( $btn1_url ); ?>"
				class="<?php echo $s['btn_primary']; ?> inline-block text-sm px-10 py-4 rounded-md"
				<?php echo $btn1_target; ?>>
				<?php echo esc_html( $btn1_label ); ?>
			</a>

			<a href="<?php echo esc_url( $btn2_url ); ?>"
				class="<?php echo $s['btn_secondary']; ?> inline-block text-sm px-10 py-4 rounded-md"
				<?php echo $btn2_target; ?>>
				<?php echo esc_html( $btn2_label ); ?>
			</a>

		</div>
	</div>
</section>
