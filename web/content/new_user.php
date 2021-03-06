<?php
// new_user.php: Allows users to create new accounts
// 9-19-13
// Arthur Wuterich

	$error = "";

	if( $_POST['this'] == 'user_create' )
	{
		// Check the user submitted parameters meet the standards for the database 
		if( ( $error = MeetsUserStandard( $_POST['new_username'], $_POST['new_email'], $_POST['new_password'] )) == '1' )
		{
			// Sends user_create command to the PWApi, if the return is numeric then that is the users USER_ID and the user was created suscessfully
			$post = array( 	'username' => $_POST['new_username'],
							'password' => $_POST['new_password'],
							'email' => $_POST['new_email'] 		 );
			if( is_numeric( $error = PWTask( 'create_student', $post ) ) )
			{	
				$create = true;
			}
		}
	}

	// Show redirect screen if the login was successful
if( $create ){
?>
<script type="text/javascript">
	BouncePage( <?php echo BOUNCE_QUICK; ?>, '/login/' );
</script>
<div id="login_window" class="window_background center_on_page small_window drop_shadow">
	<h1> New User </h1>
	<div class="green_box">User created!</div>
	<form  method="POST">
		<button type="submit" onclick="GotoPage( this, '/login/' );">Login</button>
	</form>
</div>
<?php exit();} 
// Display user create form
?>
<div id="login_window" class="window_background center_on_page small_window drop_shadow new_user">
	<h1> New User </h1>
	<form  method="POST">
		<?php echo Message( $error, 'error_box' ); ?>
		<label for="new_username">Username</label>
		<input type="textfield" name="new_username" value="<?php echo $_POST['new_username']; ?>"><BR/>
		<label for="new_email">Email</label>
		<input type="textfield" name="new_email" value="<?php echo $_POST['new_email']; ?>"><BR/>
		<label for="new_password">Password</label>
		<input type="password" name="new_password" ><BR/>
		<button type="submit" onclick="GotoPage( this, '/login/' );>Back</button>
		<button type="submit" name="this" value="user_create">Create</button>		
	</form>
</div>
