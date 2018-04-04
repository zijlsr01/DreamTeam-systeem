<?php
/*
Template Name: Briefing detail E-mail Template 2017
*/
get_header();  ?>
	<?php
		//gegevens van dreamteamer/promoteamer ophalen
		global $wpdb;
		$mailID = $_GET['mailID'];
		$mailDetails = $wpdb->get_row("SELECT * FROM BriefingMaillijst WHERE ID = $mailID" );
		$vandaag = date('Ymd');
		$briefings3 = $wpdb->get_results( "SELECT * FROM Briefing WHERE Datum >= '".$vandaag."' ORDER BY Datum ASC" );
		$zonder = "zonder";

		if(!empty($_GET['add'])){ ?>
		<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
			E-mail met succes aangemaakt!
		</div>
		<?php }

		if(!empty($_GET['delml'])){
			$wpdb->query( " DELETE FROM BriefingMaillijst WHERE ID = ".$_GET['delml']." "  );
			?>
			<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
				E-mail met succes verwijderd!
			</div>
			<?php
		}


		//mail versturen
			if(isset($_GET['send']) && !isset($_GET['reminder'])){
				$ListID = $_GET['send'];
				$ActID = $mailDetails->ActID;
				$sendDate = $wpdb->get_row( "SELECT * FROM BriefingMaillijst WHERE ID = '".$ListID."'" );
				$toDay = date('Ymd');
				$mail = "";
				if($sendDate->Verzonden != '1' ){
					if($mailDetails->ActID != $zonder){
					MailBriefingReeks($ListID,$ActID,$mail);
					}else{
					MailBriefingReeks($ListID,$ActID,$mail);
					}
				?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						E-mail met succes verstuurd!
					</div>
				<?php
				}else{ ?>
					<div id="alertTop">
						<ul>
							<li>Je hebt deze Email al verstuurd!</li>
						</ul>
					</div>
				<?php }
			}

			//Reminder versturen
			if(!isset($_GET['send']) && isset($_GET['reminder'])){
				$ListID = $_GET['reminder'];
				$ActID = $mailDetails->ActID;
				$mail = "Reminder: ";
				$sendDate = $wpdb->get_row( "SELECT * FROM BriefingMaillijst WHERE ID = '".$ListID."'" );
				$toDay = date('Ymd');
				if($sendDate->reminderDate != $toDay ){
					verzendMailNieuw($ListID,$ActID,$mail);
					?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						Reminder is met succes verstuurd!
					</div>
				<?php
				}else{?>
					<div id="alertTop">
						<ul>
							<li>Je hebt deze reminder vandaag al verstuurd!</li>
						</ul>
					</div>
				<?php }
			}


				if($_POST['maillijst']){
					if(empty($_POST['naam'])){
						$error .= "<li>Je bent vergeten een naam te kiezen!</li>";
					}

					if(empty($_POST['briefing'])){
						$error .= "<li>Je bent vergeten een opdracht te kiezen!</li>";
					}

					if(empty($error)){
					//als er geen fouten zijn dan gaan we de gegevens in de database zetten

					//$studiejaar = implode(",", $_POST['studiejaar']);
					//$vooropleiding = implode(",", $_POST['vooropleiding']);
					$briefings = implode(",", $_POST['briefing']);

					$wpdb->update( BriefingMaillijst, array( 'Naam' => $_POST['naam'], 'ActID' => $briefings, 'comment' => $_POST['comments']),array( 'ID' => $mailID) );

					//$wpdb->update( Maillijst, array( 'Max_deelnemers' => '0'),array( 'ID' => $_GET['id']) );

					?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						E-mail met succes gewijzigd!
					</div>
					<?php

					}
				}


	$mailDetails = $wpdb->get_row("SELECT * FROM BriefingMaillijst WHERE ID = $mailID" );
	$briefings = explode(",",$mailDetails->ActID);

		//$studiejaren =  explode(",",$mailDetails->Studiejaar);
		//$vooropleidingen =  explode(",",$mailDetails->Vooropleiding);

	?>
	<div style="clear: both;"></div>
	<div id="contentLinks">
		<div class="contentHeader6">
			<h1>Gegevens E-mail</h1>


			<div class="edit"><?php if(!isset($_GET['edit'])){ ?><a href="/drpr/briefing-mail-detail/?mailID=<?php echo $mailID; ?>&edit=1"><img src="<?php bloginfo('template_url'); ?>/images/edit.png" alt="" title="bewerk e-mail"></a><?php } ?><a href="/drpr/briefing-mail-detail/?delml=<?php echo $mailID; ?>" ><img src="<?php bloginfo('template_url'); ?>/images/iconDelete.png" alt="" title="Verwijder e-mail" onclick="return confirm('Weet je zeker dat je deze pe-mail wilt verwijderen?')"/></a>  </div>
		</div>
		<div class="contentContent">

			<!-- edit formulier -->
			<?php


				if(!empty($_GET['edit']) || $_POST['maillijst'] && !empty($error)){

				//als het formulier verzonden is en er zijn foutmeldingen
				if(!empty($error)){ ?>
					<div id="alert">
						<ul>
							<?php echo $error; ?>
						</ul>
					</div>
					<?php } ?>


					<form action="https://www.expect-webmedia.nl/drpr/briefing-mail-detail/?mailID=<?php echo $mailID; ?> " method="post" name="instellingen">
					Onderwerp E-mail<br />
					<input type="text" name="naam" value="<?php if(!isset($_POST['naam'])){ echo $mailDetails->Naam; }else{ echo $_POST['naam'];} ?>" /><br /><br />
					Voor welke activiteit(en) is deze E-mail<br />


					<?php
						$vandaag = date('Ymd');
						$briefings2 = $wpdb->get_results( "SELECT * FROM Briefing WHERE ContactpersoonID = $current_user->ID AND Startdatum >= '".$vandaag."' ORDER BY Startdatum ASC");
						$zonder = "zonder";
					?>
					<table border="0" cellpadding="0" cellspacing="5">
					<tr>
						<td valign="top"><h2>Briefings</h2></td>
					</tr>
						<?php
						$briefings3= $wpdb->get_var( "SELECT ActID FROM BriefingMaillijst WHERE  ID >= '".$mailID."'" );
						$opdrachten2 = explode(",", $briefings3);
						?>
						<?php foreach($briefings2 as $briefing2){ ?>
						<tr>
						<td valign="top">
							<input type="checkbox" class="check" name="briefing[]" id="<?php echo $briefing2->ID; ?>" value="<?php echo $briefing2->ID; ?>" <?php if(in_array($briefing2->ID, $opdrachten2 )){ echo "checked";} ?>/>




							<label for="<?php echo $briefing2->ID; ?>"><?php echo $briefing2->Titel; ?></label>
						</td>
						</tr>
						<?php }?>
					</table>

          <br /><br />
					Aanvullende tekst (wordt in e-mail getoond)<br />
					<textarea name="comments"><?php echo $mailDetails->comment; ?></textarea>
					<br /><br />
					<a href="/drpr/briefing-mail-detail/?mailID=<?php echo $mailID; ?>">Annuleren</a><input type="submit" value="E-mail bijwerken" name="maillijst" id="submit">
				</form>



					<br /><br />
				</div>

			<?php }else { ?>

				<?php if (!$mailDetails)  {?>


									<table border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td>
												<?php echo "Deze mail bestaat niet (meer) in het systeem!"; ?>
											</td>
										</tr>
									</table>

								<?php }

								elseif (condition) { ?>

			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="130">Onderwerp E-mail</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $mailDetails->Naam; ?></td>
				</tr>
				<tr>
					<td valign="top">Opdracht(en)</td>
					<td valign="top">:</td>
					<td valign="top">
						<ul style="list-style-type: square; margin: 0px; padding-left: 15px;">
					<?php
					$vandaag = date('Ymd');

				  $briefings2= $wpdb->get_var( "SELECT ActID FROM BriefingMaillijst WHERE  ID >= '".$mailID."'" );
					$opdrachten = explode(",", $briefings2);


						$zonder = "zonder";


					if($mailDetails->ActID != $zonder){
								foreach($opdrachten as $opdracht){
									$opdrData = $wpdb->get_row( "SELECT * FROM Briefing WHERE  ID >= '".$opdracht."'" );
								?>
									<li>

										<a href="/drpr/briefing-detail/?id=<?php echo $opdracht; ?>" target="_self"><?php echo $opdrData->Titel; ?></a></li>
					<?php }

						}
						else{ ?>
							<li>Deze e-mail is niet gekoppeld aan een activiteit</li>
						<?php }
					?>
						</ul>
					</td>
				</tr>
				<tr>
					<td valign="top" width="130">Aangemaakt door</td>
					<td valign="top">:</td>
					<td valign="top"><?php contactNaam($mailDetails->UserID); ?></td>
				</tr>
				<tr>
					<td valign="top" width="130">Aanvullende tekst </td>
					<td valign="top">:</td>
					<td valign="top">
					<?php
						$tekst = $mailDetails->comment;
						echo nl2br($tekst);
					?>
					</td>
				</tr>
			</table>

<?php } // einde if (!$mailDetails)  ?>

		</div>
		<?php } ?>


	</div>

	<div id="contentRechts">
		<div class="contentHeaderMail">
			<h1>Verzendgeschiedenis</h1>
		</div>
		<div class="contentContent">
			<table border="0" cellpadding="0" cellspacing="0">
			<?php
			$reminders = $wpdb->get_results( "SELECT * FROM Reminders WHERE mailID = '".$mailID."' ORDER BY reminderDate DESC" );
			foreach($reminders as $reminder){
			?>
				<tr>
					<td valign="top" width="110"><?php mooiedatum($reminder->reminderDate); ?></td>
					<td valign="top"></td>
					<td valign="top">Reminder verstuurd</td>
				</tr>
				<?php } ?>
			<?php if(!empty($mailDetails->SendDate)){ ?>
				<tr>
					<td valign="top" width="110"><?php mooiedatum($mailDetails->SendDate); ?></td>
					<td valign="top"></td>
					<td valign="top">E-mail verstuurd</td>
				</tr>
				<?php }else{
					echo "Deze e-mail is nog niet verstuurd.";
				} ?>
			</table>
		</div>
		<div id="buttonContainer">
			<?php if(!empty($mailDetails->SendDate)){ ?>
			<div class="coverButtonNew"></div><?php } ?>
			<div class="buttonNew" onclick="location.href='/drpr/briefing-mail-detail/?mailID=<?php echo $mailID; ?>&send=<?php echo $mailID; ?>';">
				Verstuur E-mail
			</div>

			<?php /*
			$toDay = date('Ymd');
			$reminderCheck = $wpdb->get_var( "SELECT * FROM Reminders WHERE mailID = '".$mailID."' AND reminderDate  = '".$toDay."'" );
			if(!empty($reminderCheck) || empty($mailDetails->SendDate) || $mailDetails->SendDate == $toDay){ ?>
			<div class="coverButtonNew2"></div><?php } ?>
			<div class="button2New" onclick="location.href='/drpr/briefing-mail-detail/?mailID=<?php echo $mailID; ?>&reminder=<?php echo $mailID; ?>';">
				Verstuur Reminder
				*/
				?>


			<div class="button3New"  onclick="window.open('http://www.expect-webmedia.nl/drpr/preview-email-contentbeheer/?mailid=<?php echo $mailID; ?>')">
				 Preview E-mail
			</div>
		</div>

	</div>
<?php get_footer(); ?>
