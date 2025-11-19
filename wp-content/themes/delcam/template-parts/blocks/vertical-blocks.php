<?php
    $image = !empty(get_field('image')) ? get_field('image') : ''; 
    $headline = !empty(get_field('headline')) ? get_field('headline') : ''; 
    $content = !empty(get_field('content')) ? get_field('content') : '';
    $vertical_blocks = !empty(get_field('vertical_blocks')) ? get_field('vertical_blocks') : [];
?>
<section class="section split-vertical-blocks">
    <div class="container split-vertical-blocks__inner">
        <div class="split-vertical-blocks__content">
            <h2><?php echo formatHeadline($headline);?></h2>
            <?php echo wpautop($content);?>
        </div>
        <div class="split-vertical-blocks__blocks">
            <?php
            if (!empty($vertical_blocks)) :
            ?>
            <div class="vertical-block">
                <?php foreach ($vertical_blocks as $vert_block) : ?>
                <div class="block-item">
                    <h3><?php echo formatHeadline($vert_block['title']); ?></h3>
                    <div class="block-content">
                        <?php echo wp_kses_post($vert_block['content']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>