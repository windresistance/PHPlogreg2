<?php session_start(); ?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Log/Reg Template</title>
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<script type="text/javascript">
		$(document).ready(function(){
			// function to remember which form was being attempted and re-render appropriately
			(function(){
				$('#logForm').hide();
				$('#regForm').hide();
				$("#<?= isset($_SESSION['errtype']) ? $_SESSION['errtype'] : 'log'; ?>Form").show();
			})();
			
			// hide 
			$('.formSwitchBtn').click(function(){
				$('.errors').css('display','none');
			});
		})
	</script>
	
	<div id="container">
		<div class="errors">
			<?php  // get error messages from session if they exist
				if (isset($_SESSION['errors'])) {
					foreach ($_SESSION['errors'] as $error) {
						echo "<p class='errorMsg'>{$error}</p>";
					}
					unset($_SESSION['errors']);
				}
				if (isset($_SESSION['errtype'])) unset($_SESSION['errtype']);
			?>
		</div>
		
		<!-- user login form -->
		<form id="logForm" action="process.php" method="post">
			<h2>User Login</h2>
			<input type="hidden" name="action" value="login">
			<input type="text" name="email" placeholder="Email" autocomplete="off" autofocus>
			<input type="password" name="password" placeholder="Password" autocomplete="off">
			<input type="submit" value="Login">
			<a href="#" id="regBtn" class="formSwitchBtn">or register...</a>
		</form>
		
		<!-- user registration form -->
		<form id="regForm" action="process.php" method="post">
			<h2>User Registration</h2>
			<input type="hidden" name="action" value="register">
			<input type="text" name="firstName" placeholder="First name" autocomplete="off">
			<input type="text" name="lastName" placeholder="Last name" autocomplete="off">
			<input type="text" name="email" placeholder="Email" autocomplete="off">
			<input type="password" name="password" placeholder="Password" autocomplete="off">
			<input type="password" name="confirmPassword" placeholder="Password confirm" autocomplete="off">
			<input type="submit" value="Register">
			<a href="#" id="logBtn" class="formSwitchBtn">or sign in...</a>
		</form>
	</div>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#regBtn').click(function(){
				$('#logForm').slideUp();
				$('#regForm').slideDown();
			})
			$('#logBtn').click(function(){
				$('#regForm').slideUp();
				$('#logForm').slideDown();
			})
		})
	</script>
</body>
</html>
