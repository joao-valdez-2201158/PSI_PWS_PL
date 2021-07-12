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

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'gest'){
                return View::make('airplane.index', ['airplanes' => $airplanes, 'user' => $user_logado]);
            }else{
                $error = 'You have not premissions';
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

    public function create()
    {
        $user_logado = null;

        if(Session::has('user'))
        $user_logado = Session::get('user');
        if(!is_null($user_logado))
        {
            if($user_logado->role == 'gest'){
                return View::make('airplane.create', ['user' => $user_logado]);
            }else{
                $error = 'You have not premissions';
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

    public function store()
    {

        $airplane = new Airplane(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
        $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'gest'){
                if($airplane->is_valid()){
                    $airplane->save();
                    Redirect::toRoute('airplane/index');
                } else {
                    Redirect::flashToRoute('airplane/create', ['airplane' => $airplane, 'user' => $user_logado]);
                }
            }else{
                $error = 'You have not premissions';
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

    public function show($id)
    {
        $airplane = Airplane::find([$id]);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'gest'){
                if (is_null($airplane)) {
                    $error = 'Invalid Airplane';
                    Session::set('error',$error);
                    Redirect::toRoute('home/error');
                }
                else
                {
                    return View::make('airplane.show', ['airplane' => $airplane, 'user' => $user_logado]);
                }
            }else{
                $error = 'You have not premissions';
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

    public function edit($id)
    {
        $airplane = Airplane::find([$id]);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'gest'){
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
            }else{
                $error = 'You have not premissions';
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
        $airplane = Airplane::find([$id]);
        $airplane->update_attributes(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'gest'){
                if($airplane->is_valid()){
                    $airplane->save();
                    Redirect::toRoute('airplane/index');
                } else {
                    //redirect to form with data and errors
                    Redirect::flashToRoute('airplane/edit', ['airplane' => $airplane, 'user' => $user_logado]);
                }
            }else{
                $error = 'You have not premissions';
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
        $user_logado = null;

        if(Session::has('user'))
        $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'gest'){
                $airplane = Airplane::find([$id]);
                $airplane->delete();
                Redirect::toRoute('airplane/index');
            }else{
                $error = 'You have not premissions';
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

}