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

					<PanelBody title="Section Header" initialOpen={ true }>
						<TextControl
							label="Section Label"
							help='Short eyebrow label, e.g. "// Target Sectors"'
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

					<PanelBody title="Sector Pills" initialOpen={ false }>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '0', lineHeight: 1.5 } }>
							Pills are managed via the <strong>sector_pills</strong> ACF repeater field on this page. Each entry has a <code>pill_label</code> field.
						</p>
					</PanelBody>

					<PanelBody title="Stat Cards" initialOpen={ false }>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '0', lineHeight: 1.5 } }>
							Stats are managed via the <strong>stat_cards</strong> ACF repeater field on this page. Each entry has <code>stat_value</code>, <code>is_gold</code>, <code>stat_label</code>, and <code>stat_description</code> fields.
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

	save: () => null,
} );
