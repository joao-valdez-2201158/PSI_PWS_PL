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
        return View::make('home.index', ['user' => $user_logado]);
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

public function searchflight()
{
    $flight = Post::get('flight');
    $user_logado = null;

    if(Session::has('user'))
        $user_logado = Session::get('user');

    $user_logado;

    if(is_null($flight))
    {
    Redirect::toRoute('home/start');
    }
    else
    {
        Session::set('flight', $flight);
        return View::make('home.searchflight',['flight' => $flight, 'user' => $user_logado]);
    }
}

}