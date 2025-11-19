<?php
$video = !empty(get_field('background_video')) ? get_field('background_video') : '';
$image = !empty(get_field('background_image')) ? get_field('background_image') : '';
$headline = !empty(get_field('headline')) ? get_field('headline') : '';
$subhead = !empty(get_field('subhead')) ? get_field('subhead') : '';
?>
<section class="hero" style="background-image: url(<?php echo $image['url'];?>);">
    <?php if (!wp_is_mobile()):?>
    <video autoplay muted loop playsinline class="hero__video">
        <source src="<?php echo $video['url'];?>" type="video/mp4" />
    </video>
    <?php endif; ?>
    <div class="hero__overlay"></div>

    <div class="hero__content">
        <h1 class="hero__title" data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="200">
            <?php echo formatHeadline($headline);?></h1>
        <p class="hero__subtitle" data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="400">
            <?php echo $subhead;?>
        </p>
    </div>
</section>