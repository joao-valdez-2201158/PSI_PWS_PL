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
        $destiny = Post::has('destiny') ? Post::get('destiny') : '';
        $date = Post::has('date') ?  Post::get('date') : '';
        $date_return = Post::has('date_return') ?  Post::get('date_return') : '';

        /*
        $query = 'select flights.id_flight, airplanes.reference, flights.price, stopovers.distance, departure.name as origin, 
arrival.name as destination,stopovers.date_of_departure, stopovers.date_of_arrival,
       stopovers.hour_of_departure, stopovers.hour_of_arrival
from flights 
left join airplanes on flights.id_airplane = airplanes.id_airplane
left join stopovers on flights.id_flight = stopovers.id_flight
left join airports as departure on stopovers.id_departure = departure.id_airport
left join airports as arrival on stopovers.id_destination = arrival.id_airport
where (arrival.localization like "%'.$destiny.'%" and departure.localization like "%'.$flight.'%") 
and stopovers.date_of_departure >= "'.$date.'" and stopovers.date_of_arrival <= "'.$date2.'"';*/


       
$query = 'select flights.id_flight, airplanes.reference, flights.price, stopovers.distance, departure.name as origin, 
arrival.name as destination,stopovers.date_of_departure, stopovers.date_of_arrival,
       stopovers.hour_of_departure, stopovers.hour_of_arrival
from flights 
left join airplanes on flights.id_airplane = airplanes.id_airplane
inner join stopovers on flights.id_flight = stopovers.id_flight
left join airports as departure on stopovers.id_departure = departure.id_airport
left join airports as arrival on stopovers.id_destination = arrival.id_airport
where flights.id_flight in (Select stopovers.id_flight from stopovers left join airports as departure on stopovers.id_departure = departure.id_airport
left join airports as arrival on stopovers.id_destination = arrival.id_airport where arrival.localization like "%'.$destiny.'%" and stopovers.date_of_arrival = "'.$date.'")
and flights.id_flight in (Select stopovers.id_flight from stopovers left join airports as departure on stopovers.id_departure = departure.id_airport
left join airports as arrival on stopovers.id_destination = arrival.id_airport where departure.localization like "%'.$flight.'%" and stopovers.date_of_departure  = "'.$date.'")
group by flights.id_flight';

        $result = Flight::find_by_sql($query);

        $result_return = array();
        //Return Flights
        if ($date_return != ''){
            $query_return = 'select flights.id_flight, airplanes.reference, flights.price, stopovers.distance, departure.name as origin, 
                arrival.name as destination,stopovers.date_of_departure, stopovers.date_of_arrival,
                    stopovers.hour_of_departure, stopovers.hour_of_arrival
                from flights 
                left join airplanes on flights.id_airplane = airplanes.id_airplane
                inner join stopovers on flights.id_flight = stopovers.id_flight
                left join airports as departure on stopovers.id_departure = departure.id_airport
                left join airports as arrival on stopovers.id_destination = arrival.id_airport
                where flights.id_flight in (Select stopovers.id_flight from stopovers left join airports as departure on stopovers.id_departure = departure.id_airport
                left join airports as arrival on stopovers.id_destination = arrival.id_airport where arrival.localization like "%'.$flight.'%" and stopovers.date_of_arrival = "'.$date_return.'")
                and flights.id_flight in (Select stopovers.id_flight from stopovers left join airports as departure on stopovers.id_departure = departure.id_airport
                left join airports as arrival on stopovers.id_destination = arrival.id_airport where departure.localization like "%'.$destiny.'%" and stopovers.date_of_departure  = "'.$date_return.'")
                group by flights.id_flight';
            $result_return = Flight::find_by_sql($query_return);
        }
        
        
       
        return View::make('home.index',['flight' => $flight, 'destiny' => $destiny, 'date' => $date, 'date_return' => $date_return, 'result' => $result,'result_return' => $result_return, 'user' => $user_logado]);

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

    public function flightdetail()
    {
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        $id_flight = $_GET['idF'];
        $or = $_GET['or'];
        $dest = $_GET['dest'];
        $flight = Flight::find([$id_flight]);

        $stopovers = Stopover::find_by_id_flight([$id_flight]);
  
        $origin = Airport::find_by_localization([$or]);
        $destination = Airport::find_by_localization([$dest]);
        
        return View::make('home/flightdetail', ['user' => $user_logado, 'flight' => $flight, 'stopovers' => $stopovers, 'origin' => $origin, 'destination' => $destination]);
    }

    public function buy()
    {
        $qtt  = Post::has('qtt') ? Post::get('qtt') : 1;
        $id_flight = Post::has('id_flight') ? Post::get('id_flight') : null;
        $id_flight_return = Post::has('id_flight_return') ? Post::get('id_flight_return') : null;

        $stopovers = Stopover::find_by_id_flight([$id_flight]);

        //gravar na BD na tabela tickets
        $user_logado = null;
       
        if(Session::has('user')){
            $user_logado = Session::get('user');
            //Buy
            
            $flight = Flight::find_by_id_flight($id_flight);
            $price = $flight->price;

            if ($id_flight_return != null){
                $flight_return = Flight::find_by_id_flight($id_flight_return);
                $price += $flight_return->price;
            }
             
            #$attributes = array( 'id_departure_flight' => '233334', 'id_return_flight'=> '233336',  'price' => '10' ,  'date' => '2021-06-26' ,  'hour' => '05:00:00' ,  'check_in' => 0,  'check_in_return' => 0);
            for ($i = 0; $i < $qtt ; $i++){
                $ticket = new Ticket();
                //$ticket->id_user = $user_logado->id_user;
                $ticket->id_user = 13; //Remove
                $ticket->id_departure_flight = $id_flight;
                $ticket->id_return_flight = $id_flight_return;
                $ticket->price = $price;
                $ticket->date =  date("Y-m-d");
                $ticket->hour = date("h:i:s");;
                $ticket->save(false);
            }

            return View::make('home/buy', ['user'=> $user_logado, 'id_flight' => $id_flight, 'id_flight_return' => $id_flight_return, 'qtt' => $qtt ]);
        }else{
            Redirect::toRoute('user/login');
        }

    }


}