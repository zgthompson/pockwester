<?php
// login.php: Asks the user for login information and attempts to log them in through Pwapi
// 9-17-13
// Arthur Wuterich

	if( $_POST['this'] == 'login.php' && isset( $_POST['login_username'] ) && isset( $_POST['login_password'] ) )
	{
		$_POST['this'] = '';
		
		if( isset( $_POST['login_username'] ) && isset( $_POST['login_password'] ) )
		{
			$post = array( 'username' => $_POST['login_username'], 'password' => $_POST['login_password'] );
			$response = PWTask( 'login_user', $post );
			
			// If the response is >=1 then this is the users userid
			if( intval($response) >= 1 )
			{
				$login = true;
				$_SESSION['USER'] = ucwords(strtolower($_POST['login_username']));
				$_SESSION['USER_ID'] = intval($response);
				$_SESSION['CURRENT_PAGE'] = DEFAULT_CONTENT;
			}
			else
			{
				$error = $response;
			}
		}
		else
		{
			unset( $_POST['login_username'] );
			unset( $_POST['login_password'] );
		}
	}

	// If the user was successful in logging in redirect
	if( $login ){
?>
<script type="text/javascript">
	BouncePage( <?php echo BOUNCE_QUICK; ?> );
</script>
<div id="login_window" class="window_background center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	<h2> Logged in! </h2>
	<form  method="POST">
		<button type="submit" name="goto" value="home.php">Continue</button>
	</form>
</div>
<?php exit();} ?>

<div id="login_window" class="window_background center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	<form  method="POST" id="login_form">
		<?php echo Error( $error ); ?>
		<label for="login_username">Username</label>
		<input type="textfield" name="login_username" value="<?php echo $_POST['login_username'];?>"><BR/>
		<label for="login_password">Password</label>
		<input type="password" name="login_password"><BR/>
		<button type="submit" name="this" value="login.php">Login</button>
		<button type="submit" name="goto" value="new_user.php">New User</button>
		<button type="submit" name="goto" value="help_user.php">Forgot Password</button>
	</form>
</div>
