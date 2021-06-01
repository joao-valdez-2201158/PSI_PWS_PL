<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\View;
use Airport;
class AirportController extends BaseController implements ResourceControllerInterface

{

    public function index()
    {
        $airports = Airpor::all();
        return View::make('airport.index', ['airports' => $airports]);
    }

    public function create()
    {
        return View::make('airport.create');
    }

    public function store()
    {

        $airport = new Airport(Post::getAll());

        if($airport->is_valid()){
            $airport->save();
            Redirect::toRoute('airport/index');
        } else {
            Redirect::flashToRoute('airport/create', ['airport' => $airport]);
        }
    }

    public function show($id)
    {
        $airport = Airport::find([$id]);


        if (is_null($airport)) {

        } else {
            return View::make('airport.show', ['airport' => $airport]);
        }
    }

    public function edit($id)
    {
        $airport = Airport::find([$id]);

        if (is_null($airport)) {
        } else {
            return View::make('airport.edit', ['airport' => $airport]);
        }    }

    public function update($id)
    {
        $airport = Airport::find([$id]);
        $airport->update_attributes(Post::getAll());

        if($airport->is_valid()){
            $airport->save();
            Redirect::toRoute('airport/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('airport/edit', ['airport' => $airport]);
        }    }

    public function destroy($id)
    {
        $airport = Airport::find([$id]);
        $airport->delete();
        Redirect::toRoute('airport/index');
    }

}