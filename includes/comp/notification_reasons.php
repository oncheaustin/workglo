<?php
if($reason == "modification"){
	return "Has sent modification to your proposal.";
}

if($reason == "declined"){
	return "Has Declined your proposal. Please submit a valid proposal.";
}

if($reason == "approved"){
	return "Has approved your proposal. Thanks for posting.";
}

if($reason == "unapproved_request"){
	return "Has unapproved your request. Please submit a valid request.";
}

if($reason == "approved_request"){
	return "Has approved your request. Thanks for posting.";
}

if($reason == "order"){
	return "Has just sent you an order.";
}

if($reason == "order_message"){
	return "Updated the order.";
}

if($reason == "order_revision"){
	return "Requested for a revision.";
}

if($reason == "order_completed"){
	return "Completed your order.";
}

if($reason == "order_delivered"){
	return "Delivered your order.";
}

if($reason == "cancellation_request"){
	return "Wants to cancel the order.";
}

if($reason == "decline_cancellation_request"){
	return "Declined your cancellation request.";
}

if($reason == "accept_cancellation_request"){
	return "Accepted cancellation request.";
}

if($reason == "cancelled_by_customer_support"){
	return "Order has been cancelled by admin.";
}

if($reason == "buyer_order_review"){
	return "Please review and rate your buyer.";
}
if($reason == "seller_order_review"){
	return "Please review and rate your seller.";
}

if($reason == "order_cancelled"){
	return "Your order has been cancelled.";
}

if($reason == "withdrawal_declined"){
	return "your withdrawal request has been declined. click here to view reason.";
}

if($reason == "withdrawal_approved"){
	return "your withdrawal request has been completed. click here to view.";
}
