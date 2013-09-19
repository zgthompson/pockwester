<?php
// login.php: Asks the user for login information and attempts to log them in through Pwapi
// 9-17-13
// Arthur Wuterich

	if( $_POST['goto'] == 'login.php' && isset( $_POST['username'] ) && isset( $_POST['password'] ) )
	{
		$response = PWTask( 'login_user', $_POST );
					
		if( $response == '1' )
		{
			$login = true;
			$_SESSION['USER'] = $_POST['username'];
			unset($_POST);
		}
	}

	// If the user was successful in logging in redirect
	if( $login ){
?>
<script type="text/javascript">
	//BouncePage( 2 );
</script>
<div id="login_window" class="rounded_window center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	<h2> Logged in! </h2>
	<form action="index.php" method="POST">
		<button type="submit" name="goto" value="home.php">Continue</button>
	</form>
</div>
<?php exit();} ?>

<div id="login_window" class="rounded_window center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	<form action="index.php" method="POST">
		<label for="username">Username</label>
		<input type="textfield" name="username" value="<?php echo $_POST['username'];?>"><BR/>
		<label for="password">Password</label>
		<input type="password" name="password"><BR/>
		<button type="submit" name="goto" value="login.php">Login</button>
		<button type="submit" name="goto" value="new_user.php">New User</button>
		<button type="submit" name="goto" value="help_user.php">Forgot Password</button>
	</form>
</div>
