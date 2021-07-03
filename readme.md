#Basic PHP login and registration add on

###Stack

 - MySQL
 - PHP 5.5 or higher
 - jQuery (for index page animations)

---------------
How to use

1. Create database table
	a. Create table; default name: 'users'
	b. Create table fields; defaults ('*' required fields for authentication): 
		- 'id' (INT(11), PRIMARY_KEY, AUTO_INCREMENT), 
		- 'first_name' (VARCHAR(45)), 
		- 'last_name' (VARCHAR(45)), 
		- 'email' (VARCHAR(45)), 
		- 'password' (VARCHAR(255)),
		- 'created_at' (DATETIME), 
		- 'updated_at' (DATETIME)
2. Rename global variables in process.php:
	a. DB_HOST		db host, default: 'localhost'
	b. DB_USER		db username, default: 'root'
	c. DB_PASS		db password, default: ''
	d. LOGIN_PG		rename page to redirect to on unsuccessful login/registration; default: 'index.php'
	e. SUCCESS_PG	rename page to redirect to on successful login/registration; default: 'success.php'
3. Adjust user fields in process.php to desired fields and to reflect db fields (will need to search through process.php)
4. Adjust user inputs in index.php to reflect user fields in process.php (will need to search through index.php)
