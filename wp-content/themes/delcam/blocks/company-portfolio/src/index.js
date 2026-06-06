import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, ToggleControl } from '@wordpress/components';
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
							help='Short eyebrow label, e.g. "// Our Companies"'
							value={ attributes.sectionLabel }
							onChange={ ( v ) => setAttributes( { sectionLabel: v } ) }
						/>
						<TextControl
							label="Headline"
							help='Use [span class="..."] for styled spans.'
							value={ attributes.sectionHeadline }
							onChange={ ( v ) => setAttributes( { sectionHeadline: v } ) }
						/>
						<TextareaControl
							label="Description"
							value={ attributes.description }
							onChange={ ( v ) => setAttributes( { description: v } ) }
						/>
					</PanelBody>

					{/* ── Portfolio Companies ── */}
					<PanelBody title="Portfolio Companies" initialOpen={ false }>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '0', lineHeight: 1.5 } }>
							Companies are pulled from the <strong>portfolio</strong> CPT ordered by menu order. Manage them via <em>Portfolio</em> in the WP admin. Each post supports a featured image (logo), excerpt, <code>portfolio_category</code> taxonomy terms, and a <code>company_url</code> ACF field.
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
