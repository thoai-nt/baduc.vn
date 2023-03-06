<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section
 * 
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mestore
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class('at-sticky-sidebar');?>>
	<?php 
      if(function_exists('wp_body_open')) :
          wp_body_open();
      else :
          do_action('wp_body_open');
      endif;
    ?>
	<?php
	if(true === get_theme_mod( 'mestore_enable_preloader',true )) :
  		?>
        <!-- Begin Preloader -->
            <div class="loader-wrapper">
               <div id="pre-loader" class="loading">
                    <p><?php echo esc_html(get_theme_mod( 'mestore_preloader_text', esc_html__('loading','mestore'))); ?></p>
                    <span></span>
               </div>
            </div>
    		<!-- End Preloader -->
  		<?php
  endif;
	?>
    <!-- Header Styles -->
    <?php
        /**
         * Hook - mestore_action_header.
         *
         * @hooked mestore_header_menu_styles - 10
         */
        do_action( 'mestore_action_header' );
    ?>