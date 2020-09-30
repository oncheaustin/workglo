<div class="col-md-12">
<div class="card card-body mb-4 freelancerBox">
	<figure class="wt-userlistingimg">
		<?php if(!empty($seller_image)){ ?>
		<img src="user_images/<?php echo $seller_image; ?>" width="100" class="rounded img-fluid">
		<?php }else{ ?>
		<img src="user_images/empty-image.png" width="100" class="rounded img-fluid">
		<?php } ?>
		<small class="text-muted mt-1">
			<?php echo ($seller_status=="online" ? "<i class='fa fa-circle text-success'></i>" : "<i class='fa fa-circle text-danger'></i>") ?>
			<?php echo $seller_status; ?>
		</small>
		<div class="wt-userdropdown wt-away template-content tipso_style wt-tipso">
		 	<?php if($seller_level == 2){ ?>
			  <img src="images/level_badge_1.png" class="level_badge">
			<?php }elseif($seller_level == 3){ ?>
			  <img src="images/level_badge_2.png" class="level_badge">
			<?php }elseif($seller_level == 4){ ?>
			  <img src="images/level_badge_3.png" class="level_badge">
			<?php } ?>
		</div>
		<a id="chatBtn" data-toggle="tooltip" data-placement="top" title="Chat With Me" href="conversations/message.php?seller_id=<?php echo $seller_id; ?>" class="btn btn-success mt-4 text-white "><i class="fa fa-comments-o" aria-hidden="true"></i> Chat</a>
  </figure>
	<div class="request-description">
		<div class="row">
			<div class="col-lg-9 col-md-12">
				<a href="<?php echo $seller_user_name; ?>">
				<h6 class="font-weight-normal"><i class="fa fa-check-circle" style="color:#00cc8d;"></i> <?php echo $seller_name; ?> </h6>
				<h5 class="text-success"> <?php echo $seller_headline; ?> </h5>
				</a>
				<ul class="tagline mb-2">
					<li>
					<i class="fa fa-user"></i>
					<strong>Member Since: </strong> <?php echo $seller_register_date; ?>
					</li>
					<?php if($seller_recent_delivery != "none"){ ?>
					<li>
					<i class="fa fa-truck fa-flip-horizontal"></i>
					<strong>Recent Delivery: </strong> <?php echo $seller_recent_delivery; ?>
					</li>
					<?php } ?>
					<li>
					<i class="fa fa-map-marker"></i>
					<strong>Country: </strong> <?php echo $seller_country; ?>
					</li>
					<li>
						<a href="conversations/message.php?seller_id=<?php echo $seller_id; ?>"><i class="fa fa-comments-o"></i> <strong>Contact:</strong> <?php echo $seller_user_name; ?> </a>
					</li>
			  </ul>
			</div>
			<div class="col-lg-3 col-md-12">
				<div class="star-rating">
				<?php
				for($seller_i=0; $seller_i<$average_rating; $seller_i++){
				  echo " <i class='fa fa-star'></i> ";
				}
				for($seller_i=$average_rating; $seller_i<5; $seller_i++){
				  echo " <i class='fa fa-star-o'></i> ";
				}
				?>
				<h4 class="mb-1"><?php printf("%.1f", $average); ?>/<small class="text-muted font-weight-normal">5</small></h4>
				<a>(<?php echo $count_reviews; ?> Reviews)</a>
				</div>
			</div>
		</div>
		<p class="lead mb-2 mt-0"><?php echo $seller_about; ?></p>
		<div class="skills">
			<?php
			$select_skills_relation = $db->select("skills_relation",array("seller_id" => $seller_id));
			$countSkills = $select_skills_relation->rowCount();
			$i = 0;
			while($row_skills_relation = $select_skills_relation->fetch()){
				$i++;
				$relation_id = $row_skills_relation->relation_id;
				$skill_id = $row_skills_relation->skill_id;
				$skill_level = $row_skills_relation->skill_level;
				$get_skill = $db->select("seller_skills",array("skill_id" => $skill_id));
				$row_skill = $get_skill->fetch();
				$skill_title = $row_skill->skill_title;
				$dNone = "";
				if($i > 5){
					$dNone = "d-none";
				}
			?>
			<button class="btn btn-light tags-<?php echo $seller_id; ?> <?php echo $dNone; ?>"><?php echo $skill_title; ?></button>
			<?php } ?>
			<?php if($countSkills > 5){ ?>
			<button class="btn btn-light showMore" data-id="<?php echo $seller_id; ?>">More..</button>
			<?php } ?>
		</div>
	</div>
</div>
<script>
	$(".showMore").click(function(){
		var id = $(this).data("id");
		$(".tags-"+id).removeClass("d-none");
		$(this).addClass("d-none");
	});
</script>
</div>