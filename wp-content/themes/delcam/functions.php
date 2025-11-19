<?php

/**
 * DelCam Capital functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DelCam_Capital
 */

if (! defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.6');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function delcam_setup()
{
    /*
        * Make theme available for translation.
        * Translations can be filed in the /languages/ directory.
        * If you're building a theme based on DelCam Capital, use a find and replace
        * to change 'delcam' to the name of your theme in all the template files.
        */
    load_theme_textdomain('delcam', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
    add_theme_support('title-tag');

    /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'delcam'),
            'menu-2' => esc_html__('Footer', 'delcam'),
        )
    );

    /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'delcam_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'delcam_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function delcam_content_width()
{
    $GLOBALS['content_width'] = apply_filters('delcam_content_width', 640);
}
add_action('after_setup_theme', 'delcam_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function delcam_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'delcam'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'delcam'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'delcam_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function delcam_scripts()
{
    wp_enqueue_style('delcam-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('delcam-style', 'rtl', 'replace');

    wp_enqueue_script('delcam-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
    wp_enqueue_script('delcam-aos', get_template_directory_uri() . '/js/vendor/aos.js', array(), _S_VERSION, true);
    wp_enqueue_script('delcam-site', get_template_directory_uri() . '/js/site.js', array(), _S_VERSION, true);


    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'delcam_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}



function my_register_acf_blocks()
{
    $block_listing = array(
        array(
            'name' => 'homepage-hero',
            'title' => 'DelCam: Homepage Hero',
            'render_template' => 'template-parts/blocks/homepage-hero.php',
            'category' => 'delcam',
            'keywords' => array( 'delcam', 'block', 'acf' ),
        ),
        array(
            'name' => 'interior-page-hero',
            'title' => 'DelCam: Interior Page Hero',
            'render_template' => 'template-parts/blocks/interior-page-hero.php',
            'category' => 'delcam',
            'keywords' => array( 'delcam', 'block', 'acf' ),
        ),
        array(
            'name' => 'basic',
            'title' => 'DelCam: Basic',
            'render_template' => 'template-parts/blocks/basic.php',
            'category' => 'delcam',
            'keywords' => array( 'delcam', 'block', 'acf' ),
        ),
        array(
            'name' => 'content-image',
            'title' => 'DelCam: Content + Image',
            'render_template' => 'template-parts/blocks/content-image.php',
            'category' => 'delcam',
            'keywords' => array( 'delcam', 'block', 'acf' ),
        ),
        array(
            'name' => 'Content plus 3 feature boxes',
            'title' => 'DelCam: Content plus 3 feature boxes',
            'render_template' => 'template-parts/blocks/content-3-blocks.php',
            'category' => 'delcam',
            'keywords' => array( 'delcam', 'block', 'acf' ),
        ),
        array(
            'name' => 'Highlighted boxes',
            'title' => 'DelCam: Highlighted boxes',
            'render_template' => 'template-parts/blocks/highlighted-boxes.php',
            'category' => 'delcam',
            'keywords' => array( 'delcam', 'block', 'acf' ),
        ),
        array(
            'name' => 'Content + Vertical Blocks',
            'title' => 'DelCam: Content + Vertical Blocks',
            'render_template' => 'template-parts/blocks/vertical-blocks.php',
            'category' => 'delcam',
            'keywords' => array( 'delcam', 'block', 'acf' ),
        ),
        array(
            'name' => 'Company Portfolio',
            'title' => 'DelCam: Company Portfolio',
            'render_template' => 'template-parts/blocks/company-portfolio.php',
            'category' => 'delcam',
            'keywords' => array( 'delcam', 'block', 'acf' ),
        ),
        array(
            'name' => 'Selected Company Portfolio',
            'title' => 'DelCam: Selected Company Portfolio',
            'render_template' => 'template-parts/blocks/company-portfolio-selected.php',
            'category' => 'delcam',
            'keywords' => array( 'delcam', 'block', 'acf' ),
        ),
        array(
            'name' => 'Team Members',
            'title' => 'DelCam: Team Members',
            'render_template' => 'template-parts/blocks/team-members.php',
            'category' => 'delcam',
            'keywords' => array( 'delcam', 'block', 'acf' ),
        ),
        array(
            'name' => 'Large Text Callout',
            'title' => 'DelCam: Large Text Callout',
            'render_template' => 'template-parts/blocks/large-text-callout.php',
            'category' => 'delcam',
            'keywords' => array( 'delcam', 'block', 'acf' ),
        )
    );

    foreach ($block_listing as $block) {
        acf_register_block_type($block);
    }
}
add_action('acf/init', 'my_register_acf_blocks');


function formatHeadline($headline_text)
{
    $headline_text = str_replace('[', '<', str_replace(']', '>', $headline_text));
    return $headline_text;
}


/* Team Members */
function register_team_member_cpt()
{
    // Register the CPT
    $labels = array(
        'name'               => 'Team Members',
        'singular_name'      => 'Team Member',
        'menu_name'          => 'Team',
        'name_admin_bar'     => 'Team Member',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Team Member',
        'new_item'           => 'New Team Member',
        'edit_item'          => 'Edit Team Member',
        'view_item'          => 'View Team Member',
        'all_items'          => 'All Team Members',
        'search_items'       => 'Search Team Members',
        'not_found'          => 'No team members found',
        'not_found_in_trash' => 'No team members found in Trash'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false, // No archive page
        'rewrite' => false,     // No pretty URLs
        'publicly_queryable' => false, // Prevents individual pages
        'show_ui' => true,      // Still show in admin
        'show_in_menu' => true,
        'show_in_rest' => true,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'menu_icon'          => 'dashicons-groups',
        'show_in_rest'       => true,
    );

    register_post_type('team_member', $args);

    // Register the custom taxonomy
    $taxonomy_labels = array(
        'name'              => 'Team Categories',
        'singular_name'     => 'Team Category',
        'search_items'      => 'Search Team Categories',
        'all_items'         => 'All Team Categories',
        'parent_item'       => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item'         => 'Edit Category',
        'update_item'       => 'Update Category',
        'add_new_item'      => 'Add New Category',
        'new_item_name'     => 'New Category Name',
        'menu_name'         => 'Team Categories',
    );

    $taxonomy_args = array(
        'hierarchical'      => true,
        'labels'            => $taxonomy_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'team-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('team_category', array('team_member'), $taxonomy_args);

    // Register Portfolio CPT (non-public)
    $labels = array(
        'name'               => 'Portfolio Companies',
        'singular_name'      => 'Portfolio Company',
        'menu_name'          => 'Portfolio',
        'name_admin_bar'     => 'Portfolio Company',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Company',
        'new_item'           => 'New Company',
        'edit_item'          => 'Edit Company',
        'view_item'          => 'View Company',
        'all_items'          => 'All Companies',
        'search_items'       => 'Search Companies',
        'not_found'          => 'No companies found',
        'not_found_in_trash' => 'No companies found in Trash',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,              // Not publicly viewable
        'show_ui'            => true,               // Shown in admin
        'show_in_menu'       => true,
        'show_in_rest'       => true,               // Optional: Gutenberg/API use
        'has_archive'        => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'rewrite'            => false,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
    );

    register_post_type('portfolio', $args);

    // Register custom taxonomy for Portfolio (like categories)
    $tax_labels = array(
        'name'              => 'Portfolio Categories',
        'singular_name'     => 'Portfolio Category',
        'search_items'      => 'Search Categories',
        'all_items'         => 'All Categories',
        'parent_item'       => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item'         => 'Edit Category',
        'update_item'       => 'Update Category',
        'add_new_item'      => 'Add New Category',
        'new_item_name'     => 'New Category Name',
        'menu_name'         => 'Categories',
    );

    $tax_args = array(
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => false,
        'show_in_rest'      => true,
    );

    register_taxonomy('portfolio_category', array('portfolio'), $tax_args);

    $labels = array(
        'name'               => 'News & Press',
        'singular_name'      => 'News Item',
        'menu_name'          => 'News & Press',
        'name_admin_bar'     => 'News Item',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New News Item',
        'new_item'           => 'New News Item',
        'edit_item'          => 'Edit News Item',
        'view_item'          => 'View News Item',
        'all_items'          => 'All News & Press',
        'search_items'       => 'Search News',
        'not_found'          => 'No news items found.',
        'not_found_in_trash' => 'No news items found in Trash.',
    );

    // Arguments for the post type
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-megaphone',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'author' ),
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'news' ),
        'show_in_rest'       => true, // For Gutenberg/REST
        'taxonomies'         => array( 'news_category' ), // Associate custom taxonomy
    );

    register_post_type('delcam_news', $args);

    $labels = array(
        'name'              => 'News Categories',
        'singular_name'     => 'News Category',
        'search_items'      => 'Search News Categories',
        'all_items'         => 'All News Categories',
        'parent_item'       => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'edit_item'         => 'Edit News Category',
        'update_item'       => 'Update News Category',
        'add_new_item'      => 'Add New News Category',
        'new_item_name'     => 'New News Category Name',
        'menu_name'         => 'Categories',
    );

    $args = array(
        'hierarchical'      => true, // Like default categories
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array( 'slug' => 'news-category' ),
        'show_in_rest'      => true, // Enables Gutenberg compatibility
    );

    register_taxonomy('news_category', array( 'delcam_news' ), $args);
}
add_action('init', 'register_team_member_cpt');



function excerpt($limit)
{
    $excerpt = explode(' ', get_the_excerpt(), $limit);

    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . '...';
    } else {
        $excerpt = implode(" ", $excerpt);
    }

    $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);

    return $excerpt;
}

function content($limit)
{
    $content = explode(' ', get_the_content(), $limit);

    if (count($content) >= $limit) {
        array_pop($content);
        $content = implode(" ", $content) . '...';
    } else {
        $content = implode(" ", $content);
    }

    $content = preg_replace('/\[.+\]/', '', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);

    return $content;
}



add_filter('render_block', function ($block_content, $block) {
    if (is_admin() || wp_is_json_request()) {
        return $block_content; // Don't affect the editor or REST.
    }
    if (empty($block_content) || empty($block['blockName'])) {
        return $block_content;
    }


    $targets = [
           'core/paragraph',
           'core/heading',
           'core/separator',
           'core/list',
           'core/accordion'
       ];


    if (in_array($block['blockName'], $targets, true)) {
        // Avoid double-wrapping if something else already added this class.
        if (preg_match('/class="[^"]*\bmy-block-wrap\b/', $block_content)) {
            return $block_content;
        }

        $block_slug = str_replace('/', '-', $block['blockName']); // e.g. core-heading
        $classes    = 'container ' . 'wrap-' . $block_slug;

        return '<div class="' . esc_attr($classes) . '">' . $block_content . '</div>';
    }

    return $block_content;
}, 10, 2);
