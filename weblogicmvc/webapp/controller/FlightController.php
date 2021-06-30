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

        return View::make('flight.index', ['flights' => $flights, 'user' => $user_logado]);
    }

    public function create()
    {
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        return View::make('flight.create', ['user' => $user_logado]);
    }

    public function store()
    {

        $flight = new Flight(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

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

        if (is_null($flight)) {

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

        if (is_null($flight)) {
        } else {
            return View::make('flight.edit', ['flight' => $flight, 'user' => $user_logado]);
        }    }

    public function update($id)
    {
        $flight = Flight::find([$id]);
        $flight->update_attributes(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

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

}

