import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, SelectControl, Button, ToggleControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

import metadata from '../block.json';

const ICON_OPTIONS = [
	{ label: 'Building',  value: 'building' },
	{ label: 'Chart',     value: 'chart'    },
	{ label: 'Team',      value: 'team'     },
	{ label: 'Tech',      value: 'tech'     },
	{ label: 'Globe',     value: 'globe'    },
];

const DEFAULT_CARD = {
	title:     '',
	content:   '',
	icon:      'building',
	link_text: 'Learn more',
	link_url:  '/strategy/',
};

function updateCard( cards, index, field, value ) {
	return cards.map( ( card, i ) =>
		i === index ? { ...card, [ field ]: value } : card
	);
}

registerBlockType( metadata.name, {
	edit( { attributes, setAttributes } ) {
		const blockProps = useBlockProps();
		const cards = attributes.strategyCards || [];

		return (
			<>
				<InspectorControls>

					<PanelBody title="Section Header" initialOpen={ true }>
						<TextControl
							label="Section Label"
							help='Short eyebrow label, e.g. "// Investment Focus"'
							value={ attributes.sectionLabel }
							onChange={ ( v ) => setAttributes( { sectionLabel: v } ) }
						/>
						<TextControl
							label="Headline"
							value={ attributes.sectionHeadline }
							onChange={ ( v ) => setAttributes( { sectionHeadline: v } ) }
						/>
						<TextareaControl
							label="Description"
							value={ attributes.description }
							onChange={ ( v ) => setAttributes( { description: v } ) }
						/>
					</PanelBody>

					<PanelBody title="Banner" initialOpen={ false }>
						<TextControl
							label="Badge Text"
							value={ attributes.bannerBadge }
							onChange={ ( v ) => setAttributes( { bannerBadge: v } ) }
						/>
						<TextControl
							label="Banner Headline"
							value={ attributes.bannerHeadline }
							onChange={ ( v ) => setAttributes( { bannerHeadline: v } ) }
						/>
					</PanelBody>

					<PanelBody title={ `Strategy Cards (${ cards.length })` } initialOpen={ false }>

						{ cards.map( ( card, index ) => (
							<PanelBody
								key={ index }
								title={ card.title || `Card ${ index + 1 }` }
								initialOpen={ false }
							>
								<TextControl
									label="Title"
									value={ card.title }
									onChange={ ( v ) => setAttributes( { strategyCards: updateCard( cards, index, 'title', v ) } ) }
								/>
								<TextareaControl
									label="Content"
									value={ card.content }
									onChange={ ( v ) => setAttributes( { strategyCards: updateCard( cards, index, 'content', v ) } ) }
								/>
								<SelectControl
									label="Icon"
									value={ card.icon }
									options={ ICON_OPTIONS }
									onChange={ ( v ) => setAttributes( { strategyCards: updateCard( cards, index, 'icon', v ) } ) }
								/>
								<TextControl
									label="Link Text"
									value={ card.link_text }
									onChange={ ( v ) => setAttributes( { strategyCards: updateCard( cards, index, 'link_text', v ) } ) }
								/>
								<TextControl
									label="Link URL"
									value={ card.link_url }
									onChange={ ( v ) => setAttributes( { strategyCards: updateCard( cards, index, 'link_url', v ) } ) }
								/>
								<Button
									isDestructive
									variant="tertiary"
									style={ { marginTop: '8px' } }
									onClick={ () => setAttributes( { strategyCards: cards.filter( ( _, i ) => i !== index ) } ) }
								>
									Remove Card
								</Button>
							</PanelBody>
						) ) }

						<Button
							variant="secondary"
							style={ { marginTop: '8px', width: '100%' } }
							onClick={ () => setAttributes( { strategyCards: [ ...cards, { ...DEFAULT_CARD } ] } ) }
						>
							+ Add Card
						</Button>

					</PanelBody>

					<PanelBody title="CTA Card" initialOpen={ false }>
						<TextControl
							label="Eyebrow Label"
							value={ attributes.ctaLabel }
							onChange={ ( v ) => setAttributes( { ctaLabel: v } ) }
						/>
						<TextControl
							label="Headline"
							value={ attributes.ctaHeadline }
							onChange={ ( v ) => setAttributes( { ctaHeadline: v } ) }
						/>
						<TextareaControl
							label="Body Text"
							value={ attributes.ctaContent }
							onChange={ ( v ) => setAttributes( { ctaContent: v } ) }
						/>
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
