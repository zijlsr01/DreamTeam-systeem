<?php  ob_start();
/*
Template Name: Inloggen
*/
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header('kaal'); ?>

<?php
    // if user is logged in, redirect whereever you want
    if (is_user_logged_in()) {
        header('Location: '.get_option('siteurl').'/drpr/');
        exit;
    }
 
    // if this page is receiving post data
    // means that someone has submitted the login form
    if( isset( $_POST['log'] ) ) {
        $incorrect_login = TRUE;
        $log = trim( $_POST['log'] );
        $pwd = trim( $_POST['pwd'] );
 
        // check if username exists
        if ( username_exists( $log ) ) {
            // read user data
            $user_data = get_userdatabylogin( $log );
 
            // create the wp hasher to add some salt to the md5 hash
            require_once( ABSPATH.'/wp-includes/class-phpass.php');
            $wp_hasher = new PasswordHash( 8, TRUE );
            // check that provided password is correct
            $check_pwd = $wp_hasher->CheckPassword($pwd, $user_data->user_pass);
 
            // if password is username + password are correct
            // signon with wordpress function and redirect wherever you want
            if( $check_pwd ) {
                $credentials = array();
                $credentials['user_login'] = $log;
                $credentials['user_password'] = $pwd;
                $credentials['remember'] = isset($_POST['rememberme']) ? TRUE : FALSE;
 
                $user_data = wp_signon( $credentials, false );
                header('Location: '.site_url('/'));
            }
            else {
                // don't need to do anything here, just print some error message
                // in the form below after checking the variable $incorrect_login
            }
        }
    }
 
    // and finally print the form, just be aware the action needs to go to "self",
    // hence we're using echo site_url('log-in'); for it
?>
 	<div id="content"> 
	
    <?php
			// incorrect credentials, print an error message
			if( TRUE == $incorrect_login ) {
				$error .= "<li>Ongeldige gebruikersnaam en wachtwoord combinatie!</li>";
			}
				$register = $_GET['register'];
				if($register == "1"){
					$error .= "<li>Je bent niet ingelogd op offer2deal.nl<br /> Meld je aan via onderstaand formulier of registreer je <a href=\"/registreren\" target=\"_self\">hier</a>!</li>";
				}

		?>
				
		<div class="kader">
		<?php if(!empty($error)){ ?>
				<div id="alertHome">
					Er is iets fout gegaan!
					<ul>
					<?php echo $error; ?>
					</ul>
				</div>
		<?php } ?>  
			<h1>Inloggen</h1>
			<form method="post" id="login-form">
			Gebruikersnaam<br />
			<input type="text" name="log" id="log" class="text" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="20" style="width: 430px; padding: 5px; border: 1px solid #bebebe;" /><br/>
	 
			Wachtwoord<br />
			<input type="password" name="pwd" id="pwd" class="text" size="20" style="width: 430px; padding: 5px; border: 1px solid #bebebe;" /><br /><br />
	 
			
			<input type="hidden" name="redirect_to" value="<?php echo get_option('siteurl'); ?>/drpr/" />
			<br />
			<div id="ad_cat_submit_div_2">
			<input type="submit" name="submit" value="Inloggen"  id="ad_cat_submit2" />
			
			<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> &nbsp;Onthouden</label>
		</div>
    </form> 
	</div>
</div>
<!-- /content -->

<?php
get_footer(); ob_end_flush();