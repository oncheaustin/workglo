sQuery(document).ready(function() {
	sQuery(".dropdown dt a").click(function() {
		sQuery(this).parent().parent().find("dd ul").toggle();
		return false;
	});
	sQuery(".dropdown dd ul li a").click(function(e) {
		var text = sQuery(this).html();
		sQuery(this).parent().parent().parent().parent().find("dt a span").html(text);
		sQuery(this).parent().parent().parent().parent().find("dd ul").hide();
		//e.preventDefault();
	});		
	function getSelectedValue(id) {
		return sQuery("#" + id).find("dt a span.value").html();
	}
	sQuery(document).bind('click', function(e) {
		var sQueryclicked = sQuery(e.target);
		if (! sQueryclicked.parents().hasClass("dropdown"))
			sQuery(".dropdown dd ul").hide();
	});		
	sQuery('.customDropdown').customSelect();
	sQuery('.order-extras').hide();
	sQuery(".hoverMe").on('mouseenter',function() {
		sQuery('.order-extras').show();
		sQuery('.order-extras').addClass('open');
	});
	sQuery(".hoverMe").on('mouseleave',function() {
		sQuery('.order-extras').hide();
		sQuery('.order-extras').removeClass('open');
	});
	sQuery(".order-extras").on('mouseenter',function() {
		sQuery('.order-extras').show();
		sQuery('.order-extras').addClass('open');
	});
	sQuery(".order-extras").on('mouseleave',function() {
		sQuery('.order-extras').hide();
		sQuery('.order-extras').removeClass('open');
	});
	sQuery('.contactUser').hide();
	sQuery(".contactPopup").on('click',function() {
		sQuery('.contactUser').fadeIn();
		sQuery('html, body').animate({
			scrollTop: sQuery(".contactUser").offset().top
		}, 800);
		return false;
	});
});
function scriptolution_newtoggle(obj) {
	var el = document.getElementById(obj);
	if ( el.style.display != 'none' ) {
		$('#' + obj).hide();
	}
	else {
		$('#' + obj).show();
	}
}
function scriptolution_newhide(obj) {
	var el = document.getElementById(obj);
	$('#' + obj).hide();
}
function scriptolution_newshow(obj) {
	var el = document.getElementById(obj);
	$('#' + obj).show();
}