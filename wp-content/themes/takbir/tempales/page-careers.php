<?php
/**
 * Template Name: Page Careers Template
 * Template Post Type: page
 * The template for displaying Page Home
 */
?>
<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<main id="main_content" class="content">
    <div class="page-title">
        <div class="row">
			 <?php
  	$lang = custom_get_current_lang();
	if($lang == 'ar'){
		 echo '  <h2>وظائف خالية</h2>'; 
		}elseif($lang == 'en'){
		echo '  <h2>Careers</h2>'; 
	};
	?>  
        
        </div>
    </div>
	<div class="col-12 text-center">
		<div class="section2">
		<div class="top-border left"></div>
		<div class="top-border right"></div>
		<h2><?php the_title(); ?></h2>
			<form action="#">
				<div class="formContents">   
					 <?php
  	$lang = custom_get_current_lang();
	if($lang == 'ar'){
		 echo do_shortcode('[contact-form-7 id="53" title="Careers form ar"]');
		}elseif($lang == 'en'){
		echo do_shortcode('[contact-form-7 id="4" title="Careers form en"]');
	};
	?>  					
				</div>
			</form>
		</div>
 	</div>
</main>
<?php
    endwhile; //resetting the page loop
    wp_reset_query(); //resetting the page query
    ?>
<?php get_footer(); ?>