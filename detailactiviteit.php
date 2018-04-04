<?php 
/*
Template Name: detailpagina Activiteit NIEUW
*/
get_header(); 
		//gegevens van dreamteamer/promoteamer ophalen
		global $wpdb; $current_user;
		get_currentuserinfo();
		$actID = $_GET['id'];
		$actDetails2 = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $actID" );
		
			if($_POST['mail']){
				if(empty($_POST['naam'])){	$error .= "<li>Je bent een naam vergeten in te vullen</li>"; }
				
				if($_POST['activiteit'] == 'keuze'){	$error .= "<li>Je bent vergeten een maillijst te selecteren</li>";	}
				
				if(empty($error)){
					$wpdb->insert( Mailing, array( 'Naam' => $_POST['naam'], 'ListID' => $_POST['activiteit'], 'ActID' => $_GET['id']) );
					?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						E-mail is met succes aangemaakt!
						</div>
					<?php 
				}
	
			}
			
			if(isset($_GET['stop'])){
				$wpdb->update( Activiteiten, array( 'Max_deelnemers' => '0'),array( 'ID' => $_GET['id']) ); 
				?>
				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					Aanmeldingen zijn gestopt!
				</div>
				<?php
			}
			
			//Annulerings e-mail versturen
			
			if(isset($_GET['ann']) && empty($actDetails2->annulering)){
				$ActID = $_GET['id'];
				annuleringsmail($ActID);
			}
			
			//Bevestigings e-mail versturen
			if(isset($_GET['bev']) && empty($actDetails2->bevestiging)){
				$ActID = $_GET['id'];
				bevestigingsmail($ActID);
			}


			//Enkele bevestigings e-mail versturen
			if(isset($_GET['enkelbev'])){
				$ActID = $_GET['id'];
				$StudID = $_GET['Studid'];
				bevestigingsmailEnkel($ActID,$StudID);
			}
			
			//mail versturen
			if(isset($_GET['send']) && !isset($_GET['reminder'])){
				$ListID = $_GET['send'];
				$ActID = $_GET['id'];
				$sendDate = $wpdb->get_row( "SELECT * FROM Maillijst WHERE ID = '".$ListID."'" );
				$toDay = date('Ymd');
				$mail = "";
				if($sendDate->SendDate != $toDay ){
					verzendMail($ListID,$ActID,$mail);
				}else{
					$foutMelding = "Je hebt deze mail vandaag al verstuurd!";
				}
			}
			
			//Reminder versturen
			if(isset($_GET['send']) && isset($_GET['reminder'])){
				$ListID = $_GET['send'];
				$ActID = $_GET['id'];
				$mail = "Reminder: ";
				$sendDate = $wpdb->get_row( "SELECT * FROM Maillijst WHERE ID = '".$ListID."'" );
				$toDay = date('Ymd');
				if($sendDate->SendDate != $toDay ){
					verzendMail($ListID,$ActID,$mail);
				}else{
					$foutMelding = "Je hebt deze reminder vandaag al verstuurd!";
				}
			}
			
			
			if($_GET['add'] == 'succes'){ ?>
	<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
		Activiteit met succes toegevoegd!
	</div>
	<?php }
			
		 
					if($_POST['submit']){ 
				//kijken of er fouten zijn gemaakt
				if(empty($_POST['titel'])){	$error .= "<li>Je bent vergeten de titel in te vullen</li>";	}
				if(empty($_POST['datum'])){	$error .= "<li>Je bent vergeten een datum in te vullen</li>";	}
				if(empty($_POST['startTijd'])){	$error .= "<li>Je bent vergeten een starttijd in te vullen</li>";	}
				if(empty($_POST['eindTijd'])){	$error .= "<li>je bent vergeten een eindtijd in te vullen</li>";}
				if(empty($_POST['beschrijving'])){	$error .= "<li>Je bent vergeten een beschrijving in te vullen</li>";}
				if($_POST['contactpersoon'] == 'keuze'){ $error .= "<li>Je bent vergeten een contactpersoon in te vullen</li>";	}
				if(empty($_POST['deadline'])){	$error .= "<li>Je bent vergeten in te vullen tot wanneer er kan worden aangemeld</li>";	}
				if($_POST['aantal'] == 'keuze'){	$error .= "<li>Je bent het max aantal dreamteamers/promoteamers in te vullen</li>";	}
				if(empty($_POST['locatie'])){	$error .= "<li>Je bent de locatie vergeten in te vullen</li>";	}
				if($_POST['doelgroep'] == 'keuze'){	$error .= "<li>Je bent vergeten een doelgroep in te vullen</li>";	}
				}



					if($_POST['submit'] && empty($error)){
					//Activiteit updaten
						$dbDate = date("Ymd", strtotime($_POST['datum']));
						$userData = get_userdata($_POST['contactpersoon']);
						
						$wpdb->update( Activiteiten, array( 'Titel' => $_POST['titel'], 'Datum' => $dbDate, 'Tijd_van' => $_POST['startTijd'], 'Tijd_tot' => $_POST['eindTijd'], 'Omschrijving' => $_POST['beschrijving'], 'Max_deelnemers' => $_POST['aantal'], 'Deadline' => $_POST['deadline'], 'ContactpersoonID' => $_POST['contactpersoon'],'Contactpersoon' => $userData->display_name, 'Contactemail' => $userData->user_email, 'Locatie' => $_POST['locatie'], 'Doelgroep' => $_POST['doelgroep'], 'Opmerkingen' => $_POST['opmerkingen'] ),array( 'ID' => $_GET['id']) ); 

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
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $actID" );
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
		<div class="contentHeader2">
			<h1><?php echo $actDetails->Titel; ?></h1>
			<div class="edit"><a href="https://www.expect-webmedia.nl/drpr/activiteit-detail/?id=<?php echo $actDetails->ID; ?>&stop=1"><img src="<?php bloginfo('template_url'); ?>/images/iconStop.png" title="Stop aanmeldingen"></a><a href="https://www.expect-webmedia.nl/drpr/activiteit-detail/?id=<?php echo $actDetails->ID; ?>" id="refresh"><img src="<?php bloginfo('template_url'); ?>/images/iconRefresh.png" title="Ververs pagina"></a><?php if(!isset($_GET['edit'])){ ?><a href="http://www.expect-webmedia.nl/drpr/activiteit-detail/?id=<?php echo $actDetails->ID; ?>&edit=1" ><img src="<?php bloginfo('template_url'); ?>/images/edit.png" alt="" title="bewerk de gegevens" /></a><?php } ?><a href="http://www.expect-webmedia.nl/drpr/activiteiten/?delete=yes&id=<?php echo $actDetails->ID; ?>" ><img src="<?php bloginfo('template_url'); ?>/images/iconDelete.png" alt="" title="Verwijder activiteit" onclick="return confirm('Weet je zeker dat je deze activiteit wilt verwijderen?')"/></a></div>
		</div>
		<div class="contentContent">

		<?php if(empty($_GET['edit']) || !empty($show) && empty($error)){ 
		
		$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = $actID" );
		
		?>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="130">Activiteit</td>
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
			</table><br /><br />
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="130">Contactpersoon</td>
					<td valign="top">:</td>
					<td valign="top"><a href="mailto:<?php echo $actDetails->Contactemail; ?>"><?php echo $actDetails->Contactpersoon; ?></a></td>
				</tr>
				<tr>
					<td valign="top">Maximaal aantal deelnemers</td>
					<td valign="top">:</td>
					<td valign="top">
					<?php if($actDetails->Max_deelnemers == '0'){
						echo "Onbeperkt aantal deelnemers";
					}else{ 
						echo $actDetails->Max_deelnemers." deelnemer(s)";
						} ?>
					</td>
				</tr>
				<tr>
					<td valign="top">Aanmelden kan tot </td>
					<td valign="top">:</td>
					<td valign="top"><?php //echo $actDetails->Deadline; 
					$datum = date("H:i:s", strtotime($actDetails->Deadline));
					mooiedatum($actDetails->Deadline);
					echo " om ".$datum; ?> uur</td>
				</tr>
				<tr>
					<td valign="top">Doelgroep</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $actDetails->Doelgroep; ?></td>
				</tr>
				<tr>
					<td valign="top">Eventuele opmerkingen</td>
					<td valign="top">:</td>
					<td valign="top" ><?php echo $actDetails->Opmerkingen; ?></td>
				</tr>
			</table>
			<?php }


				
			if(!empty($_GET['edit']) && !empty($_GET['id']) || empty($_GET['edit']) && !empty($error) && $_POST['submit']){ ?>

				<?php if($_POST['submit'] && !empty($error)){ ?>
				<div id="alert">
					<ul>
						<?php echo $error; ?>
					</ul>
				</div>
				<?php } ?>
				
				<form action="https://www.expect-webmedia.nl/drpr/activiteit-detail/?id=<?php echo $_GET['id'];?>&show=1 " method="post">
				Naam activiteit *<br />
				<input type="text" name="titel" value="<?php if(!isset($_POST['titel'])){ echo $actDetails->Titel; }else{ echo $_POST['titel'];} ?>" /><br /><br />
				Datum *<br />
				<input type="text" name="datum" id="datum" value="<?php mooiedatum3($actDetails->Datum); ?>" /><br /><br />
				Starttijd<br />
				<input type="text" name="startTijd" id="startTijd" value="<?php echo $actDetails->Tijd_van; ?>" /><br /><br />
				Eindtijd<br />
				<input type="text" name="eindTijd" id="eindTijd" value="<?php echo $actDetails->Tijd_tot; ?>" /><br /><br />
				Omschrijving *<br />
				<textarea name="beschrijving"><?php echo $actDetails->Omschrijving; ?></textarea><br /><br />
				Locatie *<br />
				<input type="text" name="locatie" value="<?php echo $actDetails->Locatie; ?>" /><br /><br />
				Maximaal aantal dream- promoteamers *<br />
				<select name="aantal">
					<option value="125" <?php if($actDetails->Max_deelnemers == "250"){ ?>selected="selected"<?php } ?>>Onbeperkte aantal inschrijvingen</option>
					<option value="1" <?php if($actDetails->Max_deelnemers == "1"){ ?>selected="selected"<?php } ?>>1</option>
					<option value="2" <?php if($actDetails->Max_deelnemers == "2"){ ?>selected="selected"<?php } ?>>2</option>
					<option value="3" <?php if($actDetails->Max_deelnemers == "3"){ ?>selected="selected"<?php } ?>>3</option>
					<option value="4" <?php if($actDetails->Max_deelnemers == "4"){ ?>selected="selected"<?php } ?>>4</option>
					<option value="5" <?php if($actDetails->Max_deelnemers == "5"){ ?>selected="selected"<?php } ?>>5</option>
					<option value="6" <?php if($actDetails->Max_deelnemers == "6"){ ?>selected="selected"<?php } ?>>6</option>
					<option value="7" <?php if($actDetails->Max_deelnemers == "7"){ ?>selected="selected"<?php } ?>>7</option>
					<option value="8" <?php if($actDetails->Max_deelnemers == "8"){ ?>selected="selected"<?php } ?>>8</option>
					<option value="9" <?php if($actDetails->Max_deelnemers == "9"){ ?>selected="selected"<?php } ?>>9</option>
					<option value="10" <?php if($actDetails->Max_deelnemers == "10"){ ?>selected="selected"<?php } ?>>10</option>
					<option value="11" <?php if($actDetails->Max_deelnemers == "11"){ ?>selected="selected"<?php } ?>>11</option>
					<option value="12" <?php if($actDetails->Max_deelnemers == "12"){ ?>selected="selected"<?php } ?>>12</option>
					<option value="13" <?php if($actDetails->Max_deelnemers== "13"){ ?>selected="selected"<?php } ?>>13</option>
					<option value="14" <?php if($actDetails->Max_deelnemers == "14"){ ?>selected="selected"<?php } ?>>14</option>
					<option value="15" <?php if($actDetails->Max_deelnemers == "15"){ ?>selected="selected"<?php } ?>>15</option>
					<option value="16" <?php if($actDetails->Max_deelnemers == "16"){ ?>selected="selected"<?php } ?>>16</option>
					<option value="17" <?php if($actDetails->Max_deelnemers == "17"){ ?>selected="selected"<?php } ?>>17</option>
					<option value="18" <?php if($actDetails->Max_deelnemers == "18"){ ?>selected="selected"<?php } ?>>18</option>
					<option value="19" <?php if($actDetails->Max_deelnemers == "19"){ ?>selected="selected"<?php } ?>>19</option>
					<option value="20" <?php if($actDetails->Max_deelnemers == "20"){ ?>selected="selected"<?php } ?>>20</option>
					<option value="21" <?php if($actDetails->Max_deelnemers == "21"){ ?>selected="selected"<?php } ?>>21</option>
					<option value="22" <?php if($actDetails->Max_deelnemers == "22"){ ?>selected="selected"<?php } ?>>22</option>
					<option value="23" <?php if($actDetails->Max_deelnemers == "23"){ ?>selected="selected"<?php } ?>>23</option>
					<option value="24" <?php if($actDetails->Max_deelnemers == "24"){ ?>selected="selected"<?php } ?>>24</option>
					<option value="25" <?php if($actDetails->Max_deelnemers == "25"){ ?>selected="selected"<?php } ?>>25</option>
				</select><br /><br />
				Inschrijven kan tot: *<br />
				<input type="text" name="deadline" id="deadline" value="<?php echo $actDetails->Deadline; ?>" /><br /><br />
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
				Doelgroep *<br />
				<select name="doelgroep">
					<option value="keuze" <?php if($actDetails->Doelgroep == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="werving" <?php if($actDetails->Doelgroep == "werving"){ ?>selected="selected"<?php } ?>>Werving</option>
					<option value="branding" <?php if($actDetails->Doelgroep == "branding"){ ?>selected="selected"<?php } ?>>Branding</option>
					<option value="corporate" <?php if($actDetails->Doelgroep == "corporate"){ ?>selected="selected"<?php } ?>>Corporate</option>
				</select><br /><br />
				Eventuele opmerkingen<br />
				<textarea name="opmerkingen"><?php echo $actDetails->Opmerkingen; ?></textarea><br /><br />
				<a href="http://www.expect-webmedia.nl/drpr/activiteit-detail/?id=<?php echo $actDetails->ID; ?> ">Annuleren</a> <input type="submit" id="submit" name="submit" value="Activiteit bijwerken">
			</form>
			<?php } ?>
		</div>
		
		<div class="contentHeader6">
		<?php 
				global $wpdb;
				//$mailingen= $wpdb->get_results( "SELECT * FROM Maillijst WHERE ActID = '".$_GET['id']."' ORDER BY ID DESC" );
				
				
				$mailingen = $wpdb->get_results( "SELECT * FROM Maillijst WHERE ActID LIKE '%".$_GET['id']."%'" );
			
				
				?>
			<h1>E-mails</h1>
		</div>
		<div class="contentContent">
			<table border="0" cellpadding="5" cellspacing="3">
			<?php
				foreach( $mailingen as $mail ){ ?>
				<tr>
					<td valign="top" title="Deze e-mail heeft <?php aantalOntvangersNieuw($mail->ID); ?> ontvanger(s)"><a href="http://www.expect-webmedia.nl/drpr/mailing-detail/?mailID=<?php echo $mail->ID; ?>"><?php echo $mail->Naam; ?></a> (<?php aantalOntvangersNieuw($mail->ID); ?>)</td>
				</tr>
				<?php }
				
				if(empty($mailingen)){
					echo "Er zijn nog geen E-mails!";
				} ?>
			</table>
		</div>
	</div>

	<div id="contentRechts">
		<div class="contentHeader3">
		<?php 
				global $wpdb;
				$vandaag = date('Ymd');
				$activiteiten = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE ActID = '".$actDetails->ID."' AND Afwezig != 'afwezig' AND Afwezig != 'afwezig2' AND hoeftNiet != '1' ORDER BY Datum ASC" );
				?>
			<h1>Deelnemers &nbsp;<font style="font-size: 11px;">(<?php  aantalDeelnemers($actDetails->ID); ?>)</font></h1>
			<div class="edit"><?php if(!empty($activiteiten)){ 
			if(empty($actDetails->bevestiging)){?>
			<a href="http://www.expect-webmedia.nl/drpr/activiteit-detail/?id=<?php echo $actDetails->ID; ?>&bev=1"><img src="<?php bloginfo('template_url'); ?>/images/iconSendEmail.png" alt="" title="Verzend bevestigings e-mail!" border="0"></a>
			<?php }else{ ?>
			<img src="<?php bloginfo('template_url'); ?>/images/iconSendEmailOke.png" alt="" title="Bevestigings e-mail is verzonden!">
				<?php }	
			} ?><?php if(!empty($activiteiten)){ ?><a href="http://www.expect-webmedia.nl/drpr/print-werkbriefjes/?actid=<?php echo $_GET['id']; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/iconPrinter.png" alt="" title="Print alle werkbriefjes!" /></a><a href="https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/scripts/exportActiviteit.php?secure=0999897965&actid=<?php echo $_GET['id']; ?>" alt="" target="_self"><img src="https://www.expect-webmedia.nl/drpr/wp-content/themes/beheertool/images/iconExportGroot.png" alt="" title="Exporteer aanmeldingen naar Excel" border="0"></a><?php } ?></div>
		</div>
		<div class="contentContent">
			<table border="0" cellpadding="5" cellspacing="3">
			<?php
				foreach( $activiteiten as $activiteit ){ ?>
				<tr>
					<td valign="top" width="150"><?php mooiedatum($activiteit->Datum); ?></td>
					<td valign="top" width="230"><B><a href="https://www.expect-webmedia.nl/drpr/detail/?id=<?php echo $activiteit->StudID; ?>" title="<?php studentOpleiding($activiteit->StudID); ?>" ><?php  studentNaam($activiteit->StudID); ?></a></B></td>
					<td valign="top" width="111">
						<?php if(!empty($actDetails->bevestiging) && empty($activiteit->Werkt)){ ?>
							<a href="https://www.expect-webmedia.nl/drpr/activiteit-detail/?id=<?php echo $actDetails->ID; ?>&Studid=<?php echo $activiteit->StudID; ?>&enkelbev=1"><img src="<?php bloginfo('template_url'); ?>/images/buttonMail.png" alt="" title="Verzend bevestigings e-mail!" border="0"></a>
						<?php } ?>
					</td>
					<td valign="top" width="111"><a href="https://www.expect-webmedia.nl/drpr/print-werkbriefjes/?actid=<?php echo $activiteit->ActID; ?>&userid=<?php echo $activiteit->StudID; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/buttonPrint.png" alt="" title="Print werkbriefje!" border="0"></a></td>
					<td valign="top" width="20"><a href="https://www.expect-webmedia.nl/drpr/activiteit-detail/?actid=<?php echo $activiteit->ActID; ?>&studid=<?php echo $activiteit->StudID; ?>&id=<?php echo $activiteit->ActID; ?>&delete=yes&dbID=<?php echo $activiteit->ID; ?>"  onclick="return confirm('Weet je zeker dat je deze aanmelding niet hoeft te werken?')" ><img src="<?php bloginfo('template_url'); ?>/images/buttonDelete.png" alt="" title="" border="0"></a></td>
				</tr>
				<?php }
				
				if(empty($activiteiten)){
					echo "Er zijn nog geen aanmeldingen!";
				} ?>
			</table>
		</div>

		<div class="contentHeader4">
		<?php 
				global $wpdb;
				$afwezigen= $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE ActID = '".$actDetails->ID."' AND Afwezig = 'afwezig' OR ActID = '".$actDetails->ID."' AND Afwezig = 'afwezig2' ORDER BY ID DESC LIMIT 15" );
				?>
			<h1>Afmelders &nbsp;<font style="font-size: 11px;">(<?php  afwezigen($actDetails->ID); ?>) Laatste 15 worden getoond</font></h1>
			<div class="edit"></div>
		</div>
		<div class="contentContent">
			<table border="0" cellpadding="5" cellspacing="3">
			<?php
				foreach( $afwezigen as $afwezig ){ ?>
				<tr>
					<td valign="top" width="100"><?php mooiedatum($afwezig->Datum); ?></td>
					<td valign="top" width="250"><B><a href="http://www.expect-webmedia.nl/drpr/detail/?id=<?php echo $afwezig->StudID; ?>" title="<?php studentOpleiding($afwezig->StudID); ?>" ><?php  studentNaam($afwezig->StudID); ?></a></B></td>
					<td valign="top" width="150"><?php if($afwezig->Afwezig == 'afwezig2'){ ?><img src="<?php bloginfo('template_url'); ?>/images/teruggetrokken.png" alt="" /><?php } ?></td>
					<td valign="top"><a href="http://www.expect-webmedia.nl/drpr/activiteit-detail/?actid=<?php echo $afwezig->ActID; ?>&studid=<?php echo $afwezig->StudID; ?>&id=<?php echo $afwezig->ActID; ?>&delete=yes"  onclick="return confirm('Weet je zeker dat je deze afmelding wilt verwijderen?')" ><img src="<?php bloginfo('template_url'); ?>/images/buttonDelete.png" alt="" title="" border="0"></a></td>
				</tr>
				<?php }
				
				if(empty($afwezigen)){
					echo "Er zijn geen afmelders!";
				} ?>
			</table>
		</div>
		
		
		<div class="contentHeader4">
		<?php 
				global $wpdb;
				$afwezigen2 = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE ActID = '".$actDetails->ID."' AND hoeftNiet = '1' ORDER BY Datum ASC" );
				?>
			<h1>Aangemeld, maar hoeft niet te werken &nbsp;<font style="font-size: 11px;">(<?php  nietWerken($actDetails->ID); ?>)</font></h1>
			<div class="edit">
			<?php if(!empty($afwezigen2)){ 
			if(empty($actDetails->annulering)){?>
			<a href="http://www.expect-webmedia.nl/drpr/activiteit-detail/?id=<?php echo $actDetails->ID; ?>&ann=1"><img src="<?php bloginfo('template_url'); ?>/images/iconSendEmail.png" alt="" title="Verzend annulerings e-mail!" border="0"></a>
			<?php }else{ ?>
			<img src="<?php bloginfo('template_url'); ?>/images/iconSendEmailOke.png" alt="" title="Annulerings e-mail is verzonden!">
				<?php }	
			} ?>
			
			</div>
		</div>
		<div class="contentContent">
			<table border="0" cellpadding="5" cellspacing="3">
			<?php
				foreach( $afwezigen2 as $afwezig2 ){ 
				?>
				<tr>
					<td valign="top" width="100"><?php mooiedatum($afwezig2->Datum); ?></td>
					<td valign="top" width="250"><B><a href="http://www.expect-webmedia.nl/drpr/detail/?id=<?php echo $afwezig2->StudID; ?>" title="<?php studentOpleiding($afwezig2->StudID); ?>" ><?php  studentNaam($afwezig2->StudID); ?></a></B></td>
					<td valign="top" width="150"></td>
					<td valign="top"><a href="http://www.expect-webmedia.nl/drpr/activiteit-detail/?actid=<?php echo $afwezig2->ActID; ?>&studid=<?php echo $afwezig2->StudID; ?>&id=<?php echo $afwezig2->ActID; ?>&delete=yes&dbID2=<?php echo $afwezig2->ID; ?>"  onclick="return confirm('Weet je zeker dat je deze persoon wilt terug zetten naar deelnemers?')" ><img src="<?php bloginfo('template_url'); ?>/images/buttonDelete.png" alt="" title="" border="0"></a></td>
				</tr>
				<?php }
				
				if(empty($afwezigen2)){
					echo "Nog geen gegevens!";
				} ?>
			</table>
		</div>
	</div>
<?php

get_footer();
