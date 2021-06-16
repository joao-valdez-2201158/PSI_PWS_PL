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

        return View::make('ticket.index', ['tickets' => $tickets, 'user' => $user_logado]);
    }

    public function create()
    {
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');


        return View::make('ticket.create', ['user' => $user_logado]);
    }

    public function store()
    {
        $ticket = new Ticket(Post::getAll());
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');


        if($ticket->is_valid()){
            $ticket->save();
            Redirect::toRoute('ticket/index');
        } else {
            Redirect::flashToRoute('ticket/create', ['ticket' => $ticket, 'user' => $user_logado]);
        }
    }

    public function show($id)
    {
        $ticket= Ticket::find($id);
        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if (is_null($ticket)) {

        } else {
            return View::make('ticket.show', ['ticket' => $ticket, 'user' => $user_logado]);
        }
    }

    public function edit($id)
    {
        $ticket = Ticket::find([$id]);

        $user_logado = null;

        if (Session::has('user'))
            $user_logado = Session::get('user');


        if (is_null($ticket))
        {
        } else
        {
            return View::make('ticket.edit', ['ticket' => $ticket, 'user' => $user_logado]);
        }
    }


    public function update($id)
    {
        $ticket = Ticket::find([$id]);
        $ticket->update_attributes(Post::getAll());

        $user_logado = null;

        if(Session::has('user'))
            $user_logado = Session::get('user');

        if($ticket->is_valid()){
            $ticket->save();
            Redirect::toRoute('ticket/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('ticket/edit', ['ticket' => $ticket, 'user' => $user_logado]);
        }

    }

    public function destroy($id)
    {
        $ticket = Ticket::find([$id]);
        $ticket->delete();
        Redirect::toRoute('ticket/index');
    }

    public function buy()
    {
        $user_logado = null;
        if(Session::has('user'))
            $user_logado = Session::get('user');
        return View::make('ticket.buy', ['user' => $user_logado]);
    }

}