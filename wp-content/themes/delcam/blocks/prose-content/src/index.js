import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

import metadata from '../block.json';

registerBlockType( metadata.name, {
	edit() {
		const blockProps = useBlockProps( { className: 'prose-content' } );
		const innerBlocksProps = useInnerBlocksProps( blockProps );

		return <div { ...innerBlocksProps } />;
	},

	// Inner block HTML is stored in post content and passed as $content to render.php
	save() {
		const blockProps = useBlockProps.save();
		const innerBlocksProps = useInnerBlocksProps.save( blockProps );
		return <div { ...innerBlocksProps } />;
	},
} );
