<?php 
/*
Template Name: Contracten
*/
get_header('kaal'); ?>

<!-- begin document -->
<?php 
	
	
	//een batch aan contracten
	
		global $wpdb;
		$contracten = $wpdb->get_results( "SELECT * FROM Beheertool" );
		
		foreach($contracten as $contract){
			$userID = $contract->ID;
			contract($userID);
		}
		
?>
<!-- einde document -->
<?php
get_footer('kaal');