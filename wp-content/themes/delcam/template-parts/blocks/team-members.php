<?php
$headline = get_field('headline');
$content = get_field('content');
?>
<section class="team-grid">
    <!-- Leadership Section -->
    <h2 class="team-grid__title">Leadership Team</h2>
    <div class="team-grid__wrapper">
        <?php
      $leadership_args = array(
          'post_type' => 'team_member',
          'posts_per_page' => -1,
          'orderby' => 'menu_order',
          'order' => 'ASC',
          'tax_query' => array(
              array(
                  'taxonomy' => 'team_category',
                  'field'    => 'slug',
                  'terms'    => 'leadership'
              )
          )
      );
$leadership_query = new WP_Query($leadership_args);

if ($leadership_query->have_posts()) :
    while ($leadership_query->have_posts()) : $leadership_query->the_post();
        $id = get_the_ID();
        $email = get_field('email_address', $id);
        $phone = get_field('phone_number', $id);
        $linkedin = get_field('linkedin_url', $id);
        ?>
        <div class="team-card" data-aos="fade-up" data-aos-delay="100" data-aos-duration="600"
            data-modal-id="modal-<?php echo esc_attr($id); ?>">
            <div class="team-card__photo">
                <?php
      if (has_post_thumbnail()) {
          the_post_thumbnail('medium', ['alt' => esc_attr(get_the_title())]);
      } else {
          echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/placeholder-team.png') . '" alt="Team member placeholder">';
      }
        ?>
            </div>

            <h3 class="team-card__name"><?php the_title(); ?></h3>

            <?php if (!empty($email)) : ?>
            <p class="team-card__email">
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            </p>
            <?php endif; ?>

            <?php if (!empty($phone)) : ?>
            <p class="team-card__phone">
                <a href="tel:<?php echo esc_attr(preg_replace('/\D+/', '', $phone)); ?>">
                    <?php echo esc_html($phone); ?>
                </a>
            </p>
            <?php endif; ?>

            <?php if (!empty($linkedin)) : ?>
            <p class="team-card__linkedin">
                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener">LinkedIn</a>
            </p>
            <?php endif; ?>
        </div>

        <!-- Modal Content -->
        <?php
          // Prepare modal image HTML once for reuse
          $modal_img_html = has_post_thumbnail()
        ? get_the_post_thumbnail($id, 'large', ['class' => 'team-modal__img', 'alt' => esc_attr(get_the_title())])
        : '<img class="team-modal__img" src="' . esc_url(get_template_directory_uri() . '/assets/images/placeholder-team.png') . '" alt="Team member placeholder">';
        ?>
        <div id="modal-<?php echo esc_attr($id); ?>" class="team-modal" role="dialog" aria-modal="true"
            aria-labelledby="modal-title-<?php echo esc_attr($id); ?>" aria-hidden="true" tabindex="-1">

            <div class="team-modal__overlay" data-close></div>

            <div class="team-modal__content" role="document">
                <button class="team-modal__close" data-close aria-label="Close">&times;</button>

                <div class="team-modal__header">
                    <div class="team-modal__media">
                        <?php echo $modal_img_html; ?>
                    </div>
                    <div class="team-modal__meta">
                        <h2 id="modal-title-<?php echo esc_attr($id); ?>" class="team-modal__title">
                            <?php the_title(); ?></h2>

                        <ul class="team-modal__contacts">
                            <?php if (!empty($email)) : ?>
                            <li>
                                <a class="contact-chip" href="mailto:<?php echo esc_attr($email); ?>">
                                    <span class="contact-chip__icon" aria-hidden="true">✉️</span>
                                    <span class="contact-chip__text"><?php echo esc_html($email); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if (!empty($phone)) : ?>
                            <li>
                                <a class="contact-chip"
                                    href="tel:<?php echo esc_attr(preg_replace('/\D+/', '', $phone)); ?>">
                                    <span class="contact-chip__icon" aria-hidden="true">📞</span>
                                    <span class="contact-chip__text"><?php echo esc_html($phone); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if (!empty($linkedin)) : ?>
                            <li>
                                <a class="contact-chip" href="<?php echo esc_url($linkedin); ?>" target="_blank"
                                    rel="noopener">
                                    <span class="contact-chip__icon" aria-hidden="true">in</span>
                                    <span class="contact-chip__text">LinkedIn</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="team-modal__body">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

        <?php endwhile;
