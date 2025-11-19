<?php
$headline = !empty(get_field('headline')) ? get_field('headline') : '';
$content = !empty(get_field('content')) ? get_field('content') : '';
$button_1 = !empty(get_field('button_1')) ? get_field('button_1') : '';
$button_2 = !empty(get_field('button_2')) ? get_field('button_2') : '';
?>
<section class="basic">
    <h2><?php echo $headline;?></h2>
    <?php echo wpautop($content);?>
    <?php if (!empty($button_1) || !empty($button_2)):?>
    <div class="button-group">
        <a href="#" class="btn"></a><a href="#" class="btn"></a>
    </div>
    <?php endif; ?>
</section>