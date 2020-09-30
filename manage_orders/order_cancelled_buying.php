

<div class="table-responsive box-table mt-3">


	<table class="table table-bordered">

		<thead>
			
			<tr> 

				<th>ORDER SUMMARY</th>
				<th>ORDER DATE</th>
				<th>DUE ON</th>
				<th>TOTAL</th>
				<th>STATUS</th>
				

			</tr>

		</thead>

		<tbody>
            
            <?php


                $sel_orders = $db->select("orders",array("buyer_id" => $login_seller_id,"order_status" => "cancelled"),"DESC");
            
                $count_orders = $sel_orders->rowCount();

                while($row_orders = $sel_orders->fetch()){

                $order_id = $row_orders->order_id;

                $proposal_id = $row_orders->proposal_id;

                $order_price = $row_orders->order_price;

                $order_status = $row_orders->order_status;

                $order_number = $row_orders->order_number;

                $order_duration = intval($row_orders->order_duration);

                $order_date = $row_orders->order_date;

                $order_due = date("F d, Y", strtotime($order_date . " + $order_duration days"));


				$select_proposals = $db->select("proposals",array("proposal_id" => $proposal_id));

				$row_proposals = $select_proposals->fetch();

				$proposal_title = $row_proposals->proposal_title;

                $proposal_img1 = $row_proposals->proposal_img1;


            ?>


			<tr>

				<td>

					<a href="order_details?order_id=<?php echo $order_id; ?>" class="make-black">

						<img class="order-proposal-image" src="proposals/proposal_files/<?php echo $proposal_img1; ?>">

						<p class="order-proposal-title"><?php echo $proposal_title; ?></p>
						

					</a>
					
				</td>

				<td><?php echo $order_date; ?></td>
				<td><?php echo $order_due; ?></td>
				<td><?php echo $s_currency; ?><?php echo $order_price; ?></td>
				<td><button class="btn btn-success"><?php echo ucwords($order_status); ?></button></td>
				


			</tr>
            
            <?php } ?>
			


		</tbody>
		


	</table>
    
    <?php
            
            if( $count_orders == 0){
                
                echo "<center><h3 class='pb-4 pt-4'><i class='fa fa-smile-o'></i> No proposals/services have been cancelled.</h3></center>";
            }
            
            
            
            ?>



</div>