<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use User;
use Ticket;

class TicketController extends BaseController implements ResourceControllerInterface
{

    public function index()
    {
        $tickets = Ticket::all();
        return View::make('ticket.index', ['tickets' => $tickets]);
    }

    public function create()
    {
        return View::make('ticket.create');
    }

    public function store()
    {
        $ticket = new Ticket(Post::getAll());

        if($ticket->is_valid()){
            $ticket->save();
            Redirect::toRoute('ticket/index');
        } else {
            Redirect::flashToRoute('ticket/create', ['ticket' => $ticket]);
        }
    }

    public function show($id)
    {
        $ticket= Ticket::find($id);

        if (is_null($ticket)) {

        } else {
            return View::make('ticket.show', ['ticket' => $ticket]);
        }
    }

    public function edit($id)
    {
        $ticket = Ticket::find([$id]);

        if (is_null($ticket)) {
        } else {
            return View::make('ticket.edit', ['ticket' => $ticket]);
        }    }

    public function update($id)
    {
        $ticket = Ticket::find([$id]);
        $ticket->update_attributes(Post::getAll());

        if($ticket->is_valid()){
            $ticket->save();
            Redirect::toRoute('ticket/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('ticket/edit', ['ticket' => $ticket]);
        }    }

    public function destroy($id)
    {
        $ticket = Ticket::find([$id]);
        $ticket->delete();
        Redirect::toRoute('ticket/index');
    }

    public function login()
    {
        return View::make('ticket.login');

    }



}