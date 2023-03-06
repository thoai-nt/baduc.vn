<?php

/**
 * Function to return the array of starter content for the theme.
 *
 * Passes it through the `mestore_starter_content` filter before returning.
 *
 *
 * @return array A filtered array of args for the starter_content.
 */
function mestore_get_starter_content() {

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts'     => array(
			'front' => array(
				'post_type'    => 'page',
				'post_title'   => esc_html__( 'Gutenberg Home', 'mestore' ),
				'post_content' => '
									<!-- wp:cover {"url":"' . esc_url( get_stylesheet_directory_uri() ) .'/img/bg-image.jpg","id":299,"dimRatio":0,"focalPoint":{"x":"0.49","y":"0.05"},"minHeight":550,"isDark":false,"align":"full","style":{"color":{}}} -->
									<div class="wp-block-cover alignfull is-light" style="min-height:550px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-299" alt="'. esc_attr_x('home-featured','Theme starter content','mestore'). '" src="' . esc_url( get_stylesheet_directory_uri() ) . '/img/bg-image.jpg" style="object-position:49% 5%" data-object-fit="cover" data-object-position="49% 5%"/><div class="wp-block-cover__inner-container"><!-- wp:spacer {"height":"30px"} -->
									<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"level":5,"style":{"color":{"text":"#54c6d6"}},"fontSize":"medium"} -->
									<h5 class="has-text-color has-medium-font-size" style="color:#54c6d6">' . esc_html_x( 'Furniture', 'Theme starter content', 'mestore' ) . '</h5>
									<!-- /wp:heading -->

									<!-- wp:heading {"textAlign":"left","textColor":"black","fontSize":"large"} -->
									<h2 class="has-text-align-left has-black-color has-text-color has-large-font-size" id="best-deals-and-prices-guaranteed">' . esc_html_x( 'Custom Designed', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"15px"} -->
									<div style="height:15px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"left","textColor":"black","fontSize":"large"} -->
									<h2 class="has-text-align-left has-black-color has-text-color has-large-font-size" id="best-deals-and-prices-guaranteed">' . esc_html_x( 'Modern Furnitures for You', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"50px"} -->
									<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'START SHOPPING', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons -->

									<!-- wp:spacer {"height":"25px"} -->
									<div style="height:25px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph -->
									<p>' . esc_html_x( 'Quick parcel delivery from $99', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:columns {"align":"wide","backgroundColor":"white"} -->
									<div class="wp-block-columns alignwide has-white-background-color has-background"><!-- wp:column {"verticalAlignment":"center"} -->
									<div class="wp-block-column is-vertically-aligned-center"><!-- wp:spacer {"height":"70px"} -->
									<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","textColor":"black","fontSize":"medium"} -->
									<h2 class="has-text-align-center has-black-color has-text-color has-medium-font-size" id="doorstep-within-1-hour">' . esc_html_x( 'FAST SHIPPING', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"0px"} -->
									<div style="height:0px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph {"align":"center","fontSize":"small"} -->
									<p class="has-text-align-center has-small-font-size">' . esc_html_x( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit simepte dsrl vlad imr to faddlo', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph -->

									<!-- wp:spacer {"height":"70px"} -->
									<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:spacer {"height":"70px"} -->
									<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","textColor":"black","fontSize":"medium"} -->
									<h2 class="has-text-align-center has-black-color has-text-color has-medium-font-size" id="guaranteed-satisfaction">' . esc_html_x( 'SAFE DELIVERY', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph {"align":"center","fontSize":"small"} -->
									<p class="has-text-align-center has-small-font-size">' . esc_html_x( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit simepte dsrl vlad imr to faddlo', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph -->

									<!-- wp:spacer {"height":"70px"} -->
									<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:spacer {"height":"70px"} -->
									<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","textColor":"black","fontSize":"medium"} -->
									<h2 class="has-text-align-center has-black-color has-text-color has-medium-font-size" id="great-discounts">' . esc_html_x( '365 DAYS RETURN', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph {"align":"center","fontSize":"small"} -->
									<p class="has-text-align-center has-small-font-size">' . esc_html_x( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit simepte dsrl vlad imr to faddlo', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph -->

									<!-- wp:spacer {"height":"70px"} -->
									<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns -->

									<!-- wp:spacer {"height":"50px"} -->
									<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"30px"}},"textColor":"black"} -->
									<h2 class="has-text-align-center has-black-color has-text-color" id="category-collection" style="font-size:30px">' . esc_html_x( 'SHOP FROM OUR STORE', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#54c6d6"}},"fontSize":"normal"} -->
									<p class="has-text-align-center has-text-color has-normal-font-size" style="color:#54c6d6">' . esc_html_x( 'CHOOSE FROM A RANGE OF PRODUCTS', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph -->

									<!-- wp:spacer {"height":"30px"} -->
									<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#555555"}},"fontSize":"small"} -->
									<p class="has-text-align-center has-text-color has-small-font-size" style="color:#555555">' . esc_html_x( 'This is a demo products list. Install WooCommerce Plugin', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph -->

									<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#555555"}},"fontSize":"small"} -->
									<p class="has-text-align-center has-text-color has-small-font-size" style="color:#555555">' . esc_html_x( '& Add WooCommerce Product Blocks here', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph -->

									<!-- wp:spacer {"height":"50px"} -->
									<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:columns -->
									<div class="wp-block-columns"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:columns {"align":"wide"} -->
									<div class="wp-block-columns alignwide"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"cyan-bluish-gray","minHeight":306,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:306px"><span aria-hidden="true" class="wp-block-cover__background has-cyan-bluish-gray-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-1" style="font-size:15px">' . esc_html_x( 'Product 1', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="100" style="font-size:15px">' . esc_html_x( '$100', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"luminous-vivid-amber","minHeight":306,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:306px"><span aria-hidden="true" class="wp-block-cover__background has-luminous-vivid-amber-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-2" style="font-size:15px">' . esc_html_x( 'Product 2', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="89" style="font-size:15px">' . esc_html_x( '$89', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:columns {"align":"wide"} -->
									<div class="wp-block-columns alignwide"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"light-green-cyan","minHeight":305,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:305px"><span aria-hidden="true" class="wp-block-cover__background has-light-green-cyan-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-3" style="font-size:15px">' . esc_html_x( 'Product 3', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="149-100" style="font-size:15px">' . esc_html_x( '$149', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"pale-cyan-blue","minHeight":303,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:303px"><span aria-hidden="true" class="wp-block-cover__background has-pale-cyan-blue-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-4" style="font-size:15px">' . esc_html_x( 'Product 4', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="79" style="font-size:15px">' . esc_html_x( '$79', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns -->

									<!-- wp:spacer {"height":"50px"} -->
									<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:columns -->
									<div class="wp-block-columns"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:columns {"align":"wide"} -->
									<div class="wp-block-columns alignwide"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"cyan-bluish-gray","minHeight":306,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:306px"><span aria-hidden="true" class="wp-block-cover__background has-cyan-bluish-gray-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-5" style="font-size:15px">' . esc_html_x( 'Product 5', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="100" style="font-size:15px">' . esc_html_x( '$100', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"luminous-vivid-amber","minHeight":306,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:306px"><span aria-hidden="true" class="wp-block-cover__background has-luminous-vivid-amber-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-6" style="font-size:15px">' . esc_html_x( 'Product 6', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="89" style="font-size:15px">' . esc_html_x( '$89', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:columns {"align":"wide"} -->
									<div class="wp-block-columns alignwide"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"light-green-cyan","minHeight":305,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:305px"><span aria-hidden="true" class="wp-block-cover__background has-light-green-cyan-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-7" style="font-size:15px">' . esc_html_x( 'Product 7', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="149-100" style="font-size:15px">' . esc_html_x( '$149', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"pale-cyan-blue","minHeight":303,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:303px"><span aria-hidden="true" class="wp-block-cover__background has-pale-cyan-blue-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-8" style="font-size:15px">' . esc_html_x( 'Product 8', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="79" style="font-size:15px">' . esc_html_x( '$79', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns -->

									<!-- wp:spacer {"height":"60px"} -->
									<div style="height:60px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:spacer {"height":"60px"} -->
									<div style="height:60px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:columns {"style":{"color":{"background":"#f8f8f8"}}} -->
									<div class="wp-block-columns has-background" style="background-color:#f8f8f8"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:spacer {"height":"50px"} -->
									<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:image {"id":89,"sizeSlug":"full","linkDestination":"none"} -->
									<figure class="wp-block-image size-full"><img src="http://localhost:8080/uploadtest/wp-content/uploads/2022/06/chair1.png" alt="" class="wp-image-89"/></figure>
									<!-- /wp:image --></div>
									<!-- /wp:column -->

									<!-- wp:column {"width":"50%"} -->
									<div class="wp-block-column" style="flex-basis:50%"><!-- wp:spacer -->
									<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#54c6d6"},"typography":{"fontSize":"18px"}}} -->
									<p class="has-text-align-center has-text-color" style="color:#54c6d6;font-size:18px">' . esc_html_x( 'NOW IN OUR STORE', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph -->

									<!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#54c6d6"},"typography":{"fontSize":"40px"}}} -->
									<h2 class="has-text-align-center has-text-color" style="color:#54c6d6;font-size:40px"><strong>' . esc_html_x( 'CUSTOM DESIGNED', 'Theme starter content', 'mestore' ) . '</strong></h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"35px"}},"textColor":"black"} -->
									<h2 class="has-text-align-center has-black-color has-text-color" style="font-size:35px">' . esc_html_x( 'Modern Interior Furniture', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"30px"} -->
									<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"width":50} -->
									<div class="wp-block-button has-custom-width wp-block-button__width-50"><a class="wp-block-button__link">' . esc_html_x( 'START SHOPPING', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons -->

									<!-- wp:spacer -->
									<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:spacer {"height":"50px"} -->
									<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:image {"id":90,"sizeSlug":"full","linkDestination":"none"} -->
									<figure class="wp-block-image size-full"><img src="http://localhost:8080/uploadtest/wp-content/uploads/2022/06/chair2.png" alt="" class="wp-image-90"/></figure>
									<!-- /wp:image --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns -->

									<!-- wp:spacer {"height":"70px"} -->
									<div style="height:70px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"30px"}},"textColor":"black"} -->
									<h2 class="has-text-align-center has-black-color has-text-color" id="trendy-products" style="font-size:30px">' . esc_html_x( 'TRENDY PRODUCTS', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#54c6d6"}},"fontSize":"normal"} -->
									<p class="has-text-align-center has-text-color has-normal-font-size" style="color:#54c6d6">' . esc_html_x( 'NEW LAUNCHES', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#555555"}},"fontSize":"small"} -->
									<p class="has-text-align-center has-text-color has-small-font-size" style="color:#555555">' . esc_html_x( 'This is a demo products list. Install WooCommerce Plugin', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph -->

									<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#555555"}},"fontSize":"small"} -->
									<p class="has-text-align-center has-text-color has-small-font-size" style="color:#555555">' . esc_html_x( '& Add WooCommerce Product Blocks', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph -->

									<!-- wp:spacer {"height":"80px"} -->
									<div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph -->
									<p></p>
									<!-- /wp:paragraph -->

									<!-- wp:columns -->
									<div class="wp-block-columns"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:columns {"align":"wide"} -->
									<div class="wp-block-columns alignwide"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"cyan-bluish-gray","minHeight":306,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:306px"><span aria-hidden="true" class="wp-block-cover__background has-cyan-bluish-gray-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-1" style="font-size:15px">' . esc_html_x( 'Product 1', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="100" style="font-size:15px">' . esc_html_x( '$100', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"luminous-vivid-amber","minHeight":306,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:306px"><span aria-hidden="true" class="wp-block-cover__background has-luminous-vivid-amber-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-2" style="font-size:15px">' . esc_html_x( 'Product 2', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="89" style="font-size:15px">' . esc_html_x( '$89', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:columns {"align":"wide"} -->
									<div class="wp-block-columns alignwide"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"light-green-cyan","minHeight":305,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:305px"><span aria-hidden="true" class="wp-block-cover__background has-light-green-cyan-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-3" style="font-size:15px">' . esc_html_x( 'Product 3', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="149-100" style="font-size:15px">' . esc_html_x( '$149', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:cover {"overlayColor":"pale-cyan-blue","minHeight":303,"minHeightUnit":"px","isDark":false} -->
									<div class="wp-block-cover is-light" style="min-height:303px"><span aria-hidden="true" class="wp-block-cover__background has-pale-cyan-blue-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…"} -->
									<p class="has-text-align-center">' . esc_html_x( 'Demo Product', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div></div>
									<!-- /wp:cover -->

									<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"15px"}}} -->
									<h2 class="has-text-align-center" id="product-4" style="font-size:15px">' . esc_html_x( 'Product 4', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"10px"} -->
									<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"15px"}}} -->
									<h3 class="has-text-align-center" id="79" style="font-size:15px">' . esc_html_x( '$79', 'Theme starter content', 'mestore' ) . '</h3>
									<!-- /wp:heading -->

									<!-- wp:spacer {"height":"20px"} -->
									<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center","orientation":"horizontal"}} -->
									<div class="wp-block-buttons"><!-- wp:button {"textColor":"white","style":{"color":{"background":"#54c6d6"}}} -->
									<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background" style="background-color:#54c6d6">' . esc_html_x( 'Add to Cart', 'Theme starter content', 'mestore' ) . '</a></div>
									<!-- /wp:button --></div>
									<!-- /wp:buttons --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns -->

									<!-- wp:spacer {"height":"50px"} -->
									<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph -->
									<p></p>
									<!-- /wp:paragraph -->
								',
			),
			'blog',
			'contact' => array(
				'post_type'    => 'page',
				'post_title'   => esc_html__( 'Contact', 'mestore' ),
				'post_content' => '
									<!-- wp:spacer {"height":50} -->
									<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:columns {"align":"wide"} -->
									<div class="wp-block-columns alignwide"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:heading {"fontSize":"medium"} -->
									<h2 class="has-medium-font-size" id="email-us">' . esc_html_x( 'Email Us', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:paragraph {"fontSize":"normal"} -->
									<p class="has-normal-font-size">' . esc_html_x( 'support@spiraclethemes.com', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:heading {"fontSize":"medium"} -->
									<h2 class="has-medium-font-size" id="phone">' . esc_html_x( 'Phone', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:paragraph {"fontSize":"normal"} -->
									<p class="has-normal-font-size">' . esc_html_x( '123-456-7890', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:heading {"fontSize":"medium"} -->
									<h2 class="has-medium-font-size" id="address">' . esc_html_x( 'Address', 'Theme starter content', 'mestore' ) . '</h2>
									<!-- /wp:heading -->

									<!-- wp:paragraph {"fontSize":"normal"} -->
									<p class="has-normal-font-size">' . esc_html_x( '123, Upper Street New York, US', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns -->

									<!-- wp:spacer -->
									<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:columns {"align":"wide"} -->
									<div class="wp-block-columns alignwide"><!-- wp:column -->
									<div class="wp-block-column"><!-- wp:contact-form-7/contact-form-selector -->
									<div class="wp-block-contact-form-7-contact-form-selector">[contact-form-7 id="" title=""]</div>
									<!-- /wp:contact-form-7/contact-form-selector -->

									<!-- wp:spacer {"height":50} -->
									<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph {"textColor":"black"} -->
									<p class="has-black-color has-text-color">' . esc_html_x( 'Add the Contact Form 7 Shortcode above', 'Theme starter content', 'mestore' ) . '</p>
									<!-- /wp:paragraph --></div>
									<!-- /wp:column -->

									<!-- wp:column -->
									<div class="wp-block-column"><!-- wp:image {"id":507,"sizeSlug":"full","linkDestination":"none"} -->
									<figure class="wp-block-image size-full"><img src="' . esc_url( get_stylesheet_directory_uri() ) . '/img/img-5.jpg" alt="Contact Us" class="wp-image-507"/></figure>
									<!-- /wp:image --></div>
									<!-- /wp:column --></div>
									<!-- /wp:columns -->

									<!-- wp:spacer -->
									<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
									<!-- /wp:spacer -->

									<!-- wp:paragraph -->
									<p></p>
									<!-- /wp:paragraph -->
								',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options'   => array(
			'show_on_front'  => 'page',
			'page_on_front'  => '{{front}}',
			'page_for_posts' => '{{blog}}',
			'blogdescription' => esc_html__( 'WooCommerce WordPress theme', 'mestore' ),
			'blogname' => 'MeStore',
		),
		'theme_mods'  => array(
			'mestore_enable_header_category_menu'  => true,
			'mestore_site_primary_color'  => '#54c6d6',
			'mestore_site_secondary_color'  => '#000000',
		),

		'widgets' => array(
			'topsidebar' => array(
				'text_world' => array(
			       	'text',
			        array(
			        	'text'  => '<p>Free Shipping all orders above $99. <button>Shop Now</button></p>',
			        )
			    ),
			),
			'footer-1' => array(
				'text_world' => array(
			       	'text',
			        array(
			        	'title'  => esc_html__( 'Quick Links', 'mestore' ),
			        	'text'  => '<ul>
										<li><a href="#">' . esc_html__( 'About Us', 'mestore' ) . '</a></li>
										<li><a href="#">' . esc_html__( 'Why MeStore', 'mestore' ) . '</a></li>
										<li><a href="#">' . esc_html__( 'Customer Reviews', 'mestore' ) . '</a></li>
										<li><a href="#">' . esc_html__( 'Support', 'mestore' ) . '</a></li>
										<li><a href="#">' . esc_html__( 'Privacy Policy', 'mestore' ) . '</a></li>
										<li><a href="#">' . esc_html__( 'Terms & Conditions', 'mestore' ) . '</a></li>
									</ul>',
			        )
			    ),
			),
			'footer-2' => array(
				'archives'
			),
			'footer-3' => array(
				'text_world' => array(
			       	'text',
			        array(
			        	'text'  => '<img src="' . esc_url( get_stylesheet_directory_uri() ) . '/img/logo.png" alt="' . esc_attr__( 'footer logo', 'mestore' ) . '" width="150px"><br/><br/>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras urna sem, imperdiet in leo et, fermentum luctus ipsum. Integer ut orci justo. Curabitur posuere rutrum condimentum. In porttitor ligula vel bibendum dictum<br/><br/><br/>',
			        )
			    ),
			),
		),
		
		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "primary" location.
			'primary' => array(
				'name'  => esc_html__( 'Primary', 'mestore' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_blog',
					'page_contact',
				),
			),
			'categorymenu' => array(
				'name'  => esc_html__( 'Category Menu', 'mestore' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_blog',
					'page_contact',
				),
			),
		),
	);

	/**
	 * Filters the array of starter content.
	 *
	 *
	 * @param array $starter_content Array of starter content.
	 */
	return apply_filters( 'mestore_starter_content', $starter_content );
}
