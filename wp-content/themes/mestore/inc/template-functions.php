<?php
/**
 * @package mestore
 */


/**
* Header
*/

if ( ! function_exists( 'mestore_header_menu_styles' ) ) :
function mestore_header_menu_styles() {
    get_template_part( 'inc/header-menu/content',esc_html(get_theme_mod('mestore_header_menu_style','style1')));
}
endif;
add_action( 'mestore_action_header', 'mestore_header_menu_styles' );   


/**
* Footer
*/

if ( ! function_exists( 'mestore_footer_copyrights' ) ) :
function mestore_footer_copyrights() {
	?>
		<div class="row">
            <div class="col-md-6">
                <div class="copyrights">
                    <p>
                        <?php

                            if("" != esc_html(get_theme_mod( 'mestore_footer_copyright_text'))) :
                                echo esc_html(get_theme_mod( 'mestore_footer_copyright_text')); 
                                if(get_theme_mod('mestore_en_footer_credits',true)) :
                                    ?><span><?php esc_html_e(' | Theme by ','mestore') ?><a href="<?php echo esc_url(MESTORE_THEME_AUTH); ?>" target="_blank"><?php esc_html_e('Spiracle Themes','mestore') ?></a></span>
                                    <?php   
                                endif;
                            
                            else :
                                echo date_i18n(
                                    /* translators: Copyright date format, see https://secure.php.net/date */
                                    _x( 'Y', 'copyright date format', 'mestore' )
                                );
                                ?>
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                                    <span><?php esc_html_e(' | Theme by ','mestore') ?><a href="<?php echo esc_url(MESTORE_THEME_AUTH); ?>" target="_blank"><?php esc_html_e('Spiracle Themes','mestore') ?></a></span>
                                <?php
                            endif;
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="custom-menu-product">
                    <div class="collapse navbar-collapse" id="navbar-collapse-4">
                        <?php
                            wp_nav_menu( array(                             
                                'theme_location'    => 'footer-copyrights',
                                'depth'             => 1,
                                'container'         => 'ul',
                                'container_class'   => 'copyrights-menu',
                                'container_id'      => 'menu-copyrights',
                                'menu_class'        => 'copyrights-custom',
                                )
                            );
                        ?>
                    </div>
                </div>
            </div>
        </div>
	<?php
}
endif;
add_action( 'mestore_action_footer', 'mestore_footer_copyrights' );	


/**
* Custom excerpt length.
*/
if ( ! function_exists( 'mestore_my_excerpt_length' ) ) :
function mestore_my_excerpt_length($length) {
	if ( is_admin() ) :
		return $length;
	endif;
  	return absint(get_theme_mod( 'mestore_excerpt_length',70));
}
endif;
add_filter('excerpt_length', 'mestore_my_excerpt_length');


/**
 * Get Page Title
 */

if( !function_exists( 'mestore_get_title' ) ):
    function mestore_get_title() {
        if(!is_front_page()) :
            ?>
                <div class="page-title">
                    <?php mestore_before_title_content(); ?>
                    <div class="<?php echo esc_attr(MESTORE_CONTAINER_CLASS) ?>">
                        <h1 class="main-title"><?php the_title(); ?></h1>
                    </div>
                    <?php mestore_after_title_content(); ?>
                </div>
            <?php    
        endif;
    }
endif;


/**
 * Get Blog Title
 */

if( !function_exists( 'mestore_get_blog_title' ) ):
    function mestore_get_blog_title() {
        if(!is_front_page()) :
            ?>
                <div class="page-title">
                    <?php mestore_before_title_content(); ?>
                    <?php mestore_after_title_content(); ?>
                </div>
            <?php    
        endif;
    }
endif;


/**
 * Top Bar
 */
if ( ! function_exists( 'mestore_enable_header_topbar_style1' ) ) :
function mestore_enable_header_topbar_style1() {
    
    if ( is_active_sidebar('topsidebar')) :
        ?>
            <div class="top-bar-main">
        <?php
    else:
        ?>
            <div class="top-bar-main-no-widgets">
        <?php
    endif;
    ?>
        <div class="<?php echo esc_attr(MESTORE_CONTAINER_CLASS) ?>">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <?php
                        if ( is_active_sidebar('topsidebar')) :
                            get_sidebar('topsidebar');
                        endif;
                    ?>
                </div>
            </div>
        </div>
        </div>
    <?php
}
endif;
add_action('mestore_action_enable_header_topbar_style1', 'mestore_enable_header_topbar_style1');


/**
 * Header Menu Cart
 */
if ( ! function_exists( 'mestore_header_menucart' ) ) :
function mestore_header_menucart() {
    if(true===get_theme_mod( 'mestore_enable_header_menucart',true)) :
        ?>
            <ul class="header-woo-cart">
                <li>
                    <?php
                        if ( mestore_is_active_woocommerce() ) :
                            mestore_woocommerce_header_cart();
                        endif;
                    ?>
                </li>
            </ul>
        <?php
    endif;
}
endif;
add_action('mestore_action_header_menucart', 'mestore_header_menucart');


/**
 * Header Login/Register Links
 */
