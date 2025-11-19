<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DelCam_Capital
 */

$grid_layout_class = get_query_var('grid_layout_class', '');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($grid_layout_class); ?>>
    <?php if ($grid_layout_class != 'is-rail'): ?>
    <?php delcam_post_thumbnail(); ?>
    <?php endif; ?>
    <header class="entry-header">
        <?php
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
if ('post' === get_post_type()) :
    ?>
        <div class="entry-meta">
            <?php delcam_posted_on(); ?>
        </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->
    <div class="entry-content">
        <?php
        $length = 55;
if ($grid_layout_class === 'is-rail'):
    $length = 20;
endif;

echo excerpt($length);

?>
    </div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->