<?php
	if( isset( $_POST['submit'] ) )
	{
		// Do calculations
		echo 'hello!';
	}
?>

<html>
<head>
</head>
<body>
	<form name="test_form" method="post" action="a.php">
		<input type="submit" value="submit" />
	</form>
</body>
</html>