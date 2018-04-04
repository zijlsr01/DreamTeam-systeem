<?php 
/*
Template Name: Persoonlijke gegevens
*/
get_header('mobiel'); 

global $wpdb;


//////// Link voor in de mail http://www.expect-webmedia.nl/drpr/aanmelden-voor-activiteit/?perskey=f7180970ea84b570ab80ac622c1cab9b&actid=12

//gegevens ophalen van activiteit
$actID = $_GET['actid'];
$perskey = $_GET['perskey'];
$datum = date('Ymd');
//$studentInfo = $wpdb->get_var("SELECT ID FROM Beheertool WHERE Voornaam = $perskey" );
$studentDetails2 = $wpdb->get_row("SELECT * FROM Beheertool WHERE Perskey = '".$_GET['perskey']."'" );


//afmelden voor activiteit

if($_GET['afmelden'] == '1'){
	$actID = $_GET['actID'];
	$actName = get_activiteitNaam($actID);
	$rowID = $_GET['rowID'];
	$studID = $studentDetails2->ID;
	$afgemeld = $wpdb->get_row("SELECT * FROM Aanmeldingen WHERE ID = '".$rowID."'" );

	if(empty($afgemeld->Afwezig)){
	$wpdb->update( Aanmeldingen, array( 'Afwezig' => 'afwezig2'),array( 'ID' => $rowID ) );
	mailtemplate($actID, $studID); ?>
	<div id="s6">
		<div id="succesMobiel">
		Je hebt je met succes afgemeld voor "<?php echo $actName; ?>"
		</div>
	</div>
	<?php }else{ ?>
	
<div id="s6">
	<div  id="alertMobiel">
			Je hebt je al afgemeld voor deze activiteit
	</div>
	</div>
	<?php }
	?>
	<?php 
}



