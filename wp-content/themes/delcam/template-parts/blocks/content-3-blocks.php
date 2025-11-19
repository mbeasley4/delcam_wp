<?php 
    $headline = !empty(get_field('headline')) ? get_field('headline') : ''; 
    $content = !empty(get_field('main_content')) ? get_field('main_content') : '';

    $block_1_icon = !empty(get_field('icon_1')) ? get_field('icon_1') : '';
    $block_1_headline = !empty(get_field('headline_1')) ? get_field('headline_1') : '';
    $block_1_content = !empty(get_field('content_1')) ? get_field('content_1') : '';

    $block_2_icon = !empty(get_field('icon_2')) ? get_field('icon_2') : '';
    $block_2_headline = !empty(get_field('headline_2')) ? get_field('headline_2') : '';
    $block_2_content = !empty(get_field('content_2')) ? get_field('content_2') : '';

    $block_3_icon = !empty(get_field('icon_3')) ? get_field('icon_3') : '';
    $block_3_headline = !empty(get_field('headline_3')) ? get_field('headline_3') : '';
    $block_3_content = !empty(get_field('content_3')) ? get_field('content_3') : '';
?>
<section class="callouts">
    <div class="callouts__heading">
        <h2><?php echo formatHeadline($headline);?></h2>
        <?php echo wpautop($content);?>
    </div>
    <div class="callouts__container">
        <div class="callout">
            <div class="callout__icon">
                <img src="<?php echo get_template_directory_uri(); ?>/images/icons/growth.svg" alt="Growth Icon" />
            </div>
            <h3 class="callout__title"><?php echo formatHeadline($block_1_headline);?></h3>
            <?php echo wpautop($block_1_content);?>
        </div>

        <div class="callout">
            <div class="callout__icon">
                <img src="<?php echo get_template_directory_uri(); ?>/images/icons/team.svg" alt="Team Icon" />
            </div>
            <h3 class="callout__title"><?php echo formatHeadline($block_2_headline);?></h3>
            <?php echo wpautop($block_2_content);?>
        </div>

        <div class="callout">
            <div class="callout__icon">
                <img src="<?php echo get_template_directory_uri(); ?>/images/icons/innovation.svg"
                    alt="Innovation Icon" />
            </div>
            <h3 class="callout__title"><?php echo formatHeadline($block_3_headline);?></h3>
            <?php echo wpautop($block_3_content);?>
        </div>

    </div>
</section>