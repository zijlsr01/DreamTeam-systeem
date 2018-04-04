<?php  ob_start();
/*
Template Name: radiointerview toevoegen
*/


get_header();

				//connect to the database
				global $wpdb; $current_user;
				get_currentuserinfo();				
				$current_user = wp_get_current_user();
				
				if(!empty($_GET['copy'])){
					$copyCampgne = $wpdb->get_row( "SELECT * FROM Radiointerview WHERE ID = '".$_GET['copy']."'" );
				}
	
				if(!empty($_GET['delete'])){
					$actDetails = $wpdb->get_row("SELECT * FROM Activiteiten WHERE ID = ".$_GET['id']."" );
					$wpdb->query(   "  DELETE FROM Special WHERE ID = ".$_GET['id']." "  );
				?>
			
				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					Verwijderen gelukt!
				</div>
				<?php } ?>
				<div style="clear: both;"></div>
	<div id="contentLinks">
		<div class="contentHeaderContent">
		<div class="contentHeaderIcon" style="margin-top: 5px;"><img src="<?php bloginfo('template_url'); ?>/images/iconAdd.png " alt=""></div>
			<h1>Radio interview aanmaken</h1>
		</div>
		<div class="contentContentdr">
			<?php 
				//kijken of er fouten zijn gemaakt
				if(empty($_POST['titel'])){	$error .= "<li>Je bent vergeten de titel van het radio interview in te vullen</li>";	}
				if(empty($_POST['startTijd'])){	$error .= "<li>Je bent vergeten een uitzenddatum in te vullen</li>";	}
				if(empty($_POST['beschrijving'])){	$error .= "<li>Je bent vergeten de beschrijving van het interview in te vullen</li>";}		

				if(isset( $_POST['submit'] ) && !empty($error)){ ?>
					<div id="alert">
						<ul>
							<?php echo $error; ?>
						</ul>
					</div>
				<?php }
				

				//als er geen fouten gemaakt zijn dan zetten we de gegevens in de database en geven we een succesmelding
				if($_POST['submit'] && empty($error)){
					$startD = date("Ymd", strtotime($_POST['startTijd']));
					$eindD = date("Ymd", strtotime($_POST['eindTijd']));	
					$actKey = date('YmdB').$contactID;
					$kleur = "#f58d4d"; 
					$wpdb->insert( Radiointerview, array( 'Titel' => $_POST['titel'],'Tijd_van' => $startD,'Tijd_tot' => $startD, 'Mschijf' => $_POST['m-schijf'], 'Omschrijving' => $_POST['beschrijving'], 'actKey' => $actKey, 'KanaalID' => $_POST['kanaalID'] ) );
					
		
					$ActDetails = $wpdb->get_row("SELECT * FROM Radiointerview WHERE actKey = $actKey" );
					$url = "http://www.expect-webmedia.nl/drpr/detailpagina-radiointerview/?id=".$ActDetails->ID;
					wp_redirect( $url.'&add=succes' ); exit;
				}
			?>

			<?php 
				if(!isset( $_POST['submit'] ) || !empty($error)){ 
					get_currentuserinfo();
					$kanalen = $wpdb->get_results( "SELECT * FROM Kanalen" );
					
					if(!$_POST['submit'] && !empty($_GET['copy'])){ ?>
						<a href="/drpr/persbericht-toevoegen"><img src="<?php bloginfo('template_url'); ?>/images/iconCopyStop.png" alt="" title="Annuleer Kopieeractie" style="margin-bottom: 20px; border: 0px;"></a>
					<?php }
					
					?>
			<form action="/drpr/radio-interview-toevoegen/" method="post">
				Onderwerp radio Interview *<br />
				<input type="text" name="titel" value="<?php if($_POST['submit']){ echo $_POST['titel']; } if(!$_POST['submit'] && !empty($_GET['copy'])){ echo $copyCampgne->Titel; } ?>" /><br /><br />
				Op welke datum wordt het radio interview uitgezonden?<br />
				<input type="text" name="startTijd" id="startDate" value="<?php if($_POST['submit']){ echo $_POST['startTijd']; } if(!$_POST['submit'] && !empty($_GET['copy'])){ mooiedatum3($copyCampgne->Tijd_van); } ?>" /><br /><br />
				Beschrijving radio interview *<br />
				<textarea id="persbericht" name="beschrijving"><?php if($_POST['submit']){ echo $_POST['beschrijving']; } if(!$_POST['submit'] && !empty($_GET['copy'])){ echo $copyCampgne->Omschrijving; } ?></textarea><br /><br />
				<input type="submit" id="submit" name="submit" value="Aanmaken">
			</form>

			<?php } ?>
		</div>
	</div>

	<div id="contentRechts">
	<div class="contentHeaderZoeken">
					<h1>Zoek &amp; kopieer voorgaande radio interviews</h1>
				</div>
				<div class="contentContentdr">
					<form method="post" id="search">
						<input type="text" value="" id="searchDream" name="keyWord">
						<input type="submit" value="Zoeken!" name="submit2" id="searchSubmit">
					</form>
					<?php if($_POST['submit2']){
						global $wpdb;
						$keyWord = $_POST['keyWord'];
						$zoekresultaten = $wpdb->get_results( "SELECT * FROM Radiointerview WHERE Titel LIKE '%".$keyWord."%' ORDER BY ID DESC" );
						$aantal = $wpdb->get_var( " SELECT COUNT(*) FROM Radiointerview WHERE Titel LIKE '%".$keyWord."%'"); 
						?><span class="header3">Zoekresultaten voor <i>&quot;<?php echo $_POST['keyWord']; ?>&quot;</i> (<?php echo $aantal; ?>)</span>
						<table cellpadding="5" cellspacing="0" border="0">
						<?php
						foreach( $zoekresultaten as $zoekresultaat ){ 
							
						?>
							<tr >
								<td valign="top" width="280"><a href="http://www.expect-webmedia.nl/drpr/detailpagina-persbericht/?id=<?php echo $zoekresultaat->ID; ?>"><?php echo $zoekresultaat->Titel; ?></a></td>
								<td valign="top">&nbsp;</td>
								<td valign="top" width="230" class="date">&nbsp;&nbsp;<?php mooiedatum2($zoekresultaat->Tijd_tot); ?><a href="/drpr/persbericht-toevoegen/?copy=<?php echo $zoekresultaat->ID; ?>"><img src="<?php bloginfo('template_url'); ?>/images/iconCopy.png" alt="" title="Kopieer dit persbericht" border="0" style="float: right;"></a></td>
							</tr>
						<?php 
						
						}

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