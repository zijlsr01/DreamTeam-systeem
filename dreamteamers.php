<?php  ob_start();
/*
Template Name: Dreamteamers
*/


get_header();

				//connect to the database
				global $wpdb;

				//Export studenten
				if(isset($_GET['export'])){
					 exportExcel();
				}

				if(!empty($_GET['delete']) && !empty($_GET['id']) ){
					$studDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE ID = ".$_GET['id']."" );
						if(!empty($studDetails)){
						$wpdb->query(   "  DELETE FROM Beheertool WHERE ID = ".$_GET['id']." "  );
						$wpdb->query(   "  DELETE FROM Aanmeldingen WHERE StudID = ".$_GET['id']." "  );
						$deleteSucces = "1";
						}
					}

				//als het formulier verzonden is
				if(isset( $_POST['submitAdd'])){

					//we gaan kijken of er fouten gemaakt zijn

					//we gaan kijken of de student al voorkomt in het systeem

					$studNr = $_POST['studnr'];
					$studentDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE Studentnr = $studNr" );
					if(!empty($studentDetails)){
						$error .=  "<li>Student komt al voor in het systeem!</li>";
					}


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

					if($_POST['onlinevraagstuk'] == 'keuze'){
						$error .= "<li>Selecteer a.u.b. of hij/zij kan helpen bij een online vraagstuk</li>";
					}

					if($_POST['webcareklus'] == 'keuze'){
						$error .= "<li>Selecteer a.u.b. of hij/zij kan helpen bij een webcareklus</li>";
					}

					if($_POST['brochureklus'] == 'keuze'){
						$error .= "<li>Selecteer a.u.b. of hij/zij kan helpen bij een brochureklus</li>";
					}

					if($_POST['invoerklus'] == 'keuze'){
						$error .= "<li>Selecteer a.u.b. of hij/zij kan helpen bij een invoerklus</li>";
					}

					if($_POST['fotoklus'] == 'keuze'){
						$error .= "<li>Selecteer a.u.b. of hij/zij kan fotografieklus</li>";
					}

					if($_POST['videoklus'] == 'keuze'){
						$error .= "<li>Selecteer a.u.b. of hij/zij kan helpen bij een videoklus</li>";
					}

					if($_POST['workshop'] == "keuze" ){
						$error .=  "<li>Selecteer a.u.b. of hij/zij een Talentworkshop kan geven</li>";
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

						if($_POST['burgerlijkeStaat'] == "keuze" ){
						$error .=  "<li>Selecteer a.u.b. de burgerlijkestaat</li>";
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
					$persKey = md5(uniqid($extr, true));



					if(empty($tijdelijk)){
						$temp = explode(".",$_FILES["file"]["name"]);
						$bestandNaam  = $_POST['studnr']. '.' .end($temp);
						//move_uploaded_file($_FILES["file"]["tmp_name"], "../drpr/wp-content/fotos/". $bestandNaam);
						//$imgUrl = "../drpr/wp-content/fotos/". $bestandNaam;
						//studentafbeelding($imgUrl);
						//move_uploaded_file($_FILES["file"]["tmp_name"], "../drpr/wp-content/fotos/". $_FILES["file"]["name"]);
						move_uploaded_file($_FILES["file"]["tmp_name"], "../drpr/wp-content/fotos/". $bestandNaam);
						$imgUrl = "../drpr/wp-content/fotos/". $bestandNaam;
						studentafbeelding($imgUrl);

					}


					if(!empty($_POST['tijdelijk']) && empty($_POST['file'])){
						$temp = explode(".",$_POST['tijdelijk']);
						//rename("../drpr/wp-content/fotos/". $_POST['tijdelijk'], "../drpr/wp-content/fotos/". $bestandNaam);
						$bestandNaam  = $_POST['studnr']. '.' .end($temp);
						$imgUrl = "../drpr/wp-content/fotos/". $_POST['tijdelijk'];
						studentafbeeldingRename($imgUrl,$bestandNaam);
					}

					$afwezigV = date("Ymd", strtotime($_POST['afwezigVan']));
					$afwezigT = date("Ymd", strtotime($_POST['afwezigTot']));

					$wpdb->insert( Beheertool, array( 'Type_overeenkomst' => $_POST['overeenkomst'], 'Voornaam' => $_POST['voornaam'], 'Opdrachtnummer' => $_POST['opdrachtNummer'], 'Tussenvoegsel' => $_POST['tussenvoegsel'], 'Achternaam' => $_POST['achternaam'], 'Geslacht' => $_POST['geslacht'], 'Geboortedatum' => $_POST['geboortedatum'], 'Emailadres' => $_POST['email'], 'Adres' => $_POST['adres'], 'Huisnummer' => $_POST['huisnummer'], 'Postcode' => $_POST['postcode'], 'Woonplaats' => $_POST['woonplaats'], 'Telefoonnummer' => $_POST['telefoonnummer'], 'Mobiel' => $_POST['mobiel'], 'Opleiding' => $_POST['opleiding'], 'Maat' => $_POST['maat'], 'Rijbewijs' => $_POST['rijbewijs'], 'Afwezig_van' => $afwezigV, 'Afwezig_tot' => $afwezigT, 'Opmerkingen' => $_POST['opmerkingen'], 'IBAN' => $_POST['bank'], 'Studentnr' => $_POST['studnr'], 'Studiejaar' => $_POST['studiejaar'], 'Loonheffing' => $_POST['loonheffing'], 'Talentworkshop' => $_POST['workshop'], 'Rondleiding' => $_POST['rondleiding'], 'OnlineVraagstuk' => $_POST['onlinevraagstuk'], 'WebcareKlus' => $_POST['webcareklus'], 'BrochureKlus' => $_POST['brochureklus'], 'InvoerKlus' => $_POST['invoerklus'], 'FotoKlus' => $_POST['fotoklus'], 'VideoKlus' => $_POST['videoklus'], 'NabelActie' => $_POST['nabelactie'], 'Vooropleiding' => $_POST['vooropleiding'], 'Ingang_loonheffing' => $_POST['startLoonheffing'],'BurgerlijkeStaat' => $_POST['burgerlijkeStaat'], 'Contract_van' => $_POST['contractVan'], 'Contract_tot' => $_POST['contractTot'], 'BSN' => $_POST['bsn'], 'Actief' => $actief, 'Perskey' => $persKey, 'Foto' => $bestandNaam ) );

					$studNr = $_POST['studnr'];
					$studentDetails = $wpdb->get_row("SELECT * FROM Beheertool WHERE Studentnr = $studNr" );
					$url = "https://www.expect-webmedia.nl/drpr/detail/?id=".$studentDetails->ID;
					wp_redirect( $url.'&add=succes' ); exit;
					 } ?>

					 <?php if(isset($deleteSucces)){ ?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						Persoon met succes verwijderd!
					</div>
					<?php } ?>

					 <?php if(isset($_GET['instel'])){ ?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						Instellingen met succes gewijzigd!
					</div>
					<?php } ?>
					<?php if(isset($_GET['batch'])){ ?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						Contractduur bij alle contracten met succes gewijzigd!
					</div>
					<?php } ?>
				<div style="clear: both;"></div>

			<div id="contentLinks">
				<div class="contentHeaderAdd">
			<h1>Voeg Dream- /Promoteamer toe</h1>
		</div>
		<div class="contentContent">
		<?php


				if(!isset( $_POST['submitAdd'] ) || !empty($error)){

				//als het formulier verzonden is en er zijn foutmeldingen
				if(!empty($error)){ ?>
					<div id="alert">
						<ul>
							<?php echo $error; ?>
						</ul>
					</div>
					<?php } ?>
			<form action="" method="post" enctype="multipart/form-data">
				<br />Type overeenkomst*<br />
				<select name="overeenkomst">
					<option value="keuze" <?php if($_POST['overeenkomst'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="Dreamteamer" <?php if($_POST['overeenkomst'] == "Dreamteamer"){ ?>selected="selected"<?php } ?>>Dreamteamer</option>
					<option value="Promoteamer" <?php if($_POST['overeenkomst'] == "Promoteamer"){ ?>selected="selected"<?php } ?>>Promoteamer</option>
					<option value="Dreamteamer en Promoteamer" <?php if($_POST['overeenkomst'] == "Dreamteamer en Promoteamer"){ ?>selected="selected"<?php } ?>>Dreamteamer en Promoteamer</option>
				</select><br /><br />
				Voornaam *<br />
				<input type="text" name="voornaam" value="<?php echo $_POST['voornaam']; ?>" /><br /><br />

				Tussenvoegsel <br />
				<input type="text" name="tussenvoegsel" value="<?php echo $_POST['tussenvoegsel']; ?>" /><br /><br />

				Achternaam *<br />
				<input type="text" name="achternaam" value="<?php echo $_POST['achternaam']; ?>" /><br /><br />

				Geslacht *<br />
				<select name="geslacht">
					<option value="keuze" <?php if($_POST['geslacht'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="mannelijk" <?php if($_POST['geslacht'] == "mannelijk"){ ?>selected="selected"<?php } ?>>Mannelijk</option>
					<option value="vrouwelijk" <?php if($_POST['geslacht'] == "vrouwelijk"){ ?>selected="selected"<?php } ?>>Vrouwelijk</option>
				</select><br /><br />
				Geboortedatum (mm-dd-jjjj)*<br />
				<input type="text" name="geboortedatum" value="<?php echo $_POST['geboortedatum']; ?>" /><br /><br />
				E-mailadres *<br />
				<input type="text" name="email" value="<?php echo $_POST['email']; ?>" /><br /><br />
				Adres *<br />
				<input type="text" name="adres" value="<?php echo $_POST['adres']; ?>" /><br /><br />
				Huisnummer*<br />
				<input type="text" name="huisnummer" value="<?php echo $_POST['huisnummer']; ?>" /><br /><br />
				Postcode*<br />
				<input type="text" name="postcode" value="<?php echo $_POST['postcode']; ?>" /><br /><br />
				Woonplaats*<br />
				<input type="text" name="woonplaats" value="<?php echo $_POST['woonplaats']; ?>" /><br /><br />
				Telefoonnummer*<br />
				<input type="text" name="telefoonnummer" value="<?php echo $_POST['telefoonnummer']; ?>" /><br /><br />
				Mobiele telefoon*<br />
				<input type="text" name="mobiel" value="<?php echo $_POST['mobiel']; ?>" /><br /><br />
				Studentennummer*<br />
				<input type="text" name="studnr" value="<?php echo $_POST['studnr']; ?>" /><br /><br />
				Opdrachtnummer<br />
				<input type="text" name="opdrachtNummer" value="<?php echo $_POST['opdrachtNummer']; ?>" /><br /><br />
				Opleiding*<br />
				<select name="opleiding">
					<option value="keuze" <?php if($_POST['opleiding'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="Accountancy" <?php if($_POST['opleiding'] == "Accountancy"){ ?>selected="selected"<?php } ?>>Accountancy</option>
					<option value="Bedrijfseconomie" <?php if($_POST['opleiding'] == "Bedrijfseconomie"){ ?>selected="selected"<?php } ?>>Bedrijfseconomie</option>
					<option value="Bedrijfskunde-MER" <?php if($_POST['opleiding'] == "Bedrijfskunde-MER"){ ?>selected="selected"<?php } ?>>Bedrijfskunde-MER</option>
					<option value="Bedrijfswiskunde" <?php if($_POST['opleiding'] == "Bedrijfswiskunde"){ ?>selected="selected"<?php } ?>>Bedrijfswiskunde</option>
					<option value="Bestuurskunde" <?php if($_POST['opleiding'] == "Bestuurskunde"){ ?>selected="selected"<?php } ?>>Bestuurskunde</option>
					<option value="Bouwkunde" <?php if($_POST['opleiding'] == "Bouwkunde"){ ?>selected="selected"<?php } ?>>Bouwkunde</option>
					<option value="Business IT en Management" <?php if($_POST['opleiding'] == "Business IT en Management"){ ?>selected="selected"<?php } ?>>Business IT &amp; Management</option>
					<option value="Civiele Techniek" <?php if($_POST['opleiding'] == "Civiele Techniek"){ ?>selected="selected"<?php } ?>>Civiele Techniek</option>
					<option value="Commerciele Economie" <?php if($_POST['opleiding'] == "Commerciele Economie"){ ?>selected="selected"<?php } ?>>Commerci&euml;le Economie</option>
					<option value="Communicatie" <?php if($_POST['opleiding'] == "Communicatie"){ ?>selected="selected"<?php } ?>>Communicatie</option>
					<option value="Communications en Multimedia Design" <?php if($_POST['opleiding'] == "Communications en Multimedia Design"){ ?>selected="selected"<?php } ?>>Communications &amp; Multimedia Design</option>
					<option value="Culturele en Maatschappelijke Vorming" <?php if($_POST['opleiding'] == "Culturele en Maatschappelijke Vorming"){ ?>selected="selected"<?php } ?>>Culturele en Maatschappelijke Vorming</option>
					<option value="Docent Beeldende Kunst en Vormgeving" <?php if($_POST['opleiding'] == "Docent Beeldende Kunst en Vormgeving"){ ?>selected="selected"<?php } ?>>Docent Beeldende Kunst en Vormgeving</option>
					<option value="Docent Theater" <?php if($_POST['opleiding'] == "Docent Theater"){ ?>selected="selected"<?php } ?>>Docent Theater</option>
					<option value="Elektrotechniek" <?php if($_POST['opleiding'] == "Elektrotechniek"){ ?>selected="selected"<?php } ?>>Elektrotechniek</option>
					<option value="European Studies" <?php if($_POST['opleiding'] == "European Studies"){ ?>selected="selected"<?php } ?>>European Studies</option>
					<option value="Financial Services Management" <?php if($_POST['opleiding'] == "Financial Services Management"){ ?>selected="selected"<?php } ?>>Financial Services Management</option>
					<option value="HBO-Rechten" <?php if($_POST['opleiding'] == "HBO-Rechten"){ ?>selected="selected"<?php } ?>>HBO-Rechten</option>
					<option value="Human Resource Management" <?php if($_POST['opleiding'] == "Human Resource Management"){ ?>selected="selected"<?php } ?>>Human Resource Management</option>
					<option value="International Business en Languages" <?php if($_POST['opleiding'] == "International Business en Languages"){ ?>selected="selected"<?php } ?>>International Business &amp; Languages</option>
					<option value="Informatica" <?php if($_POST['opleiding'] == "Informatica"){ ?>selected="selected"<?php } ?>>Informatica</option>
					<option value="Integrale veiligheid" <?php if($_POST['opleiding'] == "Integrale veiligheid"){ ?>selected="selected"<?php } ?>>Integrale veiligheid</option>
					<option value="IT service Management (AD)" <?php if($_POST['opleiding'] == "IT service Management (AD)"){ ?>selected="selected"<?php } ?>>IT service Management (AD)</option>
					<option value="Leraar Aardrijkskunde" <?php if($_POST['opleiding'] == "Leraar Aardrijkskunde"){ ?>selected="selected"<?php } ?>>Leraar Aardrijkskunde</option>
					<option value="Leraar Algemene/Bedrijfseconomie" <?php if($_POST['opleiding'] == "Leraar Algemene/Bedrijfseconomie"){ ?>selected="selected"<?php } ?>>Leraar Algemene/Bedrijfseconomie</option>
					<option value="Leraar Basisonderwijs" <?php if($_POST['opleiding'] == "Leraar Basisonderwijs"){ ?>selected="selected"<?php } ?>>Leraar Basisonderwijs</option>
                    <option value="Leraar Biologie" <?php if($_POST['opleiding'] == "Leraar Biologie"){ ?>selected="selected"<?php } ?>>Leraar Biologie</option>
					<option value="Leraar Duits" <?php if($_POST['opleiding'] == "Leraar Duits"){ ?>selected="selected"<?php } ?>>Leraar Duits</option>
					<option value="Leraar Engels" <?php if($_POST['opleiding'] == "Leraar Engels"){ ?>selected="selected"<?php } ?>>Leraar Engels</option>
					<option value="Leraar Frans" <?php if($_POST['opleiding'] == "Leraar Frans"){ ?>selected="selected"<?php } ?>>Leraar Frans</option>
					<option value="Leraar Fries" <?php if($_POST['opleiding'] == "Leraar Fries"){ ?>selected="selected"<?php } ?>>Leraar Fries</option>
					<option value="Leraar Geschiedenis" <?php if($_POST['opleiding'] == "Leraar Geschiedenis"){ ?>selected="selected"<?php } ?>>Leraar Geschiedenis</option>
					<option value="Leraar Gezondheidszorg en Welzijn" <?php if($_POST['opleiding'] == "Leraar Gezondheidszorg en Welzijn"){ ?>selected="selected"<?php } ?>>Leraar Gezondheidszorg &amp; Welzijn</option>
					<option value="Leraar Maatschappijleer" <?php if($_POST['opleiding'] == "Leraar Maatschappijleer"){ ?>selected="selected"<?php } ?>>Leraar Maatschappijleer</option>
                    <option value="Leraar Natuurkunde" <?php if($_POST['opleiding'] == "Leraar Natuurkunde"){ ?>selected="selected"<?php } ?>>Leraar Natuurkunde</option>
					<option value="Leraar Nederlands" <?php if($_POST['opleiding'] == "Leraar Nederlands"){ ?>selected="selected"<?php } ?>>Leraar Nederlands</option>
                    <option value="Leraar Scheikunde" <?php if($_POST['opleiding'] == "Leraar Scheikunde"){ ?>selected="selected"<?php } ?>>Leraar Scheikunde</option>
                    <option value="Leraar Wiskunde" <?php if($_POST['opleiding'] == "Leraar Wiskunde"){ ?>selected="selected"<?php } ?>>Leraar Wiskunde</option>
					<option value="Maatschappelijk Werk en Dienstverlening" <?php if($_POST['opleiding'] == "Maatschappelijk Werk en Dienstverlening"){ ?>selected="selected"<?php } ?>>Maatschappelijk Werk en Dienstverlening</option>
					<option value="Maritieme Techniek" <?php if($_POST['opleiding'] == "Maritieme Techniek"){ ?>selected="selected"<?php } ?>>Maritiem Techniek</option>
					<option value="Mobiliteit" <?php if($_POST['opleiding'] == "Mobiliteit"){ ?>selected="selected"<?php } ?>>Mobiliteit</option>
					<option value="Pedagogiek" <?php if($_POST['opleiding'] == "Pedagogiek"){ ?>selected="selected"<?php } ?>>Pedagogiek</option>
					<option value="Technische Bedrijfskunde" <?php if($_POST['opleiding'] == "Technische Bedrijfskunde"){ ?>selected="selected"<?php } ?>>Technische Bedrijfskunde</option>
					<option value="Toegepaste Wiskunde" <?php if($_POST['opleiding'] == "Toegepaste Wiskunde"){ ?>selected="selected"<?php } ?>>Toegepaste Wiskunde</option>
					<option value="Verpleegkunde" <?php if($_POST['opleiding'] == "Verpleegkunde"){ ?>selected="selected"<?php } ?>>Verpleegkunde</option>
					<option value="Werktuigbouwkunde" <?php if($_POST['opleiding'] == "Werktuigbouwkunde"){ ?>selected="selected"<?php } ?>>Werktuigbouwkunde</option>
				</select>

				<br /><br />
				Studiejaar*<br />
				<select name="studiejaar">
					<option value="keuze" <?php if($_POST['studiejaar'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="1" <?php if($_POST['studiejaar'] == "1"){ ?>selected="selected"<?php } ?>>1</option>
					<option value="2" <?php if($_POST['studiejaar'] == "2"){ ?>selected="selected"<?php } ?>>2</option>
					<option value="3" <?php if($_POST['studiejaar'] == "3"){ ?>selected="selected"<?php } ?>>3</option>
					<option value="4" <?php if($_POST['studiejaar'] == "4"){ ?>selected="selected"<?php } ?>>4</option>
				</select><br /><br />
				Vooropleiding*<br />
				<select name="vooropleiding">
					<option value="keuze" <?php if($_POST['vooropleiding'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="havo" <?php if($_POST['vooropleiding'] == "havo"){ ?>selected="selected"<?php } ?>>havo</option>
					<option value="vwo" <?php if($_POST['vooropleiding'] == "vwo"){ ?>selected="selected"<?php } ?>>vwo</option>
					<option value="mbo" <?php if($_POST['vooropleiding'] == "mbo"){ ?>selected="selected"<?php } ?>>mbo</option>
					<option value="hbo" <?php if($_POST['vooropleiding'] == "hbo"){ ?>selected="selected"<?php } ?>>hbo</option>
				</select><br /><br />
				Maat T-shirt*<br />
				<select name="maat">
					<option value="keuze" <?php if($_POST['maat'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="Small" <?php if($_POST['maat'] == "Small"){ ?>selected="selected"<?php } ?>>Small</option>
					<option value="Medium" <?php if($_POST['maat'] == "Medium"){ ?>selected="selected"<?php } ?>>Medium</option>
					<option value="Large" <?php if($_POST['maat'] == "Large"){ ?>selected="selected"<?php } ?>>Large</option>
					<option value="Extra large" <?php if($_POST['maat'] == "Extra Large"){ ?>selected="selected"<?php } ?>>Extra large</option>
				</select><br /><br />
				Heeft Rijbewijs*<br />
				<select name="rijbewijs">
					<option value="keuze" <?php if($_POST['rijbewijs'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="Ja" <?php if($_POST['rijbewijs'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
					<option value="Nee" <?php if($_POST['rijbewijs'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
				</select><br /><br />
				Kan rondleiding geven*<br />
				<select name="rondleiding">
					<option value="keuze" <?php if($_POST['rondleiding'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="Ja" <?php if($_POST['rondleiding'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
					<option value="Nee" <?php if($_POST['rondleiding'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
				</select><br /><br />
				Kan Talentworkshop geven*<br />
				<select name="workshop">
					<option value="keuze" <?php if($_POST['workshop'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="Ja" <?php if($_POST['workshop'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
					<option value="Nee" <?php if($_POST['workshop'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
				</select><br /><br />

                Kan helpen bij online vraagstuk*<br />
                    <select name="onlinevraagstuk">
						<option value="keuze" <?php if(!empty($error) && $_POST['onlinevraagstuk'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['onlinevraagstuk'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['onlinevraagstuk'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />

                     Kan helpen bij webcareklus*<br />

                    <select name="webcareklus">
						<option value="keuze" <?php if(!empty($error) && $_POST['webcareklus'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['webcareklus'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['webcareklus'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />

                    Kan helpen bij brochureklus*<br />

                    <select name="brochureklus">
						<option value="keuze" <?php if(!empty($error) && $_POST['brochureklus'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['brochureklus'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['brochureklus'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />
                    Kan helpen bij invoerklus*<br />
                      <select name="invoerklus">
						<option value="keuze" <?php if(!empty($error) && $_POST['invoerklus'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['invoerklus'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['invoerklus'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />

                      Kan helpen bij fotografieklus*<br />
                      <select name="fotoklus">
						<option value="keuze" <?php if(!empty($error) && $_POST['fotoklus'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['fotoklus'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['fotoklus'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />

                      Kan helpen bij videoklus*<br />
                      <select name="videoklus">
						<option value="keuze" <?php if(!empty($error) && $_POST['videoklus'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['videoklus'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['videoklus'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />

                      Kan helpen bij nabelactie*<br />
                      <select name="nabelactie">
						<option value="keuze" <?php if(!empty($error) && $_POST['nabelactie'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['nabelactie'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['nabelactie'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />



				Afwezig van<br />
				<input type="text" name="afwezigVan" id="range_example_1_start" value="<?php echo $_POST['afwezigVan']; ?>" /><br /><br />

				Afwezig tot<br />
				<input type="text" name="afwezigTot" id="range_example_1_end" value="<?php echo $_POST['afwezigTot']; ?>" /><br /><br />
				IBAN Rekeningnummer*<br />
				<input type="text" name="bank" value="<?php echo $_POST['bank']; ?>" /><br /><br />
				Loonheffing*<br />
				<select name="loonheffing">
					<option value="keuze" <?php if($_POST['loonheffing'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="Ja" <?php if($_POST['loonheffing'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
					<option value="Nee" <?php if($_POST['loonheffing'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
				</select><br /><br />
				Ingang loonheffing<br />
				<input type="text" name="startLoonheffing" id="datum" value="<?php echo $_POST['startLoonheffing']; ?>" /><br /><br />
				Contract vanaf*<br />
				<input type="text" name="contractVan" id="range_example_1_start2" value="<?php echo $_POST['contractVan']; ?>" /><br /><br />
				Contract tot*<br />
				<input type="text" name="contractTot" id="range_example_1_end2" value="<?php echo $_POST['contractTot']; ?>" /><br /><br />
				BSN-nummer*<br />
				<input type="text" name="bsn" value="<?php echo $_POST['bsn']; ?>" /><br /><br />
				Burgerlijke Staat*<br />
				<select name="burgerlijkeStaat">
					<option value="keuze" <?php if($_POST['burgerlijkeStaat'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value=" Ongehuwd" <?php if( empty($_POST['burgerlijkeStaat']) && $studentDetails->burgerlijkeStaat == "Ongehuwd" ){ ?>selected="selected"<?php } if( $_POST['burgerlijkeStaat'] == "Ongehuwd" ){ ?>selected="selected"<?php }  ?>>Ongehuwd</option>
					<option value=" Gehuwd" <?php if( empty($_POST['burgerlijkeStaat']) && $studentDetails->burgerlijkeStaat == "Gehuwd" ){ ?>selected="selected"<?php } if( $_POST['burgerlijkeStaat'] == "Gehuwd" ){ ?>selected="selected"<?php }  ?>>Gehuwd</option>
					<option value="Samenwonend" <?php if( empty($_POST['burgerlijkeStaat']) && $studentDetails->burgerlijkeStaat == "Samenwonend" ){ ?>selected="selected"<?php } if( $_POST['burgerlijkeStaat'] == "Samenwonend" ){ ?>selected="selected"<?php }  ?>>Samenwonend</option>
				</select><br /><br />
				Foto<br />
				<?php if(!empty($tijdelijk) || !empty($_POST['tijdelijk'])){
					if(!empty($tijdelijk)){
						$tafb = "https://www.expect-webmedia.nl/drpr/wp-content/fotos/".$tijdelijk;
					}

					if(!empty($_POST['tijdelijk'])){
						$tafb = "https://www.expect-webmedia.nl/drpr/wp-content/fotos/".$_POST['tijdelijk'];
					}
				?>
				<img src="<?php echo $tafb; ?>" alt="" />
				<?php }else{ ?>
				<input type="file" name="file" id="file" value="<?php echo $_POST['file']; ?>"`>
				<?php } ?>
				<input type="hidden" name="tijdelijk" value="<?php if(empty($tijdelijk)){ echo $_POST['tijdelijk']; }else { echo $tijdelijk; } ?>">
				<br/><br/>
				Eventuele opmerkingen<br />
				<textarea name="opmerkingen"><?php echo $_POST['opmerkingen']; ?></textarea><br /><br />
				<input type="submit" id="submit" name="submitAdd" value="Aanmaken">
			</form><br /><br />

			<?php } ?>
		</div>
			</div>


	<div id="contentRechts">
	<div class="contentHeaderZoeken">
					<h1>Zoek Dream - en Promoteamers</h1>
				</div>
				<div class="contentContent">
					<form method="post" id="search">
						<input type="text" value="" id="searchDream" name="keyWord">
						<input type="submit" value="Zoeken!" name="submit" id="searchSubmit">
					</form>
					<?php if($_POST['submit']){
						global $wpdb;
						$keyWord = $_POST['keyWord'];
						$zoekresultaten = $wpdb->get_results( "SELECT * FROM Beheertool WHERE Voornaam LIKE '%".$keyWord."%' OR Achternaam LIKE '%".$keyWord."%' OR Emailadres LIKE '%".$keyWord."%' OR Studentnr LIKE '%".$keyWord."%' OR Opleiding LIKE '%".$keyWord."%' OR Woonplaats LIKE '%".$keyWord."%'" );
						$aantal = $wpdb->get_var( " SELECT COUNT(*) FROM Beheertool WHERE Voornaam LIKE '%".$keyWord."%' OR Achternaam LIKE '%".$keyWord."%' OR Emailadres LIKE '%".$keyWord."%' OR Opleiding LIKE '%".$keyWord."%' OR Woonplaats LIKE '%".$keyWord."%'");
						?><h3>Zoekresultaten voor <i>&quot;<?php echo $_POST['keyWord']; ?>&quot;</i> (<?php echo $aantal; ?>)</h3><?php
						foreach( $zoekresultaten as $zoekresultaat ){ ?>
							<div class="card">
								<table cellpadding="0" border="0">
									<tr>
										<td width="100" valign="top"><?php studentFoto($zoekresultaat->ID); ?></td>
										<td>
											<table cellpadding="0" border="0">
												<tr>
													<td width="60" valign="top">Naam</td>
													<td valign="top">:</td>
													<td valign="top"><?php echo $zoekresultaat->Voornaam; ?> <?php echo $zoekresultaat->Tussenvoegsel; ?> <?php echo $zoekresultaat->Achternaam; ?> (<?php echo $zoekresultaat->Type_overeenkomst; ?>)</td>
												</tr>
												<tr>
													<td>Opleiding</td>
													<td>:</td>
													<td><?php echo $zoekresultaat->Opleiding; ?></td>
												</tr>
												<tr>
													<td colspan="3" valign="bottom"><br /><a href="https://www.expect-webmedia.nl/drpr/detail/?id=<?php echo $zoekresultaat->ID; ?>">Bekijk het profiel van <?php echo $zoekresultaat->Voornaam; ?></a></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</div>

						<?php }

						if(empty($zoekresultaten)){
							echo "Er zijn geen zoekresultaten<br />";
						}
					}
					?>
				</div>

<!-- einde zoeken begin account toevoegen -->
		<div class="contentHeaderActief">
			<h1>Komende activiteiten</h1>
		</div>
		<div class="contentContent">
		<table border="0" cellpadding="5" cellspacing="3">
				<?php
				global $wpdb;
				$vandaag = date('Ymd');
				$activiteiten = $wpdb->get_results( "SELECT * FROM Activiteiten WHERE Datum >= '".$vandaag."' ORDER BY Datum ASC" );
				foreach( $activiteiten as $activiteit ){

				//kijken of er wel aanmeldingen zijn, anders geen werkbriefjes
				$aanmeldingen = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE ActID = '".$activiteit->ID."' AND Afwezig != 'afwezig'" );
				?>
							<tr >
								<td valign="top" width="120" class="date"> <B>&nbsp;&nbsp;<?php mooiedatum($activiteit->Datum); ?></B></td>
								<td valign="top">&nbsp;</td>
								<td valign="top" width="285"><a href="https://www.expect-webmedia.nl/drpr/activiteit-detail?id=<?php echo $activiteit->ID; ?>"><?php echo $activiteit->Titel; ?></a></td>
								<td valign="top"><?php if(!empty($aanmeldingen)){ ?><a href="https://www.expect-webmedia.nl/drpr/print-werkbriefjes/?actid=<?php echo $activiteit->ID; ?>" target="_blank"><span>print werkbriefjes</span></a><?php 				} ?></td>
							</tr>
				<?php }

					if(empty($activiteiten)){
						echo "Er zijn nog geen activiteiten";
					}
				?>
			</table>
		</div>
		<div class="button" onclick="location.href='/drpr/importeren/';">
			Importeer Studenten
		</div>
		<div class="button2" onclick="location.href='https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/scripts/export.php?secure=098012378929';">
			Exporteer Studenten
		</div>
		<div class="button3"  onclick="window.open('https://www.expect-webmedia.nl/drpr/contracten/')">
			 Print alle contracten
		</div>
		<div class="contentHeaderActief">
			<h1>Algemene gegevens</h1>
			<div class="edit"><a href="/drpr/dreamteamers-promoteamers/?editBasics=1"><img src="<?php bloginfo('template_url'); ?>/images/edit.png" alt="" title="bewerk de algemene gegevens"></a></div>
		</div>
		<div class="contentContent">
			<?php $instellingenDetails = $wpdb->get_row("SELECT * FROM Instellingen WHERE ID = '1'" ); ?>
		<?php if(!isset($_GET['editBasics']) && empty($errorInstellingen) || isset($_POST['instellingen']) && empty($errorInstellingen)) { ?>
		<table border="0" cellpadding="5" cellspacing="3">
				<tr >
					<td valign="top" width="120">Afdelingshoofd</td>
					<td valign="top">:</td>
					<td valign="top" ><?php echo $instellingenDetails->Hoofd; ?></td>
				</tr>
				<tr >
					<td valign="top" width="120">Projectnummer</td>
					<td valign="top">:</td>
					<td valign="top" ><?php echo $instellingenDetails->Projectnummer; ?></td>
				</tr>
				<tr >
					<td valign="top" width="120">Bruto uurlonen</td>
					<td valign="top">:</td>
					<td valign="top">
						<table border="0" cellpadding="5" cellspacing="3">
							<tr>
								<td valign="top">t/m 21 jaar</td>
								<td valign="top">:</td>
								<td valign="top" width="285">&euro; <?php echo $instellingenDetails->Salaris21; ?> per uur</td>
							</tr>
							<tr>
								<td valign="top">22 jaar</td>
								<td valign="top">:</td>
								<td valign="top" width="285">&euro; <?php echo $instellingenDetails->Salaris22; ?> per uur</td>
							</tr>
							<tr>
								<td valign="top">vanaf 23 jaar</td>
								<td valign="top">:</td>
								<td valign="top" width="285">&euro;  <?php echo $instellingenDetails->Salaris23; ?> per uur</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<?php } ?>
			<?php
				//als de instellingen gewijzigd zijn, we gaan kijken of er fouten gemaakt zijn
				if($_POST['instellingen']){
					if(empty($_POST['afdelingshoofd'])){
						$errorInstellingen .="1";
						$errorInstellingen1 ="1";

					}

					if(empty($_POST['projectnummer'])){
						$errorInstellingen .="1";
						$errorInstellingen11 ="1";

					}

					if(empty($_POST['21'])){
						$errorInstellingen .="2";
						$errorInstellingen2 ="1";
					}

					if(empty($_POST['22'])){
						$errorInstellingen .="3";
						$errorInstellingen3 ="1";
					}

					if(empty($_POST['23'])){
						$errorInstellingen .="4";
						$errorInstellingen4 ="1";
					}
				}
			?>

			<?php if(isset($_POST['instellingen']) && empty($errorInstellingen)){
				$wpdb->update( Instellingen, array( 'Hoofd' => $_POST['afdelingshoofd'],'Projectnummer' => $_POST['projectnummer'], 'Salaris21' => $_POST['21'], 'Salaris22' => $_POST['22'], 'Salaris23' => $_POST['23'] ),array( 'ID' => '1') );
				$url = "https://www.expect-webmedia.nl/drpr/dreamteamers-promoteamers/?instel=1";
				wp_redirect( $url ); exit;
			} ?>

			<?php if(!$_POST['instellingen'] && isset($_GET['editBasics']) || $_POST['instellingen'] && !empty($errorInstellingen)){
					$instellingen = $wpdb->get_row("SELECT * FROM Instellingen" );
				?>
				<form action="" method="post" name="instellingen">
					<?php if(isset($errorInstellingen1)){ ?><img src="<?php bloginfo('template_url'); ?>/images/alert.jpg" alt=""> <?php } ?>Naam afdelingshoofd<br />
					<input type="text" name="afdelingshoofd" value="<?php if($_POST['instellingen']){ echo $_POST['afdelingshoofd'];}else{ echo $instellingenDetails->Hoofd; } ?>" /><br /><br />
					<?php if(isset($errorInstellingen11)){ ?><img src="<?php bloginfo('template_url'); ?>/images/alert.jpg" alt=""> <?php } ?>Projectnummer<br />
					<input type="text" name="projectnummer" value="<?php if($_POST['instellingen']){ echo $_POST['projectnummer'];}else{ echo $instellingenDetails->Projectnummer; } ?>" /><br /><br />
					<?php if(isset($errorInstellingen2)){ ?><img src="<?php bloginfo('template_url'); ?>/images/alert.jpg" alt=""> <?php } ?>Bruto uurloon t/m 21 jaar <span>(met komma en zonder euroteken)</span><br />
					<input type="text" name="21" value="<?php if($_POST['21']){ echo $_POST['21'];}else{ echo $instellingenDetails->Salaris21; } ?>" /><br /><br />
					<?php if(isset($errorInstellingen3)){ ?><img src="<?php bloginfo('template_url'); ?>/images/alert.jpg" alt=""> <?php } ?>Bruto uurloon 22 jaar <span>(met komma en zonder euroteken)</span><br />
					<input type="text" name="22" value="<?php if($_POST['22']){ echo $_POST['22'];}else{ echo $instellingenDetails->Salaris22; } ?>" /><br /><br />
					<?php if(isset($errorInstellingen4)){ ?><img src="<?php bloginfo('template_url'); ?>/images/alert.jpg" alt=""> <?php } ?>Bruto uurloon vanaf 23 jaar <span>(met komma en zonder euroteken)</span><br />
					<input type="text" name="23" value="<?php if($_POST['23']){ echo $_POST['23'];}else{ echo $instellingenDetails->Salaris23; } ?>" /><br /><br />
					<a href="/drpr/dreamteamers-promoteamers/">Annuleren</a> <input type="submit" value="aanpassen" name="instellingen" id="submit">
				</form>
				<br /><br />
			<?php } ?>
		</div>

		<?php
		if ( is_user_logged_in() ) {
		$user = new WP_User( $user_ID );
				if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
					foreach ( $user->roles as $role )
						$test = $role;
				}
			}
		?>
		<?php if($test == 'administrator'){ ?>
		<div class="contentHeaderActief">
			<h1>Contractgegevens van alle Dream- /Promoteamers aanpassen</h1>
		</div>
		<div class="contentContent">
			<?php
				//als de instellingen gewijzigd zijn, we gaan kijken of er fouten gemaakt zijn
				if($_POST['batch']){
					if(empty($_POST['contractVan1'])){
						$errorBatch .="1";
						$errorBatch1 ="1";

					}

					if(empty($_POST['contractTot1'])){
						$errorBatch .="1";
						$errorBatch2 ="1";
					}

				}
			?>

			<?php if(isset($_POST['batch']) && empty($errorBatch)){
				$wpdb->update( Beheertool, array( 'Contract_van' => $_POST['contractVan1'], 'Contract_tot' => $_POST['contractTot1'] ),array( 'Actief' => '') );
				$url = "https://www.expect-webmedia.nl/drpr/dreamteamers-promoteamers/?batch=1";
				wp_redirect( $url ); exit;
			} ?>
			<form action="" method="post" name="batch">
			<?php if(isset($errorBatch1)){ ?><img src="<?php bloginfo('template_url'); ?>/images/alert.jpg" alt=""> <?php } ?>Contract vanaf*<br />
			<input type="text" name="contractVan1" id="range_example_1_start3" value="<?php echo $_POST['contractVan1']; ?>" /><br /><br />
			<?php if(isset($errorBatch2)){ ?><img src="<?php bloginfo('template_url'); ?>/images/alert.jpg" alt=""><?php } ?> Contract tot*<br />
			<input type="text" name="contractTot1" id="range_example_1_end3" value="<?php echo $_POST['contractTot1']; ?>" /><br /><br />
			<input type="submit" value="Aanpassen" name="batch" id="submit">
			</form>
		</div>
		<?php } ?>
	</div>

<?php

get_footer(); ob_end_flush(); ?>
