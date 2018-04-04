<?php 
/*
Template Name: Aanmelden voor activiteit
*/
get_header('mobiel'); 

global $wpdb;


//////// Link voor in de mail http://www.expect-webmedia.nl/drpr/aanmelden-voor-activiteit/?perskey=f7180970ea84b570ab80ac622c1cab9b&actid=12

//gegevens ophalen van activiteit
$actID = $_GET['actid'];
$perskey = $_GET['perskey'];
//$studentInfo = $wpdb->get_var("SELECT ID FROM Beheertool WHERE Voornaam = $perskey" );
$studentInfo = $wpdb->get_row("SELECT * FROM Beheertool WHERE Perskey = '".$_GET['perskey']."'" );
$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $actID" );
$alAangemeld = $wpdb->get_row("SELECT * FROM Aanmeldingen WHERE StudID = '".$studentInfo->ID."' AND ActID = '".$actID."' AND Afwezig != 'afwezig' ");
$afgemeld = $wpdb->get_row("SELECT * FROM Aanmeldingen WHERE StudID = '".$studentInfo->ID."' AND ActID = '".$actID."' AND Afwezig = 'afwezig' ");

$huidigeDag = date("YmdHis", strtotime(date('YmdHis') . "+1hours"));
$deadLineDag = date("YmdHis", strtotime($actDetails->Deadline));


$countAanmeldingen = $wpdb->get_var( 
						"
						SELECT COUNT(*) FROM Aanmeldingen WHERE actID = $actID AND Afwezig != 'afwezig' AND hoeftNiet != '1'
						"
					); 
$maxAanmeldingen = $actDetails->Max_deelnemers;
$maxDeelnemers = maxDeelnemers($actID);

