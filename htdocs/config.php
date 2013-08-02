<?php session_start();

/**
 * Holds constants/variables used in the configuration of the application.
 *
 * @author Kyle
 */

/**
 * These are the database connection details, change them as required.
 * Database dump stored in the "sql" folder of the project root
 *
 */
//localhost
define('DB_HOST',       'localhost');
define('DB_NAME',       'fishgate-profile-mailer');
define('DB_USERNAME',   'root');
define('DB_PASSWORD',   '');
define('DB_USER_TBL',   'users');
define('DB_LOGS_TBL',   'emaillogs');

/**
 * Set the project state here for error handling, saves the end user from 
 * getting exceptions thrown at them, set to true/false. Also handles some other things
 * 
 */
define('DEV', true);
define('DEV_EMAIL', 'kyle@fishgate.co.za, tyrone@fishgate.co.za');

/**
 * General pathing constants
 *
 */
$root = pathinfo($_SERVER['SCRIPT_FILENAME']);
define('BASE_FOLDER',   basename($root['dirname']));
define('SITE_ROOT',     realpath(dirname(__FILE__)));
define('SITE_URL',      'http://'.$_SERVER['HTTP_HOST'].'/'.BASE_FOLDER);
define('ERROR_LOG',     SITE_ROOT.'/logs/errors.txt');
define('TEMPLATE_DIR',  SITE_ROOT.'/templates/');

/**
 * Setup autoloader to initiate classes
 *
 */
function __autoload($className) {
    require_once "./classes/$className.php";
}

?>
