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

        $flight = Post::has('flight') ? Post::get('flight') : '';
        $date = Post::has('date') ?  Post::get('date') : '';
        $date2 = Post::has('date2') ?  Post::get('date2') : '';

        $query = 'select flights.id_flight, airplanes.reference, flights.price, stopovers.distance, departure.name as origin, 
arrival.name as destination,stopovers.date_of_departure, stopovers.date_of_arrival,
       stopovers.hour_of_departure, stopovers.hour_of_arrival
from flights 
left join airplanes on flights.id_airplane = airplanes.id_airplane
left join stopovers on flights.id_flight = stopovers.id_flight
left join airports as departure on stopovers.id_departure = departure.id_airport
left join airports as arrival on stopovers.id_destination = arrival.id_airport
where (arrival.localization like "%'.$flight.'%" or departure.localization like "%'.$flight.'%") 
and stopovers.date_of_departure >= "'.$date.'" and stopovers.date_of_arrival <= "'.$date2.'"';

        $result = Flight::find_by_sql($query);

        return View::make('home.index',['flight' => $flight, 'date' => $date, 'date2' => $date2, 'result' => $result, 'user' => $user_logado]);

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

    public function flightdetail($id, $id2, $id3)
    {
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');


        $flight = Flight::find([$id]);

        $stopovers = Stopover::find_by_id_flight([$id]);

        $origin = Airport::find_by_name([$id2]);
        $destination = Airport::find_by_name([$id3]);




        return View::make('home/flightdetail', ['user' => $user_logado, 'flight' => $flight, 'stopovers' => $stopovers, 'origin' => $origin, 'destination' => $destination]);
    }

    public function buy()
    {
        $qtt = Post::get('qtt');
        $id_flight = Post::get('id_flight');

        $stopovers = Stopover::find_by_id_flight([$id_flight]);

        //gravar na BD na tabela tickets
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if($id_flight->is_valid()){
            $id_flight->save();
            Redirect::toRoute('home/flightdetail');
        } else {
            Redirect::flashToRoute('home/buy', ['id_flight' => $id_flight, 'qtt' => $qtt, 'stopovers'=> $stopovers,  'user' => $user_logado]);
        }

    }


}