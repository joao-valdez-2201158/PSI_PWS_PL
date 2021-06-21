<?php


use ActiveRecord\Model;

class Stopover extends Model
{

    static $validates_presence_of = array(
        array('id_flight'),
        array('id_departure'),
        array('id_destination'),
        array('date_of_departure'),
        array('hour_of_departure'),
        array('date_of_arrival'),
        array('hour_of_arrival'),
        array('distance')

    );

}