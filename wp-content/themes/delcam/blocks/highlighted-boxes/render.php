<?php
/**
 * Block: Highlighted Boxes (native Gutenberg — ACF repeater for highlights)
 * White section with a heading and a 3-column card grid.
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * ACF Fields (per page):
 *   highlights  (repeater)
 *     ↳ icon     (image)    — optional; falls back to positional SVG
 *     ↳ headline (text)
 *     ↳ content  (textarea)
 *
 * @package DelCam_Capital
 */

$section_label = $attributes['sectionLabel'] ?? '// Why DelCam';
$headline      = $attributes['headline']     ?? "THE DELCAM\nDIFFERENCE.";
$intro_content = $attributes['content']      ?? '';

$highlights = ! empty( $attributes['highlights'] ) && is_array( $attributes['highlights'] )
	? $attributes['highlights']
	: array(
		array( 'headline' => 'Operator-Led',     'content' => 'Our partners have run manufacturing businesses — not just invested in them. We understand the shop floor, the customer relationships, and the operational levers that matter.' ),
		array( 'headline' => 'No Re-Trades',     'content' => 'Our LOI is our word. We price deals fairly upfront, conduct focused diligence, and close on the terms we agreed to. Every time.' ),
		array( 'headline' => 'Patient Capital',  'content' => 'We hold companies for the long term. Our investment horizon is aligned with building durable value — not engineering a quick exit.' ),
		array( 'headline' => 'Founder-Friendly', 'content' => "We respect what you've built. Rollover equity, management retention, and legacy preservation are core to how we structure every transaction." ),
		array( 'headline' => 'Hands-On Support', 'content' => 'Post-close, our operating team is a resource, not a burden. We support where needed and step back where management thrives.' ),
		array( 'headline' => 'Sector Expertise', 'content' => 'Decades of experience in precision manufacturing give us an edge in diligence, integration, and identifying opportunities others miss.' ),
	);

$dark_bg = (bool) ( $attributes['darkBackground'] ?? false );
$s       = delcam_scheme( $dark_bg );

// SVG icon stroke adapts to scheme.
$icon_stroke   = $dark_bg ? 'var(--gold-light)' : 'var(--blue)';
$icon_circle_style = 'background:' . $s['pill_bg'] . '; border:1px solid ' . $s['pill_border'] . '; width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center;';

// Positional fallback SVG icons.
$default_icons = array(
	'<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
);

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'highlighted-boxes-section ' . $s['section_class'] ) );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>; padding:7rem 1.5rem; position:relative; overflow:hidden;">

	<?php if ( $dark_bg ) : ?>
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute top-0 right-0 w-96 h-96 pointer-events-none glow-gold-lg" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto relative z-10">

		<!-- Section header -->
		<div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 gap-8">
			<div>
				<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; border-left:2px solid <?php echo $s['label_border']; ?>; padding-left:0.75rem; margin-bottom:1.25rem;">
					<?php echo esc_html( $section_label ); ?>
				</p>
				<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(2.5rem,6vw,4.5rem); line-height:0.95; color:<?php echo $s['heading']; ?>;">
					<?php echo wp_kses_post( format_headline( nl2br( $headline ) ) ); ?>
				</h2>
				<?php if ( ! empty( $intro_content ) ) : ?>
				<div style="color:<?php echo $s['text']; ?>; line-height:1.75; margin-top:1rem;">
					<?php echo wp_kses_post( $intro_content ); ?>
				</div>
				<?php endif; ?>
			</div>
		</div>

		<!-- Card grid -->
		<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
			<?php foreach ( $highlights as $i => $highlight ) : ?>
			<div class="<?php echo $s['card_class']; ?> p-8 rounded-xl"
				style="background:<?php echo $s['card_bg']; ?>; border:1px solid <?php echo $s['card_border']; ?>;"
				data-aos="fade-up" data-aos-duration="500" data-aos-delay="<?php echo esc_attr( ( $i % 3 ) * 100 ); ?>">

				<div style="<?php echo $icon_circle_style; ?>" class="mb-6">
					<?php echo $default_icons[ $i % count( $default_icons ) ]; // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</div>

				<h3 style="font-family:'Bebas Neue',cursive; font-size:1.35rem; letter-spacing:0.04em; color:<?php echo $s['heading']; ?>; margin-bottom:0.75rem;">
					<?php echo esc_html( $highlight['headline'] ); ?>
				</h3>

				<div style="font-size:0.875rem; line-height:1.75; color:<?php echo $s['text']; ?>;">
					<?php echo wp_kses_post( $highlight['content'] ); ?>
				</div>

			</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
