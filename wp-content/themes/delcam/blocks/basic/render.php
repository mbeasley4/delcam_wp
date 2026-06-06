<?php
/**
 * Block: Basic Content (native Gutenberg — no ACF required)
 * Light split-section: creates visual break from dark hero.
 * Left: large Bebas headline + gold accent. Right: body text + CTAs.
 *
 * @package DelCam_Capital
 */

$section_label = $attributes['sectionLabel']  ?? '// For Business Owners';
$headline      = $attributes['headline']      ?? 'Building Enduring Value in U.S. Manufacturing';
$body          = $attributes['content']       ?? '';
$btn1_label    = $attributes['button1Label']  ?? 'Our Investment Approach';
$btn1_url      = $attributes['button1Url']    ?? '/strategy/';
$btn1_target   = ! empty( $attributes['button1Target'] ) ? ' target="' . esc_attr( $attributes['button1Target'] ) . '"' : '';
$btn2_label    = $attributes['button2Label']  ?? 'View Portfolio Companies';
$btn2_url      = $attributes['button2Url']    ?? '/portfolio/';
$btn2_target   = ! empty( $attributes['button2Target'] ) ? ' target="' . esc_attr( $attributes['button2Target'] ) . '"' : '';

$dark_bg = (bool) ( $attributes['darkBackground'] ?? false );
$s       = delcam_scheme( $dark_bg );

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'basic-content-section relative overflow-hidden' ) );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $dark_bg ? 'var(--dark)' : 'var(--white)'; ?>; padding:6rem 1.5rem; position:relative; overflow:hidden;">

	<?php if ( $dark_bg ) : ?>
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute right-0 top-0 w-[28rem] h-[28rem] pointer-events-none glow-gold" aria-hidden="true"></div>
	<?php else : ?>
	<!-- Light mode: radial blue wash upper-right for depth -->
	<div class="absolute right-0 top-0 w-[36rem] h-[36rem] pointer-events-none" aria-hidden="true"
		style="background:radial-gradient(ellipse at top right, rgba(30,95,168,0.07) 0%, transparent 65%);"></div>
	<!-- Subtle dot-grid texture -->
	<div class="absolute inset-0 pointer-events-none" aria-hidden="true"
		style="background-image:radial-gradient(rgba(30,95,168,0.09) 1px, transparent 1px); background-size:28px 28px;"></div>
	<?php endif; ?>

	<!-- Gold top-edge rule -->
	<div class="absolute top-0 left-0 right-0 h-[3px] pointer-events-none" aria-hidden="true"
		style="background:linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 40%, transparent 75%);"></div>

	<div class="max-w-7xl mx-auto relative z-10">
		<div class="grid lg:grid-cols-2 gap-12 lg:gap-24 items-center">

			<!-- Left: label + oversized headline -->
			<div>
				<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $dark_bg ? 'rgba(200,146,42,0.9)' : 'var(--blue)'; ?>; border-left:2px solid <?php echo $dark_bg ? 'rgba(200,146,42,0.5)' : 'var(--blue)'; ?>; padding-left:0.75rem; margin-bottom:1.5rem;"
					data-aos="fade-up" data-aos-duration="500">
					<?php echo esc_html( $section_label ); ?>
				</p>

				<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(3rem,6.5vw,5.5rem); line-height:0.93; color:<?php echo $dark_bg ? 'var(--white)' : 'var(--navy)'; ?>;"
					data-aos="fade-up" data-aos-duration="500" data-aos-delay="80">
					<?php echo wp_kses_post( format_headline( $headline ) ); ?>
				</h2>

				<!-- Gold underline accent -->
				<div style="width:3.5rem; height:3px; margin-top:1.75rem; background:linear-gradient(90deg, var(--gold), var(--gold-light));"
					data-aos="fade-up" data-aos-duration="400" data-aos-delay="150" aria-hidden="true"></div>
			</div>

			<!-- Right: vertical rule + body + CTAs -->
			<div style="<?php echo ! $dark_bg ? 'border-left:1px solid rgba(30,95,168,0.15); padding-left:3rem;' : ''; ?>"
				data-aos="fade-up" data-aos-duration="500" data-aos-delay="200">

				<?php if ( ! empty( $body ) ) : ?>
				<div style="color:<?php echo $dark_bg ? 'rgba(255,255,255,0.7)' : 'var(--mid)'; ?>; line-height:1.85; font-size:1.05rem; margin-bottom:2.5rem; max-width:40ch;">
					<?php echo wp_kses_post( wpautop( $body ) ); ?>
				</div>
				<?php endif; ?>

				<?php if ( ! empty( $btn1_label ) || ! empty( $btn2_label ) ) : ?>
				<div class="flex flex-wrap gap-4">

					<?php if ( ! empty( $btn1_label ) ) : ?>
					<a href="<?php echo esc_url( $btn1_url ); ?>"
						class="<?php echo $s['btn_primary']; ?> inline-block text-sm px-8 py-3.5 rounded-md"
						<?php echo $btn1_target; ?>>
						<?php echo esc_html( $btn1_label ); ?>
					</a>
					<?php endif; ?>

					<?php if ( ! empty( $btn2_label ) ) : ?>
					<a href="<?php echo esc_url( $btn2_url ); ?>"
						class="<?php echo $s['btn_secondary']; ?> inline-block text-sm px-8 py-3.5 rounded-md"
						<?php echo $btn2_target; ?>>
						<?php echo esc_html( $btn2_label ); ?>
					</a>
					<?php endif; ?>

				</div>
				<?php endif; ?>

			</div>

		</div>
	</div>
</section>
