<?php  ob_start();
/*
Template Name: Importeren Bellijst Test
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
    do { 
        if ($data[0]) { 
            mysql_query("INSERT INTO Bellijst (studentName, studentNumber, studentOpleiding, studentTelefoon, camID) VALUES 
                ( 
                    '".addslashes($data[0])."', 
                    '".addslashes($data[1])."', 
                    '".addslashes($data[2])."',
					'".addslashes($data[3])."', 
                    '".addslashes($data[4])."' 
                ) 
            "); 
				
        } 
    } while ($data = fgetcsv($handle,1000,",","'")); 
    // 

    //redirect 
    header('Location: /drpr/belactie-import/?success=1'); die; 

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
			<h1>Importeer bellijst</h1>
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