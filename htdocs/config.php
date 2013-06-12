<?php
/**
 * Holds constants used in the configuration of the application.
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
 * General pathing constants
 *
 */
$root = pathinfo($_SERVER['SCRIPT_FILENAME']);
define('BASE_FOLDER',   basename($root['dirname']));
define('SITE_ROOT',     realpath(dirname(__FILE__)));
define('SITE_URL',      'http://'.$_SERVER['HTTP_HOST'].'/'.BASE_FOLDER);

/**
 * Setup autoloader to initiate classes
 *
 */
function __autoload($className) {
    require_once "./classes/$className.php";
}

?>
