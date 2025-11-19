<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DelCam_Capital
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
?>
        <div class="entry-meta">
            <?php
        delcam_posted_on();
?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

    <?php delcam_post_thumbnail(); ?>
    <div class="entry-content">
        <?php
        echo get_the_excerpt();
?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->