<?php
// home.php: Landing page for entering the pw web client
// 9-17-13
// Arthur Wuterich

// Email the user the password 

$sent_mail = false;

if( $_POST['this'] == 'email_password' && isset( $_POST['help_email'] ) )
{
	$post = array( 'user_email' => $_POST['help_email'] );
	
	if( ( $user = PWTask( 'get_user_details', $post ) ) != '-1' )
	{
		$user = json_decode( $user );
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
<div id="login_window" class="rounded_window center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	<div class="green_box">Email sent!</div>
	<form action="index.php" method="POST">
	</form>
</div>
<?php exit(); } ?>
<div id="login_window" class="rounded_window center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	<h2> I'll email your password... </h2>
	<?php echo Error( $error ); ?>	
	<form action="index.php" method="POST">
		<label for="email">Email</label>
		<input type="textfield" name="help_email"><BR/>
		<button type="submit" name="goto" value="login.php">Back</button>
		<button type="submit" name="this" value="email_password">Send It</button>
	</form>
</div>
