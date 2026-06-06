<?php
/**
 * Block: Investment Strategy (native Gutenberg — ACF repeater for strategy cards)
 * Two-column intro (text + tall photo) above a strategy card grid.
 *
 * @package DelCam_Capital
 */

$section_label    = $attributes['sectionLabel']    ?? '// Investment Focus';
$section_headline = $attributes['sectionHeadline'] ?? "OUR\nSTRATEGY";
$description      = $attributes['description']     ?? '';
$banner_badge     = $attributes['bannerBadge']     ?? 'PLATFORM STRATEGY';
$banner_headline  = $attributes['bannerHeadline']  ?? 'Acquire. Operate. Grow.';
$cta_label        = $attributes['ctaLabel']        ?? 'SELL YOUR COMPANY';
$cta_headline     = $attributes['ctaHeadline']     ?? 'Ready to explore a partnership?';
$cta_content      = $attributes['ctaContent']      ?? '';
$cta_button_text  = $attributes['ctaButtonText']   ?? 'Start a Conversation';
$cta_button_url   = $attributes['ctaButtonUrl']    ?? '/contact/';

$strategy_cards = ! empty( $attributes['strategyCards'] ) && is_array( $attributes['strategyCards'] )
	? $attributes['strategyCards']
	: array(
		array( 'title' => 'Platform Acquisitions',    'content' => 'We target founder-owned precision manufacturers with $5M–$50M EBITDA, building regional and national platforms through add-on acquisitions.',       'icon' => 'building', 'link_text' => 'Learn more', 'link_url' => '/strategy/' ),
		array( 'title' => 'Operational Excellence',   'content' => 'Our operating partners embed within portfolio companies to implement lean manufacturing, ERP systems, and workforce development programs.',          'icon' => 'chart',    'link_text' => 'Learn more', 'link_url' => '/strategy/' ),
		array( 'title' => 'Management Partnerships',  'content' => 'We back strong management teams with meaningful equity, aligning incentives for long-term value creation alongside our capital.',                    'icon' => 'team',     'link_text' => 'Learn more', 'link_url' => '/strategy/' ),
		array( 'title' => 'Technology Modernization', 'content' => 'Capital investment in advanced CNC, robotics, and automation to increase throughput, reduce costs, and capture higher-value work.',                  'icon' => 'tech',     'link_text' => 'Learn more', 'link_url' => '/strategy/' ),
		array( 'title' => 'Geographic Expansion',     'content' => 'Building regional density in key manufacturing corridors to share back-office resources, purchasing leverage, and customer relationships.',          'icon' => 'globe',    'link_text' => 'Learn more', 'link_url' => '/strategy/' ),
	);

$dark_bg = (bool) ( $attributes['darkBackground'] ?? false );
$s       = delcam_scheme( $dark_bg );

$icon_stroke       = $dark_bg ? 'var(--gold-light)' : 'var(--blue)';
$icon_circle_style = 'background:' . $s['pill_bg'] . '; border:1px solid ' . $s['pill_border'] . '; width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center;';

$icons = array(
	'building' => '<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
	'chart'    => '<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>',
	'team'     => '<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
	'tech'     => '<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>',
	'globe'    => '<svg width="22" height="22" fill="none" stroke="' . $icon_stroke . '" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
);
$icon_order = array( 'building', 'chart', 'team', 'tech', 'globe' );

