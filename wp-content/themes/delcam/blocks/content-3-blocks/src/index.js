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
							label="Headline"
							help='Use [span class="..."] for styled spans.'
							value={ attributes.headline }
							onChange={ ( v ) => setAttributes( { headline: v } ) }
						/>
						<TextareaControl
							label="Intro Text"
							value={ attributes.mainContent }
							onChange={ ( v ) => setAttributes( { mainContent: v } ) }
						/>
					</PanelBody>

					{/* ── Card 1 ── */}
					<PanelBody title="Card 1" initialOpen={ false }>
						<TextControl
							label="Headline"
							value={ attributes.headline1 }
							onChange={ ( v ) => setAttributes( { headline1: v } ) }
						/>
						<TextareaControl
							label="Content"
							value={ attributes.content1 }
							onChange={ ( v ) => setAttributes( { content1: v } ) }
						/>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '0', lineHeight: 1.5 } }>
							Set a custom icon via the <strong>icon_1</strong> ACF image field on this page.
						</p>
					</PanelBody>

					{/* ── Card 2 ── */}
					<PanelBody title="Card 2" initialOpen={ false }>
						<TextControl
							label="Headline"
							value={ attributes.headline2 }
							onChange={ ( v ) => setAttributes( { headline2: v } ) }
						/>
						<TextareaControl
							label="Content"
							value={ attributes.content2 }
							onChange={ ( v ) => setAttributes( { content2: v } ) }
						/>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '0', lineHeight: 1.5 } }>
							Set a custom icon via the <strong>icon_2</strong> ACF image field on this page.
						</p>
					</PanelBody>

					{/* ── Card 3 ── */}
					<PanelBody title="Card 3" initialOpen={ false }>
						<TextControl
							label="Headline"
							value={ attributes.headline3 }
							onChange={ ( v ) => setAttributes( { headline3: v } ) }
						/>
						<TextareaControl
							label="Content"
							value={ attributes.content3 }
							onChange={ ( v ) => setAttributes( { content3: v } ) }
						/>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '0', lineHeight: 1.5 } }>
							Set a custom icon via the <strong>icon_3</strong> ACF image field on this page.
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
