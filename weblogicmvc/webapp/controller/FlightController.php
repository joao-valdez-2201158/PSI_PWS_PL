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
        $tickets = Ticket::all();

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
            return View::make('flight.index', ['flights' => $flights,  'tickets' => $tickets, 'user' => $user_logado]);
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

        if (is_null($flight)) {

            $error = 'Invalid Flight';
            Session::set('error',$error);
            Redirect::toRoute('home/error');

        } else {
            return View::make('flight.show', ['flight' => $flight, 'user' => $user_logado]);
        }
    }

    public function edit($id)
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

        if (is_null($flight)) {
            $error = 'Invalid Flight';
            Session::set('error',$error);
            Redirect::toRoute('home/error');
        } else {
            return View::make('flight.edit', ['flight' => $flight, 'user' => $user_logado]);
        }

    }

    public function update($id)
    {
        $flight = Flight::find([$id]);
        $flight->update_attributes(Post::getAll());

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
            //redirect to form with data and errors
            Redirect::flashToRoute('flight/edit', ['flight' => $flight, 'user' => $user_logado]);
        }
    }

    public function destroy($id)
    {
            $stopovers = Stopover::find_by_id_flight($id);
            $airplanes = Airplane::find_by_id_airplane($id);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
            if ($stopovers != null || $airplanes != null)
            {
                $error = 'User has airplane(s)/stopover(s) associated, deletion is not allowed, first delete stopovers';
                Session::set('error_user',$error);
                Redirect::toRoute('home/error');
            } else {
                $flight = Flight::find([$id]);
                $flight->delete();
                Redirect::toRoute('flight/index');
            }

    }


    public function ticketflight($id)
    {

        $flights = Flight::all();
        $stopover = Stopover::find_by_id_flight($id);
        $origin = Ticket::find_by_id_departure_flight($id);
        $destination = Ticket::find_by_id_return_flight($id);
        $tickets = Ticket::all();

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if (is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error', $error);
            Redirect::toRoute('home/usererror');
        }
        if (is_null($flights))
        {
            $error = 'Invalid Flight';
            Session::set('error', $error);
            Redirect::toRoute('home/error');
        } else
        {
            return View::make('flight.ticketflight', ['user' => $user_logado, 'flights'=> $flights, 'tickets' => $tickets, 'stopover'=>$stopover, 'origin'=> $origin, 'destination' => $destination, 'id' => $id]);
        }

    }

    public function ticketflightedit($id)
    {
        $ticket = Ticket::find([$id]);

        $user_logado = null;

        if (Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado)){
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
        if (is_null($ticket))
        {
            if(is_null($user_logado)){
                $error = 'There is no ticket';
                Session::set('error',$error);
                Redirect::toRoute('home/error');
            }
        } else
        {
            return View::make('flight.tickeflightedit', ['ticket' => $ticket, 'user' => $user_logado]);
        }
    }

}

