<?php
/**
 * Block: Prose Content
 * Constrained prose wrapper for legal / text-heavy pages.
 *
 * $content contains the rendered inner blocks HTML.
 *
 * @package DelCam_Capital
 */

$wrapper_attrs = get_block_wrapper_attributes();
?>

<section <?php echo $wrapper_attrs; ?>>
	<div class="prose-content">
		<?php echo $content; ?>
	</div>
</section>
