<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\View;

class FinanceController extends BaseController implements ResourceControllerInterface
{

    public function index()
    {
        $finances = Finance::all();
        return View::make('finances.index',['finances' => $finances]);
    }

    public function create()
    {
        return View::make('finances.create');
    }

    public function store()
    {
        // TODO: Implement store() method.
    }

    public function show($id)
    {
        $finance = Finance::find[$id];
        return View::make('finances.show',['finance' => $finance]);
    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
    }

    public function update($id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}