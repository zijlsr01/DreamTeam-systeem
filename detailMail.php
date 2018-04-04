<?php 
/*
Template Name: detailpagina Email
*/
get_header();  ?>
	<?php
		//gegevens van dreamteamer/promoteamer ophalen
		global $wpdb;
		$mailID = $_GET['mailID'];
		$mailDetails = $wpdb->get_row("SELECT * FROM Maillijst WHERE ID = $mailID" );
		$vandaag = date('Ymd');
		$activiteiten3 = $wpdb->get_results( "SELECT * FROM Activiteiten WHERE Datum >= '".$vandaag."' ORDER BY Datum ASC" );
		$zonder = "zonder";
		
		if(!empty($_GET['add'])){ ?>
		<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
			E-mail met succes aangemaakt!
		</div>
		<?php }
		
		
		//mail versturen
			if(isset($_GET['send']) && !isset($_GET['reminder'])){
				$ListID = $_GET['send'];
				$ActID = $mailDetails->ActID;
				$sendDate = $wpdb->get_row( "SELECT * FROM Maillijst WHERE ID = '".$ListID."'" );
				$toDay = date('Ymd');
				$mail = "";
				if($sendDate->Verzonden != '1' ){
					if($mailDetails->ActID != $zonder){ 
					verzendMailNieuw($ListID,$ActID,$mail);
					}else{
					verzendMailNieuw2($ListID,$ActID,$mail);
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
				$sendDate = $wpdb->get_row( "SELECT * FROM Maillijst WHERE ID = '".$ListID."'" );
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
				
					if(empty($_POST['activiteit'])){
						$error .= "<li>Je bent vergeten een activiteit te kiezen!</li>";
					}
					
					
					if(empty($_POST['opleiding'])){
						$error .= "<li>Je bent vergeten een opleiding te kiezen!</li>";
					}
					
					if(empty($_POST['studiejaar'])){
						$error .= "<li>Je bent vergeten een studiejaar te kiezen!</li>";
					}
					
					if(empty($_POST['vooropleiding'])){
						$error .= "<li>Je bent vergeten een vooropleiding te kiezen!</li>";
					}
					
					
					
					if(empty($error)){
					//als er geen fouten zijn dan gaan we de gegevens in de database zetten
					$opleiding = implode(",", $_POST['opleiding']);
					$studiejaar = implode(",", $_POST['studiejaar']);
					$vooropleiding = implode(",", $_POST['vooropleiding']);
					$activiteiten = implode(",", $_POST['activiteit']);
					
					$wpdb->update( Maillijst, array( 'Naam' => $_POST['naam'], 'ActID' => $activiteiten, 'Geslacht' => $_POST['geslacht'], 'Opleiding' => $opleiding, 'Studiejaar' => $studiejaar, 'Vooropleiding' => $vooropleiding, 'Rijbewijs' => $_POST['rijbewijs'], 'Rondleiding' => $_POST['rondleiding'], 'Workshop' => $_POST['workshop'], 'ID' => $mailID, 'comment' => $_POST['comments']),array( 'ID' => $mailID) );
					
					//$wpdb->update( Maillijst, array( 'Max_deelnemers' => '0'),array( 'ID' => $_GET['id']) ); 
					
					?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						E-mail met succes gewijzigd!
					</div>
					<?php
				
					}
				}
				
	
	$mailDetails = $wpdb->get_row("SELECT * FROM Maillijst WHERE ID = $mailID" );
	$activiteiten = explode(",",$mailDetails->ActID);
		$opleidingen =  explode(",",$mailDetails->Opleiding);
		$studiejaren =  explode(",",$mailDetails->Studiejaar);
		$vooropleidingen =  explode(",",$mailDetails->Vooropleiding);
	
	?>
	<div style="clear: both;"></div>
	<div id="contentLinks">
		<div class="contentHeader6">
			<h1>Gegevens E-mail</h1>
			<div class="edit"><?php if(!isset($_GET['edit'])){ ?><a href="/drpr/mailing-detail/?mailID=<?php echo $mailID; ?>&edit=1"><img src="<?php bloginfo('template_url'); ?>/images/edit.png" alt="" title="bewerk e-mail"></a><?php } ?><a href="/drpr/dreamteamers-promoteamers/?delete=yes&id=<?php echo $studentDetails->ID; ?>" ><img src="<?php bloginfo('template_url'); ?>/images/iconDelete.png" alt="" title="Verwijder persoon" onclick="return confirm('Weet je zeker dat je deze persoon wilt verwijderen?')"/></a>  </div>
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
					
					
					<form action="https://www.expect-webmedia.nl/drpr/mailing-detail/?mailID=<?php echo $mailID; ?> " method="post" name="instellingen">
					Onderwerp E-mail<br />
					<input type="text" name="naam" value="<?php if(!isset($_POST['naam'])){ echo $mailDetails->Naam; }else{ echo $_POST['naam'];} ?>" /><br /><br />
					Voor welke activiteit(en) is deze E-mail<br />
					<?php 
						$vandaag = date('Ymd');
						$activiteiten2 = $wpdb->get_results( "SELECT * FROM Activiteiten WHERE Datum >= '".$vandaag."' ORDER BY Datum ASC" );
						$zonder = "zonder";
					?>
					<table border="0" cellpadding="0" cellspacing="5">
					<tr>
						<td valign="top"><input type="checkbox" class="check" name="activiteit[]" id="zonder" value="zonder" <?php if( $mailDetails->ActID == $zonder ){ ?>checked<?php } ?>><label for="zonder"><b>Een e-mail versturen zonder activiteit</b></label>	
						</td>
					</tr>
					<tr>
						<td valign="top"><h2>Activiteiten</h2></td>
					</tr>
					<?php 
						foreach($activiteiten2 as $activiteit){ ?>
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="activiteit[]" id="<?php echo $activiteit->ID; ?>" value="<?php echo $activiteit->ID; ?>" <?php if(empty($_POST['activiteit']) &&  in_array( $activiteit->ID, $activiteiten)){ ?>checked<?php } ?>><label for="<?php echo $activiteit->ID; ?>"><?php echo $activiteit->Titel; ?></label></td>	
						</tr>
						<?php }?>
					</table>
					<h2>Selecteer de criteria waaraan de studenten moeten voldoen</h2> 
					Geslacht *<br />
					<select name="geslacht">
						<option value="nvt" <?php if($mailDetails->Geslacht == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="mannelijk" <?php if($mailDetails->Geslacht == "mannelijk"){ ?>selected="selected"<?php } ?>>Mannelijk</option>
						<option value="vrouwelijk" <?php if($mailDetails->Geslacht == "vrouwelijk"){ ?>selected="selected"<?php } ?>>Vrouwelijk</option>
					</select><br /><br />
					Opleiding*<br />
					<table border="0" cellpadding="0" cellspacing="5">
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="nvt" value="nvt" <?php if(in_array( "nvt", $opleidingen)){ ?>checked<?php } ?>><label for="nvt">Alle opleidingen</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Accountancy" value="Accountancy" <?php if(in_array( "Accountancy", $opleidingen)){ ?>checked<?php } ?>><label for="Accountancy">Accountancy</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bedrijfseconomie" value="Bedrijfseconomie" <?php if(in_array( "Bedrijfseconomie", $opleidingen)){ ?>checked<?php } ?>><label for="Bedrijfseconomie">Bedrijfseconomie</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bedrijfseconomie (AD)" value="Bedrijfseconomie (AD)" <?php if(in_array( "Bedrijfseconomie (AD)", $opleidingen)){ ?>checked<?php } ?>><label for="Bedrijfseconomie (AD)">Bedrijfseconomie (AD)</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bedrijfskunde-MER" value="Bedrijfskunde-MER" <?php if(in_array( "Bedrijfskunde-MER", $opleidingen)){ ?>checked<?php } ?>><label for="Bedrijfskunde-MER">Bedrijfskunde-MER</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bedrijfswiskunde" value="Bedrijfswiskunde" <?php if(in_array( "Bedrijfswiskunde", $opleidingen)){ ?>checked<?php } ?>><label for="Bedrijfswiskunde">Bedrijfswiskunde</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bestuurskunde" value="Bestuurskunde" <?php if(in_array( "Bestuurskunde", $opleidingen)){ ?>checked<?php } ?>><label for="Bestuurskunde">Bestuurskunde</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bouwkunde" value="Bouwkunde" <?php if(in_array( "Bouwkunde", $opleidingen)){ ?>checked<?php } ?>><label for="Bouwkunde">Bouwkunde</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Business IT en Management" value="Business IT en Management" <?php if(in_array( "Business IT en Management", $opleidingen)){ ?>checked<?php } ?>><label for="Business IT en Management">Business IT &amp; Management</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Civiele Techniek" value="Civiele Techniek" <?php if(in_array( "Civiele Techniek", $opleidingen)){ ?>checked<?php } ?>><label for="Civiele Techniek">Civiele Techniek</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Commerciele Economie" value="Commerciele Economie" <?php if(in_array( "Commerciele Economie", $opleidingen)){ ?>checked<?php } ?>><label for="Commerciele Economie">Commerciële Economie</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Communicatie" value="Communicatie" <?php if(in_array( "Communicatie", $opleidingen)){ ?>checked<?php } ?>><label for="Communicatie">Communicatie</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Communications en Multimedia Design" value="Communications en Multimedia Design" <?php if(in_array( "Communications en Multimedia Design", $opleidingen)){ ?>checked<?php } ?>><label for="Communications en Multimedia Design">Communications &amp; Multimedia Design</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Culturele en Maatschappelijke Vorming" value="Culturele en Maatschappelijke Vorming" <?php if(in_array( "Culturele en Maatschappelijke Vorming", $opleidingen)){ ?>checked<?php } ?>><label for="Culturele en Maatschappelijke Vorming">Culturele en Maatschappelijke Vorming</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Docent Beeldende Kunst en Vormgeving" value="Docent Beeldende Kunst en Vormgeving" <?php if(in_array( "Docent Beeldende Kunst en Vormgeving", $opleidingen)){ ?>checked<?php } ?>><label for="Docent Beeldende Kunst en Vormgeving">Docent Beeldende Kunst en Vormgeving</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Docent Theater" value="Docent Theater" <?php if(in_array( "Docent Theater", $opleidingen)){ ?>checked<?php } ?>><label for="Docent Theater">Docent Theater</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Elektrotechniek" value="Elektrotechniek" <?php if(in_array( "Elektrotechniek", $opleidingen)){ ?>checked<?php } ?>><label for="Elektrotechniek">Elektrotechniek</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="European Studies"" value="European Studies" <?php if(in_array( "European Studies", $opleidingen)){ ?>checked<?php } ?>><label for="European Studies">European Studies</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Financial Services Management" value="Financial Services Management" <?php if(in_array( "Financial Services Management", $opleidingen)){ ?>checked<?php } ?>><label for="Financial Services Management">Financial Services Management</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="HBO-Rechten"" value="HBO-Rechten" <?php if(in_array( "HBO-Rechten", $opleidingen)){ ?>checked<?php } ?>><label for="HBO-Rechten">HBO-Rechten</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Human Resource Managament (AD)" value="Human Resource Managament (AD)" <?php if(in_array( "Human Resource Managament (AD)", $opleidingen)){ ?>checked<?php } ?>><label for="Human Resource Managament (AD)">Human Resource Managament (AD)</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Human Resource Management" value="Human Resource Management" <?php if(in_array( "Human Resource Management", $opleidingen)){ ?>checked<?php } ?>><label for="Human Resource Management">Human Resource Management</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="International Business en Languages" value="International Business en Languages" <?php if(in_array( "International Business en Languages", $opleidingen)){ ?>checked<?php } ?>><label for="International Business en Languages">International Business &amp; Languages</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Informatica"  value="Informatica" <?php if(in_array( "Informatica", $opleidingen)){ ?>checked<?php } ?>><label for="Informatica">Informatica</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Integrale veiligheid" value="Integrale veiligheid" <?php if(in_array( "Integrale veiligheid", $opleidingen)){ ?>checked<?php } ?>><label for="Integrale veiligheid">Integrale veiligheid</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="IT service Management (AD)" value="IT service Management (AD)" <?php if(in_array( "IT service Management (AD)", $opleidingen)){ ?>checked<?php } ?>><label for="IT service Management (AD)">IT service Management (AD)</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Aardrijkskunde"" value="Leraar Aardrijkskunde" <?php if(in_array( "Leraar Aardrijkskunde", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Aardrijkskunde">Leraar Aardrijkskunde</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Algemene/Bedrijfseconomie" value="Leraar Algemene/Bedrijfseconomie" <?php if(in_array( "Leraar Algemene/Bedrijfseconomie", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Algemene/Bedrijfseconomie">Leraar Algemene/Bedrijfseconomie</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Basisonderwijs" value="Leraar Basisonderwijs" <?php if(in_array( "Leraar Basisonderwijs", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Basisonderwijs">Leraar Basisonderwijs</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Duits" value="Leraar Duits" <?php if(in_array( "Leraar Duits", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Duits">Leraar Duits</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Engels"" value="Leraar Engels" <?php if(in_array( "Leraar Engels", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Engels">Leraar Engels</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Exacte Vakken" value="Leraar Exacte Vakken" <?php if(in_array( "Leraar Exacte Vakken", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Exacte Vakken">Leraar Exacte Vakken</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Frans" value="Leraar Frans" <?php if(in_array( "Leraar Frans", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Frans">Leraar Frans</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Fries" value="Leraar Fries" <?php if(in_array( "Leraar Fries", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Fries">Leraar Fries</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Geschiedenis" value="Leraar Geschiedenis" <?php if(in_array( "Leraar Geschiedenis", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Geschiedenis">Leraar Geschiedenis</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Gezondheidszorg en Welzijn" value="Leraar Gezondheidszorg en Welzijn" <?php if(in_array( "Leraar Gezondheidszorg en Welzijn", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Gezondheidszorg en Welzijn">Leraar Gezondheidszorg &amp; Welzijn</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Maatschappijleer" value="Leraar Maatschappijleer" <?php if(in_array( "Leraar Maatschappijleer", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Maatschappijleer">Leraar Maatschappijleer</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Nederlands"" value="Leraar Nederlands" <?php if(in_array( "Leraar Nederlands", $opleidingen)){ ?>checked<?php } ?>><label for="Leraar Nederlands">Leraar Nederlands</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Maatschappelijk Werk en Dienstverlening" value="Maatschappelijk Werk en Dienstverlening" <?php if(in_array( "Maatschappelijk Werk en Dienstverlening", $opleidingen)){ ?>checked<?php } ?>><label for="Maatschappelijk Werk en Dienstverlening">Maatschappelijk Werk en Dienstverlening</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Maritiem Officier/Ocean Technology"" value="Maritiem Officier/Ocean Technology" <?php if(in_array( "1", $opleidingen)){ ?>checked<?php } ?>><label for="Maritiem Officier/Ocean Technology">Maritiem Officier/Ocean Technology</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Mobiliteit" value="Mobiliteit" <?php if(in_array( "Mobiliteit", $opleidingen)){ ?>checked<?php } ?>><label for="Mobiliteit">Mobiliteit</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Pedagogiek" value="Pedagogiek" <?php if(in_array( "Pedagogiek", $opleidingen)){ ?>checked<?php } ?>><label for="Pedagogiek">Pedagogiek</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Scheepsbouwkunde (AD)" value="Scheepsbouwkunde (AD)" <?php if(in_array( "Scheepsbouwkunde (AD)", $opleidingen)){ ?>checked<?php } ?>><label for="Scheepsbouwkunde (AD)">Scheepsbouwkunde (AD)</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Scheepsbouwkunde (MT)" value="Scheepsbouwkunde (MT)" <?php if(in_array( "Scheepsbouwkunde (MT)", $opleidingen)){ ?>checked<?php } ?>><label for="Scheepsbouwkunde (MT)">Scheepsbouwkunde (MT)</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]"  value="Technische Bedrijfskunde" id="Technische Bedrijfskunde" <?php if(in_array( "Technische Bedrijfskunde", $opleidingen)){ ?>checked<?php } ?>><label for="Technische Bedrijfskunde">Technische Bedrijfskunde</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Verpleegkunde"  value="Verpleegkunde"<?php if(in_array( "Verpleegkunde", $opleidingen)){ ?>checked<?php } ?>><label for="Verpleegkunde">Verpleegkunde</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Werktuigbouwkunde" value="Werktuigbouwkunde" <?php if(in_array( "Werktuigbouwkunde", $opleidingen)){ ?>checked<?php } ?>><label for="Werktuigbouwkunde">Werktuigbouwkunde</label></td>	
						<td></label></td>			
						</tr>			
						</table>		
						<br />
					Studiejaar*<br />
					<table border="0" cellpadding="0" cellspacing="5">
					<tr>
						<td valign="top" width="180"><input type="checkbox" class="check" name="studiejaar[]" id="nvt2" value="nvt" <?php if(in_array( "nvt", $studiejaren)){ ?>checked<?php } ?>><label for="nvt2">Alle Studiejaren</label></td>
						<td valign="top"></td>
					</tr>
					<tr>
						<td valign="top"><input type="checkbox" class="check" name="studiejaar[]" id="1" value="1" <?php if(in_array( "1", $studiejaren)){ ?>checked<?php } ?>><label for="1">1ste studiejaar</label></td>
						<td valign="top"><input type="checkbox" class="check" name="studiejaar[]" id="2" value="2" <?php if(in_array( "2", $studiejaren)){ ?>checked<?php } ?>><label for="2">2de studiejaar</label></td>
					</tr>
					<tr>
						<td valign="top"><input type="checkbox" class="check" name="studiejaar[]" id="3" value="3" <?php if(in_array( "3", $studiejaren)){ ?>checked<?php } ?>><label for="3">3de studiejaar</label></td>
						<td valign="top"><input type="checkbox" class="check" name="studiejaar[]" id="4" value="4" <?php if(in_array( "4", $studiejaren)){ ?>checked<?php } ?>><label for="4">4de studiejaar</label></td>
					</tr>
					</table>
					Vooropleiding*<br />
					<table border="0" cellpadding="0" cellspacing="5">
					<tr>
						<td valign="top" width="180"><input type="checkbox" class="check" name="vooropleiding[]" id="nvt3" value="nvt" <?php if(in_array( "nvt", $vooropleidingen)){ ?>checked<?php } ?>><label for="nvt3">Alle Vooropleidingen</label></td>
						<td valign="top"></td>
					</tr>
					<tr>
						<td valign="top" width="180"><input type="checkbox" class="check" name="vooropleiding[]" id="havo" value="havo" <?php if(in_array( "havo", $vooropleidingen)){ ?>checked<?php } ?>><label for="havo">HAVO</label></td>
						<td valign="top"><input type="checkbox" class="check" name="vooropleiding[]" id="vwo" value="vwo" <?php if(in_array( "vwo", $vooropleidingen)){ ?>checked<?php } ?>><label for="vwo">VWO</label></td>
					</tr>
					<tr>
						<td valign="top" width="180"><input type="checkbox" class="check" name="vooropleiding[]" id="mbo" value="mbo" <?php if(in_array( "mbo", $vooropleidingen)){ ?>checked<?php } ?>><label for="mbo">mbo</label></td>
						<td valign="top"><input type="checkbox" class="check" name="vooropleiding[]" id="hbo" value="hbo" <?php if(in_array( "hbo", $vooropleidingen)){ ?>checked<?php } ?>><label for="hbo">hbo</label></td>
					</tr>
					</table>
					
					
					Heeft Rijbewijs*<br />
					<select name="rijbewijs">
						<option value="nvt" <?php if($mailDetails->Rijbewijs == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if($mailDetails->Rijbewijs == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if($mailDetails->Rijbewijs == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select><br /><br />
					Kan rondleiding geven*<br />
					<select name="rondleiding">
						<option value="nvt" <?php if($mailDetails->Rondleiding == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if($mailDetails->Rondleiding == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if($mailDetails->Rondleiding == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select><br /><br />
					Kan Talentworkshop geven*<br />
					<select name="workshop">
						<option value="nvt" <?php if($mailDetails->Workshop == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if($mailDetails->Workshop == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if($mailDetails->Workshop == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select><br /><br />
					Aanvullende tekst (wordt in e-mail getoond)<br />
					<textarea name="comments"><?php echo $mailDetails->comment; ?></textarea>
					<br /><br />
					<a href="/drpr/mailing-detail/?mailID=<?php echo $mailID; ?>">Annuleren</a><input type="submit" value="E-mail bijwerken" name="maillijst" id="submit">
				</form>
					
					
					
					<br /><br /></div>

			<?php }else { ?>
			
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="130">Onderwerp E-mail</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $mailDetails->Naam; ?></td>
				</tr>
				<tr>
					<td valign="top">Activiteit(en)</td>
					<td valign="top">:</td>
					<td valign="top">
						<ul style="list-style-type: square; margin: 0px; padding-left: 15px;">
					<?php  
					
						$activiteiten2 = $wpdb->get_results( "SELECT * FROM Activiteiten WHERE Datum >= '".$vandaag."' ORDER BY Datum ASC" );
						$zonder = "zonder";
						if($mailDetails->ActID != $zonder){
						foreach($activiteiten as $activiteit){ 
							$ActName = substr(get_activiteitNaam($activiteit), 0, 50);
						?>
							<li><a href="/drpr/activiteit-detail/?id=<?php echo $activiteit; ?>" target="_self"><?php echo $ActName; ?></a></li>
						<?php } }else{ ?>
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
					<td valign="top" width="130">Aantal ontvangers</td>
					<td valign="top">:</td>
					<td valign="top"><?php aantalOntvangersNieuw($mailID); ?></td>
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
			<br /><h2>Selectiecriteria voor de studenten</h2>
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" width="130">Geslacht</td>
					<td valign="top">:</td>
					<td valign="top"><?php geslacht2($mailDetails->Geslacht); ?></td>
				</tr>
				<tr>
					<td valign="top" width="130">Opleidingen</td>
					<td valign="top">:</td>
					<td valign="top">
					<ul style="list-style-type: square; margin: 0px; padding-left: 15px;">
					<?php  
						foreach($opleidingen as $opleiding){ 
						 if($opleiding == 'nvt'){
							echo "<li>Onbelangrijk</li>";
						 }else{ ?>
							<li><?php echo $opleiding; ?></li>
						<?php } }
					?>		
						</ul>
					</td>
				</tr>
				<tr>
					<td valign="top" width="130">Studiejaar</td>
					<td valign="top">:</td>
					<td valign="top">
					<ul style="list-style-type: square; margin: 0px; padding-left: 15px;">
					<?php  
						foreach($studiejaren as $studiejaar){ 
							if($studiejaar != 'nvt'){?>
							<li><?php if($studiejaar == '1'){ echo $studiejaar."ste studiejaar"; }else{ echo $studiejaar."de studiejaar";} ?></li>
							<? }else{
								echo "<li>Alle studiejaren</li>";
							}
					}
					?>		
						</ul>
					</td>
				</tr>
				<tr>
					<td valign="top" width="130">Vooropleiding</td>
					<td valign="top">:</td>
					<td valign="top">
					<ul style="list-style-type: square; margin: 0px; padding-left: 15px;">
					<?php  
						foreach($vooropleidingen as $vooropleiding){ 
						 if($vooropleiding == 'nvt'){
							echo "<li>Onbelangrijk</li>";
						 }else{ ?>
							<li><?php echo $vooropleiding; ?></li>
						<?php } }
					?>		
						</ul>
					</td>
				</tr>
				<tr>
					<td valign="top" width="130">Rijbewijs</td>
					<td valign="top">:</td>
					<td valign="top"><?php if($mailDetails->Rijbewijs == 'nvt'){echo "Onbelangrijk";}else{ echo $mailDetails->Rijbewijs;} ?></td>
				</tr>
				<tr>
					<td valign="top" width="130">Rondleiding</td>
					<td valign="top">:</td>
					<td valign="top"><?php if($mailDetails->Rondleiding == 'nvt'){echo "Onbelangrijk";}else{ echo $mailDetails->Rondleiding;} ?></td>
				</tr>
				<tr>
					<td valign="top" width="130">Talentworkshop</td>
					<td valign="top">:</td>
					<td valign="top"><?php if($mailDetails->Workshop == 'nvt'){echo "Onbelangrijk";}else{ echo $mailDetails->Workshop;} ?></td>
				</tr>
			</table>
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
			<div class="buttonNew" onclick="location.href='/drpr/mailing-detail/?mailID=<?php echo $mailID; ?>&send=<?php echo $mailID; ?>';">
				Verstuur E-mail
			</div>
			<?php 
			$toDay = date('Ymd');
			$reminderCheck = $wpdb->get_var( "SELECT * FROM Reminders WHERE mailID = '".$mailID."' AND reminderDate  = '".$toDay."'" );
			if(!empty($reminderCheck) || empty($mailDetails->SendDate) || $mailDetails->SendDate == $toDay){ ?>
			<div class="coverButtonNew2"></div><?php } ?>
			<div class="button2New" onclick="location.href='/drpr/mailing-detail/?mailID=<?php echo $mailID; ?>&reminder=<?php echo $mailID; ?>';">
				Verstuur Reminder
			</div>
			
			<div class="button3New"  onclick="window.open('http://www.expect-webmedia.nl/drpr/preview-email/?mailid=<?php echo $mailID; ?>')">
				 Preview E-mail
			</div>
		</div>
		<br /><br />
		<div class="contentHeaderMail" style="margin-top: 15px;">
			<h1>E-mailontvangers</h1>
		</div>
		<div class="contentContent">
			<table border="0" cellpadding="0" cellspacing="0">
				<?php 
					$ActID = $mailDetails->ActID;
					$email = "";
					mailOntvangers($mailID,$ActID,$email);
				?>
			</table>
		</div>
	</div>
<?php get_footer(); ?>