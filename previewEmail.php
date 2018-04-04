<?php 
/*
Template Name: Preview Email
*/
get_header('kaal'); ?>

<!-- begin document -->
<?php 
	global $wpdb;
	$mailID = $_GET['mailid'];
	$lijstDetails = $wpdb->get_row("SELECT * FROM Maillijst WHERE ID = $mailID" );
	$zonder = "zonder";
	if($lijstDetails->ActID != $zonder){
		previewMail($mailID); 
	}else{
		previewMail2($mailID);
	}
?>
<!-- einde document -->
<?php
get_footer('leeg');