<?php  ob_start();
/*
Template Name:Mailingen en Maillijsten Nieuw TEST!
*/
get_header();  get_header();

				//connect to the database
				global $wpdb;
				
				//haal gegevens van de huidige gebruiker open
				$current_user = wp_get_current_user();		
				
				
				if(!empty($_GET['delml']) && !$_POST['maillijst']){
					$wpdb->query( " DELETE FROM Maillijst WHERE ID = ".$_GET['delml']." "  );
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
				
					if($_POST['geslacht'] == 'keuze'){
						$error .= "<li>Je bent vergeten een geslacht te kiezen!</li>";
					}
					
					if(empty($_POST['opleiding'])){
						$error .= "<li>Je bent vergeten een opleiding te kiezen!</li>";
					}
					
					if($_POST['rijbewijs'] == 'keuze'){
						$error .= "<li>Je bent vergeten aan te geven of een rijbewijs belangrijk is</li>";
					}
					
					if($_POST['workshop'] == 'keuze'){
						$error .= "<li>Je bent vergeten aan te geven of het kunnen geven van een workshop belangrijk is</li>";
					}
					
					if($_POST['onlinevraagstuk'] == 'keuze'){
						$error .= "<li>Je bent vergeten aan te geven of het kunnen helpen bij een online vraagstuk belangrijk is</li>";
					}
					
					if($_POST['webcareklus'] == 'keuze'){
						$error .= "<li>Je bent vergeten aan te geven of het kunnen helpen bij een webcare klus belangrijk is</li>";
					}
					
					if($_POST['brochureklus'] == 'keuze'){
					$error .= "<li>Je bent vergeten aan te geven of het kunnen helpen bij een brochure klus belangrijk is</li>";
					}
					
					if($_POST['invoerklus'] == 'keuze'){
					$error .= "<li>Je bent vergeten aan te geven of het kunnen helpen bij een invoer klus belangrijk is</li>";
					}
					
					if($_POST['rondleiding'] == 'keuze'){
						$error .= "<li>Je bent vergeten aan te geven of het kunnen geven van een rondleiding belangrijk is</li>";
					}
					
					//$test = implode(",", $_POST['studiejaar']);
					
					if(empty($error)){
					//als er geen fouten zijn dan gaan we de gegevens in de database zetten
					$opleiding = implode(",", $_POST['opleiding']);
					//$studiejaar = implode(",", $_POST['studiejaar']);
					//$vooropleiding = implode(",", $_POST['vooropleiding']);
					$activiteiten = implode(",", $_POST['activiteit']);
					
					$mailNaam = $_POST['naam'];
					$geslacht = $_POST['geslacht'];
					$rijbewijs = $_POST['rijbewijs'];
					$onlinevraagstuk = $_POST['onlinevraagstuk'];
					$webcareklus = $_POST['webcareklus'];
					$brochureklus = $_POST['brochureklus'];
					$invoerklus = $_POST['invoerklus'];					
					$rondleiding = $_POST['rondleiding'];
					$workshop = $_POST['workshop'];
					$comments = $_POST['comments'];
					
					
					
					$wpdb->insert( Maillijst, array( 'Naam' => $mailNaam, 'ActID' => $activiteiten, 'Geslacht' => $geslacht, 'Opleiding' => $opleiding, 'Rijbewijs' => $rijbewijs, 'Rondleiding' => $rondleiding, 'Workshop' => $workshop, 'UserID' => $current_user->ID, 'comment' => $comments, 'OnlineVraagstuk' => $onlinevraagstuk, 'WebcareKlus' => $webcareklus, 'BrochureKlus' => $brochureklus, 'InvoerKlus' => $invoerklus ) );
					
					$mailID = $wpdb->insert_id;
					
					$url = "http://www.expect-webmedia.nl/drpr/mailing-detail-test/?mailID=".$mailID;
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
					Voor welke activiteit(en) is deze E-mail<br />
					<?php 
						$vandaag = date('Ymd');
						$activiteiten = $wpdb->get_results( "SELECT * FROM Activiteiten WHERE Datum >= '".$vandaag."' ORDER BY Datum ASC" );
					?>
				<table border="0" cellpadding="0" cellspacing="5">
					<?php 
						foreach($activiteiten as $activiteit){ ?>
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="activiteit[]" id="<?php echo $activiteit->ID; ?>" value="<?php echo $activiteit->ID; ?>" <?php if(!empty($_POST['activiteit']) && !empty($error) &&  in_array( $activiteit->ID, $_POST['activiteit'])){ ?>checked<?php } ?>><label for="<?php echo $activiteit->ID; ?>"><?php echo $activiteit->Titel; ?></label></td>	
						</tr>
						<?php }
					
					?></table>
					<h2>Selecteer de criteria waaraan de studenten moeten voldoen</h2> 
					<p>Geslacht *<br />
					  <select name="geslacht">
					    <option value="keuze" <?php if(!empty($error) && $_POST['geslacht'] == "keuze"){ ?>selected="selected"<?php } ?>>- Maak een keuze -</option>
					    <option value="nvt" <?php if(!empty($error) && $_POST['geslacht'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
					    <option value="mannelijk" <?php if(!empty($error) && $_POST['geslacht'] == "mannelijk"){ ?>selected="selected"<?php } ?>>Mannelijk</option>
					    <option value="vrouwelijk" <?php if(!empty($error) && $_POST['geslacht'] == "vrouwelijk"){ ?>selected="selected"<?php } ?>>Vrouwelijk</option>
				      </select>
					  <br /><br />
                    
                    
                    <h2>Opleiding*</h2>
                    
                    
                    <div class="alleOpleidingenAan aanUit">Selecteer alle opleidingen</div>
					<div class="alleOpleidingenUit aanUit">Deselecteer alle opleidingen</div>
                    
                    
                 <!---    
           	  <table border="0" cellpadding="0" cellspacing="5">
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="nvt" value="nvt" <?php // if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "nvt", $_POST['opleiding'])){ ?>checked<?php // } ?>><label for="nvt">Alle opleidingen</label></td>	
                        </tr>
              </table>
              
              -->
              
              
                        
                        
                    
              <h2><strong>ECMA</strong></h2>
     
<div class="alleEcmaAan aanUit">Selecteer alle ECMA opleidingen</div>
<div class="alleEcmaUit aanUit">Deselecteer alle ECMA opleidingen</div>

           
			
				<div id="alleopleidingen">
              
              <div id="ecma">
					<table border="0" cellpadding="0" cellspacing="5">
               <tr>				
				<td width="252" valign="top"><strong>ECONOMICS</strong></td>
                <td valign="top"><strong>BA</strong></td>
			</tr>	
						<tr>				
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Accountancy" value="Accountancy" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Accountancy", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Accountancy">Accountancy</label></td>
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bedrijfskunde-MER" value="Bedrijfskunde-MER" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Bedrijfskunde-MER", $_POST['opleiding'])){ ?>checked<?php } ?> />
						  <label for="Bedrijfskunde-MER">Bedrijfskunde-MER</label></td>
					  </tr>			
						<tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bedrijfseconomie" value="Bedrijfseconomie" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Bedrijfseconomie", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Bedrijfseconomie">Bedrijfseconomie</label></td>
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="HBO-Rechten" value="HBO-Rechten" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "HBO-Rechten", $_POST['opleiding'])){ ?>checked<?php } ?> />
						  <label for="HBO-Rechten">HBO-Rechten</label></td>
						<tr>	
						<td valign="top"><input type="checkbox" class="check" name="Financial Services Management" id="Financial Services Management" value="Financial Services Management" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Financial Services Management", $_POST['opleiding'])){ ?>checked<?php } ?> />
						  <label for="Financial Services Management">Financial Services Management</label></td>
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Human Resource Management" value="Human Resource Management" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Human Resource Management", $_POST['opleiding'])){ ?>checked<?php } ?> />
						  <label for="Human Resource Management">Human Resource Management</label></td>
						</tr>
                      
                        <tr><td></td>
                          <td></td>
                        </tr>
                        
                        <tr>				
						<td valign="top"><strong>BIM/ITSM</strong></td>
						<td valign="top"><strong>Thorbecke</strong></td>
					  </tr>	
                        
						
                        		
						<tr>	
                        
                        <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Business IT en Management" value="Business IT en Management" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Business IT en Management", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Business IT en Management">Business IT &amp; Management</label></td>
                        <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Integrale veiligheid" value="Integrale veiligheid" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Integrale veiligheid", $_POST['opleiding'])){ ?>checked<?php } ?> />
                          <label for="Integrale veiligheid">Integrale veiligheid</label></td>
                        <tr>
                        
                        <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="IT service Management(AD)" value="IT service Management (AD)" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "IT service Management", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="IT service Management (AD)">IT service Management(AD)</label></td>
                        <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bestuurskunde" value="Bestuurskunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Bestuurskunde", $_POST['opleiding'])){ ?>checked<?php } ?> />
                          <label for="Bestuurskunde">Bestuurskunde</label>
                          </td>
                          
                          
                          
                          <tr>
                          <td></td>
                          <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="European Studies" value="European Studies" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "European Studies", $_POST['opleiding'])){ ?>checked<?php } ?> />
                        	  <label for="European Studies">European Studies</label></td>
                              </tr>
                          
                    
                    <tr>
                     <td valign="top"><strong>MARKETING MAN.</strong></td>
                     <td valign="top"><strong>TBK</strong></td>
                     
                     </tr>
                       				
