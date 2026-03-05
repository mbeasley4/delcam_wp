<?php
/**
 * Block: Large Text Callout (CTA Banner)
 * Dark gradient section with a large display headline and two CTAs.
 *
 * ACF Fields:
 *   eyebrow_label  (text)     — "// FOR BUSINESS OWNERS"
 *   callout        (text)     — large headline, e.g. "IS IT TIME\nTO TALK?"
 *   subtext        (textarea) — supporting paragraph
 *   button_1       (link)     — primary gold CTA
 *   button_2       (link)     — ghost/outline CTA
 *
 * @package DelCam_Capital
 */

$eyebrow_label = ! empty( get_field( 'eyebrow_label' ) ) ? get_field( 'eyebrow_label' ) : '// FOR BUSINESS OWNERS';
$callout       = ! empty( get_field( 'callout' ) ) ? get_field( 'callout' ) : 'IS IT TIME<br>TO TALK?';
$subtext       = ! empty( get_field( 'subtext' ) ) ? get_field( 'subtext' ) : "Whether you're thinking about retirement, bringing on a growth partner, or just exploring options — we're a straightforward call. Confidential and obligation-free.";
$button_1      = ! empty( get_field( 'button_1' ) ) ? get_field( 'button_1' ) : '';
$button_2      = ! empty( get_field( 'button_2' ) ) ? get_field( 'button_2' ) : '';
?>

<section class="section-dark relative overflow-hidden py-24 px-6 lg:px-12">

	<!-- Background gradient -->
	<div class="absolute inset-0 callout-overlay"></div>

	<!-- Grid overlay -->
	<div class="absolute inset-0 pointer-events-none grid-overlay"></div>

	<!-- Ambient glow -->
	<div class="absolute top-0 right-0 w-96 h-96 pointer-events-none glow-gold-lg"></div>

	<div class="max-w-7xl mx-auto relative z-10 text-center">

		<p class="section-label mb-6">
			<?php echo esc_html( $eyebrow_label ); ?>
		</p>

		<h2 class="heading-display-xl mb-6">
			<?php echo $callout; ?>
		</h2>

		<p class="max-w-md mx-auto leading-relaxed mb-10">
			<?php echo esc_html( $subtext ); ?>
		</p>

		<div class="flex flex-col sm:flex-row gap-4 justify-center">

			<?php if ( ! empty( $button_1 ) ) : ?>
				<a href="<?php echo esc_url( $button_1['url'] ); ?>"
					class="btn-gold inline-block text-sm px-10 py-4 rounded-md"
					<?php echo $button_1['target'] ? 'target="' . esc_attr( $button_1['target'] ) . '"' : ''; ?>>
					<?php echo esc_html( $button_1['title'] ); ?>
				</a>
			<?php else : ?>
				<a href="/contact/" class="btn-gold inline-block text-sm px-10 py-4 rounded-md">Schedule a Conversation</a>
			<?php endif; ?>

			<?php if ( ! empty( $button_2 ) ) : ?>
				<a href="<?php echo esc_url( $button_2['url'] ); ?>"
					class="btn-ghost-white inline-block text-sm px-10 py-4 rounded-md"
					<?php echo $button_2['target'] ? 'target="' . esc_attr( $button_2['target'] ) . '"' : ''; ?>>
					<?php echo esc_html( $button_2['title'] ); ?>
				</a>
			<?php else : ?>
				<a href="/portfolio/" class="btn-ghost-white inline-block text-sm px-10 py-4 rounded-md">
					View Our Portfolio
				</a>
			<?php endif; ?>

		</div>
	</div>
</section>
