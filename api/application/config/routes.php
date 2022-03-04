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

//Website
$route['default_controller'] 	= 	'welcome';
$route['404_override'] 			= 	'';
$route['translate_uri_dashes']  = 	FALSE;


$route['api-pack'] 					= 	'api/AuthController/pack';

$route['api/registration'] 			= 	'api/AuthController/registration';
$route['api/login'] 				= 	'api/LoginCotroller/login';

$route['api/buyPack'] 				= 	'api/ProfileController/buyPack';
$route['api/getprofile'] 			= 	'api/ProfileController/getprofile';


$route['api/pack'] 					= 	'api/ProfileController/checkUserPackage';

$route['api/userBuyPackList'] 		= 	'api/ProfileController/userBuyPackList';

$route['api/logout'] 				= 	'api/ProfileController/logout';

$route['api/deletePackageUser'] 	= 	'api/ProfileController/deletePackageUser';

$route['checkActiveUser'] 			= 	'api/RewardController/checkActiveUser';

$route['checkAndReward'] 			= 	'api/RewardController/checkAndReward';

$route['nftList'] 					= 	'api/ProfileController/nftList';
$route['buyNft'] 					= 	'api/ProfileController/buyNft';
$route['userNftList'] 					= 	'api/ProfileController/userNftList';

$route['ftList'] 					= 	'api/ProfileController/ftList';
$route['buyft'] 					= 	'api/ProfileController/buyft';
$route['userFtList'] 				= 	'api/ProfileController/userFtList';

$route['addTrading'] 				= 	'api/ProfileController/addTrading';
$route['trading_list'] 				= 	'api/ProfileController/tradingList';
$route['buyTrading'] 				= 	'api/ProfileController/buyTrading';

$route['sendTradeAmount'] 				= 	'api/ProfileController/sendTradeAmount';

$route['update_status'] 				= 	'api/ProfileController/update_status';
$route['user_inventory'] 				= 	'api/ProfileController/userInventory';
$route['marketplace'] 				= 	'api/ProfileController/marketplace';

$route['bid_item'] 				= 	'api/ProfileController/bid_item';


















