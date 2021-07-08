<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Session;
class StopoverController extends BaseController implements ResourceControllerInterface

{

    public function index()
    {
        $stopovers = Stopover::all();
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado)){
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');

        }
        if (is_null($stopovers))
        {
            $error = 'First no stopovers';
            Session::set('error',$error);
            Redirect::toRoute('home/error');

        } else
        {
            return View::make('stopover.index', ['stopovers' => $stopovers, 'user' => $user_logado ]);
        }
    }

    public function create()
    {
        $airports = Airport::all();
        $flights = Flight::all();
        $airplanes = Airplane::all();

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado)){
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
        else
        {
            return View::make('stopover.create',  ['user' => $user_logado, 'airports' => $airports, 'flights' => $flights, 'airplanes' => $airplanes]);
        }

    }

    public function stopovercreate($id)
    {
        $airports = Airport::all();
        $flights = Flight::all();
        $airplanes = Airplane::all();
        $user_logado = null;

        if (Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado)){
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }else
        {
            return View::make('stopover.stopovercreate', ['user' => $user_logado, 'airports' => $airports, 'flights' => $flights, 'airplanes' => $airplanes, 'id' => $id]);
        }
    }

    public function store()
    {

        $stopover = new Stopover(Post::getAll());
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado)){
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

        if($stopover->is_valid()){
            $stopover->save();
            Redirect::toRoute('stopover/index');
        } else {
            Redirect::flashToRoute('stopover/create', ['stopover' => $stopover, 'user' => $user_logado]);
        }
    }

    public function show($id)
    {
        $stopover = Stopover::find([$id]);
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

        if (is_null($stopover)) {
            $error = 'There is no stopover';
            Session::set('error',$error);
            Redirect::toRoute('home/error');
        } else {
            return View::make('stopover.show', ['stopover' => $stopover, 'user' => $user_logado]);
        }
    }

    public function edit($id)
    {
        $stopover = Stopover::find([$id]);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

        if (is_null($stopover)) {
            $error = 'There is no stopover';
            Session::set('error',$error);
            Redirect::toRoute('home/error');
        }
        else
        {
            return View::make('stopover.edit', ['stopover' => $stopover, 'user' => $user_logado ]);
        }

    }

    public function update($id)
    {
        $stopover = Stopover::find([$id]);
        $stopover->update_attributes(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

        if($stopover->is_valid()){
            $stopover->save();
            Redirect::toRoute('stopover/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('stopover/edit', ['stopover' => $stopover, 'user' => $user_logado]);
        }
    }

    public function destroy($id)
    {
        $airports = Airport::find_by_id_airport($id);
        $airplanestopovers = AirplaneStopover::find_by_id_stopover($id);
        $flights = Flight::find_by_id_flight($id);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
        if ($airports != null || $airplanestopovers != null || $flights != null)
        {
            $error = 'User has airport(s)/stopover(s)/flight(s) associated, deletion is not allowed, first delete the other items';
            Session::set('error_user',$error);
            Redirect::toRoute('home/error');
        } else {
            $stopover = Stopover::find([$id]);
            $stopover->delete();
            Redirect::toRoute('stopover/index');
        }

    }

}