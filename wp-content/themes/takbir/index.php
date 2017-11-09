<?php get_header(); ?>
<?php  
    if ( function_exists( 'ot_get_option' ) ) {
	  $title_slider = ot_get_option( 'title_slider' );
	  $img_slider = ot_get_option( 'img_slider' );
	  $video_slider = ot_get_option( 'video_slider' );
	  $facebook = ot_get_option( 'facebook' );
	  $linkedin = ot_get_option( 'linkedin' );
	  $call = ot_get_option( 'phone' );
	  $address = ot_get_option( 'address' );
	}
    ?>
<!-- End of main header area -->
  <section id="slider">
    <div class="caption">
      <h3><?php echo $title_slider; ?></h3>
      <a href="#" class="button">DISCOVER MORE</a>
    </div>
    <div class="responsive-embed youtube">
		<video id="video" src="<?php echo $video_slider; ?>" loop="" autoplay=""></video>
		<img src="<?php echo $img_slider; ?>" />
    </div>
<button id="sound-control"><i class="fa fa-lg"></i></button>
  </section>
  <!-- Main content area -->
<?php
			$cats = [];
						$args = array(
								'post_type' => 'products',
								'posts_per_page' => 3,
						);
						$product_query = new WP_Query( $args );
							 ?>
						<?php if ( $product_query->have_posts() ) : ?>
			<?php $i = 1; ?>
							<?php while ($product_query->have_posts()) : $product_query->the_post(); 
			$categories = get_the_category();
			$cats = array_merge($cats, $categories);
			?>
			<?php endwhile; endif; ?>
  <main id="main_content">
	  <?php if ( $product_query->have_posts() ) : ?>
			<?php $i = 0; ?>
			<?php while ($product_query->have_posts()) : $product_query->the_post();
				$class = '';
								if ($i++ == 0){
									$class = ' active ';
								}	
			$categories = get_the_category();
			$slug = '';
			foreach($categories  as $cat){
			if(isset($cat->slug)){
				$slug .= $cat->slug;
			}
			}
			?>
   <div class="one-third">
<!-- begin position 1 --> 
    <div class="card">
    <a href="<?php the_permalink(); ?>">
		<img src="<?php the_post_thumbnail_url(); ?>">
		</a>   
    <div class="card-section text-center">
        <h4><?php the_title() ?></h4>
            <?php the_excerpt(); ?>
         <a href="<?php the_permalink(); ?>" class="button"></a>
    </div>
</div>  
</div>
	  <?php $i++;
									?>
							
			<?php endwhile; endif; ?>
  </main>
  <!-- End of main content -->
<?php get_footer(); ?>