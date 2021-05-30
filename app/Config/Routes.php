<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Site\Oxygen_supply_controller');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
// $routes->set404Override( function() {
//     echo view('Site/error_page');
// });
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', function(){ return view('Site\homepage'); } );


// oxygen routes
$routes->add('/oxygen_supply', 'Site\Oxygen_supply_controller::oxygen_supply');
$routes->post('/oxygen_search', 'Site\Oxygen_supply_controller::search_oxygen_supplier');

// plasma donor
$routes->add('/plasma_donor', 'Site\Plasma_donors_controller::plasma_donor');
$routes->post('/donor_search', 'Site\Plasma_donors_controller::search_plasma_donors');

// tiffin service
$routes->add('/tiffin_service', 'Site\Tiffin_service_controller::tiffin_service');
$routes->post('/tiffin_search', 'Site\Tiffin_service_controller::search_tiffin_service');

// bed availability
$routes->add('/bed_availability', 'Site\Bed_availability_controller::bed_availability');
$routes->post('/bed_search', 'Site\Bed_availability_controller::search_bed_availability');


// posts
$routes->get('/post', 'Site\Posts_controller::index');
$routes->get('/post/(:any)', 'Site\Posts_controller::show_post');
$routes->add('/report_post', 'Site\Posts_controller::report_post');

// about
$routes->get('/about', function(){ return view('Site\about'); });

// Registration
$routes->get('/registration', function(){ return view('Site\registration'); });
$routes->post('/register_user', 'Site\Registration_controller::register_user');
$routes->get('/verify_user/(:segment)/(:hash)', 'Site\Registration_controller::verify_registration_email/$1/$2');

// login
$routes->get('/login', function(){ return view('Site\login'); });
$routes->post('/login_user', 'Site\Login_controller::authenticate');


// User Panel Functions
$routes->group('/user', function($routes)
{   
    // ACCESS DENIED
    $routes->add('access-denied', function() { echo view('User/access_denied');});


    // PROFILE
    $routes->add('profile', 'User\Profile_controller::index');


    // OXYGEN
    $routes->add('oxygen_supply', 'User\Oxygen_supply_controller::index');
    $routes->add('oxygen_supply_save', 'User\Oxygen_supply_controller::oxygen_supply_save');
    $routes->add('add_oxygen_supply', 'User\Oxygen_supply_controller::add_oxygen_supplier');
    $routes->add('del_oxygen_supplier', 'User\Oxygen_supply_controller::delete_oxygen_supply');


    // TIFFIN
    $routes->add('tiffin_service', 'User\Tiffin_services_controller::index');    
    $routes->add('add_tiffin_supply', 'User\Tiffin_services_controller::add_tiffin_service');
    $routes->add('tiffin_supply_save', 'User\Tiffin_services_controller::tiffin_service_save');
    $routes->add('del_tiffin_supplier', 'User\Tiffin_services_controller::delete_tiffin_service');


    // BED
    $routes->add('bed_availability', 'User\Bed_availability_controller::index');    
    $routes->add('add_bed_availability', 'User\Bed_availability_controller::add_bed_availability');
    $routes->add('bed_availability_save', 'User\Bed_availability_controller::bed_availability_save');
    $routes->add('del_bed_availability', 'User\Bed_availability_controller::delete_bed_availability');


    // PLASMA DONORS
    $routes->add('plasma_donors', 'User\Plasma_donor_controller::index');    
    $routes->add('add_plasma_donor', 'User\Plasma_donor_controller::add_plasma_donor');
    $routes->add('plasma_donor_save', 'User\Plasma_donor_controller::plasma_donor_save');
    $routes->add('del_plasma_donor', 'User\Plasma_donor_controller::delete_plasma_donor');


    // USERS
    $routes->get('all_users', 'User\Users_controller::index');
    $routes->post('promote_user', 'User\Users_controller::promote');
    $routes->post('demote_user', 'User\Users_controller::demote');


    // REQUESTS
    $routes->get('requests', 'User\Requests_controller::index');
    $routes->post('submit_request', 'User\Requests_controller::elivate_request_submit');
    $routes->post('discard_request', 'User\Requests_controller::discard_request');
    $routes->post('approve_request', 'User\Requests_controller::approve_request');


});



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
