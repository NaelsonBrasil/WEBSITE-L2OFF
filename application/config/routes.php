<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/*private*/

// Controller Dashboard
$route['(:any)'] = 'admin/Main_controllers/index';
$route['admin/login'] = 'admin/Login_controllers/index';
$route['admin/register'] = 'admin/Register_controllers/index';
$route['admin/leave'] = 'admin/Main_controllers/leave';

//Menu
$route['admin/menu'] = 'admin/Menu_controller/index';
$route['admin/menu/announce'] = 'admin/Menu_controller/announcement';

//Gallery
$route['admin/gallery'] = 'admin/Gallery_controllers/index';
$route['admin/gallery/uploaded'] = 'admin/Gallery_controllers/upload';
$route['admin/gallery/deleted'] = 'admin/Gallery_controllers/delete';

//Notice
$route['admin/notice'] = 'admin/Notice_controllers/index';
$route['admin/notice/sent'] = 'admin/Notice_controllers/sentNotice';
$route['admin/notice/deleted'] = 'admin/Notice_controllers/delete';


// Controller AccountChange
$route['admin/account/password'] = 'admin/Account_controllers/password';
$route['admin/account/nickname'] = 'admin/Account_controllers/nickName';
$route['admin/account/unlock'] = 'admin/Account_controllers/unlockFunc';
$route['admin/account/email'] = 'admin/Account_controllers/changeEmail';

//Tools
$route['admin/tools/unlock'] = 'admin/Tools_controllers/unlockFunc';

//Report bug
$route['admin/report'] = 'admin/Report_controllers/index';
$route['admin/report/created'] = 'admin/Report_controllers/create';

//Live
$route['admin/live'] = 'admin/Live_controllers/index';
$route['admin/live/uploaded'] = 'admin/Live_controllers/upload';
$route['admin/live/deleted'] = 'admin/Live_controllers/delete';


//Store
$route['admin/cart'] = 'admin/Store_controllers/index';
$route['admin/add/item'] = 'admin/Store_controllers/addItem';
$route['admin/item/delete'] = 'admin/Store_controllers/delete';
$route['admin/order'] = 'admin/Store_controllers/order';
$route['admin/process'] = 'admin/Store_controllers/process';
$route['admin/donated'] = 'admin/Store_controllers/itemDonated';
$route['admin/completed'] = 'admin/Store_controllers/completed';
$route['admin/cancel'] = 'admin/Store_controllers/cancel';
$route['admin/redirection'] = 'admin/Store_controllers/redirection';  //paysecurity
$route['admin/notification'] = 'admin/Store_controllers/notification'; //paysecurity

/*Public*/
//Pagination Public
$route['notices/pag'] = "Home_controllers";
$route['notices/pag/(:num)'] = "Home_controllers";

$route['boss'] = "Boss_controllers";
$route['boss/pag'] = "Boss_controllers";
$route['boss/pag/(:num)'] = "Boss_controllers";
$route['contact'] = "Contact_controllers";
$route['info'] = "Info_controllers";
$route['download'] = "Download_controllers";
$route['test'] = "Test/index";


$route['default_controller'] = 'Home_controllers';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
