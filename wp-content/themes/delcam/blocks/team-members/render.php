<?php
/**
 * Block: Team Members (native Gutenberg — no ACF required)
 * Dark section with portrait photo cards and full-screen modal bios.
 *
 * Available variables:
 *   $attributes  (array)    — block attributes from block.json schema
 *   $content     (string)   — inner blocks HTML (unused)
 *   $block       (WP_Block) — the block instance
 *
 * Team Member CPT ACF Fields (per post):
 *   job_title     (text)
 *   email_address (email)
 *   phone_number  (text)
 *   linkedin_url  (url)
 *
 * @package DelCam_Capital
 */

$section_label      = $attributes['sectionLabel']    ?? '// Our People';
$section_headline   = $attributes['sectionHeadline'] ?? 'THE TEAM';
$leadership_label   = $attributes['leadershipLabel']  ?? '// Leadership';
$leadership_eyebrow = $attributes['leadershipEyebrow'] ?? '// Leadership';
$advisory_label     = $attributes['advisoryLabel']    ?? '// Advisory';
$advisory_eyebrow   = $attributes['advisoryEyebrow']  ?? '// Advisory Board';

$placeholder_leadership = array(
	array( 'name' => 'Partner Name', 'title' => 'Managing Partner' ),
	array( 'name' => 'Partner Name', 'title' => 'Operating Partner' ),
	array( 'name' => 'Partner Name', 'title' => 'Principal' ),
);

$placeholder_advisory = array(
	array( 'name' => 'Advisor Name', 'title' => 'Industry Expert' ),
	array( 'name' => 'Advisor Name', 'title' => 'Strategic Advisor' ),
	array( 'name' => 'Advisor Name', 'title' => 'Technical Advisor' ),
	array( 'name' => 'Advisor Name', 'title' => 'Finance Advisor' ),
);

$dark_bg = (bool) ( $attributes['darkBackground'] ?? false );
$s       = delcam_scheme( $dark_bg );

$wrapper_attrs = get_block_wrapper_attributes( array( 'class' => 'team-section ' . $s['section_class'] ) );
?>

