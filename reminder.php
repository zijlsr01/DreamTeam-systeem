<?php require('/home/deb41737/domains/expect-webmedia.nl/private_html/drpr/wp-blog-header.php');
global $wpdb;
$nu = date('Ymd');
$dagNummer = date('N');


if($dagNummer == 5){
			$minEenDag = date('Ymd',strtotime($nu . "+3 days"));
	}else{
		$minEenDag = date('Ymd',strtotime($nu . "+1 days"));
	}




$results = $wpdb->get_results( "SELECT * FROM Briefing WHERE reminder = 'Ja' AND Startdatum = $minEenDag" );

foreach($results as $result){
	reminderMail($result->ID);

}



?>
