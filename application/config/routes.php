<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['login']['post'] = 'welcome/login';
$route['protected']= 'welcome/protected_function';
$route['another']= 'welcome/another_protected';
$route['unprotected'] = 'welcome/unprotected';