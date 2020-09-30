<div id="myCarousel" class="carousel slide">
	<ol class="carousel-indicators">
		<?php if(!empty($proposal_video)){ ?>
		<li data-target="#myCarousel" data-slide-to="0"  class="active"></li>
		<?php } ?>
		<li data-target="#myCarousel" data-slide-to="1" 
		<?php
		if(empty($proposal_video)){ echo "class='active'"; }
		?>
		></li>
		<?php if(!empty($proposal_img2)){ ?>
		<li data-target="#myCarousel" data-slide-to="2"></li>
		<?php } ?>
		<?php if(!empty($proposal_img3)){ ?>
		<li data-target="#myCarousel" data-slide-to="3"></li>
		<?php } ?>
		<?php if(!empty($proposal_img4)){ ?>
		<li data-target="#myCarousel" data-slide-to="4"></li>
		<?php } ?>
	</ol>
	<div class="carousel-inner">
		<?php if(!empty($proposal_video)){ ?>
		<div class="carousel-item active">
		<?php if(!empty($jwplayer_code)){ ?>
		<script type="text/javascript" src="<?php echo $jwplayer_code; ?>"></script>
		<div class="d-block w-100" id="player"></div>
		<script type="text/javascript">
		var player = jwplayer('player');
		player.setup({
		file: "<?php echo $show_video; ?>",
		image: "<?php echo $show_img1; ?>"
		})
		</script>
		<?php }else{ ?>
		<video class="embed-responsive embed-responsive-16by9"  style="background-color:black;" controls>
		<source class="embed-responsive-item" src="<?php echo $show_video; ?>" type="video/mp4">
		<source src="<?php echo $show_video; ?>" type="video/ogg">
		</video>
		<?php } ?>
		</div>
		<?php } ?>
		<div class="carousel-item
		<?php
		if(empty($proposal_video)){ echo "active"; }
		?>
		">
		<img class="d-block w-100" src="<?php echo $show_img1; ?>">
		</div>
		<?php if(!empty($proposal_img2)){ ?>
		<div class="carousel-item">
		<img class="d-block w-100" src="<?php echo $show_img2; ?>">
		</div>
		<?php } ?>
		<?php if(!empty($proposal_img3)){ ?>
		<div class="carousel-item"><!-- carousel-item Starts -->
		<img class="d-block w-100" src="<?php echo $show_img3; ?>">
		</div><!-- carousel-item Ends -->
		<?php } ?>
		<?php if(!empty($proposal_img4)){ ?>
		<div class="carousel-item"><!-- carousel-item Starts -->
		<img class="d-block w-100" src="<?php echo $show_img4; ?>">
		</div><!-- carousel-item Ends -->
		<?php } ?>
	</div>

	<a class="carousel-control-prev slide-nav slide-right" href="#myCarousel" data-slide="prev">
		<!--<span class="carousel-control-prev-icon carousel-icon"></span>-->
		<img src="../../images/left-arrow.png">
	</a>
	<a class="carousel-control-next slide-nav slide-left" href="#myCarousel" data-slide="next">
		<!--<span class="carousel-control-next-icon carousel-icon"></span>-->
		<img src="../../images/right-arrow.png">
	</a>
</div>