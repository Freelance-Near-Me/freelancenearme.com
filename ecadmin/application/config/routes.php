<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "dashboard";
//$route['default_controller'] = "ckeditor";
$route['login'] = "login";
$route['logout'] = "login/logout";
$route['login/loginprocess'] = "login/loginprocess";
$route['forgotpass/check'] = "login/forgotpass";
$route['forgotpass'] = "login/forgotpass/index";

$route['menulist'] = "adminmenu";
$route['addnewmenu'] = "adminmenu/add";
$route['editmenu/(:num)'] = "adminmenu/edit/$1";
$route['404_override'] = '';
//$route['(:any)'] = 'user';
$route['(:num)'] = 'user';
 
 //print_r($route); die();

/* End of file routes.php */
/* Location: ./application/config/routes.php */