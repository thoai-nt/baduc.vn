<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package mestore
 */
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="blog-post">
            <?php
                if ( has_post_thumbnail()) :
                    ?>
                        <div class="image">
                    <?php
                    the_post_thumbnail('full');
                    ?>                            
                        </div>
                    <?php
                endif;
            ?>
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
                <h2 class="entry-title">
                    <?php
                        if ( is_sticky() && is_home() ) :
                            echo "<i class='la la-thumbtack'></i>";
                        endif;
                    ?>
                    <a href="<?php echo esc_url( get_permalink()); ?>" rel="bookmark"><?php the_title(); ?></a>
                </h2>

                <?php
                    if(is_single()) :
                        the_content();
                        wp_link_pages(array(
                            'before' => '<div class="page-link">' . esc_html__('Pages:','mestore'),
                            'after' => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                        )); 
                        ?>
                            <div class="post-tags">
                                <?php the_tags(); ?>
                            </div>
                            <div class="post-categories">
                                <?php esc_html_e('Categories:','mestore') ?><?php the_category(); ?>
                            </div>
                        <?php
                    else :
                        the_excerpt();  
                        ?>
                            <div class="read-more">
                                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e('READ MORE','mestore'); ?> <i class="la la-long-arrow-alt-right"></i></a>
                            </div>
                        <?php
                    endif;
                ?>
            </div>
        </div>
    </article>
    