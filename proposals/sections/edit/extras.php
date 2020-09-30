<?php 

  @session_start();

  if(isset($_POST['proposal_id'])){

  require_once("../../../includes/db.php");

  $proposal_id = $input->post('proposal_id');

  }

  if(!isset($_SESSION['seller_user_name'])){

  echo "<script>window.open('../login','_self')</script>";

  }

  $get_extras = $db->select("proposals_extras",array("proposal_id"=>$proposal_id));
  while($row_extras = $get_extras->fetch()){
  $id = $row_extras->id;
  $name = $row_extras->name;
  $price = $row_extras->price;
  ?>
  <div class="tab rounded border-1">
    <!-- tab rounded Starts -->
    <div class="tab-header" data-toggle="collapse" href="#tab-<?php echo $id; ?>">
      <a class="float-left"> <i class="fa fa-bars mr-2"></i> <?php echo $name; ?></a>
      <a class="float-right text-muted"><i class="fa fa-sort-down"></i></a>
      <div class="clearfix"></div>
    </div>
    <div class="tab-body p-3 pb-0 collapse" id="tab-<?php echo $id; ?>" data-parent="#allTabs">
      <form action="#" method="post" class="edit-extra">

        <input type="hidden" name="id" value="<?php echo $id; ?>" required>

        <div class="form-group">
          <input type="text" name="name" placeholder="Extra Name" class="form-control form-control-sm" value="<?php echo $name; ?>" required>
        </div>
        <div class="form-group">
          <div class="input-group input-group-sm">
            <!--- input-group Starts --->
              <span class="input-group-addon"><?php echo $s_currency; ?></span>
            <input type="number" name="price" placeholder="Extra Price" value="<?php echo $price; ?>" class="form-control" required>
          </div>
          <!--- input-group Ends --->
        </div>
        <div class="form-group mb-0">
          <a href="#" class="btn btn-danger btn-sm delete-extra">Delete</a>
          <button type="submit" class="btn btn-success btn-sm float-right">Save</button>
        </div>
      </form>
    </div>
  </div>
  <!-- tab rounded Ends -->
  <?php } ?>
  <div class="tab">
    <?php 

    $form_errors = Flash::render("insert_extra_errors");

    ?>
    <!-- tab rounded Starts -->
    <div class="tab-body rounded border-1 p-3 pb-0 collapse <?php if(!empty($form_errors)){ echo "show"; } ?>" id="insert-extra" data-parent="#allTabs">
      <form action="#" method="post" class="add-extra">
        <div class="form-group">
          <input type="text" name="name" placeholder="Extra Name" class="form-control form-control-sm" required="">
          <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['name']); ?></small>
        </div>
        <div class="form-group">
          <div class="input-group input-group-sm">
            <!--- input-group Starts --->
              <span class="input-group-addon"><?php echo $s_currency; ?></span>
            <input type="number" name="price" placeholder="Extra Price" class="form-control form-control-sm" required="">
          </div>
          <small class="form-text text-danger"><?php echo ucfirst(@$form_errors['price']); ?></small>
          <!--- input-group Ends --->
        </div>
        <div class="form-group mb-0">
          <button type="submit" class="btn btn-success btn-sm float-right">Insert</button>
          <div class="clearfix"></div>
        </div>
      </form>
    </div>
  </div>
  <!-- tab rounded Ends -->

  <script>

  $(document).ready(function(){

  
  $(".add-extra").on('submit', function(event){

  event.preventDefault();

  var form_data = new FormData(this);
    
  form_data.append('proposal_id',<?php echo $proposal_id; ?>);

  $('#wait').addClass("loader");

  $.ajax({
    
  method: "POST",

  url: "ajax/insert_extra",

  data: form_data,

  async: false,cache: false,contentType: false,processData: false
        
  }).done(function(data){

  $('#wait').removeClass("loader");

  if(data == "error"){

  swal({type: 'warning',text: 'You Must Need To Fill Out All Fields Before Updating The Details.'});

  }else{

  $(".add-extra").trigger("reset");

  $("#allTabs").load("sections/edit/extras",{proposal_id : <?= $proposal_id; ?>});

  }

  });

  });


  $(".edit-extra").on('submit', function(event){

  event.preventDefault();

  var form_data = new FormData(this);
    
  form_data.append('proposal_id',<?php echo $proposal_id; ?>);

  $('#wait').addClass("loader");

  $.ajax({
    
  method: "POST",

  url: "ajax/edit_extra",

  data: form_data,

  async: false,cache: false,contentType: false,processData: false
        
  }).done(function(data){

  $('#wait').removeClass("loader");

  if(data == "error"){

  swal({type: 'warning',text: 'You Must Need To Fill Out All Fields Before Updating The Details.'});

  }else{

  swal({type: 'success',text: 'Changes Saved.'});

  }

  });

  });


  $(".delete-extra").on('click',function(){

  event.preventDefault();

  var id = $(this).parent().parent().find("input[name='id']").val();

  var main = $(this).parent().parent().parent().parent();

  $.ajax({
    
  method: "POST",

  url: "ajax/delete_extra",

  data: {proposal_id : <?php echo $proposal_id; ?>, id : id},

  success : function(data){

  main.remove();

  }
        
  });

  });


  });

  </script>