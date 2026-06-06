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
					<PanelBody title="Content" initialOpen={ true }>
						<TextControl
							label="Headline"
							value={ attributes.headline }
							onChange={ ( v ) => setAttributes( { headline: v } ) }
						/>
						<TextareaControl
							label="Body Text"
							help="Separate paragraphs with a blank line."
							value={ attributes.content }
							onChange={ ( v ) => setAttributes( { content: v } ) }
						/>
					</PanelBody>

					<PanelBody title="Primary Button" initialOpen={ false }>
						<TextControl
							label="Label"
							value={ attributes.button1Label }
							onChange={ ( v ) => setAttributes( { button1Label: v } ) }
						/>
						<TextControl
							label="URL"
							value={ attributes.button1Url }
							onChange={ ( v ) => setAttributes( { button1Url: v } ) }
						/>
						<TextControl
							label='Target (e.g. "_blank")'
							value={ attributes.button1Target }
							onChange={ ( v ) => setAttributes( { button1Target: v } ) }
						/>
					</PanelBody>

					<PanelBody title="Secondary Button" initialOpen={ false }>
						<TextControl
							label="Label"
							value={ attributes.button2Label }
							onChange={ ( v ) => setAttributes( { button2Label: v } ) }
						/>
						<TextControl
							label="URL"
							value={ attributes.button2Url }
							onChange={ ( v ) => setAttributes( { button2Url: v } ) }
						/>
						<TextControl
							label='Target (e.g. "_blank")'
							value={ attributes.button2Target }
							onChange={ ( v ) => setAttributes( { button2Target: v } ) }
						/>
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
