<?php
//	search_clases.php: Will allow the user to search for class groups 
// 9-17-2013
// Arthur Wuterich

// Get class data from PWApi
$classes = PWTask( 'get_classes' );

$classes = json_decode( $classes, true );

$classes_dropdown = '<select name="class1" id="select_copy">';

// Build the class select object
foreach( $classes as $class )
{
	$classes_dropdown .= "<option value=\"{$class[1]} {$class[2]}({$class[0]}), {$class[7]} {$class[8]}\">{$class[1]} {$class[2]}({$class[0]}), {$class[7]} {$class[8]}</option>";
}

$classes_dropdown .= '</select>';

?>

<script type="text/javascript">

// Copies the classes drop down menu and adds to document
var nextField = 2;
function AddField()
{
	// Copy the classes dropdown menu with options
	var options = $("#select_copy > option").clone();
	$('#select_copy').clone().attr({
		name: 'class'+(nextField++),
		id: ''
	}).append(options).fadeIn(500).insertBefore('#add').before("<BR/>");
}
</script>

<div id="course_form" class="rounded_window center_on_page large_window drop_shadow" >
<h1> Select Courses </h1>
	<form action="index.php" method="POST" >
		<?php echo $classes_dropdown; ?>
		<button type="button" name="add" id="add" onclick="AddField();">+</button>
		<BR />
		<button type="submit" name="goto" value="home.php">Back Home</button>
		<button type="submit" name="goto" value="calc_schecule.php">Calculate Schedule</button>
	</form>
</div>