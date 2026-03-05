document.addEventListener(
	"DOMContentLoaded",
	function () {
		// ── Mobile menu toggle ──────────────────────────────────────────────────
		const toggle     = document.querySelector( ".mobile-menu-toggle" );
		const mobileMenu = document.querySelector( "#mobile-menu" );

		if (toggle && mobileMenu) {
			toggle.addEventListener(
				"click",
				function () {
					const isExpanded = toggle.getAttribute( "aria-expanded" ) === "true";
					const nowOpen    = ! isExpanded;

					toggle.setAttribute( "aria-expanded", String( nowOpen ) );
					// Toggle Tailwind's hidden utility class (display:none)
					mobileMenu.classList.toggle( "hidden", ! nowOpen );
					document.body.classList.toggle( "mobile-menu-open", nowOpen );
				}
			);
		}

		// ── Desktop nav: inject chevron SVG into parent items ──────────────────
		document.querySelectorAll( "#primary-menu > .menu-item-has-children > a" ).forEach(
			function (link) {
				const chevron     = document.createElement( "span" );
				chevron.className = "nav-chevron";
				chevron.setAttribute( "aria-hidden", "true" );
				chevron.innerHTML =
				'<svg width="11" height="11" viewBox="0 0 11 11" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4l3.5 3.5L9 4"/></svg>';
				link.appendChild( chevron );
			}
		);

		// ── Desktop nav: dropdown open/close with close delay ──────────────────
		// Using a JS-managed .is-open class + 200ms close delay instead of pure
		// CSS :hover, so the cursor has time to cross the gap between the nav
		// link and the dropdown panel without the menu disappearing.
		document.querySelectorAll( "#primary-menu > .menu-item-has-children" ).forEach(
			function (item) {
				let closeTimer = null;

				item.addEventListener(
					"mouseenter",
					function () {
						if (closeTimer) {
							clearTimeout( closeTimer );
							closeTimer = null;
						}
						item.classList.add( "is-open" );
					}
				);

				item.addEventListener(
					"mouseleave",
					function () {
						closeTimer = setTimeout(
							function () {
								item.classList.remove( "is-open" );
								closeTimer = null;
							},
							200
						);
					}
				);
			}
		);

		// ── Mobile sub-menu toggles ─────────────────────────────────────────────
		document.querySelectorAll( "#mobile-menu-items .menu-item-has-children" ).forEach(
			function (item) {
				const link    = item.querySelector( ":scope > a" );
				const subMenu = item.querySelector( ":scope > .sub-menu" );
				if ( ! link || ! subMenu) {
					return;
				}

				// Inject a chevron toggle button after the link
				const btn     = document.createElement( "button" );
				btn.className = "sub-menu-toggle";
				btn.setAttribute( "aria-expanded", "false" );
				btn.setAttribute( "aria-label", "Toggle sub-menu" );
				btn.innerHTML =
				'<svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4l4 4 4-4"/></svg>';
				link.after( btn );

				btn.addEventListener(
					"click",
					function () {
						const isOpen = item.classList.toggle( "open" );
						btn.setAttribute( "aria-expanded", String( isOpen ) );
					}
				);
			}
		);

		// ── Team member modals ──────────────────────────────────────────────────
		function openModal( modal ) {
			if ( ! modal ) {
				return;
			}
			modal.classList.add( "active" );
			modal.setAttribute( "aria-hidden", "false" );
			document.body.style.overflow = "hidden";
			// Move focus into the panel for accessibility.
			const closeBtn = modal.querySelector( ".team-modal__close" );
			if (closeBtn) {
				closeBtn.focus();
			}
		}

		function closeModal( modal ) {
			if ( ! modal) {
				return;
			}
			modal.classList.remove( "active" );
			modal.setAttribute( "aria-hidden", "true" );
			// Restore scroll only if no other modals are open.
			if ( ! document.querySelector( ".team-modal.active" )) {
				document.body.style.overflow = "";
			}
		}

		// Open on card click or Enter/Space key.
		document.querySelectorAll( ".team-card[data-modal-id]" ).forEach(
			function (card) {
				card.addEventListener(
					"click",
					function () {
						const modal = document.getElementById( card.getAttribute( "data-modal-id" ) );
						openModal( modal );
					}
				);
				card.addEventListener(
					"keydown",
					function (e) {
						if (e.key === "Enter" || e.key === " ") {
							e.preventDefault();
							const modal = document.getElementById( card.getAttribute( "data-modal-id" ) );
							openModal( modal );
						}
					}
				);
			}
		);

		// Close on backdrop / close button click.
		document.querySelectorAll( "[data-close]" ).forEach(
			function (el) {
				el.addEventListener(
					"click",
					function () {
						closeModal( el.closest( ".team-modal" ) );
					}
				);
			}
		);

		// Close on Escape key.
		window.addEventListener(
			"keydown",
			function (e) {
				if (e.key === "Escape") {
					document.querySelectorAll( ".team-modal.active" ).forEach( closeModal );
				}
			}
		);
	}
);
