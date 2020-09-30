<?php 

$approve_proposals = $row_general_settings->approve_proposals;

if($approve_proposals == "yes"){ $text = "Submit For Approval"; }else{ $text = "Publish"; }

?>
<nav id="tabs">

<div class="container">

<div class="breadcrumb flat mb-0 nav" role="tablist">
	<a class="nav-link <?php if(!isset($_GET['pricing']) and !isset($_GET['publish'])){ echo "active"; } ?>" href="#overview">Overview</a>
	<a class="nav-link <?= (isset($_GET['pricing']) ? "active" : ""); ?>" href="#pricing">Pricing</a>
	<a class="nav-link" href="#description">Description & FAQ</a>
	<a class="nav-link" href="#requirements">Requirements</a>
	<a class="nav-link" href="#gallery">Gallery</a>
	<a class="nav-link <?= (isset($_GET['publish']) ? "active" : ""); ?>" href="#publish"><?= $text; ?></a>
</div>

</div>

</nav>

	<!-- <a class="nav-link active" data-toggle="tab" href="#overview">Overview</a>
	<a class="nav-link" data-toggle="tab" href="#pricing">Pricing</a>
	<a class="nav-link" data-toggle="tab" href="#description">Description & FAQ</a>
	<a class="nav-link" data-toggle="tab" href="#requirements">Requirements</a>
	<a class="nav-link" data-toggle="tab" href="#gallery">Gallery</a>
	<a class="nav-link" data-toggle="tab" href="#publish">Publish</a> -->