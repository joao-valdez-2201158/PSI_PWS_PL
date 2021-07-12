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

        $airports = Airport::all();
        $flight = Post::has('flight') ? Post::get('flight') : '';
        $destiny = Post::has('destiny') ? Post::get('destiny') : '';
        $date = Post::has('date') ?  Post::get('date') : '';
        $date_return = Post::has('date_return') ?  Post::get('date_return') : '';
       
        $query = "select flights.*,
                       (
                            select count(*) from stopovers where stopovers.id_flight = flights.id_flight
                        ) as stopover_number
                    from flights
                    where 
                    id_flight in 
                    (
                        select stopovers.id_flight
                        from stopovers 
                         left join airports as departure on stopovers.id_departure_airport = departure.id_airport   
                        where departure.localization = '$flight'
                        and stopovers.date_of_departure >= '$date'
                    ) 
                    
                    and id_flight in 
                    (
                    
                        select stopovers.id_flight
                        from stopovers 
                        left join airports as arrival on stopovers.id_destination_airport = arrival.id_airport   
                        where arrival.localization = '$destiny'
                        #and stopovers.arrival <= '$date_return'
                    )";

        $result = Flight::find_by_sql($query);


        $result_return = array();
        //Return Flights
        if ($date_return != ''){
            $query_return = "select flights.*,
                       (
                            select count(*) from stopovers where stopovers.id_flight = flights.id_flight
                        ) as stopover_number
                    from flights
                    where 
                    id_flight in 
                    (
                        select stopovers.id_flight
                        from stopovers 
                         left join airports as departure on stopovers.id_departure_airport = departure.id_airport   
                        where departure.localization = '$destiny'
                        and stopovers.date_of_departure >= '$date'
                    ) 
                    
                    and id_flight in 
                    (
                    
                        select stopovers.id_flight
                        from stopovers 
                        left join airports as arrival on stopovers.id_destination_airport = arrival.id_airport   
                        where arrival.localization = '$flight'
                        #and stopovers.arrival <= '$date_return'
                    )";
            $result_return = Flight::find_by_sql($query_return);
        }
        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
        else
        {
            return View::make('home.index', ['airports' => $airports, 'flight' => $flight, 'destiny' => $destiny, 'date' => $date, 'date_return' => $date_return, 'result' => $result, 'result_return' => $result_return, 'user' => $user_logado]);
        }
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

    public function flightdetail($id)
    {
        $id_flight = $id;

        if(Session::has('user'))
        $user_logado = Session::get('user');


        $flight = Flight::find([$id_flight]);

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
        else
        {
            return View::make('home/flightdetail', ['user' => $user_logado, 'flight' => $flight]);
        }
    }

    public function buy()
    {
        $user_logado = null;

        if(Session::has('user'))
        $user_logado = Session::get('user');

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
        else
        {
            $qtt = Post::has('qtt') ? Post::get('qtt') : 1;
            $id_flight = Post::has('id_flight') ? Post::get('id_flight') : null;
            $id_flight_return = Post::has('id_flight_return') ? Post::get('id_flight_return') : null;

            //$discount_departure = Post::has('discount_departure') ? Post::get('discount_departure') : null;
            //$discount_return = Post::has('discount_return') ? Post::get('discount_return') : null;


            $flight = Flight::find_by_id_flight($id_flight);
            $flight_return = Flight::find_by_id_flight($id_flight_return);
            $price = $flight->price;
            $discount_value = 0;


            //aplicar descontos de stopover
            foreach($flight->stopovers as $stopover){
                $discount_value += ($stopover->price * ($stopover->discount / 100));

            }

            if ($id_flight_return != null){
                foreach($flight_return->stopovers as $stopover){
                    $discount_value += ($stopover->price * ($stopover->discount / 100));
                }
            }

            //aplicar desconto do fligth
            $discount_value += ($price * ($flight->discount / 100));


            if ($id_flight_return != null)
            {
                $price += $flight_return->price;
                $discount_value += ($price * ($flight_return->discount / 100));
            }

            for ($i = 0; $i < $qtt; $i++){

                $ticket = new Ticket();
                $ticket->id_user = $user_logado->id_user;
                $ticket->id_departure_flight = $id_flight;
                $ticket->id_return_flight = $id_flight_return;
                //calcular descontos que estao no stopover e no fligth

                $ticket->discount_value = $discount_value;
                $ticket->price = $price - $discount_value;
                $ticket->date = date("Y-m-d");
                $ticket->hour = date("h:i:s");
                $ticket->save(false);
            }

            $stopover = Stopover::find_by_id_flight($id_flight);

            $airplanestop = new  AirplaneStopover();
            $airplanestop->passengers_quantity = $qtt;
            $airplanestop->id_airplane = $stopover->id_airplane;
            $airplanestop->id_stopover = $stopover->id_stopover;
            $airplanestop->save();


                return View::make('home/buy', ['user' => $user_logado, 'flight' => $flight, 'flight_return' => $flight_return,
                    'qtt' => $qtt, 'price' => $price,'discount_value' => $discount_value, 'id_ticket' => $ticket->id_ticket]);

            }
    }

    public function error()
    {
        $user_logado = null;

        if(Session::has('user'))
        $user_logado = Session::get('user');

        $error = Session::get('error');

        return View::make('home.error',['error' => $error, 'user' => $user_logado]);
    }

    public function usererror()
    {
        $error = Session::get('error');

        return View::make('home.usererror',['error' => $error]);
    }
}