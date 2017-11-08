<?php
/**
 * The template for displaying all single posts and attachments
 * Template Post Type: post
 * @package WordPress
 */
?>
<?php get_header(); ?>
<?php  
    if ( function_exists( 'ot_get_option' ) ) {
	  $title_page_about = ot_get_option( 'title_page_about' );
	  $description_page_about = ot_get_option( 'description_page_about' );
	}
    ?>
   <div class="col-md-12 main_news">
	   <div class="container">
	   <?php 
	if (have_posts()){
		while (have_posts()){
			the_post(); ?>
            <div class="l-main-content l-main-content_pd-rgt l-main-content_pd-top_lg">
              <div class="posts-group">
                <article class="b-post b-post-4 clearfix">
                  <div class="col-md-12 entry-media">
					  <a href="<?php the_permalink(); ?>" class="js-zoom-images">
						  <img src="<?php the_post_thumbnail_url(); ?>" class="img-responsive"/>
					  </a>
					</div>
                  <div class="entry-main">
                    <div class="entry-header">
                      <h2 class="entry-title entry-title_spacing ui-title-inner"><?php the_title(); ?></h2>
                    </div>
                    <div class="entry-content"><?php the_content(); ?></div>
                  </div>
					<?php
							}
							}
						  	?> 
                </article>  
              </div>
            </div>
          </div>
	   </div>
<?php get_footer(); ?>