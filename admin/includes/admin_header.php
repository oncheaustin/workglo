  <div class="col-sm-7">
<!-- 
       <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                        <button class="search-trigger"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div>



                    </div>
                </div> -->

                </div>

                <div class="col-sm-5">

                    <div class="user-area dropdown float-right">

                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle text=white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <?php if(!empty($admin_image)){ ?>

                        <img src="admin_images/<?php echo $admin_image; ?>" width="30" height="30" class="rounded-circle text-white">

                       <?php }else{ ?>

                        <img src="admin_images/empty-image.png" width="30" height="30" class="rounded-circle text-white">

                        <?php } ?>

                        &nbsp; <?php echo $admin_name; ?>  &nbsp; <span class="caret"></span>


                       </button>



                        <div class="user-menu dropdown-menu">

                               <a class="nav-link" href="index?dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>

                                <a class="nav-link"  href="index?user_profile=<?php echo $admin_id; ?>"><i class="fa fa-user"></i> My Profile</a>

                                <div class="dropdown-divider"></div>

                                <a class="nav-link" href="logout"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>


                </div>
