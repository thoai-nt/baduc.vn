<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package mestore
 */

if ( ! function_exists( 'mestore_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function mestore_posted_on() {
	$posted_on_text = '';
	$mestore_last_updated_post_date = get_theme_mod( 'mestore_last_updated_post_date', false );
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		if( $mestore_last_updated_post_date ){
            $time_string = '<time class="entry-date published updated" datetime="%3$s" itemprop="dateModified">%4$s</time></time><time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';		  
		}else{
            $time_string = '<time class="entry-date published" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';  
		}        
	}else{
	   $time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';   
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
    $posted_on = sprintf( '%1$s %2$s',$posted_on_text, '<a href="' . esc_url(get_day_link( absint(get_the_date('Y')), absint(get_the_date('m')), absint(get_the_date('d')))) . '" rel="bookmark">' . $time_string . '</a>' );

	
	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'mestore_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function mestore_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) :
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'mestore' ) );
		if ( $categories_list && mestore_categorized_blog() ) :
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'mestore' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		endif;

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'mestore' ) );
		if ( $tags_list ) :
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'mestore' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		endif;
	endif;

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
		echo '<span class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'mestore' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	endif;

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'mestore' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function mestore_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'mestore_categories' ) ) ) :
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'mestore_categories', $all_the_cool_cats );
	endif;

	if ( $all_the_cool_cats > 1 ) :
		// This blog has more than 1 category so one_shop_categorized_blog should return true.
		return true;
	else :
		// This blog has only 1 category so one_shop_categorized_blog should return false.
		return false;
	endif;
}

/**
 * Flush out the transients used in one_shop_categorized_blog.
 */
function mestore_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) :
		return;
	endif;
	// Like, beat it. Dig?
	delete_transient( 'mestore_categories' );
}
add_action( 'edit_category', 'mestore_category_transient_flusher' );
add_action( 'save_post',     'mestore_category_transient_flusher' );



if ( ! function_exists( 'mestore_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 */
function mestore_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) :
		the_custom_logo();
	endif;
}
endif;