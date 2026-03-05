<?php
/**
 * The template for displaying the footer
 *
 * @package DelCam_Capital
 */

$address = get_field( 'footer_address', 'option' );
?>

<footer id="colophon" class="bg-dark py-16 px-6 lg:px-12">
	<div class="max-w-7xl mx-auto">

		<!-- 4-column grid -->
		<div class="grid md:grid-cols-4 gap-12 mb-12">

			<!-- Column 1: Branding -->
			<div>
				<div class="font-display text-[1.75rem] tracking-[0.05em] mb-1">
					<span class="text-gold">DEL</span><span class="text-white/90">CAM</span>
				</div>
				<div class="font-sans text-[0.6rem] font-semibold tracking-[0.2em] uppercase text-white/50 mb-5">CAPITAL</div>

				<div class="text-sm leading-relaxed mb-6 text-white/60">
					Private equity focused on precision manufacturing.<br><br>
					<?php if ( ! empty( $address ) ) : ?>
						<div class="text-sm leading-relaxed mb-4 text-white/60">
						<?php echo $address; ?>
						</div>
					<?php else : ?>
						New Hampshire, USA
					<?php endif; ?>
				</div>

				<div class="flex gap-2 mb-5">
					<span class="bg-gold/15 border border-gold/30 text-gold font-mono text-[0.65rem] px-2 py-1 rounded">PE</span>
					<span class="bg-blue/20 border border-blue/30 text-accent font-mono text-[0.65rem] px-2 py-1 rounded">MFG</span>
					<span class="bg-blue/20 border border-blue/30 text-accent font-mono text-[0.65rem] px-2 py-1 rounded">USA</span>
				</div>

				<div class="flex gap-3">
					<a href="https://www.linkedin.com/company/delcam-capital-llc/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="text-white/60 hover:text-white/90 transition-colors">
						<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
					</a>
				</div>
			</div>

			<!-- Column 2: Strategy -->
			<div>
				<p class="font-mono tracking-[0.15em] text-gold mb-5 uppercase">Strategy</p>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-2',
						'menu_id'        => 'footer-menu',
						'container'      => false,
						'items_wrap'     => '<ul class="flex flex-col gap-3">%3$s</ul>',
						'fallback_cb'    => false,
					)
				);
				?>
				<?php if ( ! has_nav_menu( 'menu-2' ) ) : ?>
				<ul class="flex flex-col gap-3">
					<li><a href="/strategy/" class="text-sm text-white">Platform Acquisitions</a></li>
					<li><a href="/strategy/" class="text-sm text-white">Operational Excellence</a></li>
					<li><a href="/strategy/" class="text-sm text-white">Management Partnerships</a></li>
					<li><a href="/strategy/" class="text-sm text-white">Technology Investment</a></li>
				</ul>
				<?php endif; ?>
			</div>

			<!-- Column 3: Portfolio -->
			<div>
				<p class="font-mono tracking-[0.15em] text-gold mb-5 uppercase">Portfolio</p>
				<ul class="flex flex-col gap-3">
					<li><a href="/portfolio/" class="text-sm text-white">PlasTech Machining</a></li>
					<li><a href="/portfolio/" class="text-sm text-white">NEFM</a></li>
					<li><a href="/portfolio/" class="text-sm text-white">PlasTech Molding</a></li>
					<li><a href="/portfolio/" class="text-sm font-semibold text-white">View All Companies &rarr;</a></li>
				</ul>
			</div>

			<!-- Column 4: Contact -->
			<div>
				<p class="font-mono tracking-[0.15em] text-gold mb-5 uppercase">Contact</p>
				<ul class="flex flex-col gap-3">
					<li><a href="/investor-relations/" class="text-sm text-white">Investor Relations</a></li>
					<li><a href="/contact/" class="text-sm text-white">Acquisition Inquiries</a></li>
					<li><a href="/careers/" class="text-sm text-white">Careers</a></li>
					<li><a href="/news/" class="text-sm text-white">Media &amp; Press</a></li>
				</ul>
			</div>

		</div><!-- .grid -->

		<!-- Legal bar -->
		<div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-6 border-t border-white/[0.07]">
			<p class="font-mono text-[0.65rem] text-white/45">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> DelCam Capital. All rights reserved.
			</p>
			<div class="flex items-center gap-6">
				<a href="/privacy-policy/" class="font-mono text-[0.65rem] text-white">Privacy Policy</a>
				<a href="/terms-and-conditions/" class="font-mono text-[0.65rem] text-white">Terms &amp; Conditions</a>
				<p class="font-mono text-[0.65rem] text-white">Associated DelCam Manufacturing Companies</p>
			</div>
		</div>

	</div><!-- .max-w-7xl -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
