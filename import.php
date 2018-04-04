<?php  ob_start();
/*
Template Name: Importeren
*/


get_header();

				

				//connect to the database
				global $wpdb;
				//

				if ($_FILES[csv][size] > 0) {

					//get the csv file
					$file = $_FILES[csv][tmp_name];
					$handle = fopen($file,"r");
					
					//loop through the csv file and insert into database
					$i = 0;
					do {
						$i++;
						if ($data[0]) {
							if($i > "2"){
							$extr = date('m');
							$persKey = md5(uniqid($extr, true));
							$actief = "ja";
							mysql_query("INSERT INTO Beheertool (Voornaam, Tussenvoegsel, Achternaam, Type_overeenkomst, Geslacht, Emailadres, Geboortedatum, Adres, Huisnummer, Postcode, Woonplaats, Telefoonnummer, Mobiel, Opleiding, Maat, Rijbewijs, Afwezig_van, Afwezig_tot, Opmerkingen, IBAN, Studentnr, Studiejaar, Loonheffing, Talentworkshop, Rondleiding, Vooropleiding, Ingang_loonheffing, Contract_van, Contract_tot, BSN, Actief, Perskey) VALUES
								(
									'".addslashes($data[0])."',
									'".addslashes($data[1])."',
									'".addslashes($data[2])."',
									'".addslashes($data[3])."',
									'".addslashes($data[4])."',
									'".addslashes($data[5])."',
									'".addslashes($data[6])."',
									'".addslashes($data[7])."',
									'".addslashes($data[8])."',
									'".addslashes($data[9])."',
									'".addslashes($data[10])."',
									'".addslashes($data[11])."',
									'".addslashes($data[12])."',
									'".addslashes($data[13])."',
									'".addslashes($data[14])."',
									'".addslashes($data[15])."',
									'".addslashes($data[16])."',
									'".addslashes($data[17])."',
									'".addslashes($data[18])."',
									'".addslashes($data[19])."',
									'".addslashes($data[20])."',
									'".addslashes($data[21])."',
									'".addslashes($data[22])."',
									'".addslashes($data[23])."',
									'".addslashes($data[24])."',
									'".addslashes($data[25])."',
									'".addslashes($data[26])."',
									'".addslashes($data[27])."',
									'".addslashes($data[28])."',
									'".addslashes($data[29])."',
									'".addslashes($data[30])."',
									'$persKey'
								)
							");
							}
						}
					} while ($data = fgetcsv($handle,1000,",","'"));
					//

					//redirect
					header('Location: http://www.expect-webmedia.nl/drpr/importeren?success=1'); die;

				}

				?>
				<?php if (!empty($_GET[success])) { ?>
					<div id="s6" style="width: 1150px;  background-color: #007942; float: left; margin-bottom: 15px;padding: 20px; color: #ffffff;">
						Bestand met succes geïmporteerd!
					</div>
					<?php }?> 
				 
<div style="clear: both;"></div>
	<div id="contentLinks">
		<div class="contentHeaderImport">
			<h1>Importeer Dream- Promoteamers</h1>
		</div>
		<div class="contentContent">
			<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
			  Selecteer een CSV bestand: <br />
			  <input name="csv" type="file" id="csv" />
			  <input type="submit" name="Submit" value="Importeren" id="importSubmit" />
			</form>
		</div>
	</div>

	<div id="contentRechts">
		<div class="contentHeaderHulp">
			<h1>Handleiding importeren</h1>
		</div>
		<div class="contentContent">
			Tekst
		</div>
	</div>
<?php

get_footer(); ob_end_flush(); ?>