<?php
/**
 * Block: Content + 3 Feature Boxes
 * Light section with a headline/intro on the left and three feature cards on the right,
 * or stacked on smaller screens as a 3-column card grid below the heading.
 *
 * ACF Fields:
 *   headline     (text)
 *   main_content (textarea / wysiwyg)
 *   icon_1       (image)
 *   headline_1   (text)
 *   content_1    (textarea)
 *   icon_2       (image)
 *   headline_2   (text)
 *   content_2    (textarea)
 *   icon_3       (image)
 *   headline_3   (text)
 *   content_3    (textarea)
 *
 * @package DelCam_Capital
 */

$headline     = ! empty( get_field( 'headline' ) ) ? get_field( 'headline' ) : 'HOW WE CREATE VALUE';
$main_content = ! empty( get_field( 'main_content' ) ) ? get_field( 'main_content' ) : 'Our approach combines operational expertise with strategic capital to build lasting value in precision manufacturing.';

$blocks = array(
	array(
		'icon'     => get_field( 'icon_1' ),
		'headline' => ! empty( get_field( 'headline_1' ) ) ? get_field( 'headline_1' ) : 'Growth Focus',
		'content'  => ! empty( get_field( 'content_1' ) ) ? get_field( 'content_1' ) : 'We identify and acquire founder-owned manufacturers with proven business models and strong growth potential.',
		'icon_src' => get_template_directory_uri() . '/images/icons/growth.svg',
		'icon_alt' => 'Growth Icon',
	),
	array(
		'icon'     => get_field( 'icon_2' ),
		'headline' => ! empty( get_field( 'headline_2' ) ) ? get_field( 'headline_2' ) : 'Team Partnership',
		'content'  => ! empty( get_field( 'content_2' ) ) ? get_field( 'content_2' ) : 'Backing strong management teams with meaningful equity and operational support to drive sustainable performance.',
		'icon_src' => get_template_directory_uri() . '/images/icons/team.svg',
		'icon_alt' => 'Team Icon',
	),
	array(
		'icon'     => get_field( 'icon_3' ),
		'headline' => ! empty( get_field( 'headline_3' ) ) ? get_field( 'headline_3' ) : 'Innovation & Scale',
		'content'  => ! empty( get_field( 'content_3' ) ) ? get_field( 'content_3' ) : 'Investing in technology modernization and process improvements to capture higher-value work and expand margins.',
		'icon_src' => get_template_directory_uri() . '/images/icons/innovation.svg',
		'icon_alt' => 'Innovation Icon',
	),
);
?>

<section class="py-28 px-6 lg:px-12 bg-white">
	<div class="max-w-7xl mx-auto">

		<!-- Section heading -->
		<div class="flex flex-col justify-between mb-16 gap-6">
			<h2 class="heading-display">
				<?php echo wp_kses_post( format_headline( $headline ) ); ?>
			</h2>
			<?php if ( ! empty( $main_content ) ) : ?>
			<div class="leading-relaxed text-mid">
				<?php echo $main_content; ?>
			</div>
			<?php endif; ?>
		</div>

		<!-- Feature boxes grid -->
		<div class="grid md:grid-cols-3 gap-6">
			<?php foreach ( $blocks as $block ) : ?>
			<div class="card p-8 rounded-xl">

				<!-- Icon -->
				<div class="icon-circle mb-6">
					<?php if ( ! empty( $block['icon']['url'] ) ) : ?>
						<img src="<?php echo esc_url( $block['icon']['url'] ); ?>"
							alt="<?php echo esc_attr( $block['icon']['alt'] ?? '' ); ?>"
							width="22" height="22" />
					<?php else : ?>
						<img src="<?php echo esc_url( $block['icon_src'] ); ?>"
							alt="<?php echo esc_attr( $block['icon_alt'] ); ?>"
							width="22" height="22" />
					<?php endif; ?>
				</div>

				<!-- Heading -->
				<h3 class="heading-card mb-3">
					<?php echo wp_kses_post( format_headline( $block['headline'] ) ); ?>
				</h3>

				<!-- Body -->
				<div class="text-sm leading-relaxed text-mid">
					<?php echo $block['content']; ?>
				</div>

			</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
