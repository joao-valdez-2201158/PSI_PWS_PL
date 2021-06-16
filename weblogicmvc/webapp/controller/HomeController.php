<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use Carbon\Carbon;
use ArmoredCore\WebObjects\Debug;

/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 09-05-2016
 * Time: 11:30
 */
class HomeController extends BaseController
{

    public function index(){
        $user_logado = null;

        if(Session::has('user'))
        $user_logado = Session::get('user');
        return View::make('home.index', ['user' => $user_logado]);
    }

    public function start(){
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');
        return View::make('home.start', ['user' => $user_logado]);

    }

    public function login(){
        Throw new Exception('Method not implemented. Do it yourself!');
    }


    public function worksheet(){

        View::attachSubView('titlecontainer', 'layout.pagetitle', ['title' => 'MVC Worksheet']);

        return View::make('home.worksheet');
    }

    public function setsession(){
        $dataObject = MetaArmCoreModel::getComponents();
        Session::set('object', $dataObject);

        Redirect::toRoute('home/worksheet');
    }

    public function showsession(){
        $res = Session::get('object');
        var_dump($res);
    }

    public function destroysession(){

        Session::destroy();
        Redirect::toRoute('home/worksheet');
    }

public function searchflight()
{
    $flight = Post::get('flight');
    $date = Post::get('date');
    $date2 = Post::get('date2');

    $user_logado = null;

    if(Session::has('user'))
        $user_logado = Session::get('user');

    if(is_null($flight))
    {
        Redirect::toRoute('home/start', ['user' => $user_logado]);
    }
    else
    {
        //pesquisar na BD
        $result = Flight::find_by_sql('select flights.id_flight, airplanes.reference, flights.price, stopovers.distance, departure.name as origin, 
arrival.name as destination,stopovers.date_of_departure, stopovers.date_of_arrival
from flights 
left join airplanes on flights.id_airplane = airplanes.id_airplane
left join stopovers on flights.id_flight = stopovers.id_flight
left join airports as departure on stopovers.id_departure = departure.id_airport
left join airports as arrival on stopovers.id_destination = arrival.id_airport
where arrival.name like "%'.$flight.'%" and stopovers.date_of_departure like "%'.$date.'%" and stopovers.date_of_arrival like"%'.$date2.'%"');


        return View::make('home.searchflight',['flight' => $flight, 'date' => $date, 'date2' => $date2, 'result' => $result]);
    }
}

}