<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DelCam_Capital
 */
$img = get_field('footer_branding', 'option');
$address = get_field('footer_address', 'option');
?>

<footer id="colophon" class="site-footer">
    <div class="site-info container">
        <div class="site-footer-branding">
            <img src="<?php echo $img['url'];?>" alt="<?php echo $img['alt'];?>" />
        </div>
        <div class="site-footer-nav">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'menu-2',
                    'menu_id'        => 'footer-menu',
                )
            );
?>
        </div>
        <div class="site-footer-address">
            <?php echo $address;?>
            <div class="social-links">
                <a href="https://www.linkedin.com/company/delcam-capital-llc/" target="_blank"><img
                        src="/wp-content/themes/delcam/images/social/linkedin.png" width="30" height="30"
                        class="social-icon" /></a>
            </div>
        </div>
    </div><!-- .site-info -->
    <div class="container">
        <div class="site-footer-legal">
            <div class="copyright">&copy <?php echo date('Y');?> DelCam Capital. All rights reserved.</div>
            <div class="legal-links"><a href="/privacy-policy/">Privacy Policy</a> | <a
                    href="/terms-and-conditions/">Terms and
                    Conditions</a></div>
        </div>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>