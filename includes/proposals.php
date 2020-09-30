<div class="gig_box">

                	<img class="img-responsive" src="<?php echo $site_url; ?>/proposals/proposal_files/<?php echo $proposal_img1; ?>" alt=""/>

                    <a class="gig_title" href="<?php echo $site_url; ?>/proposals/<?php echo $seller_user_name; ?>/<?php echo $proposal_url; ?>" ><?php echo $proposal_title; ?></a>



                    <?php if(isset($_SESSION['seller_user_name'])){ ?>

						<?php if($proposal_seller_id != $login_seller_id){ ?>

						<i data-id="<?php echo $proposal_id; ?>" href="#" class="fa fa-heart <?php echo $show_favorite_class; ?>" data-toggle="tooltip" data-placement="top" title="Favorite"></i>

						<?php } ?>

						<?php }else{ ?>
                    <div class="start_frm"><a href="#" data-toggle="modal" data-target="#login-modal"><i class="fa fa-heart"></i>


					<?php } ?>
                    </a> <span><?= $lang['proposals']['starting_at']; ?> <?= $s_currency; ?><?= $proposal_price; ?></span></div>

              </div>