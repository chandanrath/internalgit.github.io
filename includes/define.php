<?php//echo"host==".$_SERVER['HTTP_HOST'];
define("PROJECT_TITLE", "Mail Send" );
define('HTTP_SERVER', 'https://'.$_SERVER['HTTP_HOST'].'/bni/dashboard.php');
date_default_timezone_set('Asia/Calcutta');
define('DB_HOST_PORT', '21');
define("WRONG_USER_NAME","Invalid Login Credentials.");
define('_PREFIX', 'ri_');
define('ADMIN_PATH', 'https://'.$_SERVER['HTTP_HOST'].'/bni/dashboard.php?action=');
define('IMG_PATH', 'https://'.$_SERVER['HTTP_HOST'].'/bni/images/profile/');
define('BASE_URL', 'https://'.$_SERVER['HTTP_HOST'].'/bni/');
define('RECORDS_PER_PAGE', '50');

define('REFERENCE_PERIOD_DAYS', 10);

define('STATUS_DRAFT', 0);

define('STATUS_ACTIVE', 1);

define('STATUS_DEACTIVE', 3);

define('STATUS_EXPIRED', 2);

define('STATUS_PENDING', 7);

define('SOURCE1_DEFAULT', 0);

define('SOURCE1_CONTENT', 1);

define('SOURCE2_IMAGE', 0);

define('SOURCE2_CONTENT', 1);

define('ABSPATH', dirname(dirname(__FILE__)));

define('MOBILE_AUTH', '235062A3lNWJTtD5b8a7030');





?>