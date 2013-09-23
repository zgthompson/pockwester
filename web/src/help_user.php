<?php
// home.php: Landing page for entering the pw web client
// 9-17-13
// Arthur Wuterich

// Email the user the password 

$sent_mail = false;

// If we have the email and the user clicked the submit button
if( $_POST['this'] == 'email_password' && isset( $_POST['help_email'] ) )
{
	$post = array( 'user_email' => $_POST['help_email'] );
	
	// If the user account is found then send the amail
	if( ( $user = PWTask( 'get_user_details', $post ) ) != '-1' )
	{
		$user = json_decode( $user );
		
		// Ugly php email code
		$to      = "{$user[1]}";
		$subject = 'Pockwester: Reset Password Request';
		$message = 
		"Hi {$user[0]}:
		
		Password Recovery System";
		$headers = 'From: noreply@pw.arthurwut.com' . "\r\n" .
			'Reply-To: noreply@pw.arthurwut.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
		
		$sent_mail = true;
		$_SESSION['CURRENT_PAGE'] = DEFAULT_CONTENT;
		
	}
	else
	{
		$error = 'Could not find user';
	}
}

if( $sent_mail ) {
?>
<script type="text/javascript">
	BouncePage( <?php echo BOUNCE_NORMAL; ?> );
</script>
<div id="login_window" class="window_background center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	<div class="green_box">Sent email on how to reset your password</div>
	<form  method="POST">
	</form>
</div>
<?php exit(); } ?>
<div id="login_window" class="window_background center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	<h2> Whats the email for the account? </h2>
	<?php echo Error( $error ); ?>	
	<form  method="POST">
		<input type="textfield" name="help_email"><BR/>
		<button type="submit" name="goto" value="login.php">Back</button>
		<button type="submit" name="this" value="email_password">Submit</button>
	</form>
</div>
