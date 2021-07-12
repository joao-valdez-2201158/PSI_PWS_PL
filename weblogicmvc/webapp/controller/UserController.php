<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
class UserController extends BaseController implements ResourceControllerInterface
{

    public function index()
    {   $users = User::all();

        $user_logado = null;

        if(Session::has('user')){
            $user_logado = Session::get('user');
        }

        if(is_null($user_logado)){
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/error');

        }else{
            if($user_logado->role == 'admin' || $user_logado->role == 'user'){
                return View::make('user.index', ['users' => $users, 'user'=> $user_logado]);
            }else{

                $error = 'You have not premissions';
                Session::set('error',$error);
                Redirect::toRoute('home/error');
            }

        }

    }

    public function create()
    { $user_logado = null;

        if(Session::has('user')){
            $user_logado = Session::get('user');
        }

        if(!is_null($user_logado)){

            if($user_logado->role == 'admin'){
                return View::make('user.create', ['user' => $user_logado]);

            }else{
                $error = 'You have not premissions';
                Session::set('error',$error);
                Redirect::toRoute('home/error');
            }
        }
    }

    public function createuser()
    {
        return View::make('user.createuser');
    }

    public function store()
    {

        $user = new User(Post::getAll());

        $user->password = md5($user->password, false);

        if ($user->role == null ){

            $user->role = 'user';
        }

        if($user->is_valid()){
            $user->save();
            Redirect::toRoute('user/login');
        } else {
            Redirect::flashToRoute('user/create', ['user' => $user]);
        }
    }

    public function show($id)
    {
        $user_logado = null;

        if(Session::has('user')){
            $user_logado = Session::get('user');
        }
        $user = User::find([$id]);

    if(!is_null($user_logado)){

    if (is_null($user)) {
        $error = 'No user';
        Session::set('error',$error);
        Redirect::toRoute('home/error');
    }else{
        if($user_logado->id_user == $id){
            return View::make('user.show', ['user' => $user, 'user_logado' => $user_logado]);

        }else {
            $error = 'No premissions';
            Session::set('error',$error);
            Redirect::toRoute('home/error');
        }
    }
    }else {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }
    }

    public function edit($id)
    {
        $user = User::find([$id]);

        if (is_null($user)) {
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        } else {
            return View::make('user.edit', ['user' => $user]);
        }
    }

    public function update($id)
    {
        $user = User::find([$id]);
        $user->update_attributes(Post::getAll());

        $user->password = md5($user->password, false);

        if($user->is_valid()){
            $user->save();
            Redirect::toRoute('user/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('user/edit', ['user' => $user]);
        }    }

    public function destroy($id)
    {

        $tickets = Ticket::find_by_id_user($id);

        $user_logado = null;

            if(Session::has('user'))
                $user_logado = Session::get('user');

            if(!is_null($user_logado))
            {
                if($user_logado->role == 'admin'){
                    if ($tickets != null)
                    {
                        $error = 'User has associated ticket(s), deletion is not allowed';
                        Session::set('error',$error);
                        Redirect::toRoute('home/error');
                    } else {
                        $user = User::find([$id]);
                        $user->delete();
                        Redirect::toRoute('user/index');
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


    public function login()
    {
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            Redirect::toRoute('user/index');
        }else{
            return View::make('user.login');

        }
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
           Session::set('user',$user);
           Redirect::toRoute('home/start');
       }

    }

    public function logout()
    {

        Session::destroy();
        Redirect::toRoute('home/start');
    }


}