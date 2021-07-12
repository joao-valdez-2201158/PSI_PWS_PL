<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Session;
class FlightController extends BaseController implements ResourceControllerInterface

{

    public function index()
    {
        $flights = Flight::all();

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
            return View::make('flight.index', ['flights' => $flights, 'user' => $user_logado]);
        }
    }

    public function create()
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
            return View::make('flight.create', ['user' => $user_logado]);
        }
    }

    public function store()
    {

        $flight = new Flight(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

        if($flight->is_valid()){
            $flight->save();

            Redirect::toRoute('flight/index');
        } else {
            Redirect::flashToRoute('flight/create', ['flight' => $flight, 'user' => $user_logado]);
        }
    }

    public function show($id)
    {
        $flight = Flight::find([$id]);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado))

        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
        else{
            if (is_null($flight)) {

                $error = 'Invalid Flight';
                Session::set('error',$error);
                Redirect::toRoute('home/error');

            } else {
                return View::make('flight.show', ['flight' => $flight, 'user' => $user_logado]);
            }
        }


    }

    public function edit($id)
    {
        $flight = Flight::find([$id]);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'op' || $user_logado->role == 'gest'){
                return View::make('flight.edit', ['flight' => $flight, 'user' => $user_logado]);
            }else{
                $error = 'You have no premissions';
                Session::set('error',$error);
                Redirect::toRoute('home/error');
            }
        }
        else
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
    }

    public function update($id)
    {
        $flight = Flight::find([$id]);
        $flight->update_attributes(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'op' || $user_logado->role == 'gest'){
                if($flight->is_valid()){

                    $price = 0;
                    foreach($flight->stopovers as $stopover){
                        $price += $stopover->price;
                    }
                    $flight->price = $price;

                    $flight->save();
                    Redirect::toRoute('flight/index');
                } else {
                    //redirect to form with data and errors
                    Redirect::flashToRoute('flight/edit', ['flight' => $flight, 'user' => $user_logado]);
                }
            }else{
                $error = 'You have no premissions';
                Session::set('error',$error);
                Redirect::toRoute('home/error');
            }
        }
        else
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

    }

    public function destroy($id)
    {
            $stopovers = Stopover::find_by_id_flight($id);
            $airplanes = Airplane::find_by_id_airplane($id);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'op' || $user_logado->role == 'gest'){
                if ($stopovers != null || $airplanes != null)
                {
                    $error = 'User has airplane(s)/stopover(s) associated, deletion is not allowed, first delete stopovers';
                    Session::set('error',$error);
                    Redirect::toRoute('home/error');
                } else {
                    $flight = Flight::find([$id]);
                    $flight->delete();
                    Redirect::toRoute('flight/index');
                }
            }else{
                $error = 'You have no premissions';
                Session::set('error',$error);
                Redirect::toRoute('home/error');
            }
        }
        else
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

    }


    public function ticketflight($id)
    {
        $tickets = Ticket::all();
        $ticket_departure = Ticket::find_by_id_departure_flight($id);
        $ticket_return = Ticket::find_by_id_return_flight($id);
        
        $user_logado = null;

        if(Session::has('user'))
        $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'op' || $user_logado->role == 'user' || $user_logado->role == 'gest'){

                if (is_null($ticket_departure) && is_null($ticket_return))
                {
                    $error = 'No Tickets Associated';
                    Session::set('error', $error);
                    Redirect::toRoute('home/error');
                } else
                {
                    return View::make('flight.ticketflight', ['user' => $user_logado, 'tickets' => $tickets, 'id' => $id]);
                }
            }else{
                $error = 'You have no premissions';
                Session::set('error',$error);
                Redirect::toRoute('home/error');
            }
        }
        else
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }



    }


    public function givediscount($id){

        $flight = Flight::find_by_id_flight($id);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'mark'){
                return View::make('flight.ticketdiscount',[ 'user' => $user_logado, 'flight' => $flight]);
            }else{
                $error = 'You have no premissions';
                Session::set('error',$error);
                Redirect::toRoute('home/error');
            }
        }
        else
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }


    }

    public function savediscount($id){

        $flight = Flight::find([$id]);
        $flight->update_attributes(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {

            if ($flight->is_valid())
            {
                $flight->save();
                Redirect::toRoute('flight/index');
            } else
            {
                //obs: redirect to form with data and errors
                Redirect::flashToRoute('flight/edit', ['flight' => $flight, 'user' => $user_logado]);
            }
        }else{
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
    }

}

