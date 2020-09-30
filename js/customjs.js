$(document).ready(function(){
	var base_url = $("#custom-js").data("base-url");
	var seller_id = $("#custom-js").data("logged-id");
	var enable_sound = $("#custom-js").data("enable-sound");
	$('.my-navbar-toggler').click(function(){
		$('#order-status-bar').toggle();
	});
	    
	$(".home-featured-carousel").owlCarousel({
		items:5,
		margin:18,
		autoplay:false,
		loop:false,
		rtl:false,
		nav:true,
		autoplaySpeed:1000,
		responsiveClass:true,
		responsive:{
			0:{
				items:1,
			},
			480:{
				items:2	
			},
			768:{
		  	items:3
			},
			900:{
				items:4
			},
			1140:{
		   	items:5
			}
		}
	});

	$('[data-toggle="tooltip"]').tooltip();

	$(document).on('click','.dropdown-menu',function(event){
		event.stopPropagation();
	});

	$(".dropdown-menu .dropdown-item.dropdown-toggle").click(function(){
		$('.collapse.dropdown-submenu').collapse('hide');
	});

	$(".home-cards-carousel").owlCarousel({
		items:5,
		margin:18,
		autoplay:false,
		nav:true,
		autoplaySpeed:1000,
		responsiveClass:true,
		responsive:{
		0:{
		items:2,
		margin:14,
		autoWidth:true,
		},
		480:{
		items:2	
		},
		768:{
			items:3
		},
		900:{
			items:4
		},
		1140:{
			items:5
		}
		}
	});

	$(".user-home-featured-carousel").owlCarousel({		
		items:3,
		margin:30,
		stagePadding:20,
		autoplay:true,
		autoplaySpeed:1000,
		responsive:{
			0:{
				items:1,
			},
			480:{
				items:1,
			},
			600:{
				items:2
			},
			1000:{
				items:3
			}
		}
	});

	$("#register-modal input[name='u_name']").keypress(function (e) {
		if (!(e.which != 8 && e.which != 0 &&  ((e.which >= 45 && e.which <= 45)  || (e.which >= 48 && e.which <= 57)  || (e.which >= 65 && e.which <= 90) || (e.which >= 95 && e.which <= 95) || (e.which >= 97 && e.which <= 122) ))) {
				event.preventDefault();
			}
		}).keyup(function (e) {
			if (!(e.which != 8 && e.which != 0 &&  ((e.which >= 45 && e.which <= 45)  || (e.which >= 48 && e.which <= 57)  || (e.which >= 65 && e.which <= 90) || (e.which >= 95 && e.which <= 95) || (e.which >= 97 && e.which <= 122) ))) {
				event.preventDefault();
			}
		}).keypress(function (e) {
			if (!(e.which != 8 && e.which != 0 &&  ((e.which >= 45 && e.which <= 45)  || (e.which >= 48 && e.which <= 57)  || (e.which >= 65 && e.which <= 90) || (e.which >= 95 && e.which <= 95) || (e.which >= 97 && e.which <= 122) ))) {
				event.preventDefault();
			}
	});


	$("#search-query").keyup(function(e){
		var val = $(this).val();
		if(val != ""){
			$.ajax({
				type: "POST",
				url: base_url+"/includes/comp/search-auto",
				data: {seller_id:seller_id, search:val},
				success: function(data){
					result = $.parseJSON(data);
		      		proposals = result.proposals;
		      		sellers = result.sellers;
					var html = "";
					if(result.count_proposals > 0){
					 	html += "<aside><li> <i class='fa fa-paint-brush'></i> Services </li><ul>";
					for(i in proposals){
						html += "<li><a href='"+proposals[i].url+"'>"+proposals[i].title+"</a></li>";
					}
						html += "</ul></aside>";
					}
					if(result.count_sellers > 0){
						html += "<aside><li> <i class='fa fa-user'></i> Users </li><ul>";
					for(i in sellers){
						html += "<li><a href='"+sellers[i].url+"'>"+sellers[i].name+"</a></li>";
					}
						html += "</ul></aside>";
					}
					if(result.count_proposals == 0 & result.count_sellers == 0){
						var html = "";
					}
					$('.search-bar-panel').html(html);
				}
			});
			$('.search-bar-panel').removeClass('d-none');
		}else{
			$('.search-bar-panel').addClass('d-none');
		}
	});

	if(seller_id != 0){

		$(document).on("click", ".proposal-favorite", function(event){
			var proposal_id = $(this).attr("data-id");
			$.ajax({
				type: "POST",
				url: base_url+"/includes/add_delete_favorite",
				data:{seller_id:seller_id, proposal_id:proposal_id, favorite:"add_favorite"},
				success: function(){
					$('i[data-id="'+proposal_id+'"]').attr({ class:"proposal-unfavorite fa fa-heart dil"});
				}
			});
		});

		$(document).on("click", ".proposal-unfavorite", function(event){
			var proposal_id = $(this).attr("data-id");
			$.ajax({
			type:"POST",
			url:base_url+"/includes/add_delete_favorite",
			data:{seller_id:seller_id,proposal_id:proposal_id,favorite:"delete_favorite"},
			success: function(){
				$('i[data-id="'+proposal_id+'"]').attr({class:"proposal-favorite fa fa-heart dil1"});
			}
			});
		});

		$(".proposal-offer").click(function(){
			var proposal_id = $(this).attr("data-id");
			$.ajax({
			method: "POST",
			url: base_url+"/referral_modal",
			data: {proposal_id: proposal_id }
			}).done(function(data){
				$(".append-modal").html("");
				$(".append-modal").html(data);
			});
		});

		$(document).on("click", ".closePopup", function(event){
			event.preventDefault();
			$(this).parent().fadeOut();
		});

		//// Ajax Requests Code Starts ////
	  play = new Audio(base_url+"/images/sound.mp3");
	  play.volume = 0.1;
	  var stop_audio = function(){
	  	play.pause();
	  }

	  setInterval(function(){
		  $.ajax({
		  method: "POST",
		  url: base_url+"/includes/comp/messages-bells",
		  data: {seller_id : seller_id}
		  }).done(function(data){
		  	if(data != ""){
			  	if(!isNaN(data)){
					  if(enable_sound == "yes"){
					  	play.play(); 
					  }
					  setTimeout(stop_audio, 2000);
				  }
				}
		  });
	  }, 2500);

		var c_favorites = function(){
			$.ajax({
			method: "POST",
		    url: base_url+"/includes/comp/c-favorites",
		    data: {seller_id: seller_id}
		    }).done(function(data){
		    data = parseInt(data);
		    if(data > 0){
		      $(".c-favorites").html(data);
		  	}else{ $(".c-favorites").html(""); }
		      setTimeout(c_favorites, 1000);
		   });
	  }
	  c_favorites();

	  var c_messages_header = function(){
	    $.ajax({
	    method: "POST",
	    url: base_url+"/includes/comp/c-messages-header",
	    data: {seller_id: seller_id}
	    }).done(function(data){
		  	if(data > 0){
		      $(".c-messages-header").html(data);
		  	}else{ 
		  		$(".c-messages-header").html(""); 
		  	}
	      setTimeout(c_messages_header, 1000);
	    });
	  }
	  c_messages_header();

	  var c_messages_body = function(){
	    $.ajax({
	    method: "POST",
	    url: base_url+"/includes/comp/c-messages-body",
	    data: {seller_id: seller_id}
	    }).done(function(data){
	      result = $.parseJSON(data);
	      messages = result.messages;
	      html = "<h3 class='dropdown-header'> "+result['lang'].inbox+" ("+result.count_all_inbox_sellers+") <a class='float-right make-black' href='"+base_url+"/conversations/inbox' style='color:black;'>"+result['lang'].view_inbox+"</a></h3>";
	      if(parseInt(result.count_all_inbox_sellers) == 0){
	      	html += "<h6 class='text-center mt-3'> No Messages Are Available </h6>";
	      }
	      for(i in messages){
	      	html += "<div class='"+messages[i].class+"'><a href='"+base_url+"/conversations/inbox?single_message_id="+messages[i].message_group_id+"'><img src='"+base_url+"/user_images/"+messages[i].sender_image+"' width='50' height='50' class='rounded-circle'><strong class='heading'>"+messages[i]['sender_user_name']+"</strong><p class='message text-truncate'>"+messages[i].desc+"</p><p class='date text-muted'>"+messages[i].date+"</p></a></div>";
	      }
	      if(parseInt(result.count_all_inbox_sellers) > 0){
	      html += "<div class='mt-2'><center class='pl-2 pr-2'><a href='"+base_url+"/conversations/inbox' class='ml-0 btn btn-success btn-block'>"+result.see_all+"</a></center></div>";
	  	  }
	      $('.messages-dropdown').html(html);
	      setTimeout(c_messages_body, 1000);
	    });
	  } 
	  c_messages_body();

	  var c_notifications_header = function(){
	    $.ajax({
	    method: "POST",
	    url: base_url+"/includes/comp/c-notifications-header",
	    data: {seller_id: seller_id}
	    }).done(function(data){
		    if(data > 0){
		      $(".c-notifications-header").html(data);
		  	}else{ 
		  		$(".c-notifications-header").html(""); 
		  	}
	      setTimeout(c_notifications_header, 1000);
	    });
	  }
	  c_notifications_header();

	  var c_notifications_body = function(){
	    $.ajax({
	    method: "POST",
	    url: base_url+"/includes/comp/c-notifications-body",
	    data: {seller_id: seller_id}
	    }).done(function(data){
	      result = $.parseJSON(data);
	      notifications = result.notifications;
	      html = "<h3 class='dropdown-header'> "+result['lang'].notifications+" ("+result.count_all_notifications+") <a class='float-right make-black' href='"+base_url+"/notifications' style='color:black;'>"+result['lang'].view_notifications+"</a></h3>";
	      if(parseInt(result.count_all_notifications) == 0){
	      	html += "<h6 class='text-center mt-3'>"+result['lang'].no_notifications+"</h6>";
	      }
	      for(i in notifications){
	      	html += "<div class='"+notifications[i].class+"'><a href='"+base_url+"/dashboard?n_id="+notifications[i].id+"'><img src='"+base_url+"/"+notifications[i].sender_image+"' width='50' height='50' class='rounded-circle'><strong class='heading'>"+notifications[i]['sender_user_name']+"</strong><p class='message text-truncate'>"+notifications[i].message+"</p><p class='date text-muted'>"+notifications[i].date+"</p></a></div>";
	      }
	      if(parseInt(result.count_all_notifications) > 0){
	      	html += "<div class='mt-2'><center class='pl-2 pr-2'><a href='"+base_url+"/notifications' class='ml-0 btn btn-success btn-block'>"+result.see_all+"</a></center></div>";
	      }
	      $('.notifications-dropdown').html(html);
	      setTimeout(c_notifications_body, 1000);
	    });
	  }
	  c_notifications_body();

	  var messagePopup = function(){
	    $.ajax({
	    method: "POST",
	    url: base_url+"/includes/messagePopup",
	    data: {seller_id: seller_id}
	    }).done(function(data){
	      result = $.parseJSON(data);
	      html = '';
	      for(i in result){
	     		html += "<div class='header-message-div'><a class='float-left' href='"+base_url+"/conversations/inbox?single_message_id="+result[i].message_group_id+"'><img src='"+base_url+"/user_images/"+result[i].sender_image+"' width='50' height='50' class='rounded-circle'><strong class='heading'>"+result[i].sender_user_name+"</strong><p class='message'>"+result[i].desc+"</p><p class='date text-muted'>"+result[i].date+"</p></a><a href='#' class='float-right close closePopup btn btn-sm pl-lg-5 pt-0'><i class='fa fa-times'></i></a></div>";
	      }
	      $('.messagePopup').prepend(html);
	      setTimeout(messagePopup, 2000);
	    });
	  }
	  messagePopup();
	
	  var notificationsPopup = function(){
	    $.ajax({
	    method: "POST",
	    url: base_url+"/includes/notificationsPopup",
	    data: {seller_id: seller_id, enable_sound : '<?php echo $login_seller_enable_sound; ?>'}
	    }).done(function(data){
	      result = $.parseJSON(data);
	      html = '';
	      for(i in result){
	     		html += "<div class='header-message-div'><a class='float-left' href='"+base_url+"/dashboard?n_id="+result[i].notification_id+"'><img src='"+base_url+"/"+result[i].sender_image+"' width='50' height='50' class='rounded-circle'><strong class='heading'>"+result[i].sender_user_name+"</strong><p class='message'>"+result[i].message+"</p><p class='date text-muted'>"+result[i].date+"</p></a><a href='#' class='float-right close closePopup btn btn-sm pl-lg-5 pt-0'><i class='fa fa-times'></i></a></div>";
		     		if(enable_sound == "yes"){ 
					  	play.play(); 
					  }
	      }
	      $('.messagePopup').prepend(html);
	      setTimeout(notificationsPopup, 2000);
	      setTimeout(stop_audio, 2000);
      });
		}
		notificationsPopup();
		// Ajax Requests Code Ends ////

	}

	// Footer
	if($(window).width() < 767.98) {
		// do something for small screens
		$("footer .collapse.show").removeClass("show");
	}else if ($(window).width() >= 767.98 &&  $(window).width() <= 991.98) {
		// do something for medium screens
	}else if ($(window).width() > 992 &&  $(window).width() <= 1199.98) {
		// do something for big screens
		$(".footer .collapse.show").removeClass("collapse");
	}else{
		// do something for huge screens
		$("footer h3").removeAttr("data-toggle","data-target");
	}

});