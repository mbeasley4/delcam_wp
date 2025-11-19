<?php
$image = !empty(get_field('image')) ? get_field('image') : '';
$headline = !empty(get_field('headline')) ? get_field('headline') : '';
$content = !empty(get_field('content')) ? get_field('content') : '';
?>
<section class="section split-block">
    <div class="split-block__inner">
        <div class="split-block__media">
            <img src="<?php echo $image['url'];?>" alt="<?php echo $image['alt'];?>" />
        </div>
        <div class="split-block__content">
            <h2><?php echo formatHeadline($headline);?></h2>
            <?php echo wpautop($content);?>
        </div>
    </div>
</section>