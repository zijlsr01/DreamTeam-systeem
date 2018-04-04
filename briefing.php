<?php  ob_start();
/*
Template Name: Briefing
*/


get_header();

				//connect to the database
				global $wpdb; $current_user;
				get_currentuserinfo();
				//

				$actID = $_GET['id'];

				$current_user = wp_get_current_user();
				$user_info = get_userdata($current_user->ID);
				$userRole = implode(', ', $user_info->roles);




				if($_POST['addContent']){
					$wpdb->insert('Contentbeheerders', array( 'userID' => $_POST['contentB']) );
				}

				if($_GET['delCont']){
					$wpdb->query( " DELETE FROM Contentbeheerders WHERE ID = ".$_GET['delCont']." "  );
					?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						Contentbeheerder met succes verwijderd!
					</div>
					<?php
				}



								//	testGeert('2');


				if(!empty($_GET['delete']) && !empty($_GET['id'])){
					$wpdb->query( " DELETE FROM Briefing WHERE ID = ".$_GET['id']." "  );
					?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						Opdracht met succes verwijderd!
					</div>
					<?php
					 } ?>





					<?php  if(!empty($_GET['annuleren']) && !empty($_GET['id'])){ ?>

						 <div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
							 Opdracht met succes geannuleerd!
						 </div>




				 		<?php

						$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );

						$actID = $_GET['id'];

						//En een mail versturen naar de opdrachtgever
						opdrachtGeannuleerd($actID,$actDetails->ContactpersoonID);

						//En een mail versturen naar de contentbeheerder
						opdrachtGeannuleerdContentbeheerder($actID,$actDetails->ContactpersoonID);


						//En een mail versturen naar het Office
						opdrachtGeannuleerdOffice($actID,$actDetails->ContactpersoonID); ?>


						 <?php
							} ?>

                <div style="clear: both;"></div>


                <?php // Berekening uren op basis selectie formulier

				$uren = 0;
				$correcties = 0;
				$totaal = $uren + $correcties;

				// Bereken de uren subcatMail
					switch($_POST['subcatMail']) {

					case "MailBestaandeOpmaak":
						$uren =  1.50;
						break;
					case "mailNieuweOpmaak":
						$uren =  3.00;
						break;
					}


						// Bereken de uren subcatWebsitePanels
					switch($_POST['subcatWebsitePanels']) {

					case "singlecontentpanel":
						$uren =  0.50;
						break;
					case "multitab":
						$uren =  1.00;
						break;
					case "calltoaction":
						$uren =  0.50;
						break;
					case "fotoalbumklein":
						$uren =  1.00;
						break;
					case "fotoalbumgroot":
						$uren =  1.50;
						break;
					case "videopanel":
						$uren =  0.50;
						break;
					}


					// Bereken de uren subcatWebsiteLP
					switch($_POST['subcatWebsiteLP']) {

					case "landingspagina":
						$uren =  2.00;
						break;
					case "landingspaginaCor":
						$uren =  0.50;
						break;
					}


					// Bereken de uren subcatWebsiteForm
					switch($_POST['subcatWebsiteForm']) {

					case "formulierNieuw":
						$uren =  1.00;
						break;
					case "formulierBestaand":
						$uren =  0.50;
						break;
					case "crmFormulierNieuw":
						$uren =  1.50;
						break;
					case "crmFormulierBestaand":
						$uren =  1.00;
						break;

					}

					// Bereken de uren subcatWebsiteTekst
					switch($_POST['subcatWebsiteTekst']) {

					case "webTekstOpleiding":
						$uren =  5.00;
						break;
					case "webTekstCursus":
						$uren =  2.50;
						break;
					case "webTekstPagina":
						$uren =  2.00;
						break;
					case "webTekstBestaand":
						$uren =  0.50;
						break;

					}

					// Bereken de uren kleine aanpassing
					switch($_POST['subcatWebsite']) {

					case "kleineAanpassing":
						$uren =  0.15;
						break;
					}

					// Bereken de uren subcatBanners
					switch($_POST['subcatBanners']) {

					case "bannersetBestaandeOpmaak":
						$uren =  4.00;
						break;
					case "bannersetNieuweOpmaak":
						$uren =  5.00;
						break;
					case "facebookBannerBestaandeOpmaak":
						$uren =  0.50;
						break;
					case "facebookBannerNieuweOpmaak":
						$uren =  1.00;
						break;

					}

					// Bereken de uren subcatEnquete
					switch($_POST['subcatEnquete']) {

					case "bestaandeEnquete":
						$uren =  1.00;
						break;
					case "nieuweEnquete":
						$uren =  3.00;
						break;
					}

					// Bereken de uren subcatNarrowcasting
					switch($_POST['subcatNarrowcasting']) {

					case "bestaandeNarrowcasting":
						$uren =  0.50;
						break;
					case "nieuweNarrowcasting":
						$uren =  1.00;
						break;
					}

					// Bereken de uren subcatOverig
					switch($_POST['subcatOverig']) {

					case "videoYoutube":
						$uren =  1.00;
						break;
					}


					// Bereken de uren correcties

					switch($_POST['corTijd']) {

					case "halfUur":
						$correcties = 0.50;
						break;
					case "uur":
						$correcties = 1.00;
						break;
					case "anderHalfUur":
						$correcties = 1.50;
						break;
					}

				?>


	<div id="contentLinks">

        <div class="contentHeader">
			<h1>Briefingformulier Contentbeheer</h1>
		</div>

		<div class="contentContent input-list style-1 clearfix">
			<?php
				//kijken of er fouten zijn gemaakt
				if(empty($_POST['titel'])){	$error .= "<li>Je bent vergeten de titel in te vullen</li>";	}
				if(empty($_POST['projectnummer'])){	$error .= "<li>Je bent vergeten het projectnummer in te vullen</li>";	}
				if(empty($_POST['startDatum'])){	$error .= "<li>Je bent vergeten een datum in te vullen2</li>";	}
				if(empty($_POST['beschrijving'])){	$error .= "<li>Je bent vergeten een beschrijving in te vullen</li>";}

				if(empty($_POST['correcties'])){ $error .= "<li>Je bent vergeten het Correcties veld in te vullen</li>";	}

				if($_POST['categorie'] == 'keuze'){	$error .= "<li>Je bent vergeten een categorie te kiezen</li>";	}
				if($_POST['categorie'] == 'website' && $_POST['subcatWebsite'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Website in te vullen</li>";}
				if($_POST['categorie'] == 'website' && $_POST['subcatWebsite'] == 'panels' && $_POST['subcatWebsitePanels'] == 'keuze'){ $error .= "<li>Je bent vergeten om een panel te kiezen</li>";}
				if($_POST['categorie'] == 'website' && $_POST['subcatWebsite'] == 'landingspagina' && $_POST['subcatWebsiteLP'] == 'keuze'){ $error .= "<li>Je bent vergeten om een keuze te maken qua landingspagina</li>";}
				if($_POST['categorie'] == 'website' && $_POST['subcatWebsite'] == 'formulier' && $_POST['subcatWebsiteForm'] == 'keuze'){ $error .= "<li>Je bent vergeten om een keuze te maken qua formulier</li>";}

				if($_POST['categorie'] == 'website' && $_POST['subcatWebsite'] == 'webtekst' && $_POST['subcatWebsiteText'] == 'keuze'){ $error .= "<li>Je bent vergeten om een keuze te maken qua webtekst</li>";}
				//if($_POST['reminder'] == 'keuze'){	$error .= "<li>Je bent vergeten aan te geven of je een reminder wilt ontvangen.</li>";	}

				if($_POST['correcties'] == 'Ja' &&  $_POST['corTijd'] == 'keuze'){ $error .= "<li>Je bent vergeten om een keuze te maken qua uren correcties</li>";}


				if($_POST['categorie'] == 'mail' && $_POST['subcatMail'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Mail in te vullen</li>";	}
				if($_POST['categorie'] == 'banners' && $_POST['subcatBanners'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Banners in te vullen</li>";	}
				if($_POST['categorie'] == 'enquete' && $_POST['subcatEnquete'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Enquete in te vullen</li>";	}
				if($_POST['categorie'] == 'narrowcasting' && $_POST['subcatNarrowcasting'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Narrowcasting in te vullen</li>";	}
				if($_POST['categorie'] == 'overig' && $_POST['subcatOverig'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Overig te vullen</li>";	}





				if(isset( $_POST['submit'] ) && !empty($error)){ ?>
					<div id="alert">
						<ul>
							<?php echo $error; ?>
						</ul>
					</div>
				<?php }


				//als er geen fouten gemaakt zijn dan zetten we de gegevens in de database en geven we een succesmelding
				if($_POST['submit'] && empty($error)){
					$dbDate = date("Ymd", strtotime($_POST['startDatum']));
					$dbDate2 = date("Ymd", strtotime($_POST['eindDatum']));
					$dbDate3 = date("Ymd", strtotime($_POST['verzendDatum']));
					$contactID =  $current_user->ID;
					$actKey = date('YmdB').$contactID;


					// Conditioner om alleen correcties datum naar DB te schrijven wanneer nodig

					if($_POST['correcties'] == 'Ja'){
					$datumCor = $dbDate2;
					}

					// Conidtioner om alleen verzenddatum naar DB te schrijven wanneer nodig

					if($_POST['versturen'] == 'Ja'){
					$datumVerzenden = $dbDate3;
					}



					//Conditioner voor schrijven subcategorie naar database

					if($_POST['categorie'] == 'mail'){
						$subCat= $_POST['subcatMail'];
					}
					if($_POST['categorie'] == 'website'){
						$subCat= $_POST['subcatWebsite'];
					}
					if($_POST['categorie'] == 'banners'){
						$subCat= $_POST['subcatBanners'];
					}
					if($_POST['categorie'] == 'enquete'){
						$subCat= $_POST['subcatEnquete'];
					}
					if($_POST['categorie'] == 'narrowcasting'){
						$subCat= $_POST['subcatNarrowcasting'];
					}
					if($_POST['categorie'] == 'overig'){
						$subCat= $_POST['subcatOverig'];
					}

					//Conditioner voor schrijven Subsubcategorie naar database


					//SUBSUB Website

					if($_POST['subcatWebsite'] == 'panels'){
					$subsubCat= $_POST['subcatWebsitePanels'];
					}
					if($_POST['subcatWebsite'] == 'landingspagina'){
					$subsubCat= $_POST['subcatWebsiteLP'];
					}
					if($_POST['subcatWebsite'] == 'webtekst'){
					$subsubCat= $_POST['subcatWebsiteTekst'];
					}
					if($_POST['subcatWebsite'] == 'formulier'){
					$subsubCat= $_POST['subcatWebsiteForm'];
					}


					$wpdb->insert('Briefing', array( 'Titel' => $_POST['titel'],'Projectnummer' => $_POST['projectnummer'], 'Startdatum' => $dbDate, 'Einddatum' => $datumCor,
					'Correcties' => $_POST['corTijd'], 'Terugkeerpatroon' => $_POST['terugkeerpatroon'], 'Verzenddatum' => $datumVerzenden, 'Omschrijving' => $_POST['beschrijving'], 'Categorie' => $_POST['categorie'], 'SubCategorie' => $subCat,
					'SubSubcategorie'=> $subsubCat, 'ContactpersoonID' => $current_user->ID ,'Opdrachtgever' => $_POST['opdrachtgever'], 'voorkeurContent' => $_POST['contentbeheerder'], 'Contactemail' => $_POST['emailopdrachtgever'],
				'Locatie' => $_POST['locatie'],/*'Uren' => $_POST['uren'],*/ 'Uren' => $uren, 'actKey' => $actKey, /*'reminder' => $_POST['reminder']*/ ) );
					$briefingDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE actKey = $actKey" );
					$url = "http://www.expect-webmedia.nl/drpr/briefing-detail/?id=".$briefingDetails->ID;
					wp_redirect( $url.'&add=succes' ); exit;

				}
			?>

			<?php
				if(!isset( $_POST['submit'] ) || !empty($error)){
					get_currentuserinfo();
					?>


		<form id="briefingcontent" action="" method="post">

        Titel opdracht*<br />
				<input type="text" name="titel" required value="<?php echo $_POST['titel']; ?>" /><br /><br />

				Projectnummer*<br />
				<input type="text" name="projectnummer" required value="<?php echo $_POST['projectnummer']; ?>" /><br /><br />

				Gewenste datum *<br />
				<input type="text" name="startDatum" required  id="datum" value="<?php echo $_POST['startDatum']; ?>" /><br /><br />

				Terugkeerpatroon*
				<select name="terugkeerpatroon" >
					<option value="Geen" <?php if($_POST['terugkeerpatroon'] == "Geen"){ ?>selected="selected"<?php } ?>>Geen</option>
					<option value="Dagelijks" <?php if($_POST['terugkeerpatroon'] == "Dagelijks"){ ?>selected="selected"<?php } ?>>Dagelijks</option>
					<option value="Wekelijks" <?php if($_POST['terugkeerpatroon'] == "Wekelijks"){ ?>selected="selected"<?php } ?>>Wekelijks</option>
					<option value="Maandelijks" <?php if($_POST['terugkeerpatroon'] == "Maandelijks"){ ?>selected="selected"<?php } ?>>Maandelijks</option>
				</select><br /><br />



        Categorie *<br />
				<select name="categorie" onchange="calculateTotal();" required >
						<option value="keuze" <?php if($_POST['categorie'] == "keuze"){ ?> selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="mail" <?php if($_POST['categorie'] == "mail"){ ?> selected="selected"<?php } ?>>Mail</option>
						<option value="website" <?php if($_POST['categorie'] == "website"){ ?> selected="selected" <?php } ?>>Website</option>
						<option value="banners" <?php if($_POST['categorie'] == "banners"){ ?> selected="selected"<?php } ?>>Banners</option>
						<option value="enquete" <?php if($_POST['categorie'] == "enquete"){ ?>selected="selected"<?php } ?>>Enquete</option>
						<option value="narrowcasting" <?php if($_POST['categorie'] == "narrowcasting"){ ?>selected="selected"<?php } ?>>Narrowcasting</option>
          	<option value="overig" <?php if($_POST['categorie'] == "overig"){ ?>selected="selected"<?php } ?>>Overig</option>
				</select><br /><br />

      <div id="subcatMail" style="display:none">

        Subcategorie Mail *<br />
				<select name="subcatMail" onchange="calculateTotal();">
					<option value="keuze" <?php if($_POST['subcatMail'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="MailBestaandeOpmaak" <?php if($_POST['subcatMail'] == "MailBestaandeOpmaak"){ ?>selected="selected"<?php } ?>>Opmaak mail - bestaande opmaak</option>
					<!--<option value="corMailBestaandeOpmaak" <?php // if($_POST['subcatMail'] == "corMailBestaandeOpmaak"){ ?>selected="selected"<?php // } ?>>Correcties mail bestaande opmaak</option> -->
					<option value="mailNieuweOpmaak" <?php if($_POST['subcatMail'] == "mailNieuweOpmaak"){ ?>selected="selected"<?php } ?>>Opmaak mail - nieuwe opmaak</option>
          <!--<option value="corMailNieuweOpmaak" <?php// if($_POST['subcatMail'] == "corMailNieuweOpmaak"){ ?>selected="selected"<?php // } ?>>Correcties mail - nieuwe opmaak</option> -->
				</select><br /><br />

      </div> <!-- Einde div subcatMail -->


      <div id="subcatWebsite" style="display:none">

        Subcategorie Website *<br />
				<select name="subcatWebsite" onchange="calculateTotal();">
					<option value="keuze" <?php if($_POST['subcatWebsite'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="kleineAanpassing" <?php if($_POST['subcatWebsite'] == "kleineAanpassing"){ ?>selected="selected"<?php } ?>>Kleine aanpassing (foto wijzigen, PDF, min tekstwijz, agenda-item, nieuwsbericht)</option>
					<option value="panels" <?php if($_POST['subcatWebsite'] == "panels"){ ?>selected="selected"<?php } ?>>Panels</option>
          <option value="landingspagina" <?php if($_POST['subcatWebsite'] == "landingspagina"){ ?>selected="selected"<?php } ?>>Landingspagina</option>
					<option value="webtekst" <?php if($_POST['subcatWebsite'] == "webtekst"){ ?>selected="selected"<?php } ?>>Webtekst</option>
					<option value="formulier" <?php if($_POST['subcatWebsite'] == "formulier"){ ?>selected="selected"<?php } ?>>Formulier</option>
				</select><br /><br />

      </div>

      <div id="subcatWebsitePanels" style="display:none">

        Panels *<br />
				<select name="subcatWebsitePanels" onchange="calculateTotal(); document.getElementById('preview').src = 'https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/'+this.value+'.jpg'">
					<option value="keuze" <?php if($_POST['subcatWebsitePanels'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="singlecontentpanel" <?php if($_POST['subcatWebsitePanels'] == "singlecontentpanel"){ ?>selected="selected"<?php } ?>>Single content panel</option>
					<option value="multitab" <?php if($_POST['subcatWebsitePanels'] == "multitab"){ ?>selected="selected"<?php } ?>>Multitab</option>
					<option value="calltoaction" <?php if($_POST['subcatWebsitePanels'] == "calltoaction"){ ?>selected="selected"<?php } ?>>Call to action</option>
					<option value="fotoalbumklein" <?php if($_POST['subcatWebsitePanels'] == "fotoalbumklein"){ ?>selected="selected"<?php } ?>>Foto album (minder dan 25 foto's)</option>
					<option value="fotoalbumgroot" <?php if($_POST['subcatWebsitePanels'] == "fotoalbumgroot"){ ?>selected="selected"<?php } ?>>Foto album (meer dan 25 foto's)</option>
        	<option value="videopanel" <?php if($_POST['subcatWebsitePanels'] == "videopanel"){ ?>selected="selected"<?php } ?>>Video panel</option>
				</select><br /><br />
      </div>

    	<div id="subcatWebsiteLP" style="display:none">

        Landingspagina *<br />
				<select name="subcatWebsiteLP" onchange="calculateTotal();">
					<option value="keuze" <?php if($_POST['subcatWebsiteLP'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="landingspagina" <?php if($_POST['subcatWebsiteLP'] == "landingspagina"){ ?>selected="selected"<?php } ?>>Maken landingspagina</option>
					<option value="landingspaginaCor" <?php if($_POST['subcatWebsiteLP'] == "landingspaginaCor"){ ?>selected="selected"<?php } ?>>Correcties landingspagina</option>
      	</select><br /><br />
      </div>

      <div id="subcatWebsiteForm" style="display:none">

        Formulier *<br />
				<select name="subcatWebsiteForm" onchange="calculateTotal();">
					<option value="keuze" <?php if($_POST['subcatWebsiteForm'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="formulierNieuw" <?php if($_POST['subcatWebsiteForm'] == "formulierNieuw"){ ?>selected="selected"<?php } ?>>Formulier - Nieuw</option>
					<option value="formulierBestaand" <?php if($_POST['subcatWebsiteForm'] == "formulierBestaand"){ ?>selected="selected"<?php } ?>>Formulier - op basis bestaand</option>
          <option value="crmFormulierNieuw" <?php if($_POST['subcatWebsiteForm'] == "crmFormulierNieuw"){ ?>selected="selected"<?php } ?>>CRM Formulier - Nieuw</option>
					<option value="crmFormulierBestaand" <?php if($_POST['subcatWebsiteForm'] == "crmFormulierBestaand"){ ?>selected="selected"<?php } ?>>CRM Formulier - op basis bestaand</option>
				</select><br /><br />
      </div>

      <div id="subcatWebsiteTekst" style="display:none">

        Subcategorie webtekst *<br />
				<select name="subcatWebsiteTekst" onchange="calculateTotal();">
					<option value="keuze" <?php if($_POST['subcatWebsiteTekst'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="webTekstOpleiding" <?php if($_POST['subcatWebsiteTekst'] == "webTekstOpleiding"){ ?>selected="selected"<?php } ?>>Webtekst nieuwe opleiding</option>
					<option value="webTekstCursus" <?php if($_POST['subcatWebsiteTekst'] == "webTekstCursus"){ ?>selected="selected"<?php } ?>>Webtekst invoeren nieuwe cursus</option>
          <option value="webTekstPagina" <?php if($_POST['subcatWebsiteTekst'] == "webTekstPagina"){ ?>selected="selected"<?php } ?>>Webtekst nieuwe algemene pagina</option>
					<option value="webTekstBestaand" <?php if($_POST['subcatWebsiteTekst'] == "webTekstBestaand"){ ?>selected="selected"<?php } ?>>Webtekst wijzigen algemene pagina</option>
				</select><br /><br />
      </div>

      <div id="subcatBanners" style="display:none" >

        Subcategorie Banners *<br />
        <select name="subcatBanners" onchange="calculateTotal();">
          <option value="keuze" <?php if($_POST['subcatBanners'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
          <option value="bannersetBestaandeOpmaak" <?php if($_POST['subcatBanners'] == "bannersetBestaandeOpmaak"){ ?>selected="selected"<?php } ?>>Bannerset - bestaande opmaak</option>
        	<option value="bannersetNieuweOpmaak" <?php if($_POST['subcatBanners'] == "bannersetNieuweOpmaak"){ ?>selected="selected"<?php } ?>>Bannerset - nieuwe opmaak</option>
        	<option value="facebookBannerBestaandeOpmaak" <?php if($_POST['subcatBanners'] == "facebookBannerBestaandeOpmaak"){ ?>selected="selected"<?php } ?>>Facebookbanner - bestaande opmaak</option>
          <option value="facebookBannerNieuweOpmaak" <?php if($_POST['subcatBanners'] == "facebookBannerNieuweOpmaak"){ ?>selected="selected"<?php } ?>>Facebook banner - nieuwe opmaak</option>
        </select>
            <br /><br />
        </div>

      <div id="subcatEnquete" style="display:none">
        Subcategorie Enquete *<br />

			<select name="subcatEnquete" onchange="calculateTotal();" >
				<option value="keuze" <?php if($_POST['subcatEnquete'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
				<option value="bestaandeEnquete" <?php if($_POST['subcatEnquete'] == "bestaandeEnquete"){ ?>selected="selected"<?php } ?>>Enquete - bestaande opmaak</option>
				<option value="nieuweEnquete" <?php if($_POST['subcatEnquete'] == "nieuweEnquete"){ ?>selected="selected"<?php } ?>>Enquete - nieuwe opmaak</option>
			</select><br /><br />

       </div>

      	<div id="subcatNarrowcasting" style="display:none">
        Subcategorie Narrowcasting *<br />

				<select name="subcatNarrowcasting" onchange="calculateTotal();" >
					<option value="keuze" <?php if($_POST['subcatNarrowcasting'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="bestaandeNarrowcasting" <?php if($_POST['subcatNarrowcasting'] == "bestaandeNarrowcasting"){ ?>selected="selected"<?php } ?>>Narrowcasting - bestaande opmaak</option>
					<option value="nieuweNarrowcasting" <?php if($_POST['subcatNarrowcasting'] == "nieuweNarrowcasting"){ ?>selected="selected"<?php } ?>>Narrowcasting - nieuwe opmaak</option>
				</select><br /><br />

        </div>

        <div id="subcatOverig" style="display:none">

        Subcategorie Overig *<br />
				<select name="subcatOverig" onchange="calculateTotal();" >
					<option value="keuze" <?php if($_POST['subcatOverig'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="videoYoutube" <?php if($_POST['subcatOverig'] == "videoYoutube"){ ?>selected="selected"<?php } ?>>Youtube - video uploaden</option>
				</select><br /><br />

        </div>

        <div id="correcties">

        Correcties*<br />
				<select name="correcties" required onchange="calculateTotal();" >
					<option value="keuze" <?php if($_POST['correcties'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
          <option value="Ja" <?php if($_POST['correcties'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
					<option value="Nee" <?php if($_POST['correcties'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
				</select><br /><br />

        <div id="corTijd" style="display:none">

        Uren correcties*<br />
				<select name="corTijd" required onchange="calculateTotal();" >
					<option value="keuze" <?php if($_POST['corTijd'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
          <option value="0.50" <?php if($_POST['corTijd'] == "0.50"){ ?>selected="selected"<?php } ?>>0,5 uur</option>
					<option value="1.00" <?php if($_POST['corTijd'] == "1.00"){ ?>selected="selected"<?php } ?>>1 uur</option>
          <option value="1.50" <?php if($_POST['corTijd'] == "1.50"){ ?>selected="selected"<?php } ?>>1,5 uur</option>
				</select><br /><br />

      </div> <!-- einde corTijd -->
		</div> <!-- einde div Correcties -->





               <div id="datumCorrecties" style="display:none">
                Gewenste datum correcties *<br />
								<input type="text" name="eindDatum" id="datumNew" value="<?php echo $_POST['eindDatum']; ?>" /><br /><br />
                </div>


								<div id="versturen" style="display:none">

        				Versturen op andere datum dan correcties?*<br />
								<select name="versturen" required onchange="calculateTotal();" >
										<option value="keuze" <?php if($_POST['versturen'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
                    <option value="Ja" <?php if($_POST['versturen'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
										<option value="Nee" <?php if($_POST['versturen'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
								</select><br /><br />

							</div><!-- einde Div versturen -->


								<div id="dateSend" style="display:none">
									Gewenste datum verzending *<br />
									<input type="text" name="verzendDatum" id="datumVerzending" value="<?php echo $_POST['verzendDatum']; ?>" /><br /><br />
								</div> <!-- einde Div dateSend -->

				<div id="naamOpdrachtgever" style="display:none">
        Naam opdrachtgever *<br />
				<input type="text" required name="opdrachtgever" value="<?php if(!isset($_POST['opdrachtgever'])){ echo $current_user->display_name; }else{ echo $_POST['opdrachtgever'];} ?>"  /><br /><br />
			</div> <!-- einde Div naamOpdrachtgever-->
				<div id="emailOpdrachtgever" style="display:none">
        E-mail opdrachtgever *<br />
				<input type="text" required name="emailopdrachtgever" value="<?php if(!isset($_POST['emailopdrachtgever'])){ echo $current_user->user_email; }else{ echo $_POST['emailopdrachtgever'];} ?>" /><br /><br />
			</div> <!-- einde Div emailOpdrachtgever-->

        Omschrijving opdracht*<br />
				<textarea id="mytextarea" name="beschrijving" rows="3" cols="30"><?php echo $_POST['beschrijving']; ?></textarea><br /><br />


				Projectmap op de (M:) schijf<br />
				<input type="text" name="locatie" value="<?php echo $_POST['locatie']; ?>" placeholder="URL invoeren" /><br /><br />

				<?php
					$contentbeheerders = $wpdb->get_results("SELECT * FROM Contentbeheerders" );
				?>
				 Voorkeur contentbeheerder<br/>
				<select name="contentbeheerder">
				<option value="Geen voorkeur" <?php if($_POST['contentbeheerder'] == "geenvoorkeur"){ ?>selected="selected"<?php } ?>>- Onbelangrijk -</option>
				<?php
					foreach($contentbeheerders as $contentbeheerder){
					$contentDetail = get_userdata($contentbeheerder->userID);?>
					<option value="<?php echo $contentbeheerder->userID; ?>"><?php echo $contentDetail->display_name; ?></option>
				<?php }
				?>
			</select><br /><br />

      <input type="hidden" name="uren" value="" id="myField" /><br /><br />

   	<!-- deze div wordt gebruikt om de juiste input te vragen per geselecteerde opdracht -->
			<div id="briefingInput" style="display:none">

                <p>Lever een complete briefing met de volgende elementen:

                - Inhoud (tekst), afbeeldingen meesturen per blok, tekst voor in buttons, links meesturen
                </p>

                </div>

                <!-- <div id="totaalUren" style="background:#FF0; color:#000; font-size:16px" ></div>-->

				<input type="submit" id="submit" name="submit" value="Briefing aanmaken">

            </form>

			<?php } ?>

		</div>
	</div>



	<div id="contentRechts">

	<!--
         <div class="contentHeaderActief">
			<h1>Voorbeeldweergave</h1>
		 </div>

 			 <img id="preview"><br />

		</div>
	-->
<div class="contentHeaderFeedback">
			<h1>Feedback</h1>
		</div>
		<div class="contentContent">
		<table border="0" cellpadding="5" cellspacing="3">
				
							<tr >
								<td valign="top">
									Heb je op- of aanmerkingen of heb je verbeterpunten voor het plansysteem van Contentbeheer? Zet ze in <a href="https://docs.google.com/spreadsheets/d/1VMrgRGmT0p_AjLQg7MGdvwWMfouZM9OivPgA3w6aRXM/edit?usp=sharing" target="_blank" style="text-decoration: underline;" >dit document</a>!
								</td>
							</tr>
			</table>
		</div>
	<?php
	global $wpdb;
	$nu = date('Ymd');
	if($userRole != 'author'){ ?>
	<div class="contentHeaderActief">
			<h1>Mijn briefings</h1>
		</div>
		<div class="contentContent">
		<table border="0" cellpadding="5" cellspacing="3">
				<?php

							$briefings2 = $wpdb->get_results( "SELECT * FROM Briefing WHERE ContactpersoonID = $current_user->ID AND Startdatum >= $nu ORDER BY Startdatum ASC");
				foreach( $briefings2 as $briefing2 ){
				$onderwerp = substr($briefing2->Titel, 0, 50);
				?>
							<tr >
								<td valign="top" width="150"> <B> <?php echo get_mooiedatum($briefing2->Startdatum); ?></B></td>
								<td valign="top" width="230"> <B><a href="http://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $briefing2->ID; ?>"><?php echo $onderwerp; ?></a></B></td>
								<td valign="top" width="120"><?php if(!empty($briefing2->ingepland)){ ?><img src="<?php bloginfo('template_url'); ?>/images/iconDefinitief.png"><?php } ?></td>
								<td valign="top"><a href="https://www.expect-webmedia.nl/drpr/briefing-contentbeheer/?delete=yes&id=<?php echo $briefing2->ID; ?>"  onclick="return confirm('Weet je zeker dat je deze opdracht wilt verwijderen?')"><img src="<?php bloginfo('template_url'); ?>/images/buttonDelete.png"></a></td>
							</tr>
				<?php }

					if(empty($briefings2)){
						echo "Je hebt nog geen opdrachten";
					}
				?>
			</table>
		</div>
		<?php } ?>


<?php
		if($userRole == 'administrator'){ ?>
		<div class="contentHeaderActief">
				<h1>Bij mij ingepland</h1>
			</div>
			<div class="contentContent">
			<table border="0" cellpadding="5" cellspacing="3">
					<?php
								$briefings2 = $wpdb->get_results( "SELECT * FROM Briefing WHERE IngeplandBij = $current_user->ID AND Startdatum >= $nu ORDER BY Startdatum ASC");

					foreach( $briefings2 as $briefing2 ){
					$onderwerp = substr($briefing2->Titel, 0, 50);
					?>
								<tr >
									<td valign="top" width="150"> <B> <?php echo get_mooiedatum($briefing2->Startdatum); ?></B></td>
									<td valign="top" width="230"> <B><a href="http://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $briefing2->ID; ?>"><?php echo $onderwerp; ?></a></B></td>
									<td valign="top" width="120"><?php if(!empty($briefing2->ingepland)){ ?><img src="<?php bloginfo('template_url'); ?>/images/iconDefinitief.png"><?php } ?></td>
									<td valign="top"><a href="https://www.expect-webmedia.nl/drpr/briefing-contentbeheer/?annuleren=yes&id=<?php echo $briefing2->ID; ?>"  onclick="return confirm('Weet je zeker dat je deze opdracht wilt annuleren?')"><img src="<?php bloginfo('template_url'); ?>/images/iconAnnuleren.png"></a></td>
								</tr>
					<?php }

						if(empty($briefings2)){
							echo "Je hebt nog geen opdrachten";
						}
					?>
				</table>
			</div>
			<?php } ?>


        <?php
			if($userRole == 'author'){
			$opdrachten = $wpdb->get_results( "SELECT * FROM Briefing WHERE ingepland != '1' AND planningVerzonden = '1' AND Startdatum >= $nu ORDER BY Startdatum ASC");
			$opdrachten2 = $wpdb->get_results( "SELECT * FROM Briefing WHERE ingepland = '1' AND Startdatum >= $nu ORDER BY Startdatum ASC");
		?>

        <div class="contentHeaderClipboard">
					<h1>Opdrachten die nog moeten worden ingepland</h1>
				</div>
				<div class="contentContent">
					<table border="0" cellpadding="5" cellspacing="3">
					<?php
						foreach($opdrachten as $opdracht){ ?>
							<tr >
								<td valign="top" width="120"> <B> <?php echo get_mooiedatum($opdracht->Startdatum); ?></B></td>
								<td valign="top"> <B>&nbsp;&nbsp;<a href="http://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $opdracht->ID; ?>"><?php echo $opdracht->Titel; ?></a></B></td>
							</tr>
						<?php }
						if(empty($opdrachten)){
							echo "Er zijn geen opdrachten";
						}
					?>
					</table>
				</div>

				<div class="contentHeaderClipboard">
					<h1>Ingeplande opdrachten</h1>
				</div>
				<div class="contentContent">
					<table border="0" cellpadding="5" cellspacing="3">
					<?php
						foreach($opdrachten2 as $opdracht2){ ?>
							<tr >
								<td valign="top" width="120"> <B> <?php echo get_mooiedatum($opdracht2->Startdatum); ?></B></td>
								<td valign="top"> <B>&nbsp;&nbsp;<a href="http://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $opdracht2->ID; ?>"><?php echo $opdracht2->Titel; ?></a></B></td>
							</tr>
						<?php }
						if(empty($opdrachten2)){
							echo "Er zijn geen opdrachten";
						}
					?>
					</table>
				</div>
				<?php } ?>


				 <?php
			if($userRole == 'administrator' || $userRole =='author'){
			$opdrachten = $wpdb->get_results( "SELECT * FROM Briefing WHERE ingepland != '1' AND planningVerzonden = '1' AND Startdatum >= $nu ORDER BY Startdatum ASC");
			$opdrachten2 = $wpdb->get_results( "SELECT * FROM Briefing WHERE ingepland = '1' AND Startdatum >= $nu ORDER BY Startdatum ASC");
		?>

        <div class="contentHeaderClipboard">
					<a name="contentbeheer"></a>
					<h1>Contentbeheerders</h1>
				</div>
				<div class="contentContent">
					<table border="0" cellpadding="5" cellspacing="3">
					<?php
					$contentbeheerders = $wpdb->get_results( "SELECT * FROM Contentbeheerders");
					foreach($contentbeheerders as $contentbeheerder){
						$user_info = get_userdata($contentbeheerder->userID);
						?>
						<tr>
							<td width="515"><?php echo $user_info->display_name; ?></td>
							<td><a href="/drpr/briefing-contentbeheer/?delCont=<?php echo $contentbeheerder->ID; ?>"><img src="<?php bloginfo('template_url'); ?>/images/buttonDelete.png" border="0"></a></td>
						</tr>
					<?php } ?>
						</table>
					<?php if(!$_GET['contentT']){ ?>
					<a href="https://www.expect-webmedia.nl/drpr/briefing-contentbeheer/?contentT=1"><img src="<?php bloginfo('template_url'); ?>/images/knopContentbeheerderToevoegen.png" border="0"></a>
					<?php }

					if($_GET['contentT']){
					$users = $wpdb->get_results( "SELECT * FROM wp_users WHERE ID != '1' ORDER BY display_name ASC");


					?>
					<div style="background: #393939; padding: 10px; border-radius: 10px; height: 150px;" class="addMid">
					<img src="<?php bloginfo('template_url'); ?>/images/knopContentbeheerderToevoegen.png" border="0">
						<form action="https://www.expect-webmedia.nl/drpr/briefing-contentbeheer/#contentbeheer" method="post">
						<br />
						Medewerkers<br />
						<select name="contentB">
							<?php
								foreach($users as $user){ ?>
									<option value="<?php echo $user->ID; ?>"><?php echo $user->display_name; ?>
								<?php }
							?>
						</select><br /><br />
						<a href="/drpr/briefing-contentbeheer/">Annuleren</a> <input type="submit" id="submit" name="addContent" value="Toevoegen">
						</form>
					</div>
					<?php } ?>
					<br /><br />
				</div>
				<?php } ?>


        </div>


<?php get_footer(); ob_end_flush(); ?>
