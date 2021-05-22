<?php


class Ticket
{
public $id_user;
public $flight_if_number;
public $id_departure_flight;
public $id_return_flight;
public $price;
public $date;
public $check_in;

    public function __construct($id_user, $flight_if_number, $check_in,$date,$id_departure_flight,$id_return_flight,$price)
    {
        $this->id_user=$id_user;
        $this->flight_if_number=$flight_if_number;
        $this->check_in=$check_in;
        $this->date=$date;
        $this->id_departure_flight=$id_departure_flight;
        $this->id_return_flight=$id_return_flight;
        $this->price=$price;
    }
}