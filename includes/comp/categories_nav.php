<div class="header">

  <div id="header" class="menu_header">

    <div class="container">

      <div class="row">

        <div class="col-md-12">

          <nav class="navbar">

  <div class="container-fluid">

    <!-- Brand and toggle get grouped for better mobile display -->

    <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">

        <span class="sr-only">Toggle navigation</span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

      </button>

      <a class="navbar-brand" href="<?php echo $site_url; ?>"><img class="img-responsive <?php if(isset($_SESSION["seller_user_name"])){echo"loggedInLogo";} ?>" <?php if($site_logo_type == "image"){ ?> src="<?php echo $site_url; ?>/images/<?php echo $site_logo_image; ?>" <?php }else{ ?>
        <?php echo $site_logo_text; ?>
        <?php } ?> /></a>

    </div>



    <!-- Collect the nav links, forms, and other content for toggling -->

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <form id="search_form" method="post" action="<?php echo $lang['search']['button']; ?>" class="navbar-form navbar-left">
        <div class="form-group">
			<input name="search_query" type="text" class="form-control search_box" placeholder="<?php echo $lang['search']['placeholder']; ?>">
                <input type="hidden" name="c" id="scriptolution_search_cat" value="<?php echo @$_SESSION["search_query"]; ?>" /> 
        </div>
     </form>

      <ul class="nav navbar-nav navbar-right">
        <?php
        $get_categories = $db->query("select * from categories where cat_featured='yes'".($lang_dir=="right"?'order by 1 DESC':'')." LIMIT 0,3");
        while($row_categories = $get_categories->fetch()){
        $cat_id = $row_categories->cat_id;
        $cat_url = $row_categories->cat_url;
        $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id,"language_id" => $siteLanguage));
        $row_meta = $get_meta->fetch();
        @$cat_title = $row_meta->cat_title;
        ?>

        <li><a href="<?php echo $site_url; ?>/categories/<?php echo $cat_url; ?>"><?php echo @$cat_title; ?></a>
        </li>

         <?php } ?>

        
		
          <li><a class="login_btn" data-toggle="modal" data-target="#login-modal" href="#">Login</a></li>
        	<li><a class="register_btn" data-toggle="modal" data-target="#register-modal" href="#"><?php if ($deviceType == "phone") { echo $lang['mobile_join_now']; } else { echo $lang['join_now']; } ?></a></li>
        
		        <li>
            <select style="padding: 12px; margin-left: 5px;" onChange="changeCurrency(this.value)">
            	<option value="US Dollar" selected="selected">US Dollar - $</option>
            	<option value="Nigerian Naira" >Nigerian Naira - ₦</option>
                <option value="Euro" >Euro - €</option>
                <option value="British Pound" >British Pound - £</option>
            </select>
        </li>
      </ul>

    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->

</nav>

        </div>

      </div>

    </div>

  </div>

</div>
<!--header-->
