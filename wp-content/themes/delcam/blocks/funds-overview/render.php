<?php
/**
 * Block: Funds Overview (native Gutenberg — ACF repeater for funds)
 * Dark section displaying fund cards with portfolio companies and descriptions.
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * ACF Fields (per page):
 *   funds  (repeater)
 *     ↳ fund_name           (text)
 *     ↳ fund_description    (textarea)
 *     ↳ portfolio_companies (repeater)
 *         ↳ company_name (text)
 *
 * @package DelCam_Capital
 */

$section_label    = $attributes['sectionLabel']    ?? '// Our Funds';
$section_headline = $attributes['sectionHeadline'] ?? "FUNDS\nOVERVIEW";
$button_1_text    = $attributes['button1Text']     ?? 'Schedule a Conversation';
$button_1_url     = $attributes['button1Url']      ?? '/contact/';
$button_2_text    = $attributes['button2Text']     ?? 'View Our Portfolio';
$button_2_url     = $attributes['button2Url']      ?? '/portfolio/';

// companies_text is a newline-separated list of company names stored per fund.
$funds = ! empty( $attributes['funds'] ) && is_array( $attributes['funds'] )
	? $attributes['funds']
	: array(
		array(
			'fund_name'        => 'DelCam Capital Fund I',
			'fund_description' => 'Our inaugural fund focused on lower middle-market businesses with proven cash flow and clear operational improvement opportunities.',
			'companies_text'   => "Portfolio Company A\nPortfolio Company B\nPortfolio Company C",
		),
		array(
			'fund_name'        => 'DelCam Capital Fund II',
			'fund_description' => 'Building on our track record, Fund II targets sector-focused opportunities in business services, industrials, and healthcare services.',
			'companies_text'   => "Portfolio Company D\nPortfolio Company E",
		),
	);

$roman_numerals = array( 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X' );

$dark_bg = (bool) ( $attributes['darkBackground'] ?? true );
$s       = delcam_scheme( $dark_bg );

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'funds-overview-section ' . $s['section_class'] . ' relative overflow-hidden' ) );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>; padding:7rem 1.5rem;">

	<?php if ( $dark_bg ) : ?>
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute right-0 top-0 w-96 h-96 pointer-events-none glow-gold" aria-hidden="true"></div>
	<?php else : ?>
	<div class="absolute top-0 left-0 right-0 h-1 pointer-events-none" aria-hidden="true"
		style="background:linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 50%, transparent 100%);"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto relative z-10">

		<!-- Section heading -->
		<div class="mb-12">
			<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; border-left:2px solid <?php echo $s['label_border']; ?>; padding-left:0.75rem; margin-bottom:0.75rem;">
				<?php echo esc_html( $section_label ); ?>
			</p>
			<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(2.5rem,6vw,4.5rem); line-height:0.95; color:<?php echo $s['heading']; ?>;">
				<?php echo wp_kses_post( format_headline( nl2br( $section_headline ) ) ); ?>
			</h2>
		</div>

		<!-- Fund cards -->
		<div class="grid md:grid-cols-2 gap-8">
			<?php
			$items = $funds;
			foreach ( $items as $i => $fund ) :
				$numeral = $roman_numerals[ $i ] ?? ( $i + 1 );
			?>
			<div class="<?php echo $dark_bg ? 'step-card' : $s['card_class']; ?> rounded-xl p-8 flex flex-col gap-6"
				<?php if ( ! $dark_bg ) : ?>style="background:<?php echo $s['card_bg']; ?>; border:1px solid <?php echo $s['card_border']; ?>;"<?php endif; ?>
				data-aos="fade-up" data-aos-duration="500" data-aos-delay="<?php echo esc_attr( $i * 100 ); ?>">

				<!-- Fund number badge + name -->
				<div>
					<span style="font-family:'JetBrains Mono',monospace; font-size:0.7rem; letter-spacing:0.12em; text-transform:uppercase; color:<?php echo $s['text_muted']; ?>; display:block; margin-bottom:0.75rem;">
						<?php echo esc_html( 'FUND ' . $numeral ); ?>
					</span>
					<h3 style="font-family:'Bebas Neue',cursive; font-size:1.75rem; letter-spacing:0.04em; color:<?php echo $s['heading']; ?>;">
						<?php echo esc_html( $fund['fund_name'] ); ?>
					</h3>
				</div>

				<!-- Portfolio companies -->
				<?php if ( ! empty( $fund['portfolio_companies'] ) ) : ?>
				<div>
					<p style="font-family:'JetBrains Mono',monospace; font-size:0.7rem; letter-spacing:0.12em; text-transform:uppercase; color:var(--gold); display:block; margin-bottom:0.75rem;">Portfolio Companies</p>
					<div class="flex flex-wrap gap-2">
						<?php foreach ( $fund['portfolio_companies'] as $company ) : ?>
						<span style="display:inline-block; padding:0.375rem 0.75rem; border-radius:4px; font-family:'JetBrains Mono',monospace; font-size:0.72rem; background:rgba(200,146,42,0.1); border:1px solid rgba(200,146,42,0.3); color:var(--gold-light);">
							<?php echo esc_html( $company['company_name'] ); ?>
						</span>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>

				<!-- Description -->
				<?php if ( ! empty( $fund['fund_description'] ) ) : ?>
				<div style="font-size:0.875rem; line-height:1.75; color:<?php echo $s['text']; ?>; border-top:1px solid <?php echo $dark_bg ? 'rgba(255,255,255,0.1)' : $s['card_border']; ?>; padding-top:1rem;">
					<?php echo wp_kses_post( $fund['fund_description'] ); ?>
				</div>
				<?php endif; ?>

			</div>
			<?php endforeach; ?>
		</div><!-- .grid -->

		<!-- Button group -->
		<div class="flex flex-col sm:flex-row gap-4 justify-center mt-12 mx-auto">
			<a href="<?php echo esc_url( $button_1_url ); ?>"
				class="<?php echo $s['btn_primary']; ?> inline-block text-sm px-10 py-4 rounded-md">
				<?php echo esc_html( $button_1_text ); ?>
			</a>
			<a href="<?php echo esc_url( $button_2_url ); ?>"
				class="<?php echo $s['btn_secondary']; ?> inline-block text-sm px-10 py-4 rounded-md">
				<?php echo esc_html( $button_2_text ); ?>
			</a>
		</div>

	</div>
</section>
