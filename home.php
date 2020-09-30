<?php
$get_section = $db->select("home_section",array("language_id" => $siteLanguage));
$row_section = $get_section->fetch();
$count_section = $get_section->rowCount();
$section_heading = $row_section->section_heading;
$section_short_heading = $row_section->section_short_heading;
$get_slides = $db->query("select * from home_section_slider LIMIT 0,1");
$row_slides = $get_slides->fetch();
$slide_id = $row_slides->slide_id; 
$slide_image = $row_slides->slide_image; 
?>






<section class="main_slider">
    <div id="carousel-example-generic" class="carousel slide carousel-fade" data-ride="carousel">
      <?php
    $count_slides = $db->count("home_section_slider");
    $i = 0;
    $get_slides = $db->query("select * from home_section_slider LIMIT 1,$count_slides");
    while($row_slides = $get_slides->fetch()){
    $i++;
    ?>
    <!-- Wrapper for slides -->
  

    <li data-target="#demo1" data-slide-to="<?php echo $i; ?>"></li>
    <?php } ?>
    
  <div class="carousel-inner" role="listbox">
  	<div class="sli_text">
        	<h1><?php echo $section_heading; ?></h1>
            <p><?php echo $section_short_heading; ?></p>
            				<a class="green_btn" href="signup.html">Get Started!</a>
		</div>
        <?php
        $get_slides = $db->query("select * from home_section_slider LIMIT 0,1");
        while($row_slides = $get_slides->fetch()){
        $slide_image = $row_slides->slide_image;
    ?>
    <div class="item active">
        
      <img class="slider_img img-responsive" src="home_slider_images/<?php echo $slide_image; ?>" alt=""/>
    </div>
    <?php } ?>

    <?php
    $get_slides = $db->query("select * from home_section_slider LIMIT 1,2");
    while($row_slides = $get_slides->fetch()){
    $slide_image = $row_slides->slide_image;
    ?>
    <div class="item ">
        
      <img class="slider_img img-responsive" src="home_slider_images/<?php echo $slide_image; ?>" alt=""/>
    </div>
<?php } ?>

 <?php
    $get_slides = $db->query("select * from home_section_slider LIMIT 0,3");
    while($row_slides = $get_slides->fetch()){
    $slide_image = $row_slides->slide_image;
    ?>
    <div class="item ">
         
      <img class="slider_img img-responsive" src="home_slider_images/<?php echo $slide_image; ?>" alt=""/>
    </div>
<?php } ?>
   
      </div>

  <!-- Controls -->
  <ol class="carousel-indicators"> 
  	    
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        
    <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
        
    <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
      
  </ol>
 <!--<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>-->
</div>
<div class="clearfix"></div>
</section>












<section class="intro_welcome"><img class="left_tri" src="img/tringle2.png" alt=""/>

	<div class="container">

    	<div class="row">

        	<div class="col-md-12">

            	<div class="title_sec">

                	<h1>Welcome to Work<span>glo</span></h1>

                    <span>where the world come to work</span>

                    <p>How does "anything you want" sound? We have experts representing every technical, professional and creative field, providing a full range of solutions. Just give us the details of your project and our skillants will get it done faster, better, and cheaper than you can imagine. Your jobs can be as big or small as you like, they can be fixed price or hourly, and you can specify the schedule and cost range </p>
											<a class="green_btn" href="signup.html">Register Now!</a>
					                </div>

             </div>

            

            <div class="clearfix"></div>

            

        </div>

    </div>

</section>



<section id="howitworks">

	<div class="container">

    	<div class="row">

        	<div class="col-md-12">

            	<div class="title_sec">

                	<h1>How it works</h1>

                </div>

             </div>

             <div class="col-md-3 col-sm-3 col-xs-6">

            	<div class="hiw_box">

                	<img src="img/icon1.png" class="img-responsive" alt=""/>

                    <p>Find experts or tell us what you need</p>

                </div>

             </div>

             <div class="col-md-3 col-sm-3 col-xs-6">

            	<div class="hiw_box">

                	<img src="img/icon2.png" class="img-responsive" alt=""/>

                    <p>Get curated experts to work on your project</p>

                </div>

             </div>

             <div class="col-md-3 col-sm-3 col-xs-6">

            	<div class="hiw_box">

                	<img src="img/icon3.png" class="img-responsive" alt=""/>

                    <p>Work done on your schedule and budget</p>

                </div>

             </div>

             <div class="col-md-3 col-sm-3 col-xs-6">

            	<div class="hiw_box">

                	<img src="img/icon4.png" class="img-responsive" alt=""/>

                    <p>Pay safely only when satisfied</p>

                </div>

             </div>

            

            <div class="clearfix"></div>

            

        </div>

    </div>

