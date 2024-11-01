<?php



/*



Plugin Name: User Self Delete



Plugin URI: http://www.bluelayermedia.com



Description: A Plugin to allow users to self delete



Author: BlueLayerMedia



Author URI: http://www.bluelayermedia.com



Version: 1.1

*/







add_action('admin_init', 'user_delete_init' );



add_action('admin_menu', 'user_delete_add_page');











// Init plugin options to white list our options



function user_delete_init(){



	register_setting( 'user_delete_options', 'selfdelete_allow_delete', 'user_delete_validate' );



}







// Add menu page



function user_delete_add_page() {



	add_options_page('User Self Delete', 'User Self Delete', 'administrator', 'user_self_delete', 'user_delete_do_page');



}







// Draw the menu page itself



function user_delete_do_page() {



	?>



	<div class="wrap">
<br />
  <a href="http://www.bluelayermedia.com/hosting/"><img src="http://www.bluelayermedia.com/images/hosting-offer.png" border="0" /></a>
  <br /><br />


		<h2>User Self Delete</h2>

		<p><b>GO PRO: </b> <a href="http://www.bluelayermedia.com/wp-plugin-user-self-delete">Get The Pro Version of User Self Delete</a> - It Includes the ability to set deletion abilities by user role and to choose to delete the posts related to the user at the same time.</p>

		<form method="post" action="options.php">



			<?php settings_fields('user_delete_options'); ?>



			<table class="form-table">



				<tr valign="top"><th scope="row">Allow Users To Self Delete?</th>



					<td><input name="selfdelete_allow_delete" type="checkbox" value="1" <?php checked('1', get_option('selfdelete_allow_delete')); ?> /></td>



			</table>



			<p class="submit">



			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />



			</p>



		</form>



	</div>



	<?php	



}







// Sanitize and validate input. Accepts an array, return a sanitized array.



function user_delete_validate($input) {



	// Our first value is either 0 or 1



	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );



	







	



	return $input;



}







add_action('admin_menu', 'user_delete_user_page');







function user_delete_user_page() {    



    if (get_option('selfdelete_allow_delete')==1) {



	add_menu_page('Delete My Account', 'Delete My Account', 'read', 'user_self_delete_user', 'user_delete_user_pages');



}



}



function user_delete_user_pages() {



  if ($_POST['delete_me'] == "yes") {



      mysql_query("DELETE FROM wp_users WHERE id='".$_POST['user_ID']."'"); 

      echo '<script type="text/javascript">window.location = "'.get_option('siteurl') . '/wp-login.php"</script>';

  

    }



global $current_user;

get_currentuserinfo();





?>



	<div class="wrap">



		<h2>Delete My Account</h2>



		 <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">



			<table class="form-table">



				<tr valign="top"><th scope="row">Delete My Account:</th>

                

                To delete your account, type "yes" in the box below without quotes and hit the button.



					<td><input name="delete_me" type="text" value=""  /></td>



			</table>



			<p class="submit">



			<input type="submit" class="button-primary" value="<?php _e('Delete My Account') ?>" />

            <input type="hidden" name="user_ID" value="<?php echo $current_user->ID; ?>"  />



			</p>



		</form>



	</div>



	<?php	

}