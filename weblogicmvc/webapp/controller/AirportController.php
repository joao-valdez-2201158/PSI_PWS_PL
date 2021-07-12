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
        $airports = Airport::all();

        $user_logado = null;
        
        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'admin'){
                return View::make('airport.index', ['airports' => $airports, 'user' => $user_logado]);
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
            if($user_logado->role == 'admin'){
            return View::make('airport.create', ['user' => $user_logado]);
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

    public function store()
    {

        $airport = new Airport(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'admin'){

                if($airport->is_valid()){
                    $airport->save();
                    Redirect::toRoute('airport/index');
                } else {
                    Redirect::flashToRoute('airport/create', ['airport' => $airport, 'user' => $user_logado]);
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

    public function show($id)
    {
        $airport = Airport::find([$id]);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'admin'){
                if (is_null($airport)) {
                    $error = 'Invalid Airport';
                    Session::set('error',$error);
                    Redirect::toRoute('home/error');

                } else
                {
                    return View::make('airport.show', ['airport' => $airport, 'user' => $user_logado]);
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
        $airport = Airport::find([$id]);

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'admin'){
                if (is_null($airport)) {
                    $error = 'Invalid Airport';
                    Session::set('error',$error);
                    Redirect::toRoute('home/error');
                }
                else {
                    return View::make('airport.edit', ['airport' => $airport, 'user' => $user_logado]);
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
        $airport = Airport::find([$id]);
        $airport->update_attributes(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'admin'){
                if($airport->is_valid()){
                    $airport->save();
                    Redirect::toRoute('airport/index');
                } else {
                    //redirect to form with data and errors
                    Redirect::flashToRoute('airport/edit', ['airport' => $airport, 'user' => $user_logado]);
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

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'admin'){
                $airport = Airport::find([$id]);
                $airport->delete();
                Redirect::toRoute('airport/index');
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

}