<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'administration/case_types';
// $route['404_override'] = 'auth/login_merchant';
$route['translate_uri_dashes'] = false;

/**
 * Merchant Routes
 */
$route['merchant/login'] = 'auth/login_merchant';
$route['merchants/login'] = 'auth/login_merchant';
$route['mpesa/login'] = "merchants/registers/login";
$route['mpesa/logout'] = "auth/logout_merchant";
$route['mpesa/merchant'] = "merchants/registers/login_merchant";
$route['mpesa/profile'] = "merchants/registers/merchant_profile";
$route['merchant/profile'] = "merchants/registers/merchant_profile";
$route['mpesa/create-client'] = "merchants/registers/create_client";
$route['mpesa/save-client'] = "merchants/registers/save_client";
$route['merchant/change-password'] = "merchants/registers/change_password";
$route['update-customers'] = 'webservice/update_customers';

/**
 * Auth
 */
$route['login'] = 'auth/login_admin';
$route['logout'] = 'auth/logout';

$route['laikipia/login'] = 'auth/laikipiaauth/login_admin';
$route['laikipia/logout'] = 'auth/laikipiaauth/logout';

/**
 * Admin
 */
$route['administration'] = 'admin';
$route['admin'] = 'admin';
$route['dashboard'] = 'admin/dashboard';

/**
 * Case Types
 */
$route['administration/case_types'] = 'admin/case_types/index';
$route['administration/case_types/(:any)/(:any)/(:num)'] = 'admin/case_types/index/$1/$2/$3';
$route['administration/case_types/(:any)/(:any)'] = 'admin/case_types/index/$1/$2';
$route['administration/add-case_type'] = 'admin/case_types/add_case_type';
$route['administration/edit-case_type/(:num)'] = 'admin/case_types/edit_case_type/$1';
$route['administration/edit-case_type/(:num)/(:num)'] = 'admin/case_types/edit_case_type/$1/$2';
$route['administration/delete-case_type/(:num)'] = 'admin/case_types/delete_case_type/$1';
$route['administration/delete-case_type/(:num)/(:num)'] = 'admin/case_types/delete_case_type/$1/$2';


/**
 * Reports - Transactions
 */
$route['reports/update-merchants/(:num)/(:num)'] = 'reports/transactions/update_merchant_info/$1/$2';
$route['reports/transactions'] = 'reports/transactions/index';
$route['reports/test-page'] = 'reports/transactions/test_page';
$route['reports/search-transactions'] = 'reports/transactions/search_transactions';
$route['reports/close-search'] = 'reports/transactions/close_search';
$route['reports/export-transactions'] = 'reports/transactions/export_transactions';
$route['reports/transactions/(:any)/(:any)/(:num)'] = 'reports/transactions/index/$1/$2/$3';
$route['reports/transactions/(:any)/(:any)'] = 'reports/transactions/index/$1/$2';
$route['reports/transactions/bulk-actions'] = 'reports/transactions/bulk_actions';

/**
 * Reports - Payments
 */
$route['reports/payments'] = 'reports/payments/index';
$route['reports/search-payments'] = 'reports/payments/search_payments';
$route['reports/close-payments-search'] = 'reports/payments/close_search';
$route['reports/export-payments'] = 'reports/payments/export_payments';
$route['reports/payments/(:any)/(:any)/(:num)'] = 'reports/payments/index/$1/$2/$3';
$route['reports/payments/(:any)/(:any)'] = 'reports/payments/index/$1/$2';
$route['reports/payments/bulk-actions'] = 'reports/payments/bulk_actions';
$route['reports/payments/get-false-payments'] = 'reports/payments/update_payment_info';

/*
 *    Users Routes
 */
