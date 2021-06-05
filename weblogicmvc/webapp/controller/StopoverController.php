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

        $user_logado;

        if (is_null($stopovers)) {
        } else {
            return View::make('stopover.edit', ['stopovers' => $stopovers, 'user' => $user_logado ]);
        }
    }

    public function create()
    {
        return View::make('stopover.create');
    }

    public function store()
    {

        $stopover = new Stopover(Post::getAll());
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        $user_logado;

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

        $user_logado;

        if (is_null($stopover)) {

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

        $user_logado;

        if (is_null($stopover)) {
        } else {
            return View::make('stopover.edit', ['stopover' => $stopover, 'user' => $user_logado ]);
        }    }

    public function update($id)
    {
        $stopover = Stopover::find([$id]);
        $stopover->update_attributes(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        $user_logado;

        if($stopover->is_valid()){
            $stopover->save();
            Redirect::toRoute('stopover/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('stopover/edit', ['stopover' => $stopover, 'user' => $user_logado]);
        }    }

    public function destroy($id)
    {
        $stopover = Stopover::find([$id]);
        $stopover->delete();
        Redirect::toRoute('stopover/index');
    }

}