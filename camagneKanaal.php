<?php  ob_start();
/*
Template Name: Campagne Kanaal toevoegen
*/


get_header();

				//connect to the database
				global $wpdb; $current_user;
				get_currentuserinfo();				
				$current_user = wp_get_current_user();
				if($_POST['submitKanaal']){
					if(empty($_POST['kanaalNaam'])){
						$error = "Je bent vergeten de naam van het campagne kanaal in te vullen";
					}
					
					if(empty($error)){
						$wpdb->insert( Kanalen, array( 'Kanaal' => $_POST['kanaalNaam'] ) ); ?>
						<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">Campagne kanaal met succes toegevoegd!
						</div>
					<?php
					}
				}
				
				
				if(!empty($_POST['addMid'])){
					if(empty($_POST['addMidDis'])){
						$error2 = "Je bent vergeten de naam van het campagne middel in te vullen";
					}
					
					if(empty($error2)){
						$wpdb->insert( Middelen, array( 'Kanaal' => $_POST['kanaal'], 'Uiting_type' => $_POST['addMidDis'] ) ); ?>
						<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">Campagne middel met succes toegevoegd!
						</div>
					<?php
					}
					
				}
				
				if(!empty($_GET['emp'])){
					$wpdb->query(   " DELETE FROM Middelen WHERE ID = ".$_GET['emp']." "  );
					?>
			
				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					Campagnemiddel met succes verwijderd
				</div>
				<?php } 
				
				if(!empty($_GET['emp2'])){
					$wpdb->query(   " DELETE FROM Kanalen WHERE ID = ".$_GET['emp2']." "  );
					$wpdb->query(   " DELETE FROM Middelen WHERE Kanaal = ".$_GET['emp2']." "  );
					
					?>
			
				<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
					Campagnemiddel met succes verwijderd
				</div>
				<?php } ?>
				<div style="clear: both;"></div>
	<div id="contentLinks">
		<div class="contentHeaderContent">
		<div class="contentHeaderIcon" style="margin-top: 5px;"><img src="<?php bloginfo('template_url'); ?>/images/iconAddChannel.png " alt=""></div>
			<h1>Campagne Kanaal toevoegen</h1>
		</div>
		<div class="contentContentdr">
		<?php 
		if(isset( $_POST['submitKanaal'] ) && !empty($error)){ ?>
					<div id="alert">
						<ul>
							<?php echo $error; ?>
						</ul>
					</div>
				<?php } ?>
			<form action="/drpr/campagne-kanalen-en-middelen/" method="post">
				Naam campagne kanaal *<br />
				<input type="text" name="kanaalNaam" value="<?php echo $_POST['titel']; ?>" /><br /><br />
				<input type="submit" id="submit" name="submitKanaal" value="Campagne kanaal aanmaken" style="float: right;">
			</form>
		</div>
	</div>

	<div id="contentRechts">
	<div class="contentHeaderContent">
		<div class="contentHeaderIcon" style="margin-top: 5px;"><img src="<?php bloginfo('template_url'); ?>/images/iconAddChannel.png " alt=""></div>
			<h1>Campagne kanalen en middelen</h1>
		</div>
		<?php 
				global $wpdb;
				$kanalen = $wpdb->get_results( "SELECT * FROM Kanalen" );
				?>
		<div class="contentContentdr">
			<table border="0" cellpadding="5" cellspacing="3">
			<?php
				foreach( $kanalen as $kanaal ){ 
					$kanaalNaam = $wpdb->get_row( "SELECT * FROM Kanalen WHERE ID = '".$kanaal->ID."'" );
				?>
				<tr>
					<td valign="top"  colspan="2" width="600" bgcolor="#000" style="color: #ffffff;"><b><a name="<?php echo $kanaalNaam->Kanaal; ?>"></a>&nbsp;<div style="margin-top: 10px; margin-left: 5px; float: left;"><?php echo $kanaalNaam->Kanaal; ?></b></div><a href="http://www.expect-webmedia.nl/drpr/campagne-kanalen-en-middelen/?emp2=<?php echo $kanaalNaam->ID; ?>" onclick="return confirm('Weet je zeker dat je dit campagnekanaal wilt verwijderen?')" ><img src="<?php bloginfo('template_url'); ?>/images/iconDelChannel.png" alt="" title="Dit campagnekanaal verwijderen" style="float: right; padding: 7px;"></a></td>
				</tr>

			<?php 
				$campagneMiddelen = $wpdb->get_results( "SELECT * FROM Middelen WHERE Kanaal = '".$kanaalNaam->ID."'" );
				foreach($campagneMiddelen as $campagneMiddel){ 
				$middelDetails = $wpdb->get_row( "SELECT * FROM Middelen WHERE ID = '".$campagneMiddel->Middel."' AND Campagne = '".$actID."'" );	
				?>
				<tr bgcolor="#8b8b8b" style="color: #ffffff;" >
					<td valign="top" colspan="2" >&nbsp;<?php echo $campagneMiddel->Uiting_type; ?>
					
					<a href="http://www.expect-webmedia.nl/drpr/campagne-kanalen-en-middelen/?emp=<?php echo $campagneMiddel->ID; ?>#<?php echo $kanaalNaam->Kanaal; ?>" onclick="return confirm('Weet je zeker dat je dit campagnemiddel wilt verwijderen?')" ><img src="<?php bloginfo('template_url'); ?>/images/iconTrash.png" alt="" title="Dit campagnemiddel verwijderen" style="float: right; padding-top: 2px; margin-right: 3px;"></a></td>
				</tr>

			<?php } ?>
				<tr>
					<td valign="top" colspan="2">
					<?php if(empty($_GET['addCamp']) || $_GET['addCamp'] != $kanaal->ID){ ?>
					<a href="/drpr/campagne-kanalen-en-middelen/?addCamp=<?php echo $kanaal->ID; ?>#<?php echo $kanaalNaam->Kanaal; ?>"><img src="<?php bloginfo('template_url'); ?>/images/iconMiddelToevoegen.png" border="0"></a>
					<?php } ?>
					<?php if(!empty($_GET['addCamp']) && $_GET['addCamp'] == $kanaal->ID){ ?>
					<div style="background: #f37021; padding: 10px; border-radius: 10px; height: 150px;" class="addMid">
					<img src="<?php bloginfo('template_url'); ?>/images/iconMiddelToevoegen.png" border="0">
						<form action="https://www.expect-webmedia.nl/drpr/campagne-kanalen-en-middelen/#<?php echo $kanaalNaam->Kanaal; ?>" method="post">
						Type campagne middel<br />
						<input type="text" name="addMidDis" value="<?php echo $_POST['AddMisDis']; ?>" /><br /><br />
						<input type="text" name="kanaal" value="<?php echo $kanaal->ID; ?>" style="display: none;" />
						<a href="/drpr/campagne-kanalen-en-middelen/">Annuleren</a> <input type="submit" id="submit2" name="addMid" value="Toevoegen">
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
		</div>
	</div>
				

<?php

get_footer(); ob_end_flush(); ?>