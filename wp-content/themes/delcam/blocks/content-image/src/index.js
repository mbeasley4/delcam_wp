import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, ToggleControl, Button } from '@wordpress/components';
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
							label="Section Label"
							value={ attributes.sectionLabel }
							onChange={ ( v ) => setAttributes( { sectionLabel: v } ) }
						/>
						<TextControl
							label="Headline"
							help='Use <br> for line breaks. Wrap text in [span class="..."] for styled spans.'
							value={ attributes.headline }
							onChange={ ( v ) => setAttributes( { headline: v } ) }
						/>
						<TextareaControl
							label="Body Content"
							help="Supports basic HTML (p, strong, em, a, br)."
							value={ attributes.bodyContent }
							onChange={ ( v ) => setAttributes( { bodyContent: v } ) }
							rows={ 6 }
						/>
					</PanelBody>

					<PanelBody title="Image" initialOpen={ false }>
						<MediaUploadCheck>
							<MediaUpload
								onSelect={ ( media ) =>
									setAttributes( {
										imageUrl: media.url,
										imageAlt: media.alt,
										imageId: media.id,
									} )
								}
								allowedTypes={ [ 'image' ] }
								value={ attributes.imageId }
								render={ ( { open } ) => (
									<>
										{ attributes.imageUrl && (
											<img
												src={ attributes.imageUrl }
												alt={ attributes.imageAlt }
												style={ { width: '100%', marginBottom: '8px', borderRadius: '4px' } }
											/>
										) }
										<Button
											onClick={ open }
											variant="secondary"
											style={ { marginBottom: '8px', display: 'block' } }
										>
											{ attributes.imageUrl ? 'Replace Image' : 'Select Image' }
										</Button>
										{ attributes.imageUrl && (
											<Button
												onClick={ () =>
													setAttributes( { imageUrl: '', imageAlt: '', imageId: 0 } )
												}
												variant="link"
												isDestructive
											>
												Remove Image
											</Button>
										) }
									</>
								) }
							/>
						</MediaUploadCheck>
						<ToggleControl
							label="Image on Left"
							help={ attributes.swapImage ? 'Image appears on the left.' : 'Image appears on the right.' }
							checked={ attributes.swapImage }
							onChange={ ( v ) => setAttributes( { swapImage: v } ) }
						/>
					</PanelBody>

					<PanelBody title="CTA Button" initialOpen={ false }>
						<TextControl
							label="Button Label"
							value={ attributes.ctaLabel }
							onChange={ ( v ) => setAttributes( { ctaLabel: v } ) }
						/>
						<TextControl
							label="URL"
							value={ attributes.ctaUrl }
							onChange={ ( v ) => setAttributes( { ctaUrl: v } ) }
						/>
						<TextControl
							label='Target (e.g. "_blank")'
							value={ attributes.ctaTarget }
							onChange={ ( v ) => setAttributes( { ctaTarget: v } ) }
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
