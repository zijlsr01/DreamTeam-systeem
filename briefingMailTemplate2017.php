<?php  ob_start();
/*
Template Name: Briefing Mail Template 2017
*/
get_header();  get_header();

				//connect to the database
				global $wpdb;

				//haal gegevens van de huidige gebruiker open
				$current_user = wp_get_current_user();


				if(!empty($_GET['delml']) && !$_POST['maillijst']){
					$wpdb->query( " DELETE FROM BriefingMaillijst WHERE ID = ".$_GET['delml']." "  );
					?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						E-mail met succes verwijderd!
					</div>
					<?php
				}


				//Maillijst formulier wordt verstuurd, we gaan kijken of er ook fouten zijn gemaakt.
				if($_POST['maillijst']){

					if(empty($_POST['naam'])){
						$error .= "<li>Je bent vergeten een naam te kiezen!</li>";
					}

					//$test = implode(",", $_POST['studiejaar']);

					if(empty($error)){
					//als er geen fouten zijn dan gaan we de gegevens in de database zetten

					//$studiejaar = implode(",", $_POST['studiejaar']);
					//$vooropleiding = implode(",", $_POST['vooropleiding']);
					$briefings2 = implode(",", $_POST['briefing']);

					$mailNaam = $_POST['naam'];
					$comments = $_POST['comments'];


					$wpdb->insert( BriefingMaillijst, array( 'Naam' => $mailNaam, 'ActID' => $briefings2, 'UserID' => $current_user->ID, 'comment' => $comments) );

					$mailID = $wpdb->insert_id;

					$url = "http://www.expect-webmedia.nl/drpr/briefing-mail-detail/?mailID=".$mailID;
					wp_redirect( $url.'&add=succes' ); exit;


					}
				}



				?>
				<div style="clear: both;"></div>
	<div id="contentLinks">
		<div class="contentHeader6">
			<h1>Voeg een E-mail toe </h1>
		</div>
		<div class="contentContent">
		<?php if(!empty($error)){ ?>
					<div id="alert">
						<ul>
							<?php echo $error; ?>
						</ul>
					</div>
					<?php } ?>
			<form action="" method="post" name="instellingen">
					Onderwerp E-mail<br />
					<input type="text" name="naam" value="<?php if(!empty($error)){ echo $_POST['naam']; }; ?>" /><br /><br />






					<?php
					global $wpdb;
					$nu = date('Ymd');
					if($userRole != 'author'){ ?>

							Voor welke opdracht(en) is deze E-mail<br />


						<table border="0" cellpadding="5" cellspacing="3">
								<?php
								$briefings2 = $wpdb->get_results( "SELECT * FROM Briefing WHERE ContactpersoonID = $current_user->ID AND Startdatum >= $nu ORDER BY Startdatum ASC");
								foreach( $briefings2 as $briefing2 ){
								$onderwerp = substr($briefing2->Titel, 0, 50);


								?>

								<tr>
										<td valign="top"><input type="checkbox" class="check" name="briefing[]" id="<?php echo $briefing2->ID; ?>" value="<?php echo $briefing2->ID; ?>"
											<?php if(!empty($_POST['briefing']) && !empty($error) &&  in_array( $briefings2->ID, $_POST['briefing'])){ ?>checked<?php } ?>>

											<label for="<?php echo $briefing2->ID; ?>">
												<?php echo $briefing2->Titel; ?>
											</label>
									</td>
								</tr>

								<?php } ?>



											<!--<tr >
												<td valign="top" width="150"> <B> <?php //echo get_mooiedatum($briefing2->Startdatum); ?></B></td>
												<td valign="top" width="230"> <B><a href="http://www.expect-webmedia.nl/drpr/briefing-detail/?id=<?php //echo// $briefing2->ID; ?>"><?php// echo $onderwerp; ?></a></B></td>
												<td valign="top" width="120"><?php //if(!empty($briefing2->ingepland)){ ?><img src="<?php // bloginfo('template_url'); ?>/images/iconDefinitief.png"><?php } ?></td>
												<td valign="top"><a href="https://www.expect-webmedia.nl/drpr/briefing-contentbeheer/?delete=yes&id=<?php// echo $briefing2->ID; ?>"  onclick="return confirm('Weet je zeker dat je deze opdracht wilt verwijderen?')"><img src="<?php // bloginfo('template_url'); ?>/images/buttonDelete.png"></a></td>
											</tr>

										-->

								<?php

									if(empty($briefings2)){
										echo "Je hebt nog geen opdrachten";
									}
								?>
							</table>




              <br /><br />
					Aanvullende tekst (wordt in e-mail getoond)<br />
					<textarea name="comments"><?php echo $_POST['comments']; ?></textarea>
					<br /><br />
					<input type="submit" value="E-mail aanmaken" name="maillijst" id="submit">
		  </form>
		</div>
	</div>

	<div id="contentRechts">
		<div class="contentHeader6">
			<h1>Mijn E-mails</h1>
		</div>
		<div class="contentContent">
		<table border="0" cellpadding="5" cellspacing="3">
				<?php
				global $wpdb;
				$maillijsten2 = $wpdb->get_results( "SELECT * FROM BriefingMaillijst WHERE UserID = $current_user->ID ORDER BY ID DESC");
				foreach( $maillijsten2 as $maillijst2 ){
				$onderwerp = substr($maillijst2->Naam, 0, 50);
				?>
							<tr >
								<td valign="top" width="500" title="Deze mailing heeft <?php aantalOntvangersNieuw($maillijst2->ID); ?> ontvangers"> <B>&nbsp;&nbsp;<a href="http://www.expect-webmedia.nl/drpr/briefing-mail-detail/?mailID=<?php echo $maillijst2->ID; ?>"><?php echo $onderwerp; ?> (<?php aantalOntvangersNieuw($maillijst2->ID); ?>)</a></B></td>
								<td valign="top"><a href="http://www.expect-webmedia.nl/drpr/briefing-mail-nieuw/?delml=<?php echo $maillijst2->ID; ?>"  onclick="return confirm('Weet je zeker dat je deze E-mail wilt verwijderen?')">X</a></td>
							</tr>
				<?php }

					if(empty($maillijsten2)){
						echo "Je hebt nog geen E-mails";
					}
				?>
			</table>
		</div>

		<div class="contentHeader6">
			<h1>E-mails van andere gebruikers <span style="font-size: 10px;">(laatste 20)</span></h1>
		</div>
		<div class="contentContent">
		<table border="0" cellpadding="5" cellspacing="3">
				<?php
				global $wpdb;
				$maillijsten = $wpdb->get_results( "SELECT * FROM BriefingMaillijst WHERE UserID != $current_user->ID ORDER BY ID DESC LIMIT 20");
				foreach( $maillijsten as $maillijst ){
				$onderwerp = substr($maillijst->Naam, 0, 50);
				?>
							<tr >
								<td valign="top" width="500" title="Deze mailing heeft <?php aantalOntvangersNieuw($maillijst->ID); ?> ontvangers"> <B>&nbsp;&nbsp;<a href="http://www.expect-webmedia.nl/drpr/briefing-mail-detail/?mailID=<?php echo $maillijst->ID; ?>"><?php echo $onderwerp; ?> (<?php aantalOntvangersNieuw($maillijst->ID); ?>)</a></B></td>
								<td valign="top"><a href="https://www.expect-webmedia.nl/drpr/briefing-mail-nieuw/?delml=<?php echo $maillijst->ID; ?>"  onclick="return confirm('Weet je zeker dat je deze E-mail wilt verwijderen?')">X</a></td>
							</tr>
				<?php }

					if(empty($maillijsten)){
						echo "Er zijn nog geen E-mails";
					}
				?>
			</table>
		</div>
	</div>




<?php

get_footer(); ob_end_flush(); ?>
