<!DOCTYPE html>
<html <?php get_bloginfo('language') ?>>
<?php  
    if ( function_exists( 'ot_get_option' ) ) {
	  $logo = ot_get_option( 'logo' );
	  $favicon = ot_get_option( 'favicon' );
	  $instagram = ot_get_option( 'instagram' );
	  $facebook = ot_get_option( 'facebook' );
	  $linkedin = ot_get_option( 'linkedin' );
	  $call = ot_get_option( 'phone' );
	  $email = ot_get_option( 'email' );
	}
    ?>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>"/>
		<title><?php wp_title('|','true','right'); ?><?php bloginfo('name'); ?></title>
		<meta name="keywords" content="">
		<meta name="description" content="">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/ico" href="<?php echo $favicon; ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<?php wp_head(); ?>
		<style type="text/css">
ul.bulletList li, ul.bulletList ul {
	margin-left:7px;
	padding-left:0px;
	font-size:9px;	
}

.bulletList .level0 {
	font-size:13px;
}

.bulletList .level1 {
	font-size:11px;
}
</style>
	</head>
	<body class="home"> 
  <!-- Main header area -->
  <header id="main_header">
    <!-- Top header -->
    <div class="top_header">
        <div class="row">
        <div class="col-6">
          <ul class="p0 m0">
            <li><a href="#"><i class="fa fa-phone"></i><?php echo $call; ?> </a></li>
            <li><a href="#"><i class="fa fa-envelope-o"></i><?php echo $email; ?></a></li>
			  <?php
					if(is_active_sidebar('header')){
					dynamic_sidebar('header');
					}
					?>
          </ul>
        </div>
        <div class="col-6 text-right">
			   <?php
  	$lang = custom_get_current_lang();
	if($lang == 'ar'){
		 echo ' <ul class="p0 m0">
            <li><i class="fa fa-map-marker"></i><a href="http://localhost/psolvingegypt/takbir/ar/store">فروعنا</a></li>
          </ul>'; 
		}elseif($lang == 'en'){
		echo ' <ul class="p0 m0">
            <li><i class="fa fa-map-marker"></i><a href="http://localhost/psolvingegypt/takbir/store_locator">Find a Store</a></li>
          </ul>'; 
	};
	?>  
        </div>
      </div>
    </div>
    <!-- End of top header -->
    <!-- Logo area -->
    <div class="logo_container">
      <div class="row">
        <div class="col-12 text-center">
          <a href="<?php bloginfo('url'); ?>">
			  <img src="<?php echo $logo; ?> " alt="Concrete">
			</a>
        </div>
      </div>
    </div>  
    <!-- End of logo area -->
    <!-- Menu area -->
    <nav id="main_nav" class="fixed">
      <div class="row">
        <div class="col-12 text-center"> 
			    <?php
  	$lang = custom_get_current_lang();
	if($lang == 'ar'){
		 echo ' <ul class="p0 m0">
	<li>
	<a href="http://localhost/psolvingegypt/takbir/ar">الرئيسية</a>
   </li>
	<li>
	<a href="http://localhost/psolvingegypt/takbir/ar/about">من نحن</a>
    </li>
	<li>
	<a href="http://localhost/psolvingegypt/takbir/ar/pro">منتجاتنا</a>
    </li>
	<li>
	<a href="http://localhost/psolvingegypt/takbir/ar/contact/">اتصل بنا</a>
   </li>
</ul> '; 
		}elseif($lang == 'en'){
		echo ' <ul class="p0 m0">
	<li>
	<a href="http://localhost/psolvingegypt/takbir">Home</a>
   </li>
	<li>
	<a href="http://localhost/psolvingegypt/takbir/about-us">About Us</a>
    </li>
	<li>
	<a href="http://localhost/psolvingegypt/takbir/products">Products</a>
    </li>
	<li>
	<a href="http://localhost/psolvingegypt/takbir/contact-us/">Contact Us</a>
   </li>
</ul> '; 
	};
	?>  
        </div>
      </div>          
    </nav>
    <!-- End of menu area -->
  </header>
   