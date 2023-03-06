<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package mestore
 */

get_header(); 
mestore_before_title();
if(true===get_theme_mod( 'mestore_enable_page_title',true)) :
mestore_get_title();
endif;
mestore_after_title();

?>
<div id="primary" class="<?php echo esc_attr(get_theme_mod('mestore_header_menu_style','style1')); ?> content-area">
	<main id="main" class="site-main" role="main">
		<div class="content-inner">
			<div class="row">
				<?php
					while ( have_posts() ) : the_post();
						if ( mestore_is_active_woocommerce() ) :
							if ( is_page( 'cart' ) || is_cart() ) :
								get_template_part( 'template-parts/page/content', 'cart-page' );
							elseif ( is_page( 'checkout' ) || is_checkout() ) :
								get_template_part( 'template-parts/page/content', 'checkout-page' );
							elseif ( is_page( 'my-account' ) || is_account_page() ) :
								get_template_part( 'template-parts/page/content', 'myaccount-page' );
							else :
								get_template_part( 'template-parts/page/content', 'page' );
							endif;
						else:
							get_template_part( 'template-parts/page/content', 'page' );
						endif;

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
		                    comments_template();  
						endif;
					endwhile; // End of the loop.	
				?>
			</div>
		</div>
	</main>
</div>

<?php

get_footer();