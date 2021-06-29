<?php
/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 02-05-2016
 * Time: 11:18
 */
use ArmoredCore\Facades\Router;

/****************************************************************************
 *  URLEncoder/HTTPRouter Routing Rules
 *  Use convention: controllerName/methodActionName
 ****************************************************************************/

Router::get('/',			'HomeController/index');
Router::get('home/',		'HomeController/index');
Router::get('home/index',	'HomeController/index');
Router::post('home/index',	'HomeController/index');
Router::get('home/start',	'HomeController/start');
Router::get('home/searchflight/',	'HomeController/searchflight');
Router::post('home/searchflight/',	'HomeController/searchflight');
Router::get('home/flightdetail',	'HomeController/flightdetail');
Router::post('home/buy',	'HomeController/buy');
Router::get('home/buy',	'HomeController/buy');

Router::get('home/error',	'HomeController/error');


//Router::get('home/start',	'UserController/start');

Router::get('test/index',  'TestController/index');

Router::resource('user', 'UserController');
Router::resource('ticket', 'TicketController');
Router::resource('stopover', 'StopoverController');
Router::resource('flight', 'FlightController');
Router::resource('airport', 'AirportController');
Router::resource('airplane', 'AirplaneController');






/************** End of URLEncoder Routing Rules ************************************/