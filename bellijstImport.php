<?php  ob_start();
/*
Template Name: Bellijst Import
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
					
					$wpdb->insert( Beheertool, array( 'Type_overeenkomst' => $_POST['overeenkomst'], 'Voornaam' => $_POST['voornaam'], 'Tussenvoegsel' => $_POST['tussenvoegsel'], 'Achternaam' => $_POST['achternaam'], 'Geslacht' => $_POST['geslacht'], 'Geboortedatum' => $_POST['geboortedatum'], 'Emailadres' => $_POST['email'], 'Adres' => $_POST['adres'], 'Huisnummer' => $_POST['huisnummer'], 'Postcode' => $_POST['postcode'], 'Woonplaats' => $_POST['woonplaats'], 'Telefoonnummer' => $_POST['telefoonnummer'], 'Mobiel' => $_POST['mobiel'], 'Opleiding' => $_POST['opleiding'], 'Maat' => $_POST['maat'], 'Rijbewijs' => $_POST['rijbewijs'], 'Afwezig_van' => $afwezigV, 'Afwezig_tot' => $afwezigT, 'Opmerkingen' => $_POST['opmerkingen'], 'IBAN' => $_POST['bank'], 'Studentnr' => $_POST['studnr'], 'Studiejaar' => $_POST['studiejaar'], 'Loonheffing' => $_POST['loonheffing'], 'Talentworkshop' => $_POST['workshop'], 'Rondleiding' => $_POST['rondleiding'], 'OnlineVraagstuk' => $_POST['onlinevraagstuk'], 'WebcareKlus' => $_POST['webcareklus'], 'BrochureKlus' => $_POST['brochureklus'], 'InvoerKlus' => $_POST['invoerklus'], 'Vooropleiding' => $_POST['vooropleiding'], 'Ingang_loonheffing' => $_POST['startLoonheffing'],'BurgerlijkeStaat' => $_POST['burgerlijkeStaat'], 'Contract_van' => $_POST['contractVan'], 'Contract_tot' => $_POST['contractTot'], 'BSN' => $_POST['bsn'], 'Actief' => $actief, 'Perskey' => $persKey, 'Foto' => $bestandNaam ) );

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
				<div class="contentHeaderImport">
			<h1>Importeer bellijst</h1>
		</div>
		<div class="contentContent">
			<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
			  Selecteer een CSV bestand: <br />
			  <input name="csv" type="file" id="csv" />
			  <input type="submit" name="Submit" value="Importeren" id="importSubmit" />
			</form>
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