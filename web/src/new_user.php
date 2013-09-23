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
			// Sends user_create command to the PWApi, if the return is 1 then the user was created suscessfully
			$post = array( 	'username' => $_POST['new_username'],
							'password' => $_POST['new_password'],
							'email' => $_POST['new_email'] 		 );
			if( ( $error = PWTask( 'user_create', $post ) ) == '1' )
			{	
				$_SESSION['CURRENT_PAGE'] = LOGIN_PAGE;
				$create = true;
			}
		}
	}

	// Show redirect screen if the login was successful
if( $create ){
?>
<script type="text/javascript">
	BouncePage( <?php echo BOUNCE_QUICK; ?> );
</script>
<div id="login_window" class="rounded_window center_on_page small_window drop_shadow">
	<h1> New User </h1>
	<div class="green_box">User created!</div>
	<form action="index.php" method="POST">
		<button type="submit" name="goto" value="login.php">Login</button>
	</form>
</div>
<?php exit();} 
// Display user create form
?>
<div id="login_window" class="rounded_window center_on_page small_window drop_shadow">
	<h1> New User </h1>
	<form action="index.php" method="POST">
		<?php echo Error( $error ); ?>
		<label for="new_username">Username</label>
		<input type="textfield" name="new_username" value="<?php echo $_POST['new_username']; ?>"><BR/>
		<label for="new_email">Email</label>
		<input type="textfield" name="new_email" value="<?php echo $_POST['new_email']; ?>"><BR/>
		<label for="new_password">Password</label>
		<input type="password" name="new_password" ><BR/>
		<button type="submit" name="goto" value="login.php">Back</button>
		<button type="submit" name="this" value="user_create">Create</button>		
	</form>
</div>