</section>



<section id="fea_categories">

	<div class="container">

    	<div class="row">

        	<div class="col-md-12">

            	<div class="title_sec">

                	<h1><?php echo $lang['home']['categories']['title']; ?></h1>

                </div>

             </div>

             <div class="col-md-12">

             
            	<ul class="fea_cat">
                <?php
              $get_categories = $db->query("select * from categories where cat_featured='yes' ".($lang_dir == "right" ? 'order by 1 DESC LIMIT 4,4':' LIMIT 0,8')."");
              while($row_categories = $get_categories->fetch()){
              $cat_id = $row_categories->cat_id;
              $cat_image = $row_categories->cat_image;
              $cat_url = $row_categories->cat_url;
              $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id, "language_id" => $siteLanguage));
              $row_meta = $get_meta->fetch();
              $cat_title = $row_meta->cat_title;
               ?>

                
                	<li><a href="categories/<?php echo $cat_url; ?>"><img src="cat_images/<?php echo $cat_image; ?>" alt="" class="img-responsive"/> <span><?php echo $cat_title; ?></span></a></li>

                    
                

                     <?php } ?>
                	
                    
                </ul>


               <!--  <a class="grn_bor_btn" href="categories.html">See All Categories</a> -->


             </div>

            

            <div class="clearfix"></div>

            

        </div>

    </div>

</section>



<section id="why_workglo">

	<div class="container">

    	<div class="row">

        	<div class="col-md-6 col-sm-5">

            	<div class="top_people">

                	<img src="img/ing1.png" align="" alt="" class="img-responsive"/>

                    <div class="poeple_count">

                    	and other <span class="big-text">5,452</span> <span>talented people</span>

                    </div>

                </div>

             </div>

            <div class="col-md-6 col-sm-7">

            	<div class="title_sec">

                	<h1>Why Work<span>glo</span>?</h1>

                </div>

                <ul class="fea_points">

                	<li><b>Work with top-notch talent: </b>boost your project success by hiring handpicked professional Freelancers</li>

                    <li><b>Hire today, have results tomorrow: </b>collaborate eﬀortlessly and track the progress</li>

                    <li><b>Save your money, time & peace of mind: </b>no payroll hassle, no overheads, no agencies</li>

                    <li><b>Have complete control over your projects: </b>your funds will sit safely in deposit until you're satisﬁed with deliverables</li>

                </ul>

             </div>

            <div class="clearfix"></div>

            

        </div>

    </div>

</section>



