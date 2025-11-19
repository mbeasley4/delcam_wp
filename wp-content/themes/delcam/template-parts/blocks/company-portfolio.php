<section class="delcam-portfolio">
    <?php
    $args = array(
      'post_type'      => 'portfolio',
      'posts_per_page' => -1,
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
    );

    $portfolio_query = new WP_Query($args);

    if ($portfolio_query->have_posts()) : ?>
    <ul class="portfolio-list" role="list">
        <?php
        while ($portfolio_query->have_posts()) :
            $portfolio_query->the_post();

            // Description (you noted this is coming from ACF; adjust if needed)
            $content = get_the_content();
            $content = wpautop($content);
            $content = preg_replace(
                '/<p([^>]*)>/',
                '<p$1 data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="200">',
                $content
            );

            $permalink = get_permalink();
            $terms     = get_the_terms(get_the_ID(), 'portfolio_category'); // optional
            ?>

        <li class="portfolio-item" data-aos="fade-up">
            <a class="portfolio-row" href="<?php echo esc_url($permalink); ?>"
                aria-label="<?php echo esc_attr(get_the_title()); ?>">
                <!-- Logo -->
                <div class="portfolio-logo">
                    <?php
                  if (has_post_thumbnail()) {
                      the_post_thumbnail('full', array('class' => 'portfolio-logo__img', 'alt' => get_the_title()));
                  } else {
                      // optional placeholder
                      echo '<div class="portfolio-logo__placeholder" aria-hidden="true"></div>';
                  }
            ?>
                </div>

                <!-- Title + Description -->
                <div class="portfolio-main">
                    <h3 class="portfolio-title"><?php the_title(); ?></h3>

                    <?php if (!empty($terms)) : ?>
                    <div class="portfolio-categories">
                        <?php foreach ($terms as $term) : ?>
                        <span class="portfolio-category"><?php echo esc_html($term->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($content)) : ?>
                    <div class="portfolio-desc">
                        <?php echo $content; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </a>
        </li>
        <?php endwhile; ?>
    </ul>
    <?php
      wp_reset_postdata();
    else :
        echo '<p>No portfolio items found.</p>';
    endif;
    ?>
</section>