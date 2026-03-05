<?php
/**
 * Block: Investment Strategy
 * White section with section heading, gradient banner, and a 3×2 card grid
 * (up to 5 strategy cards + 1 CTA card).
 *
 * ACF Fields:
 *   section_label    (text)
 *   section_headline (text)
 *   description      (textarea)
 *   banner_badge     (text)      — badge label on the gradient banner
 *   banner_headline  (text)      — large text on the gradient banner
 *   strategy_cards   (repeater)
 *     ↳ title      (text)
 *     ↳ content    (textarea)
 *     ↳ link_text  (text)
 *     ↳ link_url   (url)
 *   cta_label    (text)
 *   cta_headline (text)
 *   cta_content  (textarea)
 *   cta_button   (link)
 *
 * @package DelCam_Capital
 */

$section_label    = ! empty( get_field( 'section_label' ) ) ? get_field( 'section_label' ) : '// Investment Focus';
$section_headline = ! empty( get_field( 'section_headline' ) ) ? get_field( 'section_headline' ) : 'OUR<br>STRATEGY';
$description      = ! empty( get_field( 'description' ) ) ? get_field( 'description' ) : 'We acquire and build leading precision manufacturing businesses — partnering with management teams to drive sustainable, long-term growth.';
$banner_badge     = ! empty( get_field( 'banner_badge' ) ) ? get_field( 'banner_badge' ) : 'PLATFORM STRATEGY';
$banner_headline  = ! empty( get_field( 'banner_headline' ) ) ? get_field( 'banner_headline' ) : 'Acquire. Operate. Grow.';
$strategy_cards   = ! empty( get_field( 'strategy_cards' ) ) ? get_field( 'strategy_cards' ) : array();
$cta_label        = ! empty( get_field( 'cta_label' ) ) ? get_field( 'cta_label' ) : 'SELL YOUR COMPANY';
$cta_headline     = ! empty( get_field( 'cta_headline' ) ) ? get_field( 'cta_headline' ) : 'Ready to explore a partnership?';
$cta_content      = ! empty( get_field( 'cta_content' ) ) ? get_field( 'cta_content' ) : 'We provide confidential, straightforward conversations for owners considering their next chapter.';
$cta_button       = ! empty( get_field( 'cta_button' ) ) ? get_field( 'cta_button' ) : '';

// Default strategy cards.
if ( empty( $strategy_cards ) ) {
	$strategy_cards = array(
		array(
			'title'     => 'Platform Acquisitions',
			'content'   => 'We target founder-owned precision manufacturers with $5M–$50M EBITDA, building regional and national platforms through add-on acquisitions.',
			'link_text' => 'Learn more',
			'link_url'  => '/strategy/',
			'icon'      => 'building',
		),
		array(
			'title'     => 'Operational Excellence',
			'content'   => 'Our operating partners embed within portfolio companies to implement lean manufacturing, ERP systems, and workforce development programs.',
			'link_text' => 'Learn more',
			'link_url'  => '/strategy/',
			'icon'      => 'chart',
		),
		array(
			'title'     => 'Management Partnerships',
			'content'   => 'We back strong management teams with meaningful equity, aligning incentives for long-term value creation alongside our capital.',
			'link_text' => 'Learn more',
			'link_url'  => '/strategy/',
			'icon'      => 'team',
		),
		array(
			'title'     => 'Technology Modernization',
			'content'   => 'Capital investment in advanced CNC, robotics, and automation to increase throughput, reduce costs, and capture higher-value work.',
			'link_text' => 'Learn more',
			'link_url'  => '/strategy/',
			'icon'      => 'tech',
		),
		array(
			'title'     => 'Geographic Expansion',
			'content'   => 'Building regional density in key manufacturing corridors to share back-office resources, purchasing leverage, and customer relationships.',
			'link_text' => 'Learn more',
			'link_url'  => '/strategy/',
			'icon'      => 'globe',
		),
	);
}