?>
<div id="aanmeldenContent">
<div id="contentMobiel">
		<div class="contentHeaderMobiel">
			<h1>Aanmelden voor "<?php echo $actDetails->Titel; ?>"<?php echo $deadLine; ?></h1>
		</div>
		<div class="contentContent">
		<?php if($countAanmeldingen < $maxAanmeldingen && empty($_GET['subscribe']) && empty($_GET['afwezig'])){ 
			if(!empty($studentInfo) && empty($alAangemeld ) && empty($afgemeld) && $huidigeDag < $deadLineDag){
			?>
	Je staat op punt je aan te melden voor "<?php echo $actDetails->Titel; ?>", controleer onderstaande gegevens goed voordat je hiermee akkoord gaat! 
	<br /><br />
	Let op: Wanneer je je aanmeldt voor deze activiteit is het nog niet zeker of je die dag ook moet werken, je ontvangt hierover op een later tijdstip een definitieve e-mail van mij.
	<br /><br />
	<table border="0" cellpadding="5" width="100%">
		<tr>
			<td valign="top" width="100"><B>Activiteit</B></td>
			<td valign="top">:</td>
			<td valign="top"><?php echo $actDetails->Titel; ?></td>
		</tr>
		<tr>
					<td valign="top">Datum</td>
					<td valign="top">:</td>
					<td valign="top"><?php mooiedatum($actDetails->Datum); ?></td>
				</tr>
				<tr>
					<td valign="top">Tijdstip</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $actDetails->Tijd_van; ?> - <?php echo $actDetails->Tijd_tot; ?> uur</td>
				</tr>
				<tr>
					<td valign="top">Locatie</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $actDetails->Locatie; ?></td>
				</tr>
				<tr>
					<td valign="top">Omschrijving</td>
					<td valign="top">:</td>
					<td valign="top" ><?php echo $actDetails->Omschrijving; ?></td>
				</tr>
				<tr>
					<td valign="top" width="130">Contactpersoon</td>
					<td valign="top">:</td>
					<td valign="top"><a href="mailto:<?php echo $actDetails->Contactemail; ?>"><?php echo $actDetails->Contactpersoon; ?></a></td>
				</tr>
				<tr>
					<td valign="top" width="130">Aanmelden kan tot</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $actDetails->Deadline; ?></td>
				</tr>
				<tr>
					  <td valign="top">Maximaal aantal deelnemers</td>
					  <td valign="top">:</td>
					  <td valign="top"><?php echo $maxDeelnemers; ?> </td>
				  </tr>
				<tr>
					<td valign="top">Eventuele opmerkingen</td>
					<td valign="top">:</td>
					<td valign="top" ><?php echo $actDetails->Opmerkingen; ?></td>
				</tr>
	</table> 
	<B>Jouw gegevens</B>
	<table border="0" cellpadding="5" width="100%">
		<tr>
			<td valign="top" width="130"><B>Naam</B></td>
			<td valign="top">:</td>
			<td valign="top"><?php echo $studentInfo->Voornaam." ".$studentInfo->Tussenvoegsel." ".$studentInfo->Achternaam; ?></td>
		</tr>
		<tr>
			<td valign="top" width="100"><B>Studentnummer</B></td>
			<td valign="top">:</td>
			<td valign="top"><?php echo $studentInfo->Studentnr; ?></td>
		</tr>
	</table>
	<div id="subscribe" onclick="javascript:location.href='http://www.expect-webmedia.nl/drpr/aanmelden-voor-activiteit/?perskey=<?php echo $studentInfo->Perskey; ?>&actid=<?php echo $actDetails->ID; ?>&subscribe=yes'">Ja, ik meld mij aan voor "<?php echo $actDetails->Titel; ?>"</div>
	<div id="subscribe" onclick="javascript:location.href='http://www.expect-webmedia.nl/drpr/aanmelden-voor-activiteit/?perskey=<?php echo $studentInfo->Perskey; ?>&actid=<?php echo $actDetails->ID; ?>&afwezig=yes'">Nee, ik ben niet beschikbaar.</div>

	
	
	<?php }	}
	
	if($countAanmeldingen == $maxAanmeldingen  || $huidigeDag > $deadLineDag){
		if($countAanmeldingen == $maxAanmeldingen ){
			echo "Je kunt je helaas niet meer aan- of afmelden voor deze activiteit! Er zijn genoeg aanmeldingen! <br /><p>";
		}
		
		if($huidigeDag > $deadLineDag){
			echo "Helaas is de sluitingsdatum voor deze activiteit verstreken, je kunt je niet meer aan- of afmelden.";
		}
		
	}

	if(!empty($alAangemeld)){
		echo "Je hebt je al aangemeld voor deze activiteit!<br /><p>";
	}

	if(!empty($afgemeld)){
		echo "Je hebt je afgemeld voor deze activiteit!<br /><p>";
	}

	if(empty($studentInfo)){
		echo "Er gaat iets fout!<br /><p>";
	}
if(!empty($_GET['subscribe']) && !empty($studentInfo) && $countAanmeldingen < $maxAanmeldingen && empty($alAangemeld)){
		$datum = date('Ymd');
		$tijd = date('H:i:s');
		$actDate = $actDetails->Datum;
		$wpdb->insert( Aanmeldingen, array( 'ActID' => $_GET['actid'], 'StudID' => $studentInfo->ID, 'Datum' => $datum, 'Tijd' => $tijd, 'ActDate' => $actDate, 'contactID' => $actDetails->ContactpersoonID  ) );	?>
		<div id="succes">
			<ul>
				<li>Bedankt je hebt je aangemeld voor "<?php echo $actDetails->Titel; ?>"!</li>
			</ul>
		</div>
		<?php }


if(!empty($_GET['afwezig']) && empty($alAangemeld) && empty($afgemeld)){
		$datum = date('Ymd');
		$tijd = date('H:i:s');
		$actDate = $actDetails->Datum;
		$wpdb->insert( Aanmeldingen, array( 'ActID' => $_GET['actid'], 'StudID' => $studentInfo->ID, 'Datum' => $datum, 'Tijd' => $tijd, 'ActDate' => $actDate, 'Afwezig' => 'afwezig', 'contactID' => $actDetails->ContactpersoonID ) );	?>
		<div id="succes">
			<ul>
				<li>Bedankt, je hebt aangegeven dat je niet beschikbaar bent voor "<?php echo $actDetails->Titel; ?>"!</li>
			</ul>
		</div>
		<?php }



	
	
	?>
	</div>
</div>
<?php
get_footer('kaal');