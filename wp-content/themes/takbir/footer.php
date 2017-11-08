<!-- FOOTER-->
<?php  
    if ( function_exists( 'ot_get_option' ) ) {
	  $logo_image = ot_get_option( 'logo' );
	  $description_footer = ot_get_option( 'description_footer' );
	  $favicon = ot_get_option( 'favicon' );
	  $facebook = ot_get_option( 'facebook' );
	  $linkedin = ot_get_option( 'linkedin' );
	  $instagram = ot_get_option( 'instagram' );
	  $address = ot_get_option( 'address' );
	  $phone = ot_get_option( 'phone' );
	  $email = ot_get_option( 'email' );
	  $youtube = ot_get_option( 'youtube' );
	}
    ?>
           <!--Start Footer-->
        <!-- Main footer area -->
  <footer id="main_footer">
    <!-- Top footer area -->
    <div class="top_footer">
      <div class="row">
        <div class="col-12 text-center">
			 <?php
  	$lang = custom_get_current_lang();
	if($lang == 'ar'){
		 echo '  <p>تابعنا عن طريق التواصل الاجتماعي</p>'; 
		}elseif($lang == 'en'){
		echo '  <p>Follow us on</p>'; 
	};
	?>  
         
          <ul class="p0 m0">
            <li><a href="<?php echo $facebook; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="<?php echo $linkedin; ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="<?php echo $instagram; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
            <li><a href="<?php echo $youtube; ?>" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End of top footer area -->
    <!-- Bottom footer area -->
    <div class="mid_footer">
      <div class="row">
		  	 <?php
  	$lang = custom_get_current_lang();
	if($lang == 'ar'){
		 echo '  <div class="col-12 text-center">
          <a href="http://localhost/psolvingegypt/takbir/ar/contact/">تحتاج مساعدة  ؟  الاتصال  بنا  <i class="fa fa-envelope"></i></a>
        </div>'; 
		}elseif($lang == 'en'){
		echo '  <div class="col-12 text-center">
          <a href="http://localhost/psolvingegypt/takbir/contact-us">Need help? contact us on <i class="fa fa-envelope"></i></a>
        </div>'; 
	};
	?>  
        
      </div>
    </div>  
    <div class="bottom_footer">
      <div class="row">
		  	 <?php
  	$lang = custom_get_current_lang();
	if($lang == 'ar'){
		 echo ' <div class="col-3">
          <h4>روابط مهمة</h4>
          <ul class="p0 m0 no-bullet">
            <li><a href="http://localhost/psolvingegypt/takbir/ar/about">من نحن</a></li>
            <li><a href="http://localhost/psolvingegypt/takbir/ar/pro">منتجاتنا</a></li>
            <li><a href="http://localhost/psolvingegypt/takbir/ar/contact">اتصل بنا </a></li>
            <li><a href="#">وظائف خالية</a></li>
          </ul>
        </div>
        <div class="col-3">
          <h4>روابط مهمة </h4>
          <ul class="p0 m0 no-bullet">
            <li><a href="#su-misura"> </a></li>
          </ul>          
        </div>
        <div class="col-3">
          <h4>اتصل بنا</h4>
          <ul class="p0 m0 no-bullet">
            <li><a href="http://localhost/psolvingegypt/takbir/ar/contact">نموذج الاتصال</a></li>
            <li><a href="http://localhost/psolvingegypt/takbir/ar/store">فروعنا</a></li>
          </ul>          
        </div>
        <div class="col-3">
          <h4>تواصل معانا</h4>'; ?>
		  <?php echo
          do_shortcode('[contact-form-7 id="46" title="contact footer ar"]'); ?>
		  <?php echo'
        </div>'; 
		}elseif($lang == 'en'){
		echo ' <div class="col-3">
          <h4>links</h4>
          <ul class="p0 m0 no-bullet">
            <li><a href="http://localhost/psolvingegypt/takbir/about-us">About Us</a></li>
            <li><a href="http://localhost/psolvingegypt/takbir/products">Products</a></li>
            <li><a href="http://localhost/psolvingegypt/takbir/contact-us">Contact Us</a></li>
            <li><a href="">Careers</a></li>
          </ul>
        </div>
        <div class="col-3">
          <h4>links</h4>
          <ul class="p0 m0 no-bullet">
            <li><a href="#su-misura"> </a></li>

          </ul>          
        </div>
        <div class="col-3">
          <h4>Contact us</h4>
          <ul class="p0 m0 no-bullet">
            <li><a href="http://localhost/psolvingegypt/takbir/contact-us">Contact Form</a></li>
            <li><a href="http://localhost/psolvingegypt/takbir/store_locator">Store Locator</a></li>
          </ul>          
        </div>
        <div class="col-3">
          <h4>Continue with us</h4>'; ?>
		  <?php echo
          do_shortcode('[contact-form-7 id="43" title="contact footer"]'); ?>
		  <?php echo'
        </div>'; 
	};
	?>  
      </div>
    </div>
    <!-- End of bottom area -->
  </footer>
  <!-- End of footer -->
  
<div class="copyright">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 text_center_footer">© <?php echo date ('Y'); ?>. All Rights Reserved | Design & Developer by psolvingegypt</div>
            </div>
          </div>
        </div>
        <!--End Footer-->
        <!--start angle up-->
        <a href="##" id="toTop" class="is-visible">
    <i class="fa fa-chevron-up fa-lg"></i>
  </a>
<?php wp_footer(); ?>
</body>	
</html>