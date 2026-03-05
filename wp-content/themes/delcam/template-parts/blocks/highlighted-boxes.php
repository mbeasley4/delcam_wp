<?php
/**
 * Block: Highlighted Boxes
 * White section with a section heading and a 3-column card grid.
 *
 * ACF Fields:
 *   section_label  (text)
 *   headline       (text)
 *   content        (textarea) — optional intro blurb
 *   highlights     (repeater)
 *     ↳ icon      (image)    — optional; falls back to positional SVG
 *     ↳ headline  (text)
 *     ↳ content   (textarea)
 *
 * @package DelCam_Capital
 */

$section_label = ! empty( get_field( 'section_label' ) ) ? get_field( 'section_label' ) : '// Why DelCam';
$headline      = ! empty( get_field( 'headline' ) ) ? get_field( 'headline' ) : 'THE DELCAM<br>DIFFERENCE.';
$content       = ! empty( get_field( 'content' ) ) ? get_field( 'content' ) : '';
$highlights    = ! empty( get_field( 'highlights' ) ) ? get_field( 'highlights' ) : array();

if ( empty( $highlights ) ) {
	$highlights = array(
		array(
			'icon'     => null,
			'headline' => 'Operator-Led',
			'content'  => 'Our partners have run manufacturing businesses — not just invested in them. We understand the shop floor, the customer relationships, and the operational levers that matter.',
		),
		array(
			'icon'     => null,
			'headline' => 'No Re-Trades',
			'content'  => 'Our LOI is our word. We price deals fairly upfront, conduct focused diligence, and close on the terms we agreed to. Every time.',
		),
		array(
			'icon'     => null,
			'headline' => 'Patient Capital',
			'content'  => 'We hold companies for the long term. Our investment horizon is aligned with building durable value — not engineering a quick exit.',
		),
		array(
			'icon'     => null,
			'headline' => 'Founder-Friendly',
			'content'  => 'We respect what you\'ve built. Rollover equity, management retention, and legacy preservation are core to how we structure every transaction.',
		),
		array(
			'icon'     => null,
			'headline' => 'Hands-On Support',
			'content'  => 'Post-close, our operating team is a resource, not a burden. We support where needed and step back where management thrives.',
		),
		array(
			'icon'     => null,
			'headline' => 'Sector Expertise',
			'content'  => 'Decades of experience in precision manufacturing give us an edge in diligence, integration, and identifying opportunities others miss.',
		),
	);
}

// Positional fallback SVG icons (stroke="var(--blue)").
$default_icons = array(
	'<svg width="22" height="22" fill="none" stroke="var(--blue)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="var(--blue)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="var(--blue)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="var(--blue)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="var(--blue)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>',
	'<svg width="22" height="22" fill="none" stroke="var(--blue)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
);
?>

<section class="py-28 px-6 lg:px-12 bg-white">
	<div class="max-w-7xl mx-auto">

		<!-- Section header -->
		<div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 gap-8">
			<div>
				<p class="section-label mb-4"><?php echo esc_html( $section_label ); ?></p>
				<h2 class="heading-display">
					<?php echo wp_kses_post( format_headline( $headline ) ); ?>
				</h2>
				<?php if ( ! empty( $content ) ) : ?>
				<div class="leading-relaxed text-mid">
					<?php echo $content; ?>
				</div>
			<?php endif; ?>
			</div>
		</div>

		<!-- Card grid -->
		<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
			<?php foreach ( $highlights as $i => $highlight ) : ?>
				<?php
				$icon = ! empty( $highlight['icon'] ) ? $highlight['icon'] : null;
				?>
				<div class="card p-8 rounded-xl">
					<div class="icon-circle mb-6">
						<?php if ( $icon ) : ?>
							<img src="<?php echo esc_url( $icon['url'] ); ?>" alt="<?php echo esc_attr( $icon['alt'] ); ?>" style="width:22px;height:22px;object-fit:contain;" />
						<?php else : ?>
							<?php echo wp_kses_post( $default_icons[ $i % count( $default_icons ) ] ); ?>
						<?php endif; ?>
					</div>
					<h3 class="heading-card mb-3">
						<?php echo esc_html( $highlight['headline'] ); ?>
					</h3>
					<div class="leading-relaxed text-mid">
						<?php echo $highlight['content']; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