// Icon SVG map (keyed by ACF icon field value or default position).
$icons      = array(
	'building' => '<svg width="22" height="22" fill="none" stroke="var(--blue)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
	'chart'    => '<svg width="22" height="22" fill="none" stroke="var(--blue)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>',
	'team'     => '<svg width="22" height="22" fill="none" stroke="var(--blue)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
	'tech'     => '<svg width="22" height="22" fill="none" stroke="var(--blue)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>',
	'globe'    => '<svg width="22" height="22" fill="none" stroke="var(--blue)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
);
$icon_order = array( 'building', 'chart', 'team', 'tech', 'globe' );
?>

<section class="py-28 px-6 lg:px-12 bg-white">
	<div class="max-w-7xl mx-auto">

		<!-- Section heading -->
		<div class="flex flex-col lg:flex-row lg:items-end justify-between mb-10 gap-8">
			<div>
				<p class="section-label mb-4"><?php echo esc_html( $section_label ); ?></p>
				<h2 class="heading-display">
					<?php echo wp_kses_post( format_headline( $section_headline ) ); ?>
				</h2>
			</div>
			<p class="text-sm max-w-xs leading-relaxed text-mid">
				<?php echo esc_html( $description ); ?>
			</p>
		</div>

		<!-- Strategy gradient banner -->
		<div class="strategy-banner rounded-2xl overflow-hidden mb-12 relative bg-gradient-dark">
			<div class="absolute inset-0 pointer-events-none grid-overlay-white"></div>
			<div class="absolute inset-0 flex items-end p-8 strategy-banner-overlay">
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

		<!-- Card grid -->
		<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">

			<?php
			foreach ( $strategy_cards as $i => $card ) :
				// Pick icon: use ACF 'icon' subfield if set, otherwise fall back to positional icon.
				$icon_key  = ! empty( $card['icon'] ) ? $card['icon'] : ( $icon_order[ $i ] ?? 'building' );
				$icon_svg  = $icons[ $icon_key ] ?? $icons['building'];
				$link_text = ! empty( $card['link_text'] ) ? $card['link_text'] : 'Learn more';
				$link_url  = ! empty( $card['link_url'] ) ? $card['link_url'] : '/strategy/';
				?>
			<div class="card p-8 rounded-xl">
				<div class="icon-circle mb-6">
					<?php echo wp_kses_post( $icon_svg ); ?>
				</div>
				<h3 class="heading-card mb-3">
					<?php echo esc_html( $card['title'] ); ?>
				</h3>
				<p class="text-sm leading-relaxed mb-6 text-mid">
					<?php echo esc_html( $card['content'] ); ?>
				</p>
				<a href="<?php echo esc_url( $link_url ); ?>" class="card-link-mono">
					<?php echo esc_html( $link_text ); ?> &rarr;
				</a>
			</div>
			<?php endforeach; ?>

			<!-- CTA Card -->
			<div class="bg-gradient-dark p-8 rounded-xl flex flex-col justify-between">
				<div>
					<p class="mono-label-dim mb-3">
						<?php echo esc_html( $cta_label ); ?>
					</p>
					<h3 class="heading-card-dark mb-4">
						<?php echo esc_html( $cta_headline ); ?>
					</h3>
					<p class="text-sm text-white leading-relaxed opacity-75">
						<?php echo esc_html( $cta_content ); ?>
					</p>
				</div>
				<?php if ( ! empty( $cta_button ) ) : ?>
					<a href="<?php echo esc_url( $cta_button['url'] ); ?>"
						class="btn-gold mt-8 text-xs px-6 py-3 rounded-md inline-block text-center"
						<?php echo $cta_button['target'] ? 'target="' . esc_attr( $cta_button['target'] ) . '"' : ''; ?>>
						<?php echo esc_html( $cta_button['title'] ); ?> &rarr;
					</a>
				<?php else : ?>
					<a href="/contact/" class="btn-gold mt-8 text-xs px-6 py-3 rounded-md inline-block text-center">
						Start a Conversation &rarr;
					</a>
				<?php endif; ?>
			</div>

		</div><!-- .grid -->
	</div>
</section>
