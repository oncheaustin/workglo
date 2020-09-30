<?php


@session_start();

if(!isset($_SESSION['admin_email'])){
	
echo "<script>window.open('login','_self');</script>";
	
}else{
	

    if(isset($_GET['unpause_proposal'])){
        
        $unpause_id = $input->get('unpause_proposal');
        
        $update_proposal = $db->update("proposals",array("proposal_status"=>'active'),array("proposal_id"=>$unpause_id));

        if($update_proposal){

        $insert_log = $db->insert_log($admin_id,"proposal",$unpause_id,"activated");
            
            echo "<script>
      
                swal({
               
                type: 'success',
                text: 'Listing unpaused/activated successfully!',
                timer: 3000,
                onOpen: function(){
                swal.showLoading()
                }
                }).then(function(){
               
                    window.open('index?view_proposals_paused','_self')

                });

            </script>";
        }
        
    }

?>

<?php } ?>