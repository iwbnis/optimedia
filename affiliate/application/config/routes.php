<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['404_override'] = 'admincontrol/page_404';

$route['default_controller'] = "AuthController/user_index";

$route['affiliate'] = "AuthController/user_index";

$route['admin'] = "AuthController/admin_login";

$route['store'] = "store/index";

$route['store/mini_cart'] = "store/mini_cart";
$route['store/checkout_shipping'] = "store/checkout_shipping";
$route['store/checkout_shipping/(:num)'] = "store/checkout_shipping/$1";
$route['store/checkout_confirm'] = "store/checkout_confirm";
$route['store/payment_confirmation'] = "store/payment_confirmation";
$route['store/getState'] = "store/getState";
$route['store/checkout-cart'] = "store/checkoutCart";
$route['store/about'] = "store/about";
$route['store/profile'] = "store/profile";
$route['store/order'] = "store/order";
$route['store/wishlist'] = "store/wishlist";
$route['store/login'] = "store/login";
$route['store/forgot'] = "store/forgot";
$route['store/vieworder/(:any)'] = "store/vieworder/$1";
$route['store/shipping'] = "store/shipping";
$route['store/logout'] = "store/logout";
$route['store/contact'] = "store/contact";
$route['store/policy'] = "store/policy";
$route['store/cart'] = "store/cart";
$route['store/toggle_wishlist'] = "store/toggle_wishlist";
$route['store/page/(:any)'] = "store/page/$1";
$route['store/payment_gateway/(:any)/(:any)'] = "store/paymentGateway/$1/$2";
$route['store/payment_gateway/(:any)/(:any)/(:any)'] = "store/paymentGateway/$1/$2/$3";
$route['store/payment_gateway/(:any)/(:any)/(:any)/(:any)'] = "store/paymentGateway/$1/$2/$3/$4";
$route['store/checkout'] = "store/checkout";
$route['store/get_payment_mothods'] = "store/get_payment_mothods";
$route['store/ajax_login'] = "store/ajax_login";
$route['store/add_coupon'] = "store/add_coupon";
$route['store/add_to_cart'] = "store/add_to_cart";
$route['store/thankyou/(:any)'] = "store/thankyou/$1";
$route['store/confirm_payment'] = "store/confirm_payment";
$route['store/confirm_order'] = "store/confirm_order";
$route['store/ajax_register'] = "store/ajax_register";
$route['store/(:any)/product/(:any)'] = "store/product/$1/$2";
$route['store/product/(:any)'] = "store/product/$1/$2";
$route['store/category'] = "store/category";
$route['store/category/(:any)'] = "store/category/$1";
$route['store/change_language/(:any)'] = "store/change_language/$1";
$route['store/change_currency/(:any)'] = "store/change_currency/$1";
$route['store/(:any)'] = "store/index/$1";
$route['store/(:any)/(:any)'] = "store/index/$2/$1";

$route['product/views/(:any)/(:any)'] = "product/views/$1/$2";
$route['product/clicks/(:any)/(:any)'] = "product/clicks/$1/$2";
$route['product/thankyou/(:any)'] = "product/thankyou/$1";
$route['product/payment/(:any)/(:any)'] = "product/payment/$1/$2";
$route['product/(:any)/(:any)'] = "product/index/$1/$2";

$route['usercontrol/contact-us'] = "usercontrol/contact_us";
$route['usercontrol/wallet/withdraw'] = "usercontrol/wallet_withdraw";

$route['admincontrol/wallet/withdraw'] = "admincontrol/wallet_withdraw";
$route['admincontrol/wallet/withdraw/(:any)'] = "admincontrol/wallet_withdraw_detail/$1";

$route['form/thankyou/(:any)'] = "form/thankyou/$1";
$route['form/checkout_cart'] = "form/checkoutCart";
$route['form/checkout_cart/(:any)'] = "form/checkoutCart/$1";
$route['form/checkout_shipping'] = "form/checkoutShipping";
$route['form/checkout_shipping/(:any)'] = "form/checkoutShipping/$1";
$route['form/confirm_order'] = "form/confirm_order";
$route['form/ajax_login'] = "form/ajax_login";
$route['form/ajax_register'] = "form/ajax_register";
$route['form/cart'] = "form/cart";
$route['form/add_coupon'] = "form/add_coupon";
$route['form/(:any)/(:any)'] = "form/index/$1/$2";

$route['membership/payment_gateway/(:any)/(:any)'] = "membership/paymentGateway/$1/$2";
$route['membership/payment_gateway/(:any)/(:any)/(:any)'] = "membership/paymentGateway/$1/$2/$3";
$route['membership/payment_gateway/(:any)/(:any)/(:any)/(:any)'] = "membership/paymentGateway/$1/$2/$3/$4";

$route['resetpassword/(:any)'] = "usercontrol/resetpassword/$1";
$route['auth/(:any)'] = "usercontrol/auth/$1";

$route['cronjob/expire_package_notification'] = "CronJob/expire_package_notification";

$route['get_state'] = "usercontrol/getState";

$route['backend/(:any)'] = "Pagebuilder/custom/$1";

$route['page/(:any)'] = "AuthController/page/$1";
$route['p/(:any)'] = "AuthController/user_index/$1";

$route['faq'] = "AuthController/user_index/faq";
$route['contact'] = "AuthController/user_index/contact";
$route['terms-of-use'] = "AuthController/user_index/terms-of-use";
$route['forget-password'] = "AuthController/user_index/forget-password";
$route['privacy-policy'] = "AuthController/privacy_policy";
$route['term-condition'] = "common/term_condition";

$route['login'] = "AuthController/user_index/login";
$route['register'] = "AuthController/user_index/register";
$route['register/vendor'] = "AuthController/vendor_register";
$route['register/(:any)'] = "AuthController/user_register/$1";

$route['unsubscribe/(:any)'] = "AuthController/unsubscribe/$1";

$route['bigcommerce.js'] = "integration/bigcommerce";
$route['integration'] = "integration/index";
$route['firstsetting'] = "firstsetting/index";
$route['incomereport'] = "incomereport/index";
$route['filemanager'] = "filemanager/index";

$route['update'] = "Manualcontrol/index";
$route['api-document'] = "common/api_document";
$route['debug'] = "Manualcontrol/debug";
$route['debug/(:any)'] = "Manualcontrol/debug/$1";

$route['usercontrol/payment_gateway/(:any)/(:any)'] = "usercontrol/paymentGateway/$1/$2";
$route['usercontrol/payment_gateway/(:any)/(:any)/(:any)'] = "usercontrol/paymentGateway/$1/$2/$3";
$route['usercontrol/payment_gateway/(:any)/(:any)/(:any)/(:any)'] = "usercontrol/paymentGateway/$1/$2/$3/$4";

global $DB_ROUTES;
if(!empty($DB_ROUTES)) $route = array_merge($route,$DB_ROUTES);

$route['ref/(:any)'] = "RedirectTracking/external_integration/$1";
$route['(:any)'] = "RedirectTracking/redirect_tracking_url/$1";