<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
class FlightController extends BaseController implements ResourceControllerInterface

{

    public function index()
    {
        $flights = Flight::all();
        return View::make('flight.index', ['flights' => $flights]);
    }

    public function create()
    {
        return View::make('flight.create');
    }

    public function store()
    {

        $flight = new Flight(Post::getAll());

        if($flight->is_valid()){
            $flight->save();
            Redirect::toRoute('flight/index');
        } else {
            Redirect::flashToRoute('flight/create', ['fligh' => $flight]);
        }
    }

    public function show($id)
    {
        $flight = Flight::find([$id]);


        if (is_null($flight)) {

        } else {
            return View::make('flight.show', ['flight' => $flight]);
        }
    }

    public function edit($id)
    {
        $flight = Flight::find([$id]);

        if (is_null($flight)) {
        } else {
            return View::make('fligh.edit', ['flight' => $flight]);
        }    }

    public function update($id)
    {
        $flight = Flight::find([$id]);
        $flight->update_attributes(Post::getAll());

        if($flight->is_valid()){
            $flight->save();
            Redirect::toRoute('flight/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('flight/edit', ['flight' => $flight]);
        }    }

    public function destroy($id)
    {
        $flight = Flight::find([$id]);
        $flight->delete();
        Redirect::toRoute('flight/index');
    }

}