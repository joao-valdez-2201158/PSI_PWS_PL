<?php


class Stopover
{
public $id_stop_over;
public $hour_of_departure;
public $hour_of_arrival;
public $id_destination;
public $id_departure;

    /**
     * Stopover constructor.
     */
    public function __construct($id_stop_over,$hour_of_arrival,$hour_of_departure,$id_departure,$id_destination)
    {
        $this->id_stop_over=$id_stop_over;
        $this->hour_of_departure=$hour_of_departure;
        $this->hour_of_arrival=$hour_of_arrival;
        $this->id_destination=$id_destination;
        $this->id_departure=$id_departure;
    }

}