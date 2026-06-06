import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, RangeControl, ToggleControl, SelectControl } from '@wordpress/components';
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
							help='Eyebrow label, e.g. "// In The News"'
							value={ attributes.sectionLabel }
							onChange={ ( v ) => setAttributes( { sectionLabel: v } ) }
						/>
						<TextControl
							label="Headline"
							help='Use \n for a line break.'
							value={ attributes.sectionHeadline }
							onChange={ ( v ) => setAttributes( { sectionHeadline: v } ) }
						/>
						<TextareaControl
							label="Description"
							value={ attributes.description }
							onChange={ ( v ) => setAttributes( { description: v } ) }
						/>
					</PanelBody>

					{/* ── Filter ── */}
					<PanelBody title="Filter" initialOpen={ true }>
						<SelectControl
							label="News Type"
							value={ attributes.newsTypeSlug }
							options={ [
								{ label: 'All (News + Press Releases)', value: '' },
								{ label: 'In the News',                 value: 'in-the-news' },
								{ label: 'Press Release',               value: 'press-release' },
								{ label: 'White Paper',                 value: 'white-paper' },
							] }
							onChange={ ( v ) => setAttributes( { newsTypeSlug: v } ) }
						/>
						<RangeControl
							label="Posts Per Page"
							value={ attributes.postsPerPage }
							onChange={ ( v ) => setAttributes( { postsPerPage: v } ) }
							min={ 1 }
							max={ 24 }
						/>
					</PanelBody>

					{/* ── Appearance ── */}
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
