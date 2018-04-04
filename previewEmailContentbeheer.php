<?php
/*
Template Name: Preview Email Contentbeheer
*/
get_header('kaal'); ?>

<!-- begin document -->
<?php
	global $wpdb;
	$mailID = $_GET['mailid'];
	$lijstDetails = $wpdb->get_row("SELECT * FROM BriefingMaillijst WHERE ID = $mailID" );
	$zonder = "zonder";
	if($lijstDetails->ActID != $zonder){
		previewMailContentbeheer($mailID);
	}else{
		previewMail2Contentbeheer($mailID);
	}
?>
<!-- einde document -->
<?php
get_footer('leeg');
