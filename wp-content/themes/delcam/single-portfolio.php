<?php
/**
 * Template for displaying a single Portfolio Company.
 *
 * ACF Fields (per portfolio post):
 *   company_url       (url)       — external company website
 *   company_founded   (text)      — founding / acquisition year
 *   company_location  (text)      — city, state
 *   company_employees (text)      — headcount range
 *   company_overview  (textarea)  — longer description beyond the excerpt
 *   company_gallery   (gallery)   — additional company images
 *
 * @package DelCam_Capital
 */

get_header();

while ( have_posts() ) :
	the_post();

	$company_id       = get_the_ID();
	$company_url       = get_post_meta( $company_id, 'company_url',       true );
	$company_founded   = get_post_meta( $company_id, 'company_founded',   true );
	$company_location  = get_post_meta( $company_id, 'company_location',  true );
	$company_employees = get_post_meta( $company_id, 'company_employees', true );
	$company_overview  = get_post_meta( $company_id, 'company_overview',  true );
	$company_logo_id   = (int) get_post_meta( $company_id, 'company_logo', true );
	$terms            = get_the_terms( $company_id, 'portfolio_category' );
	$excerpt          = get_the_excerpt();

endwhile;
?>

<main id="primary" class="site-main">

	<!-- ── Hero ─────────────────────────────────────────────────────── -->
	<section class="section-dark relative overflow-hidden py-20 lg:py-28 px-6 lg:px-12 flex items-center" style="min-height:420px;">

		<div class="absolute inset-0 pointer-events-none grid-overlay" aria-hidden="true"></div>
		<div class="absolute -left-24 top-1/2 -translate-y-1/2 w-96 h-96 rounded-full pointer-events-none"
			style="background:radial-gradient(circle,rgba(30,95,168,0.18) 0%,transparent 70%);filter:blur(60px);" aria-hidden="true"></div>
		<div class="absolute top-0 right-0 w-72 h-72 pointer-events-none glow-gold-lg" aria-hidden="true"></div>

		<div class="w-full max-w-7xl mx-auto relative z-10">

			<a href="/portfolio/" class="inline-flex items-center gap-2 mb-8 fade-up d1"
				style="font-family:'JetBrains Mono',monospace; font-size:0.7rem; letter-spacing:0.12em; text-transform:uppercase; color:rgba(255,255,255,0.45); text-decoration:none; transition:color 0.2s;"
				onmouseover="this.style.color='rgba(200,146,42,0.9)'" onmouseout="this.style.color='rgba(255,255,255,0.45)'">
				&larr; Back to Portfolio
			</a>

			<div class="flex flex-col lg:flex-row lg:items-center gap-10">

				<!-- Logo -->
				<?php if ( $company_logo_id || has_post_thumbnail() ) : ?>
				<div class="flex-shrink-0 flex items-center justify-center rounded-xl fade-up d2"
					style="width:200px; height:120px; background:rgba(255,255,255,0.06); border:1px solid rgba(200,146,42,0.2); padding:1.5rem;">
					<?php if ( $company_logo_id ) : ?>
						<?php echo wp_get_attachment_image( $company_logo_id, 'medium', false, array( 'class' => 'max-h-16 w-auto object-contain', 'alt' => esc_attr( get_the_title() ) . ' logo' ) ); ?>
					<?php else : ?>
						<?php the_post_thumbnail( 'medium', array( 'class' => 'max-h-16 w-auto object-contain', 'alt' => esc_attr( get_the_title() ) ) ); ?>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<!-- Title + meta -->
				<div>
					<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
					<div class="flex flex-wrap gap-2 mb-3 fade-up d2">
						<?php foreach ( $terms as $portfolio_term ) : ?>
						<span style="font-family:'JetBrains Mono',monospace; font-size:0.68rem; letter-spacing:0.08em; text-transform:uppercase; color:var(--gold-light); border:1px solid rgba(200,146,42,0.35); padding:0.2rem 0.75rem; border-radius:99px; background:rgba(200,146,42,0.08);">
							<?php echo esc_html( $portfolio_term->name ); ?>
						</span>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

					<h1 class="heading-display-dark fade-up d3" style="font-size:clamp(2.5rem,7vw,5rem);">
						<?php the_title(); ?>
					</h1>
					<div class="accent-line-gold mb-4 fade-up d4"></div>

					<!-- Quick stats row -->
					<div class="flex flex-wrap gap-6 fade-up d5">
						<?php if ( ! empty( $company_location ) ) : ?>
						<span style="font-family:'JetBrains Mono',monospace; font-size:0.75rem; letter-spacing:0.08em; color:rgba(255,255,255,0.5);">
							📍 <?php echo esc_html( $company_location ); ?>
						</span>
						<?php endif; ?>
						<?php if ( ! empty( $company_founded ) ) : ?>
						<span style="font-family:'JetBrains Mono',monospace; font-size:0.75rem; letter-spacing:0.08em; color:rgba(255,255,255,0.5);">
							// Acquired <?php echo esc_html( $company_founded ); ?>
						</span>
						<?php endif; ?>
						<?php if ( ! empty( $company_employees ) ) : ?>
						<span style="font-family:'JetBrains Mono',monospace; font-size:0.75rem; letter-spacing:0.08em; color:rgba(255,255,255,0.5);">
							👥 <?php echo esc_html( $company_employees ); ?> employees
						</span>
						<?php endif; ?>
						<?php if ( ! empty( $company_url ) ) : ?>
						<a href="<?php echo esc_url( $company_url ); ?>" target="_blank" rel="noopener"
							style="font-family:'JetBrains Mono',monospace; font-size:0.75rem; letter-spacing:0.08em; color:var(--gold); text-decoration:none;">
							Visit Website &rarr;
						</a>
						<?php endif; ?>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- ── Overview ─────────────────────────────────────────────────── -->
	<section class="bg-white py-20 px-6 lg:px-12">
		<div class="max-w-7xl mx-auto">
			<div class="grid lg:grid-cols-3 gap-16">

				<!-- Main content -->
				<div class="lg:col-span-2">
					<p class="section-label mb-4">// About the Company</p>
					<h2 class="heading-display mb-6" style="font-size:clamp(2rem,4vw,3rem);">
						<?php the_title(); ?>
					</h2>
					<div class="accent-line-gold mb-8"></div>

					<?php if ( ! empty( $company_overview ) ) : ?>
					<div class="prose-content" style="padding:0;">
						<?php echo wp_kses_post( wpautop( $company_overview ) ); ?>
					</div>
					<?php elseif ( ! empty( $excerpt ) ) : ?>
					<p style="font-size:1.05rem; line-height:1.8; color:rgba(11,37,69,0.75); max-width:60ch;">
						<?php echo esc_html( $excerpt ); ?>
					</p>
					<?php endif; ?>

					<!-- Post content (editor blocks) -->
					<?php
					while ( have_posts() ) :
						the_post();
						if ( ! empty( get_the_content() ) ) :
					?>
					<div class="mt-8 prose-content" style="padding:0;">
						<?php the_content(); ?>
					</div>
					<?php
						endif;
					endwhile;
					?>
				</div>

				<!-- Sidebar -->
				<aside class="lg:col-span-1">
					<div class="rounded-xl p-8 sticky top-28" style="background:var(--light); border:1px solid var(--border);">

						<p class="section-label mb-6" style="font-size:0.65rem;">// Company Details</p>

						<dl class="flex flex-col gap-5">

							<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
							<div>
								<dt style="font-family:'JetBrains Mono',monospace; font-size:0.65rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--mid); margin-bottom:0.25rem;">Sector</dt>
								<dd style="font-size:0.95rem; font-weight:600; color:var(--navy);">
									<?php echo esc_html( implode( ', ', wp_list_pluck( $terms, 'name' ) ) ); ?>
								</dd>
							</div>
							<?php endif; ?>

							<?php if ( ! empty( $company_location ) ) : ?>
							<div>
								<dt style="font-family:'JetBrains Mono',monospace; font-size:0.65rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--mid); margin-bottom:0.25rem;">Location</dt>
								<dd style="font-size:0.95rem; font-weight:600; color:var(--navy);"><?php echo esc_html( $company_location ); ?></dd>
							</div>
							<?php endif; ?>

							<?php if ( ! empty( $company_founded ) ) : ?>
							<div>
								<dt style="font-family:'JetBrains Mono',monospace; font-size:0.65rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--mid); margin-bottom:0.25rem;">Acquired</dt>
								<dd style="font-size:0.95rem; font-weight:600; color:var(--navy);"><?php echo esc_html( $company_founded ); ?></dd>
							</div>
							<?php endif; ?>

							<?php if ( ! empty( $company_employees ) ) : ?>
							<div>
								<dt style="font-family:'JetBrains Mono',monospace; font-size:0.65rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--mid); margin-bottom:0.25rem;">Employees</dt>
								<dd style="font-size:0.95rem; font-weight:600; color:var(--navy);"><?php echo esc_html( $company_employees ); ?></dd>
							</div>
							<?php endif; ?>

						</dl>

						<?php if ( ! empty( $company_url ) ) : ?>
						<div class="mt-8 pt-6" style="border-top:1px solid var(--border);">
							<a href="<?php echo esc_url( $company_url ); ?>" target="_blank" rel="noopener"
								class="btn-primary w-full text-center block rounded-md py-3 px-6">
								Visit Website &rarr;
							</a>
						</div>
						<?php endif; ?>

					</div>
				</aside>

			</div>
		</div>
	</section>

	<!-- ── Back to portfolio CTA ──────────────────────────────────────── -->
	<section class="py-16 px-6" style="background:var(--light); border-top:1px solid var(--border);">
		<div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6">
			<div>
				<p class="section-label mb-1">// Our Portfolio</p>
				<p style="font-size:1rem; color:var(--mid);">Explore all of our portfolio companies.</p>
			</div>
			<a href="/portfolio/" class="btn-outline rounded-md py-3 px-8">
				View All Companies &rarr;
			</a>
		</div>
	</section>

</main>

<?php get_footer(); ?>
