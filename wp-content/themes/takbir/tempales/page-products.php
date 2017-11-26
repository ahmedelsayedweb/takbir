<?php
/**
 * Template Name: Page products Template
 * Template Post Type: page
 * The template for displaying Page Home
 */
?>
<?php get_header(); ?>
<main id="main_content" class="content">
    <div class="page-title">
        <div class="row">
			<?php
  	$lang = custom_get_current_lang();
	if($lang == 'ar'){
		echo '<h2>منتجاتنا</h2>';
		}elseif($lang == 'en'){
		echo '<h2>Products</h2>';
	};
	?> 
        </div>
    </div>
	<?php
			$cats = [];
						$args = array(
								'post_type' => 'products',
								'posts_per_page' => 200,
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
           
         <a href="<?php the_permalink(); ?>" class="button"></a>
    </div>
</div>  
</div>
	  <?php $i++;
									?>
							
			<?php endwhile; endif; ?>
  </main>
  </main>

<?php get_footer(); ?>