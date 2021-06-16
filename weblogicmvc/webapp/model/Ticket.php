<?php


use ActiveRecord\Model;

class Ticket extends Model
{
    static $validates_presence_of = array(
        array('id_user'),
        array('id_departure_flight'),
        array('id_return_flight'),
        array('price'),
        array('date'),
        array('check_in')

    );
}