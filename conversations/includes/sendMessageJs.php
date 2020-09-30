<script>

var height = 0;
$(".col-md-8 .messages .inboxMsg").each(function(i, value){
	height += parseInt($(this).height());
});
height += 2000;

$(".col-md-8 .messages").animate({scrollTop: height});

var login_seller_id = "<?php echo $login_seller_id; ?>";
var seller_id = "<?php echo $seller_id; ?>";
var message_group_id = "<?php echo $message_group_id ?>";

$(document).off('submit').on('submit','#insert-message-form', function(event){
	event.preventDefault();
	sendMessage();
	$(this).off('submit'); 
});

function sendMessage() {
	$("#send-msg").prop("disabled", true);
	$("#send-msg").html("<i class='fa fa-spinner fa-pulse fa-lg fa-fw'></i>");
	message = $('.emojionearea-editor').html();
	if(message==""){
    swal({
	    type: 'warning',
	    text: 'Message can\'t be empty!',
	 	});
		$("#send-msg").prop("disabled", false);
		$("#send-msg").html("Send");
	}else{
		file = $('#fileVal').val();
		$.ajax({
			method: "POST",
			url: "insert_inbox_message",
			data: {single_message_id: message_group_id, message: message, file: file},
			success: function(data){
				$('#message').val('');
				$('#fileVal').val('');
				$(".emojionearea-editor").html("");
				$('.files').html('');
				$("#send-msg").prop("disabled", false);
				$("#send-msg").html("Send");
			}
		});
	}
}

$(document).on('change','#file', function(){
	var form_data = new FormData();
	var name = document.getElementById('file').files[0];
	form_data.append("file", name);
	$.ajax({
		url:"upload_file",
		method:"POST",
		data:form_data,
		contentType:false,
		cache:false,
		processData:false,
	}).done(function(data){
		var file = "<span class='border rounded p-1'>"+name.name+"</span>";
		$(".files").removeClass("d-none").append(file);
		$("#fileVal").val(data);
	});
});

$("#send-offer").click(function(){
	receiver_id = "<?php echo $seller_id; ?>";
	message = $("#message").val();
	file = $("#file").val();
	if(file == ""){
		message_file = file;
	}else{
		message_file = document.getElementById("file").files[0].name;
	}
	$.ajax({
		method: 'POST',
		url: 'send_offer_modal',
		data: {receiver_id: receiver_id, message: message, file: message_file}
	}).done(function(data){
		$("#send-offer-div").html(data);
	});
});

// Javascript Jquery Code To Reload User Typing Status Every half second Code Starts ///

var seller_id = "<?php echo $seller_id; ?>";

setInterval(function(){
	$.ajax({
		method: "POST",
		url: "seller_typing_status",
		data: {seller_id : seller_id, message_group_id: message_group_id}
	}).done(function(data){
		$('.typing-status').html(data);
	});
}, 500);

// Javascript Jquery Code To Reload User Typing Status Every half second Code Ends //

setInterval(function(){
	$.ajax({
		method: "POST",
		url: "includes/display_messages",
		data: {message_group_id: message_group_id}
	}).done(function(data){
		$('.specfic .messages').empty();
		$('.specfic .messages').append(data);
	});
}, 2000);
</script>