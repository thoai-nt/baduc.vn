<?php
/**
 * 
 * @package mestore
 */


/**
 * WooCommerce setup
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function mestore_woocommerce_setup() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'mestore_woocommerce_setup' );


/**
 * WooCommerce scripts & styles
 *
 * @return void
 */
function mestore_woocommerce_scripts() {
    wp_register_style( 'mestore-woocommerce-style', get_template_directory_uri() . '/css/woocommerce-style.css', array(), wp_get_theme()->get('Version'));
	wp_enqueue_style( 'mestore-woocommerce-style' );
}
add_action( 'wp_enqueue_scripts', 'mestore_woocommerce_scripts' );


/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function mestore_woocommerce_active_body_class( $classes ) {
    $classes[] = 'woocommerce-active';

    return $classes;
}
add_filter( 'body_class', 'mestore_woocommerce_active_body_class' );


/**
* Cart Fragments
*/
if ( ! function_exists( 'mestore_woocommerce_cart_link_fragment' ) ) :
function mestore_woocommerce_cart_link_fragment( $fragments ) {
    ob_start();
    mestore_woocommerce_cart_link();
    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}
endif;
add_filter( 'woocommerce_add_to_cart_fragments', 'mestore_woocommerce_cart_link_fragment' );


/**
* Cart Link
*/
if ( ! function_exists( 'mestore_woocommerce_cart_link' ) ) :
function mestore_woocommerce_cart_link() {
    $mestore_cart_icon_title = apply_filters( 'mestore_cart_icon_title', esc_html__( 'View your shopping cart', 'mestore' ) );
    $cart_text = esc_html(get_theme_mod('mestore_header_menucart_text',esc_html__('Your Cart','mestore'))) ;
    ?>
        <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php echo esc_attr( $mestore_cart_icon_title ); ?>">
            <i class="la la-shopping-bag"></i>
            <?php $item_count_text = WC()->cart->get_cart_contents_count(); ?>
            <span class="count badge">
                <?php echo esc_html( $item_count_text ); ?>
            </span>
        </a>
    <?php
}
endif;


/**
* Header Cart
*/
if ( ! function_exists( 'mestore_woocommerce_header_cart' ) ) :
function mestore_woocommerce_header_cart() {
    $mestore_cart_link_option = get_theme_mod( 'mestore_cart_link_option', true );
    if ( false == $mestore_cart_link_option ) :
        return;
    endif;
    if ( is_cart() ) :
        $class = 'current-menu-item';
    else :
        $class = '';
    endif;
    ?>
        <ul id="site-header-cart" class="site-header-cart">
            <li class="menu-cart <?php echo esc_attr( $class ); ?>">
                <?php mestore_woocommerce_cart_link(); ?>
            </li>
            <li>
                <?php
                    $instance = array(
                        'title' => '',
                    );
                    the_widget( 'WC_Widget_Cart', $instance );
                ?>
            </li>
        </ul>
    <?php
}
endif;


/**
* Header Signup Links
*/
if ( ! function_exists( 'mestore_woocommerce_header_signup_links' ) ) :
function mestore_woocommerce_header_signup_links() {
    ?>
        <span class="register">
            <?php
                if ( is_user_logged_in() ) :
                    ?>
                        <a data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e('My Account','mestore') ?>" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php echo esc_attr_e('My Account','mestore'); ?>"><i class="la la-user"></i></a>
                    <?php
                else :
                    ?>  
                        <a data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e('Sign In','mestore') ?>" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php echo esc_attr_e('Sign In','mestore'); ?>"><i class="la la-user"></i></a>
                    <?php
                endif;
            ?>
        </span>
    <?php
}
endif;