<tr>
  <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Commerciele Economie" value="Commerciele Economie" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Commerciele Economie", $_POST['opleiding'])){ ?>checked<?php } ?> />
    <label for="Commerciele Economie">Commerciële Economie</label></td>
  <td valign="top"><input type="checkbox" class="check" name="opleiding[]"  value="Technische Bedrijfskunde" id="Technische Bedrijfskunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Technische Bedrijfskunde", $_POST['opleiding'])){ ?>checked<?php } ?> />
    <label for="Technische Bedrijfskunde">Technische Bedrijfskunde</label></td>
  </tr>
<tr>
  <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="International Business en Languages" value="International Business en Languages" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "International Business en Languages", $_POST['opleiding'])){ ?>checked<?php } ?> />
    <label for="International Business en Languages">International Business &amp; Languages</label></td>
  <td valign="top">&nbsp;</td>			
						</tr>
<tr>
  <td valign="top"><strong>Comm/CMD</strong></td>			
						<td valign="top">&nbsp;</td>
						</tr>
                        
                        <tr>
                          <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Communicatie" value="Communicatie" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Communicatie", $_POST['opleiding'])){ ?>checked<?php } ?> />
                            <label for="Communicatie">Communicatie</label></td>
                          <td></td>
                        </tr>
                        
                        	<tr>
                        	  <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Communications en Multimedia Design" value="Communications en Multimedia Design" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Communications en Multimedia Design", $_POST['opleiding'])){ ?>checked<?php } ?> />
                        	    <label for="Communications en Multimedia Design">Communications &amp; Multimedia Design</label></td>
                        	  <td valign="top">&nbsp;</td>	
                            
    
                        
             
                          </table>
                        
                        </div><!-- einde ECMA -->
                        
                        
                        
                        <h2><strong>TECHNIEK</strong>
                        </h2>
                        
             <div class="alleTechniekAan aanUit">Selecteer alle Techniek opleidingen</div>
			<div class="alleTechniekUit aanUit">Deselecteer alle Techniek opleidingen</div>
                        
                        <div id="techniek">
                        
                        <table width="521" border="0">
  <tr>
    <td width="252" valign="top"><p><strong>Build Environment </strong></p></td>
    <td width="259" valign="top"><p><strong>Engineering</strong></p></td>
    </tr>
  <tr>
    <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Bouwkunde" value="Bouwkunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Bouwkunde", $_POST['opleiding'])){ ?>checked<?php } ?> />
      <label for="Bouwkunde">Bouwkunde</label></td>
    <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Elektrotechniek" value="Elektrotechniek" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Elektrotechniek", $_POST['opleiding'])){ ?>checked<?php } ?> />
      <label for="Elektrotechniek">Elektrotechniek</label></td>
    </tr>
  <tr>
    <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Civiele Techniek" value="Civiele Techniek" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Civiele Techniek", $_POST['opleiding'])){ ?>checked<?php } ?> />
      <label for="Civiele Techniek">Civiele Techniek</label></td>
    <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Informatica"  value="Informatica" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Informatica", $_POST['opleiding'])){ ?>checked<?php } ?> />
      <label for="Informatica">Informatica</label></td>
    </tr>
  <tr>
    <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Mobiliteit" value="Mobiliteit" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Mobiliteit", $_POST['opleiding'])){ ?>checked<?php } ?> />
      <label for="Mobiliteit">Mobiliteit</label></td>
    <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Werktuigbouwkunde" value="Werktuigbouwkunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Werktuigbouwkunde", $_POST['opleiding'])){ ?>checked<?php } ?> />
      <label for="Werktuigbouwkunde">Werktuigbouwkunde</label></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Maritieme Techniek" value="Maritieme Techniek" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "1", $_POST['opleiding'])){ ?>checked<?php } ?> />
      <label for="Maritieme Techniek">Maritieme Techniek</label></td>
    </tr>

