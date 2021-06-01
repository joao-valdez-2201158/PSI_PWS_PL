<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\View;
use Stopover;
class StopoverController extends BaseController implements ResourceControllerInterface

{

    public function index()
    {
        $stopovers = Stopover::all();
        return View::make('stopover.index', ['stopovers' => $stopovers]);
    }

    public function create()
    {
        return View::make('stopover.create');
    }

    public function store()
    {

        $stopover = new Stopover(Post::getAll());

        if($stopover->is_valid()){
            $stopover->save();
            Redirect::toRoute('stopover/index');
        } else {
            Redirect::flashToRoute('stopover/create', ['stopover' => $stopover]);
        }
    }

    public function show($id)
    {
        $stopover = Stopover::find([$id]);


        if (is_null($stopover)) {

        } else {
            return View::make('stopover.show', ['stopover' => $stopover]);
        }
    }

    public function edit($id)
    {
        $stopover = Stopover::find([$id]);

        if (is_null($stopover)) {
        } else {
            return View::make('stopover.edit', ['stopover' => $stopover]);
        }    }

    public function update($id)
    {
        $stopover = Stopover::find([$id]);
        $stopover->update_attributes(Post::getAll());

        if($stopover->is_valid()){
            $stopover->save();
            Redirect::toRoute('stopover/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('stopover/edit', ['stopover' => $stopover]);
        }    }

    public function destroy($id)
    {
        $stopover = Stopover::find([$id]);
        $stopover->delete();
        Redirect::toRoute('stopover/index');
    }

}