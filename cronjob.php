<?php 
/*
Template Name: CJPage
*/
get_header('kaal'); ?>

<!-- begin document -->
<?php 
	global $wpdb;
	
	$cronKey = $_GET['cronKey'];
	if($cronKey == 'osjdu997839uj7hhiknuhnh989780776hsjsi'){
	tijdelijkmail('geertvanderheide@gmail.com');
	}
?>
<!-- einde document -->
<?php
get_footer('leeg');
