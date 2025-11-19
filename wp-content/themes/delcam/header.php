<?php
/**
 * The header for our theme
 *
 * Displays <head> and everything up until <div id="content">
 *
 * @package DelCam_Capital
 */
$eyebrow_message = get_field('eyebrow_message', 'option');
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5RKT81XXEH"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-5RKT81XXEH');
    </script>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'delcam'); ?></a>

        <?php if (!empty($eyebrow_message)): ?>
        <div class="eyebrow">
            <?php echo wpautop($eyebrow_message); ?>
        </div>
        <?php endif; ?>

        <header id="masthead" class="site-header">
            <div class="site-header-container">

                <!-- LOGO -->
                <div class="site-branding">
                    <?php the_custom_logo(); ?>
                    <?php
                $delcam_description = get_bloginfo('description', 'display');
if ($delcam_description || is_customize_preview()) : ?>
                    <p class="site-description"><?php echo $delcam_description; ?></p>
                    <?php endif; ?>
                </div>

                <!-- DESKTOP NAV -->
                <nav id="site-navigation" class="main-navigation desktop-nav">
                    <?php
wp_nav_menu([
    'theme_location' => 'menu-1',
    'menu_id'        => 'primary-menu',
]);
?>
                </nav>

                <!-- MOBILE NAV TRIGGER -->
                <button class="mobile-menu-toggle" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="hamburger"></span>
                    <span class="screen-reader-text">Menu</span>
                </button>

            </div><!-- .site-header-container -->

            <!-- MOBILE MENU -->
            <nav id="mobile-menu" class="mobile-navigation" hidden>
                <?php
            wp_nav_menu([
'theme_location' => 'menu-1',
'menu_id'        => 'mobile-menu-items',
            ]);
?>
            </nav>

        </header>