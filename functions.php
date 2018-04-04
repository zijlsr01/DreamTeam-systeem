<?php

	add_filter('show_admin_bar', '__return_false');

	function testFunctie($testFunctieVersie){

			if($testFunctieVersie == testFunctieMail1){
					ini_set( 'display_errors', 1 );
					error_reporting( E_ALL );
					$from = "contentbeheer@nhl.nl";
					$to = "ruben.zijlstra@nhl.nl";
					$subject = "Dit is een test voor mail 1";
					$message = "This is a test to check the PHP Mail functionality";
					$headers = "From:" . $from;
					mail($to,$subject,$message, $headers);
					echo "Test email 1 sent";

			}

			if($testFunctieVersie == testFunctieMail2){

				ini_set( 'display_errors', 1 );
				error_reporting( E_ALL );
				$from = "contentbeheer@nhl.nl";
				$to = "ruben.zijlstra@nhl.nl";
				$subject = "Dit is een test voor mail 2";
				$message = "This is a test to check the PHP Mail functionality";
				$headers = "From:" . $from;
				mail($to,$subject,$message, $headers);
				echo "Test email 2 sent";


			}


	}


function testGeert($versie){

			if($versie == '1'){
			echo "versie 1";
			}

			if($versie == '2'){
				echo "versie 2";
			}
}

function countConvers($dag,$camMid,$camSrc){
	global $wpdb;

		$aantal = $wpdb->get_var("SELECT COUNT(*) FROM CampagneStats2 WHERE Middel = '".$camMid."' AND Campagne = '".$camSrc."' AND TrackDate = '".$dag."'");

		return $aantal;

}

function countConvers2($camMid,$camSrc){
	global $wpdb;

		$aantal = $wpdb->get_var("SELECT COUNT(*) FROM CampagneStats2 WHERE Middel = '".$camMid."' AND Campagne = '".$camSrc."'");

		return $aantal;

}



function countConvers3($camMid,$camSrc){
	global $wpdb;

		$aantal = $wpdb->get_var("SELECT COUNT(*) FROM CampagneStats WHERE Middel = '".$camMid."' AND Campagne = '".$camSrc."'");

		return $aantal;

}

function countConvers4($dag,$camSrc){
	global $wpdb;

		$aantal = $wpdb->get_var("SELECT COUNT(*) FROM CampagneStats2 WHERE Campagne = '".$camSrc."' AND TrackDate = '".$dag."' AND Kanaal =''");

		return $aantal;

}

function countConvers5($dag,$camSrc){
	global $wpdb;

		$aantal = $wpdb->get_var("SELECT COUNT(*) FROM CampagneStats2 WHERE Campagne = '".$camSrc."' AND TrackDate = '".$dag."' AND Kanaal !=''");

		return $aantal;

}


function countConvers6($tijd,$camSrc){
	global $wpdb;
		$tijdO = explode(':', $tijd);
		$tijdU = $tijdO[0] + 1;
		if($tijdU == '24'){
			$tijdU2 = "00";
		}else{
			$tijdU2 = $tijdU;
		}
		 if($tijdO[0] == '0'){
			 $min = "01";
		 }else{
			 $min = $tijdO[0];
		 }

		$tijdT = $tijdU2.":".$min.":".$tijdO[2];
		$aantal = $wpdb->get_var("SELECT COUNT(*) FROM CampagneStats2 WHERE Campagne = '".$camSrc."' AND TrackTime BETWEEN '".$tijd."' AND '".$tijdT."'");
		echo $tijd." - ".$tijdT."<br>";
		return $aantal;

}

function countConversTotaal($camSrc){
	global $wpdb;

	$aantal = $wpdb->get_var("SELECT COUNT(*) FROM CampagneStats2 WHERE Campagne = '".$camSrc."'");

		return $aantal;
}

function countConversTotaalCam($camSrc){
	global $wpdb;

	$aantal = $wpdb->get_var("SELECT COUNT(*) FROM CampagneStats2 WHERE Campagne = '".$camSrc."' AND Middel = ''");

		return $aantal;
}

function countConversTotaalCam2($camSrc){
	global $wpdb;

	$aantal = $wpdb->get_var("SELECT COUNT(*) FROM CampagneStats2 WHERE Campagne = '".$camSrc."' AND Middel not like ''");

		return $aantal;
}


function getKanaal($chanName){
	global $wpdb;
	$kanaal = $wpdb->get_row("SELECT * FROM Kanalen WHERE Kanaal = '".$chanName."'");
	return $kanaal->ID;
}


function getKanaalName($id){
	global $wpdb;
	$kanaal = $wpdb->get_row("SELECT * FROM SocialMedia WHERE ID = '".$id."'");
	return $kanaal->Kanaal;
}

function getMiddel($kanaal,$middel,$campageCode,$variant){
	global $wpdb;
	$MidID = $wpdb->get_var("SELECT ID FROM Middelen WHERE Kanaal = '".$kanaal."' AND Uiting_type = '".$middel."'");
	$campagne = $wpdb->get_var("SELECT ID FROM Content WHERE campagneCode = '".$campageCode."'");
	$Middel = $wpdb->get_row("SELECT * FROM CampagneMiddelen WHERE Kanaal = '".$kanaal."' AND Middel = '".$MidID."' AND Campagne = '".$campagne."' AND omschrijving = '".$variant."'");
	return $Middel->ID;
}



function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

