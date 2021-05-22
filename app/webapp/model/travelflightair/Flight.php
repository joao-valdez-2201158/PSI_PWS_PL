<?php



class Flight
{
public $id_airplane;
public $id_number;
public $price;
    public function __construct($id_airplane, $id_number, $price)
    {
        $this->id_airplane=$id_airplane;
        $this->id_number=$id_number;
        $this->price=$price;
    }
}
