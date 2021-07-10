<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Session;
class AirplaneController extends BaseController implements ResourceControllerInterface
{

    public function index()
    {
        $airplanes = Airplane::all();

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
            return View::make('airplane.index', ['airplanes' => $airplanes, 'user' => $user_logado]);
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
        }else{
            return View::make('airplane.create', ['user' => $user_logado]);
        }

    }

    public function store()
    {

        $airplane = new Airplane(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
        $user_logado = Session::get('user');

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

        if($airplane->is_valid()){
            $airplane->save();
            Redirect::toRoute('airplane/index');
        } else {
            Redirect::flashToRoute('airplane/create', ['airplane' => $airplane, 'user' => $user_logado]);
        }
    }

    public function show($id)
    {
        $airplane = Airplane::find([$id]);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

        if (is_null($airplane)) {
            $error = 'Invalid Airplane';
            Session::set('error',$error);
            Redirect::toRoute('home/error');
        }
        else
        {
            return View::make('airplane.show', ['airplane' => $airplane, 'user' => $user_logado]);
        }
    }

    public function edit($id)
    {
        $airplane = Airplane::find([$id]);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
        if (is_null($airplane))
        {
            $error = 'Invalid Airplane';
            Session::set('error',$error);
            Redirect::toRoute('home/error');
        }
        else
        {
            return View::make('airplane.edit', ['airplane' => $airplane, 'user' => $user_logado]);
        }
    }

    public function update($id)
    {
        $airplane = Airplane::find([$id]);
        $airplane->update_attributes(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado))
        {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

        if($airplane->is_valid()){
            $airplane->save();
            Redirect::toRoute('airplane/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('airplane/edit', ['airplane' => $airplane, 'user' => $user_logado]);
        }
    }

    public function destroy($id)
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
            $airplane = Airplane::find([$id]);
            $airplane->delete();
            Redirect::toRoute('airplane/index');
        }

    }


}