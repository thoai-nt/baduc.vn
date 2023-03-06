<?php
/**
 * MeStore functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mestore
 */

/**
 *  Defining Constants
 */

// Core Constants
define('MESTORE_REQUIRED_PHP_VERSION', '5.6' );
define('MESTORE_DIR_PATH', get_template_directory());
define('MESTORE_DIR_URI', get_template_directory_uri());
define('MESTORE_THEME_AUTH','https://www.spiraclethemes.com/');
define('MESTORE_THEME_URL','https://www.spiraclethemes.com/mestore-free-wordpress-theme/');
define('MESTORE_THEME_PRO_URL','https://www.spiraclethemes.com/mestore-pro-addons/');
define('MESTORE_THEME_DOC_URL','https://www.spiraclethemes.com/mestore-documentation/');
define('MESTORE_THEME_VIDEOS_URL','https://www.spiraclethemes.com/mestore-video-tutorials/');
define('MESTORE_THEME_SUPPORT_URL','https://wordpress.org/support/theme/mestore/');
define('MESTORE_THEME_RATINGS_URL','https://wordpress.org/support/theme/mestore/reviews/#new-post');
define('MESTORE_THEME_CHANGELOGS_URL','https://themes.trac.wordpress.org/log/mestore/');
define('MESTORE_THEME_CONTACT_URL','https://www.spiraclethemes.com/contact/');
define('MESTORE_CONTAINER_CLASS', esc_html(get_theme_mod('mestore_layout_content_width_ratio','os-container')));


//Register Required plugin
require_once(get_template_directory() .'/inc/class-tgm-plugin-activation.php');

/**
* Check for minimum PHP version requirement 
*
*/
function mestore_check_theme_setup( $oldtheme_name, $oldtheme ) {
	// Compare versions.
	if ( version_compare(phpversion(), MESTORE_REQUIRED_PHP_VERSION, '<') ) :
	// Theme not activated info message.
	add_action( 'admin_notices', 'mestore_php_admin_notice' );
	function mestore_php_admin_notice() {
		?>
			<div class="update-nag">
		  		<?php esc_html_e( 'You need to update your PHP version to a minimum of 5.6 to run MeStore Theme.', 'mestore' ); ?> <br />
		  		<?php esc_html_e( 'Actual version is:', 'mestore' ) ?> <strong><?php echo phpversion(); ?></strong>, <?php esc_html_e( 'required is', 'mestore' ) ?> <strong><?php echo MESTORE_REQUIRED_PHP_VERSION; ?></strong>
			</div>
		<?php
	}
	// Switch back to previous theme.
	switch_theme( $oldtheme->stylesheet );
		return false;
	endif;
}
add_action( 'after_switch_theme', 'mestore_check_theme_setup', 10, 2  );


if ( ! function_exists( 'mestore_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mestore_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on MeStore, use a find and replace
	 * to change 'mestore' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'mestore', get_template_directory() . '/languages' );

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
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'mestore' ),
		'categorymenu' => esc_html__( 'Category Menu', 'mestore' ),
		'footer-social' => esc_html__( 'Footer Social Menu', 'mestore' ),
		'footer-copyrights' => esc_html__( 'Footer Copyrights Menu', 'mestore' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(		
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );


	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Remove theme support for new widgets block editor
	if(true===get_theme_mod( 'mestore_disable_widgets_block_editor',true)) :
		remove_theme_support( 'widgets-block-editor' );
	endif;

	/**
	* MeStore theme info
	*/
	require get_template_directory() . '/inc/theme-info.php';

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for responsive embeds.
    add_theme_support( 'responsive-embeds' );

    // Add support for automatic feed links.
    add_theme_support( 'automatic-feed-links' );

	/**
	 * MeStore custom posts image size
	 */
	add_image_size( 'mestore-posts', 765, 500, true );

	/**
	 * MeStore custom posts thumbs size
	 */
	add_image_size( 'mestore-posts-thumb', 150, 100, true );

	/*
	* About page instance
	*/
	$config = array();
	MeStore_About_Page::mestore_init( $config );

	if ( is_customize_preview() ) :
    	require_once( get_stylesheet_directory(). '/inc/starter-content.php' );
		add_theme_support( 'starter-content', mestore_get_starter_content() );
	endif;

}
endif;
add_action( 'after_setup_theme', 'mestore_setup' );