<section <?php echo $wrapper_attrs; ?> style="background:<?php echo $s['bg']; ?>;">

	<?php if ( $dark_bg ) : ?>
	<!-- Dark overlay accents -->
	<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
	<div class="absolute top-0 right-0 w-96 h-96 pointer-events-none glow-gold-lg" aria-hidden="true"></div>
	<div class="absolute bottom-1/4 left-0 w-80 h-80 pointer-events-none" aria-hidden="true"
		style="background:radial-gradient(circle,rgba(30,95,168,0.2) 0%,transparent 70%);filter:blur(60px);"></div>
	<?php else : ?>
	<!-- Light overlay texture -->
	<div class="absolute inset-0 pointer-events-none" aria-hidden="true"
		style="background-image:linear-gradient(rgba(30,95,168,0.06) 1px,transparent 1px),linear-gradient(90deg,rgba(30,95,168,0.06) 1px,transparent 1px);background-size:56px 56px;"></div>
	<div class="absolute top-1/4 right-0 w-96 h-96 pointer-events-none" aria-hidden="true"
		style="background:radial-gradient(circle,rgba(200,146,42,0.09) 0%,transparent 70%);filter:blur(60px);"></div>
	<div class="absolute bottom-1/4 left-0 w-80 h-80 pointer-events-none" aria-hidden="true"
		style="background:radial-gradient(circle,rgba(30,95,168,0.1) 0%,transparent 70%);filter:blur(60px);"></div>
	<?php endif; ?>

	<div class="team-section__inner">

		<!-- Section header -->
		<div class="team-section__header">
			<p style="font-family:'JetBrains Mono',monospace; font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; color:<?php echo $s['label']; ?>; border-left:2px solid <?php echo $s['label_border']; ?>; padding-left:0.75rem;">
				<?php echo esc_html( $section_label ); ?>
			</p>
			<h2 style="font-family:'Bebas Neue',cursive; font-size:clamp(2.5rem,6vw,4.5rem); line-height:0.95; color:<?php echo $s['heading']; ?>; margin-top:0.75rem;">
				<?php echo wp_kses_post( format_headline( $section_headline ) ); ?>
			</h2>
		</div>

		<!-- ── Leadership Team ─────────────────────────────────────────────── -->
		<?php
		$leadership_query = new WP_Query( array(
			'post_type'      => 'team_member',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Required for team category filtering.
				array(
					'taxonomy' => 'team_category',
					'field'    => 'slug',
					'terms'    => 'leadership',
				),
			),
		) );
		?>

		<div class="team-section__group">
			<div class="team-section__group-header">
				<div class="accent-line"></div>
				<p class="section-label"><?php echo esc_html( $leadership_label ); ?></p>
			</div>

			<div class="team-grid-leadership">
				<?php if ( $leadership_query->have_posts() ) : ?>
					<?php
					while ( $leadership_query->have_posts() ) :
						$leadership_query->the_post();
						$member_id = get_the_ID();
						$job_title = get_post_meta( $member_id, 'job_title', true );
						$email     = get_post_meta( $member_id, 'email_address', true );
						$phone     = get_post_meta( $member_id, 'phone_number', true );
						$linkedin  = get_post_meta( $member_id, 'linkedin_url', true );
						$has_bio   = trim( get_the_content() ) !== '';
						?>

					<!-- Card -->
					<div class="team-card" data-modal-id="modal-<?php echo esc_attr( $member_id ); ?>"
						role="button" tabindex="0"
						aria-label="<?php echo esc_attr( 'View bio for ' . get_the_title() ); ?>"
						data-aos="fade-up" data-aos-duration="500">

						<div class="team-card__photo">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large', array( 'class' => 'team-card__img', 'alt' => esc_attr( get_the_title() ) ) ); ?>
							<?php else : ?>
								<div class="team-card__placeholder">
									<svg width="48" height="48" fill="none" stroke="rgba(255,255,255,0.15)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
								</div>
							<?php endif; ?>
							<div class="team-card__overlay"></div>
						</div>

						<div class="team-card__body">
							<div class="team-card__info">
								<h3 class="team-card__name"><?php the_title(); ?></h3>
								<?php if ( ! empty( $job_title ) ) : ?>
									<p class="team-card__title"><?php echo esc_html( $job_title ); ?></p>
								<?php endif; ?>
							</div>
							<div class="team-card__actions">
								<?php if ( ! empty( $linkedin ) ) : ?>
									<a class="team-card__linkedin-icon" href="<?php echo esc_url( $linkedin ); ?>"
										target="_blank" rel="noopener noreferrer"
										aria-label="<?php echo esc_attr( get_the_title() ); ?> on LinkedIn"
										onclick="event.stopPropagation()">
										<svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
									</a>
								<?php endif; ?>
								<?php if ( $has_bio ) : ?>
									<span class="team-card__bio-cue" aria-hidden="true">Bio &rarr;</span>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<!-- Modal -->
					<div id="modal-<?php echo esc_attr( $member_id ); ?>" class="team-modal"
						role="dialog" aria-modal="true"
						aria-labelledby="modal-title-<?php echo esc_attr( $member_id ); ?>"
						aria-hidden="true" tabindex="-1">

						<div class="team-modal__backdrop" data-close></div>

						<div class="team-modal__panel">
							<button class="team-modal__close" data-close aria-label="Close bio">
								<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
							</button>

							<div class="team-modal__layout">
								<div class="team-modal__bio-col">
									<p class="team-modal__eyebrow"><?php echo esc_html( $leadership_eyebrow ); ?></p>
									<h2 id="modal-title-<?php echo esc_attr( $member_id ); ?>" class="team-modal__name">
										<?php the_title(); ?>
									</h2>
									<?php if ( ! empty( $job_title ) ) : ?>
										<p class="team-modal__role"><?php echo esc_html( $job_title ); ?></p>
									<?php endif; ?>

									<div class="team-modal__divider"></div>

									<?php if ( ! empty( $email ) || ! empty( $phone ) || ! empty( $linkedin ) ) : ?>
										<div class="team-modal__chips">
											<?php if ( ! empty( $email ) ) : ?>
												<a class="team-modal__chip" href="mailto:<?php echo esc_attr( $email ); ?>">
													<svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
													<?php echo esc_html( $email ); ?>
												</a>
											<?php endif; ?>
											<?php if ( ! empty( $phone ) ) : ?>
												<a class="team-modal__chip" href="tel:<?php echo esc_attr( preg_replace( '/\D+/', '', $phone ) ); ?>">
													<svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
													<?php echo esc_html( $phone ); ?>
												</a>
											<?php endif; ?>
											<?php if ( ! empty( $linkedin ) ) : ?>
												<a class="team-modal__chip" href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer">
													<svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
													LinkedIn Profile
												</a>
											<?php endif; ?>
										</div>
									<?php endif; ?>

									<?php if ( $has_bio ) : ?>
										<div class="team-modal__bio">
											<?php the_content(); ?>
										</div>
									<?php endif; ?>
								</div>
							</div><!-- .team-modal__layout -->
						</div><!-- .team-modal__panel -->
					</div><!-- .team-modal -->

					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>

				<?php else : ?>
					<!-- Placeholder cards when no CPT data exists -->
					<?php foreach ( $placeholder_leadership as $i => $p ) : ?>
						<div class="team-card team-card--placeholder" style="animation-delay:<?php echo esc_attr( $i * 80 ); ?>ms">
							<div class="team-card__photo">
								<div class="team-card__placeholder">
									<svg width="48" height="48" fill="none" stroke="rgba(255,255,255,0.12)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
								</div>
								<div class="team-card__overlay"></div>
							</div>
							<div class="team-card__body">
								<div class="team-card__info">
									<h3 class="team-card__name"><?php echo esc_html( $p['name'] ); ?></h3>
									<p class="team-card__title"><?php echo esc_html( $p['title'] ); ?></p>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div><!-- .team-grid-leadership -->
		</div><!-- .team-section__group -->


		<!-- ── Advisory Board ─────────────────────────────────────────────── -->
		<?php
		$advisory_query = new WP_Query( array(
			'post_type'      => 'team_member',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Required for team category filtering.
				array(
					'taxonomy' => 'team_category',
					'field'    => 'slug',
					'terms'    => 'advisory',
				),
			),
		) );
		?>

		<div class="team-section__group">
			<div class="team-section__group-header">
				<div class="accent-line"></div>
				<p class="section-label"><?php echo esc_html( $advisory_label ); ?></p>
			</div>

			<div class="team-grid-advisory">
				<?php if ( $advisory_query->have_posts() ) : ?>
					<?php
					while ( $advisory_query->have_posts() ) :
						$advisory_query->the_post();
						$member_id = get_the_ID();
						$job_title = get_post_meta( $member_id, 'job_title', true );
						$email     = get_post_meta( $member_id, 'email_address', true );
						$phone     = get_post_meta( $member_id, 'phone_number', true );
						$linkedin  = get_post_meta( $member_id, 'linkedin_url', true );
						$has_bio   = trim( get_the_content() ) !== '';
						?>

					<!-- Card -->
					<div class="team-card team-card--sm" data-modal-id="modal-<?php echo esc_attr( $member_id ); ?>"
						role="button" tabindex="0"
						aria-label="<?php echo esc_attr( 'View bio for ' . get_the_title() ); ?>"
						data-aos="fade-up" data-aos-duration="500">

						<div class="team-card__photo">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium', array( 'class' => 'team-card__img', 'alt' => esc_attr( get_the_title() ) ) ); ?>
							<?php else : ?>
								<div class="team-card__placeholder">
									<svg width="36" height="36" fill="none" stroke="rgba(255,255,255,0.15)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
								</div>
							<?php endif; ?>
							<div class="team-card__overlay"></div>
						</div>

						<div class="team-card__body">
							<div class="team-card__info">
								<h3 class="team-card__name"><?php the_title(); ?></h3>
								<?php if ( ! empty( $job_title ) ) : ?>
									<p class="team-card__title"><?php echo esc_html( $job_title ); ?></p>
								<?php endif; ?>
							</div>
							<div class="team-card__actions">
								<?php if ( ! empty( $linkedin ) ) : ?>
									<a class="team-card__linkedin-icon" href="<?php echo esc_url( $linkedin ); ?>"
										target="_blank" rel="noopener noreferrer"
										aria-label="<?php echo esc_attr( get_the_title() ); ?> on LinkedIn"
										onclick="event.stopPropagation()">
										<svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
									</a>
								<?php endif; ?>
								<?php if ( $has_bio ) : ?>
									<span class="team-card__bio-cue" aria-hidden="true">Bio &rarr;</span>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<!-- Modal -->
					<div id="modal-<?php echo esc_attr( $member_id ); ?>" class="team-modal"
						role="dialog" aria-modal="true"
						aria-labelledby="modal-title-<?php echo esc_attr( $member_id ); ?>"
						aria-hidden="true" tabindex="-1">

						<div class="team-modal__backdrop" data-close></div>

						<div class="team-modal__panel">
							<button class="team-modal__close" data-close aria-label="Close bio">
								<svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
							</button>

							<div class="team-modal__layout">
								<div class="team-modal__bio-col">
									<p class="team-modal__eyebrow"><?php echo esc_html( $advisory_eyebrow ); ?></p>
									<h2 id="modal-title-<?php echo esc_attr( $member_id ); ?>" class="team-modal__name">
										<?php the_title(); ?>
									</h2>
									<?php if ( ! empty( $job_title ) ) : ?>
										<p class="team-modal__role"><?php echo esc_html( $job_title ); ?></p>
									<?php endif; ?>

									<div class="team-modal__divider"></div>

									<?php if ( ! empty( $email ) || ! empty( $phone ) || ! empty( $linkedin ) ) : ?>
										<div class="team-modal__chips">
											<?php if ( ! empty( $email ) ) : ?>
												<a class="team-modal__chip" href="mailto:<?php echo esc_attr( $email ); ?>">
													<svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
													<?php echo esc_html( $email ); ?>
												</a>
											<?php endif; ?>
											<?php if ( ! empty( $phone ) ) : ?>
												<a class="team-modal__chip" href="tel:<?php echo esc_attr( preg_replace( '/\D+/', '', $phone ) ); ?>">
													<svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
													<?php echo esc_html( $phone ); ?>
												</a>
											<?php endif; ?>
											<?php if ( ! empty( $linkedin ) ) : ?>
												<a class="team-modal__chip" href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer">
													<svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
													LinkedIn Profile
												</a>
											<?php endif; ?>
										</div>
									<?php endif; ?>

									<?php if ( $has_bio ) : ?>
										<div class="team-modal__bio">
											<?php the_content(); ?>
										</div>
									<?php endif; ?>
								</div>
							</div><!-- .team-modal__layout -->
						</div><!-- .team-modal__panel -->
					</div><!-- .team-modal -->

					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>

				<?php else : ?>
					<!-- Placeholder cards -->
					<?php foreach ( $placeholder_advisory as $i => $p ) : ?>
						<div class="team-card team-card--sm team-card--placeholder" style="animation-delay:<?php echo esc_attr( $i * 60 ); ?>ms">
							<div class="team-card__photo">
								<div class="team-card__placeholder">
									<svg width="36" height="36" fill="none" stroke="rgba(255,255,255,0.12)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
								</div>
								<div class="team-card__overlay"></div>
							</div>
							<div class="team-card__body">
								<div class="team-card__info">
									<h3 class="team-card__name"><?php echo esc_html( $p['name'] ); ?></h3>
									<p class="team-card__title"><?php echo esc_html( $p['title'] ); ?></p>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div><!-- .team-grid-advisory -->
		</div><!-- .team-section__group -->

	</div><!-- .team-section__inner -->
</section>