if ( ! function_exists( 'mestore_header_login_register_links' ) ) :
function mestore_header_login_register_links() {
    ?>   
        <ul class="header-woo-search">
            <li>
                <?php
                    if ( mestore_is_active_woocommerce() && true=== get_theme_mod( 'mestore_enable_header_product_search',true) ) :
                        mestore_woocommerce_header_woo_search();
                    endif;
                ?>
            </li>
        </ul> 
        <ul class="header-woo-links">
            <li>
                <?php
                    if ( mestore_is_active_woocommerce() && true===get_theme_mod( 'mestore_enable_header_login_register_links',true) ) :
                        mestore_woocommerce_header_signup_links();
                    endif;
                ?>
            </li>
        </ul>   
    <?php
}
endif;
add_action('mestore_action_header_login_register_links', 'mestore_header_login_register_links');


/**
 * Header Inner Content
 */
if ( ! function_exists( 'mestore_header_inner_content' ) ) :
function mestore_header_inner_content() {
    ?>
        <div class="header-inner">
            <div class="<?php echo esc_attr(MESTORE_CONTAINER_CLASS) ?>">
                <div class="left-column col-md-3 col-sm-4">
                    <div class="all-categories">
                        <nav class="category-menu" role="navigation">
                            <div class="category-menu-wrapper">
                                <?php
                                    if ( mestore_is_active_woocommerce() ) :
                                        if(true===get_theme_mod( 'mestore_enable_header_category_menu',true)) :
                                            //CUSTOM MENU
                                            mestore_header_product_custom_menu();
                                        endif;
                                    endif;
                                ?>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="right-column col-md-9 col-sm-8">
                    <div class="header-product-search">
                        <?php
                            if ( mestore_is_active_woocommerce() ) :
                                if(true===get_theme_mod( 'mestore_enable_header_product_search',true)) :
                                    mestore_product_search_form();
                                endif;
                            endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
}
endif;
add_action('mestore_action_header_inner_content', 'mestore_header_inner_content');


/**
 * Header Category Menu
 */
if ( ! function_exists( 'mestore_header_category_menu' ) ) :
function mestore_header_category_menu() {
    ?>
        <div class="header-inner">
            <div class="left-column">
                <div class="all-categories">
                    <nav class="category-menu" role="navigation">
                        <div class="category-menu-wrapper">
                            <?php
                                if ( mestore_is_active_woocommerce() ) :
                                    if(true===get_theme_mod( 'mestore_enable_header_category_menu',true)) :
                                        //CUSTOM MENU
                                        mestore_header_product_custom_menu();
                                    endif;
                                endif;
                            ?>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    <?php
}
endif;
add_action('mestore_action_header_category_menu', 'mestore_header_category_menu');



/**
 * Sidebar Product Search Form
 */
if ( ! function_exists( 'mestore_sidebar_product_search_content' ) ) :
function mestore_sidebar_product_search_content() {
    ?>  
        <div class="header-product-search">
            <?php
                if ( mestore_is_active_woocommerce() ) :
                    if(true===get_theme_mod( 'mestore_enable_header_product_search',true)) :
                        mestore_sidebar_product_search_form();
                    endif;
                endif;
            ?>
        </div> 
    <?php
}
endif;
add_action('mestore_action_sidebar_product_search_content', 'mestore_sidebar_product_search_content');


/**
 * Function for displaying menu item description
 * 
 */
function mestore_nav_description( $item_output, $item, $depth, $args ) {
    if( isset($args->theme_location) && !empty($item->description) ) :
        $description_html = '<span class="menu-bubble-description">'.$item->description.'</span>';
        return $item_output.$description_html;
    endif;
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'mestore_nav_description', 10, 4 );


/**
 * Function for Minimizing dynamic CSS
 */
function mestore_minimize_css($css){
    $css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css);
    $css = preg_replace('/\s{2,}/', ' ', $css);
    $css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
    $css = preg_replace('/;}/', '}', $css);
    return $css;
}


/**
 * Function to disable Woo Wizard
 */
add_filter('woocommerce_enable_setup_wizard', 'mestore_disable_woo_wizard');
function mestore_disable_woo_wizard() {
    return false;
}


/** 
* Disable Plugin Redirect
*/
function mestore_prevent_plugins_redirect() {
    delete_transient( 'elementor_activation_redirect' );
}
add_action('admin_init', 'mestore_prevent_plugins_redirect');


/**
 * Adding blog sidebar classes to body
 */
if ( ! function_exists( 'mestore_add_blog_sidebar_classes_to_body' ) ) :
function mestore_add_blog_sidebar_classes_to_body($classes = '') {
    if('right'===esc_html(get_theme_mod('mestore_blog_single_sidebar_layout','no')) && is_single()) :
        $classes[] = 'single-right-sidebar';
    
    elseif('left'===esc_html(get_theme_mod('mestore_blog_single_sidebar_layout','no')) && is_single()) :
        $classes[] = 'single-left-sidebar';   
    
    elseif('no'===esc_html(get_theme_mod('mestore_blog_single_sidebar_layout','no')) && is_single()) :
        $classes[] = 'single-no-sidebar';
    endif;
    return $classes;
}
endif;
add_filter('body_class', 'mestore_add_blog_sidebar_classes_to_body');


/**
 * Check if woocommerce is activated.
 */
if ( ! function_exists( 'mestore_is_active_woocommerce' ) ) {
    function mestore_is_active_woocommerce() {
        if ( class_exists( 'WooCommerce' ) ) :
            return true;
        else :
            return false;
        endif;
    }
}