</table>
                      </div> <!-- einde Techniek -->
                        
                          <h2><strong>IEC</strong>
                          </h2>
                          
    <div class="alleIecAan aanUit">Selecteer alle IEC opleidingen</div>
	<div class="alleIecUit aanUit">Deselecteer alle IEC opleidingen</div>
    
    <div id="iec">
              <table>


                        
                      <tr>          
	<td width="267" valign="top"><strong>Theater/BKV</strong></td>
	<td width="215" valign="top"><strong>Talen</strong></td>
	                  </tr>
								
                        
                        		
		
        
        <tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Docent Beeldende Kunst en Vormgeving" value="Docent Beeldende Kunst en Vormgeving" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Docent Beeldende Kunst en Vormgeving", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Docent Beeldende Kunst en Vormgeving">Docent Beeldende Kunst en Vormgeving</label></td>
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Nederlands" value="Leraar Nederlands" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Nederlands", $_POST['opleiding'])){ ?>checked<?php } ?> />
						  <label for="Leraar Nederlands">Leraar Nederlands</label></td>
				</tr>
                        
                        <tr>
                        <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Docent Theater" value="Docent Theater" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Docent Theater", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Docent Theater">Docent Theater</label></td>
                        <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Duits" value="Leraar Duits" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Duits", $_POST['opleiding'])){ ?>checked<?php } ?> />
                          <label for="Leraar Duits">Leraar Duits</label></td>
                        </tr>	
                        <tr><td></td>
                          <td></td>
                        </tr>
                        
                        <tr>
                          <td valign="top"><strong>Sociale Vakken</strong></td>
                          <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Engels" value="Leraar Engels" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Engels", $_POST['opleiding'])){ ?>checked<?php } ?> />
                            <label for="Leraar Engels">Leraar Engels</label></td>
                        </tr>	
                        
                                     <tr>
                                       <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Aardrijkskunde" value="Leraar Aardrijkskunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Aardrijkskunde", $_POST['opleiding'])){ ?>checked<?php } ?> />
                                         <label for="Leraar Aardrijkskunde">Leraar Aardrijkskunde</label></td>          
	<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Frans" value="Leraar Frans" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Frans", $_POST['opleiding'])){ ?>checked<?php } ?> />
	  <label for="Leraar Frans">Leraar Frans</label></td>
	                                 </tr>

			
						<tr>
						  <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Algemene/Bedrijfseconomie" value="Leraar Algemene/Bedrijfseconomie" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Algemene/Bedrijfseconomie", $_POST['opleiding'])){ ?>checked<?php } ?> />
						    <label for="Leraar Algemene/Bedrijfseconomie">Leraar Algemene/Bedrijfseconomie</label></td>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Fries" value="Leraar Fries" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Fries", $_POST['opleiding'])){ ?>checked<?php } ?> />
						  <label for="Leraar Fries">Leraar Fries</label></td>
						</tr>
				
                <tr>
                  <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Geschiedenis" value="Leraar Geschiedenis" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Geschiedenis", $_POST['opleiding'])){ ?>checked<?php } ?> />
                    <label for="Leraar Geschiedenis">Leraar Geschiedenis</label></td>
                	<td valign="top"><strong>Pabo</strong></td>
				</tr>
              
                      
                
                        
                        
                        <tr>
                          <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Gezondheidszorg en Welzijn" value="Leraar Gezondheidszorg en Welzijn" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Gezondheidszorg en Welzijn", $_POST['opleiding'])){ ?>checked<?php } ?> />
                            <label for="Leraar Gezondheidszorg en Welzijn">Leraar Gezondheidszorg &amp; Welzijn</label></td>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Basisonderwijs" value="Leraar Basisonderwijs" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Basisonderwijs", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Leraar Basisonderwijs">Leraar Basisonderwijs</label></td>
						<td valign="top">&nbsp;</td>	
                        
                        
                        </tr>
                        
                        <tr>
                          <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Maatschappijleer" value="Leraar Maatschappijleer" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Maatschappijleer", $_POST['opleiding'])){ ?>checked<?php } ?> />
                            <label for="Leraar Maatschappijleer">Leraar Maatschappijleer</label></td>
                        
                        <td valign="top">&nbsp;</td>	
						</tr>	
                        <tr><td></td>
                          <td></td>
                        </tr>
                        
                        <tr>
                          <td valign="top"><strong>Exacte vakken</strong></td>
                          <td valign="top">&nbsp;</td>	
                        </tr>	
                        
                        <tr>
                           <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Biologie" value="Leraar Biologie" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Biologie", $_POST['opleiding'])){ ?>checked<?php } ?> />
                            <label for="Leraar Biologiee">Leraar Biologie</label></td>
                          <td></td>
                        </tr>
                        
                        <tr>
                           <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Scheikunde" value="Leraar Maatschappijleer" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Scheikunde", $_POST['opleiding'])){ ?>checked<?php } ?> />
                            <label for="Leraar Scheikunde">Leraar Scheikunde</label></td>
                          <td valign="top">&nbsp;</td>
                        
                                  <tr>
		 <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Wiskunde" value="Leraar Wiskunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Wiskunde", $_POST['opleiding'])){ ?>checked<?php } ?> />
                            <label for="Leraar Wiskunde">Leraar Wiskunde</label></td>
		<td valign="top">&nbsp;</td>	
                </tr>
        
                             <tr>
                                <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Leraar Natuurkunde" value="Leraar Natuurkunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Leraar Natuurkunde", $_POST['opleiding'])){ ?>checked<?php } ?> />
                            <label for="Leraar Natuurkunde">Leraar Natuurkunde</label></td>
                               <td valign="top">&nbsp;</td>	
                </tr>
                
                <tr>
                
                <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Toegepaste Wiskunde" value="Toegepaste Wiskunde" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Toegepaste Wiskunde", $_POST['opleiding'])){ ?>checked<?php } ?>>
                <label for="Bedrijfswiskunde"> Toegepaste Wiskunde</label></td>	
        </tr>
        
                              
        
        <tr><td></td>
          <td></td>
        </tr>
        
        
                          </table>
                      
              </div><!-- einde #iec -->
                      
                      <h2><strong>ZORG & WELZIJN</strong>
                      </h2>
                      
     <div class="alleZorgwelzijnAan aanUit">Selecteer alle IEC opleidingen</div>
	<div class="alleZorgwelzijnUit aanUit">Deselecteer alle IEC opleidingen</div>
                      
                      <div id="zorgwelzijn">
              <table>
                        
                        
        <tr>
          <td width="272" valign="top"><strong>Social Work</strong></td>
          <td width="219" valign="top"><strong>HBO-V</strong></td>
          <tr>
        	<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Pedagogiek" value="Pedagogiek" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Pedagogiek", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Pedagogiek">Pedagogiek</label></td>
        	<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Verpleegkunde"  value="Verpleegkunde"<?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Verpleegkunde", $_POST['opleiding'])){ ?>checked<?php } ?> />
        	  <label for="Verpleegkunde">Verpleegkunde</label></td>
        	</tr>	      
                        
                        <tr>			
						<td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Maatschappelijk Werk en Dienstverlening" value="Maatschappelijk Werk en Dienstverlening" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Maatschappelijk Werk en Dienstverlening", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Maatschappelijk Werk en Dienstverlening">Maatschappelijk Werk en Dienstverlening</label></td>
						<td valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                        <td valign="top"><input type="checkbox" class="check" name="opleiding[]" id="Culturele en Maatschappelijke Vorming" value="Culturele en Maatschappelijke Vorming" <?php if(!empty($_POST['opleiding']) && !empty($error) &&  in_array( "Culturele en Maatschappelijke Vorming", $_POST['opleiding'])){ ?>checked<?php } ?>><label for="Culturele en Maatschappelijke Vorming">Culturele en Maatschappelijke Vorming</label></td>
                        <td valign="top">&nbsp;</td>	
						</tr>
                        
                        
                        
                        
                        
                        </table>
                        
              </div><!-- einde #zorgwelzijn -->
              
              </div><!-- einde #alleopleidngen -->
                        
                        
                       
                        
                          <h2><strong>EXTRA</strong>
                          </h2>
              
              
              
              
					
					
					
					Heeft Rijbewijs<br />
					<select name="rijbewijs">
						<option value="nvt" <?php if(!empty($error) && $_POST['rijbewijs'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['rijbewijs'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['rijbewijs'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select><br /><br />
					Kan rondleiding geven<br />
					<select name="rondleiding">
						<option value="nvt" <?php if(!empty($error) && $_POST['rondleiding'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['rondleiding'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['rondleiding'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select><br /><br />
					Kan Talentworkshop geven<br />
					<select name="workshop">
						<option value="nvt" <?php if(!empty($error) && $_POST['workshop'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['workshop'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['workshop'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />
                    
                    Kan helpen bij online vraagstuk<br />
                    <select name="onlinevraagstuk">
						<option value="nvt" <?php if(!empty($error) && $_POST['onlinevraagstuk'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['onlinevraagstuk'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['onlinevraagstuk'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />
                    
                     Kan helpen bij webcareklus<br />
                    
                    <select name="webcareklus">
						<option value="nvt" <?php if(!empty($error) && $_POST['webcareklus'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['webcareklus'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['webcareklus'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />
                    
                    Kan helpen bij brochureklus<br />
                    
                    <select name="brochureklus">
						<option value="nvt" <?php if(!empty($error) && $_POST['brochureklus'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['brochureklus'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['brochureklus'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    <br /><br />
                    Kan helpen bij invoerklus<br />
                      <select name="invoerklus">
						<option value="nvt" <?php if(!empty($error) && $_POST['invoerklus'] == "nvt"){ ?>selected="selected"<?php } ?>>Onbelangrijk</option>
						<option value="Ja" <?php if(!empty($error) && $_POST['invoerklus'] == "Ja"){ ?>selected="selected"<?php } ?>>Ja</option>
						<option value="Nee" <?php if(!empty($error) && $_POST['invoerklus'] == "Nee"){ ?>selected="selected"<?php } ?>>Nee</option>
					</select>
                    
                    
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
				$maillijsten2 = $wpdb->get_results( "SELECT * FROM Maillijst WHERE UserID = $current_user->ID ORDER BY ID DESC");
				foreach( $maillijsten2 as $maillijst2 ){ 
				$onderwerp = substr($maillijst2->Naam, 0, 50);
				?>
							<tr >
								<td valign="top" width="500" title="Deze mailing heeft <?php aantalOntvangersNieuw($maillijst2->ID); ?> ontvangers"> <B>&nbsp;&nbsp;<a href="http://www.expect-webmedia.nl/drpr/mailing-detail/?mailID=<?php echo $maillijst2->ID; ?>"><?php echo $onderwerp; ?> (<?php aantalOntvangersNieuw($maillijst2->ID); ?>)</a></B></td>
								<td valign="top"><a href="http://www.expect-webmedia.nl/drpr/mailingen-nieuw/?delml=<?php echo $maillijst2->ID; ?>"  onclick="return confirm('Weet je zeker dat je deze E-mail wilt verwijderen?')">X</a></td>
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
				$maillijsten = $wpdb->get_results( "SELECT * FROM Maillijst WHERE UserID != $current_user->ID ORDER BY ID DESC LIMIT 20");
				foreach( $maillijsten as $maillijst ){ 
				$onderwerp = substr($maillijst->Naam, 0, 50);
				?>
							<tr >
								<td valign="top" width="500" title="Deze mailing heeft <?php aantalOntvangersNieuw($maillijst->ID); ?> ontvangers"> <B>&nbsp;&nbsp;<a href="http://www.expect-webmedia.nl/drpr/mailing-detail-test/?mailID=<?php echo $maillijst->ID; ?>"><?php echo $onderwerp; ?> (<?php aantalOntvangersNieuw($maillijst->ID); ?>)</a></B></td>
								<td valign="top"><a href="https://www.expect-webmedia.nl/drpr/e-mail-test/?delml=<?php echo $maillijst->ID; ?>"  onclick="return confirm('Weet je zeker dat je deze E-mail wilt verwijderen?')">X</a></td>
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