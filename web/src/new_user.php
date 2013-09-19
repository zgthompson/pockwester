<?php
// home.php: Landing page for entering the pw web client
// 9-17-13
// Arthur Wuterich

	// Check the data for garbage
	if( MeetsStandards( $_POST['username'], $_POST['email'], $_POST['password'] ) )
	{
		// The user was created successfully
		if( PWTask( $_POST['apitask'], $_POST ) == '1' )
		{
			$_SESSION['CURRENT_PAGE'] = LOGIN_PAGE;
			unset($_POST);
			$create = true;
		}
	}


	// Show redirect screen if the login was successful
if( $create ){
?>
<div id="login_window" class="rounded_window center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	User created, Login
	<form action="index.php" method="POST">
		<button type="submit" name="goto" value="login.php">Login</button>
	</form>
</div>
<?php exit();} 
// Display user create form
?>
<div id="login_window" class="rounded_window center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	Create User
	<form action="index.php" method="POST">
		<label for="username">Username</label>
		<input type="textfield" name="username" value="<?php echo $_POST['username']; ?>"><BR/>
		<label for="email">Email</label>
		<input type="textfield" name="email" value="<?php echo $_POST['email']; ?>"><BR/>
		<label for="password">Password</label>
		<input type="password" name="password" ><BR/>
		<button type="submit" name="goto" value="login.php">Back</button>
		<button type="submit" name="apitask" value="user_create">Create</button>
	</form>
</div>
