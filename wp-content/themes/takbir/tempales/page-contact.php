<?php
/**
 * Template Name: Page contact Template
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
		 echo '  <h2>نموذج الاتصال</h2>'; 
		}elseif($lang == 'en'){
		echo '  <h2>Contact Form</h2>'; 
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
		 echo do_shortcode('[contact-form-7 id="48" title="contact ar"]');
		}elseif($lang == 'en'){
		echo do_shortcode('[contact-form-7 id="47" title="contact en"]');
	};
	?>  
<!--					<label>First name *</label>   
                	<input id="first-name_formId" type="text" name="first-name" value="" size="0" maxlength="255">
					<label>Last name  *</label>
					<input id="last-name_formId" type="text" name="last-name" value="" size="0" maxlength="255">
            		<label>Address </label>
					<input id="address_formId" type="text" name="address" value="" size="0" maxlength="255">     <label>E-Mail  *</label>
					<input id="from_formId" type="text" name="from" value="" size="0" maxlength="255">           <label>Mobile *</label>
                	<input id="mobile-_formId" type="text">
					<label>Massage *</label>
					<textarea class="form-control" rows="5" id="Massage"></textarea>
					<input type="submit" value="Send" class="forwardButton">-->
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