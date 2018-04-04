<?php 
/*
Template Name: Werkbriefjes
*/
get_header('kaal'); ?>

<!-- begin document -->
<?php 
	$userID = $_GET['userid'];
	$actID = $_GET['actid'];

	//een enkel werkbriefje
	if(!empty($userID)){
		werkbriefke($userID, $actID);
	}
	
	//een batch aan werkbriefjes
	if(empty($userID)){
		global $wpdb;
		$aanmeldingen = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE ActID = '".$_GET['actid']."' AND Afwezig != 'afwezig' AND hoeftNiet != '1' " );
		
		foreach($aanmeldingen as $aanmelding){
			$actID = $_GET['actid'];
			$userID = $aanmelding->StudID;
			werkbriefke($userID, $actID);
		}
		
	}
?>
<!-- einde document -->
<?php
get_footer('kaal');