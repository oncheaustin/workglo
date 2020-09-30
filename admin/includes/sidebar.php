<?php
@session_start();
if(!isset($_SESSION['admin_email'])){
echo "<script>window.open('login','_self');</script>";
}else{
?>
<ul class="nav navbar-nav">
  <li class="pt-5">
    <a href="index?dashboard"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
  </li>
  <li class="menu-item-has-children dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Settings"> <i class="menu-icon fa fa-cog"></i> Settings</a>
    <ul class="sub-menu children dropdown-menu">
      <li><i class="fa  fa-arrow-circle-right"></i><a href="index?general_settings">General Settings</a></li>
      <li><i class="fa  fa-arrow-circle-right"></i><a href="index?layout_settings">Layout Settings</a></li>
      <li><i class="fa  fa-arrow-circle-right"></i><a href="index?payment_settings">Payment Settings</a></li>
      <li><i class="fa  fa-arrow-circle-right"></i><a href="index?mail_settings">Mail Server Settings</a></li>
      <li><i class="fa  fa-arrow-circle-right"></i><a href="index?app_update">Application Update</a></li>
    </ul>
  </li>
  <li>
    <a href="index?view_proposals"> <i class="menu-icon fa fa-table"></i>Proposals/Services
    <?php if(!$count_proposals == 0){ ?>
    <span class="badge badge-success"><?php echo $count_proposals ?></span>
    <?php } ?>
    </a>
  </li>
  <li class="menu-item-has-children dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cube"></i>Accounting</a>
  <ul class="sub-menu children dropdown-menu">
  <li><i class="fa  fa-arrow-circle-right"></i><a href="index?sales"> Sales</a></li>
  <li><i class="fa  fa-arrow-circle-right"></i><a href="index?expenses"> Expenses</a></li>
  </ul>
  </li>
  <li class="menu-item-has-children dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="payouts"> 
      <i class="menu-icon fa fa-money"></i> Payouts
    </a>
    <ul class="sub-menu children dropdown-menu">
      <li><i class="fa  fa-arrow-circle-right"></i><a href="index?payouts&status=pending">Pending</a></li>
      <li><i class="fa  fa-arrow-circle-right"></i><a href="index?payouts&status=declined">Declined</a></li>
      <li><i class="fa  fa-arrow-circle-right"></i><a href="index?payouts&status=completed">Completed</a></li>
    </ul>
  </li>
  <li class="menu-item-has-children dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Reports"> 
    <i class="menu-icon fa fa-flag" ></i>Reports / Abuses
  </a>
  <ul class="sub-menu children dropdown-menu">
    <li><i class="fa  fa-arrow-circle-right"></i><a href="index?order_reports">Order Reports</a></li>
    <li><i class="fa  fa-arrow-circle-right"></i><a href="index?message_reports">Message Reports</a></li>
    <li><i class="fa  fa-arrow-circle-right"></i><a href="index?proposal_reports">Proposal Reports</a></li>
  </ul>
  </li>
  <li>
  <a href="index?inbox_conversations"> <i class="menu-icon fa fa-comments"></i>Inbox Messages</a>
  </li>
  <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-star"></i>Reviews</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?insert_review">Insert Review</a></li>
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?view_buyer_reviews">View Reviews</a></li>
      </ul>
  </li>
  <li>
     <a href="index?buyer_requests"> <i class="menu-icon fa fa-table"></i>Buyer Requests
      <?php if(!$count_requests == 0){ ?>
      <span class="badge badge-success"><?php echo $count_requests; ?></span>
      <?php } ?>
     </a>
  </li>
  <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="menu-icon fa fa-fax"></i>Restricted Words</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?insert_word">Insert Word</a></li>
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?view_words">View Words</a></li>
      </ul>
  </li>
  <li>
      <a href="index?view_notifications"> <i class="menu-icon fa fa-bell"></i>Alerts
      <?php if(!$count_notifications == 0){ ?>
      <span class="badge badge-success"><?php echo $count_notifications; ?></span>
      <?php } ?>
     </a>
  </li>
  <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cubes"></i>Categories</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?insert_cat"> Insert Category</a></li>
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?view_cats"> View Categories</a></li>
      </ul>
  </li>
  <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-stack-exchange"></i>Sub Categories</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?insert_child_cat">Insert Sub Category</a></li>
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?view_child_cats">View Sub Categories</a></li>
      </ul>
  </li>
  <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-calendar"></i>Delivery Times</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?insert_delivery_time">Insert Delivery Time</a></li>
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?view_delivery_times">View Delivery Time</a></li>
      </ul>
  </li>
  <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-language"></i> Seller Languages</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?insert_seller_language"> Insert Seller Language</a></li>
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?view_seller_languages"> View Seller Languages</a></li>
      </ul>
  </li>
  <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Seller Skills"> <i class="menu-icon fa fa-flash"></i> Seller Skills</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?insert_seller_skill"> Insert Seller Skill</a></li>
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?view_seller_skills"> View Seller Skills</a></li>
      </ul>
  </li>
  <li>
      <a href="index?view_seller_levels"> <i class="menu-icon fa fa-bell"></i>Seller Levels
     </a>
  </li>
  <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Customer Support"> <i class="menu-icon fa fa-phone-square"></i> Customer Support</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?customer_support_settings" title="Customer Support Settings">Support Settings
          </a>
          </li>
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?view_support_requests" title="Customer Support Requests">
              Support Requests
              <?php
                  if(!$count_support_tickets == 0){
              ?>
      <span class="badge badge-success"><?php echo $count_support_tickets; ?></span>
             <?php } ?>
              </a>
          </li>
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?insert_enquiry_type"> Insert Enquiry Type</a>
          </li>
          <li><i class="fa  fa-arrow-circle-right"></i><a href="index?view_enquiry_types"> View Enquiry Types</a>
          </li>
      </ul>
  </li>
  <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Seller Skills"> <i class="menu-icon fa fa-gift"></i> Coupons</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?insert_coupon"> Insert Coupon</a></li>
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?view_coupons"> View Coupons</a></li>
      </ul>
  </li>
  <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Seller Skills"> <i class="menu-icon fa  fa-picture-o"></i> Slides</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?insert_slide"> Insert Slide</a></li>
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?view_slides"> View Slides</a></li>
      </ul>
  </li>
  <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Seller Skills"> <i class="menu-icon fa fa-table"></i> Terms & Conditions</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?insert_term"> Insert Term</a></li>
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?view_terms"> View Terms</a></li>
      </ul>
  </li>
  <li>
      <a href="index?view_sellers"> <i class="menu-icon fa fa-users"></i> All Users </a>
  </li>

  <li>
      <a href="index?view_orders"> <i class="menu-icon fa fa-eye"></i> View Orders </a>
  </li>

   <li>
      <a href="index?view_referrals"> <i class="menu-icon fa fa-universal-access"></i> View Referrals
       <?php
              if(!$count_referrals == 0){
          ?>
      <span class="badge badge-success"><?php echo $count_referrals;?></span>
      <?php } ?>
      </a>
  </li>
  <li>
  <a href="index?view_proposal_referrals"> 
  <i class="menu-icon fa fa-universal-access"></i>View Proposal Referrals
  <?php if(!$count_proposals_referrals == 0){ ?>
  <span class="badge badge-success"><?php echo $count_proposals_referrals;?></span>
  <?php } ?>
  </a>
  </li>
   <li class="menu-item-has-children dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Seller Skills"> <i class="menu-icon fa fa-file"></i> Files</a>
      <ul class="sub-menu children dropdown-menu">
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?view_proposals_files"> Proposals Files</a></li>
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?view_inbox_files"> Messages Files</a></li>
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?view_order_files"> Orders Files</a></li>
      </ul>
  </li>
  <li class="menu-item-has-children dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Seller Skills"> 
  <i class="menu-icon fa fa-book"></i> Knowledge Bank
  </a>
          <ul class="sub-menu children dropdown-menu">
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?insert_article_cat"> Insert Article Category</a></li>
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?view_article_cats"> View Article Categories</a></li>
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?insert_article"> Insert Article</a></li>
          <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?view_articles"> View Articles</a></li>
          </ul>
   </li>
  <li class="menu-item-has-children dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Languages"> 
  <i class="menu-icon fa fa-language"></i> Languages
  </a>
  <ul class="sub-menu children dropdown-menu">
  <li>
  <i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?insert_language">Insert Language</a>
  </li>
  <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?view_languages"> View Languages</a></li>
  </ul>
  </li>
  <li class="menu-item-has-children dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Seller Skills"> <i class="menu-icon fa fa-users"></i> Admins</a>
    <ul class="sub-menu children dropdown-menu">
      <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?admin_logs"> Admin Logs</a></li>
      <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?insert_user"> Insert Admin</a></li>
      <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?view_users"> View Admins</a></li>
      <li><i class="menu-icon fa fa-arrow-circle-right"></i><a href="index?user_profile=<?php echo $admin_id; ?>"> Edit My Profile</a></li>
    </ul>
  </li>
  <li>
    <a href="logout"> <i class="menu-icon fa fa-power-off"></i> Logout </a>
  </li>
</ul>
<?php } ?>
