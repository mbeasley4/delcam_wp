<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DelCam_Capital
 */

get_header();
?>
<main id="primary" class="site-main">
    <?php
    $image = !empty(get_field('news_background_image', 'options')) ? get_field('news_background_image', 'options') : [];
$headline = !empty(get_field('news_headline', 'options')) ? get_field('news_headline', 'options') : '';
$content = !empty(get_field('news_content', 'options')) ? get_field('news_content', 'options') : '';
$content = wpautop($content);
$content = preg_replace(
    '/<p([^>]*)>/',
    '<p$1 data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="200">',
    $content
);
$style = '';
if (!empty($image)) {
    $style = ' style="background-image: url('.$image['url'].');"';
}
?>
    <section class="interior-hero" <?php echo $style;?>>
        <div class="interior-hero__content">
            <h1 class="interior-hero__title" data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="200">
                <?php echo formatHeadline($headline);?></h1>
            <?php if (!empty($content)):?>
            <?php echo $content;?>
            <?php endif; ?>
        </div>
    </section>
    <section class="grid-list news">
        <div class="container">
            <?php
            /* Start the Loop */
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', 'news');
            endwhile;
the_posts_navigation();
?>
        </div>
    </section>
</main><!-- #main -->

<?php
get_footer();
