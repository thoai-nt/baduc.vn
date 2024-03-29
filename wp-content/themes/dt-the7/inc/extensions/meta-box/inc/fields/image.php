<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'THE7_RWMB_Image_Field' ) )
{
	class THE7_RWMB_Image_Field extends THE7_RWMB_File_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			// Enqueue same scripts and styles as for file field
			parent::admin_enqueue_scripts();

			wp_enqueue_style( 'the7-mb-image', THE7_RWMB_CSS_URL . 'image.css', array(), THE7_RWMB_VER );

			wp_enqueue_script( 'the7-mb-image', THE7_RWMB_JS_URL . 'image.js', array( 'jquery-ui-sortable', 'wp-ajax-response' ), THE7_RWMB_VER, true );
		}

		/**
		 * Add actions
		 *
		 * @return void
		 */
		static function add_actions()
		{
			// Do same actions as file field
			parent::add_actions();

			// Reorder images via Ajax
			add_action( 'wp_ajax_the7_mb_reorder_images', array( __CLASS__, 'wp_ajax_reorder_images' ) );
		}

		/**
		 * Ajax callback for reordering images
		 *
		 * @return void
		 */
		static function wp_ajax_reorder_images()
		{
			$field_id = isset( $_POST['field_id'] ) ? $_POST['field_id'] : 0;
			$order    = isset( $_POST['order'] ) ? $_POST['order'] : 0;
			$post_id    = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : 0;


			check_ajax_referer( "the7-mb-reorder-images_{$field_id}" );

			parse_str( $order, $items );
			$items = $items['item'];
			
			delete_post_meta( $post_id, $field_id );

			foreach ( $items as $item )
			{
				add_post_meta( $post_id, $field_id, $item, false );
			}

			The7_RW_Meta_Box::ajax_response( __( 'Order saved', 'the7mk2' ), 'success' );
		}

		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			$i18n_title = apply_filters( 'the7_mb_image_upload_string', _x( 'Upload Images', 'image upload', 'the7mk2' ), $field );
			$i18n_more  = apply_filters( 'the7_mb_image_add_string', _x( '+ Add new image', 'image upload', 'the7mk2' ), $field );

			// Uploaded images
			$html .= self::get_uploaded_images( $meta, $field );

			// Show form upload
			$html .= sprintf(
				'<h4>%s</h4>
				<div class="new-files">
					<div class="file-input"><input type="file" name="%s[]" /></div>
					<a class="the7-mb-add-file" href="#"><strong>%s</strong></a>
				</div>',
				$i18n_title,
				$field['id'],
				$i18n_more
			);

			return $html;
		}

		/**
		 * Get HTML markup for uploaded images
		 *
		 * @param array $images
		 * @param array $field
		 *
		 * @return string
		 */
		static function get_uploaded_images( $images, $field )
		{
			$reorder_nonce = wp_create_nonce( "the7-mb-reorder-images_{$field['id']}" );
			$delete_nonce = wp_create_nonce( "the7-mb-delete-file_{$field['id']}" );
			$classes = array('the7-mb-images', 'the7-mb-uploaded');
			if ( count( $images ) <= 0  )
				$classes[] = 'hidden';
			$ul = '<ul class="%s" data-field_id="%s" data-delete_nonce="%s" data-reorder_nonce="%s" data-force_delete="%s" data-max_file_uploads="%s">';
			$html = sprintf(
				$ul,
				implode( ' ', $classes ),
				$field['id'],
				$delete_nonce,
				$reorder_nonce,
				$field['force_delete'] ? 1 : 0,
				$field['max_file_uploads']
			);

			foreach ( $images as $image )
			{
				$html .= self::img_html( $image );
			}

			$html .= '</ul>';

			return $html;
		}

		/**
		 * Get HTML markup for ONE uploaded image
		 *
		 * @param int $image Image ID
		 *
		 * @return string
		 */
		static function img_html( $image )
		{
			$i18n_delete = apply_filters( 'the7_mb_image_delete_string', _x( 'Delete', 'image upload', 'the7mk2' ) );
			$i18n_edit   = apply_filters( 'the7_mb_image_edit_string', _x( 'Edit', 'image upload', 'the7mk2' ) );
			$li = '
				<li id="item_%s">
					<img src="%s" />
					<div class="the7-mb-image-bar">
						<a title="%s" class="the7-mb-edit-file" href="%s" target="_blank">%s</a> |
						<a title="%s" class="the7-mb-delete-file" href="#" data-attachment_id="%s">×</a>
					</div>
				</li>
			';

			$src  = wp_get_attachment_image_src( $image, 'thumbnail' );
			$src  = $src[0];
			$link = get_edit_post_link( $image );

			return sprintf(
				$li,
				$image,
				$src,
				$i18n_edit, $link, $i18n_edit,
				$i18n_delete, $image
			);
		}

		/**
		 * Standard meta retrieval
		 *
		 * @param mixed $meta
		 * @param int   $post_id
		 * @param array $field
		 * @param bool  $saved
		 *
		 * @return mixed
		 */
		static function meta( $meta, $post_id, $saved, $field )
		{
			global $wpdb;

			$meta = The7_RW_Meta_Box::meta( $meta, $post_id, $saved, $field );
			
			return empty( $meta ) ? array() : (array) $meta;
		}
	}
}
