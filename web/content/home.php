<?php
// home.php: Landing page for entering the pw web client
// 9-17-13
// Arthur Wuterich
$post = array( 'user_id' => "{$_SESSION['USER_ID']},{$_SESSION['USER_ID_BETA']}");
$user_info = json_decode( PWTask( 'get_user_overview', $post ) );

// print_r( $user_info );


?>
<div id="login_window" class="window_background center_on_page small_window drop_shadow home">
	<h1> Home </h1>
	<form method="POST">
		<div class="large_table">
			<div class="large_table_row">
				<div class="large_table_cell">
					<button class="home_manage_button" type="submit" onclick="GotoPage( this, '/manage_groups/' );">Manage Study Groups</button>
				</div>
			</div>
			<div class="large_table_row">
				<div class="large_table_cell">
					<button class="home_manage_button" type="submit" onclick="GotoPage( this, '/classes/' );">Manage Classes</button>
				</div>
			</div>
			<div class="large_table_row">
				<div class="large_table_cell">
					<button class="home_manage_button" type="submit" onclick="GotoPage( this, '/manage_availability/' );">Manage Availability</button>
				</div>
			</div>
		</div>
	</form>
</div>
