<?php  ob_start();
/*
Template Name: Reserveren
*/


get_header();

				//connect to the database
				global $wpdb; $current_user;

				$vandaag = date('Ymd');
				$reserveringen = $wpdb->get_results( "SELECT * FROM Reserveringen WHERE Datum = '".$vandaag."' ORDER BY Tijd_van ASC" );

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
			<h1>Vergaderruimte reserveren</h1>
		</div>
		<div class="contentContent">
			<?php 
				//kijken of er fouten zijn gemaakt
				if(empty($_POST['titel'])){	$error .= "<li>Je bent vergeten de titel in te vullen</li>";	}
				if(empty($_POST['datum'])){	$error .= "<li>Je bent vergeten een datum in te vullen</li>";	}
				if(empty($_POST['startTijd'])){	$error .= "<li>Je bent vergeten een starttijd in te vullen</li>";	}
				if(empty($_POST['eindTijd'])){	$error .= "<li>je bent vergeten een eindtijd in te vullen</li>";}
				if(empty($_POST['contactpersoon'])){ $error .= "<li>Je bent vergeten een contactpersoon in te vullen</li>";	}
				if(empty($_POST['emailcontactpersoon'])){	$error .= "<li>Je bent vergeten een e-mailadres van een contactpersoon in te vullen</li>";	}


				//kijken of er op dat tijdstip al wat is geboekt

					$orgStart  = $_POST['startTijd'];
					$start = str_replace(':', '', $orgStart);
					$orgEinde = $_POST['eindTijd'];
					$einde = str_replace(':', '', $orgEinde);
					$resDate = date("Ymd", strtotime($_POST['datum']));
					$algeboekten = $wpdb->get_results( "SELECT * FROM Reserveringen WHERE Datum = '".$testdate."'" );
					$totalRange = array(
"100","115","130","145","200","215","230","245","300","315","330","345","400","415","430","445","500","515","530","545","600","615","630","645","700","715","730","745","800","815","830","845","900","915","930","945","1000","1015","1030","1045","1100","1115","1130","1145","1200","1215","1230","1245","1300","1315","1330","1345","1400","1415","1430","1445","1500",  "1515","1530","1545","1600","1615","1630","1645","1700","1715","1730","1745","1800","1815","1830","1845","1900","1915","1930","1945","2000","2000","2015","2030","2045","2100","2115","2130","2145","2200","2215","2230","2245","2300","2315","2330","2345");

				foreach($totalRange as $data){
					if($data > $start && $data <= $einde){
						
						 
						 //gegevens uit de database halen van reserveringen die op dezelfde dag zijn geboekt
						 $algeboekten = $wpdb->get_results( "SELECT * FROM Reserveringen WHERE Datum = '".$resDate."'" );
						//loop door de reeds gereserveerde tijden heen
						 foreach($algeboekten as $algeboekt){
							$multi = explode(',', $algeboekt->range);
							if(in_array($data,$multi)){
								$error .= "<li>Dit tijdstip is al geboekt</li>";
								$errorStop = "1";
							}

						 }
						 if($data == $einde){
							break;
						 }

						 if(isset($errorStop)){
							break;
						 }
					}

				}




	
			
				if(isset( $_POST['submit'] ) && !empty($error)){ 
					
					?>
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


					$orgStart  = $_POST['startTijd'];
					$start = str_replace(':', '', $orgStart);
					$orgEinde = $_POST['eindTijd'];
					$einde = str_replace(':', '', $orgEinde);
					$totalRange = array(
"100","115","130","145","200","215","230","245","300","315","330","345","400","415","430","445","500","515","530","545","600","615","630","645","700","715","730","745","800","815","830","845","900","915","930","945","1000","1015","1030","1045","1100","1115","1130","1145","1200","1215","1230","1245","1300","1315","1330","1345","1400","1415","1430","1445","1500",  "1515","1530","1545","1600","1615","1630","1645","1700","1715","1730","1745","1800","1815","1830","1845","1900","1915","1930","1945","2000","2000","2015","2030","2045","2100","2115","2130","2145","2200","2215","2230","2245","2300","2315","2330","2345");

				foreach($totalRange as $data){
					if($data > $start && $data <= $einde){
						 $items = $data.",";
						 if($data == $einde){
							break;
						 }
					}

					$eindresul .= $items;

					

				}
				$rer = substr($eindresul, 0, -1);
					


					$wpdb->insert( Reserveringen, array( 'Titel' => $_POST['titel'], 'Datum' => $dbDate, 'Tijd_van' => $_POST['startTijd'], 'Tijd_tot' => $_POST['eindTijd'], 'ContactpersoonID' => $current_user->ID ,'Contactpersoon' => $_POST['contactpersoon'], 'Contactemail' => $_POST['emailcontactpersoon'], 'range' => $rer, 'Opmerkingen' => $_POST['opmerkingen'], 'actKey' => $actKey ) ); 
					
					$studNr = $_POST['studnr'];
					$ActDetails = $wpdb->get_row("SELECT * FROM Reserveringen WHERE actKey = $actKey" );
					$url = "http://www.expect-webmedia.nl/drpr/vergaderruimte-reserveren/?id=".$ActDetails->ID;
					wp_redirect( $url.'&add=succes' ); exit;
				}
			?>

			<?php 
				if(!isset( $_POST['submit'] ) || !empty($error)){ 
					get_currentuserinfo();
					?>
			<form action="" method="post">
				Naam *<br />
				<input type="text" name="contactpersoon" value="<?php if(!isset($_POST['contactpersoon'])){ echo $current_user->display_name; }else{ echo $_POST['contactpersoon'];} ?>" /><br /><br />
				E-mail *<br />
				<input type="text" name="emailcontactpersoon" value="<?php if(!isset($_POST['emailcontactpersoon'])){ echo $current_user->user_email; }else{ echo $_POST['emailcontactpersoon'];} ?>" /><br /><br />
				Onderwerp <small>(bijvoorbeeld Vergadering of plangesprek)</small> *<br />
				<input type="text" name="titel" value="<?php echo $_POST['titel']; ?>" /><br /><br />
				Datum *<br />
				<input type="text" name="datum" id="datum" value="<?php echo $_POST['datum']; ?>" /><br /><br />
				Starttijd<br />
				<input type="text" name="startTijd" id="startTijd" value="<?php echo $_POST['startTijd']; ?>" /><br /><br />
				Eindtijd<br />
				<input type="text" name="eindTijd" id="eindTijd" value="<?php echo $_POST['eindTijd']; ?>" /><br /><br />
				Eventuele opmerkingen<br />
				<textarea name="opmerkingen"><?php echo $_POST['opmerkingen']; ?></textarea><br /><br />
				<input type="submit" id="submit" name="submit" value="Ruimte reserveren">
			</form>

			<?php } ?>
		</div>
	</div>

	<div id="contentRechts">

	<div class="contentHeaderActief">
			<h1>Reserveringen voor vandaag &nbsp; <small><b>( <?php echo date('d.m.Y'); ?> )</b></small></h1>
		</div>
		<div class="contentContent">
			<table border="0" cellpadding="5" cellspacing="3">
				<?php 
				foreach($reserveringen as $activiteit){ ?>
							<tr >
								<td valign="top" width="120" class="date"> <B>&nbsp;&nbsp;<?php mooiedatum($activiteit->Datum); ?></B></td>
								<td valign="top" width="120"><a href="/drpr/reserverings-detail//?id=<?php echo $activiteit->ID; ?>"><?php echo $activiteit->Tijd_van." - ".$activiteit->Tijd_tot ; ?> uur</a></b></td>
								<td valign="top"><?php echo $activiteit->Contactpersoon; ?></td>
							</tr>	
				<?php } 
				?>
			</table>
		</div>
		<div class="contentHeaderActief">
			<h1>Komende reserveringen</h1>
		</div>
		<div class="contentContent">
		<table border="0" cellpadding="5" cellspacing="3">
				<?php 
				$activiteiten = $wpdb->get_results( "SELECT * FROM Reserveringen WHERE Datum > '".$vandaag."' ORDER BY Datum ASC" );
				foreach( $activiteiten as $activiteit ){ 
				
				//kijken of er wel aanmeldingen zijn, anders geen werkbriefjes
				$aanmeldingen = $wpdb->get_results( "SELECT * FROM Aanmeldingen WHERE ActID = '".$activiteit->ID."' AND Afwezig != 'afwezig'" );
				?>
							<tr >
								<td valign="top" width="120" class="date"> <B>&nbsp;&nbsp;<?php mooiedatum($activiteit->Datum); ?></B></td>
								<td valign="top" width="120"><a href="/drpr/reserverings-detail//?id=<?php echo $activiteit->ID; ?>"><?php echo $activiteit->Tijd_van." - ".$activiteit->Tijd_tot ; ?> uur</a></b></td>
								<td valign="top"><?php echo $activiteit->Contactpersoon; ?></td>
							</tr>
				<?php } 
				
					if(empty($activiteiten)){
						echo "Er zijn nog geen activiteiten";
					}
				?>
			</table>
		</div>
		<div class="contentHeaderZoeken">
					<h1>Zoek (voorgaande) activiteiten</h1>
				</div>
				<div class="contentContent">
					<form method="post" id="search">
						<input type="text" name="datum" id="datum" value="<?php echo $_POST['datum']; ?>" />
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
	
	</div>
				

<?php

get_footer(); ob_end_flush(); ?>