<section id="invitations">

	<div class="container">

    	<div class="row">

            <div class="col-md-12">

            	<div class="title_sec">

                	<h1>Featured invitations to bid</h1>

                </div>

             </div>

             <div class="col-md-12">

                	<div  class="table-responsive">

                	<table class="table table-hover">

                      <thead class="thead-default">

                        <tr>

                          <th>Category</th>

                          <th>Project Details</th>

                          <th>Posted on</th>

                          <th>Ending Time</th>

                          <th>Bidding Time Left</th>

                          <th>Budget</th>

                          <th>Bid</th>

                        </tr>

                      </thead>

                      <tbody>

                      
                        <tr>

                          <td scope="row">Research &amp; Summaries</td>

                          <td><h4>Need web developer</h4>
                          	<p>We need the service of experienced web content write to write the content of our foundation site ...</p>
                          </td>
							
                          <td>Thu, 05 2017</td>

                          <td>2 Days</td>

                          <td>24 Hours</td>

                          <td>$30.00</td>

                          <td><a class="bid_btn" href="login36c2.html?REQID=8">Bid</a></td>

                        </tr>

                        
                        <tr>

                          <td scope="row">WordPress</td>

                          <td><h4>Need web developer</h4>
                          	<p>We need the services of an experience developer to develop a property management site for us with a WordPress ...</p>
                          </td>
							
                          <td>Fri, 02 2017</td>

                          <td>7 Days</td>

                          <td>24 Hours</td>

                          <td>$100.00</td>

                          <td><a class="bid_btn" href="logindbb9.html?REQID=2">Bid</a></td>

                        </tr>

                        
                        <tr>

                          <td scope="row">Ecommerce</td>

                          <td><h4>Need wordpress developer</h4>
                          	<p>We need the services of an experience e-commerce developer to build and e-commerce site for us in either Magen...</p>
                          </td>
							
                          <td>Fri, 02 2017</td>

                          <td>7 Days</td>

                          <td>24 Hours</td>

                          <td>$150.00</td>

                          <td><a class="bid_btn" href="loginf36c.html?REQID=3">Bid</a></td>

                        </tr>

                        
                        <tr>

                          <td scope="row">Mobile Apps &amp; Web</td>

                          <td><h4>Need mobile apps developer</h4>
                          	<p>I need a standard mobile app for School Results...</p>
                          </td>
							
                          <td>Sun, 04 2017</td>

                          <td>14 Days</td>

                          <td>24 Hours</td>

                          <td>$250.00</td>

                          <td><a class="bid_btn" href="loginf624.html?REQID=5">Bid</a></td>

                        </tr>

                        
                        <tr>

                          <td scope="row">Programming &amp; Tech</td>

                          <td><h4>I want seniour programmer. </h4>
                          	<p>i Need a programmer...</p>
                          </td>
							
                          <td>Sun, 04 2017</td>

                          <td>14 Days</td>

                          <td>24 Hours</td>

                          <td>$250.00</td>

                          <td><a class="bid_btn" href="logina894.html?REQID=6">Bid</a></td>

                        </tr>

                        
                        <tr>

                          <td scope="row">Support &amp; IT</td>

                          <td><h4>Database programmer required</h4>
                          	<p>I will make a php script in $10...</p>
                          </td>
							
                          <td>Thu, 04 2017</td>

                          <td>1 Days</td>

                          <td>24 Hours</td>

                          <td>$10.00</td>

                          <td><a class="bid_btn" href="login2e37.html?REQID=7">Bid</a></td>

                        </tr>

                        
                        

                      </tbody>

                    </table>

                    </div>

                    <div class="clearfix"><a class="grn_bor_btn" href="requests.html">See All Invitations</a></div>

                </div>

                

            <div class="clearfix"></div>

            

        </div>

    </div>

</section>



