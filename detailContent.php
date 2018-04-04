<?php 
/*
Template Name: Contentkalender Detail
*/
get_header(); 
		//gegevens van dreamteamer/promoteamer ophalen
		global $wpdb; $current_user;
		get_currentuserinfo();
		$actID = $_GET['id'];
		$actDetails = $wpdb->get_row("SELECT * FROM Content WHERE ID = $actID" );
		
	
			if($_GET['add'] == 'succes'){ ?>
	<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
		Campagne met succes toegevoegd!
	</div>
	<?php }
	
			if(!empty($_GET['camMidDel'])){
				$camMidID = $_GET['camMidDel'];
				$wpdb->query(   "  DELETE FROM CampagneMiddelen WHERE ID = ".$camMidID." "  );
				?>
				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						Campagnemiddel verwijderd
					</div>
				<?php
			}
			
			if($_POST['addMid']){

				if($_POST['middel'] == "selectie"){
					$errorMid = "Kies een campagne middel";
				}

				if(empty($errorMid)){
					$wpdb->insert( CampagneMiddelen, array( 'Campagne' => $actDetails->ID, 'Kanaal' => $_POST['kanaal'], 'Middel' => $_POST['middel'], 'URL' => $_POST['addURL'], 'omschrijving' => $_POST['addMidDis'] ) );
					?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						Campagnemiddel toegevoegd!
					</div>
					<?php
				}
			}
		 
					if($_POST['submit']){ 
				//kijken of er fouten zijn gemaakt
				if(empty($_POST['titel'])){	$error .= "<li>Je bent vergeten de titel in te vullen</li>";	}
				if(empty($_POST['startTijd'])){	$error .= "<li>Je bent vergeten een starttijd in te vullen</li>";	}
				if(empty($_POST['eindTijd'])){	$error .= "<li>je bent vergeten een eindtijd in te vullen</li>";}
				if(empty($_POST['beschrijving'])){	$error .= "<li>Je bent vergeten een beschrijving in te vullen</li>";}
				if($_POST['contactpersoon'] == 'keuze'){ $error .= "<li>Je bent vergeten een contactpersoon in te vullen</li>";	}
				if(empty($_POST['camURL'])){ $error .= "<li>Je bent vergeten de url van de landingspagina in te vullen</li>";	}
				if(empty($_POST['conURL'])){ $error .= "<li>Je bent vergeten de url van de conversiepagina in te vullen</li>";	}
				if($_POST['doelgroep'] == 'keuze'){	$error .= "<li>Je bent vergeten een doelgroep in te vullen</li>";	}
				}



					if($_POST['submit'] && empty($error)){
					//Campagne updaten
						$userData = get_userdata($_POST['contactpersoon']);
						if($actDetails->type == 'Campagne'){
							$kanalen = implode(",", $_POST['kanaal']);
						}
						
						$startD = date("Ymd", strtotime($_POST['startTijd']));
						$eindD = date("Ymd", strtotime($_POST['eindTijd']));
						
						$wpdb->update( Content, array( 'Titel' => $_POST['titel'], 'Tijd_van' => $startD, 'Tijd_tot' => $eindD, 'Omschrijving' => $_POST['beschrijving'], 'ContactpersoonID' => $_POST['contactpersoon'],'Contactpersoon' => $userData->display_name, 'Doelgroep' => $_POST['doelgroep'], 'Kanalen' => $kanalen, 'Opmerkingen' => $_POST['opmerkingen'], 'CampagnePage' => $_POST['camURL'], 'conURL' => $_POST['conURL'] ),array( 'ID' => $_GET['id']) ); 

						?>
						<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					Gegevens zijn met succes aangepast!
						</div>
						<?php }
						
						if(!empty($foutMelding)){ ?>
							<div  style="width: 1150px;  background-color: #ef413d; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
								<?php echo $foutMelding; ?>
							</div>
						<?php }
		$actDetails = $wpdb->get_row("SELECT * FROM Content WHERE ID = $actID" );
	?><?php

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

					$wpdb->query(   " DELETE FROM Maillijst WHERE ID = ".$_GET['listid']." "  );
				?>
			
				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					E-mail met succes verwijderd!
				</div>
				<?php } ?>
	<div style="clear: both;"></div>
	<div id="contentLinks">
		<div style="height: 5px; width: 590px; background: <?php echo $actDetails->kleur; ?>; float: left;">&nbsp;</div>
		<div class="contentHeaderContent">
		<div class="contentHeaderIcon"><?php echo getIconGroot($actDetails->type); ?></div>
			<h1><?php echo $actDetails->type.": ".$actDetails->Titel; ?></h1>
			<div class="edit"><?php if(!isset($_GET['edit'])){ ?><a href="/drpr/contentdetail/?id=<?php echo $actDetails->ID; ?>&edit=1" ><img src="<?php bloginfo('template_url'); ?>/images/edit.png" alt="" title="Bewerk de gegevens" /></a><?php } ?><a href="/drpr/contentkalender?delete=yes&id=<?php echo $actDetails->ID; ?>" ><img src="<?php bloginfo('template_url'); ?>/images/iconDelete.png" alt="" title="Verwijderen" onclick="return confirm('Weet je zeker dat je deze campagne wilt verwijderen?')"/></a></div>
		</div>
		<div class="contentContentdr" >
		<?php if(empty($_GET['edit']) || !empty($show) && empty($error)){ 
		
		$actDetails = $wpdb->get_row("SELECT * FROM Content WHERE ID = $actID" );
		?>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="130"> <?php echo $actDetails->type; ?></td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $actDetails->Titel; ?><br></td>
				</tr>
				<tr>
					<td valign="top"><?php if($actDetails->type == 'Campagne'){
						echo "Looptijd"; }else{
							echo "Datum";
						} ?></td>
					<td valign="top">:</td>
					<td valign="top"><?php if($actDetails->type == 'Campagne'){
						echo mooiedatum($actDetails->Tijd_van);
						echo " - ";
						echo mooiedatum($actDetails->Tijd_tot);}else{
							echo mooiedatum($actDetails->Tijd_tot); 
						} ?></td>
				</tr>
				<tr>
					<td valign="top">Omschrijving</td>
					<td valign="top">:</td>
					<td valign="top" ><?php echo $actDetails->Omschrijving; ?></td>
				</tr>
			</table><br /><br />
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="130">Ingepland door</td>
					<td valign="top">:</td>
					<td valign="top"><a href="mailto:<?php echo $actDetails->Contactemail; ?>"><?php echo $actDetails->Contactpersoon; ?></a></td>
				</tr>
			<?php if($actDetails->type == 'Campagne'){ ?>
				<tr>
					<td valign="top">Doelgroep</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $actDetails->Doelgroep; ?></td>
				</tr>
			<?php } ?>
			<?php if($actDetails->type == 'Campagne'){ ?>
				<tr>
					<td valign="top">Campagne landingspagina</td>
					<td valign="top">:</td>
					<td valign="top"><a href="<?php echo $actDetails->CampagnePage; ?>" target="_blank"><?php echo $actDetails->CampagnePage; ?></a></td>
				</tr>
				<tr>
					<td valign="top">Campagne <br />conversiepagina</td>
					<td valign="top">:</td>
					<td valign="top"><a href="<?php echo $actDetails->conURL; ?>" target="_blank"><?php echo $actDetails->conURL; ?></a></td>
				</tr>
			<?php } ?>
				<tr>
					<td valign="top">Aanvullende informatie</td>
					<td valign="top">:</td>
					<td valign="top" ><?php echo $actDetails->Opmerkingen; ?></td>
				</tr>
			</table>
			<?php }


				
			if(!empty($_GET['edit']) && !empty($_GET['id']) || empty($_GET['edit']) && !empty($error) && $_POST['submit']){ 
			$actId = $_GET['id'];
			$actDetails = $wpdb->get_row("SELECT * FROM Content WHERE ID = $actID" );
			?>

				<?php if($_POST['submit'] && !empty($error)){ ?>
				<div id="alert">
					<ul>
						<?php echo $error; ?>
					</ul>
				</div>
				<?php } 
				$startD = date("d-m-Y", strtotime($actDetails->Tijd_van));
				$endD = date("d-m-Y", strtotime($actDetails->Tijd_tot));
				
				?>
				
				<form action="https://www.expect-webmedia.nl/drpr/contentdetail/?id=<?php echo $_GET['id'];?>&show=1 " method="post">
				Naam campagne *<br />
				<input type="text" name="titel" value="<?php if(!isset($_POST['titel'])){ echo $actDetails->Titel; }else{ echo $_POST['titel'];} ?>" /><br /><br />
				Startdatum<br />
				
				<input type="text" name="startTijd" id="startDate" value="<?php echo $startD; ?>" /><br /><br />
				Einddatum<br />
				<input type="text" name="eindTijd" id="endDate" value="<?php echo $endD; ?>" /><br /><br />
				Omschrijving *<br />
				<textarea name="beschrijving"><?php echo  $actDetails->Omschrijving ?></textarea><br /><br />
				<?php if($actDetails->type == 'Campagne'){ ?>
				Welke Kanalen worden voor deze campagne ingezet *<br />
				<table border="0" cellpadding="0" cellspacing="5">
						<?php 
							$kanalen = $wpdb->get_results( "SELECT * FROM Kanalen ORDER BY ID" );
							$arKanalen = explode(",", $actDetails->Kanalen);
						
							foreach($kanalen as $kanaal){ ?>
							<tr>			
							<td valign="top"><input type="checkbox" class="check" name="kanaal[]" id="<?php echo $kanaal->ID; ?>" value="<?php echo $kanaal->ID; ?>" <?php if(!empty($_POST['kanaal']) && !empty($error) &&  in_array( $kanaal->ID, $_POST['kanaal'])){ ?>checked<?php } if(empty($error) && in_array($kanaal->ID, $arKanalen)){ echo "checked"; } ?>></td><td><label for="<?php echo $kanaal->ID; ?>"><?php echo $kanaal->Kanaal; ?></label></td>	
							</tr>
							<?php }
						
						?></table>
				<br /><br />URL landingpagina *<br />
				<input type="text" name="camURL" value="<?php if(!isset($_POST['camURL'])){ echo $actDetails->CampagnePage; }else{ echo $_POST['camURL'];} ?>" /><br /><br />
				URL conversiepagina *<br />
				<input type="text" name="conURL" value="<?php if(!isset($_POST['conURL'])){ echo $actDetails->conURL; }else{ echo $_POST['conURL'];} ?>" /><br /><br />
				<?php } ?>
				Naam contactpersoon *<br />
				<select name="contactpersoon">
				<option value="keuze">- Maak een keuze - </option>
				<?php
					$contactpersonen = $wpdb->get_results( "SELECT * FROM wp_users ORDER BY display_name DESC" );
					foreach($contactpersonen as $contactpersoon){ 
				?>
					<option value="<?php echo $contactpersoon->ID; ?>" <?php if($actDetails->Contactpersoon == $contactpersoon->display_name){ ?>selected="selected"<?php } ?>><?php echo $contactpersoon->display_name; ?></option>
				<?php } ?>
				</select><br /><br />
				<?php if($actDetails->type == 'Campagne'){ ?>
				Doelgroep *<br />
				<select name="doelgroep">
					<option value="keuze" <?php if($actDetails->Doelgroep == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="werving" <?php if($actDetails->Doelgroep == "werving"){ ?>selected="selected"<?php } ?>>Werving</option>
					<option value="branding" <?php if($actDetails->Doelgroep == "branding"){ ?>selected="selected"<?php } ?>>Branding</option>
					<option value="corporate" <?php if($actDetails->Doelgroep == "corporate"){ ?>selected="selected"<?php } ?>>Corporate</option>
				</select><br /><br />
				<?php } ?>
				Aanvullende informatie<br />
				<textarea name="opmerkingen"><?php echo $actDetails->Opmerkingen; ?></textarea><br /><br />
				<a href="/drpr/contentdetail/?id=<?php echo $actDetails->ID; ?> ">Annuleren</a> <input type="submit" id="submit" name="submit" value="Bijwerken">
			</form>
			<?php } ?>
		</div>
	</div>

	<div id="contentRechts">
	<?php if($actDetails->type == 'Campagne'){ ?>
		<div style="height: 5px; width: 590px; background: <?php echo $actDetails->kleur; ?>; float: left;">&nbsp;</div>
		<div class="contentHeader3">
		<?php 
				global $wpdb;
				$vandaag = date('Ymd');
				$kanalen = $wpdb->get_var( "SELECT Kanalen FROM Content WHERE ID = '".$actDetails->ID."'" );
				$kanalen2 = explode( ',', $kanalen );
				
				?>
			<h1>Kanalen en middelen</h1>
		</div>
		<div class="contentContentdr">
			<table border="0" cellpadding="5" cellspacing="3">
			<?php
				foreach( $kanalen2 as $kanaal ){ 
					$kanaalDetails = $wpdb->get_row( "SELECT * FROM Kanalen WHERE ID = '".$kanaal."'" );
				?>
				<tr>
					<td valign="top"  colspan="2"><b><a name="<?php echo $kanaalDetails->Kanaal; ?>"></a><?php echo $kanaalDetails->Kanaal; ?></b></td>
				</tr>

			<?php 
				$campagneMiddelen = $wpdb->get_results( "SELECT * FROM CampagneMiddelen WHERE Kanaal = '".$kanaalDetails->ID."' AND Campagne = '".$actID."'  " );
				foreach($campagneMiddelen as $campagneMiddel){ 
				$camYes = "1";
				$volgorde .= $campagneMiddel->ID.",";
				$midNames .= "'".$kanaalDetails->Kanaal." - ".getMiddelName($campagneMiddel->Middel)." ".$campagneMiddel->omschrijving."',";
				$middelDetails = $wpdb->get_row( "SELECT * FROM Middelen WHERE ID = '".$campagneMiddel->Middel."' AND Campagne = '".$actID."'" );	
			
				$midVar = $campagneMiddel->omschrijving;
				
				?>
				<tr bgcolor="#8b8b8b" style="color: #ffffff;">
					<td valign="top" colspan="2" >&nbsp;<?php echo getMiddelName($campagneMiddel->Middel); if(!empty($campagneMiddel->omschrijving)){ ?> - <small><?php echo $campagneMiddel->omschrijving; ?></small><?php } ?><a href="http://www.expect-webmedia.nl/drpr/contentdetail/?id=<?php echo $actID; ?>&camMidDel=<?php echo $campagneMiddel->ID; ?>" onclick="return confirm('Weet je zeker dat je dit campagnemiddel wilt verwijderen?')" ><img src="<?php bloginfo('template_url'); ?>/images/iconTrash.png" alt="" title="Dit campagnemiddel verwijderen" style="float: right; padding-top: 2px; margin-right: 3px;"></a></td>
				</tr>
				<tr>
					<td valign="top" width="150">UTM-code</td>
					<td valign="top" ><input value="<?php if(!empty($campagneMiddel->URL)){ echo $campagneMiddel->URL."?utm_source=".getChanel($kanaal)."&utm_medium=".getMedium($campagneMiddel->Middel)."&utm_campaign=".createCampagneName($actID);}else{ echo $actDetails->CampagnePage."?utm_source=".getChanel($kanaal)."&utm_medium=".getMedium($campagneMiddel->Middel)."&utm_campaign=".createCampagneName($actID)."&midvar=".$midVar; } ?>" onClick="this.setSelectionRange(0, this.value.length)" style="width: 450px; padding: 0px 3px; background-color: none; margin-bottom: 5px;"/></td>
				</tr>

			<?php } ?>
				<tr>
					<td valign="top" colspan="2">
					<?php if(empty($_GET['add']) || $_GET['chanel'] != $kanaal){ ?>
					<a href="/drpr/contentdetail/?id=<?php echo $actID; ?>&add=1&chanel=<?php echo $kanaal; ?>#<?php echo $kanaalDetails->Kanaal; ?>"><img src="<?php bloginfo('template_url'); ?>/images/iconMiddelToevoegen.png" border="0"></a>
					<?php } ?>
					<?php if(!empty($_GET['add']) && $_GET['chanel'] == $kanaal){ ?>
					<div style="background: #f37021; padding: 10px; border-radius: 10px;" class="addMid">
					<img src="<?php bloginfo('template_url'); ?>/images/iconMiddelToevoegen.png" border="0">
						<form action="https://www.expect-webmedia.nl/drpr/contentdetail/?id=<?php echo $_GET['id'];?>&show=1 " method="post">
						Campagnemiddel*<br />
						<select name="middel" style="width: 520px; margin-top: 5px;">
						<option value="selectie"> - selecteer campagnemiddel - </option>
						<?php 
							$middelen = $wpdb->get_results( "SELECT * FROM Middelen WHERE Kanaal = '".$kanaal."' ORDER BY ID" );						
							foreach($middelen as $middel){ ?>
							<option value="<?php echo $middel->ID; ?>"><?php echo $middel->Uiting_type; ?></option>
							<?php } ?>
							<select><br /><br />
						Middel variant<br />
						<input type="text" name="addMidDis" value="<?php echo $_POST['AddMisDis']; ?>" /><br /><br />
						<input type="text" name="kanaal" value="<?php echo $kanaal; ?>" style="display: none;" />
						
							Alternatieve URL landingspagina <small>(Alleen invullen wanneer anders dan campagne landingspagina)</small> <br />
							<input type="text" name="addURL" value="<?php echo $_POST['addURL']; ?>" /><br /><br />
						<a href="/drpr/contentdetail/?id=<?php echo $actDetails->ID; ?> ">Annuleren</a> <input type="submit" id="submit2" name="addMid" value="Toevoegen">
						</form>
					</div>
					<?php } ?>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">&nbsp;</td>
				</tr>
				<?php 

				}
				
				if(empty($kanalen)){
					echo "Er zijn nog geen kanalen en middelen geselecteerd!";
				} ?>
			</table>
		</div> <?php }else{ ?>
		<div style="height: 5px; width: 590px; background: <?php echo $actDetails->kleur; ?>; float: left;">&nbsp;</div>
		<div class="contentHeader3">
		<?php 
				global $wpdb;
				$vandaag = date('Ymd');
				$activiteiten = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE ActID = '".$actDetails->ID."' AND Afwezig != 'afwezig' AND Afwezig != 'afwezig2' AND hoeftNiet != '1' ORDER BY Datum ASC" );
				?>
			<h1>Extra informatie</h1>
			<div class="edit"><?php if(!empty($activiteiten)){ 
			if(empty($actDetails->bevestiging)){?>
			<a href="http://www.expect-webmedia.nl/drpr/activiteit-detail/?id=<?php echo $actDetails->ID; ?>&bev=1"><img src="<?php bloginfo('template_url'); ?>/images/iconSendEmail.png" alt="" title="Verzend bevestigings e-mail!" border="0"></a>
			<?php }else{ ?>
			<img src="<?php bloginfo('template_url'); ?>/images/iconSendEmailOke.png" alt="" title="Bevestigings e-mail is verzonden!">
				<?php }	
			} ?><?php if(!empty($activiteiten)){ ?><a href="http://www.expect-webmedia.nl/drpr/print-werkbriefjes/?actid=<?php echo $_GET['id']; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/iconPrinter.png" alt="" title="Print alle werkbriefjes!" /></a><a href="http://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/scripts/exportActiviteit.php?secure=0999897965&actid=<?php echo $_GET['id']; ?>" alt="" target="_self"><img src="http://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/iconExportGroot.png" alt="" title="Exporteer aanmeldingen naar Excel" border="0"></a><?php } ?></div>
		</div>
		<div class="contentContentdr">
			<table border="0" cellpadding="5" cellspacing="3">
			<?php
				foreach( $activiteiten as $activiteit ){ ?>
				<tr>
					<td valign="top" width="150"><?php mooiedatum($activiteit->Datum); ?></td>
					<td valign="top" width="230"><B><a href="http://www.expect-webmedia.nl/drpr/detail/?id=<?php echo $activiteit->StudID; ?>" title="<?php studentOpleiding($activiteit->StudID); ?>" ><?php  studentNaam($activiteit->StudID); ?></a></B></td>
					<td valign="top" width="111">
						<?php if(!empty($actDetails->bevestiging) && empty($activiteit->Werkt)){ ?>
							<a href="http://www.expect-webmedia.nl/drpr/activiteit-detail/?id=<?php echo $actDetails->ID; ?>&Studid=<?php echo $activiteit->StudID; ?>&enkelbev=1"><img src="<?php bloginfo('template_url'); ?>/images/buttonMail.png" alt="" title="Verzend bevestigings e-mail!" border="0"></a>
						<?php } ?>
					</td>
					<td valign="top" width="111"><a href="http://www.expect-webmedia.nl/drpr/print-werkbriefjes/?actid=<?php echo $activiteit->ActID; ?>&userid=<?php echo $activiteit->StudID; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/buttonPrint.png" alt="" title="Print werkbriefje!" border="0"></a></td>
					<td valign="top" width="20"><a href="http://www.expect-webmedia.nl/drpr/activiteit-detail/?actid=<?php echo $activiteit->ActID; ?>&studid=<?php echo $activiteit->StudID; ?>&id=<?php echo $activiteit->ActID; ?>&delete=yes&dbID=<?php echo $activiteit->ID; ?>"  onclick="return confirm('Weet je zeker dat je deze aanmelding niet hoeft te werken?')" ><img src="<?php bloginfo('template_url'); ?>/images/buttonDelete.png" alt="" title="" border="0"></a></td>
				</tr>
				<?php }
				
				if(empty($activiteiten)){
					echo "Er zijn nog geen aanmeldingen!";
				} ?>
			</table>
		
		<?php } ?>
		
		<?php 
			if(isset($camYes)){ 
			$camName = getCampagneName($actID);
			$getStats = $wpdb->get_results( "SELECT * FROM CampagneStats WHERE Campagne = '".$camName ."' ORDER BY ID" );
			$getStats2 = $wpdb->get_results( "SELECT * FROM CampagneStats2 WHERE Campagne = '".$camName ."' ORDER BY ID" );
			?>
		<div style="height: 5px; width: 590px; background: <?php echo $actDetails->kleur; ?>; float: left;">&nbsp;</div>
		<div class="contentHeaderContent">
		<div class="contentHeaderIcon"><img src="<?php bloginfo('template_url'); ?>/images/iconCharts.png"></div>
			<h1>Campagne statistieken</h1>
			<a name="stats"></a>
			<div class="edit"><a href="https://www.expect-webmedia.nl/drpr/contentdetail/?id=<?php echo $actDetails->ID; ?>" id="refresh"><img src="<?php bloginfo('template_url'); ?>/images/iconRefresh.png" title="Ververs pagina"></a></div>
		</div>
		
	
		<div class="contentContentdrCharts">
		<?php 
		if(empty($getStats)){
				
				?>
		<div class="statsLayer"><h2 style="color: #000;">Nog geen statistieken beschikbaar</h2></div>
		<?php
			}
		?>
		
			<?php
			
			
			$begin = new DateTime( $actDetails->Tijd_van );
			$end = new DateTime( $actDetails->Tijd_tot );
			$end = $end->modify( '+1 day' ); 
			$today = date('Ymd');

			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval ,$end);

			$volgO = substr($volgorde, 0, -1);
			$volAr = explode(",", $volgO);
			
			
			$minN = substr($midNames, 0, -1);
			$totalMinN = "['Dagen',".$minN."],";
			

			//dagen dat de campagne loopt
			foreach($daterange as $date){
				$start = "['".$date->format("d")."', ";
				
				//Volgorde en overzicht alle campagnemiddelen
				foreach($volAr as $smurf){
				$camSrc = createCampagneName($actID);
				$dag = $date->format("Ymd");
				$conversbas .= countConvers($dag,$smurf,$camSrc).", ";
				}
				$rij = $conversbas;
				$totalR = substr($rij, 0, -2);
				$eind = "],";
				$test123 = $start.$totalR.$eind;
				$totalRows .= $test123;
				$test123 ="";
				$conversbas = "";
				if($date->format("Ymd") >= $today){
					break;
				}
			}
		
			 $totalRo = substr($totalRows, 0, -1);
			 
			 $tellen = 0; 
			 foreach($volAr as $smurf){
				$camSrc = createCampagneName($actID);
				$totC .= "['".getMiddelName2($smurf)."',".countConvers3($smurf,$camSrc).",".countConvers2($smurf,$camSrc)."],";
				$tellen ++;
			 }
			 
			 $padding = $tellen * 45;
			
			$camSrc = createCampagneName($actID);
			
			
			
			
			?>
			
			<h2 style="color: #747474; margin-left: 20px; font-weight: normal; font-size: 15px;">Conversies per middel gedurende de campagne</h2>
			<div id="curve_chart" style="padding-bottom: 10px;"></div>
			
			<script type="text/javascript">
			   // haal packages op
			  google.charts.load('current', {'packages':['corechart','bar']});
			  //lijndiagram
			  google.charts.setOnLoadCallback(drawChart);
			  //bardiagram
			  google.charts.setOnLoadCallback(drawAnthonyChart);
			  //Donut Chart
			  google.charts.setOnLoadCallback(donut);
			  
			 // function voor lijndiagram
			  function drawChart() {
				var data = google.visualization.arrayToDataTable([
				  <?php echo $totalMinN; ?>
				  <?php echo $totalRo; ?>
				  
				]);
				

				var options = {
				  fontName : 'Open Sans,sans-serif',
				  fontSize: 10,
				  curveType: 'function',
				  legend: { position: 'bottom' },
				  width: 588,
				};

				var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

				chart.draw(data, options);
			  }
			  
			   // functie voor bar diagram
      function drawAnthonyChart() {

        var data = new google.visualization.arrayToDataTable([
           ['', 'Leads', 'Conversies'],
         <?php echo $totC; ?>
        ]);
		
		
        var options = {
          width: 548,
		  legend: { position: 'none' },
          bars: 'horizontal', // Required for Material Bar Charts.
		   colors: ['#f37021', '#00ab4e']
          
        };

      var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
      chart.draw(data, options);
      }
	  
	  //function donut chart
	  function donut() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Campagne conversies',   <?php echo countConversTotaalCam2($camSrc); ?>],
          ['Organische conversies', <?php echo countConversTotaalCam($camSrc); ?>],
         
        ]);

        var options = {
		  width: 585,
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }

    </script>
		</div>


	
		<div class="contentContentdrCharts" >
		<?php 
		if(empty($getStats)){
				
				?>
		<div class="statsLayer"><h2 style="color: #000;">Nog geen statistieken beschikbaar</h2></div>
		<?php
			}
		?>
		<h2 style="color: #747474; margin-left: 20px; font-weight: normal; font-size: 15px;">Leads &amp; Conversies per campagnemiddel</h2>
		<div id="dual_x_div" style="height: <?php echo $padding; ?>px;"></div>
		</div>
		<div class="contentContentdrCharts">
		<?php 
		if(empty($getStats2)){
				
				?>
		<div class="statsLayer"><h2 style="color: #000;">Nog geen statistieken beschikbaar</h2></div>
		<?php
			}
		?>
		<h2 style="color: #747474; margin-left: 20px; font-weight: normal; font-size: 15px;">Totaal aantal conversies</h2>
		<?php if(!countConversTotaalCam($camSrc)){ ?>
		<small style="margin-left: 20px;">Er zijn nog geen conversies</small>
		<?php } ?>
			<div id="donutchart" style="height: 300px;"></div>
		</div>
		
		
		<?php 
			//dagen dat de campagne loopt
			foreach($daterange as $date){
				$dag = $date->format("Ymd");
				$camSrc = createCampagneName($actID);
				$start = "['".$date->format("d")."', ";
				$tussen = countConvers4($dag,$camSrc);
				$tussen2 = countConvers5($dag,$camSrc);
				$eind = "],";
				
				$totalString .= $start.$tussen.",".$tussen2.$eind;
				
				if($date->format("Ymd") >= $today){
					break;
				}
			}
		?>
		
		<script type="text/javascript">
		 google.charts.load('current', {'packages':['corechart']});

      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['dag', 'organische conversies','campagne conversies'],
         <?php echo $totalString; ?>
        ]);

        var options = {
       
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart2'));

        chart.draw(data, options);
      }
	  </script>
	  <div class="contentContentdrCharts">
	  <?php 
		if(empty($getStats2)){
				
				?>
		<div class="statsLayer"><h2 style="color: #000;">Nog geen statistieken beschikbaar</h2></div>
		<?php
			}
		?>
				<h2 style="color: #747474; margin-left: 20px; font-weight: normal; font-size: 15px;">Campagne en organische conversies gedurende looptijd campagne</h2>
			 <div id="curve_chart2" style="height: 300px;"></div>
			 
	   </div>
	   
	   
		</div>
		<?php } ?>
	</div>
<?php

get_footer();