/**
* Header Woo Search
*/
if ( ! function_exists( 'mestore_woocommerce_header_woo_search' ) ) :
function mestore_woocommerce_header_woo_search() {
    $search_placeholder = esc_html(get_theme_mod('mestore_header_product_search_placeholder', esc_html__('Search products','mestore'))) ;
    ?>
        <div id="search-toggle" class="menu-search hidden-xs"></div>
        <div id="search-box" class="clearfix hidden-xs">
        <form method="get" id="searchform" class="woocommerce-product-search searchform" action="<?php echo esc_url(home_url( '/' )) ?>">
            <div class="search">
                <input type="text" value="" class="product-search" name="s" id="s" placeholder="<?php echo $search_placeholder; ?>">
                <label for="searchsubmit" class="search-icon"><i class="la la-search"></i></label>
                <input type="submit" id="searchsubmit" value="Search">
                <input type="hidden" name="post_type" value="product"/>
            </div>
        </form>
        </div>
    <?php
}
endif;


/**
 * Check if Quick View is activated.
 */
function mestore_is_active_quick_view() {
    if ( class_exists( 'YITH_WCQV_Frontend' ) ) :
        return true;
    else :
        return false;
    endif;
}


/**
* Display Product search form within sidebar
*/ 
if (!function_exists('mestore_sidebar_product_search_form')) :
function mestore_sidebar_product_search_form() {
    ?>
    <div class="search-form-wrapper">
        <form method="get" class="woocommerce-product-search" action="<?php echo esc_url(home_url('/')); ?>">
            <div class="form-group search">
                <?php
                    $search_placeholder = esc_html(get_theme_mod('mestore_product_search_placeholder', esc_html__('Search for products','mestore'))) ;
                ?>
                <label class="screen-reader-text" for="woocommerce-product-search-field"><?php esc_html_e('Search for:', 'mestore'); ?></label>
                <input type="search" id="woocommerce-product-search-field" class="search-field"   placeholder="<?php echo esc_attr($search_placeholder); ?>" value="<?php echo get_search_query(); ?>" name="s"/>
                <button type="submit" value=""><i class="la la-search" aria-hidden="true"></i> <?php esc_html_e('Search','mestore') ?></button>
                <input type="hidden" name="post_type" value="product"/>
            </div>
        </form>
    </div>
    <?php
}
endif;


/**
* Header Category Custom Menu
*/
if ( ! function_exists( 'mestore_header_product_custom_menu' ) ) :
function mestore_header_product_custom_menu() {
    ?>
        <div class="header-product-custom-menu">
            <div class="custom-menu-wrapper">
                <a href="#" class="title navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-2"><i class="la la-bars"></i> <?php 
                    echo esc_html(get_theme_mod( 'mestore_header_category_heading_text', esc_html__('All Departments','mestore')));
                    ?>
                </a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-2">
                    <span><i class="la la-chevron-down"></i><i class="la la-chevron-up"></i></span>
                </button>
            </div>
            <div class="custom-menu-product">
                <div class="collapse navbar-collapse" id="navbar-collapse-2">
                    <?php
                        wp_nav_menu( array(                             
                            'theme_location'    => 'categorymenu',
                            'depth'             => 3,
                            'container'         => 'ul',
                            'container_class'   => 'product-custom-menu-container',
                            'container_id'      => 'menu-categorymenu',
                            'menu_class'        => 'category-custom',
                            )
                        );
                    ?>
                </div>
            </div>
        </div>
    <?php
}
endif;


/**
* Display Sale Price
*/
if ( ! function_exists( 'mestore_change_displayed_sale_price_html' ) ) :
function mestore_change_displayed_sale_price_html( $price, $product ) {
    // Only on sale products on frontend and excluding min/max price on variable products
    if( $product->is_on_sale() && ! is_admin() && ! $product->is_type('variable')) :
        // Get product prices
        $regular_price = (float) $product->get_regular_price(); // Regular price
        $sale_price = (float) $product->get_price(); // Active price (the "Sale price" when on-sale)

        // "Saving Percentage" calculation and formatting
        $precision = 1; // Max number of decimals
        $saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%';

        // Append to the formated html price
        $price .= sprintf( __('<p class="saved-sale">Save: %s</p>', 'mestore' ), $saving_percentage );
    endif;
    return $price;
}
endif;
add_filter( 'woocommerce_get_price_html', 'mestore_change_displayed_sale_price_html', 10, 2 );


