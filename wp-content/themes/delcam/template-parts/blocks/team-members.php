<?php
/**
 * Block: Team Members
 * Dark section with portrait photo cards and full-screen modal bios.
 *
 * Block ACF Fields:
 *   section_label    (text)  — e.g. "// Our People"
 *   section_headline (text)  — e.g. "THE TEAM"
 *
 * Team Member CPT ACF Fields:
 *   job_title     (text)
 *   email_address (email)
 *   phone_number  (text)
 *   linkedin_url  (url)
 *
 * @package DelCam_Capital
 */

$section_label    = ! empty( get_field( 'section_label' ) ) ? get_field( 'section_label' ) : '// Our People';
$section_headline = ! empty( get_field( 'section_headline' ) ) ? get_field( 'section_headline' ) : 'THE TEAM';
?>

<section class="team-section">

	<!-- Grid overlay texture (light-bg variant) -->
	<div class="absolute inset-0 pointer-events-none" aria-hidden="true" style="background-image:linear-gradient(rgba(30,95,168,0.06) 1px,transparent 1px),linear-gradient(90deg,rgba(30,95,168,0.06) 1px,transparent 1px);background-size:56px 56px;"></div>

	<!-- Ambient glow accents -->
	<div class="absolute top-1/4 right-0 w-96 h-96 pointer-events-none" aria-hidden="true"
		style="background:radial-gradient(circle,rgba(200,146,42,0.09) 0%,transparent 70%);filter:blur(60px);"></div>
	<div class="absolute bottom-1/4 left-0 w-80 h-80 pointer-events-none" aria-hidden="true"
		style="background:radial-gradient(circle,rgba(30,95,168,0.1) 0%,transparent 70%);filter:blur(60px);"></div>

	<div class="team-section__inner">

		<!-- Section header -->
		<div class="team-section__header">
			<p class="section-label">
				<?php echo esc_html( $section_label ); ?>
			</p>
			<h2 class="heading-display mt-3">
				<?php echo wp_kses_post( format_headline( $section_headline ) ); ?>
			</h2>
		</div>

		<!-- ── Leadership Team ─────────────────────────────────────────────── -->
		<?php
		$leadership_args  = array(
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
		);
		$leadership_query = new WP_Query( $leadership_args );
		?>

		<div class="team-section__group">
			<div class="team-section__group-header">
				<div class="accent-line"></div>
				<p class="section-label">// Leadership</p>
			</div>

			<div class="team-grid-leadership">
				<?php if ( $leadership_query->have_posts() ) : ?>
					<?php
					while ( $leadership_query->have_posts() ) :
						$leadership_query->the_post();
						$member_id = get_the_ID();
						$job_title = get_field( 'job_title', $member_id );
						$email     = get_field( 'email_address', $member_id );
						$phone     = get_field( 'phone_number', $member_id );
						$linkedin  = get_field( 'linkedin_url', $member_id );
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
					<?php
					$modal_img = has_post_thumbnail()
						? get_the_post_thumbnail( $member_id, 'large', array( 'class' => 'team-modal__img', 'alt' => esc_attr( get_the_title() ) ) )
						: '';
					?>
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
								<!-- Bio column -->
								<div class="team-modal__bio-col">
									<?php if ($modal_img): ?>
									<div class="team-modal__img-wrapper">
									<?php echo wp_kses_post( $modal_img ); ?>
									</div>
									<?php endif; ?>
									<?php if ( ! empty( $linkedin ) ) : ?>
									<a class="team-modal__linkedin-badge" href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer">
										<svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
										LinkedIn Profile
									</a>
									<?php endif; ?>
									
									<p class="team-modal__eyebrow">// Leadership</p>
									<h2 id="modal-title-<?php echo esc_attr( $member_id ); ?>" class="team-modal__name">
										<?php the_title(); ?>
									</h2>
									<?php if ( ! empty( $job_title ) ) : ?>
										<p class="team-modal__role"><?php echo esc_html( $job_title ); ?></p>
									<?php endif; ?>

									<div class="team-modal__divider"></div>

									<?php if ( $has_bio ) : ?>
										<div class="team-modal__bio">
											<?php the_content(); ?>
										</div>
									<?php endif; ?>

									<?php if ( ! empty( $email ) || ! empty( $phone ) ) : ?>
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
		$advisory_args  = array(
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
		);
		$advisory_query = new WP_Query( $advisory_args );
		?>

		<div class="team-section__group">
			<div class="team-section__group-header">
				<div class="accent-line"></div>
				<p class="section-label">// Advisory</p>
			</div>

			<div class="team-grid-advisory">
				<?php if ( $advisory_query->have_posts() ) : ?>
					<?php
					while ( $advisory_query->have_posts() ) :
						$advisory_query->the_post();
						$member_id = get_the_ID();
						$job_title = get_field( 'job_title', $member_id );
						$email     = get_field( 'email_address', $member_id );
						$phone     = get_field( 'phone_number', $member_id );
						$linkedin  = get_field( 'linkedin_url', $member_id );
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
					<?php
					$modal_img = has_post_thumbnail()
						? get_the_post_thumbnail( $member_id, 'large', array( 'class' => 'team-modal__img', 'alt' => esc_attr( get_the_title() ) ) )
						: '<div class="team-modal__photo-placeholder"><svg width="64" height="64" fill="none" stroke="rgba(255,255,255,0.1)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>';
					?>
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
									<p class="team-modal__eyebrow">// Advisory Board</p>
									<h2 id="modal-title-<?php echo esc_attr( $member_id ); ?>" class="team-modal__name">
										<?php the_title(); ?>
									</h2>
									<?php if ( ! empty( $job_title ) ) : ?>
										<p class="team-modal__role"><?php echo esc_html( $job_title ); ?></p>
									<?php endif; ?>

									<div class="team-modal__divider"></div>

									<?php if ( $has_bio ) : ?>
										<div class="team-modal__bio">
											<?php the_content(); ?>
										</div>
									<?php endif; ?>

									<?php if ( ! empty( $email ) || ! empty( $phone ) ) : ?>
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