$img_url  = get_template_directory_uri() . '/images/';
$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'investment-strategy-section ' . $s['section_class'] ) );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>; padding:7rem 1.5rem; position:relative; overflow:hidden;">

	<?php if ( $dark_bg ) : ?>
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute top-0 right-0 w-96 h-96 pointer-events-none glow-gold-lg" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto relative z-10">

		<!-- ── Intro: header row ── -->
		<div class="flex flex-col lg:flex-row lg:items-end justify-between mb-10 gap-8">
			<div>
				<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; border-left:2px solid <?php echo $s['label_border']; ?>; padding-left:0.75rem; margin-bottom:1.25rem;" class="fade-up d1">
					<?php echo esc_html( $section_label ); ?>
				</p>
				<h2 class="fade-up d2" style="font-family:'Bebas Neue',cursive; font-size:clamp(3rem,7vw,5.5rem); line-height:0.93; color:<?php echo $s['heading']; ?>;">
					<?php echo wp_kses_post( format_headline( nl2br( $section_headline ) ) ); ?>
				</h2>
			</div>
			<?php if ( ! empty( $description ) ) : ?>
			<p class="fade-up d3" style="font-size:0.875rem; line-height:1.75; color:<?php echo $s['text']; ?>; max-width:30ch;">
				<?php echo esc_html( $description ); ?>
			</p>
			<?php endif; ?>
		</div>

		<!-- ── Wide banner image ── -->
		<div class="rounded-2xl overflow-hidden relative mb-12 fade-up d4" style="height:280px;">
			<img src="<?php echo esc_url( $img_url . 'strategy-engineer.jpg' ); ?>"
				 alt="Manufacturing engineering"
				 class="absolute inset-0 w-full h-full object-cover object-center"
				 loading="lazy">
			<div class="absolute inset-0" style="background:linear-gradient(to right, rgba(10,30,53,0.88) 0%, rgba(10,30,53,0.4) 60%, rgba(10,30,53,0.1) 100%);"></div>
			<div class="absolute inset-0 pointer-events-none grid-overlay-white" aria-hidden="true"></div>
			<div class="absolute inset-0 flex items-end p-8">
				<div>
					<span class="badge px-3 py-1.5 rounded text-xs mb-3 inline-block">
						<?php echo esc_html( $banner_badge ); ?>
					</span>
					<p class="heading-card-dark">
						<?php echo esc_html( $banner_headline ); ?>
					</p>
				</div>
			</div>
		</div>

		<!-- ── Strategy card grid ── -->
		<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">

			<?php foreach ( $strategy_cards as $i => $card ) :
				$icon_key  = ! empty( $card['icon'] ) ? $card['icon'] : ( $icon_order[ $i ] ?? 'building' );
				$icon_svg  = $icons[ $icon_key ] ?? $icons['building'];
				$link_text = ! empty( $card['link_text'] ) ? $card['link_text'] : 'Learn more';
				$link_url  = ! empty( $card['link_url'] )  ? $card['link_url']  : '/strategy/';
			?>
			<div class="<?php echo $s['card_class']; ?> p-8 rounded-xl"
				style="background:<?php echo $s['card_bg']; ?>; border:1px solid <?php echo $s['card_border']; ?>;"
				data-aos="fade-up" data-aos-duration="500" data-aos-delay="<?php echo esc_attr( ( $i % 3 ) * 100 ); ?>">
				<div style="<?php echo $icon_circle_style; ?>" class="mb-6">
					<?php echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput -- hardcoded SVG map, not user input ?>
				</div>
				<h3 style="font-family:'Bebas Neue',cursive; font-size:1.35rem; letter-spacing:0.04em; color:<?php echo $s['heading']; ?>; margin-bottom:0.75rem;">
					<?php echo esc_html( $card['title'] ); ?>
				</h3>
				<p style="font-size:0.875rem; line-height:1.75; color:<?php echo $s['text']; ?>; margin-bottom:1.5rem;">
					<?php echo esc_html( $card['content'] ); ?>
				</p>
				<a href="<?php echo esc_url( $link_url ); ?>"
					style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.1em; text-transform:uppercase; color:<?php echo $s['label']; ?>; text-decoration:none;">
					<?php echo esc_html( $link_text ); ?> &rarr;
				</a>
			</div>
			<?php endforeach; ?>

			<!-- CTA Card -->
			<div class="bg-gradient-dark p-8 rounded-xl flex flex-col justify-between"
				data-aos="fade-up" data-aos-duration="500" data-aos-delay="<?php echo esc_attr( ( count( $strategy_cards ) % 3 ) * 100 ); ?>">
				<div>
					<div style="background:rgba(200,146,42,0.15); border:1px solid rgba(200,146,42,0.3); width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center;" class="mb-6">
						<svg width="22" height="22" fill="none" stroke="var(--gold-light)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
					</div>
					<p class="mono-label-dim mb-3"><?php echo esc_html( $cta_label ); ?></p>
					<h3 class="heading-card-dark mb-4"><?php echo esc_html( $cta_headline ); ?></h3>
					<p class="text-sm text-white leading-relaxed opacity-75">
						<?php echo esc_html( $cta_content ); ?>
					</p>
				</div>
				<a href="<?php echo esc_url( $cta_button_url ); ?>"
					class="btn-gold mt-8 text-xs px-6 py-3 rounded-md inline-block text-center">
					<?php echo esc_html( $cta_button_text ); ?> &rarr;
				</a>
			</div>

		</div><!-- /card grid -->

	</div>
</section>
