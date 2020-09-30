<?php
  session_start();
?>
<html lang="en" class="ui-toolkit">
<head>
  <title> Logging out.. </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
  <link href="styles/bootstrap.css" rel="stylesheet">
  <link href="styles/custom.css" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
  <link href="styles/styles.css" rel="stylesheet">
  <link href="styles/categories_nav_styles.css" rel="stylesheet">
  <link href="font_awesome/css/font-awesome.css" rel="stylesheet">
  <link href="styles/owl.carousel.css" rel="stylesheet">
  <link href="styles/owl.theme.default.css" rel="stylesheet">
  <link href="styles/sweat_alert.css" rel="stylesheet">
  <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
  <script src="js/ie.js"></script>    
  <script type="text/javascript" src="js/sweat_alert.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body style="background-color: #2c3e50;"></body>
</html>
<?php
require_once("includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
  echo "<script> window.open('index','_self') </script>";
}
$seller_user_name = $_SESSION['seller_user_name'];
$login_seller_status = $row_login_seller->seller_status;
if($login_seller_status != "block-ban"){
  $update_seller_status = $db->update("sellers",array("seller_status"=>'offline'),array("seller_user_name"=>$seller_user_name));
}
unset($_SESSION['seller_user_name']);
echo "
<script>
  swal({
    type: 'success',
    text: 'Good Bye! ',
    timer: 3000,
    onOpen: function(){
      swal.showLoading()
    }
  }).then(function(){
    if(
      // Read more about handling dismissals
      window.open('index','_self')
    ){
      console.log('Successfully logged out')
    }
  })
</script>
";
?>
