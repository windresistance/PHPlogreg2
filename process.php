<?php
	session_start();
	
	//define constants for db_host, db_user, db_pass, and db_database
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_DATABASE', 'logpage');
	define('DB_USER_TABLE', 'users');
	
	define('LOGIN_PG', 'index.php');
	define('SUCCESS_PG', 'success.php');
	
		/* DEFAULT DATABASE FIELDS:
			id
			first_name
			last_name
			email
			password
			created_at
			updated_at
		*/
	
	if (isset($_POST['action'])) {
		// log user in
		if ($_POST['action'] == "login") {
			login_user($_POST);
		}
		// register user
		if ($_POST['action'] == "register") {
			register_user($_POST);
		}
	} else {
		// malicious navigation to process.php or someone is trying to log off
		session_destroy();
		header('location: ' . LOGIN_PG);
		die();
	}
	
	function login_user($post) {
		// validate email with password
		if (validate($post['email'], $post['password'])) {
 			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
			if ($stmt = $mysqli->prepare("SELECT id, first_name FROM " . DB_USER_TABLE . " WHERE email=?")) {
				$stmt->bind_param("s", $post['email']);  // bind variable(s) to the parameter as a string
				$stmt->execute();  // execute the statement
				$stmt->bind_result($id, $first_name);  // get the variables from the query
				$stmt->fetch();  // fetch the data
				$stmt->close();  // close the prepared statement
			}
			
			$_SESSION['user_id'] = $id;
			$_SESSION['first_name'] = $first_name;
			$_SESSION['logged_in'] = TRUE;
			$_SESSION['success_msg'] = 'signed in';
			
			header('location: ' . SUCCESS_PG);
			echo "success";
		} else {
			$_SESSION['errors'][] = 'Cannot find user with the given credentials!';
			$_SESSION['errtype'] = 'log';
			header('location: ' . LOGIN_PG);
			die();
		}
	}  /* end of login_user function */
	
	function register_user($post) {
		$_SESSION['errors'] = array();
		
		// verify first name field is not blank
 		if (empty($_POST['firstName'])) $_SESSION['errors'][] = 'First name cannot be blank.';
		// verify first name is valid
 		if (has_numbers($_POST['firstName'])) $_SESSION['errors'][] = 'Invalid first name.';
		
		// verify last name field is not blank
		if (empty($_POST['lastName'])) $_SESSION['errors'][] = 'Last name cannot be blank.';
		// verify last name is valid
		if (has_numbers($_POST['lastName'])) $_SESSION['errors'][] = 'Invalid last name.';
		
		// verify email is valid
		if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) $_SESSION['errors'][] = 'Invalid email entered.';
		// verify email is not already taken
		if (check_user_exists($_POST)) $_SESSION['errors'][] = 'User with email \'' . $_POST['email'] . '\' already exists.';
		
		// verify password field is not blank
		if (empty($_POST['password'])) $_SESSION['errors'][] = 'Password cannot be blank.';
		// verify password is at least 6 chars
		if (strlen($_POST['password']) <= 6) $_SESSION['errors'][] = 'Password must be longer than 6 characters.';
		
		// verify password confirmation field in not blank
		if (empty($_POST['confirmPassword'])) $_SESSION['errors'][] = 'Password confirmation cannot be blank.';
		// verify password confirmation matches password
		if ($_POST['confirmPassword'] != $_POST['password']) $_SESSION['errors'][] = 'Passwords do not match.';
		
		// check for errors
		if (empty($_SESSION['errors'])) {
			// no errors exist in user input data
			
			$first_name = $_POST['firstName'];  // get data from post
			$last_name = $_POST['lastName'];  // get data from post
			$email = $_POST['email'];  // get data from post
			$password = encrypt($_POST['password']);  // encrypt password
			
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
			if ($stmt = $mysqli->prepare("INSERT INTO " . DB_USER_TABLE . " (first_name, last_name, email, password, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())")) {
				$stmt->bind_param("ssss", $first_name, $last_name, $email, $password);  // bind variables
				$stmt->execute();  // execute statement
				$userid = $stmt->insert_id;  // catch the newly generated user ID
				$stmt->close();  // close the prepared statement
			}
			
			$_SESSION['user_id'] = $userid;
			$_SESSION['first_name'] = $first_name;
			$_SESSION['logged_in'] = TRUE;
			$_SESSION['success_msg'] = 'registered';
			
			header('location: ' . SUCCESS_PG);
			die();
		} else {
			// errors exist; redirect to index.php
			$_SESSION['errtype'] = 'reg';
			header('location: ' . LOGIN_PG);
			die();
		}
	}  /* end of register_user function */
	
	// check if a user already exists in the database
	function check_user_exists($post) {
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		if ($stmt = $mysqli->prepare("SELECT COUNT('id') AS id FROM " . DB_USER_TABLE . " WHERE email=?")) {
			$stmt->bind_param("s", $post['email']);  // bind variable(s) to the parameter as a string
			$stmt->execute();  // execute the statement
			$stmt->bind_result($id);  // get the variables from the query
			$stmt->fetch();  // fetch the data
			$stmt->close();  // close the prepared statement
		}
		
		return $id;
	}
	
	// check if a given string contains any numbers
	function has_numbers($str) {
		$hasNum = false;
		$strArray = str_split($str);
		foreach ($strArray as $char) {
			if (is_numeric($char)) {
				$hasNum = true;
			}
		}
		return $hasNum;
	}
	
	// encrypt password
	function encrypt($pw_in) {
		$hash = password_hash($pw_in, PASSWORD_DEFAULT);
		return $hash;
	}

	// validate email with password
	function validate($email, $pw_in) {
	 	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
		if ($stmt = $mysqli->prepare("SELECT password AS pw FROM " . DB_USER_TABLE . " WHERE email=?")) {
			$stmt->bind_param("s", $email);  // bind variable(s) to the parameter as a string
			$stmt->execute();  // execute the statement
			$stmt->bind_result($pw);  // get the variables from the query
			$stmt->fetch();  // fetch the data
			$stmt->close();  // close the prepared statement
		}
		$hash = $pw;
		return crypt($pw_in, $hash) == $hash ? 1 : 0;
	}
?>