$route['administration/users'] = 'hr/personnel/index';
$route['administration/users/(:any)/(:any)/(:num)'] = 'hr/personnel/index/$1/$2/$3';
$route['administration/add-user'] = 'hr/personnel/add_personnel';
$route['administration/edit-user/(:num)'] = 'hr/personnel/edit_personnel/$1';
$route['administration/edit-user-about/(:num)'] = 'hr/personnel/update_personnel_about_details/$1';
$route['administration/edit-user-account/(:num)'] = 'hr/personnel/update_personnel_account_details/$1';
$route['administration/edit-user/(:num)/(:num)'] = 'hr/personnel/edit_personnel/$1/$2';
$route['administration/delete-user/(:num)'] = 'hr/personnel/delete_personnel/$1';
$route['administration/delete-user/(:num)/(:num)'] = 'hr/personnel/delete_personnel/$1/$2';
$route['administration/activate-user/(:num)'] = 'hr/personnel/activate_personnel/$1';
$route['administration/activate-user/(:num)/(:num)'] = 'hr/personnel/activate_personnel/$1/$2';
$route['administration/deactivate-user/(:num)'] = 'hr/personnel/deactivate_personnel/$1';
$route['administration/deactivate-user/(:num)/(:num)'] = 'hr/personnel/deactivate_personnel/$1/$2';
$route['administration/reset-password/(:num)'] = 'hr/personnel/reset_password/$1';
$route['administration/update-user-roles/(:num)'] = 'hr/personnel/update_personnel_roles/$1';
$route['human-resource/delete-personnel-role/(:num)/(:num)'] = 'hr/personnel/delete_personnel_role/$1/$2';

/**
 * Update Payments
 */
$route['administration/update-payments'] = 'admin/payments/index';
$route['administration/update-payments/(:any)/(:any)/(:num)'] = 'admin/payments/index/$1/$2/$3';
$route['administration/update-payments/(:any)/(:any)'] = 'admin/payments/index/$1/$2';
$route['administration/search-update-payments'] = 'admin/payments/search_payments';
$route['administration/update-payments-close-search'] = 'admin/payments/close_search';
$route['administration/update-payments/bulk-actions'] = 'admin/payments/bulk_actions';

/**
 * Reports - Merchants
 */
$route['reports/search-merchants'] = 'reports/merchants/search_merchants';
$route['reports/close-merchants-search'] = 'reports/merchants/close_search';
$route['reports/export-merchants'] = 'reports/merchants/export_merchants';
$route['reports/merchants'] = 'reports/merchants/index';
$route['reports/merchants/(:any)/(:any)/(:num)'] = 'reports/merchants/index/$1/$2/$3';
$route['reports/merchants/(:any)/(:any)'] = 'reports/merchants/index/$1/$2';
$route['reports/merchants/bulk-actions'] = 'reports/merchants/bulk_actions';

/**
 * Customers - All Customers
 */
$route['customers/search-customers'] = 'customers/customers/search_customers';
$route['customers/close-customers-search'] = 'customers/customers/close_search';
$route['customers/export-customers'] = 'customers/customers/export_customers';
$route['customers/all-customers'] = 'customers/customers/index';
$route['customers/all-customers/(:any)/(:any)/(:num)'] = 'customers/customers/index/$1/$2/$3';
$route['customers/all-customers/(:any)/(:any)'] = 'customers/customers/index/$1/$2';
$route['customers/assign-customer'] = 'customers/customers/assign_customer';
$route['customers/reassign-customer'] = 'customers/customers/reassign_customer';

/**
 * Customers - Tasks
 */
$route['customers/search-tasks'] = 'customers/tasks/search_tasks';
$route['customers/close-tasks-search'] = 'customers/tasks/close_tasks_search';
$route['customers/export-tasks'] = 'customers/tasks/export_tasks';
$route['customers/task'] = 'customers/tasks/index';
$route['customers/tasks/(:any)/(:any)/(:num)'] = 'customers/tasks/index/$1/$2/$3';
$route['customers/tasks/(:any)/(:any)'] = 'customers/tasks/index/$1/$2';
$route['customers/task/(:any)/(:any)/(:num)'] = 'customers/tasks/index/$1/$2/$3';
$route['customers/task/(:any)/(:any)'] = 'customers/tasks/index/$1/$2';
$route['customers/update-status'] = 'customers/tasks/update_status';
$route['customers/update-customer-task'] = 'customers/tasks/update_customer_task';

