<?php
/*
Template Name: detailpagina
*/
get_header();  ?>
	<?php
		//gegevens van dreamteamer/promoteamer ophalen
		global $wpdb;
		$studID = $_GET['id'];
				if($_POST['submitAdd']){
					//we gaan kijken of er fouten gemaakt zijn

					//we gaan kijken of de student al voorkomt in het systeem

					$studNr = $_POST['studnr'];

					if($_POST['overeenkomst'] == "keuze" ){
						$error .=  "<li>Vul a.u.b. het type overeenkomst in!</li>";
					}


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

					if($_POST['rondleiding'] == "keuze" ){
						$error .=  "<li>Selecteer a.u.b. of hij/zij een rondleiding kan geven</li>";
					}

					if($_POST['workshop'] == "keuze" ){
						$error .=  "<li>Selecteer a.u.b. of hij/zij een Talentworkshop kan geven</li>";
					}

					if($_POST['fotoklus'] == 'keuze'){
						$error .= "<li>Selecteer a.u.b. of hij/zij kan fotografieklus</li>";
					}

					if($_POST['videoklus'] == 'keuze'){
						$error .= "<li>Selecteer a.u.b. of hij/zij kan helpen bij een videoklus</li>";
					}

					if($_POST['nabelactie'] == 'keuze'){
						$error .= "<li>Selecteer a.u.b. of hij/zij kan helpen bij een nabelactie</li>";
					}

					if($_POST['studiejaar'] == "keuze" ){
						$error .=  "<li>Selecteer a.u.b. studiejaar!</li>";
					}

					if(empty($_POST['bank'])){
						$error .=  "<li>Vul a.u.b. het IBAN-nummer in!!</li>";
					}

					if($_POST['loonheffing'] == "keuze" ){
						$error .=  "<li>Selecteer a.u.b. of hij/zij loonheffing heeft</li>";
					}

					if($_POST['loonheffing'] == "Ja" && empty($_POST['startLoonheffing'])){
						$error .=  "<li>Vul a.u.b. de startdatum van de loonheffing in!</li>";
					}

					if(empty($_POST['contractVan'])){
						$error .=  "<li>Vul a.u.b. de startdatum van het contract in!</li>";
					}

					if(empty($_POST['contractTot'])){
						$error .=  "<li>Vul a.u.b. de einddatum van het contract in!</li>";
					}

					if(empty($_POST['bsn'])){
						$error .=  "<li>Vul a.u.b. het BSN-nummer in!</li>";
					}

				}

				//als formulier verzonden is en er zijn wel fouten dan slaan we de afbeelding op
				if(!empty($error) && !empty($_FILES["file"]["tmp_name"])){

					move_uploaded_file($_FILES["file"]["tmp_name"], "../drpr/wp-content/fotos/". $_FILES["file"]["name"]);

					$imgUrl = "../drpr/wp-content/fotos/". $_FILES["file"]["name"];
					studentafbeelding($imgUrl);
					$tijdelijk = $_FILES["file"]["name"];
				}

				//als formulier verstuurd is en er zijn geen fouten
				if(isset( $_POST['submitAdd'] ) && empty($error)){
					$actief = "";
					$extr = date('m');
					//$persKey = md5(uniqid($extr, true));

					//alleen mailen
					if(!empty($_POST['alleenMailen'])){
						foreach($_POST['alleenMailen'] as $klus){
							$alleenMailen .= ",".$klus;
						}
					}

					$alleenMailen2 = substr($alleenMailen, 1);


					///Wanneer er geen fouten zijn gemaakt en het veld file is wel gevuld
					if(!empty($_FILES["file"]["tmp_name"])){
						$cache = date('Ys');
						$temp = explode(".",$_FILES["file"]["name"]);
						$bestandNaam  = $_POST['studnr'].$cache.'.' .end($temp);
						move_uploaded_file($_FILES["file"]["tmp_name"], "../drpr/wp-content/fotos/". $bestandNaam);
						$imgUrl = "../drpr/wp-content/fotos/". $bestandNaam;
						studentafbeelding($imgUrl);

					}

					///Wanneer er een fout is geweest en de foto in het tijdelijke veld is opgeslagen
					if(!empty($_POST['tijdelijk']) && empty($_POST['file'])){
						$temp = explode(".",$_POST['tijdelijk']);
						$cache = date('Ys');
						//rename("../drpr/wp-content/fotos/". $_POST['tijdelijk'], "../drpr/wp-content/fotos/". $bestandNaam);
						$bestandNaam  = $_POST['studnr'].$cache. '.' .end($temp);
						$imgUrl = "../drpr/wp-content/fotos/". $_POST['tijdelijk'];
						studentafbeeldingRename($imgUrl,$bestandNaam);
					}

					if(!empty($bestandNaam)){
					$afwezigV = date("Ymd", strtotime($_POST['afwezigVan']));
					$afwezigT = date("Ymd", strtotime($_POST['afwezigTot']));
					$wpdb->update( Beheertool, array( 'Type_overeenkomst' => $_POST['overeenkomst'], 'Voornaam' => $_POST['voornaam'], 'Tussenvoegsel' => $_POST['tussenvoegsel'], 'Achternaam' => $_POST['achternaam'], 'Geslacht' => $_POST['geslacht'], 'Opdrachtnummer' => $_POST['opdrachtNummer'], 'Geboortedatum' => $_POST['geboortedatum'], 'Emailadres' => $_POST['email'], 'Adres' => $_POST['adres'], 'Huisnummer' => $_POST['huisnummer'], 'Postcode' => $_POST['postcode'], 'Woonplaats' => $_POST['woonplaats'], 'Telefoonnummer' => $_POST['telefoonnummer'], 'Mobiel' => $_POST['mobiel'], 'Opleiding' => $_POST['opleiding'], 'Maat' => $_POST['maat'], 'Rijbewijs' => $_POST['rijbewijs'], 'Afwezig_van' => $afwezigV, 'Afwezig_tot' => $afwezigT, 'Opmerkingen' => $_POST['opmerkingen'], 'IBAN' => $_POST['bank'], 'Studentnr' => $_POST['studnr'], 'Studiejaar' => $_POST['studiejaar'], 'Loonheffing' => $_POST['loonheffing'], 'Talentworkshop' => $_POST['workshop'], 'OnlineVraagstuk' => $_POST['onlinevraagstuk'], 'WebcareKlus' => $_POST['webcareklus'], 'BrochureKlus' => $_POST['brochureklus'], 'InvoerKlus' => $_POST['invoerklus'], 'FotoKlus' => $_POST['fotoklus'], 'VideoKlus' => $_POST['videoklus'],'NabelActie' => $_POST['nabelactie'], 'Rondleiding' => $_POST['rondleiding'], 'Vooropleiding' => $_POST['vooropleiding'], 'Ingang_loonheffing' => $_POST['startLoonheffing'],'BurgerlijkeStaat' => $_POST['burgerlijkeStaat'], 'Contract_van' => $_POST['contractVan'], 'Contract_tot' => $_POST['contractTot'], 'BSN' => $_POST['bsn'], 'Actief' => $actief, 'Foto' => $bestandNaam, 'alleenMailen' => $alleenMailen2 ),array( 'ID' => $_GET['id'] )  );
					}

					if(empty($bestandNaam)){
					if(!empty($_POST['afwezigVan'])){
					$afwezigV = date("Ymd", strtotime($_POST['afwezigVan']));
					$afwezigT = date("Ymd", strtotime($_POST['afwezigTot']));
					}else{
						$afwezigV = "";
						$afwezigT = "";
					}

					$wpdb->update( Beheertool, array( 'Type_overeenkomst' => $_POST['overeenkomst'], 'Voornaam' => $_POST['voornaam'], 'Tussenvoegsel' => $_POST['tussenvoegsel'], 'Achternaam' => $_POST['achternaam'], 'Geslacht' => $_POST['geslacht'], 'Opdrachtnummer' => $_POST['opdrachtNummer'], 'Geboortedatum' => $_POST['geboortedatum'], 'Emailadres' => $_POST['email'], 'Adres' => $_POST['adres'], 'Huisnummer' => $_POST['huisnummer'], 'Postcode' => $_POST['postcode'], 'Woonplaats' => $_POST['woonplaats'], 'Telefoonnummer' => $_POST['telefoonnummer'], 'Mobiel' => $_POST['mobiel'], 'Opleiding' => $_POST['opleiding'], 'Maat' => $_POST['maat'], 'Rijbewijs' => $_POST['rijbewijs'], 'Afwezig_van' => $afwezigV, 'Afwezig_tot' => $afwezigT, 'Opmerkingen' => $_POST['opmerkingen'], 'IBAN' => $_POST['bank'], 'Studentnr' => $_POST['studnr'], 'Studiejaar' => $_POST['studiejaar'], 'Loonheffing' => $_POST['loonheffing'], 'Talentworkshop' => $_POST['workshop'], 'OnlineVraagstuk' => $_POST['onlinevraagstuk'], 'WebcareKlus' => $_POST['webcareklus'], 'BrochureKlus' => $_POST['brochureklus'], 'InvoerKlus' => $_POST['invoerklus'], 'FotoKlus' => $_POST['fotoklus'], 'VideoKlus' => $_POST['videoklus'], 'NabelActie' => $_POST['nabelactie'], 'Rondleiding' => $_POST['rondleiding'], 'Vooropleiding' => $_POST['vooropleiding'], 'Ingang_loonheffing' => $_POST['startLoonheffing'],'BurgerlijkeStaat' => $_POST['burgerlijkeStaat'], 'Contract_van' => $_POST['contractVan'], 'Contract_tot' => $_POST['contractTot'], 'BSN' => $_POST['bsn'], 'Actief' => $actief, 'alleenMailen' => $alleenMailen2),array( 'ID' => $_GET['id'] )  );
					}


					$succes = "1";

					 }



		$studentDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = $studID" );
	if($_GET['add'] == 'succes'){ ?>
	<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
		<?php echo $studentDetails->Voornaam; ?> is met succes toegevoegd!
	</div>
	<?php }

	if(isset($succes)){ ?>
	<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
		<?php echo $studentDetails->Voornaam; ?> is met succes bijgewerkt!
	</div>
	<?php }
	?>
	<div style="clear: both;"></div>
	<div id="contentLinks">
		<div class="contentHeader">
			<h1>Persoonlijke gegevens</h1>
			<div class="edit"><a href="/drpr/print-werkbriefjes/?userid=<?php echo $studentDetails->ID; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/printWerkbriefje.png" alt="" title="Print blanco werkbriefje"/></a><a href="/drpr/print-contract/?userid=<?php echo $studentDetails->ID; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/printContract.png" alt="" title="Print Contract"/></a><?php if(!isset($_GET['edit'])){ ?><a href="/drpr/detail/?id=<?php echo $studentDetails->ID; ?>&edit=1"><img src="<?php bloginfo('template_url'); ?>/images/edit.png" alt="" title="bewerk de gegevens van <?php echo $studentDetails->Voornaam; ?>"></a><?php } ?><a href="/drpr/dreamteamers-promoteamers/?delete=yes&id=<?php echo $studentDetails->ID; ?>" ><img src="<?php bloginfo('template_url'); ?>/images/iconDelete.png" alt="" title="Verwijder persoon" onclick="return confirm('Weet je zeker dat je deze persoon wilt verwijderen?')"/></a>  </div>
		</div>
		<div class="contentContent">

			<!-- edit formulier -->
			<?php


				if(!empty($_GET['edit']) || !empty($error)){

				//als het formulier verzonden is en er zijn foutmeldingen
				if(!empty($error)){ ?>
					<div id="alert">
						<ul>
							<?php echo $error; ?>
						</ul>
					</div>
					<?php } ?>

			<form action="/drpr/detail/?id=<?php echo $studentDetails->ID; ?>" method="post" enctype="multipart/form-data">
				<br />Type overeenkomst*<br />
				<select name="overeenkomst">
					<option value="Dreamteamer" <?php if( empty($_POST['overeenkomst']) && $studentDetails->Type_overeenkomst == "Dreamteamer" ){ ?>selected="selected"<?php } if( $_POST['overeenkomst'] == "Dreamteamer" ){ ?>selected="selected"<?php }  ?>>Dreamteamer</option>
					<option value="Promoteamer" <?php if( empty($_POST['overeenkomst']) && $studentDetails->Type_overeenkomst == "Promoteamer" ){ ?>selected="selected"<?php } if( $_POST['overeenkomst'] == "Promoteamer" ){ ?>selected="selected"<?php }  ?>>Promoteamer</option>
					<option value="Dreamteamer en Promoteamer" <?php if( empty($_POST['overeenkomst']) && $studentDetails->Type_overeenkomst == "Dreamteamer en Promoteamer" ){ ?>selected="selected"<?php } if( $_POST['overeenkomst'] == "Dreamteamer en Promoteamer" ){ ?>selected="selected"<?php }  ?>>Dreamteamer en Promoteamer</option>
				</select><br /><br />
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

				Opdrachtnummer<br />
				<input type="text" name="opdrachtNummer" value="<?php if( empty($_POST['opdrachtNummer']) ) { echo $studentDetails->Opdrachtnummer; }else{ echo $_POST['opdrachtNummer']; } ?>" /><br /><br />

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
					<option value="Accountancy" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Accountancy" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Accountancy" ){ ?>selected="selected"<?php }  ?>>Accountancy</option>
					<option value="Bedrijfseconomie" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Bedrijfseconomie" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Bedrijfseconomie" ){ ?>selected="selected"<?php }  ?>>Bedrijfseconomie</option>
					<option value="Bedrijfskunde-MER" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Bedrijfskunde-MER" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Bedrijfskunde-MER" ){ ?>selected="selected"<?php }  ?>>Bedrijfskunde-MER</option>
					<option value="Bedrijfswiskunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Bedrijfswiskunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Bedrijfswiskunde" ){ ?>selected="selected"<?php }  ?>>Bedrijfswiskunde</option>
					<option value="Bestuurskunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Bestuurskunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Bestuurskunde" ){ ?>selected="selected"<?php }  ?>>Bestuurskunde</option>
					<option value="Bouwkunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Bouwkunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Bouwkunde" ){ ?>selected="selected"<?php }  ?>>Bouwkunde</option>
					<option value="Business IT en Management" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Business IT en Management" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Business IT en Management" ){ ?>selected="selected"<?php }  ?>>Business IT &amp; Management</option>
					<option value="Civiele Techniek" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Civiele Techniek" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Civiele Techniek" ){ ?>selected="selected"<?php }  ?>>Civiele Techniek</option>
					<option value="Commerciele Economie" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Commerciele Economie" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Commerciele Economie" ){ ?>selected="selected"<?php }  ?>>Commerci&euml;le Economie</option>
					<option value="Communicatie" <<?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Communicatie" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Communicatie" ){ ?>selected="selected"<?php }  ?>>Communicatie</option>
					<option value="Communications en Multimedia Design" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Communications en Multimedia Design" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Communications en Multimedia Design" ){ ?>selected="selected"<?php }  ?>>Communications &amp; Multimedia Design</option>
					<option value="Culturele en Maatschappelijke Vorming" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Culturele en Maatschappelijke Vorming" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Culturele en Maatschappelijke Vorming" ){ ?>selected="selected"<?php }  ?>>Culturele en Maatschappelijke Vorming</option>
					<option value="Docent Beeldende Kunst en Vormgeving" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Docent Beeldende Kunst en Vormgeving" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Docent Beeldende Kunst en Vormgeving" ){ ?>selected="selected"<?php }  ?>>Docent Beeldende Kunst en Vormgeving</option>
					<option value="Docent Theater" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Docent Theater" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Docent Theater" ){ ?>selected="selected"<?php }  ?>>Docent Theater</option>
					<option value="Elektrotechniek" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Elektrotechniek" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Elektrotechniek" ){ ?>selected="selected"<?php }  ?>>Elektrotechniek</option>
					<option value="European Studies" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "European Studies" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "European Studies" ){ ?>selected="selected"<?php }  ?>>European Studies</option>
					<option value="Financial Services Management" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Financial Services Managements" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Financial Services Management" ){ ?>selected="selected"<?php }  ?>>Financial Services Management</option>
					<option value="HBO-Rechten" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "HBO-Rechten" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "HBO-Rechten" ){ ?>selected="selected"<?php }  ?>>HBO-Rechten</option>
					<option value="Human Resource Management" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Human Resource Management" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Human Resource Management" ){ ?>selected="selected"<?php }  ?>>Human Resource Management</option>
					<option value="International Business en Languages" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "International Business en Languages" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "International Business en Languages" ){ ?>selected="selected"<?php }  ?>>International Business &amp; Languages</option>
					<option value="Informatica" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Informatica" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Informatica" ){ ?>selected="selected"<?php }  ?>>Informatica</option>
					<option value="Integrale veiligheid" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Integrale veiligheid" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Integrale veiligheid" ){ ?>selected="selected"<?php }  ?>>Integrale veiligheid</option>
					<option value="IT service Management (AD)" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "IT service Management (AD)" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "IT service Management (AD)" ){ ?>selected="selected"<?php }  ?>>IT service Management (AD)</option>
					<option value="Leraar Aardrijkskunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Aardrijkskunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Aardrijkskunde" ){ ?>selected="selected"<?php }  ?>>Leraar Aardrijkskunde</option>
					<option value="Leraar Algemene/Bedrijfseconomie"<?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Algemene/Bedrijfseconomie" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Algemene/Bedrijfseconomie" ){ ?>selected="selected"<?php }  ?>>Leraar Algemene/Bedrijfseconomie</option>
					<option value="Leraar Basisonderwijs" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Basisonderwijs" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Basisonderwijs" ){ ?>selected="selected"<?php }  ?>>Leraar Basisonderwijs</option>
                    <option value="Leraar Biologie" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Biologie" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Biologie" ){ ?>selected="selected"<?php }  ?>>Leraar Biologie</option>
					<option value="Leraar Duits" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Duits" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Duits" ){ ?>selected="selected"<?php }  ?>>Leraar Duits</option>
					<option value="Leraar Engels" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Engels" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Engels" ){ ?>selected="selected"<?php }  ?>>Leraar Engels</option>
					<option value="Leraar Frans" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Frans" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Frans" ){ ?>selected="selected"<?php }  ?>>Leraar Frans</option>
					<option value="Leraar Fries" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Fries" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Fries" ){ ?>selected="selected"<?php }  ?>>Leraar Fries</option>
					<option value="Leraar Geschiedenis" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Geschiedenis" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Geschiedenis" ){ ?>selected="selected"<?php }  ?>>Leraar Geschiedenis</option>
					<option value="Leraar Gezondheidszorg en Welzijn" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Gezondheidszorg en Welzijn" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Gezondheidszorg en Welzijn" ){ ?>selected="selected"<?php }  ?>>Leraar Gezondheidszorg &amp; Welzijn</option>
					<option value="Leraar Maatschappijleer"<?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Maatschappijleer" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Maatschappijleer" ){ ?>selected="selected"<?php }  ?>>Leraar Maatschappijleer</option>
                    <option value="Leraar Natuurkunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Natuurkunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Natuurkunde" ){ ?>selected="selected"<?php }  ?>>Leraar Natuurkunde</option>
					<option value="Leraar Nederlands" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Nederlands" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Nederlands" ){ ?>selected="selected"<?php }  ?>>Leraar Nederlands</option>
                    <option value="Leraar Scheikunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Scheikunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Scheikunde" ){ ?>selected="selected"<?php }  ?>>Leraar Scheikunde</option>
                    <option value="Leraar Wiskunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Leraar Wiskunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Leraar Wiskunde" ){ ?>selected="selected"<?php }  ?>>Leraar Wiskunde</option>
					<option value="Maatschappelijk Werk en Dienstverlening" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Maatschappelijk Werk en Dienstverlening" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Maatschappelijk Werk en Dienstverlening" ){ ?>selected="selected"<?php }  ?>>Maatschappelijk Werk en Dienstverlening</option>
					<option value="Maritieme Techniek"<?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Maritieme Techniek" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Maritieme Techniek" ){ ?>selected="selected"<?php }  ?>>Maritiem Techniek</option>
					<option value="Mobiliteit" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Mobiliteit" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Mobiliteit" ){ ?>selected="selected"<?php }  ?>>Mobiliteit</option>
					<option value="Pedagogiek" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Pedagogiek" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Pedagogiek" ){ ?>selected="selected"<?php }  ?>>Pedagogiek</option>
					<option value="Technische Bedrijfskunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Technische Bedrijfskunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Technische Bedrijfskunde" ){ ?>selected="selected"<?php }  ?>>Technische Bedrijfskunde</option>
					<option value="Toegepaste Wiskunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Toegepaste Wiskunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Toegepaste Wiskunde" ){ ?>selected="selected"<?php }  ?>>Toegepaste Wiskunde</option>
					<option value="Verpleegkunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Verpleegkunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Verpleegkunde" ){ ?>selected="selected"<?php }  ?>>Verpleegkunde</option>
					<option value="Werktuigbouwkunde" <?php if( empty($_POST['opleiding']) && $studentDetails->Opleiding == "Werktuigbouwkunde" ){ ?>selected="selected"<?php } if( $_POST['opleiding'] == "Werktuigbouwkunde" ){ ?>selected="selected"<?php }  ?>>Werktuigbouwkunde</option>
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
				Kan rondleiding geven*<br />
				<select name="rondleiding">
					<option value="Ja" <?php if( empty($_POST['rondleiding']) && $studentDetails->Rondleiding == "Ja" ){ ?>selected="selected"<?php } if( $_POST['rondleiding'] == "Ja" ){ ?>selected="selected"<?php }  ?>>Ja</option>
					<option value="Nee" <?php if( empty($_POST['rondleiding']) && $studentDetails->Rondleiding == "Nee" ){ ?>selected="selected"<?php } if( $_POST['rondleiding'] == "Nee" ){ ?>selected="selected"<?php }  ?>>Nee</option>
				</select><br /><br />
				Kan Talentworkshop geven*<br />
				<select name="workshop">
					<option value="Ja" <?php if( empty($_POST['workshop']) && $studentDetails->Talentworkshop == "Ja" ){ ?>selected="selected"<?php } if( $_POST['workshop'] == "Ja" ){ ?>selected="selected"<?php }  ?>>Ja</option>
					<option value="Nee" <?php if( empty($_POST['workshop']) && $studentDetails->Talentworkshop == "Nee" ){ ?>selected="selected"<?php } if( $_POST['workshop'] == "Nee" ){ ?>selected="selected"<?php }  ?>>Nee</option>
				</select><br /><br />




                    Kan helpen bij online vraagstuk<br />
                    <select name="onlinevraagstuk">
						<option value="Ja" <?php if( empty($_POST['onlinevraagstuk']) && $studentDetails->OnlineVraagstuk == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if( empty($_POST['onlinevraagstuk']) && $studentDetails->OnlineVraagstuk === "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />

                     Kan helpen bij webcareklus<br />

                    <select name="webcareklus">
						<option value="Ja" <?php if( empty($_POST['webcareklus']) && $studentDetails->WebcareKlus == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if( empty($_POST['webcareklus']) && $studentDetails->WebcareKlus == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />

                    Kan helpen bij brochureklus<br />

                    <select name="brochureklus">
						<option value="Ja" <?php if( empty($_POST['brochureklus']) && $studentDetails->BrochureKlus == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if( empty($_POST['brochureklus']) && $studentDetails->BrochureKlus == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />
                    Kan helpen bij invoerklus<br />
                      <select name="invoerklus">
						<option value="Ja" <?php if( empty($_POST['invoerklus']) && $studentDetails->InvoerKlus == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if( empty($_POST['invoerklus']) && $studentDetails->InvoerKlus == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />

                         Kan helpen bij fotografieklus<br />
                      <select name="fotoklus">
						<option value="Ja" <?php if( empty($_POST['fotoklus']) && $studentDetails->FotoKlus == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if( empty($_POST['fotoklus']) && $studentDetails->FotoKlus == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />


                         Kan helpen bij videoklus<br />
                      <select name="videoklus">
						<option value="Ja" <?php if( empty($_POST['videoklus']) && $studentDetails->VideoKlus == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if( empty($_POST['videoklus']) && $studentDetails->VideoKlus == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />

                      Kan helpen bij nabelactie<br />
                      <select name="nabelactie">
						<option value="Ja" <?php if( empty($_POST['nabelactie']) && $studentDetails->NabelActie == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if( empty($_POST['nabelactie']) && $studentDetails->NabelActie == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />

					Alleen mailen voor:<br />
					<?php
					if(!$_POST['submitAdd']){
					$alleenVoorKlussen = explode(",", $studentDetails->alleenMailen);
					}else{
						$alleenVoorKlussen = explode(",", $_POST['alleenMailen']);
					}
					?>
					<table cellspacing="0" cellpadding="0" border="0">

					<tr>
						<td>
							<input type="checkbox" name="alleenMailen[]" value="onlineVraagStuk" id="onlineVraagStuk" <?php if(in_array('onlineVraagStuk', $alleenVoorKlussen)){ echo "checked";} ?>>
						</td>
						<td>
							<label for="onlineVraagStuk">Online vraagstuk</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" name="alleenMailen[]" value="webcareKlus" id="webcareKlus" style="" <?php if(in_array('webcareKlus', $alleenVoorKlussen)){ echo "checked";} ?>>
						</td>
						<td>
							<label for="webcareKlus">Webcareklus</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" name="alleenMailen[]" value="brochureKlus" id="brochureKlus" style="" <?php if(in_array('brochureKlus', $alleenVoorKlussen)){ echo "checked";} ?>>
						</td>
						<td>
							<label for="brochureKlus">Brochureklus</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" name="alleenMailen[]" value="invoerKlus" id="invoerKlus" style="" <?php if(in_array('invoerKlus', $alleenVoorKlussen)){ echo "checked";} ?>>
						</td>
						<td>
							<label for="invoerKlus">Invoerklus</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" name="alleenMailen[]" value="fotografieKlus" id="fotografieKlus" style="" <?php if(in_array('fotografieKlus', $alleenVoorKlussen)){ echo "checked";} ?>>
						</td>
						<td>
							<label for="fotografieKlus">Fotografieklus</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" name="alleenMailen[]" value="videoKlus" id="videoKlus" style="" <?php if(in_array('videoKlus', $alleenVoorKlussen)){ echo "checked";} ?>>
						</td>
						<td>
							<label for="videoKlus">VideoKlus</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" name="alleenMailen[]" value="nabelActie" id="nabelActie" style="" <?php if(in_array('nabelActie', $alleenVoorKlussen)){ echo "checked";} ?>>
						</td>
						<td>
							<label for="nabelActie">Nabelactie</label>
						</td>
					</tr>
					</table>


				Afwezig van<br />
				<input type="text" name="afwezigVan" id="range_example_1_start" value="<?php if( empty($_POST['afwezigVan']) ) { if(!empty($studentDetails->Afwezig_van)){ echo date("d-m-Y", strtotime($studentDetails->Afwezig_van)); } }else{ echo date("d-m-Y", strtotime($_POST['afwezigVan'])); } ?>" /><br /><br />

				Afwezig tot<br />
				<input type="text" name="afwezigTot" id="range_example_1_end" value="<?php if( empty($_POST['afwezigTot']) ) { if(!empty($studentDetails->Afwezig_tot)){ echo date("d-m-Y", strtotime($studentDetails->Afwezig_tot)); } }else{ echo date("d-m-Y", strtotime($_POST['afwezigTot'])); } ?>" /><br /><br />
				IBAN Rekeningnummer*<br />
				<input type="text" name="bank" value="<?php if( empty($_POST['bank']) ) { echo $studentDetails->IBAN; }else{ echo $_POST['bank']; } ?>" /><br /><br />
				Loonheffing*<br />
				<select name="loonheffing">
					<option value="Ja" <?php if( empty($_POST['loonheffing']) && $studentDetails->Loonheffing == "Ja" ){ ?>selected="selected"<?php } if( $_POST['loonheffing'] == "Ja" ){ ?>selected="selected"<?php }  ?>>Ja</option>
					<option value="Nee" <?php if( empty($_POST['loonheffing']) && $studentDetails->Loonheffing == "Nee" ){ ?>selected="selected"<?php } if( $_POST['loonheffing'] == "Nee" ){ ?>selected="selected"<?php }  ?>>Nee</option>
				</select><br /><br />
				Ingang loonheffing<br />
				<input type="text" name="startLoonheffing" id="datum" value="<?php if( empty($_POST['startLoonheffing']) ) { echo $studentDetails->Ingang_loonheffing; }else{ echo $_POST['startLoonheffing']; } ?>" /><br /><br />
				Contract vanaf*<br />
				<input type="text" name="contractVan" id="range_example_1_start2" value="<?php if( empty($_POST['contractVan']) ) { echo $studentDetails->Contract_van; }else{ echo $_POST['contractVan']; } ?>" /><br /><br />
				Contract tot*<br />
				<input type="text" name="contractTot" id="range_example_1_end2" value="<?php if( empty($_POST['contractTot']) ) { echo $studentDetails->Contract_tot; }else{ echo $_POST['contractTot']; } ?>" /><br /><br />
				BSN-nummer*<br />
				<input type="text" name="bsn" value="<?php if( empty($_POST['bsn']) ) { echo $studentDetails->BSN; }else{ echo $_POST['bsn']; } ?>" /><br /><br />
				Burgerlijke Staat*<br />
				<select name="burgerlijkeStaat">
					<option value=" Ongehuwd" <?php if( empty($_POST['burgerlijkeStaat']) && $studentDetails->burgerlijkeStaat == "Ongehuwd" ){ ?>selected="selected"<?php } if( $_POST['burgerlijkeStaat'] == "Ongehuwd" ){ ?>selected="selected"<?php }  ?>>Ongehuwd</option>
					<option value=" Gehuwd" <?php if( empty($_POST['burgerlijkeStaat']) && $studentDetails->burgerlijkeStaat == "Gehuwd" ){ ?>selected="selected"<?php } if( $_POST['burgerlijkeStaat'] == "Gehuwd" ){ ?>selected="selected"<?php }  ?>>Gehuwd</option>
					<option value="Samenwonend" <?php if( empty($_POST['burgerlijkeStaat']) && $studentDetails->burgerlijkeStaat == "Samenwonend" ){ ?>selected="selected"<?php } if( $_POST['burgerlijkeStaat'] == "Samenwonend" ){ ?>selected="selected"<?php }  ?>>Samenwonend</option>
				</select><br /><br />
				Foto<br />
				<?php
				if(!empty($studentDetails->Foto)){ ?>
					<img src="https://www.expect-webmedia.nl/drpr/wp-content/fotos/<?php echo $studentDetails->Foto; ?>">
				<?php } ?>
				<input type="file" name="file" id="file" value="<?php echo $_POST['file']; ?>"`>
				<input type="hidden" name="tijdelijk" value="<?php if(empty($tijdelijk)){ echo $_POST['tijdelijk']; }else { echo $tijdelijk; } ?>">
				<br/><br/>
				Eventuele opmerkingen<br />
				<textarea name="opmerkingen"><?php if( empty($_POST['opmerkingen']) ) { echo $studentDetails->Opmerkingen; }else{ echo $_POST['opmerkingen']; } ?></textarea><br /><br />
				<a href="/drpr/detail/?id=<?php  echo $studentDetails->ID; ?>">Annuleren</a><input type="submit" id="submit" name="submitAdd" value="Bijwerken">
			</form><br /><br /></div>

			<?php }else { ?>





		<div class="card">
			<table cellpadding="0" border="0">
				<tr>
					<td width="100" valign="top"><?php studentFoto($studentDetails->ID); ?></td>
					<td>
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
					</td>
				</tr>
			</table>
		</div>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="160">Geslacht</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Geslacht; ?></td>
				</tr>
				<tr>
					<td valign="top">Leeftijd</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo leeftijd($studentDetails->Geboortedatum); ?> Jaar</td>
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
				<tr>
					<td valign="top">Opdrachtnummer</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Opdrachtnummer; ?></td>
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
				<tr>
					<td valign="top">Uurtarief</td>
					<td valign="top">:</td>
					<td valign="top">&euro; <?php echo uurTarief(leeftijd($studentDetails->Geboortedatum)); ?></td>
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
					<td valign="top" width="160">Actief</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Actief; ?></td>
				</tr>
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
					<td valign="top"><?php if(!empty($studentDetails->Afwezig_van)){ echo date("d-m-Y", strtotime($studentDetails->Afwezig_van));} ?></td>
				</tr>
				<tr>
					<td valign="top">Afwezig tot</td>
					<td valign="top">:</td>
					<td valign="top"><?php if(!empty($studentDetails->Afwezig_tot)){echo date("d-m-Y", strtotime($studentDetails->Afwezig_tot));} ?></td>
				</tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="160">Kan talentworkshop geven</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Talentworkshop; ?></td>
				</tr>
				<tr>
					<td valign="top">Kan rondleiding geven</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Rondleiding; ?></td>
				</tr>

                <tr>
					<td valign="top" width="130">Kan helpen bij online vraagstuk</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->OnlineVraagstuk; ?></td>
				</tr>

                <tr>
					<td valign="top" width="130">Kan helpen bij webcareklus</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->WebcareKlus; ?></td>
				</tr>
                 <tr>
					<td valign="top" width="130">Kan helpen bij brochureklus</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->BrochureKlus; ?></td>
				</tr>

                <tr>
					<td valign="top" width="130">Kan helpen bij invoerklus</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->InvoerKlus; ?></td>
				</tr>

                  <tr>
					<td valign="top" width="130">Kan helpen bij fotografieklus</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->FotoKlus; ?></td>
				</tr>

                   <tr>
					<td valign="top" width="130">Kan helpen bij videoklus</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->VideoKlus; ?></td>
				</tr>
                    <tr>
					<td valign="top" width="130">Kan helpen bij nabelactie</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->NabelActie; ?></td>
				</tr>
				</tr>
                    <tr>
					<td valign="top" width="130">Alleen e-mailen voor</td>
					<td valign="top">:</td>
					<td valign="top">
					<ul>
					<?php
					   $alleenMailer = explode(',', $studentDetails->alleenMailen);
						foreach($alleenMailer as $alleen){ ?>
						<li><?php echo $alleen; ?></li>
						<?php }
					?>
					</ul>
					</td>
				</tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top"  width="160">Opmerkingen</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $studentDetails->Opmerkingen; ?></td>
				</tr>
			</table>
		</div>
		<?php } ?>
	</div>

	<div id="contentRechts">
		<div class="contentHeaderActief">
			<h1>Komende activiteiten</h1>
		</div>
		<div class="contentContent">
			<table border="0" cellpadding="5" cellspacing="3">
			<?php
				global $wpdb;
				$datum = date('Ymd');
				$activiteiten = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE StudID = '".$studentDetails->ID."' AND ActDate >= '".$datum."' AND Afwezig != 'afwezig' AND Afwezig != 'afwezig2' AND hoeftNiet !='1' ORDER BY Datum ASC" );
				if(!empty($activiteiten)){
					echo $studentDetails->Voornaam; ?> heeft zich aangemeld voor de volgende activiteiten:<br /><br />
				<?php	}else{
						echo "<br /><br />".$studentDetails->Voornaam." heeft zich nog nergens voor aangemeld!";
					}
				foreach( $activiteiten as $activiteit ){
				?>
				<tr>
					<td valign="top" width="120" class="date"> <B>&nbsp;<?php activiteitDatum($activiteit->ActID); ?></B></td>
					<td valign="top">&nbsp;</td>
					<td valign="top" width="275"><a href="http://www.expect-webmedia.nl/drpr/activiteit-detail?id=<?php echo $activiteit->ActID; ?>" target="_self"><?php activiteitNaam($activiteit->ActID); ?></a></td>
					<td valign="top"><a href="http://www.expect-webmedia.nl/drpr/print-werkbriefjes/?actid=<?php echo $activiteit->ActID; ?>&userid=<?php echo $activiteit->StudID; ?>" target="_blank"><span>print werkbriefje</span></a></td>
				</tr>
				<?php } ?>
			</table>
			<br /><br />
			<table border="0" cellpadding="5" cellspacing="3">
			<?php
					$afwezig = "afwezig";
					$oudeActiviteiten = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE StudID = '".$studentDetails->ID."' AND ActDate < '".$datum." AND Afwezig != '".$afwezig."'  ORDER BY Datum ASC" );
					if(!empty($oudeActiviteiten)){
						echo $studentDetails->Voornaam." heeft gewerkt tijdens onderstaande activiteiten:<br /><br />";
					}
				foreach( $oudeActiviteiten as $oudeActiviteit ){
				?>
				<tr>
					<td valign="top" width="120" class="date"> <B>&nbsp;<?php activiteitDatum($oudeActiviteit->ActID); ?></B></td>
					<td valign="top">&nbsp;</td>
					<td valign="top" width="275"><a href="http://www.expect-webmedia.nl/drpr/activiteit-detail?id=<?php echo $oudeActiviteit->ActID; ?>" target="_self"><?php activiteitNaam($oudeActiviteit->ActID); ?></a></td>
					<td valign="top"><a href="http://www.expect-webmedia.nl/drpr/print-werkbriefjes/?actid=<?php echo $oudeActiviteit->ActID; ?>&userid=<?php echo $oudeActiviteit->StudID; ?>" target="_blank"><span>print werkbriefje</span></a></td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>
	<div id="contentRechts">
		<div class="contentHeaderActief">
			<h1>Voorgaande activiteiten</h1>
		</div>
		<div class="contentContent">
			<table border="0" cellpadding="5" cellspacing="3">
			<?php
				global $wpdb;
				$datum = date('Ymd');
				$activiteiten = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE StudID = '".$studentDetails->ID."' AND ActDate < '".$datum."' AND Afwezig != 'afwezig' AND hoeftNiet !='1' ORDER BY Datum DESC" );
				if(!empty($activiteiten)){

					}else{
						echo "<br /><br />".$studentDetails->Voornaam." heeft zich nog nergens voor aangemeld!";
					}
				foreach( $activiteiten as $activiteit ){
				?>
				<tr>
					<td valign="top" width="120" class="date"> <B>&nbsp;<?php activiteitDatum($activiteit->ActID); ?></B></td>
					<td valign="top">&nbsp;</td>
					<td valign="top" width="275"><a href="http://www.expect-webmedia.nl/drpr/activiteit-detail?id=<?php echo $activiteit->ActID; ?>" target="_self"><?php activiteitNaam($activiteit->ActID); ?></a></td>
					<td valign="top"><a href="http://www.expect-webmedia.nl/drpr/print-werkbriefjes/?actid=<?php echo $activiteit->ActID; ?>&userid=<?php echo $activiteit->StudID; ?>" target="_blank"><span>print werkbriefje</span></a></td>
				</tr>
				<?php } ?>
			</table>
			<br /><br />
			<table border="0" cellpadding="5" cellspacing="3">
			<?php
					$afwezig = "afwezig";
					$oudeActiviteiten = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE StudID = '".$studentDetails->ID."' AND ActDate < '".$datum." AND Afwezig != '".$afwezig."'  ORDER BY Datum ASC" );
					if(!empty($oudeActiviteiten)){
						echo $studentDetails->Voornaam." heeft gewerkt tijdens onderstaande activiteiten:<br /><br />";
					}
				foreach( $oudeActiviteiten as $oudeActiviteit ){
				?>
				<tr>
					<td valign="top" width="120" class="date"> <B>&nbsp;<?php activiteitDatum($oudeActiviteit->ActID); ?></B></td>
					<td valign="top">&nbsp;</td>
					<td valign="top" width="275"><a href="http://www.expect-webmedia.nl/drpr/activiteit-detail?id=<?php echo $oudeActiviteit->ActID; ?>" target="_self"><?php activiteitNaam($oudeActiviteit->ActID); ?></a></td>
					<td valign="top"><a href="http://www.expect-webmedia.nl/drpr/print-werkbriefjes/?actid=<?php echo $oudeActiviteit->ActID; ?>&userid=<?php echo $oudeActiviteit->StudID; ?>" target="_blank"><span>print werkbriefje</span></a></td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>
<?php get_footer(); ?>
