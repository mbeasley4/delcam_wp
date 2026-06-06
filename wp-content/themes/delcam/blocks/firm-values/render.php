<?php
/**
 * Block: Firm Values (native Gutenberg — ACF repeater for values)
 * Gold-gradient section displaying the firm's core values as a grid.
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * ACF Fields (per page):
 *   values  (repeater)
 *     ↳ title   (text)
 *     ↳ content (textarea)
 *
 * @package DelCam_Capital
 */

$section_label    = $attributes['sectionLabel']    ?? '// Our Foundation';
$section_headline = $attributes['sectionHeadline'] ?? 'FIRM VALUES';

$values = ! empty( $attributes['values'] ) && is_array( $attributes['values'] )
	? $attributes['values']
	: array(
		array( 'title' => 'Integrity',   'content' => 'We hold ourselves to the highest standards of transparency and honesty in every interaction with founders, investors, and partners.' ),
		array( 'title' => 'Conviction',  'content' => 'We take concentrated positions in businesses we deeply understand, backing our thesis with patience and resolve through market cycles.' ),
		array( 'title' => 'Partnership', 'content' => 'We operate as true partners to management teams — providing capital, operational expertise, and our network to accelerate growth.' ),
		array( 'title' => 'Excellence',  'content' => 'We pursue superior outcomes by combining rigorous analysis, creative problem-solving, and disciplined execution at every stage.' ),
	);

$dark_bg = (bool) ( $attributes['darkBackground'] ?? true );
$s       = delcam_scheme( $dark_bg );

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'firm-values-section ' . ( $dark_bg ? 'bg-gradient-gold' : $s['section_class'] ) . ' relative overflow-hidden' ) );
?>

<section <?php echo $wrapper_attrs; ?> style="<?php echo $dark_bg ? '' : 'background:' . $s['bg'] . ';'; ?> padding:7rem 1.5rem;">

	<?php if ( $dark_bg ) : ?>
	<!-- Gold gradient overlay -->
	<div class="absolute inset-0 pointer-events-none grid-overlay-white opacity-30" aria-hidden="true"></div>
	<?php else : ?>
	<!-- Light top accent bar -->
	<div class="absolute top-0 left-0 right-0 h-1 pointer-events-none" aria-hidden="true"
		style="background:linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 50%, transparent 100%);"></div>
	<?php endif; ?>

	<div class="max-w-7xl mx-auto relative z-10">

		<!-- Section heading -->
		<div class="flex flex-col lg:flex-row lg:items-end justify-between mb-16 gap-8">
			<div>
				<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $dark_bg ? 'rgba(255,255,255,0.5)' : $s['label']; ?>; border-left:2px solid <?php echo $dark_bg ? 'rgba(255,255,255,0.2)' : $s['label_border']; ?>; padding-left:0.75rem; margin-bottom:1.25rem;">
					<?php echo esc_html( $section_label ); ?>
				</p>
				<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(2.5rem,6vw,4.5rem); line-height:0.95; color:<?php echo $dark_bg ? '#fff' : $s['heading']; ?>;">
					<?php echo wp_kses_post( format_headline( $section_headline ) ); ?>
				</h2>
			</div>
		</div>

		<!-- Values grid -->
		<?php if ( $dark_bg ) : ?>
		<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-px rounded-2xl overflow-hidden"
			style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.1);">
			<?php
			$items = $values;
			foreach ( $items as $i => $value ) :
			?>
			<div class="firm-value-card group p-8 flex flex-col gap-4"
				style="background:rgba(10,30,53,0.8); transition:background 0.3s;"
				onmouseenter="this.style.background='rgba(200,146,42,0.2)'"
				onmouseleave="this.style.background='rgba(10,30,53,0.8)'"
				data-aos="fade-up" data-aos-duration="500" data-aos-delay="<?php echo esc_attr( $i * 80 ); ?>">
				<span style="font-family:'JetBrains Mono',monospace; font-size:0.7rem; letter-spacing:0.1em; color:rgba(255,255,255,0.3);"><?php printf( '%02d', $i + 1 ); ?></span>
				<h3 style="font-family:'Bebas Neue',cursive; font-size:1.35rem; letter-spacing:0.08em; line-height:1.1; color:#fff;">
					<?php echo esc_html( $value['title'] ); ?>
				</h3>
				<div style="font-size:0.875rem; line-height:1.75; color:rgba(255,255,255,0.6);">
					<?php echo wp_kses_post( $value['content'] ); ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php else : ?>
		<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
			<?php
			$items = $values;
			foreach ( $items as $i => $value ) :
			?>
			<div class="<?php echo $s['card_class']; ?> p-8 rounded-xl flex flex-col gap-4"
				style="background:<?php echo $s['card_bg']; ?>; border:1px solid <?php echo $s['card_border']; ?>;"
				data-aos="fade-up" data-aos-duration="500" data-aos-delay="<?php echo esc_attr( $i * 80 ); ?>">
				<span style="font-family:'JetBrains Mono',monospace; font-size:0.7rem; letter-spacing:0.1em; color:<?php echo $s['text_muted']; ?>;"><?php printf( '%02d', $i + 1 ); ?></span>
				<h3 style="font-family:'Bebas Neue',cursive; font-size:1.35rem; letter-spacing:0.04em; line-height:1.1; color:<?php echo $s['heading']; ?>;">
					<?php echo esc_html( $value['title'] ); ?>
				</h3>
				<div style="font-size:0.875rem; line-height:1.75; color:<?php echo $s['text']; ?>;">
					<?php echo wp_kses_post( $value['content'] ); ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

	</div>
</section>
