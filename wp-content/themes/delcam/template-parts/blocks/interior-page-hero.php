<?php
    $image = !empty(get_field('background_image'))? get_field('background_image') : [];
    $headline = !empty(get_field('headline'))? get_field('headline') : '';
    $content = !empty(get_field('content'))? get_field('content') : '';

    $style = '';
    if (!empty($image)) {
         $style = ' style="background-image: url('.$image['url'].');"';
    }
    $content = wpautop($content);
    $content = preg_replace(
        '/<p([^>]*)>/',
        '<p$1 data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="200">',
        $content
    );
?>
<section class="interior-hero" <?php echo $style;?>>
    <div class="interior-hero__content">
        <h1 class="interior-hero__title" data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="200">
            <?php echo formatHeadline($headline);?></h1>
        <?php if (!empty($content)):?>
        <?php echo $content?>
        <?php endif; ?>
    </div>
</section>