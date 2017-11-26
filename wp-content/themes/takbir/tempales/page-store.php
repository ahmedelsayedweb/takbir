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
	<?php the_content();?>
	<div class="col-12">
	<ul id="accordion" class="accordion">
		<li class="default open">
			<div class="link link2"><i class="fa fa-globe"></i>Nasr City<i class="fa fa-chevron-down"></i></div>
		</li>
		<li class="default open">
			<div class="link"><i class="fa fa-globe"></i>City Center<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu">
				<li><a href="#">3 Makram Obied St. Nasr City
3 rd Floor Shop No.: (D 16, 17)
</a></li>
				<li><a href="#">Tel : 23520671</a></li>
			</ul>
		</li>
		<li >
			<div class="link"><i class="fa fa-globe"></i>Genena Mall<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu">
				<li><a href="#">El Batrawy St., From Abbas El Akkad St., Shop No.: (C 11 , 12)</a></li>
				<li><a href="#">Tel : 20820499</a></li>
			</ul>
		</li>
		<li >
			<div class="link"><i class="fa fa-globe"></i>Nasr City<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu">
				<li><a href="#">15 Abbas El Akkad St. </a></li>
				<li><a href="#">Tel : 22744329</a></li>
			</ul>
		</li>
		<li>
			<div class="link"><i class="fa fa-globe"></i>Nasr City<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu">
				<li><a href="#">33 M.Hasanin Hekal St., From Abbas El Akkad St. </a></li>
				<li><a href="#">Tel :22612666</a></li>
			</ul>
		</li>
	</ul>
		<ul id="accordion1" class="accordion">
		<li class="default open">
			<div class="link link2"><i class="fa fa-globe"></i>Heliopolis<i class="fa fa-chevron-down"></i></div>
		</li>
			<li class="default open">
			<div class="link"><i class="fa fa-globe"></i>El Horria Mall<i class="fa fa-chevron-down"></i></div>
			<ul class="submenu">
				<li><a href="#">El Ahram St., Heliopolis 3 rd Floor Shop No. (5)
</a></li>
				<li><a href="#">Tel : 22560195</a></li>
			</ul>
		</li>
	</ul>
		<ul id="accordion2" class="accordion">
		<li class="default open">
			<div class="link link2"><i class="fa fa-globe"></i>El Haram <i class="fa fa-chevron-down"></i></div>
		</li>
			<li class="default open">
			<div class="link"><i class="fa fa-globe"></i>City Mall <i class="fa fa-chevron-down"></i></div>
			<ul class="submenu">
				<li><a href="#">95 El Haram St. Shop No. B65</a></li>
				<li><a href="#">Tel : 33871677</a></li>
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