wp_reset_postdata();
else :
    echo '<p>No leadership team members found.</p>';
endif;
?>
    </div>

    <!-- Advisory Section -->
    <h2 class="team-grid__title">Advisory Board</h2>
    <div class="team-grid__wrapper">
        <?php
$advisory_args = array(
    'post_type' => 'team_member',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'tax_query' => array(
        array(
            'taxonomy' => 'team_category',
            'field'    => 'slug',
            'terms'    => 'advisory'
        )
    )
);
$advisory_query = new WP_Query($advisory_args);

if ($advisory_query->have_posts()) :
    while ($advisory_query->have_posts()) : $advisory_query->the_post();
        $id = get_the_ID();
        $email = get_field('email_address', $id);
        $phone = get_field('phone_number', $id);
        $linkedin = get_field('linkedin_url', $id);
        ?>
        <?php
// Assume $id, $email, $phone, $linkedin already set for the current team member post.
        ?>
        <div class="team-card" data-aos="fade-up" data-aos-delay="100" data-aos-duration="600"
            data-modal-id="modal-<?php echo esc_attr($id); ?>">
            <div class="team-card__photo">
                <?php
              if (has_post_thumbnail()) {
                  the_post_thumbnail('medium', ['alt' => esc_attr(get_the_title())]);
              } else {
                  echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/placeholder-team.png') . '" alt="Team member placeholder">';
              }
        ?>
            </div>

            <h3 class="team-card__name"><?php the_title(); ?></h3>

            <?php if (!empty($email)) : ?>
            <p class="team-card__email">
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            </p>
            <?php endif; ?>

            <?php if (!empty($phone)) : ?>
            <p class="team-card__phone">
                <a href="tel:<?php echo esc_attr(preg_replace('/\D+/', '', $phone)); ?>">
                    <?php echo esc_html($phone); ?>
                </a>
            </p>
            <?php endif; ?>

            <?php if (!empty($linkedin)) : ?>
            <p class="team-card__linkedin">
                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener">LinkedIn</a>
            </p>
            <?php endif; ?>
        </div>

        <!-- Modal Content -->
        <?php
          // Prepare modal image HTML once for reuse
          $modal_img_html = has_post_thumbnail()
        ? get_the_post_thumbnail($id, 'large', ['class' => 'team-modal__img', 'alt' => esc_attr(get_the_title())])
        : '<img class="team-modal__img" src="' . esc_url(get_template_directory_uri() . '/assets/images/placeholder-team.png') . '" alt="Team member placeholder">';
        ?>
        <div id="modal-<?php echo esc_attr($id); ?>" class="team-modal" role="dialog" aria-modal="true"
            aria-labelledby="modal-title-<?php echo esc_attr($id); ?>" aria-hidden="true" tabindex="-1">

            <div class="team-modal__overlay" data-close></div>

            <div class="team-modal__content" role="document">
                <button class="team-modal__close" data-close aria-label="Close">&times;</button>

                <div class="team-modal__header">
                    <div class="team-modal__media">
                        <?php echo $modal_img_html; ?>
                    </div>
                    <div class="team-modal__meta">
                        <h2 id="modal-title-<?php echo esc_attr($id); ?>" class="team-modal__title">
                            <?php the_title(); ?></h2>

                        <ul class="team-modal__contacts">
                            <?php if (!empty($email)) : ?>
                            <li>
                                <a class="contact-chip" href="mailto:<?php echo esc_attr($email); ?>">
                                    <span class="contact-chip__icon" aria-hidden="true">✉️</span>
                                    <span class="contact-chip__text"><?php echo esc_html($email); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if (!empty($phone)) : ?>
                            <li>
                                <a class="contact-chip"
                                    href="tel:<?php echo esc_attr(preg_replace('/\D+/', '', $phone)); ?>">
                                    <span class="contact-chip__icon" aria-hidden="true">📞</span>
                                    <span class="contact-chip__text"><?php echo esc_html($phone); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>

                            <?php if (!empty($linkedin)) : ?>
                            <li>
                                <a class="contact-chip" href="<?php echo esc_url($linkedin); ?>" target="_blank"
                                    rel="noopener">
                                    <span class="contact-chip__icon" aria-hidden="true">in</span>
                                    <span class="contact-chip__text">LinkedIn</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div class="team-modal__body">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

        <?php endwhile;
wp_reset_postdata();
else :
    echo '<p>No advisory board members found.</p>';
endif;
?>
    </div>
</section>