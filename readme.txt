Basic Login and Registration Template
with password encryption

Created by Nick Jones
2 March 2015

This is a template for user authentication with login and registration built for a PHP/MySQL framework.

This page uses PHP password_hash method (>= PHP 5.5) for password encrytion and MySQL prepare statements to prevent SQL injection.

Dependencies are:
 - MySQL database
 - PHP 5.5 (for password_hash)
 - jQuery 2.1.1 (included) (for index page animations)

---------------
Instructions

1. Add this page to any existing PHP/MySQL site as landing page or as desired
2. Create database table
	a. Create table; default name: 'users'
	b. Create table fields; defaults ('*' required fields for authentication): 
		-* 'id' (INT(11), PRIMARY_KEY, AUTO_INCREMENT), 
		- 'first_name' (VARCHAR(45)), 
		- 'last_name' (VARCHAR(45)), 
		-* 'email' (VARCHAR(45)), 
		-* 'password' (VARCHAR(255)),  // recommended as VARCHAR(255)
		- 'created_at' (DATETIME), 
		- 'updated_at' (DATETIME)
3. Rename global variables in process.php:
	a. DB_HOST		database host; default: 'localhost'
	b. DB_USER		database username; default: 'root'
	c. DB_PASS		database password; default: ''
	d. LOGIN_PG		rename page to redirect to on unsuccessful login/registration; default: 'index.php'
	e. SUCCESS_PG	rename page to redirect to on successful login/registration; default: 'success.php'
4. Adjust user fields in process.php to desired fields and to reflect database fields (will need to search through process.php)
5. Adjust user inputs in index.php to reflect user fields in process.php (will need to search through index.php)