/**
 * rubicon - customers
 */
$route['rubicon/customers'] = 'rubicon/customers/get_details';

//Laikipia schools
/**
 * Donations
 */
$route['laikipiaschools/donations'] = 'laikipiaschools/donations/index';
$route['laikipiaschools/single-donation/(:num)'] = 'laikipiaschools/donations/single_donation/$1';
$route['laikipiaschools/edit-donation/(:num)'] = 'laikipiaschools/donations/edit_donation/$1';
$route['laikipiaschools/delete-donation/(:num)'] = 'laikipiaschools/donations/delete_donation/$1';
$route['laikipiaschools/export-donations'] = 'laikipiaschools/donations/export_transactions';
$route['laikipiaschools/donations/(:any)/(:any)/(:num)'] = 'laikipiaschools/donations/index/$1/$2/$3';
$route['laikipiaschools/donations/(:any)/(:any)'] = 'laikipiaschools/donations/index/$1/$2';
$route['laikipiaschools/donations/bulk-actions'] = 'laikipiaschools/donations/bulk_actions';

//partners

$route['laikipiaschools/update-merchants/(:num)/(:num)'] = 'laikipiaschools/partners/update_merchant_info/$1/$2';
$route['laikipiaschools/partners'] = 'laikipiaschools/partners/index';
$route['laikipiaschools/edit/(:num)'] = 'laikipiaschools/partners/edit/$1';
$route['laikipiaschools/search-partners'] = 'laikipiaschools/partners/search_transactions';
$route['laikipiaschools/close-search'] = 'laikipiaschools/partners/close_search';
$route['laikipiaschools/export-partners'] = 'laikipiaschools/partners/export_transactions';
$route['laikipiaschools/partners/(:any)/(:any)/(:num)'] = 'laikipiaschools/partners/index/$1/$2/$3';
$route['laikipiaschools/partners/(:any)/(:any)'] = 'laikipiaschools/partners/index/$1/$2';
$route['laikipiaschools/partners/bulk-actions'] = 'laikipiaschools/partners/bulk_actions';
$route['laikipiaschools/delete-partner/(:num)'] = 'laikipiaschools/partners/delete_partner/$1';
/**
 * Schools
 */
$route['laikipiaschools/update-school/(:num)'] = 'laikipiaschools/schools/edit_school/$1';
$route['laikipiaschools/schools'] = 'laikipiaschools/schools/index';
$route['laikipiaschools/add-schools'] = 'laikipiaschools/schools/add_school';
$route['laikipiaschools/search-schools'] = 'laikipiaschools/schools/search_transactions';
$route['laikipiaschools/close-search'] = 'laikipiaschools/schools/close_search';
$route['laikipiaschools/export-schools'] = 'laikipiaschools/schools/export_transactions';
$route['laikipiaschools/schools/(:any)/(:any)/(:num)'] = 'laikipiaschools/schools/index/$1/$2/$3';
$route['laikipiaschools/schools/(:any)/(:any)'] = 'laikipiaschools/schools/index/$1/$2';
$route['laikipiaschools/schools/bulk-actions'] = 'laikipiaschools/schools/bulk_actions';
/**
 * casetypes
 */
$route['case_types/get_case_types']= 'case_types/Case_types/get_case_types';
$route['case_types/get_specific_data']= 'case_types/Case_types/get_specific_data';
$route['case_types/get_all_case_types']= 'case_types/Case_types/get_all_case_types';
$route['translatelanguages']= 'case_types/Case_types/get_translation';

