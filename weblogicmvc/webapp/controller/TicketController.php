<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Session;
class TicketController extends BaseController implements ResourceControllerInterface
{

    public function index()
    {
        $tickets = Ticket::all();
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(!is_null($user_logado))
        {
            if($user_logado->role == 'op' || $user_logado->role == 'user' || $user_logado->role == 'gest'){
                return View::make('ticket.index', ['tickets' => $tickets, 'user' => $user_logado]);
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
            if($user_logado->role == 'op'){
                return View::make('ticket.create', ['user' => $user_logado]);
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
        $ticket = new Ticket(Post::getAll());
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado)){
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

        if($ticket->is_valid()){
            $ticket->save();
            Redirect::toRoute('ticket/index');
        }
        else
        {
            Redirect::flashToRoute('ticket/create', ['ticket' => $ticket, 'user' => $user_logado]);
        }
    }

    public function show($id)
    {
        $ticket = Ticket::find([$id]);
        $stopovers = Stopover::all();
        $airports = Airport::all();

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado)){
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

        if (is_null($ticket))
        {
            if(is_null($user_logado)){
                $error = 'First Login';
                Session::set('error',$error);
                Redirect::toRoute('home/usererror');
            }else{
                $error = 'Ticket does not exists';
                Session::set('error',$error);
                Redirect::toRoute('home/error');

            }
        }
        else
        {
            return View::make('ticket.show', ['ticket' => $ticket, 'user' => $user_logado, 'stopovers' => $stopovers, 'airports' => $airports]);
        }

    }


    public function edit($id)
    {
        $ticket = Ticket::find([$id]);

        $user_logado = null;

        if (Session::has('user'))
            $user_logado = Session::get('user');


        if(!is_null($user_logado))
        {
            if($user_logado->role == 'op'){
                return View::make('ticket.edit', ['ticket' => $ticket, 'user' => $user_logado]);
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

        if (is_null($ticket))
        {
            if(is_null($user_logado)){
                $error = 'First Login';
                Session::set('error',$error);
                Redirect::toRoute('home/usererror');
            }else{
                $error = 'Ticket does not exists';
                Session::set('error',$error);
                Redirect::toRoute('home/error');

            }
        }

    }

    public function update($id)
    {

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if(is_null($user_logado)){
            $error = 'First Login';
            Session::set('error',$error);
            Redirect::toRoute('home/usererror');
        }

        $ticket = Ticket::find([$id]);
        $ticket->update_attributes(Post::getAll());

        $pontos = 0;
        if($ticket->check_in == true){

            foreach ($ticket->departure_flight->stopovers as $stopover){
                $pontos += $stopover->distance / 100;
            }

        }

        if($ticket->check_in_return == true){
            if($ticket->return_flight != null){
                foreach ($ticket->return_flight->stopovers as $stopover){
                    $pontos += $stopover->distance / 100;
                }
            }
        }

        if($ticket->is_valid()){
            $ticket->save();
            $ticket->user->points += $pontos;
            $ticket->user->save();
            Redirect::toRoute('ticket/index');
        } else {
            //obs: redirect to form with data and errors
            Redirect::flashToRoute('ticket/edit', ['ticket' => $ticket, 'user' => $user_logado]);
        }

    }

    public function destroy($id)

        {
            $user_logado = null;

            if(Session::has('user'))
                $user_logado = Session::get('user');

            if(!is_null($user_logado))
            {
                if($user_logado->role == 'op'){
                    $ticket = Ticket::find([$id]);
                    $ticket->delete();
                    Redirect::toRoute('ticket/index');

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