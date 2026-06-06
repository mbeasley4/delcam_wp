<?php
/**
 * Block: Content + 3 Feature Boxes (native Gutenberg — ACF image fields for icons)
 * Light section with a headline and intro text above three feature cards.
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * ACF Fields (per page, optional — for custom card icons):
 *   icon_1  (image)
 *   icon_2  (image)
 *   icon_3  (image)
 *
 * @package DelCam_Capital
 */

$headline     = $attributes['headline']     ?? 'HOW WE CREATE VALUE';
$main_content = $attributes['mainContent']  ?? '';

$blocks = array(
	array( 'headline' => $attributes['headline1'] ?? 'Growth Focus',      'content' => $attributes['content1'] ?? '' ),
	array( 'headline' => $attributes['headline2'] ?? 'Team Partnership',  'content' => $attributes['content2'] ?? '' ),
	array( 'headline' => $attributes['headline3'] ?? 'Innovation & Scale','content' => $attributes['content3'] ?? '' ),
);

$dark_bg    = (bool) ( $attributes['darkBackground'] ?? false );
$s          = delcam_scheme( $dark_bg );
$icon_stroke = $dark_bg ? 'var(--gold-light)' : 'var(--blue)';

$default_icons = array(
	'<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
);

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'content-3-blocks-section ' . $s['section_class'] ) );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>; padding:7rem 1.5rem;">

	<?php if ( $dark_bg ) : ?>
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute top-0 right-0 w-96 h-96 pointer-events-none glow-gold-lg" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto relative z-10">

		<!-- Section heading -->
		<div class="flex flex-col justify-between mb-16 gap-6">
			<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(2rem,5vw,3.5rem); line-height:1; color:<?php echo $s['heading']; ?>;">
				<?php echo wp_kses_post( format_headline( $headline ) ); ?>
			</h2>
			<?php if ( ! empty( $main_content ) ) : ?>
			<div style="color:<?php echo $s['text']; ?>; line-height:1.75;">
				<?php echo wp_kses_post( $main_content ); ?>
			</div>
			<?php endif; ?>
		</div>

		<!-- Feature boxes grid -->
		<div class="grid md:grid-cols-3 gap-6">
			<?php foreach ( $blocks as $i => $block ) : ?>
			<div class="<?php echo $s['card_class']; ?> p-8 rounded-xl"
				style="background:<?php echo $s['card_bg']; ?>; border:1px solid <?php echo $s['card_border']; ?>;"
				data-aos="fade-up" data-aos-duration="500" data-aos-delay="<?php echo esc_attr( $i * 100 ); ?>">

				<!-- Icon (positional SVG) -->
				<div class="icon-circle mb-6">
					<?php echo $default_icons[ $i % count( $default_icons ) ]; // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</div>

				<!-- Heading -->
				<h3 style="font-family:'Bebas Neue',cursive; font-size:1.35rem; letter-spacing:0.04em; color:<?php echo $s['heading']; ?>; margin-bottom:0.75rem;">
					<?php echo wp_kses_post( format_headline( $block['headline'] ) ); ?>
				</h3>

				<!-- Body -->
				<div style="font-size:0.875rem; line-height:1.75; color:<?php echo $s['text']; ?>;">
					<?php echo wp_kses_post( $block['content'] ); ?>
				</div>

			</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
