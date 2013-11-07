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
	else if( $_POST['account_theme_change'] !== $_SESSION['THEME'] )
	{
		$_SESSION['THEME'] = $_POST['account_theme_change'];
		
		// Save the theme information in the database
		$post = array( 	'user_id' 	=> $_SESSION['USER_ID'],
						'field'		=> 'THEME',
						'value'		=> $_SESSION['THEME'] );
		PWTask( 'set_user_config', $post );
	}
	
	$save_settings = true;
}

$themes = GetThemeArray( scandir( 'theme/' ) );

if( $save_settings ){
?>
<script type="text/javascript">
	BouncePage( <?php echo BOUNCE_QUICK; ?>, '' );
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
			<?php echo GetOption( $_SESSION['THEME'], GetThemeName() ); ?>
			<option value="">Standard</option>
			<?php foreach( $themes as $theme ){ if($_SESSION['THEME'] === $theme){continue;}echo GetOption( $theme, GetThemeName( $theme ) );} ?>
		</select>
		<BR/>
		<button type="submit" name="this" value="account_save_settings">Save Settings</button>
		<button type="submit" onclick="Back( this );">Back</button>
	</form>
</div>
