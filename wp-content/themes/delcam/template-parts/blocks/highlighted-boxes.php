<?php
$headline = !empty(get_field('headline')) ? get_field('headline') : '';
$content = !empty(get_field('content')) ? get_field('content') : '';
$highlights = !empty(get_field('highlights')) ? get_field('highlights') : [];

?>

<section class="highlighted-section" data-aos="fade-up">
    <h2 class=" highlighted-section__title" data-aos="fade-up" data-aos-delay="100">
        <?php echo formatHeadline($headline); ?></h2>
    <?php if (!empty($content)): ?>
    <?php echo wpautop($content); ?>
    <?php endif; ?>
    <div class="highlighted-grid">
        <?php
            $delay = 0;
foreach ($highlights as $highlight):
    $icon = !empty($highlight['icon']) ? $highlight['icon'] : []; ?>
        <div class="highlighted-box" data-aos="fade-up" data-aos-delay="<?php echo $delay;?>">
            <?php if (!empty($icon)):?>
            <div class="icon-wrapper"><img src="<?php echo $icon['url'];?>" alt="<?php echo $icon['alt'];?>" />
            </div>
            <?php endif; ?>
            <h3><?php echo $highlight['headline'];?></h3>
            <?php echo wpautop($highlight['content']); ?>
        </div>
        <?php
    $delay += 100;
endforeach; ?>
    </div>
</section>