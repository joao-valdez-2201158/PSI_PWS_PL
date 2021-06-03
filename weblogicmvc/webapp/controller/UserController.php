<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class UserController extends BaseController implements ResourceControllerInterface
{

    public function index()
    {
        $users = User::all();
        return View::make('user.index', ['users' => $users]);
    }

    public function create()
    {
        return View::make('user.create');
    }

    public function store()
    {

        $user = new User(Post::getAll());
        $user->password = md5($user->password, false);

        if($user->is_valid()){
            $user->save();
            Redirect::toRoute('user/index');
        } else {
            Redirect::flashToRoute('user/create', ['user' => $user]);
        }
    }

    public function show($id)
    {
        $user = User::find([$id]);


        if (is_null($user)) {

        } else {
            return View::make('user.show', ['user' => $user]);
        }
    }

    public function edit($id)
    {
        $user = User::find([$id]);

        if (is_null($user)) {
        } else {
            return View::make('user.edit', ['user' => $user]);
        }    }

    public function update($id)
    {
        $user = User::find([$id]);
        $user->update_attributes(Post::getAll());

        if($user->is_valid()){
            $user->save();
            Redirect::toRoute('user/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('user/edit', ['user' => $user]);
        }    }

    public function destroy($id)
    {
        $user = User::find([$id]);
        $user->delete();
        Redirect::toRoute('user/index');
    }

    public function login()
    {
        return View::make('user.login');

    }

    public function makelogin()
    {

       $username = Post::get('username');
       $password = Post::get('password');
       $password = md5($password, false);


        $user = User::find_by_username_and_password($username, $password);


        if(is_null($user)){
            Redirect::toRoute('home/start');
       }else{
           \ArmoredCore\WebObjects\Session::set('user',$user);
           Redirect::toRoute('home/start');
       }

    }
}