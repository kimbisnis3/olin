<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'landingpage';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['panel/(:any)'] = 'admin/$1';