import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, ToggleControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from '../block.json';

registerBlockType( metadata.name, {
	edit( { attributes, setAttributes } ) {
		const blockProps = useBlockProps();

		return (
			<>
				<InspectorControls>

					{/* ── Section Header ── */}
					<PanelBody title="Section Header" initialOpen={ true }>
						<TextControl
							label="Section Label"
							help='Short eyebrow label, e.g. "// Our People"'
							value={ attributes.sectionLabel }
							onChange={ ( v ) => setAttributes( { sectionLabel: v } ) }
						/>
						<TextControl
							label="Headline"
							help='Use [span class="..."] for styled spans.'
							value={ attributes.sectionHeadline }
							onChange={ ( v ) => setAttributes( { sectionHeadline: v } ) }
						/>
					</PanelBody>

					{/* ── Leadership ── */}
					<PanelBody title="Leadership Group" initialOpen={ false }>
						<TextControl
							label="Group Label"
							help="Appears above the leadership card grid."
							value={ attributes.leadershipLabel }
							onChange={ ( v ) => setAttributes( { leadershipLabel: v } ) }
						/>
						<TextControl
							label="Modal Eyebrow"
							help="Small label shown at the top of each leadership bio modal."
							value={ attributes.leadershipEyebrow }
							onChange={ ( v ) => setAttributes( { leadershipEyebrow: v } ) }
						/>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '8px 0 0', lineHeight: 1.5 } }>
							Members are pulled from the <strong>team_member</strong> CPT filtered by the <code>leadership</code> taxonomy term. Manage them via <em>Team Members → Leadership</em> in the WP admin.
						</p>
					</PanelBody>

					{/* ── Advisory ── */}
					<PanelBody title="Advisory Group" initialOpen={ false }>
						<TextControl
							label="Group Label"
							help="Appears above the advisory card grid."
							value={ attributes.advisoryLabel }
							onChange={ ( v ) => setAttributes( { advisoryLabel: v } ) }
						/>
						<TextControl
							label="Modal Eyebrow"
							help="Small label shown at the top of each advisory bio modal."
							value={ attributes.advisoryEyebrow }
							onChange={ ( v ) => setAttributes( { advisoryEyebrow: v } ) }
						/>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '8px 0 0', lineHeight: 1.5 } }>
							Members are pulled from the <strong>team_member</strong> CPT filtered by the <code>advisory</code> taxonomy term. Manage them via <em>Team Members → Advisory</em> in the WP admin.
						</p>
					</PanelBody>

					<PanelBody title="Appearance" initialOpen={ false }>
					<ToggleControl
						label="Dark Background"
						help={ attributes.darkBackground ? 'Navy background with light text.' : 'White background with dark text.' }
						checked={ !! attributes.darkBackground }
						onChange={ ( v ) => setAttributes( { darkBackground: v } ) }
					/>
				</PanelBody>

			</InspectorControls>

				<div { ...blockProps }>
					<ServerSideRender
						block={ metadata.name }
						attributes={ attributes }
					/>
				</div>
			</>
		);
	},

	// Dynamic block — PHP renders the final HTML, nothing saved to post content.
	save: () => null,
} );
