<?php
// account.php: Allows the user to manage their account
// 9-17-13
// Arthur Wuterich

$message = '';
$save_settings = false;

// Theme changes
if( $_POST['this'] === 'account_save_settings' )
{
	// If the desired theme is empty unset the theme and work with the default
	if( $_POST['account_theme_change'] === '' )
	{
		unset( $_SESSION['THEME'] );
	}
	else
	{
		$_SESSION['THEME'] = $_POST['account_theme_change'];
	}
		$save_settings = true;

}

if( $save_settings ){
?>
<script type="text/javascript">
	BouncePage( <?php echo BOUNCE_QUICK; ?> );
</script>
<div id="login_window" class="window_background center_on_page small_window drop_shadow">
	<h1> Account </h1>
	<?php echo Message( 'Saving Settings...' ); ?>
</div>

<?php exit(); } ?>
<div id="login_window" class="window_background center_on_page small_window drop_shadow">
	<h1> Account </h1>
	<form method="POST">
		<h2>Set Theme</h2>
		<select name="account_theme_change" >
			<option value="">Standard</option>
			<option value="pw.mel.css">Mel</option>
		</select>
		<BR/>
		<button type="submit" name="this" value="account_save_settings">Save Settings</button>
		<button type="submit" name="goto" value="home.php">Back</button>
	</form>
</div>
