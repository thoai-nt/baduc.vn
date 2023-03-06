<?php
/**
 *
 * @package mestore
 */

//Return if the first widget area has no widgets
if ( !is_active_sidebar( 'footer-1' ) ) {
	return;
} ?>

<?php //user selected widget columns

	$mestore_widget_num = esc_html(get_theme_mod('mestore_footer_widgets', '3-wide'));

	if ($mestore_widget_num == '3-wide') :
		$mestore_col1 = 'col-md-3';
		$mestore_col2 = 'col-md-3';
		$mestore_col3 = 'col-md-6 align-right';
	elseif ($mestore_widget_num == '4') :
		$mestore_col1 = 'col-md-3';
		$mestore_col2 = 'col-md-3';
		$mestore_col3 = 'col-md-3';
		$mestore_col4 = 'col-md-3';
	elseif ($mestore_widget_num == '3') :
		$mestore_col1 = 'col-md-4';
		$mestore_col2 = 'col-md-4';
		$mestore_col3 = 'col-md-4';
	elseif ($mestore_widget_num == '2') :
		$mestore_col1 = 'col-md-6';
		$mestore_col2 = 'col-md-6';
	else :
		$mestore_col1 = 'col-md-12';
	endif;
?>
		
<?php 
	if ( is_active_sidebar( 'footer-1' ) ) :
		?>
			<div class="widget-column <?php echo esc_attr($mestore_col1); ?>">
				<?php dynamic_sidebar( 'footer-1'); ?>
			</div>
		<?php
	endif;
	if ( is_active_sidebar( 'footer-2' ) ) :
		?>
			<div class="widget-column <?php echo esc_attr($mestore_col2); ?>">
				<?php dynamic_sidebar( 'footer-2'); ?>
			</div>
		<?php
	endif;
	if ( is_active_sidebar( 'footer-3' ) ) :
		?>
			<div class="widget-column <?php echo esc_attr($mestore_col3); ?>">
				<?php dynamic_sidebar( 'footer-3'); ?>
			</div>
		<?php
	endif;
	if ( is_active_sidebar( 'footer-4' ) ) :
		?>
			<div class="widget-column <?php echo esc_attr($mestore_col4); ?>">
				<?php dynamic_sidebar( 'footer-4'); ?>
			</div>
		<?php
	endif;
?>