if($_POST['aanpassen']){
					//we gaan kijken of er fouten gemaakt zijn

					
					if(empty($_POST['voornaam'])){
						$error .=  "<li>Vul a.u.b. de voornaam in!</li>";
					}


					if(empty($_POST['achternaam'])){
						$error .=  "<li>Vul a.u.b. de achternaam in!</li>";
					}

					if($_POST['geslacht'] == "keuze" ){
						$error .=  "<li>Vul a.u.b. het geslacht in!</li>";
					}

					if(empty($_POST['geboortedatum'])){
						$error .=  "<li>Vul a.u.b. de geboortedatum in!</li>";
					}

					if(empty($_POST['email'])){
						$error .=  "<li>Vul a.u.b. het e-mailadres in!</li>";
					}

					if(empty($_POST['adres'])){
						$error .=  "<li>Vul a.u.b. het adres in!</li>";
					}

					if(empty($_POST['huisnummer'])){
						$error .=  "<li>Vul a.u.b. het huisnummer in!</li>";
					}

					if(empty($_POST['postcode'])){
						$error .=  "<li>Vul a.u.b. de postcode in!</li>";
					}

					if(empty($_POST['woonplaats'])){
						$error .=  "<li>Vul a.u.b. de woonplaatst in!</li>";
					}

					if(empty($_POST['telefoonnummer'])){
						$error .=  "<li>Vul a.u.b. het telefoonnummer in!!</li>";
					}

		
					if(empty($_POST['mobiel'])){
						$error .=  "<li>Vul a.u.b. het mobielenummer in!</li>";
					}

					if(empty($_POST['studnr'])){
						$error .=  "<li>Vul a.u.b. het studentennummer in!</li>";
					}


					if($_POST['opleiding'] == "keuze" ){
						$error .=  "<li>Selecteer a.u.b. de opleiding!</li>";
					}

					if($_POST['studiejaar'] == "keuze" ){
						$error .=  "<li>Selecteer a.u.b. het studiejaar!</li>";
					}

					if($_POST['vooropleiding'] == "keuze" ){
						$error .=  "<li>Selecteer a.u.b. de vooropleiding!</li>";
					}

					if($_POST['maat'] == "keuze" ){
						$error .=  "<li>Selecteer a.u.b. het T-shirtmaat!</li>";
					}


					if($_POST['rijbewijs'] == "keuze" ){
						$error .=  "<li>Selecteer a.u.b. of hij/zij een rijbewijs heeft!</li>";
					}
					

					if(empty($_POST['bank'])){
						$error .=  "<li>Vul a.u.b. het IBAN-nummer in!!</li>";
					}

					if(empty($_POST['bsn'])){
						$error .=  "<li>Vul a.u.b. het BSN-nummer in!</li>";
					}
					
					if(empty($error)){ 
					//update database
					
					$wpdb->update( Beheertool, array('Voornaam' => $_POST['voornaam'], 'Tussenvoegsel' => $_POST['tussenvoegsel'], 'Achternaam' => $_POST['achternaam'], 'Geslacht' => $_POST['geslacht'], 'Geboortedatum' => $_POST['geboortedatum'], 'Emailadres' => $_POST['email'], 'Adres' => $_POST['adres'], 'Huisnummer' => $_POST['huisnummer'], 'Postcode' => $_POST['postcode'], 'Woonplaats' => $_POST['woonplaats'], 'Telefoonnummer' => $_POST['telefoonnummer'], 'Mobiel' => $_POST['mobiel'], 'Opleiding' => $_POST['opleiding'], 'Maat' => $_POST['maat'], 'Rijbewijs' => $_POST['rijbewijs'], 'IBAN' => $_POST['bank'], 'Studentnr' => $_POST['studnr'], 'Studiejaar' => $_POST['studiejaar'], 'Vooropleiding' => $_POST['vooropleiding'],'BurgerlijkeStaat' => $_POST['burgerlijkeStaat'], 'BSN' => $_POST['bsn']),array( 'ID' => $studentDetails2->ID )  );
					
					?>
					<div id="s6">
						<div id="succesMobiel">
						Jouw gegevens zijn met succes aangepast!
						</div>
					</div>
						<?php
					}else{ ?>
					<div  id="alert">
						<ul>
							<?php echo $error; ?>
						</ul>
					</div>
					<?php }
					
				}
				
				$studentDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE Perskey = '".$_GET['perskey']."'" );
				$aanmeldingen = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE StudID = '".$studentDetails->ID."' AND ActDate >= '".$datum."' AND Afwezig != 'afwezig' AND Werkt = '1' ORDER BY ActDate ASC" );
				$aanmeldingen2 = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE StudID = '".$studentDetails->ID."' AND ActDate >= '".$datum."' AND Afwezig != 'afwezig' AND Afwezig != 'afwezig2' AND Werkt != '1' ORDER BY ActDate ASC" );
