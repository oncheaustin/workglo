<div class="mp-box mp-box-white notop d-lg-block d-none">

<div class="container">

	<div class="box-row">

		<ul class="main-cat-list active">

			<li class="<?=($lang_dir=="right"?'float-right':'')?>">

				<a href="<?php echo $site_url; ?>/dashboard"><?php echo $lang['dashboard']['title']; ?></a>
				
			</li>

			<li class="<?=($lang_dir=="right"?'float-right':'')?>">

				<a href="#"><?php echo $lang['selling']; ?> <i class="fa fa-fw fa-caret-down"></i></a>

				<div class="menu-cont">

					<ul>

						<?php if($count_active_proposals > 0){ ?>

						<li>
							
							<a href="<?php echo $site_url; ?>/selling_orders"><?php echo $lang['orders']; ?></a>

						</li>
						
						<?php } ?>

						<li>
							
							<a href="<?php echo $site_url; ?>/proposals/view_proposals"><?php echo $lang['my_proposals']; ?></a>


						</li>

						<li>
							
							<a href="<?php echo $site_url; ?>/proposals/create_coupon"><?php echo $lang['create_coupon']; ?></a>


						</li>

						<?php if($count_active_proposals > 0){ ?>

						<li>
							
							<a href="<?php echo $site_url; ?>/requests/buyer_requests"><?php echo $lang['buyer_requests']; ?></a>

						</li>

						<li>
							<a href="<?php echo $site_url; ?>/revenue"><?php echo $lang['revenues']; ?></a>
						</li>

						<li>
							<a href="<?= $site_url; ?>/withdrawal_requests"><?= $lang['withdrawal_requests']; ?></a>
						</li>

						<?php } ?>

					</ul>
					
				</div>

			</li>

			<li class="<?=($lang_dir=="right"?'float-right':'')?>">

				<a href="#">
					
					<?php echo $lang['buying']; ?> <i class="fa fa-fw fa-caret-down"></i>

				</a>

				<div class="menu-cont">

					<ul>

						<li>
							
							<a href="<?php echo $site_url; ?>/buying_orders">

								<?php echo $lang['orders']; ?>

							</a>

						</li>
						

						<li>
							
							<a href="<?php echo $site_url; ?>/purchases">

								<?php echo $lang['purchases']; ?>
								
							</a>

						</li>

						<li>
							
							<a href="<?php echo $site_url; ?>/favorites">

								<?php echo $lang['favorites']; ?>

							</a>

						</li>

					</ul>

				</div>
				
			</li>





			<li class="<?=($lang_dir=="right"?'float-right':'')?>">

				<a href="#">
					
					<?php echo $lang['requests']; ?> <i class="fa fa-fw fa-caret-down"></i>

				</a>

				<div class="menu-cont">

					<ul>

						<li>
							
							<a href="<?php echo $site_url; ?>/requests/manage_requests">

								<?php echo $lang['manage_requests']; ?>
								

							</a>


						</li>
						

						<li>
							
							<a href="<?php echo $site_url; ?>/requests/post_request">

								<?php echo $lang['post_request']; ?>

							</a>


						</li>

					</ul>
					
				</div>
				
			</li>


			<li class="<?=($lang_dir=="right"?'float-right':'')?>">

				<a href="#">
					
					<?php echo $lang['contacts']; ?> <i class="fa fa-fw fa-caret-down"></i>

				</a>

				<div class="menu-cont">

					<ul>

						<li>
							
							<a href="<?php echo $site_url; ?>/manage_contacts?my_buyers">

								<?php echo $lang['my_buyers']; ?>

							</a>

						</li>
						
						<li>
							
							<a href="<?php echo $site_url; ?>/manage_contacts?my_sellers">

								<?php echo $lang['my_sellers']; ?>

							</a>

						</li>

					</ul>

				</div>
				
			</li>
            

		<?php if($enable_referrals == "yes"){ ?>

			<li class="<?=($lang_dir=="right"?'float-right':'')?>">

				<a href="#"><?php echo $lang['my_referrals']['title']; ?> <i class="fa fa-fw fa-caret-down"></i></a>

				<div class="menu-cont">

					<ul>

						<li>
							
						<a href="<?php echo $site_url; ?>/my_referrals"><?php echo $lang['user_referrals']; ?></a>

						</li>
						
						<li>
							
						<a href="<?php echo $site_url; ?>/proposal_referrals"><?php echo $lang['proposal_referrals']; ?></a>

						</li>

					</ul>

				</div>
				
			</li>

		<?php } ?>


			<li class="<?=($lang_dir=="right"?'float-right':'')?>">

				<a href="<?php echo $site_url; ?>/conversations/inbox"><?php echo $lang['inbox_messages']; ?></a>
				
			</li>

			<li class="<?=($lang_dir=="right"?'float-right':'')?>">

				<a href="<?php echo $site_url; ?>/notifications"><?php echo $lang['notifications']; ?></a>
				
			</li>


			<li class="<?=($lang_dir=="right"?'float-right':'')?>">

				<a href="<?php echo $site_url; ?>/<?php echo $_SESSION['seller_user_name']; ?>">

								<?php echo $lang['my_profile']; ?>
					
				</a>
				

			</li>


			<li class="<?=($lang_dir=="right"?'float-right':'')?>">

				<a href="<?php echo $site_url; ?>/settings">

					<?php echo $lang['settings']; ?> <i class="fa fa-fw fa-caret-down"></i>

				</a>

					<div class="menu-cont">

					<ul>

						<li>
							
						<a href="<?php echo $site_url; ?>/settings?profile_settings"><?php echo $lang['profile_settings']; ?></a>


						</li>
						
						<li>
							
						<a href="<?php echo $site_url; ?>/settings?account_settings"><?php echo $lang['account_settings']; ?></a>

						</li>

					</ul>

				</div>
				
			</li>
			
			

		</ul>


	</div>
	
    </div>
	

</div>