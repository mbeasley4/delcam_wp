import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, RangeControl, ToggleControl } from '@wordpress/components';
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
							help='Short eyebrow label, e.g. "// Featured Companies"'
							value={ attributes.sectionLabel }
							onChange={ ( v ) => setAttributes( { sectionLabel: v } ) }
						/>
						<TextControl
							label="Headline"
							help='Use \n for a line break or [span class="..."] for styled spans.'
							value={ attributes.sectionHeadline }
							onChange={ ( v ) => setAttributes( { sectionHeadline: v } ) }
						/>
						<TextareaControl
							label="Description"
							value={ attributes.description }
							onChange={ ( v ) => setAttributes( { description: v } ) }
						/>
					</PanelBody>

					{/* ── Display ── */}
					<PanelBody title="Display" initialOpen={ false }>
						<RangeControl
							label="Max Cards to Show"
							value={ attributes.limit }
							onChange={ ( v ) => setAttributes( { limit: v } ) }
							min={ 1 }
							max={ 12 }
						/>
					</PanelBody>

					{/* ── CTA Button ── */}
					<PanelBody title="CTA Button" initialOpen={ false }>
						<TextControl
							label="Button Text"
							value={ attributes.ctaButtonText }
							onChange={ ( v ) => setAttributes( { ctaButtonText: v } ) }
						/>
						<TextControl
							label="Button URL"
							value={ attributes.ctaButtonUrl }
							onChange={ ( v ) => setAttributes( { ctaButtonUrl: v } ) }
						/>
					</PanelBody>

					{/* ── Company Selection ── */}
					<PanelBody title="Company Selection" initialOpen={ false }>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '0', lineHeight: 1.5 } }>
							Choose which companies to feature via the <strong>selected_companies</strong> ACF relationship field on this page. Companies are displayed in the order selected, up to the Max Cards limit. Leave empty to show placeholder cards.
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
