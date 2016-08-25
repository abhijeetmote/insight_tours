<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);
define('DRIVER_TABLE', 'driver_master');
define('VENDOR_TABLE', 'vendors_master');
define('LEDGER_TABLE', 'ledger_master');
define('BOOKING_TABLE', 'booking_master');
define('PASSENGER_TABLE', 'passenger_details');
define('REPORT_HEAD_INCOME', 'income');
define('REPORT_HEAD_EXPENSE', 'expense');
define('DRIVER_CONTEXT', 'driver');
define('VENDOR_CONTEXT', 'vendor');
define('LEDGER_ENTITY', 'ledger');
define('GROUP_ENTITY', 'group');
define('REPORTING_HEAD', 'profit and loss');
define('CR', 'cr');
define('DR', 'dr');
define('FILE_UPLOAD', 'images/user_profile/');
define("ENTITY_TYPE_LEDGER", "ledger");
define("ENTITY_TYPE_GROUP", "group");
define("ENTITY_TYPE_MAIN", "main");
define("ACC_TYPE_BANK", "bank");
define("ACC_TYPE_CASH", "cash");
define('GROUP_CHILDREN_OPTION_DIS', 'displaychildrenoptionsinselbox');

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */