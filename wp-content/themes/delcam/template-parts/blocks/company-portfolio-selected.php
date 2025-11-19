<?php
$headline = !empty(get_field('headline')) ? get_field('headline') : '';
$content = !empty(get_field('content')) ? get_field('content') : '3';
$limit = !empty(get_field('limit')) ? get_field('limit') : 3;
$selected_ids = !empty(get_field('selected_companies')) ? get_field('selected_companies') : [];
$cta_button = !empty(get_field('call-to-action_button')) ? get_field('call-to-action_button') : '';
?>
<section class="delcam-portfolio block">
    <div class="section-headline">
        <?php if (!empty($headline)):?>
        <h2><?php echo formatHeadline($headline);?></h2>
        <?php endif;?>
        <?php if (!empty($content)):?>
        <?php echo wpautop($content);?>
        <?php endif;?>
    </div>
    <div class="portfolio-grid">
        <?php
 $args = array(
  'post_type'      => 'portfolio',
  'post__in'       => $selected_ids,
  'posts_per_page' => $limit,
  'orderby'        => 'post__in', // Maintain order of IDs
  'order'          => 'ASC',
);

$portfolio_query = new WP_Query($args);

if ($portfolio_query->have_posts()) :
    while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
        $content = get_the_content(); // ACF field
        $content = wpautop($content);
        $content = preg_replace(
            '/<p([^>]*)>/',
            '<p$1 data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="200">',
            $content
        );
        $terms = get_the_terms(get_the_ID(), 'portfolio_category'); // custom taxonomy
        ?>

        <a href="<?php echo $cta_button['url'];?>" class="portfolio-card" data-aos="fade-up">
            <div class="portfolio-card__image">
                <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('medium');
                    } ?>
            </div>
            <div class="portfolio-card__content">
                <h3 class="portfolio-card__title"><?php the_title(); ?></h3>

                <?php if (!empty($terms)) : ?>
                <div class="portfolio-card__categories">
                    <?php foreach ($terms as $term) : ?>
                    <span class="portfolio-category"><?php echo esc_html($term->name); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if ($content) : ?>
                <?php // echo $content;?>
                <?php endif; ?>
            </div>
        </a>

        <?php
    endwhile;
    wp_reset_postdata();
else :
    echo '<p>No portfolio items found.</p>';
endif; ?>
    </div>
    <?php if (!empty($cta_button)): ?>
    <div class="button-group align-center" data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="100"
        data-aos-offset="50">
        <a href="<?php echo $cta_button['url'];?>" class="btn"><?php echo $cta_button['title'];?></a>
    </div>
    <?php endif; ?>
</section>