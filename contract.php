<?php 
/*
Template Name: Contract
*/
get_header('kaal'); ?>

<!-- begin document -->
<?php 
	$userID = $_GET['userid'];
	
	//een batch aan werkbriefjes
	if(!empty($userID)){		
		contract($userID);
	}
?>
<!-- einde document -->
<?php
get_footer('leeg');