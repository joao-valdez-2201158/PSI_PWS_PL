<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\View;
use Airplane;
class AirplaneController extends BaseController implements ResourceControllerInterface
{

    public function index()
    {
        $airplanes = Airplane::all();
        return View::make('airplane.index', ['airplanes' => $airplanes]);
    }

    public function create()
    {
        return View::make('airplane.create');
    }

    public function store()
    {

        $airplane = new Airplane(Post::getAll());

        if($airplane->is_valid()){
            $airplane->save();
            Redirect::toRoute('airplane/index');
        } else {
            Redirect::flashToRoute('airplane/create', ['airplane' => $airplane]);
        }
    }

    public function show($id)
    {
        $airplane = Airplane::find([$id]);


        if (is_null($airplane)) {

        } else {
            return View::make('airplane.show', ['airplane' => $airplane]);
        }
    }

    public function edit($id)
    {
        $airplane = Airplane::find([$id]);

        if (is_null($airplane)) {
        } else {
            return View::make('airplane.edit', ['airplane' => $airplane]);
        }    }

    public function update($id)
    {
        $airplane = Airplane::find([$id]);
        $airplane->update_attributes(Post::getAll());

        if($airplane->is_valid()){
            $airplane->save();
            Redirect::toRoute('airplane/index');
        } else {
            //redirect to form with data and errors
            Redirect::flashToRoute('airplane/edit', ['airplane' => $airplane]);
        }    }

    public function destroy($id)
    {
        $airplane = Airplane::find([$id]);
        $airplane->delete();
        Redirect::toRoute('airplane/index');
    }


}