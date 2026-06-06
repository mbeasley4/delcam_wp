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
							help='Short eyebrow label, e.g. "// Our Funds"'
							value={ attributes.sectionLabel }
							onChange={ ( v ) => setAttributes( { sectionLabel: v } ) }
						/>
						<TextControl
							label="Headline"
							help='Use \n for a line break or [span class="..."] for styled spans.'
							value={ attributes.sectionHeadline }
							onChange={ ( v ) => setAttributes( { sectionHeadline: v } ) }
						/>
					</PanelBody>

					{/* ── Buttons ── */}
					<PanelBody title="Buttons" initialOpen={ false }>
						<TextControl
							label="Primary Button Text"
							value={ attributes.button1Text }
							onChange={ ( v ) => setAttributes( { button1Text: v } ) }
						/>
						<TextControl
							label="Primary Button URL"
							value={ attributes.button1Url }
							onChange={ ( v ) => setAttributes( { button1Url: v } ) }
						/>
						<TextControl
							label="Secondary Button Text"
							value={ attributes.button2Text }
							onChange={ ( v ) => setAttributes( { button2Text: v } ) }
						/>
						<TextControl
							label="Secondary Button URL"
							value={ attributes.button2Url }
							onChange={ ( v ) => setAttributes( { button2Url: v } ) }
						/>
					</PanelBody>

					{/* ── Funds ── */}
					<PanelBody title="Funds" initialOpen={ false }>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '0', lineHeight: 1.5 } }>
							Funds are managed via the <strong>funds</strong> ACF repeater field on this page. Each fund has a <code>fund_name</code>, <code>fund_description</code>, and a nested <code>portfolio_companies</code> repeater. Add or reorder entries in the <em>Custom Fields</em> panel below the editor.
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
