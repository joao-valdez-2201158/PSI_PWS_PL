<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Session;
class AirportController extends BaseController implements ResourceControllerInterface

{

    public function index()
    {
        $user_logado = null;
        
        if(Session::has('user'))
            $user_logado = Session::get('user');

        $airports = Airport::all();
        return View::make('airport.index', ['airports' => $airports, 'user' => $user_logado]);
    }

    public function create()
    {
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        return View::make('airport.create', ['user' => $user_logado]);
    }

    public function store()
    {

        $airport = new Airport(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if($airport->is_valid()){
            $airport->save();
            Redirect::toRoute('airport/index');
        } else {
            Redirect::flashToRoute('airport/create', ['airport' => $airport, 'user' => $user_logado]);
        }
    }

    public function show($id)
    {
        $airport = Airport::find([$id]);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if (is_null($airport)) {

        } else {
            return View::make('airport.show', ['airport' => $airport, 'user' => $user_logado]);
        }
    }

    public function edit($id)
    {
        $airport = Airport::find([$id]);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if (is_null($airport)) {
        }
        else {
            return View::make('airport.edit', ['airport' => $airport, 'user' => $user_logado]);
        }

    }

    public function update($id)
    {
        $airport = Airport::find([$id]);
        $airport->update_attributes(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if($airport->is_valid()){
            $airport->save();
            Redirect::toRoute('airport/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('airport/edit', ['airport' => $airport, 'user' => $user_logado]);
        }    }

    public function destroy($id)
    {
        $airport = Airport::find([$id]);
        $airport->delete();
        Redirect::toRoute('airport/index');
    }

}