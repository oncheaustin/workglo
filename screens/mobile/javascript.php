<script>
$(document).ready(function(){

	<?php if(isset($_SESSION['seller_user_name'])){ ?>
	$(document).on("click", "#favorite_<?php echo $proposal_id; ?>", function(event){
		event.preventDefault();
		var seller_id = "<?php echo $login_seller_id; ?>";
		var proposal_id = "<?php echo $proposal_id; ?>";
		$.ajax({
		  type: "POST",
		  url: "../../includes/add_delete_favorite",
		  data: { seller_id: seller_id, proposal_id: proposal_id, favorite: "add_favorite" },
		  success: function(){
		  $("#favorite_<?php echo $proposal_id; ?>").attr({id: "unfavorite_<?php echo $proposal_id; ?>",});
		  $("#unfavorite_<?php echo $proposal_id; ?>").html("<i class='fa fa-heart fa-2x dil'></i>");
		  }
		});
	});

	$(document).on("click", "#unfavorite_<?php echo $proposal_id; ?>", function(event){
		event.preventDefault();
		var seller_id = "<?php echo $login_seller_id; ?>";
		var proposal_id = "<?php echo $proposal_id; ?>";
		$.ajax({
	    type: "POST",
	    url: "../../includes/add_delete_favorite",
	    data: { seller_id: seller_id, proposal_id: proposal_id, favorite: "delete_favorite" },
	    success: function(){
	    $("#unfavorite_<?php echo $proposal_id; ?>").attr({id: "favorite_<?php echo $proposal_id; ?>"});
	    $("#favorite_<?php echo $proposal_id; ?>").html("<i class='fa fa-heart fa-2x dil1'></i>");
	  }
		});
	});
	<?php } ?>

	$(document).on("click", ".seller-info .see-more", function(event){
		$(this).text("See less").addClass("see-less").removeClass("see-more");;
		$(".seller-info").addClass("show");
	});

	$(document).on("click", ".seller-info .see-less", function(event){
		$(this).text("See more").addClass("see-more").removeClass("see-less");;
		$(".seller-info").removeClass("show");
	});

	$(".gig-info-desc .see-more").click(function(){
		text = $(this).text();
		if (text === "Read more") {
		  $(this).text("Read less");
		}else{
		  $(this).text("Read more");
		}
		$(".gig-info-desc").toggleClass("show");
	});

	$(".faq-wrap header").click(function(){
		$(".faq-wrap").toggleClass("show");
	});

	$(".reviews-package header h2, .reviews-package header .ficon").click(function(){
		$(".reviews-package").toggleClass("show");
	});

	$(".filter-dd select").change(function(){
	  var value = $(this).val();
	  if(value == "all"){
			$("#all").show();
			$("#good").hide();
			$("#bad").hide();
	  }else if(value == "good"){
			$("#all").hide();
			$("#good").show();
			$("#bad").hide();
	  }else{
		  $("#all").hide();
			$("#good").hide();
			$("#bad").show();
	  }
	});

});
</script>