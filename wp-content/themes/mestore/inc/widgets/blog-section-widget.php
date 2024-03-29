<?php

/**
 * Blog Section widget.
 */


if( ! class_exists('MeStore_Blog_Section_Widget')) :

class MeStore_Blog_Section_Widget extends WP_Widget {

	var $defaults;
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'mestore_blog_widget', // Base ID
			esc_html__( 'MeStore: Blog Section Widget', 'mestore' ), // Name
			array( 'description' => esc_html__( 'Adds latest blog posts in MeStore WordPress theme. ', 'mestore'), ) // Args
		);		     
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		extract( wp_parse_args( $instance, $this->defaults ) );
		$no_of_posts = ( ! empty( $instance['no_of_posts'] ) ) ? absint( $instance['no_of_posts'] ) : 3;
		$category = ! empty( $instance['category'] ) ? esc_html( $instance['category'] ) : 'category';
		$cb_excerpt = isset ( $instance['cb_excerpt'] ) ? (bool)$instance['cb_excerpt'] : false;

		?>
		<div class="latest-posts-wrapper">
			<div class="latest-posts-lists-wrapper">
				<div class="latest-posts-content">
					<?php
						if("-1"==$category) :
							$query = new WP_Query( array(
								'posts_per_page' 			=> $no_of_posts,
								'post_type'					=> 'post',
							) );
						else :
							$query = new WP_Query( array(
								'posts_per_page' 			=> $no_of_posts,
								'post_type'					=> 'post',
								'category__in'				=> $category
							) );
						endif;
						
						while( $query-> have_posts() ) : $query->the_post(); ?>
							<article class="recent-blog-widget">
						        <div class="blog-post">
						            <div class="image">
						                <?php
						                    if ( has_post_thumbnail()) :
						                        the_post_thumbnail('full');
						                    else :
												$post_img_url = get_template_directory_uri().'/img/no-image.jpg';
												?><img src="<?php echo esc_url($post_img_url); ?>" alt="<?php esc_attr_e('post-image','mestore'); ?>" /><?php
													
						                    endif;
						                ?>						               
						            </div>
						            <div class="meta">
						                <ul class="meta-list">
						                    <li class="author-meta">
						                        <span class="author-icon">
						                           <i class="la la-user"></i>
						                        </span>
						                        <span class="byline" itemprop="author" itemscope="" itemtype="https://schema.org/Person"> 
						                            <span itemprop="name"><a class="author-post-url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>" itemprop="url"><?php the_author() ?></a></span>
						                        </span>
						                    </li>
						                           
						                    <li class="date-meta">
						                        <span class="post-day-icon">
						                           <i class="la la-clock"></i>
						                        </span>
						                        <?php mestore_posted_on(); ?>
						                    </li>
						               
						                    <li class="comments-meta">
						                        <span class="comments-icon">
						                            <i class="la la-comments"></i>
						                        </span>
						                        <span itemprop="commentCount"><a class="post-comments-url" href="<?php the_permalink() ?>#comments"><?php comments_number('0','1','%'); ?> <?php esc_html_e('Comments','mestore'); ?></a></span>
						                    </li>
						                </ul>
						            </div>
						            <div class="clearfix"></div>
						            <div class="content">
						                <h3 class="entry-title">
						                    <?php
						                        if ( is_sticky() && is_home() ) :
						                            echo "<i class='la la-thumbtack'></i>";
						                        endif;
						                    ?>
						                    <a href="<?php echo esc_url( get_permalink()); ?>" rel="bookmark"><?php the_title(); ?></a>
						                </h3>
						                <?php
						                	if( true==$cb_excerpt ) {
						                		the_excerpt();  
						                        ?>
						                            <div class="read-more">
						                                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e('READ MORE','mestore'); ?> <i class="la la-long-arrow-alt-right"></i></a>
						                            </div>
						                        <?php
						                	}
						                ?>
						            </div>
						        </div>
						    </article>
						<?php endwhile;
						wp_reset_postdata();
					?>
				</div>
			</div>
		</div>
		<?php
    }
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
	    $no_of_posts = ( ! empty( $instance['no_of_posts'] ) ) ? absint( $instance['no_of_posts'] ) : 3;
		$category = ! empty( $instance['category'] ) ? esc_html( $instance['category'] ) : 'category';
		$cb_excerpt = isset ( $instance['cb_excerpt'] ) ? (bool)$instance['cb_excerpt'] : false;
	    ?>     	  	    	
		    <p>
				<label for="<?php echo esc_attr($this->get_field_id( 'no_of_posts' )); ?>"><?php esc_html_e( 'Number of posts:', 'mestore' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('no_of_posts')); ?>" type="text" value="<?php echo absint( $no_of_posts ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'category' )); ?>"><?php esc_html_e( 'Choose Category', 'mestore' ); ?>:</label>
				<?php wp_dropdown_categories( array( 'show_option_none' =>esc_html__('-- Select -- ','mestore'),'name' => esc_attr($this->get_field_name( 'category' )), 'selected' => esc_attr($category) ) ); ?>
			</p>
			<p>
				<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('cb_excerpt')); ?>" name="<?php echo esc_attr($this->get_field_name('cb_excerpt')); ?>" value="<?php echo esc_attr('Excerpt','mestore'); ?>" <?php checked( true, $cb_excerpt ); ?>>
				<label for="<?php echo esc_attr($this->get_field_id( 'cb_excerpt' )); ?>"><?php esc_html_e('Show Excerpt','mestore') ?></label><br>
			</p>	
    	<?php
         
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;	
		$instance['no_of_posts'] = absint( $new_instance['no_of_posts'] );
		$instance[ 'category' ] = sanitize_text_field($new_instance[ 'category' ]);
		$instance['cb_excerpt'] = isset ( $new_instance['cb_excerpt'] ) ? (bool)$new_instance['cb_excerpt'] : false;
    	return $instance;
	}

}
endif;

if( ! function_exists('mestore_register_blog_section_widget')) :
// register widget
function mestore_register_blog_section_widget() {
    register_widget( 'MeStore_Blog_Section_Widget' );
}
endif;

add_action( 'widgets_init', 'mestore_register_blog_section_widget' );
