<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DelCam_Capital
 */
global $wp_query;
get_header();
?>

<main id="primary" class="site-main">
    <?php
    $image = !empty(get_field('insights_background_image', 'options')) ? get_field('insights_background_image', 'options') : [];
$headline = !empty(get_field('insights_headline', 'options')) ? get_field('insights_headline', 'options') : '';
$content = !empty(get_field('insights_content', 'options')) ? get_field('insights_content', 'options') : '';
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
    <section class="grid-list posts">
        <div class="container">
            <?php
        $i = 0;
while (have_posts()) :

    $post_count   = $wp_query->post_count;

    the_post();
    $i++;

    // Decide the layout slot for each post
    $layout = ($i === 1) ? 'is-featured' : (($i <= 4) ? 'is-rail' : 'is-standard');

    // Make the layout available inside the template part
    set_query_var('grid_layout_class', $layout);
    if ($i === 2):?>
            <div class="is-rail">
                <?php endif;
    get_template_part('template-parts/content', 'post');
    if ($i === 4 || $i === $post_count):?>
            </div>
            <?php endif;
endwhile;

the_posts_navigation();
?>
        </div>
    </section>
</main><!-- #main -->

<?php
get_footer();