/**
 * Adding checkout sidebar classes to body
 */
if ( ! function_exists( 'mestore_add_checkout_sidebar_classes_to_body' ) ) :
function mestore_add_checkout_sidebar_classes_to_body($classes = '') {
    if('right'===esc_html(get_theme_mod('mestore_checkout_page_sidebar_layout','right'))) :
        $classes[] = 'right-sidebar-checkout';
    elseif('left'===esc_html(get_theme_mod('mestore_checkout_page_sidebar_layout','right'))) :
        $classes[] = 'left-sidebar-checkout';   
    elseif('no'===esc_html(get_theme_mod('mestore_checkout_page_sidebar_layout','right'))) :
        $classes[] = 'no-sidebar-checkout';
    else :
        $classes[] = 'left-sidebar-checkout';
    endif;
    return $classes;
}
endif;
add_filter('body_class', 'mestore_add_checkout_sidebar_classes_to_body');


/**
 * Adding cart sidebar classes to body
 */
if ( ! function_exists( 'mestore_add_cart_sidebar_classes_to_body' ) ) :
function mestore_add_cart_sidebar_classes_to_body($classes = '') {
    if('right'===esc_html(get_theme_mod('mestore_cart_page_sidebar_layout','right'))) :
        $classes[] = 'right-sidebar-cart';
    elseif('left'===esc_html(get_theme_mod('mestore_cart_page_sidebar_layout','right'))) :
        $classes[] = 'left-sidebar-cart';   
    elseif('no'===esc_html(get_theme_mod('mestore_cart_page_sidebar_layout','right'))) :
        $classes[] = 'no-sidebar-cart';
    else :
        $classes[] = 'left-sidebar-cart';
    endif;
    return $classes;
}
endif;
add_filter('body_class', 'mestore_add_cart_sidebar_classes_to_body');


/**
 * Related Products
*/

if (!function_exists('mestore_filter_woocommerce_output_related_products_args')) :
function mestore_filter_woocommerce_output_related_products_args( $args ) {     
    $args=array(    
    'posts_per_page' => intval( get_theme_mod('mestore_row_items','3') ),
    'columns' => intval( get_theme_mod('mestore_row_items','3') ),
    );
    return $args; 
};
endif;
add_filter( 'woocommerce_output_related_products_args', 'mestore_filter_woocommerce_output_related_products_args', 10, 1 ); 


/**
 * Header Wishlist
 */
if ( ! function_exists( 'mestore_header_wishlist' ) ) :
function mestore_header_wishlist() {

    if( class_exists( 'YITH_WCWL' ) ) :
        if(true===get_theme_mod( 'mestore_enable_header_wishlist_mobile',false)) :
            if(function_exists( 'YITH_WCWL' )) :
                $wishlist_count = YITH_WCWL()->count_products();
                if($wishlist_count==0) :
                    ?>
                        <ul class="wishlist-icon-container">
                            <li><a data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e('No Wishlist Item','mestore') ?>" href="<?php echo esc_url( home_url() . '/wishlist' ); ?>" > <i class='la la-heart'></i></a></li>
                            
                        </ul>
                    <?php
                else :
                    ?>
                        <ul class="wishlist-icon-container">
                            <li><a data-toggle="tooltip" data-placement="top" title="<?php echo absint($wishlist_count); ?><?php esc_html_e(' Wishlist Items','mestore') ?>" href="<?php echo esc_url( home_url() . '/wishlist' ); ?>" > <i class='la la-heart'></i></a></li>
                            
                        </ul>
                    <?php    
                endif;
            endif;
        endif;
    endif;
}
endif;
add_action('mestore_action_header_wishlist', 'mestore_header_wishlist');
