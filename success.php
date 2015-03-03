<?php
	session_start();
	
	if (!isset($_SESSION['logged_in'])) header('location: index.php');
?>
<!doctype>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Log/Reg Template</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<div id="container">
		<p><a href="process.php">LOG OFF</a></p>
		<?php if (isset($_SESSION['success_msg'])) { ?>
			<p class='successMsg'>Welcome, <?= $_SESSION['first_name']; ?> (id <?= $_SESSION['user_id']; ?>)!</p>
			<p class='successMsg'>You are successfully <?= $_SESSION['success_msg'] ?>!</p>
		<?php } ?>
		<?php unset($_SESSION['success_msg']); ?>
	</div>
</body>
</html>