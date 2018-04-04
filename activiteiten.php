<?php  ob_start();
/*
Template Name: Activiteiten
*/


get_header();

				//connect to the database
				global $wpdb; $current_user;
				get_currentuserinfo();
				// 
				 $current_user = wp_get_current_user();
				if(!empty($_GET['delete'])){
					$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = ".$_GET['id']."" );
					$wpdb->query(   "  DELETE FROM Activiteiten WHERE ID = ".$_GET['id']." "  );
					$wpdb->query(   "  DELETE FROM Aanmeldingen WHERE ActID = ".$_GET['id']." "  );
					$wpdb->query(   "  DELETE FROM Maillijst WHERE ActID = ".$_GET['id']." "  );
				?>
			
				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					Activiteit met succes verwijderd!
				</div>
				<?php } ?>
				<div style="clear: both;"></div>
	<div id="contentLinks">
		<div class="contentHeader">
			<h1>Activiteiten aanmaken</h1>
		</div>
		<div class="contentContent">
			<p><B>Activiteit toevoegen</B></p>
			<?php 
				//kijken of er fouten zijn gemaakt
				if(empty($_POST['titel'])){	$error .= "<li>Je bent vergeten de titel in te vullen</li>";	}
				if(empty($_POST['datum'])){	$error .= "<li>Je bent vergeten een datum in te vullen</li>";	}
				if(empty($_POST['startTijd'])){	$error .= "<li>Je bent vergeten een starttijd in te vullen</li>";	}
				if(empty($_POST['eindTijd'])){	$error .= "<li>je bent vergeten een eindtijd in te vullen</li>";}
				if(empty($_POST['beschrijving'])){	$error .= "<li>Je bent vergeten een beschrijving in te vullen</li>";}
				if(empty($_POST['contactpersoon'])){ $error .= "<li>Je bent vergeten een contactpersoon in te vullen</li>";	}
				if(empty($_POST['emailcontactpersoon'])){	$error .= "<li>Je bent vergeten een e-mailadres van een contactpersoon in te vullen</li>";	}
				if(empty($_POST['deadline'])){	$error .= "<li>Je bent vergeten in te vullen tot wanneer er kan worden aangemeld</li>";	}
				if($_POST['aantal'] == 'keuze'){	$error .= "<li>Je bent het max aantal dreamteamers/promoteamers in te vullen</li>";	}
				if(empty($_POST['locatie'])){	$error .= "<li>Je bent de locatie vergeten in te vullen</li>";	}
				if($_POST['doelgroep'] == 'keuze'){	$error .= "<li>Je bent vergeten een doelgroep in te vullen</li>";	}

					

				if(isset( $_POST['submit'] ) && !empty($error)){ ?>
					<div id="alert">
						<ul>
							<?php echo $error; ?>
						</ul>
					</div>
				<?php }
				

				//als er geen fouten gemaakt zijn dan zetten we de gegevens in de database en geven we een succesmelding
				if($_POST['submit'] && empty($error)){
					$dbDate = date("Ymd", strtotime($_POST['datum']));
					$contactID =  $current_user->ID;
					$actKey = date('YmdB').$contactID;
					$wpdb->insert( Activiteiten, array( 'Titel' => $_POST['titel'], 'Datum' => $dbDate, 'Tijd_van' => $_POST['startTijd'], 'Tijd_tot' => $_POST['eindTijd'], 'Omschrijving' => $_POST['beschrijving'], 'Max_deelnemers' => $_POST['aantal'], 'Deadline' => $_POST['deadline'], 'ContactpersoonID' => $current_user->ID ,'Contactpersoon' => $_POST['contactpersoon'], 'Contactemail' => $_POST['emailcontactpersoon'], 'Locatie' => $_POST['locatie'], 'Doelgroep' => $_POST['doelgroep'], 'Opmerkingen' => $_POST['opmerkingen'], 'actKey' => $actKey ) ); 
					
					$studNr = $_POST['studnr'];
					$ActDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE actKey = $actKey" );
					$url = "http://www.expect-webmedia.nl/drpr/activiteit-detail/?id=".$ActDetails->ID;
					wp_redirect( $url.'&add=succes' ); exit;
				}
			?>

			<?php 
				if(!isset( $_POST['submit'] ) || !empty($error)){ 
					get_currentuserinfo();
					?>
			<form action="" method="post">
				Naam activiteit *<br />
				<input type="text" name="titel" value="<?php echo $_POST['titel']; ?>" /><br /><br />
				Datum *<br />
				<input type="text" name="datum" id="datum" value="<?php echo $_POST['datum']; ?>" /><br /><br />
				Starttijd<br />
				<input type="text" name="startTijd" id="startTijd" value="<?php echo $_POST['startTijd']; ?>" /><br /><br />
				Eindtijd<br />
				<input type="text" name="eindTijd" id="eindTijd" value="<?php echo $_POST['eindTijd']; ?>" /><br /><br />
				Omschrijving *<br />
				<textarea name="beschrijving"><?php echo $_POST['beschrijving']; ?></textarea><br /><br />
				Locatie *<br />
				<input type="text" name="locatie" value="<?php echo $_POST['locatie']; ?>" /><br /><br />
				Maximaal aantal dream- promoteamers *<br />
				<select name="aantal">
					<option value="keuze" <?php if($_POST['aantal'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="125" <?php if($_POST['aantal'] == "0"){ ?>selected="selected"<?php } ?>>Onbeperkte aantal inschrijvingen</option>
					<option value="1" <?php if($_POST['aantal'] == "1"){ ?>selected="selected"<?php } ?>>1</option>
					<option value="2" <?php if($_POST['aantal'] == "2"){ ?>selected="selected"<?php } ?>>2</option>
					<option value="3" <?php if($_POST['aantal'] == "3"){ ?>selected="selected"<?php } ?>>3</option>
					<option value="4" <?php if($_POST['aantal'] == "4"){ ?>selected="selected"<?php } ?>>4</option>
					<option value="5" <?php if($_POST['aantal'] == "5"){ ?>selected="selected"<?php } ?>>5</option>
					<option value="6" <?php if($_POST['aantal'] == "6"){ ?>selected="selected"<?php } ?>>6</option>
					<option value="7" <?php if($_POST['aantal'] == "7"){ ?>selected="selected"<?php } ?>>7</option>
					<option value="8" <?php if($_POST['aantal'] == "8"){ ?>selected="selected"<?php } ?>>8</option>
					<option value="9" <?php if($_POST['aantal'] == "9"){ ?>selected="selected"<?php } ?>>9</option>
					<option value="10" <?php if($_POST['aantal'] == "10"){ ?>selected="selected"<?php } ?>>10</option>
					<option value="11" <?php if($_POST['aantal'] == "11"){ ?>selected="selected"<?php } ?>>11</option>
					<option value="12" <?php if($_POST['aantal'] == "12"){ ?>selected="selected"<?php } ?>>12</option>
					<option value="13" <?php if($_POST['aantal'] == "13"){ ?>selected="selected"<?php } ?>>13</option>
					<option value="14" <?php if($_POST['aantal'] == "14"){ ?>selected="selected"<?php } ?>>14</option>
					<option value="15" <?php if($_POST['aantal'] == "15"){ ?>selected="selected"<?php } ?>>15</option>
					<option value="16" <?php if($_POST['aantal'] == "16"){ ?>selected="selected"<?php } ?>>16</option>
					<option value="17" <?php if($_POST['aantal'] == "17"){ ?>selected="selected"<?php } ?>>17</option>
					<option value="18" <?php if($_POST['aantal'] == "18"){ ?>selected="selected"<?php } ?>>18</option>
					<option value="19" <?php if($_POST['aantal'] == "19"){ ?>selected="selected"<?php } ?>>19</option>
					<option value="20" <?php if($_POST['aantal'] == "20"){ ?>selected="selected"<?php } ?>>20</option>
					<option value="21" <?php if($_POST['aantal'] == "21"){ ?>selected="selected"<?php } ?>>21</option>
					<option value="22" <?php if($_POST['aantal'] == "22"){ ?>selected="selected"<?php } ?>>22</option>
					<option value="23" <?php if($_POST['aantal'] == "23"){ ?>selected="selected"<?php } ?>>23</option>
					<option value="24" <?php if($_POST['aantal'] == "24"){ ?>selected="selected"<?php } ?>>24</option>
					<option value="25" <?php if($_POST['aantal'] == "25"){ ?>selected="selected"<?php } ?>>25</option>
				</select><br /><br />
				Inschrijven kan tot: *<br />
				<input type="text" name="deadline" id="deadline" value="<?php echo $_POST['deadline']; ?>" /><br /><br />
				Naam contactpersoon *<br />
				<input type="text" name="contactpersoon" value="<?php if(!isset($_POST['contactpersoon'])){ echo $current_user->display_name; }else{ echo $_POST['contactpersoon'];} ?>" /><br /><br />
				E-mail contactpersoon *<br />
				<input type="text" name="emailcontactpersoon" value="<?php if(!isset($_POST['emailcontactpersoon'])){ echo $current_user->user_email; }else{ echo $_POST['emailcontactpersoon'];} ?>" /><br /><br />
				Doelgroep *<br />
				<select name="doelgroep">
					<option value="keuze" <?php if($_POST['doelgroep'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<option value="werving" <?php if($_POST['doelgroep'] == "werving"){ ?>selected="selected"<?php } ?>>Werving</option>
					<option value="branding" <?php if($_POST['doelgroep'] == "branding"){ ?>selected="selected"<?php } ?>>Branding</option>
					<option value="corporate" <?php if($_POST['doelgroep'] == "corporate"){ ?>selected="selected"<?php } ?>>Corporate</option>
				</select><br /><br />
				Eventuele opmerkingen<br />
				<textarea name="opmerkingen"><?php echo $_POST['opmerkingen']; ?></textarea><br /><br />
				<input type="submit" id="submit" name="submit" value="Activiteit aanmaken">
			</form>

			<?php } ?>
		</div>
	</div>

	<div id="contentRechts">
	<div class="contentHeaderZoeken">
					<h1>Zoek (voorgaande) activiteiten</h1>
				</div>
				<div class="contentContent">
					<form method="post" id="search">
						<input type="text" value="" id="searchDream" name="keyWord">
						<input type="submit" value="Zoeken!" name="submit2" id="searchSubmit">
					</form>
					<?php if($_POST['submit2']){
						global $wpdb;
						$keyWord = $_POST['keyWord'];
						$zoekresultaten = $wpdb->get_results( "SELECT * FROM Activiteiten WHERE Titel LIKE '%".$keyWord."%' OR Contactpersoon LIKE '%".$keyWord."%' ORDER BY ID DESC" );
						$aantal = $wpdb->get_var( " SELECT COUNT(*) FROM Activiteiten WHERE Titel LIKE '%".$keyWord."%' OR Contactpersoon LIKE '%".$keyWord."%'"); 
						?><h3>Zoekresultaten voor <i>&quot;<?php echo $_POST['keyWord']; ?>&quot;</i> (<?php echo $aantal; ?>)</h3>
						<table cellpadding="5" cellspacing="0" border="0">
						<?php
						foreach( $zoekresultaten as $zoekresultaat ){ ?>
							<tr >
								<td valign="top" width="120" class="date"> <B>&nbsp;&nbsp;<?php mooiedatum($zoekresultaat->Datum); ?></B></td>
								<td valign="top">&nbsp;</td>
								<td valign="top"><a href="http://www.expect-webmedia.nl/drpr/activiteit-detail?id=<?php echo $zoekresultaat->ID; ?>"><?php echo $zoekresultaat->Titel; ?></a></td>
							</tr>
						<?php }

						if(empty($zoekresultaten)){
							echo "Er zijn geen zoekresultaten<br />";
						}
					}
					?>
					</table>
				</div>
	
	
		<div class="contentHeaderActief">
			<h1>Activiteiten</h1>
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
								<td valign="top" width="285"><a href="http://www.expect-webmedia.nl/drpr/activiteit-detail?id=<?php echo $activiteit->ID; ?>"><?php echo $activiteit->Titel; ?></a></td>
								<td valign="top"><?php if(!empty($aanmeldingen)){ ?><a href="http://www.expect-webmedia.nl/drpr/print-werkbriefjes/?actid=<?php echo $activiteit->ID; ?>" target="_blank"><span>print werkbriefjes</span></a><?php 				} ?></td>
							</tr>
				<?php } 
				
					if(empty($activiteiten)){
						echo "Er zijn nog geen activiteiten";
					}
				?>
			</table>
		</div>
	</div>
				

<?php

get_footer(); ob_end_flush(); ?>