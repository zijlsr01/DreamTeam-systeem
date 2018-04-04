<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title(); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel='stylesheet'  href='<?php echo get_stylesheet_uri(); ?>' type='text/css' media='all' />
	<link rel="stylesheet" media="all" type="text/css" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" media="all" type="text/css" href="jquery-ui-timepicker-addon.css" />
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:600' rel='stylesheet' type='text/css'>
	 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	 <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	 <script>
  tinymce.init({
    selector: "#mytextarea",
	plugins: "table contextmenu link image code",
	menubar: false,
	toolbar: "code undo redo bold link image table italic alignleft aligncenter alignright bullist numlist outdent indent",
	contextmenu: "link image inserttable | cell row column deletetable"
	  });
  </script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="layer" style="display: none; background-image: url('<?php bloginfo('template_url'); ?>/images/bg.png'); width: 100%; height: 95%; position: absolute; z-index: 100; text-align: center;">
	<img src="<?php bloginfo('template_url'); ?>/images/preloader.gif" alt="" style="margin-top: 400px;">
</div>
<div class="omheen">
	<div class="logo">
	<?php
	global $post;
		if(is_user_logged_in()){ ?>
		<a href="/drpr"><img src="<?php bloginfo('template_url');?>/images/logoNHLStenden.png" alt="" /></a>
		<?php } ?>
	</div>




	<div class="nav">
	<div id="log">
<?php if(is_user_logged_in()){ ?>
		<?php global $current_user; ?>
		Ha die <?php echo $current_user->first_name; ?>, welkom terug!
		<?php
		if( current_user_can('administrator') ) {  ?>
    <a href="/drpr/wp-admin" target="_self"><img src="<?php bloginfo('template_url'); ?>/images/buttonAdmin.png" alt="Ga naar WP Admin"></a>
<?php } ?> | <a href="<?php echo wp_logout_url( home_url() ); ?>" title="Uitloggen">Uitloggen</a>
<?php } ?>
	</div>

	<!--
	<ul>
		<li <?php
		// if($post->ID == 27){ ?> class="current_page_item"<?php // } ?>><a href="http://www.expect-webmedia.nl/drpr/">Mijn Dashboard</a></li>
		<?php
		// if(is_user_logged_in()){

			?>
			<li>
				<?php
			// wp_list_pages ('title_li=&exclude=15,19,11,27,6,9,35,21,48,52,60,62,74,68,70,73,75,80,83,85,87,90,101,103,105,107,109,114,116,121,126,134,146,150,157');
			?> </li>
			<?php
		// }?>
	</ul>
-->


<?php
 $currentLevel = $current_user->user_level;
?>

<nav id="primary_nav_wrap">
<ul>
  <li <?php if($post->ID == 27){ ?> class="current_page_item"<?php } if($currentLevel != 0){ ?>><a href="http://www.expect-webmedia.nl/drpr/">Mijn Dashboard</a><?php } ?></li>
		<?php
		if(is_user_logged_in()){

			?>


		<?php
			if($currentLevel != 0){
	wp_list_pages('title_li=&exclude=15,19,11,27,6,9,35,21,48,52,60,62,74,68,70,75,80,83,85,87,90,101,103,105,107,109,114,116,121,126,134,146,150,157,168,170,174');
	}
	?> 
	<?php
}?>


<?php
if($currentLevel == 0){ ?>
 <li class="page_item page-item-73"><a href="https://www.expect-webmedia.nl/drpr/contentkalender/">Contentkalender</a></li>
<?php }
?>
</ul>
</nav>
	</div>
