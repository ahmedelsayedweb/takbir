<?php
/**
 * Template Name: Page service Template
 * Template Post Type: page
 * The template for displaying Page Home
 */
?>
<?php get_header(); ?>
<?php 
	if (have_posts()){
		while (have_posts()){
			the_post(); ?>
<main id="main_content" class="content">
    <div class="page-title">
        <div class="row">
        <h2><?php the_title(); ?></h2>
        </div>
    </div>
	<div class="col-12">
	<ul id="accordion" class="accordion">
		<li>
			<div class="link"><i class="fa fa-globe"></i>Diseño web<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu">
				<li><a href="#">Photoshop</a></li>
				<li><a href="#">HTML</a></li>
				<li><a href="#">CSS</a></li>
				<li><a href="#">Maquetacion web</a></li>
			</ul>
		</li>
		<li class="default open">
			<div class="link"><i class="fa fa-globe"></i>Desarrollo front-end<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu">
				<li><a href="#">Javascript</a></li>
				<li><a href="#">jQuery</a></li>
				<li><a href="#">Frameworks javascript</a></li>
			</ul>
		</li>
		<li>
			<div class="link"><i class="fa fa-globe"></i>Diseño responsive<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu">
				<li><a href="#">Tablets</a></li>
				<li><a href="#">Dispositivos mobiles</a></li>
				<li><a href="#">Medios de escritorio</a></li>
				<li><a href="#">Otros dispositivos</a></li>
			</ul>
		</li>
		<li><div class="link"><i class="fa fa-globe"></i>Posicionamiento web<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu">
				<li><a href="#">Google</a></li>
				<li><a href="#">Bing</a></li>
				<li><a href="#">Yahoo</a></li>
				<li><a href="#">Otros buscadores</a></li>
			</ul>
		</li>
	</ul>
		</div>
  </main>
<?php
							}
							}
						  	?> 
<?php get_footer(); ?>