?>
<div id="aanmeldenContent">
<div id="contentMobiel">
		<div class="contentHeaderMobiel">
			<h1>Jouw gegevens</h1>
			<div class="edit">
				<a href="http://www.expect-webmedia.nl/drpr/gegevens/?perskey=<?php echo $_GET['perskey']; ?>&edit=1">Bewerk jouw gegevens</a>
			</div>
		</div>
		<div class="contentContent">
		<?php if(empty($_GET['edit']) || $_POST['aanpassen'] && empty($error)){ ?>
		<div class="cardMobiel">
			<table cellpadding="0" border="0">
				<tr>
					<td width="60" valign="top">Naam</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Voornaam." ".$studentDetails->Tussenvoegsel." ".$studentDetails->Achternaam; ?></td>
				</tr>
				<tr>
					<td>Opleiding</td>
					<td>:</td>
					<td><?php echo $studentDetails->Opleiding; ?></td>
				</tr>
				<tr>
					<td>Studiejaar</td>
					<td>:</td>
					<td><?php echo $studentDetails->Studiejaar; ?></td>
				</tr>
				<tr>
					<td valign="top">Studentennummer</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Studentnr; ?></td>
				</tr>
			</table>		
			</table>		
			</div>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="160">Geslacht</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Geslacht; ?></td>
				</tr>
				<tr>
					<td valign="top">Geboortedatum</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Geboortedatum; ?></td>
				</tr>
				<tr>
					<td valign="top">Adres</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Adres." ".$studentDetails->Huisnummer; ?></td>
				</tr>
				<tr>
					<td valign="top">Postcode en Woonplaats</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Postcode." ".$studentDetails->Woonplaats; ?></td>
				</tr>
				<tr>
					<td valign="top">Telefoonnummer</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Telefoonnummer; ?></td>
				</tr>
				<tr>
					<td valign="top">Mobiel</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Mobiel; ?></td>
				</tr>
				<tr>
					<td valign="top">E-mailadres</td>
					<td valign="top">:</td>
					<td valign="top"><a href="mailto:<?php echo $studentDetails->Emailadres; ?>"><?php echo $studentDetails->Emailadres; ?></a></td>
				</tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="160">Vooropleiding</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Vooropleiding; ?></td>
				</tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="160">Maat T-shirt</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Maat; ?></td>
				</tr>
				<tr>
					<td valign="top">Rijbewijs</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Rijbewijs; ?></td>
				</tr>
			</table>
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="160">IBAN</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->IBAN; ?></td>
				</tr>

				<tr>
					<td valign="top" width="160">BSN-nummer</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->BSN; ?></td>
				</tr>
				<tr>
					<td valign="top" width="160">Burgerlijke staat</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->BurgerlijkeStaat; ?></td>
				</tr>
				<tr>
					<td valign="top">Loonheffing</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Loonheffing; ?></td>
				</tr>
				<tr>
					<td valign="top">Ingang loonheffing</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Ingang_loonheffing; ?></td>
				</tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top">Type overeenkomst</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Type_overeenkomst; ?></td>
				</tr>
				<tr>
					<td valign="top">Periode overeenkomst</td>
					<td valign="top">:</td>
					<td valign="top"><?php mooiedatum2($studentDetails->Contract_van); ?> - <?php mooiedatum2($studentDetails->Contract_tot); ?></td>
				</tr>
				<tr>
					<td valign="top">Afwezig van</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(!empty($studentDetails->Afwezig_van)){ echo date("d-m-Y", strtotime($studentDetails->Afwezig_van)); } ?></td>
				</tr>
				<tr>
					<td valign="top">Afwezig tot</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(!empty($studentDetails->Afwezig_tot)){ echo date("d-m-Y", strtotime($studentDetails->Afwezig_tot)); } ?></td>
				</tr>
				</table>
				<?php } 
				
				if(!$_POST['aanpassen'] && !empty($_GET['edit']) || $_POST['aanpassen'] && !empty($error) ){
				?>
				<form action="" method="post" enctype="multipart/form-data">
				<br />
				Voornaam *<br />
				<input type="text" name="voornaam" value="<?php if( empty($_POST['voornaam']) ) { echo $studentDetails->Voornaam; }else{ echo $_POST['voornaam']; } ?>" /><br /><br />

				Tussenvoegsel <br />
				<input type="text" name="tussenvoegsel" value="<?php if( empty($_POST['tussenvoegsel']) ) { echo $studentDetails->Tussenvoegsel; }else{ echo $_POST['tussenvoegsel']; } ?>" /><br /><br />

				Achternaam *<br />
				<input type="text" name="achternaam" value="<?php if( empty($_POST['achternaam']) ) { echo $studentDetails->Achternaam; }else{ echo $_POST['achternaam']; } ?>" /><br /><br />

				Geslacht *<br />
				<select name="geslacht">
					<option value="mannelijk" <?php if( empty($_POST['geslacht']) && $studentDetails->Geslacht == "mannelijk" ){ ?>selected="selected"<?php } if( $_POST['geslacht'] == "mannelijk" ){ ?>selected="selected"<?php }  ?>>Mannelijk</option>
					<option value="vrouwelijk" <?php if( empty($_POST['geslacht']) && $studentDetails->Geslacht == "vrouwelijk" ){ ?>selected="selected"<?php } if( $_POST['geslacht'] == "vrouwelijk" ){ ?>selected="selected"<?php }  ?>>Vrouwelijk</option>
				</select><br /><br />
				Geboortedatum (mm-dd-jjjj)*<br />
				<input type="text" name="geboortedatum" value="<?php if( empty($_POST['geboortedatum']) ) { echo $studentDetails->Geboortedatum; }else{ echo $_POST['geboortedatum']; } ?>" /><br /><br />
				E-mailadres *<br />
				<input type="text" name="email" value="<?php if( empty($_POST['email']) ) { echo $studentDetails->Emailadres; }else{ echo $_POST['email']; } ?>" /><br /><br />
				Adres *<br />
				<input type="text" name="adres" value="<?php if( empty($_POST['adres']) ) { echo $studentDetails->Adres; }else{ echo $_POST['adres']; } ?>" /><br /><br />
				Huisnummer*<br />
				<input type="text" name="huisnummer" value="<?php if( empty($_POST['huisnummer']) ) { echo $studentDetails->Huisnummer; }else{ echo $_POST['huisnummer']; } ?>" /><br /><br />
				Postcode*<br />
				<input type="text" name="postcode" value="<?php if( empty($_POST['postcode']) ) { echo $studentDetails->Postcode; }else{ echo $_POST['postcode']; } ?>" /><br /><br />
				Woonplaats*<br />
				<input type="text" name="woonplaats" value="<?php if( empty($_POST['woonplaats']) ) { echo $studentDetails->Woonplaats; }else{ echo $_POST['woonplaats']; } ?>" /><br /><br />
				Telefoonnummer*<br />
				<input type="text" name="telefoonnummer" value="<?php if( empty($_POST['telefoonnummer']) ) { echo $studentDetails->Telefoonnummer; }else{ echo $_POST['telefoonnummer']; } ?>" /><br /><br />
				Mobiele telefoon*<br />
				<input type="text" name="mobiel" value="<?php if( empty($_POST['mobiel']) ) { echo $studentDetails->Mobiel; }else{ echo $_POST['mobiel']; } ?>" /><br /><br />
				Studentennummer*<br />
				<input type="text" name="studnr" value="<?php if( empty($_POST['studnr']) ) { echo $studentDetails->Studentnr; }else{ echo $_POST['studnr']; } ?>" /><br /><br />
				Opleiding*<br />
				<select name="opleiding">
					<option value="Accountancy" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Accountancy" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Accountancy" ){ ?>selected="selected"<?php }  ?> >Accountancy</option>   
					<option value="Bedrijfseconomie" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Bedrijfseconomie" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Bedrijfseconomie" ){ ?>selected="selected"<?php }  ?> >Bedrijfseconomie</option>     
					<option value="Bedrijfseconomie (AD)" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Bedrijfseconomie (AD)" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Bedrijfseconomie (AD)" ){ ?>selected="selected"<?php }  ?> >Bedrijfseconomie (AD)</option>     
					<option value="Bedrijfskunde-MER" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Bedrijfskunde-MER" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Bedrijfskunde-MER" ){ ?>selected="selected"<?php }  ?> >Bedrijfskunde-MER</option>     
					<option value="Bedrijfswiskunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Bedrijfswiskunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Bedrijfswiskunde" ){ ?>selected="selected"<?php }  ?> >Bedrijfswiskunde</option>     
					<option value="Bestuurskunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Bestuurskunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Bestuurskunde" ){ ?>selected="selected"<?php }  ?> >Bestuurskunde</option>     
					<option value="Bouwkunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Bouwkunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Bouwkunde" ){ ?>selected="selected"<?php }  ?> >Bouwkunde</option>     
					<option value="Business IT en Management" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Business IT en Management" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Business IT en Management" ){ ?>selected="selected"<?php }  ?> >Business IT &amp; Management</option>     
					<option value="Civiele Techniek" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Civiele Techniek" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Civiele Techniek" ){ ?>selected="selected"<?php }  ?> >Civiele Techniek</option>     
					<option value="Commerciele Economie" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Commerciele Economie" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Commerciele Economie" ){ ?>selected="selected"<?php }  ?> >Commerci&euml;le Economie</option>     
					<option value="Communicatie" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Communicatie" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Communicatie" ){ ?>selected="selected"<?php }  ?> >Communicatie</option>     
					<option value="Communications en Multimedia Design" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Communications en Multimedia Design" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Communications en Multimedia Design" ){ ?>selected="selected"<?php }  ?> >Communications &amp; Multimedia Design</option>     
					<option value="Culturele en Maatschappelijke Vorming" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Culturele en Maatschappelijke Vorming" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Culturele en Maatschappelijke Vorming" ){ ?>selected="selected"<?php }  ?> >Culturele en Maatschappelijke Vorming</option>     
					<option value="Docent Beeldende Kunst en Vormgeving" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Docent Beeldende Kunst en Vormgeving" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Docent Beeldende Kunst en Vormgeving" ){ ?>selected="selected"<?php }  ?> >Docent Beeldende Kunst en Vormgeving</option>     
					<option value="Docent Theater" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Docent Theater" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Docent Theater" ){ ?>selected="selected"<?php }  ?> >Docent Theater</option>     
					<option value="Elektrotechniek" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Elektrotechniek" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Elektrotechniek" ){ ?>selected="selected"<?php }  ?> >Elektrotechniek</option>     
					<option value="European Studies" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "European Studies" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "European Studies" ){ ?>selected="selected"<?php }  ?> >European Studies</option>     
					<option value="Financial Services Management" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Financial Services Management" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Financial Services Management" ){ ?>selected="selected"<?php }  ?> >Financial Services Management</option>     
					<option value="HBO-Rechten" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "HBO-Rechten" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "HBO-Rechten" ){ ?>selected="selected"<?php }  ?> >HBO-Rechten</option>     
					<option value="Human Resource Managament (AD)" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Human Resource Managament (AD)" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Human Resource Managament (AD)" ){ ?>selected="selected"<?php }  ?> >Human Resource Managament (AD)</option>     
					<option value="Human Resource Management" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Human Resource Management" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Human Resource Management" ){ ?>selected="selected"<?php }  ?> >Human Resource Management</option>     
					<option value="International Business en Languages" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "International Business en Languages" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "International Business en Languages" ){ ?>selected="selected"<?php }  ?> >International Business &amp; Languages</option>     
					<option value="Informatica" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Informatica" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Informatica" ){ ?>selected="selected"<?php }  ?> >Informatica</option>     
					<option value="Integrale veiligheid" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Integrale veiligheid" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Integrale veiligheid" ){ ?>selected="selected"<?php }  ?> >Integrale veiligheid</option>     
					<option value="IT service Management (AD)" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "IT service Management (AD)" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "IT service Management (AD)" ){ ?>selected="selected"<?php }  ?> >IT service Management (AD)</option>     
					<option value="Leraar Aardrijkskunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Aardrijkskunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Aardrijkskunde" ){ ?>selected="selected"<?php }  ?> >Leraar Aardrijkskunde</option>     
					<option value="Leraar Algemene/Bedrijfseconomie" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Algemene/Bedrijfseconomie" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Algemene/Bedrijfseconomie" ){ ?>selected="selected"<?php }  ?> >Leraar Algemene/Bedrijfseconomie</option>     
					<option value="Leraar Basisonderwijs" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Basisonderwijs" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Basisonderwijs" ){ ?>selected="selected"<?php }  ?> >Leraar Basisonderwijs</option>     
					<option value="Leraar Duits" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Duits" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Duits" ){ ?>selected="selected"<?php }  ?> >Leraar Duits</option>     
					<option value="Leraar Engels" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Engels" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Engels" ){ ?>selected="selected"<?php }  ?> >Leraar Engels</option>     
					<option value="Leraar Exacte Vakken" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Exacte Vakken" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Exacte Vakken" ){ ?>selected="selected"<?php }  ?> >Leraar Exacte Vakken</option>     
					<option value="Leraar Frans" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Frans" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Frans" ){ ?>selected="selected"<?php }  ?> >Leraar Frans</option>     
					<option value="Leraar Fries" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Fries" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Fries" ){ ?>selected="selected"<?php }  ?> >Leraar Fries</option>     
					<option value="Leraar Geschiedenis" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Geschiedenis" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Geschiedenis" ){ ?>selected="selected"<?php }  ?> >Leraar Geschiedenis</option>     
					<option value="Leraar Gezondheidszorg en Welzijn" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Gezondheidszorg en Welzijn" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Gezondheidszorg en Welzijn" ){ ?>selected="selected"<?php }  ?> >Leraar Gezondheidszorg &amp; Welzijn</option>     
					<option value="Leraar Maatschappijleer" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Maatschappijleer" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Maatschappijleer" ){ ?>selected="selected"<?php }  ?> >Leraar Maatschappijleer</option>     
					<option value="Leraar Nederlands" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Nederlands" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Nederlands" ){ ?>selected="selected"<?php }  ?> >Leraar Nederlands</option>     
					<option value="Maatschappelijk Werk en Dienstverlening" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Maatschappelijk Werk en Dienstverlening" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Maatschappelijk Werk en Dienstverlening" ){ ?>selected="selected"<?php }  ?> >Maatschappelijk Werk en Dienstverlening</option>     
					<option value="Maritiem Officier/Ocean Technology" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Maritiem Officier/Ocean Technology" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Maritiem Officier/Ocean Technology" ){ ?>selected="selected"<?php }  ?> >Maritiem Officier/Ocean Technology</option>     
					<option value="Mobiliteit" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Mobiliteit" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Mobiliteit" ){ ?>selected="selected"<?php }  ?> >Mobiliteit</option>     
					<option value="Pedagogiek" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Pedagogiek" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Pedagogiek" ){ ?>selected="selected"<?php }  ?> >Pedagogiek</option>     
					<option value="Scheepsbouwkunde (AD)" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Scheepsbouwkunde (AD)" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Scheepsbouwkunde (AD)" ){ ?>selected="selected"<?php }  ?> >Scheepsbouwkunde (AD)</option>     
					<option value="Scheepsbouwkunde (MT)" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Scheepsbouwkunde (MT)" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Scheepsbouwkunde (MT)" ){ ?>selected="selected"<?php }  ?> >Scheepsbouwkunde (MT)</option>     
					<option value="Technische Bedrijfskunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Technische Bedrijfskunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Technische Bedrijfskunde" ){ ?>selected="selected"<?php }  ?> >Technische Bedrijfskunde</option>     
					<option value="Verpleegkunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Verpleegkunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Verpleegkunde" ){ ?>selected="selected"<?php }  ?> >Verpleegkunde</option>     
					<option value="Werktuigbouwkunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Werktuigbouwkunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Werktuigbouwkunde" ){ ?>selected="selected"<?php }  ?> >Werktuigbouwkunde</option>    
				</select>
				<br /><br />
				Studiejaar*<br />
				<select name="studiejaar">
					<option value="1" <?php if( empty($_POST['studiejaar']) && $studentDetails->Studiejaar == "1" ){ ?>selected="selected"<?php } if( $_POST['studiejaar'] == "1" ){ ?>selected="selected"<?php }  ?>>1</option>
					<option value="2" <?php if( empty($_POST['studiejaar']) && $studentDetails->Studiejaar == "2" ){ ?>selected="selected"<?php } if( $_POST['studiejaar'] == "2" ){ ?>selected="selected"<?php }  ?>>2</option>
					<option value="3" <?php if( empty($_POST['studiejaar']) && $studentDetails->Studiejaar == "3" ){ ?>selected="selected"<?php } if( $_POST['studiejaar'] == "3" ){ ?>selected="selected"<?php }  ?>>3</option>
					<option value="4" <?php if( empty($_POST['studiejaar']) && $studentDetails->Studiejaar == "4" ){ ?>selected="selected"<?php } if( $_POST['studiejaar'] == "4" ){ ?>selected="selected"<?php }  ?>>4</option>
				</select><br /><br />
				Vooropleiding*<br />
				<select name="vooropleiding">
					<option value="havo" <?php if( empty($_POST['vooropleiding']) && $studentDetails->Vooropleiding == "havo" ){ ?>selected="selected"<?php } if( $_POST['vooropleiding'] == "havo" ){ ?>selected="selected"<?php }  ?>>havo</option>
					<option value="vwo" <?php if( empty($_POST['vooropleiding']) && $studentDetails->Vooropleiding == "vwo" ){ ?>selected="selected"<?php } if( $_POST['vooropleiding'] == "vwo" ){ ?>selected="selected"<?php }  ?>>vwo</option>
					<option value="mbo" <?php if( empty($_POST['vooropleiding']) && $studentDetails->Vooropleiding == "mbo" ){ ?>selected="selected"<?php } if( $_POST['vooropleiding'] == "mbo" ){ ?>selected="selected"<?php }  ?>>mbo</option>
					<option value="hbo" <?php if( empty($_POST['vooropleiding']) && $studentDetails->Vooropleiding == "hbo" ){ ?>selected="selected"<?php } if( $_POST['vooropleiding'] == "hbo" ){ ?>selected="selected"<?php }  ?>>hbo</option>
				</select><br /><br />
				Maat T-shirt*<br />
				<select name="maat">
					<option value="Small" <?php if( empty($_POST['maat']) && $studentDetails->Maat == "Small" ){ ?>selected="selected"<?php } if( $_POST['maat'] == "Small" ){ ?>selected="selected"<?php }  ?>>Small</option>
					<option value="Medium" <?php if( empty($_POST['maat']) && $studentDetails->Maat == "Medium" ){ ?>selected="selected"<?php } if( $_POST['maat'] == "Medium" ){ ?>selected="selected"<?php }  ?>>Medium</option>
					<option value="Large" <?php if( empty($_POST['maat']) && $studentDetails->Maat == "Large" ){ ?>selected="selected"<?php } if( $_POST['maat'] == "Large" ){ ?>selected="selected"<?php }  ?>>Large</option>
					<option value="Extra large" <?php if( empty($_POST['maat']) && $studentDetails->Maat == "Extra large" ){ ?>selected="selected"<?php } if( $_POST['maat'] == "Extra large" ){ ?>selected="selected"<?php }  ?>>Extra large</option>
				</select><br /><br />
				Heeft Rijbewijs*<br />
				<select name="rijbewijs">
					<option value="Ja" <?php if( empty($_POST['rijbewijs']) && $studentDetails->Rijbewijs == "Ja" ){ ?>selected="selected"<?php } if( $_POST['rijbewijs'] == "Ja" ){ ?>selected="selected"<?php }  ?>>Ja</option>
					<option value="Nee" <?php if( empty($_POST['rijbewijs']) && $studentDetails->Rijbewijs == "Nee" ){ ?>selected="selected"<?php } if( $_POST['rijbewijs'] == "Nee" ){ ?>selected="selected"<?php }  ?>>Nee</option>
				</select><br /><br />
				IBAN Rekeningnummer*<br />
				<input type="text" name="bank" value="<?php if( empty($_POST['bank']) ) { echo $studentDetails->IBAN; }else{ echo $_POST['bank']; } ?>" /><br /><br />
				BSN-nummer*<br />
				<input type="text" name="bsn" value="<?php if( empty($_POST['bsn']) ) { echo $studentDetails->BSN; }else{ echo $_POST['bsn']; } ?>" /><br /><br />
				Burgerlijke Staat*<br />
				<select name="burgerlijkeStaat">
					<option value=" Ongehuwd" <?php if( empty($_POST['burgerlijkeStaat']) && $studentDetails->burgerlijkeStaat == "Ongehuwd" ){ ?>selected="selected"<?php } if( $_POST['burgerlijkeStaat'] == "Ongehuwd" ){ ?>selected="selected"<?php }  ?>>Ongehuwd</option>
					<option value=" Gehuwd" <?php if( empty($_POST['burgerlijkeStaat']) && $studentDetails->burgerlijkeStaat == "Gehuwd" ){ ?>selected="selected"<?php } if( $_POST['burgerlijkeStaat'] == "Gehuwd" ){ ?>selected="selected"<?php }  ?>>Gehuwd</option>
					<option value="Samenwonend" <?php if( empty($_POST['burgerlijkeStaat']) && $studentDetails->burgerlijkeStaat == "Samenwonend" ){ ?>selected="selected"<?php } if( $_POST['burgerlijkeStaat'] == "Samenwonend" ){ ?>selected="selected"<?php }  ?>>Samenwonend</option>
				</select>
				<br/><br/>
				<a href="http://www.expect-webmedia.nl/drpr/gegevens/?perskey=<?php echo $_GET['perskey']; ?>">Annuleren</a><input type="submit" id="submit" name="aanpassen" value="Bijwerken">
			</form>
				<?php } ?>
				
		</div>
		
