<?php
/**
 * Block: Content + Image
 * Two-column section: rich text on one side, photo on the other.
 *
 * ACF Fields:
 *   section_label   (text)
 *   headline        (text)
 *   content         (wysiwyg / textarea)
 *   image           (image)
 *   swap_image  	 ßß(select: left | right)  — optional, defaults to right
 *   cta_button      (link)                  — optional
 *
 * @package DelCam_Capital
 */

$section_label  = ! empty( get_field( 'section_label' ) ) ? get_field( 'section_label' ) : '// Our Story';
$headline       = ! empty( get_field( 'headline' ) ) ? get_field( 'headline' ) : 'BUILT BY<br>OPERATORS.';
$content        = ! empty( get_field( 'content' ) ) ? get_field( 'content' ) : 'DelCam Capital partners with founders and management teams to build enduring precision manufacturing businesses. We bring operational expertise, patient capital, and a hands-on approach to every partnership.';
$image          = ! empty( get_field( 'image' ) ) ? get_field( 'image' ) : null;
// true = image on left, false = image on right (default)
$swap_image = get_field( 'swap_image' );
$cta_button     = ! empty( get_field( 'cta_button' ) ) ? get_field( 'cta_button' ) : null;

// Image is first in DOM so it stacks on top on mobile.
// On desktop: image left (true) = natural row order; image right (false) = reverse.
$reverse_class = ! $swap_image ? 'lg:flex-row-reverse' : '';
?>

<section class="py-28 px-6 lg:px-12 bg-white">
	<div class="max-w-7xl mx-auto">
		<div class="flex flex-col lg:flex-row <?php echo esc_attr( $reverse_class ); ?> gap-16 lg:gap-24 items-center">

			<!-- Image column (first in DOM = top on mobile) -->
			<div class="flex-1 relative">
				<?php if ( $image ) : ?>
					<img
						src="<?php echo esc_url( $image['url'] ); ?>"
						alt="<?php echo esc_attr( $image['alt'] ); ?>"
						class="w-full rounded-2xl object-cover aspect-[4/3]"
					/>
					<div class="absolute -bottom-4 -right-4 w-32 h-32 rounded-2xl bg-gradient-to-br from-sky to-accent opacity-10 -z-10 pointer-events-none"></div>
				<?php else : ?>
					<div class="w-full aspect-[4/3] rounded-2xl bg-light border border-[var(--border)] flex items-center justify-center">
						<span class="mono-label-dim">[ Image ]</span>
					</div>
				<?php endif; ?>
			</div>

			<!-- Content column -->
			<div class="flex-1">
				<p class="section-label mb-4"><?php echo esc_html( $section_label ); ?></p>
				<h2 class="heading-display mb-6">
					<?php echo wp_kses_post( format_headline( $headline ) ); ?>
				</h2>
				<div class="text-mid leading-relaxed mb-8">
					<?php echo $content; ?>
				</div>
				<?php if ( $cta_button ) : ?>
					<a href="<?php echo esc_url( $cta_button['url'] ); ?>"
						class="btn-primary"
						<?php echo ! empty( $cta_button['target'] ) ? 'target="' . esc_attr( $cta_button['target'] ) . '"' : ''; ?>>
						<?php echo esc_html( $cta_button['title'] ); ?> &rarr;
					</a>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>
