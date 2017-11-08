<?php
/**
 * Template Name: Page about Template
 * Template Post Type: page
 * The template for displaying Page Home
 */
?>
<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<main id="main_content" class="content">
    <div class="page-title">
        <div class="row">
        <h2><?php the_title(); ?></h2>
        </div>
    </div>
	<div class="col-12 text-center"><?php the_content();?>
<!--		<h2>ABOUT US</h2>
	<div class="about-us-text">CMT panels have been in the industry for over 30 years. Our aim is to bring your project vision to reality.

With unrivaled experience in the sandwich panel and cool room industry, you can rest assured knowing

that our team of accredited builders, installers and project managers will assist you with your project

from start to finish no matter how big or small.

CMT panels is leading the industry by staying abreast with technology using the latest in panel installing

techniques, we have been trusted to play a large part in installing some of Australasias biggest projects.

Using only the best available materials on the market and a focus on quality, you can be at ease knowing

that you are in good hands at CMT panels.</div>-->
		</div>
  </main>
<?php
    endwhile; //resetting the page loop
    wp_reset_query(); //resetting the page query
    ?>
<?php get_footer(); ?>