/**
* Custom Logo 
*
*/
function mestore_logo_setup() {
    add_theme_support( 'custom-logo', array(
	   'height'      => 65,
	   'width'       => 350,
	   'flex-height' => true,
	   'flex-width' => true,	   
	) );
}
add_action( 'after_setup_theme', 'mestore_logo_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mestore_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mestore_content_width', 640 );
}
add_action( 'after_setup_theme', 'mestore_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mestore_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'mestore' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'mestore' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	if ( mestore_is_active_woocommerce() ) :
		register_sidebar( array(
			'name'          => esc_html__( 'WooCommerce Sidebar', 'mestore' ),
			'id'            => 'woosidebar',
			'description'   => esc_html__( 'Add widgets here.', 'mestore' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	endif;

	if ( true === get_theme_mod( 'mestore_enable_page_sidebar', false )) :
		register_sidebar( array(
			'name'          => esc_html__( 'Page Sidebar', 'mestore' ),
			'id'            => 'page-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'mestore' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	endif;

	register_sidebar( array(
		'name'          => esc_html__( 'Topbar Sidebar', 'mestore' ),
		'id'            => 'topsidebar',
		'description'   => esc_html__( 'Add widgets here.', 'mestore' ),
		'before_widget' => '<ul id="%1$s" class="widget %2$s">',
		'after_widget'  => '</ul>',
	) );

	//Footer widget columns
    $widget_num = absint(get_theme_mod( 'mestore_footer_widgets', '3' ));
    for ( $i=1; $i <= $widget_num; $i++ ) :
        register_sidebar( array(
            'name'          => esc_html__( 'Footer Column', 'mestore' ) . $i,
            'id'            => 'footer-' . $i,
            'description'   => '',
            'before_widget' => '<div id="%1$s" class="section %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );
    endfor;

}
add_action( 'widgets_init', 'mestore_widgets_init' );


/**
* Admin Scripts
*/
if ( ! function_exists( 'mestore_admin_scripts' ) ) :
function mestore_admin_scripts($hook) {
  	wp_enqueue_style( 'mestore-info-css', get_template_directory_uri() . '/css/mestore-theme-info.css', false ); 
}
endif;
add_action( 'admin_enqueue_scripts', 'mestore_admin_scripts' );


/**
 * Display Dynamic CSS.
 */
function mestore_dynamic_css_wrap() {
	require_once( get_parent_theme_file_path( '/css/dynamic.css.php' ) );  
	?>
  		<style type="text/css" id="mestore-dynamic-style">
    		<?php echo mestore_dynamic_css_stylesheet(); ?>
  		</style>
	<?php 
}
add_action( 'wp_head', 'mestore_dynamic_css_wrap' );


/**
 * Enqueue Styles and Scripts
 */
function mestore_scripts() {
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.7');
	wp_register_style( 'mestore-main', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version'));
	wp_enqueue_style( 'mestore-main' );

	wp_register_style( 'blocks-frontend', get_template_directory_uri() . '/css/blocks-frontend.css', array(), wp_get_theme()->get('Version'));
	wp_enqueue_style( 'blocks-frontend' );

	wp_enqueue_style( 'line-awesome', get_template_directory_uri() . '/css/line-awesome.css', array(), '1.3.0');
	wp_enqueue_style( 'm-customscrollbar', get_template_directory_uri() . '/css/jquery.mCustomScrollbar.css', array(), '3.1.5');
	
	wp_enqueue_style( 'poppins-google-font', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap', array(), '1.0'); 
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) :
		wp_enqueue_script( 'comment-reply' );
	endif;

	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array(), '3.3.7', true );
	wp_enqueue_script( 'm-customscrollbar-js', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.js',array(),'3.1.5', true );
	wp_enqueue_script( 'mestore-script', get_template_directory_uri() . '/js/main.js', array('jquery'), wp_get_theme()->get('Version'), true );
	wp_localize_script( 'mestore-script', 'mestore_object',
        array( 
            'add_to_cart' => esc_html__( 'Add to Cart', 'mestore' ),
            'quick_view' => esc_html__( 'Quick View', 'mestore' ),
            'add_to_wishlist' => esc_html__( 'Add to Wishlist', 'mestore' ),
        )
    );

}
add_action( 'wp_enqueue_scripts', 'mestore_scripts' );


/** 
* Excerpt More
*/
function mestore_excerpt_more( $more ) {
	if ( is_admin() ) :
		return $more;
	endif;
    return '&hellip;';
}
add_filter('excerpt_more', 'mestore_excerpt_more');


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function mestore_pingback_header() {
 	if ( is_singular() && pings_open() ) :
    	printf( '<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo( 'pingback_url' )) );
  	endif;
}
add_action( 'wp_head', 'mestore_pingback_header' );


/**
 * Add Class to body
 */

function mestore_body_class_blocks( $classes ) {
	if ( is_singular() && has_blocks() && !is_single() ) {
		$classes[] = 'has-blocks';
	}
	return $classes;
}
add_filter( 'body_class', 'mestore_body_class_blocks' );


/**
 * Load our Block Editor styles to style the Editor like the front-end
 */
if ( ! function_exists( 'mestore_block_editor_width_styles' ) ) :
function mestore_block_editor_width_styles() {
	$mestore_layout_width = 1200;
	$styles = '';

	wp_enqueue_style( 'mestore-blocks-style', trailingslashit( get_template_directory_uri() ) . 'css/blocks-style.css', array(), '1.0.0', 'all' );

	// Increase width of Title
	$styles .= 'body.gutenberg-editor-page .edit-post-visual-editor .editor-post-title .editor-post-title__block {max-width: ' . esc_attr( $mestore_layout_width - 10 ) . 'px;}';

	// Increase width of all Blocks & Block Appender
	$styles .= 'body.gutenberg-editor-page .edit-post-visual-editor .editor-block-list__block {max-width: ' . esc_attr( $mestore_layout_width - 10 ) . 'px;}';
	$styles .= 'body.gutenberg-editor-page .edit-post-visual-editor .editor-default-block-appender {max-width: ' . esc_attr( $mestore_layout_width - 10 ) . 'px;}';

	// Increase width of Wide blocks
	$styles .= 'body.gutenberg-editor-page .edit-post-visual-editor .editor-block-list__block[data-align="wide"] {max-width: ' . esc_attr( $mestore_layout_width - 10 + 400 ) . 'px;}';

	// Remove max-width on Full blocks
	$styles .= 'body.gutenberg-editor-page .edit-post-visual-editor .editor-block-list__block[data-align="full"] {max-width: none;}';

	// Output our styles into the <head> whenever our block styles are enqueued
	wp_add_inline_style( 'mestore-blocks-style', $styles );
}
endif;
add_action( 'enqueue_block_editor_assets', 'mestore_block_editor_width_styles' );

/** 
*  Plugins Required
*/
function mestore_register_required_plugins() {
    $plugins = array(      
      array(
          'name'               => 'WooCommerce',
          'slug'               => 'woocommerce',
          'source'             => '',
          'required'           => false,          
          'force_activation'   => false,
      ),
      array(
          'name'               => 'YITH WooCommerce Quick View',
          'slug'               => 'yith-woocommerce-quick-view',
          'source'             => '',
          'required'           => false,          
          'force_activation'   => false,
      ),
      array(
          'name'               => 'One Click Demo Import',
          'slug'               => 'one-click-demo-import',
          'source'             => '',
          'required'           => false,          
          'force_activation'   => false,
      ),
      array(
          'name'               => 'Spiraclethemes Site Library',
          'slug'               => 'spiraclethemes-site-library',
          'source'             => '',
          'required'           => false,          
          'force_activation'   => false,
      ),    
    );

    $config = array(
            'id'           => 'mestore',
            'default_path' => '',
            'menu'         => 'tgmpa-install-plugins',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => false,
            'message'      => '',
            'strings'      => array()
    );

    tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'mestore_register_required_plugins' );

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Template functions
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom template hooks for this theme.
 */
require get_template_directory() . '/inc/template-hooks.php';

/**
 * Extra classes for this theme.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * WooCommerce Functions.
 */
if ( mestore_is_active_woocommerce() ) :
	require get_template_directory() . '/inc/woocommerce-functions.php';
endif;

/**
 * Load Widgets.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Upgrade Pro
 */
require_once( trailingslashit( get_template_directory() ) . 'mestore-pro/class-customize.php' );