<section id="gigs">
	<div class="container">

    	<div class="row">

            <div class="col-md-12">

            	<div class="title_sec">

                	<h1><?php echo $lang['home']['proposals']['title']; ?></h1>

                </div>

             </div>

             

             <div class="clearfix"></div>
             <?php
              $get_proposals = $db->query("select * from proposals where proposal_featured='yes' AND proposal_status='active' LIMIT 0,15");
              while($row_proposals = $get_proposals->fetch()){
              $proposal_id = $row_proposals->proposal_id;
              $proposal_title = $row_proposals->proposal_title;
              $proposal_price = $row_proposals->proposal_price;
              if($proposal_price == 0){
              $get_p_1 = $db->select("proposal_packages",array("proposal_id" => $proposal_id,"package_name" => "Basic"));
              $proposal_price = $get_p_1->fetch()->price;
              }
              $proposal_img1 = $row_proposals->proposal_img1;
              $proposal_video = $row_proposals->proposal_video;
              $proposal_seller_id = $row_proposals->proposal_seller_id;
              $proposal_rating = $row_proposals->proposal_rating;
              $proposal_url = $row_proposals->proposal_url;
              $proposal_featured = $row_proposals->proposal_featured;
              $proposal_enable_referrals = $row_proposals->proposal_enable_referrals;
              $proposal_referral_money = $row_proposals->proposal_referral_money;
              if(empty($proposal_video)){
              $video_class = "";
              }else{
              $video_class = "video-img";
              }
              $get_seller = $db->select("sellers",array("seller_id" => $proposal_seller_id));
              $row_seller = $get_seller->fetch();
              $seller_user_name = $row_seller->seller_user_name;
              $seller_image = $row_seller->seller_image;
              $seller_level = $row_seller->seller_level;
              $seller_status = $row_seller->seller_status;
              if(empty($seller_image)){
              $seller_image = "empty-image.png";
              }
              // Select Proposal Seller Level
              @$seller_level = $db->select("seller_levels_meta",array("level_id"=>$seller_level,"language_id"=>$siteLanguage))->fetch()->title;
              $proposal_reviews = array();
              $select_buyer_reviews = $db->select("buyer_reviews",array("proposal_id" => $proposal_id));
              $count_reviews = $select_buyer_reviews->rowCount();
              while($row_buyer_reviews = $select_buyer_reviews->fetch()){
                  $proposal_buyer_rating = $row_buyer_reviews->buyer_rating;
                  array_push($proposal_reviews,$proposal_buyer_rating);
              }
              $total = array_sum($proposal_reviews);
              @$average_rating = $total/count($proposal_reviews);
          ?>

             
             <div class="col-md-3 col-sm-3 col-xs-6">


              <?php require("includes/proposals.php"); ?>
              

             	

             </div>
              <?php } ?>

             
             
             
            

             
             

             
             
			<div class="clearfix"></div>
            <!-- <div class="clearfix"><a class="grn_bor_btn" href="categories.html">View All</a></div>    --> 

        </div>

    </div>

</section>










<!-- <section id="blogs">

	<div class="container">

    	<div class="row">

            <div class="col-md-12">

            	<div class="title_sec">

                	<h1>Featured From Our Blog</h1>

                </div>

             </div>

             <div class="clearfix"></div>
			             <div class="col-lg-6 col-md-6 col-sm-6">

                    	<div class="story_box">

                        	<div class="blog_img"><img src="img/scriptolution-blog-imgs/o-3.jpg" alt=""/></div>

                            <div class="blog_title"><a href="blog/students.html">Students</a></div>

                            <p class="blog_desc">student su eh kao majr ho cjusn ikesjh wjhw iduw ueiwoinwd woie wej cowwe kowej qd</p>

                            <a class="blue_link" href="blog/students.html">Read full story</a>

                        </div>

                    </div>
			             <div class="col-lg-6 col-md-6 col-sm-6">

                    	<div class="story_box">

                        	<div class="blog_img"><img src="img/scriptolution-blog-imgs/o-2.jpg" alt=""/></div>

                            <div class="blog_title"><a href="blog/showcasing-quality-heres-what-youve-madeonworkglo-2.html">Showcasing Quality: Here's What You've #MadeOnWorkglo 2</a></div>

                            <p class="blog_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore </p>

                            <a class="blue_link" href="blog/showcasing-quality-heres-what-youve-madeonworkglo-2.html">Read full story</a>

                        </div>

                    </div>
			             <div class="clearfix"><a class="grn_bor_btn" href="blogs.html">Read All</a></div>

        </div>

    </div>

</section> -->

<section id="partners" style="background: #892f00;">

	<div class="container">

    	<div class="row">

            <div class="col-md-12">

            	<div class="title_sec">

                	<h1>Trusted By</h1>

                </div>

                <div id="fd2" class="owl-carousel">

                    <div class="item"><img src="img/google.png" align="" alt=""/></div>

                    <div class="item"><img src="img/wp.png" align="" alt=""/></div>

                    <div class="item"><img src="img/microsoft.png" align="" alt=""/></div>

                    <div class="item"><img src="img/amazon.png" align="" alt=""/></div>

                    <div class="item"><img src="img/google.png" align="" alt=""/></div>

                    <div class="item"><img src="img/wp.png" align="" alt=""/></div>

                    <div class="item"><img src="img/microsoft.png" align="" alt=""/></div>

                    <div class="item"><img src="img/amazon.png" align="" alt=""/></div>

                </div>

             </div>

             <div class="clearfix"></div>

             

        </div>

    </div>

</section>


