<?php
/**
 * Kickoff functions and definitions
 *
 * @package Kickoff
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'bs3entry_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bs3entry_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Kickoff, use a find and replace
	 * to change 'bs3entry' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'bs3entry', get_template_directory() . '/languages' );

	// Add logo upload in customizer WordPress 4.5+
  	add_theme_support( 'custom-logo' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'bs3entry' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'bs3entry_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // bs3entry_setup
add_action( 'after_setup_theme', 'bs3entry_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bs3entry_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bs3entry_content_width', 640 );
}
add_action( 'after_setup_theme', 'bs3entry_content_width', 0 );


if ( !function_exists( 'bs3entry_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 */
function bs3entry_the_custom_logo() {
    // Try to retrieve the Custom Logo
    $output = '';
    if (function_exists('get_custom_logo'))
        $output = get_custom_logo();

    // Nothing in the output: Custom Logo is not supported, or there is no selected logo
    // In both cases we display the site's name
    if (empty($output))
        $output = '<a class="navbar-brand" href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>';

    echo $output;
}
endif;



/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/scripts.php';

/**
 * Load Bootstrap Menu.
 */
require get_template_directory() . '/inc/bootstrap-walker.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Comments Callback.
 */
require get_template_directory() . '/inc/comments-callback.php';

/**
 * Author Meta.
 */
require get_template_directory() . '/inc/author-meta.php';

/**
 * Search Results - Highlight.
 */
require get_template_directory() . '/inc/search-highlight.php';