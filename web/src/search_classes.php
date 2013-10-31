<?php
//	search_clases.php: Will allow the user to search for class groups 
// 9-17-2013
// Arthur Wuterich

// Get class data from PWApi
$classes = PWTask( 'grab_courses' );

$classes = json_decode( $classes, true );
$classes = $classes['courses'];

$classes_dropdown = '<select name="class[]" id="select_copy">';

// Build the class select object
foreach( $classes as $class )
{
	/* $classes_dropdown .= "<option value=\"{$class['id']} {$class[2]}({$class[0]}), {$class[7]} {$class[8]}\">{$class[1]} {$class[2]}({$class[0]}), {$class[7]} {$class[8]}</option>"; */
	$classes_dropdown .= "<option value=\"{$class['id']},{$class['subject']},{$class['catalog_no']}\">{$class['subject']} {$class['catalog_no']}</option>";
}

$classes_dropdown .= '</select>';

?>

<script type="text/javascript">

// Copies the classes drop down menu and adds to document
function AddField()
{
	// Copy the classes dropdown menu with options
	var options = $("#select_copy > option").clone();
	$('#select_copy').clone().attr({
		name: 'class[]',
		id: ''
	}).append(options).fadeIn(500).insertBefore('#add').before("<BR/>");
}
</script>

<div id="course_form" class="window_background center_on_page large_window drop_shadow search_classes" >
<div class="search_classes_left_align" >
	<h1> Select Courses </h1>
		<form  method="POST" >
			<?php echo $classes_dropdown; ?>
			<button type="button" name="add" id="add" class="add" onclick="AddField();">+</button>
</div>			
			<BR />
			<button type="submit" name="goto" value="home.php">Back</button>
			<button type="submit" name="goto" value="sections.php">Continue</button>
		</form>
</div>