function rand_char($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

	function getIcon($type){
		if(!empty($type)){
			if($type == 'Campagne'){
				$icon = get_bloginfo(template_url)."/images/cmp.png";
			}
			if($type == 'Facebook Post'){
				$icon = get_bloginfo(template_url)."/images/iconFacebook.png";
			}
			if($type == 'Persbericht'){
				$icon = get_bloginfo(template_url)."/images/iconPersbericht.png";
			}

			if($type == 'Radio Interview'){
				$icon = get_bloginfo(template_url)."/images/iconRadio.png";
			}

			$result = "<img src='".$icon."' border='0' width='18'>";
			return $result;
		}
	}

	function getIconGroot($type){
		if(!empty($type)){
			if($type == 'Campagne'){
				$icon = get_bloginfo(template_url)."/images/iconCampagneGroot.png";
			}
			if($type == 'Facebook Post'){
				$icon = get_bloginfo(template_url)."/images/iconFacebookGroot.png";
			}
			if($type == 'Persbericht'){
				$icon = get_bloginfo(template_url)."/images/iconPersberichtGroot.png";
			}

			if($type == 'Radio Interview'){
				$icon = get_bloginfo(template_url)."/images/iconRadioGroot.png";
			}

			$result = "<img src='".$icon."' border='0' width='30'>";
			return $result;
		}
	}

	function get_mooiemaand($getal){

		if( $getal == '01' ){ $dag = "Januari"; }
		if( $getal == '02' ){ $dag = "Februari"; }
		if( $getal == '03' ){ $dag = "Maart"; }
		if( $getal == '04' ){ $dag = "April"; }
		if( $getal == '05' ){ $dag = "Mei"; }
		if( $getal == '06' ){ $dag = "Juni"; }
		if( $getal == '07' ){ $dag = "Juli"; }
		if( $getal == '08' ){ $dag = "Augustus"; }
		if( $getal == '09' ){ $dag = "September"; }
		if( $getal == '10' ){ $dag = "oktober"; }
		if( $getal == '11' ){ $dag = "November"; }
		if( $getal == '12' ){ $dag = "December"; }

		return $dag;
	}

	function geslacht($geslacht){
			if($geslacht == 'Mannelijk' || $geslacht == 'mannelijk'){
				echo "Mannelijk";
		}else{
			echo "Vrouwelijk";
		}
	}


	function mooiedatum($datum){
		$dagnummer = date("N", strtotime($datum));
		$dagDatum = date("d", strtotime($datum));
		$maandDatum = date("n", strtotime($datum));
		$jaar = date("Y", strtotime($datum));

		if( $dagnummer == '1' ){ $dag = "Ma"; }
		if( $dagnummer == '2' ){ $dag = "Di"; }
		if( $dagnummer == '3' ){ $dag = "Wo"; }
		if( $dagnummer == '4' ){ $dag = "Do"; }
		if( $dagnummer == '5' ){ $dag = "Vr"; }
		if( $dagnummer == '6' ){ $dag = "Za"; }
		if( $dagnummer == '7' ){ $dag = "Zo"; }

		if( $maandDatum == '1' ){ $maand = "jan"; }
		if( $maandDatum == '2' ){ $maand = "feb"; }
		if( $maandDatum == '3' ){ $maand = "mrt"; }
		if( $maandDatum == '4' ){ $maand = "apr"; }
		if( $maandDatum == '5' ){ $maand = "mei"; }
		if( $maandDatum == '6' ){ $maand = "jun"; }
		if( $maandDatum == '7' ){ $maand = "jul"; }
		if( $maandDatum == '8' ){ $maand = "aug"; }
		if( $maandDatum == '9' ){ $maand = "sep"; }
		if( $maandDatum == '10' ){ $maand = "okt"; }
		if( $maandDatum == '11' ){ $maand = "nov"; }
		if( $maandDatum == '12' ){ $maand = "dec"; }

		echo $dag." ".$dagDatum." ".$maand." ".$jaar;
	}

	function cookiedatum($datum){
		$dagnummer = date("D", strtotime($datum));
		$dagDatum = date("d", strtotime($datum));
		$maandDatum = date("M", strtotime($datum));
		$jaar = date("Y", strtotime($datum));


		echo $dagnummer.", ".$dagDatum." ".$maandDatum." ".$jaar;
	}


	function get_mooiedatum($datum){
		$dagnummer = date("N", strtotime($datum));
		$dagDatum = date("d", strtotime($datum));
		$maandDatum = date("n", strtotime($datum));
		$jaar = date("Y", strtotime($datum));

		if( $dagnummer == '1' ){ $dag = "Ma"; }
		if( $dagnummer == '2' ){ $dag = "Di"; }
		if( $dagnummer == '3' ){ $dag = "Wo"; }
		if( $dagnummer == '4' ){ $dag = "Do"; }
		if( $dagnummer == '5' ){ $dag = "Vr"; }
		if( $dagnummer == '6' ){ $dag = "Za"; }
		if( $dagnummer == '7' ){ $dag = "Zo"; }

		if( $maandDatum == '1' ){ $maand = "jan"; }
		if( $maandDatum == '2' ){ $maand = "feb"; }
		if( $maandDatum == '3' ){ $maand = "mrt"; }
		if( $maandDatum == '4' ){ $maand = "apr"; }
		if( $maandDatum == '5' ){ $maand = "mei"; }
		if( $maandDatum == '6' ){ $maand = "jun"; }
		if( $maandDatum == '7' ){ $maand = "jul"; }
		if( $maandDatum == '8' ){ $maand = "aug"; }
		if( $maandDatum == '9' ){ $maand = "sep"; }
		if( $maandDatum == '10' ){ $maand = "okt"; }
		if( $maandDatum == '11' ){ $maand = "nov"; }
		if( $maandDatum == '12' ){ $maand = "dec"; }

		return $dag." ".$dagDatum." ".$maand." ".$jaar;
	}

	function mooiedatum3($datum){
		$dagnummer = date("N", strtotime($datum));
		$dagDatum = date("d", strtotime($datum));
		$maandDatum = date("n", strtotime($datum));
		$maand = date("m", strtotime($datum));
		$jaar = date("Y", strtotime($datum));

		echo $dagDatum."-".$maand."-".$jaar;
	}

	function mooiedatum4($datum){
		$dagnummer = date("N", strtotime($datum));
		$dagDatum = date("d", strtotime($datum));
		$maandDatum = date("n", strtotime($datum));
		$jaar = date("Y", strtotime($datum));

		if( $maandDatum == '1' ){ $maand = "Januari"; }
		if( $maandDatum == '2' ){ $maand = "Februari"; }
		if( $maandDatum == '3' ){ $maand = "Maart"; }
		if( $maandDatum == '4' ){ $maand = "April"; }
		if( $maandDatum == '5' ){ $maand = "Mei"; }
		if( $maandDatum == '6' ){ $maand = "Juni"; }
		if( $maandDatum == '7' ){ $maand = "Juli"; }
		if( $maandDatum == '8' ){ $maand = "Augustus"; }
		if( $maandDatum == '9' ){ $maand = "September"; }
		if( $maandDatum == '10' ){ $maand = "Oktober"; }
		if( $maandDatum == '11' ){ $maand = "November"; }
		if( $maandDatum == '12' ){ $maand = "December"; }

		echo $maand." ".$jaar;
	}




	function contactNaam($userID){
		$user_info = get_userdata($userID);

		echo $user_info->display_name;
	}


	function studentNaam($StudID){
		global $wpdb;
		$studentDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = $StudID" );

		echo $studentDetails->Voornaam." ".$studentDetails->Tussenvoegsel." ".$studentDetails->Achternaam;
	}

	function getStudentNaam($StudID){
		global $wpdb;
		$studentDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = $StudID" );

		return $studentDetails->Voornaam." ".$studentDetails->Tussenvoegsel." ".$studentDetails->Achternaam;
	}



	function studentOpleiding($StudID){
			global $wpdb;
			$studentDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = $StudID" );

			echo $studentDetails->Opleiding;
		}


	function studentGegevens($StudID){
			global $wpdb;
			$studentDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = $StudID" );

			return $studentDetails;
		}


	function activiteitNaam($ActID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $ActID" );

		echo $actDetails->Titel;
	}

	function get_activiteitNaam($ActID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $ActID" );

		return $actDetails->Titel;
	}


	function get_briefingNaam($ActID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $ActID" );

		return $actDetails->Titel;
	}

	function activiteitDatum($ActID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $ActID" );

		mooiedatum($actDetails->Datum);
	}

	function activiteitDatum2($ActID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $ActID" );

		return $actDetails->Datum;
	}

	function activiteitDatum3($ActID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $ActID" );

		echo $actDetails->Datum;
	}


	function getMiddelName($middelID){
		global $wpdb;
		$middelDetails = $wpdb->get_row("SELECT * FROM Middelen WHERE ID = $middelID" );

		return $middelDetails->Uiting_type;
	}

	function getMiddelName2($middelID){
		global $wpdb;
		$middelCamID = $wpdb->get_row("SELECT * FROM CampagneMiddelen WHERE ID = $middelID" );
		$geert = $middelCamID->Middel;
		$kanaal = $middelCamID->Kanaal;
		$kanaalDetails = $wpdb->get_row("SELECT * FROM Kanalen WHERE ID = $kanaal" );
		$middelDetails = $wpdb->get_row("SELECT * FROM Middelen WHERE ID = $geert" );

		return $kanaalDetails->Kanaal." - ".$middelDetails->Uiting_type." ".$middelCamID->omschrijving;
	}

	function createCampagneName($camID){
		global $wpdb;
		$camDetails = $wpdb->get_row("SELECT * FROM Content WHERE ID = $camID" );
		$Jaar = substr($camDetails->Tijd_tot, 0, 6);
		$camName = preg_replace('/\s+/', '', $camDetails->Titel);
		//$camName = str_replace(' ', '%20', $camDetails->Titel);

		$utmCamName = $Jaar.$camName;

		return $utmCamName;

	}


	function getCampagneName($camID){
		global $wpdb;
		$camDetails = $wpdb->get_row("SELECT * FROM Content WHERE ID = $camID" );
		$Jaar = substr($camDetails->Tijd_tot, 0, 6);
		$camName = preg_replace('/\s+/', '', $camDetails->Titel);
		//$camName = str_replace(' ', '%20', $camDetails->Titel);

		$utmCamName = $Jaar.$camName;

		return $utmCamName;

	}

	function getChanel($chanelID){
		global $wpdb;
		$chanelDetails = $wpdb->get_row("SELECT * FROM Kanalen WHERE ID = $chanelID" );
		//$channelName = preg_replace('/\s+/', '', $chanelDetails->Kanaal);
		//$channelName = str_replace(' ', '%20', $mediumDetails->Uiting_type);


		return $chanelDetails->Kanaal;

	}

	function getMedium($mediumID){
		global $wpdb;
		$mediumDetails = $wpdb->get_row("SELECT * FROM Middelen WHERE ID = $mediumID" );
		//$mediumName = preg_replace('/\s+/', '', $mediumDetails->Uiting_type);
		$mediumName = str_replace(' ', '%20', $mediumDetails->Uiting_type);


		return $mediumName;

	}

	function MiddelName($middelID){
		global $wpdb;
		$middelDetails = $wpdb->get_row("SELECT * FROM Middelen WHERE ID = $middelID" );

		echo $middelDetails->Uiting_type;
	}


	function mooiedatum2($datum){
		$dag = date("d", strtotime($datum));
		$maand = date("m", strtotime($datum));
		$jaar = date("Y", strtotime($datum));

		echo $dag."-".$maand."-".$jaar;
	}

	function mooiedatum23($datum){
		$dag = date("d", strtotime($datum));
		$maand = date("m", strtotime($datum));
		$jaar = date("Y", strtotime($datum));

		$test = $dag."-".$maand."-".$jaar;
		return $test;
	}

	function  aantalDeelnemers($actID){
		global $wpdb;
		$aantalDeelnemers = $wpdb->get_var(
						"
						SELECT COUNT(*) FROM Aanmeldingen WHERE actID = $actID AND Afwezig != 'afwezig' AND hoeftNiet != '1'
						"
					);

					echo $aantalDeelnemers;
	}

	//$id = MAILLIJST ID
	function aantalOntvangers($id){
		global $wpdb;
		$lijstDetails = $wpdb->get_row("SELECT * FROM Maillijst WHERE ID = $id" );

		if( $lijstDetails->Opleiding == 'nvt' && $lijstDetails->Geslacht == "nvt" && $lijstDetails->Workshop == "nvt" && $lijstDetails->Rondleiding == "nvt" && $lijstDetails->Rijbewijs == "nvt"
 			&& $lijstDetails->OnlineVraagstuk == "nvt" && $lijstDetails->Webcareklus == "nvt" && $lijstDetails->Brochureklus == "nvt" && $lijstDetails->Invoerklus == "nvt"
 			&& $lijstDetails->Fotoklus == "nvt" && $lijstDetails->VideoKlus == "nvt" && $lijstDetails->NabelActie == "nvt"
 			){
 	$query .= "";
 	}else{
 		$query .= "WHERE ";
 	}


 	//Opleiding
 	$opleidingen = explode( ',', $lijstDetails->Opleiding );
 	if( $lijstDetails->Opleiding != 'nvt' ){
 		//$query .= "WHERE ";
 		$countOpleiding = count($opleidingen ) -1;
 		$counter1 = "0";
 		$query .= "(";
 		foreach($opleidingen as $opleiding){
 			if($counter1 != $countOpleiding ){
 				$query .= "Opleiding = '".$opleiding."' OR ";
 				}else{
 					$query .= "Opleiding = '".$opleiding."') ";
 				}
 				$counter1++;
 		}
 	}

 	//Geslacht
 	if($lijstDetails->Geslacht != "nvt"){
 		if( $lijstDetails->Opleiding != 'nvt'){
 		$query .= "AND ";
 		}
 		if($lijstDetails->Geslacht == 'mannelijk'){
 			$query .= "Geslacht = 'mannelijk' ";
 		}else{
 			$query .= "Geslacht = 'vrouwelijk' ";
 		}
 	}

 	//Workshop
 	if($lijstDetails->Workshop != "nvt"){
 		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt"){
 		$query .= "AND ";
 		}
 		if($lijstDetails->Workshop == 'Ja'){
 			$query .= "Talentworkshop = 'Ja' ";
 		}else{
 			$query .= "Talentworkshop = 'Nee' ";
 		}
 	}

 	//Rondleiding
 	if($lijstDetails->Rondleiding != "nvt"){
 	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt"){
 		$query .= "AND ";
 		}
 		if($lijstDetails->Rondleiding == 'Ja'){
 			$query .= "Rondleiding = 'Ja' ";
 		}else{
 			$query .= "Rondleiding = 'Nee' ";
 		}
 	}

 	//Rijbewijs
 	if($lijstDetails->Rijbewijs != "nvt"){
 	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt"){
 		$query .= "AND ";
 		}
 		if($lijstDetails->Rijbewijs == 'Ja'){
 			$query .= "Rijbewijs = 'Ja' ";
 		}else{
 			$query .= "Rijbewijs = 'Nee' ";
 		}
 	}

 	//Online vraagstuk
 	if($lijstDetails->OnlineVraagstuk != "nvt"){
 	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt"){
 		$query .= "AND ";
 		}
 		if($lijstDetails->OnlineVraagstuk == 'Ja'){
 			$query .= "OnlineVraagstuk = 'Ja' ";
 		}else{
 			$query .= "OnlineVraagstuk = 'Nee' ";
 		}
 	}

 	//Webcare klus
 	if($lijstDetails->WebcareKlus != "nvt"){
 	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt"){
 		$query .= "AND ";
 		}
 		if($lijstDetails->WebcareKlus == 'Ja'){
 			$query .= "WebcareKlus = 'Ja' ";
 		}else{
 			$query .= "WebcareKlus = 'Nee' ";
 		}
 	}

 	//Brochure klus
 	if($lijstDetails->BrochureKlus != "nvt"){
 	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt"){
 		$query .= "AND ";
 		}
 		if($lijstDetails->BrochureKlus == 'Ja'){
 			$query .= "BrochureKlus = 'Ja' ";
 		}else{
 			$query .= "BrochureKlus = 'Nee' ";
 		}
 	}

 		//Invoer klus
 	if($lijstDetails->InvoerKlus != "nvt"){
 	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt"){
 		$query .= "AND ";
 		}
 		if($lijstDetails->InvoerKlus == 'Ja'){
 			$query .= "InvoerKlus = 'Ja' ";
 		}else{
 			$query .= "InvoerKlus = 'Nee' ";
 		}
 	}

 		//Foto klus
 	if($lijstDetails->FotoKlus != "nvt"){
 	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt"){
 		$query .= "AND ";
 		}
 		if($lijstDetails->FotoKlus == 'Ja'){
 			$query .= "FotoKlus = 'Ja' ";
 		}else{
 			$query .= "FotoKlus = 'Nee' ";
 		}
 	}

 		//Video klus
 	if($lijstDetails->VideoKlus != "nvt"){
 	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt"){
 		$query .= "AND ";
 		}
 		if($lijstDetails->VideoKlus == 'Ja'){
 			$query .= "VideoKlus = 'Ja' ";
 		}else{
 			$query .= "VideoKlus = 'Nee' ";
 		}
 	}

 	//Nabelactie
 	if($lijstDetails->NabelActie != "nvt"){
 	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt" || $lijstDetails->VideoKlus != "nvt"){
 		$query .= "AND ";
 		}
 		if($lijstDetails->NabelActie == 'Ja'){
 			$query .= "NabelActie = 'Ja' ";
 		}else{
 			$query .= "NabelActie = 'Nee' ";
 		}
 	}

		//Aanwezig
		$ActID = $lijstDetails->ActID;
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $ActID" );
		$actDatum = $actDetails>Datum;
		if( $lijstDetails->Opleiding != 'nvt'/* ||  $lijstDetails->Studiejaar != 'nvt' || $lijstDetails->Vooropleiding != "nvt" */|| $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt"){
			$query .= "AND ";
			}else{
				$query .= "WHERE ";
			}
			$query .= "( Afwezig_van < $actDetails->Datum AND Afwezig_tot < $actDetails->Datum ) OR ( Afwezig_van > $actDetails->Datum )";


					$ontvangers = $wpdb->get_results(
						"
						SELECT * FROM Beheertool $query
						"
					);

					//echo count($ontvangers);
					$totalCount = "0";
					 foreach( $ontvangers as $ontvanger ){
					$aangemeld = $wpdb->get_row("SELECT * FROM Aanmeldingen WHERE StudID = $ontvanger->ID AND ActID = $ActID" );
					 if(empty($aangemeld->Datum)){
						$totalCount++;
					 }
		 }
		 echo $totalCount;
	}


	function  afwezigen($actID){
		global $wpdb;
		$aantalDeelnemers = $wpdb->get_var(
						"
						SELECT COUNT(*) FROM Aanmeldingen WHERE actID = $actID AND Afwezig = 'afwezig'
						"
					);


					echo $aantalDeelnemers;
	}


	function  nietWerken($actID){
		global $wpdb;
		$aantalDeelnemers = $wpdb->get_var(
						"
						SELECT COUNT(*) FROM Aanmeldingen WHERE actID = $actID AND hoeftNiet = '1'
						"
					);


					echo $aantalDeelnemers;
	}

	function studentafbeelding($imgUrl){
			$image = wp_get_image_editor( $imgUrl );
			if ( ! is_wp_error( $image ) ) {
				$image->resize( 80, 80, true );
				$image->save( $imgUrl );
			}

	}

	function check_in_range($start_date, $end_date, $date_from_user)
		{
		  // Convert to timestamp
		  $start_ts = strtotime($start_date);
		  $end_ts = strtotime($end_date);
		  $user_ts = strtotime($date_from_user);

		  // Check that user date is between start & end
		  If(($user_ts >= $start_ts) && ($user_ts <= $end_ts)){
			echo "Ja";
		  }else{
			echo "Nee";
		  }
		}


	function studentafbeeldingRename($imgUrl,$bestandNaam){
		$image = wp_get_image_editor( $imgUrl );
		$imgDes = "../drpr/wp-content/fotos/". $bestandNaam;
			if ( ! is_wp_error( $image ) ) {
				//$image->resize( 80, 80, true );
				$image->save( $imgDes );
			}

	}



	function leeftijd($dob) {
	  if(!empty($dob)){
		$birthdate = new DateTime($dob);
		$today   = new DateTime('today');
		$age = $birthdate->diff($today)->y;
		return $age;
		}else{
		return 0;
		}
	}

	function uurTarief($leeftijd){
		global $wpdb;
		$instellingenDetails = $wpdb->get_row("SELECT * FROM Instellingen WHERE ID = '1'" );
		if($leeftijd < '22'){
			return $instellingenDetails->Salaris21;
		}

		if($leeftijd <= '22' && $leeftijd < '23'){
			return $instellingenDetails->Salaris22;
		}

		if($leeftijd >= '23'){
			return $instellingenDetails->Salaris23;
		}
	}


	function studentFoto($StudID){
		global $wpdb;
		$studentDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = $StudID" );
		$foto = $studentDetails->Foto;
		if(!empty($foto)){
			$url = "<img src=\"https://www.expect-webmedia.nl/drpr/wp-content/fotos/".$studentDetails->Foto."\" alt=\"\">";
			echo $url;
		}else{
			$url = "<img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/iconPersonal.png\" alt=\"\">";
			echo $url;
		}
	}

	function verzendMail($ListID,$ActID,$email){
		global $wpdb;
		 $actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $ActID" );
		 $lijstDetails = $wpdb->get_row("SELECT * FROM Maillijst WHERE ID = $ListID" );

		 if( $lijstDetails->Opleiding == 'nvt' && $lijstDetails->Geslacht == "nvt" && $lijstDetails->Workshop == "nvt" && $lijstDetails->Rondleiding == "nvt" && $lijstDetails->Rijbewijs == "nvt"
				&& $lijstDetails->OnlineVraagstuk == "nvt" && $lijstDetails->Webcareklus == "nvt" && $lijstDetails->Brochureklus == "nvt" && $lijstDetails->Invoerklus == "nvt"
				&& $lijstDetails->Fotoklus == "nvt" && $lijstDetails->VideoKlus == "nvt" && $lijstDetails->NabelActie == "nvt"
				){
		$query .= "";
		}else{
			$query .= "WHERE ";
		}


		//Opleiding
		$opleidingen = explode( ',', $lijstDetails->Opleiding );
		if( $lijstDetails->Opleiding != 'nvt' ){
			//$query .= "WHERE ";
			$countOpleiding = count($opleidingen ) -1;
			$counter1 = "0";
			$query .= "(";
			foreach($opleidingen as $opleiding){
				if($counter1 != $countOpleiding ){
					$query .= "Opleiding = '".$opleiding."' OR ";
					}else{
						$query .= "Opleiding = '".$opleiding."') ";
					}
					$counter1++;
			}
		}

		//Geslacht
		if($lijstDetails->Geslacht != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt'){
			$query .= "AND ";
			}
			if($lijstDetails->Geslacht == 'mannelijk'){
				$query .= "Geslacht = 'mannelijk' ";
			}else{
				$query .= "Geslacht = 'vrouwelijk' ";
			}
		}

		//Workshop
		if($lijstDetails->Workshop != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->Workshop == 'Ja'){
				$query .= "Talentworkshop = 'Ja' ";
			}else{
				$query .= "Talentworkshop = 'Nee' ";
			}
		}

		//Rondleiding
		if($lijstDetails->Rondleiding != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->Rondleiding == 'Ja'){
				$query .= "Rondleiding = 'Ja' ";
			}else{
				$query .= "Rondleiding = 'Nee' ";
			}
		}

		//Rijbewijs
		if($lijstDetails->Rijbewijs != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->Rijbewijs == 'Ja'){
				$query .= "Rijbewijs = 'Ja' ";
			}else{
				$query .= "Rijbewijs = 'Nee' ";
			}
		}

		//Online vraagstuk
		if($lijstDetails->OnlineVraagstuk != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->OnlineVraagstuk == 'Ja'){
				$query .= "OnlineVraagstuk = 'Ja' ";
			}else{
				$query .= "OnlineVraagstuk = 'Nee' ";
			}
		}

		//Webcare klus
		if($lijstDetails->WebcareKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->WebcareKlus == 'Ja'){
				$query .= "WebcareKlus = 'Ja' ";
			}else{
				$query .= "WebcareKlus = 'Nee' ";
			}
		}

		//Brochure klus
		if($lijstDetails->BrochureKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->BrochureKlus == 'Ja'){
				$query .= "BrochureKlus = 'Ja' ";
			}else{
				$query .= "BrochureKlus = 'Nee' ";
			}
		}

			//Invoer klus
		if($lijstDetails->InvoerKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->InvoerKlus == 'Ja'){
				$query .= "InvoerKlus = 'Ja' ";
			}else{
				$query .= "InvoerKlus = 'Nee' ";
			}
		}

			//Foto klus
		if($lijstDetails->FotoKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->FotoKlus == 'Ja'){
				$query .= "FotoKlus = 'Ja' ";
			}else{
				$query .= "FotoKlus = 'Nee' ";
			}
		}

			//Video klus
		if($lijstDetails->VideoKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->VideoKlus == 'Ja'){
				$query .= "VideoKlus = 'Ja' ";
			}else{
				$query .= "VideoKlus = 'Nee' ";
			}
		}

		//Nabelactie
		if($lijstDetails->NabelActie != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt" || $lijstDetails->VideoKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->NabelActie == 'Ja'){
				$query .= "NabelActie = 'Ja' ";
			}else{
				$query .= "NabelActie = 'Nee' ";
			}
		}


		//Aanwezig
		$ActID = $lijstDetails->ActID;
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $ActID" );
		$actDatum = $actDetails>Datum;
			if( $lijstDetails->OnlineVraagstuk == 'Ja' && in_array('onlineVraagStuk', $alleenMailen) || $lijstDetails->WebcareKlus == 'Ja' && in_array('webcareKlus', $alleenMailen) ||
			$lijstDetails->BrochureKlus == 'Ja' && in_array('brochureKlus', $alleenMailen) || $lijstDetails->InvoerKlus == 'Ja' && in_array('invoerKlus', $alleenMailen) ||
			$lijstDetails->FotoKlus == 'Ja' && in_array('fotografieKlus', $alleenMailen) || $lijstDetails->VideoKlus == 'Ja' && in_array('videoKlus', $alleenMailen) ||
			$lijstDetails->NabelActie == 'Ja' && in_array('nabelActie', $alleenMailen))
			{

			$query .= "AND ";
			}else{
				$query .= "WHERE ";
			}
			$query .= "( Afwezig_van < $actDetails->Datum AND Afwezig_tot < $actDetails->Datum ) OR ( Afwezig_van > $actDetails->Datum )";

		$ontvangers = $wpdb->get_results(
						"
						SELECT * FROM Beheertool $query
						"
					);

		 //mail
		 $subject = $email.$lijstDetails->Naam;
		 $datemooi =  mooiedatum23($actDetails->Datum);
		 foreach( $ontvangers as $ontvanger ){
			 $aangemeld = $wpdb->get_row("SELECT * FROM Aanmeldingen WHERE StudID = $ontvanger->ID AND ActID = $ActID" );
			 $message = "
			 <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
			 <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
Hallo $ontvanger->Voornaam,
<br /><br />
Je kunt je nu aan- of afmelden voor de volgende activiteit: <b>$actDetails->Titel</b>.
<br /><br />
Wanneer je je wilt aanmelden of afmelden voor deze activiteit dan kun je onderstaande link klikken:<br />
<a href=\"http://www.expect-webmedia.nl/drpr/aanmelden-voor-activiteit/?perskey=$ontvanger->Perskey&actid=$actDetails->ID
\">http://www.expect-webmedia.nl/drpr/aanmelden-voor-activiteit/?perskey=$ontvanger->Perskey&actid=$actDetails->ID</a>
<br /><br />
Let op: Wanneer je je aanmeld voor deze activiteit is het nog niet zeker of je die dag ook moet werken, je ontvangt hierover op een later tijdstip een definitieve e-mail van mij.
<br /><br />
$actDetails->Opmerkingen
</p>
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
				<tr>
					<td valign=\"top\" width=\"100\" >Activiteit</td>
					<td valign=\"top\" width=\"10\">:</td>
					<td valign=\"top\" >$actDetails->Titel</td>
				</tr>
				<tr>
					<td valign=\"top\">Datum</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">$datemooi</td>
				</tr>
				<tr>
					<td valign=\"top\">Tijdstip</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\"> $actDetails->Tijd_van - $actDetails->Tijd_tot uur</td>
				</tr>
				<tr>
					<td valign=\"top\">Locatie</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\"> $actDetails->Locatie</td>
				</tr>
				<tr>
					<td valign=\"top\">Omschrijving</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\" > $actDetails->Omschrijving</td>
				</tr>
			</table><br /><br />
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
				<tr>
					<td valign=\"top\" width=\"100\">Contactpersoon</td>
					<td valign=\"top\" width=\"10\">:</td>
					<td valign=\"top\"> <a href=\"mailto:$actDetails->Contactemail\">$actDetails->Contactpersoon</a></td>
				</tr>
				<tr>
					<td valign=\"top\">Aanmelden tot </td>
					<td valign=\"top\">:</td>
					<td valign=\"top\"> $actDetails->Deadline uur</td>
				</tr>
				<tr>
					<td valign=\"top\">Doelgroep</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\"> $actDetails->Doelgroep</td>
				</tr>
			</table>
			<p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
			<br /><br />
			Wanneer je nog vragen hebt dan hoor ik het natuurlijk graag.
			<br /><br />
			Vriendelijke groet,<br />
			$actDetails->Contactpersoon<br />
			<a href=\"mailto:$actDetails->Contactemail\">$actDetails->Contactemail</a>
			</p>
			<p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">Bekijk en bewerk <a href=\"http://www.expect-webmedia.nl/drpr/gegevens/?perskey=$ontvanger->Perskey\">hier</a> jouw gegevens en aanmeldingen.</p>
			";
			 $headers = array("From: $actDetails->Contactpersoon <$actDetails->Contactemail", "Content-Type: text/html");
			 $h = implode("\r\n",$headers) . "\r\n";
				 if(empty($aangemeld->Datum)){
					wp_mail( $ontvanger->Emailadres, $subject, $message, $h );
				 }


		 }

		//En de database bijwerken
		$sendDate = date('Ymd');
		if(empty($email)){
			$wpdb->update( Maillijst, array( 'Verzonden' => '1', 'SendDate' => $sendDate ),array( 'ID' => $ListID) );
		}else{
			$wpdb->update( Maillijst, array( 'reminderDate' => $sendDate ),array( 'ID' => $ListID) );
			//$wpdb->insert( Reminders, array( 'mailID' => $ListID, 'reminderDate' => $sendDate ) );
		}
		?>
		<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						E-mail is met succes verzonden!
		</div>
		<?php
	}


	function annuleringsmail($actID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $actID" );
		$sendDatas = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE ActID = '".$actID."' AND hoeftNiet = '1'" );
		//mail
		 $subject = "Update: ".$actDetails->Titel;
		 $datemooi =  mooiedatum23($actDetails->Datum);
		 foreach( $sendDatas as $sendData ){
			$studDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = $sendData->StudID" );
			 $message = "
			 <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
			 <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
			Hallo $studDetails->Voornaam,
			<br /><br />
			Je hebt je aangemeld voor &lsquo;<i>$actDetails->Titel</i>&rsquo; op $datemooi. <br />Voor deze activiteit heb ik inmiddels voldoende studenten beschikbaar.<br />
			Dit betekent dat je op $datemooi <u>niet</u> hoeft te werken!<br /><br />			Wanneer je nog vragen hebt dan hoor ik het natuurlijk graag.
			<br /><br />
			Vriendelijke groet,<br />
			$actDetails->Contactpersoon<br />
			<a href=\"mailto:$actDetails->Contactemail\">$actDetails->Contactemail</a>
			</p><p>Bekijk en bewerk <a href=\"http://www.expect-webmedia.nl/drpr/gegevens/?perskey=$studDetails->Perskey\">hier</a> jouw gegevens en aanmeldingen.</p>";
			 $headers = array("From: $actDetails->Contactpersoon <$actDetails->Contactemail", "Content-Type: text/html");
			 $h = implode("\r\n",$headers) . "\r\n";
			$wpdb->update( Activiteiten, array( 'annulering' => '1'),array( 'ID' => $actID) );
			wp_mail( $studDetails->Emailadres, $subject, $message, $h );

		}
			?>
			<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
							Annulerings E-mail is met succes verzonden!
			</div>
			<?php
	}





	function reminderMail($actID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );
		$user_info = get_userdata($actDetails->ingeplandBij);
		$subject = "Reminder: ".$actDetails->Titel;
		$headers = array("From: Contentbeheer <contentbeheer@nhl.nl", "Content-Type: text/html");
		$h = implode("\r\n",$headers) . "\r\n";
		$message = "
			 <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
			 <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
			 Hallo $actDetails->Opdrachtgever,<br /><br />
			 Op de volgende werkdag staat $user_info->display_name voor jou ingepland voor de volgende opdracht: $actDetails->Titel.<br/><br/>
			 Heb je ervoor gezorgd dat $user_info->first_name de juiste input heeft gekregen zodat er direct gestart kan worden met de klus? Mocht je de briefing niet of niet op tijd hebben aangeleverd dan wordt de opdracht uit de planning van contentbeheer gehaald en zal de klus opnieuw door jou moeten worden ingepland. <br /><br />

			Met vriendelijke groet,<br/>
			Contentbeheer
			</p>";


		//echo $actDetails->Contactemail."<br />";
		wp_mail( $actDetails->Contactemail, $subject, $message, $h );

	}


	function bevestigingsmail($actID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $actID" );
		$sendDatas = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE ActID = '".$actID."' AND hoeftNiet != '1' AND Afwezig != 'afwezig' AND Afwezig != 'afwezig2'" );
		//mail
		 $subject = "Update: ".$actDetails->Titel;
		 $datemooi =  mooiedatum23($actDetails->Datum);
		 foreach( $sendDatas as $sendData ){
			$studDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = $sendData->StudID" );
			 $message = "
			 <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
			 <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
			Hallo $studDetails->Voornaam,
			<br /><br />
			Je hebt je aangemeld voor &lsquo;<i>$actDetails->Titel</i>&rsquo; op $datemooi. <br /><br />
			Hierbij bevestigingen we jouw deelname aan deze activiteit.<br /><br />
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
				<tr>
					<td valign=\"top\" width=\"130\" >Activiteit</td>
					<td valign=\"top\" width=\"10\">:</td>
					<td valign=\"top\" >$actDetails->Titel</td>
				</tr>
				<tr>
					<td valign=\"top\">Datum</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">$datemooi</td>
				</tr>
				<tr>
					<td valign=\"top\">Tijdstip</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\"> $actDetails->Tijd_van - $actDetails->Tijd_tot uur</td>
				</tr>
				<tr>
					<td valign=\"top\">Locatie</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\"> $actDetails->Locatie</td>
				</tr>
				<tr>
					<td valign=\"top\">Omschrijving</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\" > $actDetails->Omschrijving</td>
				</tr>
				<tr>
					<td valign=\"top\">Eventuele opmerkingen</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\" > $actDetails->Opmerkingen</td>
				</tr>
			</table>
			<br /><br />
			Vriendelijke groet,<br />
			$actDetails->Contactpersoon<br />
			<a href=\"mailto:$actDetails->Contactemail\">$actDetails->Contactemail</a>
			</p><p>Bekijk en bewerk <a href=\"http://www.expect-webmedia.nl/drpr/gegevens/?perskey=$studDetails->Perskey\">hier</a> jouw gegevens en aanmeldingen.</p>";
			 $headers = array("From: $actDetails->Contactpersoon <$actDetails->Contactemail", "Content-Type: text/html");
			 $h = implode("\r\n",$headers) . "\r\n";

			//Update van pending naar definitief
			$wpdb->update( Aanmeldingen, array( 'Werkt' => '1'),array( 'ID' => $actID) );

			//Update activiteit, bevestiging is verstuurd
			$wpdb->update( Activiteiten, array( 'bevestiging' => '1'),array( 'ID' => $actID) );
			wp_mail( $studDetails->Emailadres, $subject, $message, $h );

			//Update van pending naar definitief
			$aanmeldingID = $sendData->ID;
			$wpdb->update( Aanmeldingen, array( 'Werkt' => '1'),array( 'ID' => $aanmeldingID) );

		}
			?>
			<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
							Bevestigings E-mail is met succes verzonden!
			</div>
			<?php
	}


	function bevestigingsmailEnkel($actID,$studID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $actID" );
		$sendData = $wpdb->get_row( "SELECT * FROM Aanmeldingen WHERE ActID = '".$actID."' AND StudID = '".$studID."' AND hoeftNiet != '1' AND Afwezig != 'afwezig' AND Afwezig != 'afwezig2'" );
		//mail
		 $subject = "Update: ".$actDetails->Titel;
		 $datemooi =  mooiedatum23($actDetails->Datum);
		 $studDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = $sendData->StudID" );

			 $message = "
			 <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
			 <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
			Hallo $studDetails->Voornaam,
			<br /><br />
			Je hebt je aangemeld voor &lsquo;<i>$actDetails->Titel</i>&rsquo; op $datemooi. <br /><br />
			Hierbij bevestigingen we jouw deelname aan deze activiteit.<br /><br />
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
				<tr>
					<td valign=\"top\" width=\"130\" >Activiteit</td>
					<td valign=\"top\" width=\"10\">:</td>
					<td valign=\"top\" >$actDetails->Titel</td>
				</tr>
				<tr>
					<td valign=\"top\">Datum</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">$datemooi</td>
				</tr>
				<tr>
					<td valign=\"top\">Tijdstip</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\"> $actDetails->Tijd_van - $actDetails->Tijd_tot uur</td>
				</tr>
				<tr>
					<td valign=\"top\">Locatie</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\"> $actDetails->Locatie</td>
				</tr>
				<tr>
					<td valign=\"top\">Omschrijving</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\" > $actDetails->Omschrijving</td>
				</tr>
				<tr>
					<td valign=\"top\">Eventuele opmerkingen</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\" > $actDetails->Opmerkingen</td>
				</tr>
			</table>
			<br /><br />
			Vriendelijke groet,<br />
			$actDetails->Contactpersoon<br />
			<a href=\"mailto:$actDetails->Contactemail\">$actDetails->Contactemail</a>
			</p><p>Bekijk en bewerk <a href=\"http://www.expect-webmedia.nl/drpr/gegevens/?perskey=$studDetails->Perskey\">hier</a> jouw gegevens en aanmeldingen.</p>";
			 $headers = array("From: $actDetails->Contactpersoon <$actDetails->Contactemail", "Content-Type: text/html");
			 $h = implode("\r\n",$headers) . "\r\n";

			//Update van pending naar definitief
			$wpdb->update( Aanmeldingen, array( 'Werkt' => '1'),array( 'ID' => $actID) );

			//Update activiteit, bevestiging is verstuurd
			$wpdb->update( Activiteiten, array( 'bevestiging' => '1'),array( 'ID' => $actID) );
			wp_mail( $studDetails->Emailadres, $subject, $message, $h );

			//Update van pending naar definitief
			$aanmeldingID = $sendData->ID;
			$wpdb->update( Aanmeldingen, array( 'Werkt' => '1'),array( 'ID' => $aanmeldingID) );

			?>
			<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
							Bevestigings E-mail is met succes verzonden!
			</div>
			<?php
	}


	function opdrachtIngepland($actID,$contactID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );

		//mail
		 $subject = "Ingepland: ".$actDetails->Titel;
		 $datemooi =  mooiedatum23($actDetails->Startdatum);
		 if(!empty($actDetails->Einddatum)){
		 $datemooi2 =  mooiedatum23($actDetails->Einddatum);
		 }
		 if(!empty($actDetails->Verzenddatum)){
		 $datemooi3 =  mooiedatum23($actDetails->Verzenddatum);
	 	}
		 $user_info = get_userdata($contactID);
		 $contentDetail2 = get_userdata($actDetails->ingeplandBij);

		 	 $message=array();
			 $message[] = "
			 <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
			 <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
			Hallo $user_info->first_name,
			<br /><br />
			Hierbij bevestigingen we dat we $contentDetail2->display_name op $datemooi ingepland hebben voor <i>$actDetails->Titel</i>.<br /><br />
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
				<tr>
					<td valign=\"top\" width=\"130\" >Opdracht</td>
					<td valign=\"top\" width=\"10\">:</td>
					<td valign=\"top\" >$actDetails->Titel</td>
				</tr>
				<tr>
					<td valign=\"top\">Datum</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">$datemooi</td>
				</tr>";

				 if(!empty($datemooi2)){
					 $message[] = "
				<tr>
					<td valign=\"top\">Correcties</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">$datemooi2</td>
				</tr>
			";}

			 if(!empty($datemooi3)){
				 $message[] = "
			<tr>
				<td valign=\"top\">Verzenden</td>
				<td valign=\"top\">:</td>
				<td valign=\"top\">$datemooi3</td>
			</tr>
		";}

			if(!empty($actDetails->Terugkeerpatroon)){

				$message[] = "
		 		<tr>
		 			<td valign=\"top\">Terugkeerpatroon</td>
		 			<td valign=\"top\">:</td>
		 			<td valign=\"top\">$actDetails->Terugkeerpatroon</td>
		 		</tr>
		 	";
		}

			 $message[] = "
				<tr>
					<td valign=\"top\">Briefing</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">Klik <a href=\"https://www.expect-webmedia.nl/drpr/briefing-detail/?id=$actDetails->ID\">hier</a> om naar de briefing te gaan.</td>
				</tr>
			</table>
			<br /><br />
			";
			 $headers = array("From: Contentbeheer <contentbeheer@nhl.nl", "Content-Type: text/html");
			 $h = implode("\r\n",$headers) . "\r\n";
			 $message = implode("\r\n", $message);

			 wp_mail( $user_info->user_email, $subject, $message, $h );

			?>
			<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
							Bevestigings E-mail is met succes verzonden!
			</div>
			<?php
	}

	function opdrachtGeannuleerd($actID,$contactID){
		global $wpdb;
 	 $actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );

 	 //mail
 		$subject = "Geannuleerd: ".$actDetails->Titel;
		$datemooi =  mooiedatum23($actDetails->Startdatum);
		if(!empty($actDetails->Einddatum)){
		$datemooi2 =  mooiedatum23($actDetails->Einddatum);
		}
		if(!empty($actDetails->Verzenddatum)){
		$datemooi3 =  mooiedatum23($actDetails->Verzenddatum);
	 }
 		$user_info = get_userdata($contactID);
 		$contentDetail2 = get_userdata($actDetails->ingeplandBij);


			$message=array();
			$message[] = "
 			<img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
 			<p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
 		 Hallo $user_info->first_name,
 		 <br /><br />
 	 		De opdracht:<i>$actDetails->Titel</i> is geannuleerd. Graag de opdracht opnieuw inplannen of verwijderen uit het systeem.<br /><br />
 		 <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
 			 <tr>
 				 <td valign=\"top\" width=\"130\" >Opdracht</td>
 				 <td valign=\"top\" width=\"10\">:</td>
 				 <td valign=\"top\" >$actDetails->Titel</td>
 			 </tr>
			 <tr>
 				<td valign=\"top\">Datum</td>
 				<td valign=\"top\">:</td>
 				<td valign=\"top\">$datemooi</td>
 			</tr>";

 			 if(!empty($datemooi2)){
 				 $message[] = "
 			<tr>
 				<td valign=\"top\">Correcties</td>
 				<td valign=\"top\">:</td>
 				<td valign=\"top\">$datemooi2</td>
 			</tr>
 		";}

 		 if(!empty($datemooi3)){
 			 $message[] = "
 		<tr>
 			<td valign=\"top\">Verzenden</td>
 			<td valign=\"top\">:</td>
 			<td valign=\"top\">$datemooi3</td>
 		</tr>
 	";}

 		 $message[] = "
 			 <tr>
 				 <td valign=\"top\">Briefing</td>
 				 <td valign=\"top\">:</td>
 				 <td valign=\"top\">Klik <a href=\"https://www.expect-webmedia.nl/drpr/briefing-detail/?id=$actDetails->ID\">hier</a> om naar de briefing te gaan.</td>
 			 </tr>
 		 </table>
 		 <br /><br />
 		 ";
 			$headers = array("From: Contentbeheer <contentbeheer@nhl.nl", "Content-Type: text/html");
 			$h = implode("\r\n",$headers) . "\r\n";
			$message = implode("\r\n", $message);

 			wp_mail( $user_info->user_email, $subject, $message, $h );
 		 ?>

 		 <?php
	}

	function opdrachtGeannuleerdOffice($actID,$contactID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );

		//mail
		 $subject = "Opdracht geannuleerd: ".$actDetails->Titel;
			 $datemooi =  mooiedatum23($actDetails->Startdatum);
	 		if(!empty($actDetails->Einddatum)){
	 		$datemooi2 =  mooiedatum23($actDetails->Einddatum);
	 		}
	 		if(!empty($actDetails->Verzenddatum)){
	 		$datemooi3 =  mooiedatum23($actDetails->Verzenddatum);
	 	 }
		 $user_info = get_userdata($contactID);

		 	$message=array();
			$message[] = "
			 <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
			 <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
			Hoi!
			<br /><br />
			De volgende klus: <i>$actDetails->Titel</i> op $datemooi is geannuleerd en wordt uit de agenda verwijderd door de contentbeheerder.<br /><br />
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
				<tr>
					<td valign=\"top\" width=\"130\" >Opdracht</td>
					<td valign=\"top\" width=\"10\">:</td>
					<td valign=\"top\" >$actDetails->Titel</td>
				</tr>
				<tr>
  				<td valign=\"top\">Datum</td>
  				<td valign=\"top\">:</td>
  				<td valign=\"top\">$datemooi</td>
  			</tr>";

  			 if(!empty($datemooi2)){
  				 $message[] = "
  			<tr>
  				<td valign=\"top\">Correcties</td>
  				<td valign=\"top\">:</td>
  				<td valign=\"top\">$datemooi2</td>
  			</tr>
  		";}

  		 if(!empty($datemooi3)){
  			 $message[] = "
  		<tr>
  			<td valign=\"top\">Verzenden</td>
  			<td valign=\"top\">:</td>
  			<td valign=\"top\">$datemooi3</td>
  		</tr>
  	";}

  		 $message[] = "
				<tr>
					<td valign=\"top\">Briefing</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">Klik <a href=\"https://www.expect-webmedia.nl/drpr/briefing-detail/?id=$actDetails->ID\">hier</a> om naar de briefing te gaan.</td>
				</tr>
				<tr>
					<td valign=\"top\">Opdrachtgever</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">$user_info->display_name</td>
				</tr>
			</table>
			<br /><br />
			";
			 $headers = array("From: $user_info->display_name <$user_info->user_email>", "Content-Type: text/html");
			 $h = implode("\r\n",$headers) . "\r\n";
			 $message = implode("\r\n", $message);

			 $to = "contentbeheer@nhl.nl";

			 wp_mail( $to, $subject, $message, $h );

			?>
			<?php
	}


	function opdrachtGeannuleerdContentbeheerder($actID,$contactID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );

		//mail
		$subject = "Opdracht verwijderen: ".$actDetails->Titel;
		$datemooi =  mooiedatum23($actDetails->Startdatum);
		if(!empty($actDetails->Einddatum)){
		$datemooi2 =  mooiedatum23($actDetails->Einddatum);
		}
		if(!empty($actDetails->Verzenddatum)){
		$datemooi3 =  mooiedatum23($actDetails->Verzenddatum);
	 	}
		 $user_info = get_userdata($contactID);
		 $contentDetail2 = get_userdata($actDetails->ingeplandBij);



			 $message=array();
			 $message[] = "
			 <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
			 <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
			Hoi $contentDetail2->first_name!
			<br /><br />
			De volgende klus: <i>$actDetails->Titel</i> op $datemooi die je zojuist hebt geannuleerd uit de agenda verwijderen.<br /><br />

			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
				<tr>
					<td valign=\"top\" width=\"130\" >Opdracht</td>
					<td valign=\"top\" width=\"10\">:</td>
					<td valign=\"top\" >$actDetails->Titel</td>
				</tr>
				<tr>
  				<td valign=\"top\">Datum</td>
  				<td valign=\"top\">:</td>
  				<td valign=\"top\">$datemooi</td>
  			</tr>";

  			 if(!empty($datemooi2)){
  				 $message[] = "
  			<tr>
  				<td valign=\"top\">Correcties</td>
  				<td valign=\"top\">:</td>
  				<td valign=\"top\">$datemooi2</td>
  			</tr>
  		";}

  		 if(!empty($datemooi3)){
  			 $message[] = "
  		<tr>
  			<td valign=\"top\">Verzenden</td>
  			<td valign=\"top\">:</td>
  			<td valign=\"top\">$datemooi3</td>
  		</tr>
  	";}

  		 $message[] = "
				<tr>
					<td valign=\"top\">Briefing</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">Klik <a href=\"https://www.expect-webmedia.nl/drpr/briefing-detail/?id=$actDetails->ID\">hier</a> om naar de briefing te gaan.</td>
				</tr>
				<tr>
					<td valign=\"top\">Opdrachtgever</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">$user_info->first_name</td>
				</tr>
			</table>
			<br /><br />
			";
			$headers = array("From: Briefing systeem <no-reply@nhl.nl>", "Content-Type: text/html");
			$h = implode("\r\n",$headers) . "\r\n";
			$message = implode("\r\n", $message);

			$wpdb->update( Briefing, array( 'ingepland' => '',/* 'ingeplandTijd' => '', 'correctieTijd' => '', */'ingeplandBij' => '','planningVerzonden' => ''),array( 'ID' => $_GET['id']) );



			 wp_mail( $contentDetail2->user_email, $subject, $message, $h );

			?>
			<?php
	}


	function verzoekTotInplannen($actID,$contactID){
		global $wpdb;
		$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );

		//mail
		 $subject = "Inplannen bij Contentbeheer: ".$actDetails->Titel;
		 $datemooi =  mooiedatum23($actDetails->Startdatum);
 		if(!empty($actDetails->Einddatum)){
 		$datemooi2 =  mooiedatum23($actDetails->Einddatum);
 		}
 		if(!empty($actDetails->Verzenddatum)){
 		$datemooi3 =  mooiedatum23($actDetails->Verzenddatum);
 	 	}
		 $user_info = get_userdata($contactID);


		 	$message=array();
			$message[] = "
			 <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
			 <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
			Hoi!
			<br /><br />
			Graag wil ik de volgende klus op $datemooi inplannen bij Contentbeheer: <i>$actDetails->Titel</i>.<br /><br />
			<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
				<tr>
					<td valign=\"top\" width=\"130\" >Opdracht</td>
					<td valign=\"top\" width=\"10\">:</td>
					<td valign=\"top\" >$actDetails->Titel</td>
				</tr>
				<tr>
  				<td valign=\"top\">Gewenste datum</td>
  				<td valign=\"top\">:</td>
  				<td valign=\"top\">$datemooi</td>
  			</tr>";

  			 if(!empty($datemooi2)){
  				 $message[] = "
  			<tr>
  				<td valign=\"top\">Gewenste datum correcties</td>
  				<td valign=\"top\">:</td>
  				<td valign=\"top\">$datemooi2</td>
  			</tr>
  		";}

  		 if(!empty($datemooi3)){
  			 $message[] = "
  		<tr>
  			<td valign=\"top\">Gewenste datum verzenden</td>
  			<td valign=\"top\">:</td>
  			<td valign=\"top\">$datemooi3</td>
  		</tr>
  	";}

  		 $message[] = "
				<tr>
					<td valign=\"top\">Briefing</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">Klik <a href=\"https://www.expect-webmedia.nl/drpr/briefing-detail/?id=$actDetails->ID\">hier</a> om naar de briefing te gaan.</td>
				</tr>
				<tr>
					<td valign=\"top\">Opdrachtgever</td>
					<td valign=\"top\">:</td>
					<td valign=\"top\">$user_info->display_name</td>
				</tr>
			</table>
			<br /><br />
			";
			 $headers = array("From: $user_info->display_name <$user_info->user_email>", "Content-Type: text/html");
			 $h = implode("\r\n",$headers) . "\r\n";
			 $message = implode("\r\n", $message);

			 $to = "contentbeheer@nhl.nl";

			 wp_mail( $to, $subject, $message, $h );

			?>
			<?php
	}


	function contract($userID){
		global $wpdb;
		$studentDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = $userID" );
		$instellingen = $wpdb->get_row("SELECT * FROM Instellingen WHERE ID = '1'" );
		?>
			<!-- begin document -->
		<div class="a4">
			<img src="<?php bloginfo('template_url');?>/images/logo.gif" alt="" /><br /><br />
			<table cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td width="500" valign="top">OVEREENKOMST UURLONER<br /><span><B>&euro; 500,- of meer</B></span></td>
					<td  valign="top"><font style="font-size: 12px;">Declareert u dit kalenderjaar in totaal minder dan <br />&euro; 500,00 vul dan het formulier voor kort-tijdelijk dienstverband minder dan &euro; 500,00 in.</font></td>
				</tr>
			</table>
			<table cellspacing="10" cellpadding="0" border="0" style="border: 2px solid #393939; width: 800px; margin-top: 20px; font-size: 13px;">
				<tr>
					<td  valign="top" colspan="2"><B>De actviteiten zullen worden uitgevoerd door:</B></td>
				</tr>
				<tr>
					<td width="200" valign="top">Voornaam en Achternaam</td>
					<td valign="top"><?php echo $studentDetails->Voornaam." ".$studentDetails->Tussenvoegsel." ".$studentDetails->Achternaam; ?></td>
				</tr>

				<tr>
					<td width="200" valign="top">Adres</td>
					<td valign="top"><?php echo $studentDetails->Adres." ".$studentDetails->Huisnummer; ?></td>
				</tr>
				<tr>
					<td width="200" valign="top">Postcode en Woonplaats</td>
					<td valign="top"><?php echo $studentDetails->Postcode." ".$studentDetails->Woonplaats; ?></td>
				</tr>
				<tr>
					<td valign="top">Geboortedatum</td>
					<td valign="top"><?php echo $studentDetails->Geboortedatum; ?></td>
				</tr>
				<tr>
					<td valign="top">Telefoonnummer</td>
					<td valign="top"><?php echo $studentDetails->Telefoonnummer; ?></td>
				</tr>
				<tr>
					<td valign="top">Mobiel nummer</td>
					<td valign="top"><?php echo $studentDetails->Mobiel; ?></td>
				</tr>
				<tr>
					<td valign="top">E-mailadres</td>
					<td valign="top"><?php echo $studentDetails->Emailadres; ?></td>
				</tr>
				<tr>
					<td valign="top">Burgelijke staat</td>
					<td valign="top"><?php echo $studentDetails->BurgerlijkeStaat; ?></td>
				</tr>
				<tr>
					<td valign="top">IBAN rekeningnummer</td>
					<td valign="top"><?php echo $studentDetails->IBAN; ?></td>
				</tr>
				<tr>
					<td valign="top">Studentnr. / Opleiding</td>
					<td valign="top"><?php echo $studentDetails->Studentnr; ?> <?php echo $studentDetails->Opleiding; ?></td>
				</tr>
				<tr>
					<td valign="top">Rijbewijs</td>
					<td valign="top"><?php echo $studentDetails->Rijbewijs; ?></td>
				</tr>
				<tr>
					<td valign="top">Maat Shirt</td>
					<td valign="top"><?php echo $studentDetails->Maat; ?></td>
				</tr>
				<tr>
					<td valign="top">Overeenkomst</td>
					<td valign="top"><?php echo $studentDetails->Type_overeenkomst; ?></td>
				</tr>
				<tr>
					<td valign="top">Organisatieonderdeel</td>
					<td valign="top">SCKO, Marketing &amp; Communicatie Services</td>
				</tr>
				<tr>
					<td valign="top">Bruto Uurloon</td>
					<td valign="top">&euro; <?php echo uurTarief(leeftijd($studentDetails->Geboortedatum)); ?></td>
				</tr>
				<tr>
					<td valign="top">Ingangsdatum activiteiten</td>
					<td valign="top"><?php  mooiedatum3($studentDetails->Contract_van) ?></td>
				</tr>
				<tr>
					<td valign="top">Uiterlijke einddatum</td>
					<td valign="top"><?php  mooiedatum3($studentDetails->Contract_tot) ?></td>
				</tr>
				<tr>
					<td valign="top">Totaal aantal uren</td>
					<td valign="top">..............................</td>
				</tr>
				<tr>
					<td valign="top">Loonheffingskorting</td>
					<td valign="top"><?php echo $studentDetails->Loonheffing; ?></td>
				</tr>
				<tr>
					<td valign="top">Bijzondere afspraken/activiteiten</td>
						<td valign="top">..........................................................................</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">De ondergetekenden komen overeen dat voor het verrichten van de boven omschreven activiteiten op declaratiebasis zal worden uitbetaald.</td>
				</tr>

				<tr>
					<td valign="top" colspan="2">
						<table cellspacing="0" cellpadding="0"  style="border: 0px; width: 750px; font-size: 13px;">
						<tr>
							<td width="375" valign="top">Uitvoerder van de activiteiten</td>
							<td valign="top">Afdelingshoofd</td>
						</tr>
						<tr>
							<td valign="top"><?php echo $studentDetails->Voornaam." ".$studentDetails->Tussenvoegsel." ".$studentDetails->Achternaam; ?></td>
							<td valign="top"><br />Paraaf: ..............<br /><br />
							</td>
						</tr>
						<tr>
							<td valign="top"><I>(handtekening)</I></td>
							<td valign="top">Naam: </td>
						</tr>
						<tr>
							<td valign="top"><br /><br /><I>Datum ...............-..............-..............</I></td>
							<td valign="top"><br /><br /><I>Datum ...............-..............-..............</I></td>
						</tr>
						</table>
					</td>
				</tr>
			</table>
			<h1 style="font-size: 14px; text-transform: uppercase;">SAMEN MET KOPIE VAN EEN GELDIG ID-BEWIJS (BEIDE ZIJDEN GEKOPIEERD) OF  PASPOORT (OPGEVOUWEN OP BLADZIJDE MET DE PASFOTO) AANLEVEREN BIJ HR-SERVICES.</h1>
		</div>
		<!-- einde document -->



	<?php

	}


	function werkbriefke($userID, $actID){
		global $wpdb;
		$studentDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = $userID" );
		$activiteitDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $actID" );
		$instellingen = $wpdb->get_row("SELECT * FROM Instellingen WHERE ID = '1'" );
		?>
			<!-- begin document -->
			<div class="a4">

				<img src="<?php bloginfo('template_url');?>/images/logo.gif" alt="" /><br /><br />

				<table cellspacing="0" cellpadding="0" border="0">

					<tr>
					<td>

					</td>
					<td valign="top">
					<font style="font-size: 12px;">
						Opdrachtnummer: <?php echo $studentDetails->Opdrachtnummer." " ?>
						</font>
					</td></tr>
					<tr><td>
						&nbsp;
					</td></tr>

					<tr>

						<td width="400" valign="top">Declaratieformulier WERKstudent</td>



						<td  valign="top"><font style="font-size: 12px;">INLEVEREN BIJ HR SERVICES UITERLIJK DE 7E VAN ELKE MAAND.</font></td>

					</tr>

				</table>

				<table cellspacing="10" cellpadding="0" border="0" style="border: 0px solid #393939; width: 800px; margin-top: 20px; font-size: 13px;">



					<tr>

						<td width="200" valign="top">Voornaam en Achternaam</td>

						<td valign="top"><?php echo $studentDetails->Voornaam." ".$studentDetails->Tussenvoegsel." ".$studentDetails->Achternaam; ?></td>

					</tr>

					<tr>

						<td valign="top">Adres</td>

						<td valign="top"><?php echo $studentDetails->Adres." " ?></td>

					</tr>

					<tr>

						<td valign="top">Huisnummer</td>

						<td valign="top"><?php echo $studentDetails->Huisnummer." " ?></td>

					</tr>

					<tr>

						<td valign="top">Postcode</td>

						<td valign="top"><?php echo $studentDetails->Postcode." " ?></td>

					</tr>

					<tr>

						<td valign="top">Woonplaats</td>

						<td valign="top"><?php echo $studentDetails->Woonplaats." " ?></td>

					</tr>

					<tr>

						<td valign="top">E-mailadres</td>

						<td valign="top"><?php echo $studentDetails->Emailadres." " ?></td>

					</tr>

					<tr>

						<td valign="top">Telefoonnummer</td>

						<td valign="top"><?php echo $studentDetails->Telefoonnummer." " ?></td>

					</tr>

					<tr>

						<td valign="top">Geboortedatum</td>

						<td valign="top"><?php echo $studentDetails->Geboortedatum; ?></td>

					</tr>

					<tr>

						<td valign="top">Burgerservicenummer (BSN)</td>

						<td valign="top"><?php echo $studentDetails->BSN." " ?></td>

					</tr>

	                <tr>

						<td valign="top">Burgerlijke staat</td>

						<td valign="top"><?php echo $studentDetails->BurgerlijkeStaat." " ?></td>

					</tr>

					<tr>

						<td valign="top">IBAN</td>

						<td valign="top"><?php echo $studentDetails->IBAN." " ?></td>

					</tr>

					<tr>

						<td valign="top">Afdeling</td>

						<td valign="top">Marketing &amp; Communicatie Services</td>

					</tr>

					<tr>

						<td valign="top">Kostendrager</td>

						<td valign="top"><?php echo $instellingen->Projectnummer; ?></td>

					</tr>

					<tr>

						<td valign="top">Opdrachtomschrijving</td>

						<td valign="top"><?php echo $activiteitDetails->Titel; ?></td>

					</tr>

					<tr>

						<td valign="top">Datum opdracht</td>

						<td valign="top"><?php if(!empty($activiteitDetails->Datum)){

										mooiedatum($activiteitDetails->Datum);

										}else {

										echo ".....................................";

										}



										?></td>

					</tr>



					<tr>

						<td  valign="top" colspan="2"><p><strong>TE BETALEN</strong></p></td>

					</tr>



					<tr>

						<td valign="top">Honorarium per uur</td>

						<td valign="top">€ 11,-</td>

					</tr>



					<tr>

						<td valign="top">Aantal uren totaal voor deze opdracht</td>

						<td valign="top">.......... x € 11,- = € ...............................</td>

					</tr>



					<tr>

						<td valign="top">Onkosten</td>

					</tr>

					<tr>

						<td valign="top">Kosten openbaar vervoer</td>

						<td valign="top">&euro;...........................</td>

					</tr>

					<tr>

						<td valign="top">Eigen vervoer</td>

						<td valign="top">................... km &agrave; &euro; 0.19 totaal &euro; .................... </td>

					</tr>

					<tr>

						<td valign="top">Overig te vergoeden onkosten</td>

						<td valign="top">&euro;...........................</td>

					</tr>

					<tr>

						<td valign="top">Omschrijving onkosten </td>

						<td valign="top">.........................................................................................................................................................</td>

					</tr>

					<tr>

						<td valign="top" colspan="2"><i>(vergoeding op basis van bijgevoegde originele bewijsstukken) </i></td>

					</tr>



					<tr>

						<td valign="top" colspan="2"><p>De hogeschool is ingevolge de zogenaamde “IB47” bepaling in de wet op de inkomstenbelasting verplicht opgave te doen van deze declaratie aan de belastinginspectie. IB47 is een opgave die een werkgever eenmaal per jaar aan de Belastingdienst moet doen voor betalingen aan mensen die niet bij hem in gewone/fictieve dienstbetrekking zijn maar die ook geen ondernemers zijn.</p></td>

					</tr>

					<tr>

						<td valign="top" colspan="2">

							<table cellspacing="0" cellpadding="0"  style="border: 0px; width: 750px; font-size: 13px;">

							<tr>

								<td width="375" valign="top"><strong>Uitvoerder van de activiteiten</strong></td>

								<td valign="top"><strong>Teamleider/Clusterhoofd Marketing & Comm. Serv.</strong></td>

							</tr>

							<tr>

								<td valign="top"><br />Datum: ...............-..............-..............  </td>

								<td valign="top"><br />Naam: Renske Wassenaar / Lucienne Krijthe<br /><br />	</td>

							</tr>

							<tr>

								<td valign="top">Handtekening:</td>

								<td valign="top">Datum: ...............-..............-..............</td>

							</tr>

							<tr>

								<td valign="top"></td>

								<td valign="top"><br />Handtekening:<br /><br /></td>

							</tr>



							</table>

						</td>

					</tr>

				</table>

			</div>

			<!-- einde document -->




	<?php

	}


	function geslacht2($geslacht){
		if($geslacht == 'nvt'){
			echo "Mannelijk en Vrouwelijk";
		}

		if($geslacht == 'mannelijk'){
			echo "Mannelijk";
		}


		if($geslacht == 'vrouwelijk'){
			echo "Vrouwelijk";
		}

	}


function MailBriefingReeks($mailID){

	//mail
	 global $wpdb;
	 $lijstDetails = $wpdb->get_row("SELECT * FROM BriefingMaillijst WHERE ID = $mailID" );
	 	$subject = "Opdracht(en) om in te plannen";
	 $ActID = $lijstDetails->ActID;
	 $user_info = get_userdata( $lijstDetails->UserID);
	 $tekst = $lijstDetails->comment;
	 $tekst2 = nl2br($tekst);

	 $message .="<div style=\"margin: 50px; width: 600px;\">";
	 $message .=" <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">";
	 $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
	 $message .=" Hallo Contentbeheer,";
	 $message .=" <br /><br />";
	 $message .=" Willen jullie onderstaande opdachten(en) inplannen?";;
	 $message .=" </p>";
	 if(!empty($lijstDetails->comment)){
	 $message .= "<p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\"><b>Opmerkingen</b><br /><br />".$tekst2."</p>";
	 }
	 $activiteiten = explode(",", $ActID);
	 $count = "1";
	 foreach($activiteiten as $activiteit){
	 $actData = $wpdb->get_row( "SELECT * FROM Briefing WHERE ID = '".$activiteit."'" );
	 $message .=" <table border=\"0\" cellpadding=\"5\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px; width: 600px;\">";
	 $message .=" <tr style=\"background-color: #f37021; color: #ffffff;\">";
	 $message .=" <td valign=\"top\" width=\"100\" ><b>Briefing $count</b></td>";
	 $message .=" <td valign=\"top\" width=\"10\"><b>:</b></td>";
	 $message .=" <td valign=\"top\" ><b>$actData->Titel</b></td>";
	 $message .=" </tr>";
	 $message .=" <tr>";
	 $datumStart = get_mooiedatum($actData->Startdatum);
	 $message .=" <td valign=\"top\">Gewenste datum</td>";
	 $message .=" <td valign=\"top\">:</td>";
	 $message .=" <td valign=\"top\">$datumStart</td>";
	 $message .=" </tr>";
  if(!empty($actData->Einddatum)){
	$message .=" <tr>";
  $datumCor = get_mooiedatum($actData->Einddatum);
	$message .=" <td valign=\"top\">Gewenste datum correcties</td>";
	$message .=" <td valign=\"top\">:</td>";
	$message .=" <td valign=\"top\">$datumCor</td>";
	$message .=" </tr>";
	}
	if(!empty($actData->Verzenddatum)){
	$message .=" <tr>";
	$datumSend = get_mooiedatum($actData->Verzenddatum);
	$message .=" <td valign=\"top\">Gewenste datum verzenden</td>";
	$message .=" <td valign=\"top\">:</td>";
	$message .=" <td valign=\"top\">$datumSend</td>";
	$message .=" </tr>";
	}

	 $message .=" <tr>";
	 $message .=" <td valign=\"top\">Locatie M: schijf</td>";
	 $message .=" <td valign=\"top\">:</td>";
	 $message .=" <td valign=\"top\"> $actData->Locatie</td>";
	 $message .=" </tr>";
	 $message .=" <tr>";
	 $message .=" <td valign=\"top\">Briefing</td>";
	 $message .=" <td valign=\"top\">:</td>";
	 $message .=" <td valign=\"top\" >Je kunt <a href=\"https://www.expect-webmedia.nl/drpr/briefing-detail/?id=$activiteit\">hier</a> de briefing bekijken</td>";
	 $message .=" </tr>";
	 $message .=" <tr>";
	 $message .=" <td valign=\"top\">Omschrijving</td>";
	 $message .=" <td valign=\"top\">:</td>";
	 $message .=" <td valign=\"top\"> $actData->Omschrijving</td>";
	 $message .=" </tr>";
	 $message .=" </table><br /><br />";
	 $count++;

	 $wpdb->update( Briefing, array( 'planningVerzonden' => '1' ),array( 'ID' =>  $activiteit) );

 }


	 $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
	 $message .=" Mochten er nog vragen zijn over deze opdracht(en) dan hoor ik het graag.";
	 $message .=" <br /><br />";
	 $message .=" Vriendelijke groet,<br />";
	 $message .=" $user_info->display_name<br />";
	 $message .=" <a href=\"mailto:$actDetails->Contactemail\">$actDetails->Contactemail</a>";
	 $message .=" </p>";
	 $message .=" </div>";


		 $headers = array("From: $user_info->display_name <$user_info->user_email>", "Content-Type: text/html");
		 $h = implode("\r\n",$headers) . "\r\n";
						$to = "contentbeheer@nhl";

		 wp_mail( $to, $subject, $message, $h );
		 $vandaag = date('Ymd');

		 $wpdb->update( BriefingMaillijst, array( 'Verzonden' => '1', 'SendDate' => $vandaag ),array( 'ID' => $mailID) );



		?>
		<?php


}






	function verzendMailNieuw($ListID,$ActID,$email){
		global $wpdb;
		 $actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $ActID" );
		 $lijstDetails = $wpdb->get_row("SELECT * FROM Maillijst WHERE ID = $ListID" );
		 $testing = $wpdb->get_results("SELECT ActID FROM Maillijst WHERE ID = $ListID" );
		 $user_info = get_userdata( $lijstDetails->UserID);
		 if( $lijstDetails->Opleiding == 'nvt' && $lijstDetails->Geslacht == "nvt" && $lijstDetails->Workshop == "nvt" && $lijstDetails->Rondleiding == "nvt" && $lijstDetails->Rijbewijs == "nvt"
				&& $lijstDetails->OnlineVraagstuk == "nvt" && $lijstDetails->Webcareklus == "nvt" && $lijstDetails->Brochureklus == "nvt" && $lijstDetails->Invoerklus == "nvt"
				&& $lijstDetails->Fotoklus == "nvt" && $lijstDetails->VideoKlus == "nvt" && $lijstDetails->NabelActie == "nvt"
				){
		$query .= "";
		}else{
			$query .= "WHERE ";
		}


		//Opleiding
		$opleidingen = explode( ',', $lijstDetails->Opleiding );
		if( $lijstDetails->Opleiding != 'nvt' ){
			//$query .= "WHERE ";
			$countOpleiding = count($opleidingen ) -1;
			$counter1 = "0";
			$query .= "(";
			foreach($opleidingen as $opleiding){
				if($counter1 != $countOpleiding ){
					$query .= "Opleiding = '".$opleiding."' OR ";
					}else{
						$query .= "Opleiding = '".$opleiding."') ";
					}
					$counter1++;
			}
		}

		//Geslacht
		if($lijstDetails->Geslacht != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt'){
			$query .= "AND ";
			}
			if($lijstDetails->Geslacht == 'mannelijk'){
				$query .= "Geslacht = 'mannelijk' ";
			}else{
				$query .= "Geslacht = 'vrouwelijk' ";
			}
		}

		//Workshop
		if($lijstDetails->Workshop != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->Workshop == 'Ja'){
				$query .= "Talentworkshop = 'Ja' ";
			}else{
				$query .= "Talentworkshop = 'Nee' ";
			}
		}

		//Rondleiding
		if($lijstDetails->Rondleiding != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->Rondleiding == 'Ja'){
				$query .= "Rondleiding = 'Ja' ";
			}else{
				$query .= "Rondleiding = 'Nee' ";
			}
		}

		//Rijbewijs
		if($lijstDetails->Rijbewijs != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->Rijbewijs == 'Ja'){
				$query .= "Rijbewijs = 'Ja' ";
			}else{
				$query .= "Rijbewijs = 'Nee' ";
			}
		}

		//Online vraagstuk
		if($lijstDetails->OnlineVraagstuk != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->OnlineVraagstuk == 'Ja'){
				$query .= "OnlineVraagstuk = 'Ja' ";
			}else{
				$query .= "OnlineVraagstuk = 'Nee' ";
			}
		}

		//Webcare klus
		if($lijstDetails->WebcareKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->WebcareKlus == 'Ja'){
				$query .= "WebcareKlus = 'Ja' ";
			}else{
				$query .= "WebcareKlus = 'Nee' ";
			}
		}

		//Brochure klus
		if($lijstDetails->BrochureKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->BrochureKlus == 'Ja'){
				$query .= "BrochureKlus = 'Ja' ";
			}else{
				$query .= "BrochureKlus = 'Nee' ";
			}
		}

			//Invoer klus
		if($lijstDetails->InvoerKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->InvoerKlus == 'Ja'){
				$query .= "InvoerKlus = 'Ja' ";
			}else{
				$query .= "InvoerKlus = 'Nee' ";
			}
		}

			//Foto klus
		if($lijstDetails->FotoKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->FotoKlus == 'Ja'){
				$query .= "FotoKlus = 'Ja' ";
			}else{
				$query .= "FotoKlus = 'Nee' ";
			}
		}

			//Video klus
		if($lijstDetails->VideoKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->VideoKlus == 'Ja'){
				$query .= "VideoKlus = 'Ja' ";
			}else{
				$query .= "VideoKlus = 'Nee' ";
			}
		}

		//Nabelactie
		if($lijstDetails->NabelActie != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt" || $lijstDetails->VideoKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->NabelActie == 'Ja'){
				$query .= "NabelActie = 'Ja' ";
			}else{
				$query .= "NabelActie = 'Nee' ";
			}
		}

		$ontvangers = $wpdb->get_results(
						"
						SELECT * FROM Beheertool $query
						"
					);

		 //mail
		 $subject = $email.$lijstDetails->Naam;
		 $datemooi =  mooiedatum23($actDetails->Datum);
		 $tekst = $lijstDetails->comment;
		 $tekst2 = nl2br($tekst);
		 foreach( $ontvangers as $ontvanger ){
			 $aangemeld = $wpdb->get_row("SELECT * FROM Aanmeldingen WHERE StudID = $ontvanger->ID AND ActID = $ActID" );
			  $message .=" <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">";
			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
			  $message .=" Hallo $ontvanger->Voornaam,";
			  $message .=" <br /><br />";
			  $message .=" Je kunt je nu aan- of afmelden voor onderstaande activiteit(en)";
			  $message .=" <br /><br />";
			  $message .=" Wanneer je je wilt aanmelden of afmelden voor deze activiteit(en) dan kun je op de betreffende link klikken.<br />";
			  $message .=" <br />";
			  $message .=" Let op: Wanneer je je aanmeldt voor een activiteit is het nog niet zeker of je die dag ook moet werken, je ontvangt hierover op een later tijdstip een definitieve e-mail.";
			  $message .=" </p>";
				 if(!empty($lijstDetails->comment)){
				$message .= "<p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\"><b>Aanvullende informatie</b><br />".$tekst2."</p>";
			  }


			   /////hier zitten/zaten de foutmeldingen!

			 $activiteiten = explode( ',', $lijstDetails->ActID );
			  $count = "1";
			  foreach( $activiteiten as $activiteit){
				$message .= getActivities($activiteit, $ontvanger->ID, $count);
				$count++;
				}

			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
			  $message .=" <br /><br />";
			  $message .=" Wanneer je nog vragen hebt dan hoor ik het natuurlijk graag.";
			  $message .=" <br /><br />";
			  $message .=" Vriendelijke groet,<br />";
			  $message .=" $user_info->display_name<br />";
			  $message .=" <a href=\"mailto:$user_info->user_email\">$user_info->user_email</a>";
			  $message .=" </p>";
			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">Bekijk en bewerk <a href=\"http://www.expect-webmedia.nl/drpr/gegevens/?perskey=$ontvanger->Perskey\">hier</a> jouw gegevens en aanmeldingen.</p>";


			 $headers = array("From: $user_info->display_name <$user_info->user_email", "Content-Type: text/html");
			 $h = implode("\r\n",$headers) . "\r\n";
				 if(empty($aangemeld->Datum)){
					 //Eventueel alleen mailen hier uit filteren
						$alleenMailen0= $ontvanger->alleenMailen;
						$alleenMailen = explode(',', $alleenMailen0);

						if( $lijstDetails->OnlineVraagstuk == 'Ja' && in_array('onlineVraagStuk', $alleenMailen) || $lijstDetails->WebcareKlus == 'Ja' && in_array('webcareKlus', $alleenMailen) ||
						$lijstDetails->BrochureKlus == 'Ja' && in_array('brochureKlus', $alleenMailen) || $lijstDetails->InvoerKlus == 'Ja' && in_array('invoerKlus', $alleenMailen) ||
						$lijstDetails->FotoKlus == 'Ja' && in_array('fotografieKlus', $alleenMailen) || $lijstDetails->VideoKlus == 'Ja' && in_array('videoKlus', $alleenMailen) ||
						$lijstDetails->NabelActie == 'Ja' && in_array('nabelActie', $alleenMailen))
						{
							wp_mail( $ontvanger->Emailadres, $subject, $message, $h );
						}

						if(empty($ontvanger->alleenMailen)){
							wp_mail( $ontvanger->Emailadres, $subject, $message, $h );
						}
				 }
			 unset($message);

		 }
		 //En we gaan de database updaten
		 $vandaag = date('Ymd');
		 if(empty($email)){

		 $wpdb->update( Maillijst, array( 'Verzonden' => '1', 'SendDate' => $vandaag ),array( 'ID' => $ListID) );
		 }else{
			//$wpdb->update( Maillijst, array( 'reminderDate' => $vandaag ),array( 'ID' => $ListID) );
			$wpdb->insert( Reminders, array( 'mailID' => $ListID, 'reminderDate' => $vandaag ) );

		 }

	}


	function verzendMailNieuw2($ListID,$ActID,$email){
		global $wpdb;
		 $actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $ActID" );
		 $lijstDetails = $wpdb->get_row("SELECT * FROM Maillijst WHERE ID = $ListID" );
		 $testing = $wpdb->get_results("SELECT ActID FROM Maillijst WHERE ID = $ListID" );
		 $user_info = get_userdata( $lijstDetails->UserID);
		 if( $lijstDetails->Opleiding == 'nvt' && $lijstDetails->Geslacht == "nvt" && $lijstDetails->Workshop == "nvt" && $lijstDetails->Rondleiding == "nvt" && $lijstDetails->Rijbewijs == "nvt"
				&& $lijstDetails->OnlineVraagstuk == "nvt" && $lijstDetails->Webcareklus == "nvt" && $lijstDetails->Brochureklus == "nvt" && $lijstDetails->Invoerklus == "nvt"
				&& $lijstDetails->Fotoklus == "nvt" && $lijstDetails->VideoKlus == "nvt" && $lijstDetails->NabelActie == "nvt"
				){
		$query .= "";
		}else{
			$query .= "WHERE ";
		}


		//Opleiding
		$opleidingen = explode( ',', $lijstDetails->Opleiding );
		if( $lijstDetails->Opleiding != 'nvt' ){
			//$query .= "WHERE ";
			$countOpleiding = count($opleidingen ) -1;
			$counter1 = "0";
			$query .= "(";
			foreach($opleidingen as $opleiding){
				if($counter1 != $countOpleiding ){
					$query .= "Opleiding = '".$opleiding."' OR ";
					}else{
						$query .= "Opleiding = '".$opleiding."') ";
					}
					$counter1++;
			}
		}

		//Geslacht
		if($lijstDetails->Geslacht != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt'){
			$query .= "AND ";
			}
			if($lijstDetails->Geslacht == 'mannelijk'){
				$query .= "Geslacht = 'mannelijk' ";
			}else{
				$query .= "Geslacht = 'vrouwelijk' ";
			}
		}

		//Workshop
		if($lijstDetails->Workshop != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->Workshop == 'Ja'){
				$query .= "Talentworkshop = 'Ja' ";
			}else{
				$query .= "Talentworkshop = 'Nee' ";
			}
		}

		//Rondleiding
		if($lijstDetails->Rondleiding != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->Rondleiding == 'Ja'){
				$query .= "Rondleiding = 'Ja' ";
			}else{
				$query .= "Rondleiding = 'Nee' ";
			}
		}

		//Rijbewijs
		if($lijstDetails->Rijbewijs != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->Rijbewijs == 'Ja'){
				$query .= "Rijbewijs = 'Ja' ";
			}else{
				$query .= "Rijbewijs = 'Nee' ";
			}
		}

		//Online vraagstuk
		if($lijstDetails->OnlineVraagstuk != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->OnlineVraagstuk == 'Ja'){
				$query .= "OnlineVraagstuk = 'Ja' ";
			}else{
				$query .= "OnlineVraagstuk = 'Nee' ";
			}
		}

		//Webcare klus
		if($lijstDetails->WebcareKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->WebcareKlus == 'Ja'){
				$query .= "WebcareKlus = 'Ja' ";
			}else{
				$query .= "WebcareKlus = 'Nee' ";
			}
		}

		//Brochure klus
		if($lijstDetails->BrochureKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->BrochureKlus == 'Ja'){
				$query .= "BrochureKlus = 'Ja' ";
			}else{
				$query .= "BrochureKlus = 'Nee' ";
			}
		}

			//Invoer klus
		if($lijstDetails->InvoerKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->InvoerKlus == 'Ja'){
				$query .= "InvoerKlus = 'Ja' ";
			}else{
				$query .= "InvoerKlus = 'Nee' ";
			}
		}

			//Foto klus
		if($lijstDetails->FotoKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->FotoKlus == 'Ja'){
				$query .= "FotoKlus = 'Ja' ";
			}else{
				$query .= "FotoKlus = 'Nee' ";
			}
		}

			//Video klus
		if($lijstDetails->VideoKlus != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->VideoKlus == 'Ja'){
				$query .= "VideoKlus = 'Ja' ";
			}else{
				$query .= "VideoKlus = 'Nee' ";
			}
		}

		//Nabelactie
		if($lijstDetails->NabelActie != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt" || $lijstDetails->VideoKlus != "nvt"){
			$query .= "AND ";
			}
			if($lijstDetails->NabelActie == 'Ja'){
				$query .= "NabelActie = 'Ja' ";
			}else{
				$query .= "NabelActie = 'Nee' ";
			}
		}


		$ontvangers = $wpdb->get_results(
						"
						SELECT * FROM Beheertool $query
						"
					);

		 //mail
		 $subject = $email.$lijstDetails->Naam;
		 $datemooi =  mooiedatum23($actDetails->Datum);
		 $tekst = $lijstDetails->comment;
		 $tekst2 = nl2br($tekst);
		 foreach( $ontvangers as $ontvanger ){
			 $aangemeld = $wpdb->get_row("SELECT * FROM Aanmeldingen WHERE StudID = $ontvanger->ID AND ActID = $ActID" );
			  $message .=" <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">";
			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
			  $message .=" <b>Hallo $ontvanger->Voornaam,</b>";
			  $message .=" <br /><br />";
			  $message .=" </p>";
				 if(!empty($lijstDetails->comment)){
				$message .= "<p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">".$tekst2."</p>";
			  }
			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
			  $message .=" <br /><br />";
			  $message .=" Vriendelijke groet,<br />";
			  $message .=" $user_info->display_name<br />";
			  $message .=" <a href=\"mailto:$user_info->user_email\">$user_info->user_email</a>";
			  $message .=" </p>";
			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">Bekijk en bewerk <a href=\"http://www.expect-webmedia.nl/drpr/gegevens/?perskey=$ontvanger->Perskey\">hier</a> jouw gegevens en aameldingen.</p>";


			 $headers = array("From: $user_info->display_name <$user_info->user_email", "Content-Type: text/html");
			 $h = implode("\r\n",$headers) . "\r\n";
				 if(empty($aangemeld->Datum)){
					 //Eventueel alleen mailen hier uit filteren
						$alleenMailen0= $ontvanger->alleenMailen;
						$alleenMailen = explode(',', $alleenMailen0);

						if( $lijstDetails->OnlineVraagstuk == 'Ja' && in_array('onlineVraagStuk', $alleenMailen) || $lijstDetails->WebcareKlus == 'Ja' && in_array('webcareKlus', $alleenMailen) ||
						$lijstDetails->BrochureKlus == 'Ja' && in_array('brochureKlus', $alleenMailen) || $lijstDetails->InvoerKlus == 'Ja' && in_array('invoerKlus', $alleenMailen) ||
						$lijstDetails->FotoKlus == 'Ja' && in_array('fotografieKlus', $alleenMailen) || $lijstDetails->VideoKlus == 'Ja' && in_array('videoKlus', $alleenMailen) ||
						$lijstDetails->NabelActie == 'Ja' && in_array('nabelActie', $alleenMailen))
						{
							wp_mail( $ontvanger->Emailadres, $subject, $message, $h );
						}

						if(empty($ontvanger->alleenMailen)){
							wp_mail( $ontvanger->Emailadres, $subject, $message, $h );
						}
				 }
			 unset($message);

		 }
		 //En we gaan de database updaten
		 $vandaag = date('Ymd');
		 if(empty($email)){
		 $wpdb->update( Maillijst, array( 'Verzonden' => '1', 'SendDate' => $vandaag ),array( 'ID' => $ListID) );
		 }else{
			//$wpdb->update( Maillijst, array( 'reminderDate' => $vandaag ),array( 'ID' => $ListID) );
			$wpdb->insert( Reminders, array( 'mailID' => $ListID, 'reminderDate' => $vandaag ) );

		 }

	}

	function getActivities($actID,$userID,$count){

			  global $wpdb;
			  //Activiteit gegegevens ophalen
			  $actData = $wpdb->get_row( "SELECT * FROM Activiteiten WHERE ID = '".$actID."'" );

			  //User gegevens ophalen
			  $userData = $wpdb->get_row( "SELECT * FROM Beheertool WHERE ID = '".$userID."'" );
			  $userPerskey = $userData->Perskey;
			  $datumNew = get_mooiedatum($actData->Datum);
			  $maxDeelnemers = maxDeelnemers($actID);
			  $act ="
			  <table border=\"0\" cellpadding=\"5\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px; width: 600px;\">
				  <tr style=\"background-color: #f37021; color: #ffffff;\">
					  <td valign=\"top\" width=\"100\" ><b>Activiteit $count</b></td>
					  <td valign=\"top\" width=\"10\"><b>:</b></td>
					  <td valign=\"top\" ><b>$actData->Titel</b></td>
				  </tr>
				  <tr>
					  <td valign=\"top\">Datum</td>
					  <td valign=\"top\">:</td>
					  <td valign=\"top\">$datumNew</td>
				  </tr>
				  <tr>
					  <td valign=\"top\">Tijdstip</td>
					  <td valign=\"top\">:</td>
					  <td valign=\"top\"> $actData->Tijd_van - $actData->Tijd_tot uur</td>
				  </tr>
				  <tr>
					  <td valign=\"top\">Locatie</td>
					  <td valign=\"top\">:</td>
					  <td valign=\"top\"> $actData->Locatie</td>
				  </tr>
				  <tr>
					  <td valign=\"top\">Aanmelden</td>
					  <td valign=\"top\">:</td>
					  <td valign=\"top\" >Je kunt je <a href=\"http://www.expect-webmedia.nl/drpr/aanmelden-voor-activiteit/?perskey=$userPerskey&actid=$actData->ID\">hier</a> aanmelden</td>
				  </tr>
				  <tr>
					  <td valign=\"top\">Aanmelden tot </td>
					  <td valign=\"top\">:</td>
					  <td valign=\"top\"> $actData->Deadline uur</td>
				  </tr>
				  <tr>
					  <td valign=\"top\">Maximaal aantal deelnemers</td>
					  <td valign=\"top\">:</td>
					  <td valign=\"top\"> $maxDeelnemers </td>
				  </tr>
			  </table>
			  <br /><br />";

			  return $act;

			  unset($act);

	}


	//hoeveel deelnemers mogen maximaal deelnemen aan de activiteit
	function maxDeelnemers($actID){
		global $wpdb;
		$actData = $wpdb->get_row( "SELECT * FROM Activiteiten WHERE ID = '".$actID."'" );
		$maxDeelnemers = $actData->Max_deelnemers;

		if($maxDeelnemers > 124){
			$max = "Onbeperkt aantal deelnemers";
			return $max;
		}else{
			if($maxDeelnemers == 1){
			$max = $maxDeelnemers." deelnemer";
			return $max;
			}else{
			$max = $maxDeelnemers." deelnemers";
			return $max;
			}
		}
	}




	//$id = MAILLIJST ID
	function aantalOntvangersNieuw($id){
		global $wpdb;
		$lijstDetails = $wpdb->get_row("SELECT * FROM Maillijst WHERE ID = $id" );
		if( $lijstDetails->Opleiding == 'nvt' && $lijstDetails->Geslacht == "nvt" && $lijstDetails->Workshop == "nvt" && $lijstDetails->Rondleiding == "nvt" && $lijstDetails->Rijbewijs == "nvt"
			 && $lijstDetails->OnlineVraagstuk == "nvt" && $lijstDetails->Webcareklus == "nvt" && $lijstDetails->Brochureklus == "nvt" && $lijstDetails->Invoerklus == "nvt"
			 && $lijstDetails->Fotoklus == "nvt" && $lijstDetails->VideoKlus == "nvt" && $lijstDetails->NabelActie == "nvt"
			 ){
		$query .= "";
		}else{
		 $query .= "WHERE ";
		}


			//Opleiding
			$opleidingen = explode( ',', $lijstDetails->Opleiding );
			if( $lijstDetails->Opleiding != 'nvt' ){
			 //$query .= "WHERE ";
			 $countOpleiding = count($opleidingen ) -1;
			 $counter1 = "0";
			 $query .= "(";
			 foreach($opleidingen as $opleiding){
				 if($counter1 != $countOpleiding ){
					 $query .= "Opleiding = '".$opleiding."' OR ";
					 }else{
						 $query .= "Opleiding = '".$opleiding."') ";
					 }
					 $counter1++;
			 }
			}

			//Geslacht
			if($lijstDetails->Geslacht != "nvt"){
			 if( $lijstDetails->Opleiding != 'nvt'){
			 $query .= "AND ";
			 }
			 if($lijstDetails->Geslacht == 'mannelijk'){
				 $query .= "Geslacht = 'mannelijk' ";
			 }else{
				 $query .= "Geslacht = 'vrouwelijk' ";
			 }
			}

			//Workshop
			if($lijstDetails->Workshop != "nvt"){
			 if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt"){
			 $query .= "AND ";
			 }
			 if($lijstDetails->Workshop == 'Ja'){
				 $query .= "Talentworkshop = 'Ja' ";
			 }else{
				 $query .= "Talentworkshop = 'Nee' ";
			 }
			}

			//Rondleiding
			if($lijstDetails->Rondleiding != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt"){
			 $query .= "AND ";
			 }
			 if($lijstDetails->Rondleiding == 'Ja'){
				 $query .= "Rondleiding = 'Ja' ";
			 }else{
				 $query .= "Rondleiding = 'Nee' ";
			 }
			}

			//Rijbewijs
			if($lijstDetails->Rijbewijs != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt"){
			 $query .= "AND ";
			 }
			 if($lijstDetails->Rijbewijs == 'Ja'){
				 $query .= "Rijbewijs = 'Ja' ";
			 }else{
				 $query .= "Rijbewijs = 'Nee' ";
			 }
			}

			//Online vraagstuk
			if($lijstDetails->OnlineVraagstuk != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt"){
			 $query .= "AND ";
			 }
			 if($lijstDetails->OnlineVraagstuk == 'Ja'){
				 $query .= "OnlineVraagstuk = 'Ja' ";
			 }else{
				 $query .= "OnlineVraagstuk = 'Nee' ";
			 }
			}

			//Webcare klus
			if($lijstDetails->WebcareKlus != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt"){
			 $query .= "AND ";
			 }
			 if($lijstDetails->WebcareKlus == 'Ja'){
				 $query .= "WebcareKlus = 'Ja' ";
			 }else{
				 $query .= "WebcareKlus = 'Nee' ";
			 }
			}

			//Brochure klus
			if($lijstDetails->BrochureKlus != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt"){
			 $query .= "AND ";
			 }
			 if($lijstDetails->BrochureKlus == 'Ja'){
				 $query .= "BrochureKlus = 'Ja' ";
			 }else{
				 $query .= "BrochureKlus = 'Nee' ";
			 }
			}

			 //Invoer klus
			if($lijstDetails->InvoerKlus != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt"){
			 $query .= "AND ";
			 }
			 if($lijstDetails->InvoerKlus == 'Ja'){
				 $query .= "InvoerKlus = 'Ja' ";
			 }else{
				 $query .= "InvoerKlus = 'Nee' ";
			 }
			}

			 //Foto klus
			if($lijstDetails->FotoKlus != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt"){
			 $query .= "AND ";
			 }
			 if($lijstDetails->FotoKlus == 'Ja'){
				 $query .= "FotoKlus = 'Ja' ";
			 }else{
				 $query .= "FotoKlus = 'Nee' ";
			 }
			}

			 //Video klus
			if($lijstDetails->VideoKlus != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt"){
			 $query .= "AND ";
			 }
			 if($lijstDetails->VideoKlus == 'Ja'){
				 $query .= "VideoKlus = 'Ja' ";
			 }else{
				 $query .= "VideoKlus = 'Nee' ";
			 }
			}

			//Nabelactie
			if($lijstDetails->NabelActie != "nvt"){
			if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt" || $lijstDetails->VideoKlus != "nvt"){
			 $query .= "AND ";
			 }
			 if($lijstDetails->NabelActie == 'Ja'){
				 $query .= "NabelActie = 'Ja' ";
			 }else{
				 $query .= "NabelActie = 'Nee' ";
			 }
			}

					$ontvangers = $wpdb->get_results(
						"
						SELECT * FROM Beheertool $query
						"
					);

					//echo count($ontvangers);
					$totalCount = "0";
					 foreach( $ontvangers as $ontvanger ){
					$aangemeld = $wpdb->get_row("SELECT * FROM Aanmeldingen WHERE StudID = $ontvanger->ID AND ActID = $ActID" );
					 if(empty($aangemeld->Datum)){
						//Eventueel alleen mailen hier uit filteren
						$alleenMailen0= $ontvanger->alleenMailen;
						$alleenMailen = explode(',', $alleenMailen0);

						if( $lijstDetails->OnlineVraagstuk == 'Ja' && in_array('onlineVraagStuk', $alleenMailen) || $lijstDetails->WebcareKlus == 'Ja' && in_array('webcareKlus', $alleenMailen) || $lijstDetails->BrochureKlus == 'Ja' && in_array('brochureKlus', $alleenMailen) || $lijstDetails->InvoerKlus == 'Ja' && in_array('invoerKlus', $alleenMailen) || $lijstDetails->FotoKlus == 'Ja' && in_array('fotografieKlus', $alleenMailen) || $lijstDetails->VideoKlus == 'Ja' && in_array('videoKlus', $alleenMailen) || $lijstDetails->NabelActie == 'Ja' && in_array('nabelActie', $alleenMailen)){

						$totalCount++;

						}

						if(empty($ontvanger->alleenMailen)){
							$totalCount++;
						}
					 }
		 }
		 echo $totalCount;
	}

	function previewMail($mailID){
			  global $wpdb;
			  $lijstDetails = $wpdb->get_row("SELECT * FROM Maillijst WHERE ID = $mailID" );
			  $ActID = $lijstDetails->ActID;
			  $user_info = get_userdata( $lijstDetails->UserID);
			  $tekst = $lijstDetails->comment;
			  $tekst2 = nl2br($tekst);

			  $message .="<div style=\"margin: 50px; width: 600px;\">";
			  $message .=" <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">";
			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
			  $message .=" Hallo %%Voornaam%%";
			  $message .=" <br /><br />";
			  $message .=" Je kunt je nu aan- of afmelden voor onderstaande activiteit(en)";
			  $message .=" <br /><br />";
			  $message .=" Wanneer je je wilt aanmelden of afmelden voor deze activiteit(en) dan kun je op de betreffende link klikken.<br />";
			  $message .=" <br /><br />";
			  $message .=" Let op: Wanneer je je aanmeldt voor een activiteit is het nog niet zeker of je die dag ook moet werken, je ontvangt hierover op een later tijdstip een definitieve e-mail.";
			  $message .=" </p>";
			  if(!empty($lijstDetails->comment)){
				$message .= "<p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\"><b>Aanvullende informatie</b><br />".$tekst2."</p>";
			  }
			  $activiteiten = explode(",", $ActID);
			  $count = "1";
			  foreach($activiteiten as $activiteit){
			  $actData = $wpdb->get_row( "SELECT * FROM Activiteiten WHERE ID = '".$activiteit."'" );
			  $message .=" <table border=\"0\" cellpadding=\"5\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px; width: 600px;\">";
			  $message .=" <tr style=\"background-color: #f37021; color: #ffffff;\">";
			  $message .=" <td valign=\"top\" width=\"100\" ><b>Activiteit $count</b></td>";
			  $message .=" <td valign=\"top\" width=\"10\"><b>:</b></td>";
			  $message .=" <td valign=\"top\" ><b>$actData->Titel</b></td>";
			  $message .=" </tr>";
			  $message .=" <tr>";
			  $datumNew = get_mooiedatum($actData->Datum);
			  $message .=" <td valign=\"top\">Datum</td>";
			  $message .=" <td valign=\"top\">:</td>";
			  $message .=" <td valign=\"top\">$datumNew</td>";
			  $message .=" </tr>";
			  $message .=" <tr>";
			  $message .=" <td valign=\"top\">Tijdstip</td>";
			  $message .=" <td valign=\"top\">:</td>";
			  $message .=" <td valign=\"top\"> $actData->Tijd_van - $actData->Tijd_tot uur</td>";
			  $message .=" </tr>";
			  $message .=" <tr>";
			  $message .=" <td valign=\"top\">Locatie</td>";
			  $message .=" <td valign=\"top\">:</td>";
			  $message .=" <td valign=\"top\"> $actData->Locatie</td>";
			  $message .=" </tr>";
			  $message .=" <tr>";
			  $message .=" <td valign=\"top\">Aanmelden</td>";
			  $message .=" <td valign=\"top\">:</td>";
			  $message .=" <td valign=\"top\" >Je kunt je <a href=\"#\">hier</a> aanmelden</td>";
			  $message .=" </tr>";
			  $message .=" <tr>";
			  $message .=" <td valign=\"top\">Aanmelden tot </td>";
			  $message .=" <td valign=\"top\">:</td>";
			  $message .=" <td valign=\"top\"> $actData->Deadline uur</td>";
			  $message .=" </tr>";
			  $message .=" </table><br /><br />";
			  $count++;
			}


			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
			  $message .=" <br /><br />";
			  $message .=" Wanneer je nog vragen hebt dan hoor ik het natuurlijk graag.";
			  $message .=" <br /><br />";
			  $message .=" Vriendelijke groet,<br />";
			  $message .=" $user_info->display_name<br />";
			  $message .=" <a href=\"mailto:$actDetails->Contactemail\">$actDetails->Contactemail</a>";
			  $message .=" </p>";
			  $message .=" </div>";

			  echo $message;
	}

	function previewMailContentbeheer($mailID){
			  global $wpdb;
			  $lijstDetails = $wpdb->get_row("SELECT * FROM BriefingMaillijst WHERE ID = $mailID" );
			  $ActID = $lijstDetails->ActID;
			  $user_info = get_userdata( $lijstDetails->UserID);
			  $tekst = $lijstDetails->comment;
			  $tekst2 = nl2br($tekst);

			  $message .="<div style=\"margin: 50px; width: 600px;\">";
			  $message .=" <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">";
			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
			  $message .=" Hallo Contentbeheer,";
			  $message .=" <br /><br />";
			  $message .=" Willen jullie onderstaande opdachten(en) inplannen?";;
			  $message .=" </p>";
			  if(!empty($lijstDetails->comment)){
				$message .= "<p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\"><b>Opmerkingen</b><br /><br />".$tekst2."</p>";
			  }
			  $activiteiten = explode(",", $ActID);
			  $count = "1";
			  foreach($activiteiten as $activiteit){
			  $actData = $wpdb->get_row( "SELECT * FROM Briefing WHERE ID = '".$activiteit."'" );
			  $message .=" <table border=\"0\" cellpadding=\"5\" cellspacing=\"0\" style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px; width: 600px;\">";
			  $message .=" <tr style=\"background-color: #f37021; color: #ffffff;\">";
			  $message .=" <td valign=\"top\" width=\"100\" ><b>Briefing $count</b></td>";
			  $message .=" <td valign=\"top\" width=\"10\"><b>:</b></td>";
			  $message .=" <td valign=\"top\" ><b>$actData->Titel</b></td>";
			  $message .=" </tr>";
				$message .=" <tr>";
		 	 $datumStart = get_mooiedatum($actData->Startdatum);
		 	 $message .=" <td valign=\"top\">Gewenste datum</td>";
		 	 $message .=" <td valign=\"top\">:</td>";
		 	 $message .=" <td valign=\"top\">$datumStart</td>";
		 	 $message .=" </tr>";
		   if(!empty($actData->Einddatum)){
		 	$message .=" <tr>";
		   $datumCor = get_mooiedatum($actData->Einddatum);
		 	$message .=" <td valign=\"top\">Gewenste datum correcties</td>";
		 	$message .=" <td valign=\"top\">:</td>";
		 	$message .=" <td valign=\"top\">$datumCor</td>";
		 	$message .=" </tr>";
		 	}
		 	if(!empty($actData->Verzenddatum)){
		 	$message .=" <tr>";
		 	$datumSend = get_mooiedatum($actData->Verzenddatum);
		 	$message .=" <td valign=\"top\">Gewenste datum verzenden</td>";
		 	$message .=" <td valign=\"top\">:</td>";
		 	$message .=" <td valign=\"top\">$datumSend</td>";
		 	$message .=" </tr>";
		 	}
			  $message .=" <tr>";
			  $message .=" <td valign=\"top\">Locatie M: schijf</td>";
			  $message .=" <td valign=\"top\">:</td>";
			  $message .=" <td valign=\"top\"> $actData->Locatie</td>";
			  $message .=" </tr>";
			  $message .=" <tr>";
			  $message .=" <td valign=\"top\">Briefing</td>";
			  $message .=" <td valign=\"top\">:</td>";
			  $message .=" <td valign=\"top\" >Je kunt <a href=\"https://www.expect-webmedia.nl/drpr/briefing-detail/?id=$activiteit\">hier</a> de briefing bekijken</td>";
			  $message .=" </tr>";
			  $message .=" <tr>";
			  $message .=" <td valign=\"top\">Omschrijving</td>";
			  $message .=" <td valign=\"top\">:</td>";
			  $message .=" <td valign=\"top\"> $actData->Omschrijving</td>";
			  $message .=" </tr>";
			  $message .=" </table><br /><br />";
			  $count++;
			}


			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
			  $message .=" Mochten er nog vragen zijn over deze opdracht(en) dan hoor ik het graag.";
			  $message .=" <br /><br />";
			  $message .=" Vriendelijke groet,<br />";
			  $message .=" $user_info->display_name<br />";
			  $message .=" <a href=\"mailto:$actDetails->Contactemail\">$actDetails->Contactemail</a>";
			  $message .=" </p>";
			  $message .=" </div>";

			  echo $message;
	}




	function previewMail2($mailID){
			  global $wpdb;
			  $lijstDetails = $wpdb->get_row("SELECT * FROM Maillijst WHERE ID = $mailID" );
			  $ActID = $lijstDetails->ActID;
			  $user_info = get_userdata( $lijstDetails->UserID);
			  $tekst = $lijstDetails->comment;
			  $tekst2 = nl2br($tekst);

			 $message .=" <div style=\"width: 600px;\"><img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">";
			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
			  $message .=" <b>Hallo %%Voornaam%%,</b>";
			  $message .=" <br /><br />";
			  $message .=" </p>";
				 if(!empty($lijstDetails->comment)){
				$message .= "<p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">".$tekst2."</p>";
			  }
			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">";
			  $message .=" <br /><br />";
			  $message .=" Vriendelijke groet,<br />";
			  $message .=" $user_info->display_name<br />";
			  $message .=" <a href=\"mailto:$user_info->user_email\">$user_info->user_email</a>";
			  $message .=" </p>";
			  $message .=" <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">Bekijk en bewerk <a href=\"#\">hier</a> jouw gegevens en aanmeldingen.</p></div>";

			  echo $message;
	}



	function mailOntvangers($ListID,$ActID,$email){
	global $wpdb;
	 $actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $ActID" );
	 $lijstDetails = $wpdb->get_row("SELECT * FROM Maillijst WHERE ID = $ListID" );
	 $testing = $wpdb->get_results("SELECT ActID FROM Maillijst WHERE ID = $ListID" );
	 $user_info = get_userdata( $lijstDetails->UserID);
	 if( $lijstDetails->Opleiding == 'nvt' && $lijstDetails->Geslacht == "nvt" && $lijstDetails->Workshop == "nvt" && $lijstDetails->Rondleiding == "nvt" && $lijstDetails->Rijbewijs == "nvt"
			&& $lijstDetails->OnlineVraagstuk == "nvt" && $lijstDetails->Webcareklus == "nvt" && $lijstDetails->Brochureklus == "nvt" && $lijstDetails->Invoerklus == "nvt"
			&& $lijstDetails->Fotoklus == "nvt" && $lijstDetails->VideoKlus == "nvt" && $lijstDetails->NabelActie == "nvt"
			){
	$query .= "";
	}else{
		$query .= "WHERE ";
	}


	//Opleiding
	$opleidingen = explode( ',', $lijstDetails->Opleiding );
	if( $lijstDetails->Opleiding != 'nvt' ){
		//$query .= "WHERE ";
		$countOpleiding = count($opleidingen ) -1;
		$counter1 = "0";
		$query .= "(";
		foreach($opleidingen as $opleiding){
			if($counter1 != $countOpleiding ){
				$query .= "Opleiding = '".$opleiding."' OR ";
				}else{
					$query .= "Opleiding = '".$opleiding."') ";
				}
				$counter1++;
		}
	}

	//Geslacht
	if($lijstDetails->Geslacht != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt'){
		$query .= "AND ";
		}
		if($lijstDetails->Geslacht == 'mannelijk'){
			$query .= "Geslacht = 'mannelijk' ";
		}else{
			$query .= "Geslacht = 'vrouwelijk' ";
		}
	}

	//Workshop
	if($lijstDetails->Workshop != "nvt"){
		if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt"){
		$query .= "AND ";
		}
		if($lijstDetails->Workshop == 'Ja'){
			$query .= "Talentworkshop = 'Ja' ";
		}else{
			$query .= "Talentworkshop = 'Nee' ";
		}
	}

	//Rondleiding
	if($lijstDetails->Rondleiding != "nvt"){
	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt"){
		$query .= "AND ";
		}
		if($lijstDetails->Rondleiding == 'Ja'){
			$query .= "Rondleiding = 'Ja' ";
		}else{
			$query .= "Rondleiding = 'Nee' ";
		}
	}

	//Rijbewijs
	if($lijstDetails->Rijbewijs != "nvt"){
	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt"){
		$query .= "AND ";
		}
		if($lijstDetails->Rijbewijs == 'Ja'){
			$query .= "Rijbewijs = 'Ja' ";
		}else{
			$query .= "Rijbewijs = 'Nee' ";
		}
	}

	//Online vraagstuk
	if($lijstDetails->OnlineVraagstuk != "nvt"){
	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt"){
		$query .= "AND ";
		}
		if($lijstDetails->OnlineVraagstuk == 'Ja'){
			$query .= "OnlineVraagstuk = 'Ja' ";
		}else{
			$query .= "OnlineVraagstuk = 'Nee' ";
		}
	}

	//Webcare klus
	if($lijstDetails->WebcareKlus != "nvt"){
	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt"){
		$query .= "AND ";
		}
		if($lijstDetails->WebcareKlus == 'Ja'){
			$query .= "WebcareKlus = 'Ja' ";
		}else{
			$query .= "WebcareKlus = 'Nee' ";
		}
	}

	//Brochure klus
	if($lijstDetails->BrochureKlus != "nvt"){
	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt"){
		$query .= "AND ";
		}
		if($lijstDetails->BrochureKlus == 'Ja'){
			$query .= "BrochureKlus = 'Ja' ";
		}else{
			$query .= "BrochureKlus = 'Nee' ";
		}
	}

		//Invoer klus
	if($lijstDetails->InvoerKlus != "nvt"){
	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt"){
		$query .= "AND ";
		}
		if($lijstDetails->InvoerKlus == 'Ja'){
			$query .= "InvoerKlus = 'Ja' ";
		}else{
			$query .= "InvoerKlus = 'Nee' ";
		}
	}

		//Foto klus
	if($lijstDetails->FotoKlus != "nvt"){
	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt"){
		$query .= "AND ";
		}
		if($lijstDetails->FotoKlus == 'Ja'){
			$query .= "FotoKlus = 'Ja' ";
		}else{
			$query .= "FotoKlus = 'Nee' ";
		}
	}

		//Video klus
	if($lijstDetails->VideoKlus != "nvt"){
	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt"){
		$query .= "AND ";
		}
		if($lijstDetails->VideoKlus == 'Ja'){
			$query .= "VideoKlus = 'Ja' ";
		}else{
			$query .= "VideoKlus = 'Nee' ";
		}
	}

	//Nabelactie
	if($lijstDetails->NabelActie != "nvt"){
	if( $lijstDetails->Opleiding != 'nvt' || $lijstDetails->Geslacht != "nvt" || $lijstDetails->Workshop != "nvt" || $lijstDetails->Rondleiding != "nvt" || $lijstDetails->Rijbewijs != "nvt" || $lijstDetails->OnlineVraagstuk != "nvt" || $lijstDetails->WebcareKlus != "nvt" || $lijstDetails->BrochureKlus != "nvt" || $lijstDetails->InvoerKlus != "nvt" || $lijstDetails->FotoKlus != "nvt" || $lijstDetails->VideoKlus != "nvt"){
		$query .= "AND ";
		}
		if($lijstDetails->NabelActie == 'Ja'){
			$query .= "NabelActie = 'Ja' ";
		}else{
			$query .= "NabelActie = 'Nee' ";
		}
	}



	$ontvangers = $wpdb->get_results(
					"
					SELECT * FROM Beheertool $query ORDER BY Voornaam ASC
					"
				);

	 //ontvangers
	 $subject = $email.$lijstDetails->Naam;
	 $datemooi =  mooiedatum23($actDetails->Datum);
	 $count = "1";
	 foreach( $ontvangers as $ontvanger ){
	$alleenMailen = explode(',', $ontvanger->alleenMailen);

										if(!empty($ontvanger->alleenMailen)){

											if( $lijstDetails->OnlineVraagstuk == 'Ja' && in_array('onlineVraagStuk', $alleenMailen) || $lijstDetails->WebcareKlus == 'Ja' && in_array('webcareKlus', $alleenMailen) ||
											$lijstDetails->BrochureKlus == 'Ja' && in_array('brochureKlus', $alleenMailen) || $lijstDetails->InvoerKlus == 'Ja' && in_array('invoerKlus', $alleenMailen) ||
											$lijstDetails->FotoKlus == 'Ja' && in_array('fotografieKlus', $alleenMailen) || $lijstDetails->VideoKlus == 'Ja' && in_array('videoKlus', $alleenMailen) ||
											$lijstDetails->NabelActie == 'Ja' && in_array('nabelActie', $alleenMailen)){
											?>

										<tr>
											<td valign="top" width="200"><b><?php echo $count; ?>. <a href="http://www.expect-webmedia.nl/drpr/detail/?id=<?php echo $ontvanger->ID; ?>"><?php echo $ontvanger->Voornaam." ".$ontvanger->Tussenvoegsel." ".$ontvanger->Achternaam; ?></a></b>
											</td>
											<td valign="top"></td>
											<td valign="top"><?php echo $ontvanger->Opleiding; ?></td>
										</tr>

										<?php $count++;

											}
										}

									if(empty($ontvanger->alleenMailen)){ ?>


										<tr>
											<td valign="top" width="200"><b><?php echo $count; ?>. <a href="http://www.expect-webmedia.nl/drpr/detail/?id=<?php echo $ontvanger->ID; ?>"><?php echo $ontvanger->Voornaam." ".$ontvanger->Tussenvoegsel." ".$ontvanger->Achternaam; ?></a></b>
											</td>
											<td valign="top"></td>
											<td valign="top"><?php echo $ontvanger->Opleiding; ?></td>
										</tr>
										 <?php $count++; }

	 }
}


	function tijdelijkmail(){
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

	$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $result->ID" );

	$user_info = get_userdata($actDetails->ingeplandBij);
	$subject = "Reminder: ".$actDetails->Titel;
	$headers = array("From: Contentbeheer <contentbeheer@nhl.nl", "Content-Type: text/html");
	$h = implode("\r\n",$headers) . "\r\n";
	$message = "
		 <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
		 <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
		 Hallo $actDetails->Opdrachtgever,<br /><br />
		Op de volgende werkdag staat $user_info->display_name voor jou ingepland voor de volgende opdracht: $actDetails->Titel.<br/><br/>
		Heb je ervoor gezorgd dat $user_info->first_name de juiste input heeft gekregen zodat er direct gestart kan worden met de klus? Mocht je de briefing niet of niet op tijd hebben aangeleverd dan wordt de opdracht uit de planning van contentbeheer gehaald en zal de klus opnieuw door jou moeten worden ingepland. <br /><br />

		Met vriendelijke groet,<br/>
		Contentbeheer
		</p>";


	//echo $actDetails->Contactemail."<br />";
	wp_mail( $actDetails->Contactemail, $subject, $message, $h );

}
		 $headers = array("From: $actDetails->Contactpersoon <$actDetails->Contactemail", "Content-Type: text/html");
			 $h = implode("\r\n",$headers) . "\r\n";
			$message = "Dit is een test van Geert";
					wp_mail( $email, $subject, $message, $h );

	}

	function mailtemplate($actID, $studID){
	 global $wpdb;
	 $actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $actID" );
	 $studentNaam = getStudentNaam($studID);
	 $subject = $studentNaam." heeft zich afgemeld voor ".$actDetails->Titel;
	 $message = "
			 <img src=\"https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/logoNHLStenden.png\">
			 <p style=\"font-family: arial; font-size: 12px; color: #393939; line-height: 18px;\">
			Hallo $actDetails->Contactpersoon,
			<br /><br />
			$studentNaam heeft zich onlangs aangemeld voor <b>$actDetails->Titel</b>, maar heeft zich nu afgemeld voor deze activiteit.
			<br /><br />
			Bekijk <a href=\"http://www.expect-webmedia.nl/drpr/activiteit-detail/?id=$actID\">hier</a> de alle aan- en afmeldingen voor deze activiteit.
			</p>
			";
			 $headers = array("From: Dream Team Systeem <no-reply@nhl.nl", "Content-Type: text/html");
			 $h = implode("\r\n",$headers) . "\r\n";
			 //mail versturen
			 wp_mail( $actDetails->Contactemail, $subject, $message, $h );
		 }



if ( get_magic_quotes_gpc() ) {
    $_POST      = array_map( 'stripslashes_deep', $_POST );
    $_GET       = array_map( 'stripslashes_deep', $_GET );
    $_COOKIE    = array_map( 'stripslashes_deep', $_COOKIE );
    $_REQUEST   = array_map( 'stripslashes_deep', $_REQUEST );
}