</div>

<div id="aanmeldenContent">
<div id="contentMobiel">
		<div class="contentHeaderMobiel">
			<h1>Jouw bevestigde aanmeldingen <font style="font-size: 11px;">(Definitief ingedeeld)</font></h1>
		</div>
		<div class="contentContent">
		<table border="0" cellpadding="5" cellspacing="3">
		<?php foreach($aanmeldingen as $aanmelding){ ?>
			<tr >
				<td valign="top" width="130" class="date"> &nbsp;&nbsp;<B><?php activiteitDatum($aanmelding->ActID); ?></B></td>
				<td valign="top"></td>
				<td valign="top"><?php activiteitNaam($aanmelding->ActID); ?></td>
			</tr>
			<?php } 
			
			if(empty($aanmeldingen)){
				echo "Je bent nog nergens definitief voor ingepland";
			}?>
			</table>
		</div>


		<div class="contentHeaderMobiel">
			<h1>Jouw nog onbevestigde aanmeldingen <font style="font-size: 11px;">(Nog niet definitief ingedeeld)</font></h1> 
		</div>
		<div class="contentContent">
		<table border="0" cellpadding="5" cellspacing="3">
		<?php foreach($aanmeldingen2 as $aanmelding2){ ?>
			<tr >
				<td valign="top" width="130" class="date"> &nbsp;&nbsp;<B><?php activiteitDatum($aanmelding2->ActID); ?></B></td>
				<td valign="top"></td>
				<td valign="top" width="300"><?php activiteitNaam($aanmelding2->ActID); ?></td>
				<td valign="top"><a href="http://www.expect-webmedia.nl/drpr/gegevens/?perskey=<?php echo $perskey; ?>&afmelden=1&actID=<?php echo $aanmelding2->ActID; ?>&rowID=<?php echo $aanmelding2->ID; ?>">Afmelden</td>
			</tr>
			<?php } 
			
			if(empty($aanmeldingen2)){
				echo "Je hebt geen onbevestigde aanmeldingen";
			}?>
			</table>
		</div>
		
</div>

<?php
get_footer('kaal');