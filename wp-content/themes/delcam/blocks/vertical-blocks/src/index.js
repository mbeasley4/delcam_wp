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

					<PanelBody title="Section Header" initialOpen={ true }>
						<TextControl
							label="Section Label"
							help='Short eyebrow label, e.g. "// Our Approach"'
							value={ attributes.sectionLabel }
							onChange={ ( v ) => setAttributes( { sectionLabel: v } ) }
						/>
						<TextControl
							label="Headline"
							help='Use \n for a line break or [span class="..."] for styled spans.'
							value={ attributes.headline }
							onChange={ ( v ) => setAttributes( { headline: v } ) }
						/>
						<TextareaControl
							label="Intro Content"
							value={ attributes.content }
							onChange={ ( v ) => setAttributes( { content: v } ) }
						/>
					</PanelBody>

					<PanelBody title="Countdown Inset" initialOpen={ false }>
						<TextControl
							label="Number"
							help='The large display value, e.g. "60–90"'
							value={ attributes.countdownNumber }
							onChange={ ( v ) => setAttributes( { countdownNumber: v } ) }
						/>
						<TextControl
							label="Label"
							help='The mono label beneath the number, e.g. "DAYS TO CLOSE"'
							value={ attributes.countdownLabel }
							onChange={ ( v ) => setAttributes( { countdownLabel: v } ) }
						/>
					</PanelBody>

					<PanelBody title="Process Steps" initialOpen={ false }>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '0', lineHeight: 1.5 } }>
							Steps are managed via the <strong>vertical_blocks</strong> ACF repeater field on this page. Each entry has a <code>title</code> and <code>content</code> field. Only the first three steps are displayed.
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
