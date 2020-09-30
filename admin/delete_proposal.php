<?php

@session_start();

if(!isset($_SESSION['admin_email'])){
	
echo "<script>window.open('login','_self');</script>";
	
}else{
	
    
if(isset($_GET['delete_proposal'])){

$delete_id = $input->get('delete_proposal');


$delete_proposal = $db->delete("proposals",array('proposal_id' => $delete_id));

$delete_packages = $db->delete("proposal_packages",array('proposal_id' => $delete_id));
  
$delete_attributes = $db->delete("package_attributes",array('proposal_id' => $delete_id));


if($delete_attributes){

$insert_log = $db->insert_log($admin_id,"proposal",$delete_id,"deleted");

echo "<script>

swal({

type: 'success',
text: 'One Proposal Has Been Deleted Successfully!',
timer: 3000,
onOpen: function(){
swal.showLoading()
}

}).then(function(){

window.open('index?view_proposals_trash','_self');

});

</script>";

}


}

?>

<?php } ?>