<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'pageloader';
$route['location/(:num)'] = 'data/locationdata/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['locationoncklick'] = 'data/clicklocation';
