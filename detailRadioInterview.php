<?php 
/*
Template Name:  Detail Radio Interview
*/
get_header(); 
		//gegevens van dreamteamer/promoteamer ophalen
		global $wpdb; $current_user;
		get_currentuserinfo();
		$actID = $_GET['id'];
		$actDetails = $wpdb->get_row("SELECT * FROM Radiointerview WHERE ID = $actID" );

			//aanhakers toevoegen
		
			if($_POST[addMid]){
	
				
				if(!empty($_POST['special'])){	
				$special = implode(",", $_POST['special']);
				}
				
				if(!empty($_POST['radio'])){
				$radio = implode(",", $_POST['radio']);
				}
				
				if(!empty($_POST['social'])){
				$social = implode(",", $_POST['social']);
				}
				
				if(!empty($_POST['campagne'])){
				$campagne = implode(",", $_POST['campagne']);
				}
				
				if(!empty($_POST['persbericht'])){
				$persbericht = implode(",", $_POST['persbericht']);
				}

				if(!empty($_POST['event'])){
				$event = implode(",", $_POST['event']);
				}
	
				
				$isAlAanhaker = $wpdb->get_row( "SELECT * FROM Aanhakers WHERE Radiointerview LIKE '%".$actID."%' " );
				if(empty($isAlAanhaker)){
				$wpdb->insert( Aanhakers, array( 'Social' => $social, 'Radiointerview' => $actID, 'Persbericht' => $persbericht , 'Special' => $special, 'Campagne' => $campagne, 'Event' => $event ) );
				$al = "nee";
				}else{
					$wpdb->update( Aanhakers, array( 'Social' => $social, 'Radiointerview' => $actID, 'Persbericht' => $persbericht, 'Special' => $special, 'Campagne' => $campagne, 'Event' => $event  ),array( 'ID' => $isAlAanhaker->ID) );
				$al = 'ja';
				}
				if(!empty($special) || !empty($persB)){
				?>
				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
				<?php if($al == 'nee'){
					echo "Aanhaker(s) met succes toegevoegd";
				}else{
					echo "Aanhaker(s) met succes gewijzigd";
				} ?>
					
				</div>
				<?php 
					}	
				}
				
			//Einde aanhakers toevoegen

	//Verwijderen aanhakers ID persberichten
	if(!empty($_GET['delaanhaaker']) && !empty($_GET['persid']) && !empty($_GET['id'])){
				$radid = $_GET['id'];
				$persid = $_GET['persid'];
				$wpdb->query(   "  UPDATE Aanhakers SET Persbericht = '' WHERE Persbericht = ".$persid." AND Radiointerview = ".$radid." "  );
				?>
				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					Aanhaker met succes verwijderd
				</div>
				<?php 
						
				}
	//Verwijderen aanhakers ID social
	if(!empty($_GET['delaanhaaker']) && !empty($_GET['socialid']) && !empty($_GET['id'])){
				$radid = $_GET['id'];
				$socialid = $_GET['socialid'];
				$wpdb->query(   "  UPDATE Aanhakers SET Social = '' WHERE Social = ".$socialid." AND Radiointerview = ".$radid." "  );
				?>
				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					Aanhaker met succes verwijderd
				</div>
				<?php 
						
				}
		
	
			if($_GET['add'] == 'succes'){ ?>
	<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
		Radio interview met succes toegevoegd!
	</div>
	<?php }

	
		 
					if($_POST['submit']){ 
				//kijken of er fouten zijn gemaakt
				if(empty($_POST['titel'])){	$error .= "<li>Je bent vergeten de titel in te vullen</li>";	}
				if(empty($_POST['startTijd'])){	$error .= "<li>Je bent vergeten een datum in te vullen</li>";	}
				if(empty($_POST['beschrijving'])){	$error .= "<li>Je bent vergeten een beschrijving in te vullen</li>";}
				}



					if($_POST['submit'] && empty($error)){
					//Campagne updaten
						$userData = get_userdata($_POST['contactpersoon']);
						if($actDetails->type == 'Campagne'){
							$kanalen = implode(",", $_POST['kanaal']);
						}
						
						$startD = date("Ymd", strtotime($_POST['startTijd']));
						$eindD = date("Ymd", strtotime($_POST['eindTijd']));
						
						$wpdb->update( Radiointerview, array( 'Titel' => $_POST['titel'], 'Tijd_van' => $startD, 'Tijd_tot' => $startD, 'Omschrijving' => $_POST['beschrijving'] ),array( 'ID' => $_GET['id']) ); 
						$actDetails = $wpdb->get_row("SELECT * FROM Radiointerview WHERE ID = $actID" );

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
				<?php } 
				$title_lang = $actDetails->Titel;
				$lengte = strlen($title_lang);
						
				if($lengte > 45){
					$title = substr($title_lang, 0, 45)." ...";
				}else{
					$title = $title_lang;
				}
				
				
				?>
	<div style="clear: both;"></div> 
	<div id="contentLinks">
		<div style="height: 5px; width: 590px; background: <?php echo $actDetails->kleur; ?>; float: left;">&nbsp;</div>
		<div class="contentHeaderContent">
		<div class="contentHeaderIcon"><img src="<?php bloginfo('template_url'); ?>/images/iconRadio.png" width="30"></div>
			<h1>Radiointerview: <?php echo $title; ?></h1>
			<div class="edit"><?php if(!isset($_GET['edit'])){ ?><a href="/drpr/detailpagina-radiointerview/?id=<?php echo $actDetails->ID; ?>&edit=1" ><img src="<?php bloginfo('template_url'); ?>/images/edit.png" alt="" title="Bewerk de gegevens" /></a><?php } ?><a href="/drpr/contentkalender?delete5=yes&id=<?php echo $actDetails->ID; ?>" ><img src="<?php bloginfo('template_url'); ?>/images/iconDelete.png" alt="" title="Verwijderen" onclick="return confirm('Weet je zeker dat je dit radio interview wilt verwijderen?')"/></a></div>
		</div>
		<div class="contentContentdr" >
		<?php if(empty($_GET['edit']) || !empty($show) && empty($error)){ 
		$actDetails = $wpdb->get_row("SELECT * FROM Radiointerview WHERE ID = $actID" );
		?>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="130"> Titel</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $actDetails->Titel; ?></td>
				</tr>
				<tr>
					<td valign="top"><?php if($actDetails->type == 'Campagne'){
						echo "Looptijd"; }else{
							echo "Datum";
						} ?></td>
					<td valign="top">:</td>
					<td valign="top"><?php 
						if($actDetails->Tijd_van != $actDetails->Tijd_tot){
						echo mooiedatum($actDetails->Tijd_van);
						echo " - ";
						echo mooiedatum($actDetails->Tijd_tot);}else{
							echo mooiedatum($actDetails->Tijd_tot);
						}?></td>
				</tr>
				<tr>
					<td valign="top">Omschrijving</td>
					<td valign="top">:</td>
					<td valign="top" ><?php echo $actDetails->Omschrijving; ?></td>
				</tr>
			</table>
			
			<?php }


				
			if(!empty($_GET['edit']) && !empty($_GET['id']) || empty($_GET['edit']) && !empty($error) && $_POST['submit']){ 
			$actId = $_GET['id'];
			$actDetails = $wpdb->get_row("SELECT * FROM Radiointerview WHERE ID = $actID" );
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
				
				<form action="https://www.expect-webmedia.nl/drpr/detailpagina-radiointerview/?id=<?php echo $_GET['id'];?>&show=1 " method="post">
				Titel *<br />
				<input type="text" name="titel" value="<?php if(!isset($_POST['titel'])){ echo $actDetails->Titel; }else{ echo $_POST['titel'];} ?>" /><br /><br />
				Startdatum<br />
				
				<input type="text" name="startTijd" id="startDate" value="<?php echo $startD; ?>" /><br /><br />

				Omschrijving *<br />
				<textarea name="beschrijving"><?php echo  $actDetails->Omschrijving ?></textarea><br /><br />
				<a href="/drpr/detailpagina-radiointerview/?id=<?php echo $actDetails->ID; ?> ">Annuleren</a> <input type="submit" id="submit" name="submit" value="Bijwerken">
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
				$middelDetails = $wpdb->get_row( "SELECT * FROM Middelen WHERE ID = '".$campagneMiddel->Middel."' AND Campagne = '".$actID."'" );	
				?>
				<tr bgcolor="#8b8b8b" style="color: #ffffff;">
					<td valign="top" colspan="2" >&nbsp;<?php echo getMiddelName($campagneMiddel->Middel); if(!empty($campagneMiddel->omschrijving)){ ?> - <small><?php echo $campagneMiddel->omschrijving; ?></small><?php } ?><a href="http://www.expect-webmedia.nl/drpr/contentdetail/?id=<?php echo $actID; ?>&camMidDel=<?php echo $campagneMiddel->ID; ?>" onclick="return confirm('Weet je zeker dat je dit campagnemiddel wilt verwijderen?')" ><img src="<?php bloginfo('template_url'); ?>/images/iconTrash.png" alt="" title="Dit campagnemiddel verwijderen" style="float: right; padding-top: 2px; margin-right: 3px;"></a></td>
				</tr>
				<tr>
					<td valign="top" width="150">UTM-code</td>
					<td valign="top" ><input value="<?php if(!empty($campagneMiddel->URL)){ echo $campagneMiddel->URL."?utm_source=".getChanel($kanaal)."&utm_medium=".getMedium($campagneMiddel->Middel)."&utm_campaign=".createCampagneName($actID);}else{ echo $actDetails->CampagnePage."?utm_source=".getChanel($kanaal)."&utm_medium=".getMedium($campagneMiddel->Middel)."&utm_campaign=".createCampagneName($actID); } ?>" onClick="this.setSelectionRange(0, this.value.length)" style="width: 450px; padding: 0px 3px; background-color: none; margin-bottom: 5px;"/></td>
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
						<form action="http://www.expect-webmedia.nl/drpr/contentdetail/?id=<?php echo $_GET['id'];?>&show=1 " method="post">
						Campagnemiddel*<br />
						<select name="middel" style="width: 520px; margin-top: 5px;">
						<option value="selectie"> - selecteer campagnemiddel - </option>
						<?php 
							$middelen = $wpdb->get_results( "SELECT * FROM Middelen WHERE Kanaal = '".$kanaal."' ORDER BY ID" );						
							foreach($middelen as $middel){ ?>
							<option value="<?php echo $middel->ID; ?>"><?php echo $middel->Uiting_type; ?></option>
							<?php } ?>
							<select><br /><br />
						Korte omschrijving<br />
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
				$activiteiten = $wpdb->get_results( "SELECT * FROM Aanhakers WHERE Radiointerview LIKE '%".$actID."%'" );
				?>
			<h1>Aanhakers <small>( Met welke (Social) Media kanalen haken we aan ) </small></h1>
		</div>
		<div class="contentContentdr">
		
			<?php if(empty($_GET['add']) || $_GET['chanel'] != $kanaal){ 
			

			?>
					<a href="/drpr/detailpagina-radiointerview?id=<?php echo $actID; ?>&add=1&chanel=<?php echo $kanaal; ?>#<?php echo $kanaalDetails->Kanaal; ?>"><img src="<?php bloginfo('template_url'); ?>/images/buttonToevoegenAanhaker.png" border="0"></a>
					<?php } ?>
					<?php if(!empty($_GET['add']) && $_GET['chanel'] == $kanaal){ ?>
					<div style="background: #f37021; padding: 10px; border-radius: 10px;" class="addMid">
					<img src="<?php bloginfo('template_url'); ?>/images/buttonToevoegenAanhaker.png" border="0">
						<form action="https://www.expect-webmedia.nl/drpr/detailpagina-radiointerview/?id=<?php echo $_GET['id'];?>&show=2 " method="post">
						
						<!-- Speciale dagen -->
						<b>Persberichten</b><br />
						<table cellpadding="0" cellspacing="0" border="0">
						<?php 
						$uitsluitenSpecial= $wpdb->get_row("SELECT * FROM Aanhakers WHERE Radiointerview LIKE '%".$actID."%'");
						$uitSpecial = explode(',', $uitsluitenSpecial->Persbericht);
				
						$nu = date('Ymd');
							$specials = $wpdb->get_results( "SELECT * FROM Persbericht WHERE Tijd_van >= '".$nu."' ORDER BY Tijd_van" );							
							foreach($specials as $special){ 
							?>
							<tr>
 								<td>
									<input type="checkbox" id="<?php echo $special->ID;?>" value="<?php echo $special->ID;?>" name="persbericht[]" style="float: left; width: 20px;"<?php if(in_array($special->ID, $uitSpecial)){echo 'checked';}?>><label for="<?php echo $special->ID;?>"><?php echo $special->Titel." (".get_mooiedatum($special->Tijd_van).")"; ?>
								</td>
							</tr>
							<?php }  if(empty($specials)){ ?>
								<tr>
								<td>
								 Er zijn geen persberichten
								 </td>
								</tr>
							<?php }?>
							</table>
							<!-- /Speciale dagen -->
							
							<!-- Speciale dagen -->
						<b>Speciale dag(en)</b><br />
						<table cellpadding="0" cellspacing="0" border="0">
						<?php 
						$uitsluitenSpecial= $wpdb->get_row("SELECT * FROM Aanhakers WHERE Radiointerview LIKE '%".$actID."%'");
						$uitSpecial = explode(',', $uitsluitenSpecial->Special);
				
						$nu = date('Ymd');
							$specials = $wpdb->get_results( "SELECT * FROM Special WHERE Tijd_van >= '".$nu."' ORDER BY Tijd_van" );							
							foreach($specials as $special){ 
							?>
							<tr>
 								<td>
									<input type="checkbox" id="<?php echo $special->ID;?>" value="<?php echo $special->ID;?>" name="special[]" style="float: left; width: 20px;"<?php if(in_array($special->ID, $uitSpecial)){echo 'checked';}?>><label for="<?php echo $special->ID;?>"><?php echo $special->Titel." (".get_mooiedatum($special->Tijd_van).")"; ?>
								</td>
							</tr>
							<?php }  if(empty($specials)){ ?>
								<tr>
								<td>
								 Er zijn geen speciale dagen
								 </td>
								</tr>
							<?php }?>
							</table>
							<!-- /Speciale dagen -->
							
							<!-- Social Media posts -->
							<b>Social Media Post(s)</b><br />
						<table cellpadding="0" cellspacing="0" border="0">
						<?php 
						$uitsluitenSocial = $wpdb->get_row("SELECT * FROM Aanhakers WHERE Radiointerview LIKE '%".$actID."%'");
						$uitSocial = explode(',', $uitsluitenSocial->Social);
				
							$nu = date('Ymd');
							$socials = $wpdb->get_results( "SELECT * FROM SocialPosts WHERE Tijd_van >= '".$nu."' ORDER BY Tijd_van" );							
							foreach($socials as $social){ 
							?>
							<tr>
 								<td>
									<input type="checkbox" id="<?php echo $social->ID;?>" value="<?php echo $social->ID;?>" name="social[]" style="float: left; width: 20px;" <?php if(in_array($social->ID, $uitSocial)){echo 'checked';}?>><label for="<?php echo $social->ID;?>"><?php echo $social->Titel." (".get_mooiedatum($social->Tijd_van).")"; ?>
								</td>
							</tr>
							<?php }  if(empty($socials)){ ?>
								<tr>
								<td>
								 Er zijn geen social media posts
								 </td>
								</tr>
							<?php }?>
							</table>
						<!-- /Social Media posts -->
						
						
						<!-- Campagnes -->
							<b>Campagnes</b><br />
						<table cellpadding="0" cellspacing="0" border="0">
						<?php 
						$uitsluitenCampagne = $wpdb->get_row("SELECT * FROM Aanhakers WHERE Radiointerview LIKE '%".$actID."%'");
						$uitSocial = explode(',', $uitsluitenCampagne->Campagne);
				
							$nu = date('Ymd');
							$campagnes = $wpdb->get_results( "SELECT * FROM Content WHERE Tijd_van >= '".$nu."' ORDER BY Tijd_van" );							
							foreach($campagnes as $social){ 
							?>
							<tr>
 								<td>
									<input type="checkbox" id="<?php echo $social->ID;?>" value="<?php echo $social->ID;?>" name="campagne[]" style="float: left; width: 20px;" <?php if(in_array($social->ID, $uitSocial)){echo 'checked';}?>><label for="<?php echo $social->ID;?>"><?php echo $social->Titel." (".get_mooiedatum($social->Tijd_van).")"; ?>
								</td>
							</tr>
							<?php }  if(empty($campagnes)){ ?>
								<tr>
								<td>
								 Er zijn geen campagnes
								 </td>
								</tr>
							<?php }?>
							</table>
						<!-- /campagnes -->

						<!-- interne evenementen -->
							<b>Interne Evenementen</b><br />
						<table cellpadding="0" cellspacing="0" border="0">
						<?php 
						$uitsluitenCampagne = $wpdb->get_row("SELECT * FROM Aanhakers WHERE Radiointerview LIKE '%".$actID."%'");
						$uitSocial = explode(',', $uitsluitenCampagne->Event);
				
							$nu = date('Ymd');
							$campagnes = $wpdb->get_results( "SELECT * FROM Event WHERE Tijd_van >= '".$nu."' ORDER BY Tijd_van" );							
							foreach($campagnes as $social){ 
							?>
							<tr>
 								<td>
									<input type="checkbox" id="<?php echo $social->ID;?>" value="<?php echo $social->ID;?>" name="event[]" style="float: left; width: 20px;" <?php if(in_array($social->ID, $uitSocial)){echo 'checked';}?>><label for="<?php echo $social->ID;?>"><?php echo $social->Titel." (".get_mooiedatum($social->Tijd_van).")"; ?>
								</td>
							</tr>
							<?php }  if(empty($campagnes)){ ?>
								<tr>
								<td>
								 Er zijn geen interne evenementen
								 </td>
								</tr>
							<?php }?>
							</table>
						<!-- /interne evenementen -->
						
							
							
						
						
							<br /><br />
						<a href="/drpr/detailpagina-radiointerview/?id=<?php echo $actDetails->ID; ?> ">Annuleren</a> <input type="submit" id="submit2" name="addMid" value="Verzend!" style="cursor: pointer;">
						</form>
					</div>
					<?php } ?>
			<table border="0" cellpadding="5" cellspacing="3">
			<?php

				$aanhaker = $wpdb->get_row("SELECT * FROM Aanhakers WHERE FIND_IN_SET('$actID', Radiointerview) > 0;");
				if(empty($aanhaker)){
					echo "<br/>Er zijn nog geen aanhakers!";
				} 
				else
					{
						
					//Persbericht	
					if(!empty($aanhaker->Persbericht)){?>
					<table border="0" cellpadding="5" cellspacing="3">
					<tr>
					<td valign="top" width="600" bgcolor="#000" style="color: #ffffff;">
					<div style="margin-top: 0px; margin-left: 5px; float: left;"><p><b>&nbsp;Persbericht(en)</b></p></div>
					</tr>
					<?php
						$specialArs = explode(',',$aanhaker->Persbericht);

						foreach($specialArs as $specialAr){ 
						$specialData = $wpdb->get_row( "SELECT * FROM Persbericht WHERE ID = '".$specialAr."' " );
						
						?>
						<tr bgcolor="#8b8b8b" style="color: #ffffff;">
						<td valign="top">
						&nbsp;<a style="color: #ffffff;" href="https://www.expect-webmedia.nl/drpr/detailpagina-persbericht/?id=<?php echo $specialData->ID; ?>"><?php echo $specialData->Titel." (".get_mooiedatum($specialData->Tijd_van).")";  ?></a>
						
						</td>
						</tr>
						<?php } ?>
						</table>
					<?php } 
					//Einde persbericht
					
					//Speciale dagen	
					if(!empty($aanhaker->Special)){?>
					<table border="0" cellpadding="5" cellspacing="3">
					<tr>
					<td valign="top" width="600" bgcolor="#000" style="color: #ffffff;">
					<div style="margin-top: 0px; margin-left: 5px; float: left;"><p><b>&nbsp;Speciale dag(en)</b></p></div>
					</tr>
					<?php
						$specialArs = explode(',',$aanhaker->Special);

						foreach($specialArs as $specialAr){ 
						$specialData = $wpdb->get_row( "SELECT * FROM Special WHERE ID = '".$specialAr."' " );
						
						?>
						<tr bgcolor="#8b8b8b" style="color: #ffffff;">
						<td valign="top">
						&nbsp;<a style="color: #ffffff;" href="https://www.expect-webmedia.nl/drpr/contentdetail-speciale-dagen/?id=<?php echo $specialData->ID; ?>"><?php echo $specialData->Titel." (".get_mooiedatum($specialData->Tijd_van).")";  ?></a>
						
						</td>
						</tr>
						<?php } ?>
						</table>
					<?php } 
					//Einde speciale dagen
					
					//Socialmedia
					if(!empty($aanhaker->Social)){?>
					<table border="0" cellpadding="5" cellspacing="3">
					<tr>
					<td valign="top" width="600" bgcolor="#000" style="color: #ffffff;">
					<div style="margin-top: 0px; margin-left: 5px; float: left;"><p><b>&nbsp;Social Media Post(s)</b></p></div>
					</tr>
					<?php
						$socialData = $wpdb->get_row("SELECT * FROM SocialPosts WHERE ID = '".$aanhaker->Social."'");
						?>
						<tr bgcolor="#8b8b8b" style="color: #ffffff;">
						<td valign="top">
						&nbsp;<a style="color: #ffffff;" href="https://www.expect-webmedia.nl/drpr/contentdetail-social-media-post/?id=<?php echo $socialData->ID; ?>"><?php echo $socialData->Titel." (".get_mooiedatum($socialData->Tijd_van).")";  ?></a>
						</td>
						</tr>
						</table>
					<?php } 
					//Einde SocialMedia
					
					//Campagnes
					if(!empty($aanhaker->Campagne)){?>
					<table border="0" cellpadding="5" cellspacing="3">
					<tr>
					<td valign="top" width="600" bgcolor="#000" style="color: #ffffff;">
					<div style="margin-top: 0px; margin-left: 5px; float: left;"><p><b>&nbsp;Campagne(s)</b></p></div>
					</tr>
					<?php
						$socialData = $wpdb->get_row("SELECT * FROM Content WHERE ID = '".$aanhaker->Campagne."'");
						?>
						<tr bgcolor="#8b8b8b" style="color: #ffffff;">
						<td valign="top">
						&nbsp;<a style="color: #ffffff;" href="https://www.expect-webmedia.nl/drpr/contentdetail/?id=<?php echo $socialData->ID; ?>"><?php echo $socialData->Titel." (".get_mooiedatum($socialData->Tijd_van).")";  ?></a>
						</td>
						</tr>
						</table>
					<?php } 
					//Einde Campagnes

					//Interne Evenmenten
					if(!empty($aanhaker->Event)){?>
					<table border="0" cellpadding="5" cellspacing="3">
					<tr>
					<td valign="top" width="600" bgcolor="#000" style="color: #ffffff;">
					<div style="margin-top: 0px; margin-left: 5px; float: left;"><p><b>&nbsp;Interne Event(s)</b></p></div>
					</tr>
					<?php
						$socialData = $wpdb->get_row("SELECT * FROM Event WHERE ID = '".$aanhaker->Event."'");
						?>
						<tr bgcolor="#8b8b8b" style="color: #ffffff;">
						<td valign="top">
						&nbsp;<a style="color: #ffffff;" href="https://www.expect-webmedia.nl/drpr/contentkalender/detail-intern-evenement/?id=<?php echo $socialData->ID; ?>"><?php echo $socialData->Titel." (".get_mooiedatum($socialData->Tijd_van).")";  ?></a>
						</td>
						</tr>
						</table>
					<?php } 
					//Interne Evenmenten
					
					
					?>
					
					
			
			<?php }} ?>
			</div>
	</div>
<?php

get_footer();