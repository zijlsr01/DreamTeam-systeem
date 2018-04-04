<?php require('../../../wp-blog-header.php');
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Briefing-contentbeheer.doc");


echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<style>";
echo "h1{font-family: arial; font-size: 35; color: #000;}";
echo "h3{font-family: arial; font-size: 16; color: #000;}";
echo "p {font-family: arial; font-weigth: lighter; color: #000; font-size: 14}";
echo "</style>";
echo "<body>";

global $wpdb;

$actID = $_GET['id'];
$actDetails = $wpdb->get_row("SELECT * FROM Briefing WHERE ID = $actID" );


echo "<h1>Briefing contentbeheer</h1>";
echo "<h3>$actDetails->Titel</h3>";
echo "<p>Projectnummer: $actDetails->Projectnummer</p>";
echo "<p>Locatie briefing op M-schijf: $actDetails->Locatie</p>";
echo "<p>Omschrijving opdracht: $actDetails->Omschrijving</p>";
echo "</body>";
echo "</html>";


?>
