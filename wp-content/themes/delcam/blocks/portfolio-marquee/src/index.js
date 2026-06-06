import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from '../block.json';

registerBlockType( metadata.name, {
	edit( { attributes } ) {
		const blockProps = useBlockProps();

		return (
			<>
				<InspectorControls>

					<PanelBody title="Portfolio Marquee" initialOpen={ true }>
						<p style={ { fontSize: '11px', color: '#6B7B8D', margin: '0', lineHeight: 1.5 } }>
							Company names are managed via the <strong>companies</strong> ACF repeater field on this page. Each entry has a <code>company_name</code> field. The list is duplicated automatically for seamless looping.
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
