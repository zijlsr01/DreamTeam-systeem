<?php
/*
Template Name: Briefing Detail
*/
get_header();
		//gegevens van dreamteamer/promoteamer ophalen
		global $wpdb; $current_user;
		  get_currentuserinfo();

		$actID = $_GET['id'];

		if($_GET['deleteplan']){


						$wpdb->update( Briefing, array( 'ingepland' => '',/* 'ingeplandTijd' => '', 'correctieTijd' => '', */'ingeplandBij' => ''),array( 'ID' => $_GET['id']) );
						?>

					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
							Planning verwijderd!
					</div>

		<?php }

		$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );

		if($_GET['inplannen']){

			//verstuur email naar office
			if(empty($actDetails->planningVerzonden)){
			verzoekTotInplannen($actID,$actDetails->ContactpersoonID);

			//update database
			$wpdb->update( Briefing, array( 'planningVerzonden' => '1' ),array( 'ID' => $_GET['id']) ); ?>
			<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
							Verzoek voor inplannen is verzonden naar het office!
					</div>

			<?php }
		}


		//mail versturen
			if(isset($_GET['sendafgerondfase1'])){

					//MailBriefingReeks($ListID,$ActID,$mail);?>
					<?php // echo "Het werkt"; ?>

					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						E-mail met succes verstuurd!
					</div>
				<?php

			}



	//Inplanning bevestigen
	if($_POST['submitBevestig']){
		$dbDate = date("Ymd", strtotime($_POST['startDatum']));
		/*$inplanTijd = $_POST['startPlanTijd']." - ".$_POST['eindPlanTijd'];*/

		if(!empty($actDetails->Einddatum)){
		$datumCor = date("Ymd", strtotime($_POST['einddatum']));
		/*$corTijd = $_POST['startCorTijd']." - ".$_POST['eindCorTijd'];*/
		}

		if(!empty($actDetails->Verzenddatum)){
		$datumSend = date("Ymd", strtotime($_POST['verzenddatum']));
		/*$corTijd = $_POST['startCorTijd']." - ".$_POST['eindCorTijd'];*/
		}

		//kijken of alle gegevens zijn ingevuld

		if(empty($_POST['startDatum'])){ $error .= "<li>Je bent vergeten de ingeplande datum in te vullen</li>";}
		/*if(empty($_POST['startPlanTijd'])){ $error .= "<li>Je bent vergeten de starttijd voor de opdracht in te vullen</li>";}*/
		/*if(empty($_POST['eindPlanTijd'])){ $error .= "<li>Je bent vergeten de eindtijd voor de opdracht in te vullen</li>";}*/
		if(empty($_POST['einddatum']) && !empty($actDetails->Einddatum)){ $error .= "<li>Je bent vergeten de ingeplande datum voor de correcties in te vullen</li>";}
		/*if(empty($_POST['startCorTijd']) && !empty($actDetails->Einddatum)){ $error .= "<li>Je bent vergeten de starttijd voor de correcties in te vullen</li>";}*/
		/*if(empty($_POST['eindCorTijd']) && !empty($actDetails->Einddatum)){ $error .= "<li>Je bent vergeten de eindtijd voor de correcties in te vullen</li>";}*/


		if(empty($error)){
		$wpdb->update( Briefing, array('Startdatum' => $dbDate, 'Einddatum' => $datumCor, 'ingepland' => '1', 'reminder' => $_POST['reminder'], /* 'ingeplandTijd' => $inplanTijd, 'correctieTijd' => $corTijd, */
		'ingeplandBij' => $_POST['naamContentbeheerder'], 'Verzenddatum' => $datumSend ),array( 'ID' => $_GET['id']) );

		//En een mail versturen naar de opdrachtgever
		opdrachtIngepland($actID,$actDetails->ContactpersoonID);
		}
	}


			if($_GET['add'] == 'succes'){ ?>
	<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
		Opdracht met succes toegevoegd!
	</div>
	<?php }


					if($_POST['submit']){


			//kijken of er fouten zijn gemaakt
				if(empty($_POST['titel'])){	$error .= "<li>Je bent vergeten de titel in te vullen</li>";	}
				if(empty($_POST['projectnummer'])){	$error .= "<li>Je bent vergeten het projectnummer in te vullen</li>";	}
				if(empty($_POST['startDatum'])){	$error .= "<li>Je bent vergeten een datum in te vullen</li>";	}
				if(empty($_POST['beschrijving'])){	$error .= "<li>Je bent vergeten een beschrijving in te vullen</li>";}
				//if(empty($_POST['corTijd'])){ $error .= "<li>Je bent vergeten het correcties veld in te vullen</li>";	}
				if($_POST['categorie'] == 'keuze'){	$error .= "<li>Je bent vergeten een categorie te kiezen</li>";	}
				if($_POST['naamContentbeheerder'] == 'selectie'){	$error .= "<li>Je hebt niet aangegeven bij wie de opdracht is ingepland</li>";	}
				if($_POST['categorie'] == 'website' && $_POST['subcatWebsite'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Website in te vullen</li>";}
				if($_POST['categorie'] == 'website' && $_POST['subcatWebsite'] == 'panels' && $_POST['subcatWebsitePanels'] == 'keuze'){ $error .= "<li>Je bent vergeten om een panel te kiezen</li>";}
				if($_POST['categorie'] == 'website' && $_POST['subcatWebsite'] == 'landingspagina' && $_POST['subcatWebsiteLP'] == 'keuze'){ $error .= "<li>Je bent vergeten om een keuze te maken qua landingspagina</li>";}
				if($_POST['categorie'] == 'website' && $_POST['subcatWebsite'] == 'formulier' && $_POST['subcatWebsiteForm'] == 'keuze'){ $error .= "<li>Je bent vergeten om een keuze te maken qua formulier</li>";}

				if($_POST['categorie'] == 'website' && $_POST['subcatWebsite'] == 'webtekst' && $_POST['subcatWebsiteText'] == 'keuze'){ $error .= "<li>Je bent vergeten om een keuze te maken qua webtekst</li>";}

				if($_POST['categorie'] == 'mail' && $_POST['subcatMail'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Mail in te vullen</li>";	}
				if($_POST['categorie'] == 'banners' && $_POST['subcatBanners'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Banners in te vullen</li>";	}
				if($_POST['categorie'] == 'enquete' && $_POST['subcatEnquete'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Enquete in te vullen</li>";	}
				if($_POST['categorie'] == 'narrowcasting' && $_POST['subcatNarrowcasting'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Narrowcasting in te vullen</li>";	}
				if($_POST['categorie'] == 'overig' && $_POST['subcatOverig'] == 'keuze'){ $error .= "<li>Je bent vergeten om de subcategorie Overig te vullen</li>";	}

					} // Einde IF statement


					if($_POST['submit'] && empty($error)){
					//Activiteit updaten
						$dbDate = date("Ymd", strtotime($_POST['startDatum']));
						$datumCor = date("Ymd", strtotime($_POST['einddatum']));
						$datumVersturen = date("Ymd", strtotime($_POST['verzendDatum']));


						$wpdb->update( Briefing, array( 'Titel' => $_POST['titel'],'Projectnummer' => $_POST['projectnummer'], 'Startdatum' => $dbDate, 'Einddatum' => $datumCor,
						'Correcties' => $_POST['corTijd'], 'Omschrijving' => $_POST['beschrijving'], 'voorkeurContent' => $_POST['contentbeheerder'], 'Locatie' => $_POST['locatie'], 'actKey' => $actKey,
						'reminder' => $_POST['reminder'], 'Verzenddatum' => $datumVersturen ),array( 'ID' => $_GET['id']) );

						?>
						<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						Activiteit is met succes aangepast!
						</div>
						<?php }

						if(!empty($foutMelding)){ ?>
							<div  style="width: 1150px;  background-color: #ef413d; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
								<?php echo $foutMelding; ?>
							</div>
						<?php }
		$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );
	?>

	<?php
	//Student hoeft zich aangemeld, maar hoeft niet te werken
	if(!empty($_GET['delete']) && !empty($_GET['studid']) &&  !empty($_GET['actid']) && !empty($_GET['dbID'])){
					//$wpdb->query(   "  DELETE FROM Aanmeldingen WHERE StudID = ".$_GET['studid']." AND ActID = ".$_GET['actid']." "  );
					//$wpdb->query(   "  DELETE FROM Maillijst WHERE ActID = ".$_GET['actid']." "  );
					$wpdb->update( Aanmeldingen, array( 'hoeftNiet' => '1' ),array( 'ID' => $_GET['dbID']) );
				?>

				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					Aanmelding omgezet naar "Hoeft niet te werken"
				</div>
				<?php } ?>

				<?php

				// Student stond op hoeft niet te werken, maar wordt nu alsnog ingeroosterd
				if(!empty($_GET['delete']) && !empty($_GET['studid']) &&  !empty($_GET['actid']) && !empty($_GET['dbID2'])){
					$wpdb->update( Aanmeldingen, array( 'hoeftNiet' => '' ),array( 'ID' => $_GET['dbID2']) );
				?>

				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					Aanmelding omgezet naar "Hoeft niet te werken"
				</div>
				<?php } ?>

				<?php
				if(!empty($_GET['deletemail']) && !empty($_GET['listid'])){

					$wpdb->query(   " DELETE FROM BriefingMaillijst WHERE ID = ".$_GET['listid']." "  );
				?>

				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					E-mail met succes verwijderd!
				</div>

				<?php } ?>
	<div style="clear: both;"></div>

	<div id="contentLinks">
		<div class="contentHeader">
        <?php if(empty($_GET['edit']) || !empty($show) && empty($error)){

			$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );

		}
		?>
        <h1>

					<?php if(!empty($actDetails->Titel))

						echo $actDetails->Titel;

						else {
							echo "404";
						}
					 ?>

				</h1>

			<div class="edit"><a href="https://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $actDetails->ID; ?>" id="refresh"><img src="<?php bloginfo('template_url'); ?>/images/iconRefresh.png" title="Ververs pagina"></a><?php if(!isset($_GET['edit'])){ ?><a href="http://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $actDetails->ID; ?>&edit=1" ><img src="<?php bloginfo('template_url'); ?>/images/edit.png" alt="" title="bewerk de gegevens" /></a><?php } ?><a href="https://www.expect-webmedia.nl/drpr/briefing-contentbeheer/?delete=yes&id=<?php echo $actDetails->ID; ?>" ><img src="<?php bloginfo('template_url'); ?>/images/iconDelete.png" alt="" title="Verwijder opdracht" onclick="return confirm('Weet je zeker dat je deze opdracht wilt verwijderen?')"/></a></div>
</div>
		<div class="contentContent">

			<?php if (!$actDetails)  {?>


				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<?php echo "Deze briefing bestaat niet (meer) in het systeem!"; ?>
						</td>
					</tr>
				</table>

			<?php }

			elseif (condition) { ?>




		<?php if(empty($_GET['edit']) || !empty($show) && empty($error)){

			$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" ); ?>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top"><b>Uren</b></td>
					<td valign="top"><b>:</b></td>
					<td valign="top" ><b><?php echo $actDetails->Uren; ?> uur</b></td>
				</tr>
				<tr>
					<td valign="top">Projectnummer</td>
					<td valign="top">:</td>
					<td valign="top" ><?php echo $actDetails->Projectnummer; ?></td>
				</tr>
				<tr>
					<td valign="top">Gewenste datum</td>
					<td valign="top">:</td>
					<td valign="top"><?php mooiedatum($actDetails->Startdatum); ?></td>
				</tr>
				<tr>
					<td valign="top" width="130">Terugkeerpatroon</td>
					<td valign="top">:</td>
					<td valign="top">

						<?php

						if(empty($actDetails->Terugkeerpatroon)){
							echo "<b>N.v.t.</b>";
						}
						else{ ?>
									<u><?php echo $actDetails->Terugkeerpatroon; ?></u>
						<?php } ?>

						</td>
				</tr>
				<tr>
					<td valign="top"> Projectmap op de (M:) schijf</td>
					<td valign="top">:</td>
					<td valign="top" ><?php echo $actDetails->Locatie; ?></td>
				</tr>
				<?php $user_info = get_userdata($actDetails->voorkeurContent);	?>
				<tr>
					<td valign="top">Voorkeur contentbeheerder</td>
					<td valign="top">:</td>
					<td valign="top">
						<?php
						if(empty($user_info->display_name)){
							echo "<b>Geen voorkeur</b>";
						}
						else{
							echo $user_info->display_name; ?>
					<?php	}
					?>
					</td>
				</tr>
				<!--
				<tr>
					<td valign="top">Categorie</td>
					<td valign="top">:</td>
					<td valign="top"><?php // echo $actDetails->Categorie; ?></td>
				</tr
			-->
		</table>

		<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="130"><b>Correcties</b></td>
					<td valign="top"><b>:</b></td>
					<td valign="top">
						<?php

						if(empty($actDetails->Einddatum)){
							echo "<b>Geen</b>";
						}
						else{
							echo $actDetails->Correcties;?> uur
					<?php	}
					?>
					</td>
				</tr>
        <tr>
					<td valign="top">Gewenste datum correcties</td>
					<td valign="top">:</td>
					<td valign="top">
						<?php
						if(empty($actDetails->Einddatum)){
							echo "N.v.t.";
						}
						else{
							echo mooiedatum($actDetails->Einddatum);
						}
					?>
					</td>
				</tr>
			</table>

			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="130"><b>Gewenste datum versturen</b></td>
					<td valign="top">:</td>
					<td valign="top">
					<?php

					if(empty($actDetails->Verzenddatum)){
						echo "<b>N.v.t.</b>";
					}
					else{ ?>
						<b> <?php echo mooiedatum($actDetails->Verzenddatum);?></b>
					<?php }
				?>
				</td>
			</tr>
			</table>



			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="130">Opdrachtgever</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $actDetails->Opdrachtgever; ?></a></td>
				</tr>
				<tr>
					<td valign="top">E-mailadres opdrachtgever</td>
					<td valign="top">:</td>
					<td valign="top"><a href="mailto:<?php echo $actDetails->Contactemail; ?>"><?php echo $actDetails->Contactemail; ?></a></td>
				</tr>
				<tr>
					<td valign="top" width="130">Omschrijving opdracht</td>
					<td valign="top">:</td>
					<td valign="top" ><?php echo $actDetails->Omschrijving; ?></td>
				</tr>

			</table>
			<?php }

			if(!empty($_GET['edit']) && !empty($_GET['id']) || empty($_GET['edit']) && !empty($error) && $_POST['submit']){
            $actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" ); ?>

				<?php if($_POST['submit'] && !empty($error)){ ?>
				<div id="alert">
					<ul>
						<?php echo $error; ?>
					</ul>
				</div>
				<?php } ?>

				<form action="https://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $_GET['id'];?>&show=1 " method="post">

				Omschrijving opdracht *<br />
				<input type="text" name="titel" value="<?php if(!isset($_POST['titel'])){ echo $actDetails->Titel; }else{ echo $_POST['titel'];} ?>" /><br /><br />

				Projectnummer *<br />
				<input type="text" name="projectnummer" id="projectnummer" value="<?php echo $actDetails->Projectnummer; ?>" /><br /><br />

        Gewenste datum *<br />
				<input type="text" name="startDatum" id="datum" value="<?php mooiedatum3($actDetails->Startdatum); ?>" /><br /><br />


				<?php if(!empty($actDetails->Einddatum)){ ?>
				Gewenste datum correcties<br />
				<input type="text" name="einddatum" id="datumNew" value="<?php mooiedatum3($actDetails->Einddatum); ?>" /><br /><br />

				<?php if($actDetails->Correcties){ ?>
				Uren correcties *<br />
				<select name="corTijd" required>
        	<option value="0.50" <?php if($actDetails->Correcties == "0.50"){ ?>selected="selected"<?php } ?>>0.50 uur</option>
					<option value="1.00" <?php if($actDetails->Correcties == "1.00"){ ?>selected="selected"<?php } ?>>1.00 uur</option>
          <option value="1.50" <?php if($actDetails->Correcties == "1.50"){ ?>selected="selected"<?php } ?>>1.50 uur</option>
				</select><br /><br />

				<?php  }
				} ?>

				<?php if(!empty($actDetails->Verzenddatum)){ ?>
				Datum versturen<br />
				<input type="text" name="verzendDatum" id="datumVerzenden" value="<?php mooiedatum3($actDetails->Verzenddatum); ?>" /><br /><br />
				<?php } // einde if !empty Verzenddatum ?>

				 Projectmap op de (M:) schijf *<br />
				<input type="text" name="locatie" value="<?php echo $actDetails->Locatie; ?>" /><br /><br />

				Omschrijving opdracht*<br />
				<textarea id="mytextarea"   name="beschrijving"><?php echo $actDetails->Omschrijving; ?></textarea><br /><br />

				<?php
					$contentbeheerders = $wpdb->get_results("SELECT * FROM Contentbeheerders" );
					$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );
				?>

				Voorkeur contentbeheerder<br/>
			 <select name="contentbeheerder">
			 <option value="<?php echo $actDetails->voorkeurContent; ?>"</option>


			 <?php
				 foreach($contentbeheerders as $contentbeheerder){
				 $contentDetail = get_userdata($contentbeheerder->userID);?>
				 <option value="<?php echo $contentbeheerder->userID; ?>"><?php echo $contentDetail->display_name; ?></option>
			 <?php }
			 ?>
		 </select><br /><br />



				<a href="http://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $actDetails->ID; ?> ">Annuleren</a> <input type="submit" id="submit" name="submit" value="Opdracht bijwerken">
			</form>
			<?php } ?>

			<?php } //einde if (!$actDetails) ?>
		</div>
        </div>

        <div id="contentRechts">
		<?php
		$user_info = get_userdata($current_user->ID);
		$userRole = implode(', ', $user_info->roles);
		?>
		 <?php if($userRole != 'author'){?>
		<div class="contentHeaderActief"><h1>Planning</h1></div>
		<div class="contentContent">
			<?php 	$contentDetail2 = get_userdata($actDetails->ingeplandBij);?>
		<?php if(!empty($actDetails->ingeplandBij)){ ?>
		<table border="0" cellpadding="5" cellspacing="3">
					<tr>
						<td>Ingepland bij</td>
						<td>:</td>
						<td><?php echo $contentDetail2->display_name; ?></td>
					</tr>
					<tr>
						<td>Datum</td>
						<td>:</td>
						<td><?php echo mooiedatum($actDetails->Startdatum); ?></td>
					</tr>
					<!--<tr>
						<td>Tijd</td>
						<td>:</td>
						<td><?php// echo $actDetails->ingeplandTijd; ?> uur</td>
					</tr>

				-->
					<?php if(!empty($actDetails->Einddatum)){ ?>
					<tr>
						<td>Datum Correcties</td>
						<td>:</td>
						<td><?php echo mooiedatum($actDetails->Einddatum); ?></td>
					</tr>
					<!-- <tr>
						<td>Tijd</td>
						<td>:</td>
						<td><?php// echo $actDetails->correctieTijd; ?> uur</td>
					</tr>
				-->
					<?php }else{
						$geen = "Er is geen correctieronde ingepland.";
					} ?>

				 </table>
				<?php
					echo $geen;
				}else{
					echo "Opdracht is nog niet ingepland";
				}

				?> <br/>


		</div>
		<?php }else{?>

		<div class="contentHeaderActief">
			<?php if(empty($actDetails->ingepland)){ ?>
				<h1>Planning</h1><?php } ?>
				<?php if(!empty($actDetails->ingepland)){ ?>
					<h1>Planning</h1><div class="edit"><a href="https://www.expect-webmedia.nl/drpr/briefing-detail/?deleteplan=yes&id=<?php echo $actDetails->ID; ?>" ><img src="<?php bloginfo('template_url'); ?>/images/iconDelete.png" alt="" title="Verwijder planning" onclick="return confirm('Weet je zeker dat je deze planning wilt verwijderen?')"/></a></div><?php } ?></div>

		<div class="contentContent">
			<?php if(empty($actDetails->ingepland)){ ?>
			<?php if($_POST['submitBevestig'] && !empty($error)){ ?>
					<div id="alert">
					<ul>
						<?php echo $error; ?>
					</ul>
				</div>

				<?php } ?>
			<div style="width: 480px; display: block;"><p>Pas eventueel de datum(s) aan</p></div>

			<form action="https://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $_GET['id'];?>" method="post">

				Datum *<br />
				<input type="text" name="startDatum" id="datum" value="<?php mooiedatum3($actDetails->Startdatum); ?>" /><br /><br />
				<!-- Start- &amp; eindtijd<br />
				<input type="text" name="startPlanTijd" id="startTijd2" value="<?php // echo $_POST['startPlanTijd']; ?>" style="width: 100px;"/> &nbsp;<input type="text" name="eindPlanTijd" id="eindTijd2" value="<?php // echo $_POST['eindPlanTijd']; ?>" style="width: 100px;"/><br /><br />
				-->
				<?php if(!empty($actDetails->Einddatum)){ ?>
				Datum Correcties*<br />
				<input type="text" name="einddatum" id="datumCor" value="<?php mooiedatum3($actDetails->Einddatum); ?>" /><br /><br />
				<?php } ?>

				<?php if(!empty($actDetails->Verzenddatum)){ ?>
				Datum Versturen*<br />
				<input type="text" name="verzenddatum" id="datumVerzending" value="<?php mooiedatum3($actDetails->Verzenddatum); ?>" /><br /><br />

				<!-- Start- &amp; eindtijd<br />
				<input type="text" name="startCorTijd" id="startTijd" value="<?php // echo $_POST['startCorTijd']; ?>" style="width: 100px;"/> &nbsp;<input type="text" name="eindCorTijd" id="eindTijd" value="<?php // echo $_POST['eindCorTijd']; ?>" style="width: 100px;"/><br /><br /> -->
				<?php } ?>

			<?php
					$contentbeheerders = $wpdb->get_results("SELECT * FROM Contentbeheerders" );
				?>

				Bij wie is deze opdracht ingepland?<br/>
				<select name="naamContentbeheerder">
					<option value="selectie" <?php if($_POST['naamContentbeheerder'] == "selectie"){ ?>selected="selected"<?php } ?>>- Selecteer -</option>
					<?php
					foreach($contentbeheerders as $contentbeheerder){
					$contentDetail = get_userdata($contentbeheerder->userID);?>
					<option value="<?php echo $contentbeheerder->userID; ?>"><?php echo $contentDetail->display_name; ?></option>
					<?php
					} ?>
				</select><br/><br/>





				<input type="submit" id="submit" name="submitBevestig" value="Inplanning bevestigen">
			</form>
			<?php }
				else{
					$contentDetail2 = get_userdata($actDetails->ingeplandBij);?>

				 <table border="0" cellpadding="5" cellspacing="3">
					<tr>
						<td>Ingepland bij</td>
						<td>:</td>
						<td><?php echo $contentDetail2->display_name; ?></td>
					</tr>
					<tr>
						<td>Datum</td>
						<td>:</td>
						<td><?php echo mooiedatum($actDetails->Startdatum); ?></td>
					</tr>
					<!--
					<tr>
						<td>Tijd</td>
						<td>:</td>
						<td><?php //echo $actDetails->ingeplandTijd; ?> uur</td>
					</tr>
				-->

					<tr>
						<td>Correcties</td>
						<td>:</td>
						<td>
							<?php if(!empty($actDetails->Einddatum)){
							echo mooiedatum($actDetails->Einddatum);
						 	}
					else{
								$geen = "Er is geen correctieronde ingepland.";
								echo $geen;
								} ?>
						</td>
					</tr>


					<tr>
						<td>Verzenden</td>
						<td>:</td>
						<td>
							<?php if(!empty($actDetails->Verzenddatum)){
							echo mooiedatum($actDetails->Verzenddatum);
							}
					else{
								$geen = "Er is geen verzenden ingepland.";
								echo $geen;
								} ?>
						</td>
					</tr>


					<?php }?>
					<!--<tr>
						<td>Tijd</td>
						<td>:</td>
						<td><?php //echo $actDetails->correctieTijd; ?> uur</td>
					</tr>
				-->



				<!--<tr>
					<td>Tijd</td>
					<td>:</td>
					<td><?php //echo $actDetails->correctieTijd; ?> uur</td>
				</tr>
			-->


				 </table>

		</div>
		<?php } ?>


						<?php // Omzetten uren basis opdracht (zonder correcties/ zonder verzenden)database naar iCal uren

						$urenDatabaseBasis = $actDetails->Uren;
						$urenDatabaseCorrecties = $actDetails->Correcties;


						switch ($urenDatabaseBasis) {
							case "0.50":
								$tijdIcalBasis = '093000';
						case "1.00":
							$tijdIcalBasis = '100000';
							break;
						case "1.50":
							$tijdIcalBasis = '103000';
							break;
						case "2.00":
							$tijdIcalBasis = '110000';
							break;
						case "2.50":
							$tijdIcalBasis = '113000';
							break;
						case "3.00":
							$tijdIcalBasis = '120000';
							break;
						case "3.50":
							$tijdIcalBasis = '123000';
							break;
						case "4.00":
							$tijdIcalBasis = '130000';
							break;
						case "4.50":
							$tijdIcalBasis = '133000';
							break;
						case "5.00":
							$tijdIcalBasis = '140000';
							break;
						case "5.50":
							$tijdIcalBasis = '143000';
							break;
						case "6.00":
							$tijdIcalBasis = '150000';
							break;
						case "6.50":
							$tijdIcalBasis = '153000';
								break;
						case "7.00":
							$tijdIcalBasis = '160000';
								break;
						case "7.30":
							$tijdIcalBasis = '163000';
										break;
						case "8.00":
							$tijdIcalBasis = '170000';
								break;
						}

						switch ($urenDatabaseCorrecties) {
						case "0.50":
							$tijdIcalCorrecties = '093000';
							break;
						case "1.00":
							$tijdIcalCorrecties  = '100000';
							break;
						case "1.50":
							$tijdIcalCorrecties  = '103000';
							break;

						}
						?>



           <div class="button" onclick="location.href='https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/doc.php?id=<?php echo $actDetails->ID; ?>';">Download briefing</div>

						<?php if($userRole == 'author'){ ?>

						<div class="divider"/></div>
		  			<div class="button" onclick="location.href='https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/ical.php?date=<?php echo $actDetails->Startdatum; ?>&amp;startTime=0900&amp;endTime=<?php echo $tijdIcalBasis; ?> &amp;subject=<?php echo $actDetails->Titel; ?> - Prj.nr. <?php echo $actDetails->Projectnummer; ?> &amp;desc=Link naar de briefing: https://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $actDetails->ID; ?>';">iCal Opdracht</div>

					 <?php
					 // Alleen iCal correcties knop laten zien wanneer er correcties zijn.
					 if (!empty($actDetails->Einddatum)){ ?>
					 <div class="divider"/></div>
					 <div class="button" onclick="location.href='https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/ical.php?date=<?php echo $actDetails->Einddatum; ?>&amp;startTime=0900&amp;endTime=<?php echo $tijdIcalCorrecties; ?> &amp;subject=Correcties <?php echo $actDetails->Titel; ?> - Prj.nr. <?php echo $actDetails->Projectnummer; ?>&amp;desc=Link naar de briefing: https://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $actDetails->ID; ?>';">iCal Correcties</div>

					<?php }

					// Alleen iCal correcties knop laten zien wanneer er orrecties zijn.
					if (!empty($actDetails->Verzenddatum)){ ?>
					<div class="divider"/></div>
					<div class="button" onclick="location.href='https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/ical.php?date=<?php echo $actDetails->Verzenddatum; ?>&amp;startTime=0900&amp;endTime=0930&amp;subject=Versturen <?php echo $actDetails->Titel; ?> - Prj.nr. <?php echo $actDetails->Projectnummer; ?>&amp;desc=Link naar de briefing: https://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php echo $actDetails->ID; ?>';">iCal Versturen</div>

				 <?php }

					} // einde if author
							?>



			 	<?php
				if(empty($actDetails->ingepland) && empty($actDetails->planningVerzonden)&& $userRole != 'author'){ ?>
			  <div class="buttonTime" onclick="location.href='https://www.expect-webmedia.nl/drpr/briefing-mail-nieuw/';">Mail voor inplannen</div>
		   <?php }?>

			 		<div class="divider"/></div>

		 <?php if(!empty($actDetails->ingepland)){ ?>
			<div class="buttonTime2" style="cursor: default;">Opdracht ingepland</div>
			 <?php } ?>

				<div class="divider"/></div>


			 <?php if(empty($actDetails->Voltooid) && current_user_can('administrator') ) { ?>
			 <div class="buttonTime" onclick="location.href='#';">Opdracht voltooien</div>
			 <?php } ?>



			 <?php if(!empty($actDetails->Voltooid)){ ?>
		<div class="buttonTime2" style="cursor: default;">Opdracht voltooid</div>
		 <?php } ?>

		 <div class="divider"/></div>

		   <?php if(!empty($actDetails->planningVerzonden) && $actDetails->ingepland != '1'){ ?>
		   <div class="buttonTime3" style="cursor: default;">Nog niet ingepland</div>
			 	 <div class="divider"/></div>
		  <?php } ?>



    		<div class="buttonAdd" onclick="location.href='/drpr/briefing-contentbeheer/'">Nieuwe briefing</div>



				<div class="contentHeader6">
				<?php
						global $wpdb;
						//$mailingen= $wpdb->get_results( "SELECT * FROM Maillijst WHERE ActID = '".$_GET['id']."' ORDER BY ID DESC" );


						$mailingen = $wpdb->get_results( "SELECT * FROM BriefingMaillijst WHERE ActID LIKE '%".$_GET['id']."%'" );


						?>
					<h1>E-mails</h1>
				</div>
				<div class="contentContent">
					<table border="0" cellpadding="5" cellspacing="3">
					<?php
						foreach( $mailingen as $mail ){ ?>
						<tr>
							<td valign="top" title=""><a href="https://www.expect-webmedia.nl/drpr/briefing-mail-detail/?mailID=<?php echo $mail->ID; ?>"><?php echo $mail->Naam; ?></a>
							<?php if($mail->Verzonden == '1'){
								echo "<small>(Deze e-mail is verzonden)</small>";
							}else{
								echo "<small>(Deze e-mail is nog niet verzonden)</small>";
							}
								?>
							</td>
						</tr>
						<?php }

						if(empty($mailingen)){
							echo "Er zijn nog geen E-mails!";
						} ?>
					</table>
				</div>

	</div>

<?php
get_footer();
