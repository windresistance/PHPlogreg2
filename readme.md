# Basic PHP login and registration add on

## Stack

 - MySQL
 - PHP 5.5 or higher
 - jQuery (for index page animations)

## How to use

1. Create database (refer to: create-db.sql)
2. Set globals in conf.php:
    - **DB_HOST**: database host, default: 'localhost'
    - **DB_USER**: database username, default: 'root'
    - **DB_PASS**: database password, default: ''
    - **LOGIN_PG**: page to redirect to on unsuccessful login/registration; default: 'index.php'
    - **SUCCESS_PG**: page to redirect to on successful login/registration; default: 'success.php'
3. Adjust user fields in process.php to desired fields and to match db fields (will probably need to search through process.php)
4. Adjust user inputs in index.php to match user fields in process.php (will probably need to search through index.php)
