<?php
/**
 * @package mestore
 */

get_header();

?>
<div class="page-title">
    <?php mestore_before_title_content(); ?>
    <?php mestore_after_title_content(); ?>
</div>
<div class="<?php echo esc_attr(MESTORE_CONTAINER_CLASS) ?>">
	<div id="primary" class="content-area">
	    <main id="main" class="site-main" role="main">
	    	<div class="content-inner">
	    		<div class="page-content-area">
			        <?php
			            get_template_part( 'template-parts/shop/content', 'woocommerce' );           
			        ?>
		    	</div>
		    </div>
	    </main><!-- #main -->
	</div><!-- #primary -->
</div>

<?php
	get_footer();
?>