<?php 
/*
Template Name:Mailingen en Maillijsten
*/
get_header();  get_header();

				//connect to the database
				global $wpdb;
				
				//haal gegevens van de huidige gebruiker open
				$current_user = wp_get_current_user();				
				
				
				//Maillijst formulier wordt verstuurd, we gaan kijken of er ook fouten zijn gemaakt.
				if($_POST['maillijst']){
				
					if(empty($_POST['naam'])){
						$error .= "<li>Je bent vergeten een naam te kiezen!</li>";
					}
				
					if($_POST['geslacht'] == 'keuze'){
						$error .= "<li>Je bent vergeten een geslacht te kiezen!</li>";
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
					
					if($_POST['rijbewijs'] == 'keuze'){
						$error .= "<li>Je bent vergeten aan te geven of een rijbewijs belangrijk is</li>";
					}
					
					if($_POST['workshop'] == 'keuze'){
						$error .= "<li>Je bent vergeten aan te geven of het kunnen geven van een workshop belangrijk is</li>";
					}
					
					if($_POST['rondleiding'] == 'keuze'){
						$error .= "<li>Je bent vergeten aan te geven of het kunnen geven van een rondleiding belangrijk is</li>";
					}
					
					$test = implode(",", $_POST['studiejaar']);
					
					if(empty($error)){
					//als er geen fouten zijn dan gaan we de gegevens in de database zetten
					$opleiding = implode(",", $_POST['opleiding']);
					$studiejaar = implode(",", $_POST['studiejaar']);
					$vooropleiding = implode(",", $_POST['vooropleiding']);
					
					$wpdb->insert( Maillijst, array( 'Naam' => $_POST['naam'], 'ActID' => $_POST['activiteit'], 'Geslacht' => $_POST['geslacht'], 'Opleiding' => $opleiding, 'Studiejaar' => $studiejaar, 'Vooropleiding' => $vooropleiding, 'Rijbewijs' => $_POST['rijbewijs'], 'Rondleiding' => $_POST['rondleiding'], 'Workshop' => $_POST['workshop']) );
					
					?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						E-mail"<?php echo  $_POST['naam']; ?>"  met succes aangemaakt!
					</div>
					<?php
				
					}
				}
				
				if(!empty($_GET['delml']) && !$_POST['maillijst']){
					$wpdb->query( " DELETE FROM Maillijst WHERE ID = ".$_GET['delml']." "  );
					?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						E-mail met succes verwijderd!
					</div>
					<?php
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
					Voor welke activiteit is deze E-mail<br />
					<?php 
						$vandaag = date('Ymd');
						$activiteiten = $wpdb->get_results( "SELECT * FROM Activiteiten WHERE Datum >= '".$vandaag."' ORDER BY Datum ASC" );
					?>
					<select name="activiteit">
						<option value="keuze" <?php if(!empty($error) && $_POST['activiteit'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					<?php 
						foreach($activiteiten as $activiteit){ ?>
							<option value="<?php echo $activiteit->ID; ?>" <?php if(!empty($error) && $_POST['activiteit'] == $activiteit->ID){ ?>selected="selected"<?php } ?>><?php echo $activiteit->Titel; ?></option>
						<?php }
						echo $_POST['activiteit'];
					?>
					</select>
					<h2>Selecteer de criteria waaraan de studenten moeten voldoen</h2> 
					Geslacht *<br />
					<select name="geslacht">
						<option value="keuze" <?php if(!empty($error) && $_POST['geslacht'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="nvt" <?php if(!empty($error) && $_POST['geslacht'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="mannelijk" <?php if(!empty($error) && $_POST['geslacht'] == "mannelijk"){ ?>selected="selected"<?php } ?>>Mannelijk</option>
						<option value="vrouwelijk" <?php if(!empty($error) && $_POST['geslacht'] == "vrouwelijk"){ ?>selected="selected"<?php } ?>>Vrouwelijk</option>
					</select><br /><br />
					Opleiding*<br />
					<table border="0" cellpadding="0" cellspacing="5">
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="nvt" value="nvt" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "nvt", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="nvt">Alle opleidingen</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Accountancy" value="Accountancy" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Accountancy", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Accountancy">Accountancy</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bedrijfseconomie" value="Bedrijfseconomie" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Bedrijfseconomie", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Bedrijfseconomie">Bedrijfseconomie</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bedrijfseconomie (AD)" value="Bedrijfseconomie (AD)" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Bedrijfseconomie (AD)", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Bedrijfseconomie (AD)">Bedrijfseconomie (AD)</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bedrijfskunde-MER" value="Bedrijfskunde-MER" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Bedrijfskunde-MER", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Bedrijfskunde-MER">Bedrijfskunde-MER</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bedrijfswiskunde" value="Bedrijfswiskunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Bedrijfswiskunde", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Bedrijfswiskunde">Bedrijfswiskunde</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bestuurskunde" value="Bestuurskunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Bestuurskunde", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Bestuurskunde">Bestuurskunde</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bouwkunde" value="Bouwkunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Bouwkunde", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Bouwkunde">Bouwkunde</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Business IT en Management" value="Business IT en Management" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Business IT en Management", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Business IT en Management">Business IT &amp; Management</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Civiele Techniek" value="Civiele Techniek" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Civiele Techniek", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Civiele Techniek">Civiele Techniek</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Commerciele Economie" value="Commerciele Economie" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Commerciele Economie", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Commerciele Economie">Commerciële Economie</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Communicatie" value="Communicatie" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Communicatie", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Communicatie">Communicatie</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Communications en Multimedia Design" value="Communications en Multimedia Design" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Communications en Multimedia Design", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Communications en Multimedia Design">Communications &amp; Multimedia Design</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Culturele en Maatschappelijke Vorming" value="Culturele en Maatschappelijke Vorming" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Culturele en Maatschappelijke Vorming", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Culturele en Maatschappelijke Vorming">Culturele en Maatschappelijke Vorming</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Docent Beeldende Kunst en Vormgeving" value="Docent Beeldende Kunst en Vormgeving" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Docent Beeldende Kunst en Vormgeving", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Docent Beeldende Kunst en Vormgeving">Docent Beeldende Kunst en Vormgeving</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Docent Theater" value="Docent Theater" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Docent Theater", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Docent Theater">Docent Theater</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Elektrotechniek" value="Elektrotechniek" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Elektrotechniek", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Elektrotechniek">Elektrotechniek</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="European Studies"" value="European Studies" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "European Studies", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="European Studies">European Studies</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Financial Services Management" value="Financial Services Management" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Financial Services Management", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Financial Services Management">Financial Services Management</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="HBO-Rechten"" value="HBO-Rechten" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "HBO-Rechten", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="HBO-Rechten">HBO-Rechten</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Human Resource Managament (AD)" value="Human Resource Managament (AD)" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Human Resource Managament (AD)", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Human Resource Managament (AD)">Human Resource Managament (AD)</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Human Resource Management" value="Human Resource Management" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Human Resource Management", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Human Resource Management">Human Resource Management</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="International Business en Languages" value="International Business en Languages" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "International Business en Languages", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="International Business en Languages">International Business &amp; Languages</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Informatica"  value="Informatica" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Informatica", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Informatica">Informatica</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Integrale veiligheid" value="Integrale veiligheid" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Integrale veiligheid", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Integrale veiligheid">Integrale veiligheid</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="IT service Management (AD)" value="IT service Management (AD)" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "IT service Management (AD)", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="IT service Management (AD)">IT service Management (AD)</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Aardrijkskunde"" value="Leraar Aardrijkskunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Aardrijkskunde", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Aardrijkskunde">Leraar Aardrijkskunde</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Algemene/Bedrijfseconomie" value="Leraar Algemene/Bedrijfseconomie" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Algemene/Bedrijfseconomie", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Algemene/Bedrijfseconomie">Leraar Algemene/Bedrijfseconomie</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Basisonderwijs" value="Leraar Basisonderwijs" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Basisonderwijs", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Basisonderwijs">Leraar Basisonderwijs</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Duits" value="Leraar Duits" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Duits", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Duits">Leraar Duits</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Engels"" value="Leraar Engels" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Engels", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Engels">Leraar Engels</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Exacte Vakken" value="Leraar Exacte Vakken" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Exacte Vakken", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Exacte Vakken">Leraar Exacte Vakken</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Frans" value="Leraar Frans" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Frans", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Frans">Leraar Frans</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Fries" value="Leraar Fries" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Fries", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Fries">Leraar Fries</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Geschiedenis" value="Leraar Geschiedenis" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Geschiedenis", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Geschiedenis">Leraar Geschiedenis</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Gezondheidszorg en Welzijn" value="Leraar Gezondheidszorg en Welzijn" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Gezondheidszorg en Welzijn", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Gezondheidszorg en Welzijn">Leraar Gezondheidszorg &amp; Welzijn</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Maatschappijleer" value="Leraar Maatschappijleer" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Maatschappijleer", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Maatschappijleer">Leraar Maatschappijleer</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Nederlands"" value="Leraar Nederlands" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Nederlands", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Nederlands">Leraar Nederlands</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Maatschappelijk Werk en Dienstverlening" value="Maatschappelijk Werk en Dienstverlening" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Maatschappelijk Werk en Dienstverlening", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Maatschappelijk Werk en Dienstverlening">Maatschappelijk Werk en Dienstverlening</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Maritiem Officier/Ocean Technology"" value="Maritiem Officier/Ocean Technology" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "1", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Maritiem Officier/Ocean Technology">Maritiem Officier/Ocean Technology</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Mobiliteit" value="Mobiliteit" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Mobiliteit", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Mobiliteit">Mobiliteit</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Pedagogiek" value="Pedagogiek" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Pedagogiek", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Pedagogiek">Pedagogiek</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Scheepsbouwkunde (AD)" value="Scheepsbouwkunde (AD)" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Scheepsbouwkunde (AD)", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Scheepsbouwkunde (AD)">Scheepsbouwkunde (AD)</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Scheepsbouwkunde (MT)" value="Scheepsbouwkunde (MT)" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Scheepsbouwkunde (MT)", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Scheepsbouwkunde (MT)">Scheepsbouwkunde (MT)</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]"  value="Technische Bedrijfskunde" id="Technische Bedrijfskunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Technische Bedrijfskunde", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Technische Bedrijfskunde">Technische Bedrijfskunde</label></td>	
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Verpleegkunde"  value="Verpleegkunde"<?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Verpleegkunde", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Verpleegkunde">Verpleegkunde</label></td>	
						</tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Werktuigbouwkunde" value="Werktuigbouwkunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Werktuigbouwkunde", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Werktuigbouwkunde">Werktuigbouwkunde</label></td>	
						<td></label></td>			
						</tr>			
						</table>		
						<br />
					Studiejaar*<br />
					<table border="0" cellpadding="0" cellspacing="5">
					<tr>
						<td valign="top" width="180"><input type="checkbox" class="check" name="studiejaar[]" id="nvt2" value="nvt" <?php if(!empty($_POST['studiejaar']) && !empty($error) &&  in_array( "nvt", $_POST['studiejaar'])){ ?>checked<?php } ?>><label for="nvt2">Alle Studiejaren</label></td>
						<td valign="top"></td>
					</tr>
					<tr>
						<td valign="top"><input type="checkbox" class="check" name="studiejaar[]" id="1" value="1" <?php if(!empty($_POST['studiejaar']) && !empty($error) &&  in_array( "1", $_POST['studiejaar'])){ ?>checked<?php } ?>><label for="1">1ste studiejaar</label></td>
						<td valign="top"><input type="checkbox" class="check" name="studiejaar[]" id="2" value="2" <?php if(!empty($_POST['studiejaar']) && !empty($error) &&  in_array( "2", $_POST['studiejaar'])){ ?>checked<?php } ?>><label for="2">2de studiejaar</label></td>
					</tr>
					<tr>
						<td valign="top"><input type="checkbox" class="check" name="studiejaar[]" id="3" value="3" <?php if(!empty($_POST['studiejaar']) && !empty($error) &&  in_array( "3", $_POST['studiejaar'])){ ?>checked<?php } ?>><label for="3">3de studiejaar</label></td>
						<td valign="top"><input type="checkbox" class="check" name="studiejaar[]" id="4" value="4" <?php if(!empty($_POST['studiejaar']) && !empty($error) &&  in_array( "4", $_POST['studiejaar'])){ ?>checked<?php } ?>><label for="4">4de studiejaar</label></td>
					</tr>
					</table>
					Vooropleiding*<br />
					<table border="0" cellpadding="0" cellspacing="5">
					<tr>
						<td valign="top" width="180"><input type="checkbox" class="check" name="vooropleiding[]" id="nvt3" value="nvt" <?php if(!empty($_POST['vooropleiding']) && !empty($error) &&  in_array( "nvt", $_POST['vooropleiding'])){ ?>checked<?php } ?>><label for="nvt3">Alle Vooropleidingen</label></td>
						<td valign="top"></td>
					</tr>
					<tr>
						<td valign="top" width="180"><input type="checkbox" class="check" name="vooropleiding[]" id="havo" value="havo" <?php if(!empty($_POST['vooropleiding']) && !empty($error) &&  in_array( "havo", $_POST['vooropleiding'])){ ?>checked<?php } ?>><label for="havo">HAVO</label></td>
						<td valign="top"><input type="checkbox" class="check" name="vooropleiding[]" id="vwo" value="vwo" <?php if(!empty($_POST['vooropleiding']) && !empty($error) &&  in_array( "vwo", $_POST['vooropleiding'])){ ?>checked<?php } ?>><label for="vwo">VWO</label></td>
					</tr>
					<tr>
						<td valign="top" width="180"><input type="checkbox" class="check" name="vooropleiding[]" id="mbo" value="mbo" <?php if(!empty($_POST['vooropleiding']) && !empty($error) &&  in_array( "mbo", $_POST['vooropleiding'])){ ?>checked<?php } ?>><label for="mbo">mbo</label></td>
						<td valign="top"><input type="checkbox" class="check" name="vooropleiding[]" id="hbo" value="hbo" <?php if(!empty($_POST['vooropleiding']) && !empty($error) &&  in_array( "hbo", $_POST['vooropleiding'])){ ?>checked<?php } ?>><label for="hbo">hbo</label></td>
					</tr>
					</table>
					
					
					Heeft Rijbewijs*<br />
					<select name="rijbewijs">
						<option value="keuze" <?php if(!empty($error) && $_POST['rijbewijs'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="nvt" <?php if(!empty($error) && $_POST['rijbewijs'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['rijbewijs'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['rijbewijs'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select><br /><br />
					Kan rondleiding geven*<br />
					<select name="rondleiding">
						<option value="keuze" <?php if(!empty($error) && $_POST['rondleiding'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="nvt" <?php if(!empty($error) && $_POST['rondleiding'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['rondleiding'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['rondleiding'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select><br /><br />
					Kan Talentworkshop geven*<br />
					<select name="workshop">
						<option value="keuze" <?php if(!empty($error) && $_POST['workshop'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
						<option value="nvt" <?php if(!empty($error) && $_POST['workshop'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['workshop'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['workshop'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select><br /><br />
					<input type="submit" value="E-mail aanmaken" name="maillijst" id="submit">
				</form>
		</div>
	</div>

	<div id="contentRechts">
		<div class="contentHeader6">
			<h1>E-mails</h1>
		</div>
		<div class="contentContent">
		<table border="0" cellpadding="5" cellspacing="3">
				<?php 
				global $wpdb;
				$maillijsten = $wpdb->get_results( "SELECT * FROM Maillijst ORDER BY ID DESC");
				foreach( $maillijsten as $maillijst ){ 
				$onderwerp = substr($maillijst->Naam, 0, 30);
				?>
							<tr >
								<td valign="top" width="250" title="Deze mailing heeft <?php aantalOntvangers($maillijst->ID); ?> ontvangers"> <B>&nbsp;&nbsp;<?php echo $onderwerp; ?> (<?php aantalOntvangers($maillijst->ID); ?>)</B></td>
								<td valign="top" width="250"><a href="http://www.expect-webmedia.nl/drpr/activiteit-detail?id=<?php echo $maillijst->ActID; ?> "><?php echo substr(get_activiteitNaam($maillijst->ActID), 0, 35); ?></a></td>
								<td valign="top"><a href="http://www.expect-webmedia.nl/drpr/maillijst/?delml=<?php echo $maillijst->ID; ?>"  onclick="return confirm('Weet je zeker dat je deze E-mail wilt verwijderen?')">X</a></td>
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