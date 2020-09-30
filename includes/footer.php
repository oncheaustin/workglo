<section class="footer">

<div class="container">

		<div class="row">

			<div class="col-md-4 col-sm-6 col-xs-12">

				<div class="about_footer">

					<figure><img src="img/logo.png" alt=""></figure>

					<p>Workglo is the one of the world's largest freelancing and crowdsourcing marketplace by number of users and projects. This magnificent website was launched in 2016 by SOLAFRIPS LIMITED and ever since then it has been creating connections from over 22,704,922 employers and skillants(freelancers) globally from over 200 countries, regions and territories.</p>

                    <span>Phone: +234 (0) 8093282802</span><span>Email: support@workglo.com</span>

				</div>

			</div>

			<div class="col-md-3 col-sm-6 col-xs-6" >

				<div class="pad-left-50">

					<h4><?php echo $lang['categories']; ?></h4>

					<ul class="links">
						<?php
					      $get_footer_links = $db->query("select * from footer_links where link_section='categories' AND language_id='$siteLanguage'  LIMIT 0,4");
					      while($row_footer_links = $get_footer_links->fetch()){
					      $link_id = $row_footer_links->link_id;
					      $link_title = $row_footer_links->link_title;
					      $link_url = $row_footer_links->link_url;
					      ?>

						<li><a href="<?php echo "$site_url$link_url"; ?>"><?php echo $link_title; ?></a></li>
						 <?php } ?>


					</ul>

				</div>

			</div>

			<div class="col-md-2 col-sm-6 col-xs-6">

				<h4><?php echo $lang['about']; ?></h4>

				<ul class="links">
					<?php
				        $get_footer_links = $db->select("footer_links",array("link_section" => "about","language_id" => $siteLanguage));
				        while($row_footer_links = $get_footer_links->fetch()){
				        $link_id = $row_footer_links->link_id;
				        $icon_class = $row_footer_links->icon_class;
				        $link_title = $row_footer_links->link_title;
				        $link_url = $row_footer_links->link_url;
				        ?>

					<li><a href="<?php echo "$site_url$link_url"; ?>"><?php echo $link_title; ?></a></li>

                    <?php } ?>
                </ul>

			</div>

            <div class="col-md-3 col-sm-6 col-xs-6">

				<h4>Resources</h4>

				<ul class="links">

					<li><a href="#">Directory</a></li>

                    <li><a href="#">Find Local Freelancers</a></li>

                    <li><a href="#">Economic Research</a></li>

                    <li><a href="#">Freelance Economy</a></li>

                    <li><a href="#">Stories</a></li>

                </ul>

			</div>

			

		</div>

		<div class="copy">

			<p>Copyright © 2016-2020 Workglo. All Rights Reserved</p>
			
            <div class="home-social">
            	<a href='#' ><?php echo $lang['find_us_on']; ?> &nbsp;&nbsp;</a>

            	<?php
		          $get_footer_links = $db->select("footer_links",array("link_section" => "follow","language_id" => $siteLanguage));
		          while($row_footer_links = $get_footer_links->fetch()){
		          $link_id = $row_footer_links->link_id;
		          $icon_class = $row_footer_links->icon_class;
		          $link_url = $row_footer_links->link_url;
		          ?>

            	<a href="<?php echo "$site_url$link_url"; ?>"> <i class="fa <?= $icon_class; ?>"></i>
            	</a>
            	<?php } ?>
           		<br>

            </div>
            <div class="links"><a href="terms_of_service.html">Terms</a>  |  <a href="privacy_policy.html">Privacy</a></div>

		</div>

</div>



</section>
<script src="js1/jquery-1.9.1.min.js"></script> 


<script src="js1/bootstrap.min.js"></script> 

<script src="js1/owl.carousel.js"></script> 

<script src="js1/custom.js"></script>

<script>
function changeCurrency(_currency){
	$.ajax({
			type: "POST",
			url: "set_lang.php",
			data: "currency="+_currency,
			cache: false,
			success: function(result){
				location.reload();
			}
	});
}
</script>


<section class="messagePopup animated slideInRight"></section>
<link rel="stylesheet" href="<?php echo $site_url; ?>/styles/msdropdown.css"/> 
<?php require("footerJs.php"); ?>


