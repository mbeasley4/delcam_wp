<?php
/**
 * Block: Homepage Hero (native Gutenberg — ACF repeater for stat cards)
 * Full-width hero with headline, subhead, two CTAs, and a 2x2 stat card grid.
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * ACF Fields (per page):
 *   stat_cards  (repeater)
 *     ↳ stat_value       (text)
 *     ↳ is_gold          (true/false)
 *     ↳ stat_label       (text)
 *     ↳ stat_description (text)
 *
 * @package DelCam_Capital
 */

$section_label = $attributes['sectionLabel'] ?? '// Private Equity';
$headline      = $attributes['headline']     ?? "Building Enduring\nManufacturing Value.";
$subhead       = $attributes['subhead']      ?? '';
$button_1_text = $attributes['button1Text']  ?? 'Our Strategy';
$button_1_url  = $attributes['button1Url']   ?? '/strategy/';
$button_2_text = $attributes['button2Text']  ?? 'View Portfolio';
$button_2_url  = $attributes['button2Url']   ?? '/portfolio/';

$stat_cards = ! empty( $attributes['statCards'] ) && is_array( $attributes['statCards'] )
	? $attributes['statCards']
	: array(
		array( 'stat_value' => '$2B+',  'is_gold' => true,  'stat_label' => 'Assets Under Management', 'stat_description' => 'Deployed across platform companies' ),
		array( 'stat_value' => '30+',   'is_gold' => false, 'stat_label' => 'Portfolio Companies',     'stat_description' => 'Precision manufacturing focus' ),
		array( 'stat_value' => '25+',   'is_gold' => false, 'stat_label' => 'Years of Experience',     'stat_description' => 'Investing in manufacturing since 1998' ),
		array( 'stat_value' => '100%',  'is_gold' => false, 'stat_label' => 'Made in America',         'stat_description' => 'Domestic manufacturing portfolio' ),
	);

$dark_bg = (bool) ( $attributes['darkBackground'] ?? false );
$s       = delcam_scheme( $dark_bg );

$hero_class = $dark_bg
	? 'homepage-hero section-dark relative flex items-center overflow-hidden'
	: 'homepage-hero hero-bg hero-grid relative flex items-center overflow-hidden';

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => $hero_class ) );
?>

<section <?php echo $wrapper_attrs; ?> style="<?php echo $dark_bg ? 'background:var(--navy);' : ''; ?> max-height:75vh; min-height:480px;">

	<?php if ( $dark_bg ) : ?>
	<!-- Dark mode overlays -->
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute right-0 top-0 w-96 h-96 pointer-events-none glow-gold-lg" aria-hidden="true"></div>
	<?php else : ?>
	<!-- Light mode ambient glow -->
	<div class="absolute right-0 top-1/4 w-96 h-96 rounded-full pointer-events-none" aria-hidden="true"
		style="background:radial-gradient(circle, rgba(200,146,42,0.1) 0%, transparent 70%); filter:blur(60px);"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto px-6 lg:px-12 w-full py-12">
		<div class="grid lg:grid-cols-2 gap-16 items-center">

			<!-- Left: Text + CTAs -->
			<div>
				<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; border-left:2px solid <?php echo $s['label_border']; ?>; padding-left:0.75rem; margin-bottom:1.25rem;" class="fade-up d1">
					<?php echo esc_html( $section_label ); ?>
				</p>

				<h1 class="mb-4 fade-up d2"
					style="font-family:'Bebas Neue',cursive; font-size:clamp(2.8rem,7vw,6rem); color:<?php echo $s['heading']; ?>; line-height:0.95;">
					<?php echo wp_kses_post( format_headline( nl2br( $headline ) ) ); ?>
				</h1>

				<h2 class="mb-8 fade-up d3"
					style="font-size:clamp(1rem,2vw,1.25rem); font-weight:400; color:<?php echo $s['text']; ?>; line-height:1.5;">
					<?php echo esc_html( $subhead ); ?>
				</h2>

				<div class="flex gap-4 flex-wrap fade-up d4">
					<a href="<?php echo esc_url( $button_1_url ); ?>"
						class="<?php echo $s['btn_primary']; ?> px-8 py-3.5 rounded-md text-sm inline-block">
						<?php echo esc_html( $button_1_text ); ?>
					</a>
					<a href="<?php echo esc_url( $button_2_url ); ?>"
						class="<?php echo $s['btn_secondary']; ?> px-8 py-3.5 rounded-md text-sm inline-block">
						<?php echo esc_html( $button_2_text ); ?>
					</a>
				</div>
			</div>

			<!-- Right: 2×2 stat card grid -->
			<div class="grid grid-cols-2 gap-4">
				<?php foreach ( $stat_cards as $i => $card ) :
					$is_gold = ! empty( $card['is_gold'] );
				?>
				<div class="<?php echo $s['card_class']; ?> <?php echo $is_gold ? 'card-gold' : ''; ?> p-6 rounded-xl"
					style="background:<?php echo $s['card_bg']; ?>; border:1px solid <?php echo $is_gold ? 'rgba(200,146,42,0.35)' : $s['card_border']; ?>;"
					data-aos="fade-up" data-aos-duration="500" data-aos-delay="<?php echo esc_attr( $i * 80 ); ?>">
					<div style="font-family:'Bebas Neue',cursive; font-size:2.25rem; line-height:1; color:<?php echo $is_gold ? 'var(--gold)' : $s['heading']; ?>;">
						<?php echo esc_html( $card['stat_value'] ); ?>
					</div>
					<div style="width:2rem; height:2px; background:<?php echo $is_gold ? 'var(--gold)' : 'var(--blue)'; ?>; margin:0.75rem 0;"></div>
					<p style="font-weight:600; font-size:0.875rem; color:<?php echo $s['heading']; ?>;">
						<?php echo esc_html( $card['stat_label'] ); ?>
					</p>
					<p style="font-size:0.75rem; margin-top:0.25rem; color:<?php echo $s['text_muted']; ?>;">
						<?php echo esc_html( $card['stat_description'] ); ?>
					</p>
				</div>
				<?php endforeach; ?>
			</div>

		</div><!-- .grid -->
	</div>
</section>
