<?php
$callout = !empty(get_field('callout')) ? get_field('callout') : '';
$button_1 = !empty(get_field('button_1')) ? get_field('button_1') : '';
$button_2 = !empty(get_field('button_2')) ? get_field('button_2') : '';
?>
<section class="lg-callout">
    <span data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="100" data-aos-offset="200">
        <?php echo $callout;?>
    </span>
    <div class="button-group" data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="100"
        data-aos-offset="50">
        <?php if (!empty($button_1)) : ?>
        <a href="<?php echo $button_1['url'];?>" class="btn"><?php echo $button_1['title'];?></a>
        <?php endif;
if (!empty($button_2)) : ?>
        <a href="<?php echo $button_2['url'];?>" class="btn btn--white"><?php echo $button_2['title'];?></a>
        <?php endif; ?>
    </div>
</section>