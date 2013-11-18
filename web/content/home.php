<?php
// home.php: Landing page for entering the pw web client
// 9-17-13
// Arthur Wuterich

if( isset($_POST['lfg'] ) )
{
	$post = array( 'student_id' => $_SESSION['USER_ID'], 'instance_id' => $_POST['course_instance_id'], 'flag' => 'y' );
	echo PWTask( 'set_lfg_flag', $post );
}


$post = array( 'user_id' => $_SESSION['USER_ID'] );
$user_info = json_decode( PWTask( 'get_user_overview', $post ) );

// Get info to display
$groups = json_decode( $user_info->groups );
$classes = json_decode( $user_info->classes );
$classes = $classes->instances;
$time_string = $user_info->time_string;

// Process the information
$groupsHtml = '';
$groupLimit = 5; // Limit the number of displayed groups

$classesHtml = '';
$classLimit = 5;

$timestringHtml = '';

// Groups
/*
$addedGroups = 0;
foreach( $groups as $group )
{
	$groupsHtml .= 
	"
		<div class=\"home_group_block\">
			{$group[0]}
		</div>
		
	";
	
	$addedGroups++;
	if( $addedGroups >= $groupLimit )
	{
		break;
	}
}
*/
if( $groupsHtml == '' )
{
	$groupsHtml = "You have no study groups";
}


// Classes
// Don't duplicate class names
$addedClasses = 0;
foreach( $classes as $class )
{
	$classesHtml .= "<div class=\"home_class_block\">{$class->title}<BR/>{$class->time}
						<div class=\"lfg_button\">
							<form method=\"post\" style=\"background-color:transparent;\">
								<input type=\"hidden\" name=\"course_instance_id\" value=\"{$class->course_instance_id}\" >
								<button class=\"start_lfg_button\" name=\"lfg\" value=\"true\">Start Looking For Group</button>
							</form>
						</div>
					</div>";
	
	$addedClasses++;
	if( $addedClasses >= $classLimit )
	{
		break;
	}	
	
}

if( $classesHtml == '' )
{
	$classesHtml = "You have no classes";
}

// Time String
for( $i = 0; $i < 16 ; $i++ )
{
	// Set css classes based on the availability
	$class = '';
	
	switch( $time_string[$i] )
	{
		case '0':
			$class .= 'home_time_unavailable';
		break;
		
		case '1':
			$class .= 'home_time_empty';
		break;
		
		case '2':
			$class .= 'home_time_available';
		break;		
	}
	
	$time = $i + 8;
	$timestringHtml .= "<div class=\"{$class}\">{$time}</div>";	
}

?>
<div id="login_window" class="window_background center_on_page small_window drop_shadow home">
	<h1> Home </h1>
	<form method="POST">
		<div id="home_info_table" class="large_table">
			<div class="large_table_row">
				<div class="large_table_cell">
					<div class="home_group_title">
						Upcoming Groups
					</div>
					<div class="home_group_wrapper">
						<?php echo $groupsHtml; ?>
					</div>
					<button class="home_manage_button" type="submit" onclick="GotoPage( this, '/manage_groups/' );">Manage Study Groups</button>
				</div>
			</div>
			<div class="large_table_row">
				<div class="large_table_cell">
					<div class="home_class_title">
						Upcoming Classes
					</div>
					<div class="home_class_wrapper">
						<?php echo $classesHtml; ?>	
					</div>
					<button class="home_manage_button" type="submit" onclick="GotoPage( this, '/classes/' );">Manage Classes</button>
				</div>
			</div>
			<div class="large_table_row">
				<div class="large_table_cell">
					<div class="home_time_title">
						<?php echo date('l'); ?>
					</div>
					<div class="home_time_wrapper">				
						<?php echo $timestringHtml; ?>
					</div>
					<button class="home_manage_button" type="submit" onclick="GotoPage( this, '/manage_availability/' );">Manage Availability</button>
				</div>
			</div>
		</div>
	</form>
</div>
