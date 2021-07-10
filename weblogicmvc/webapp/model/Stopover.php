<?php


use ActiveRecord\Model;

class Stopover extends Model
{
    static $validates_presence_of = array(
       array('id_flight'),
       array('id_departure_airport'),
       array('id_destination_airport'), array('date_of_departure'),
       array('hour_of_departure'),
       array('date_of_arrival'),
       array('hour_of_arrival'),
       array('distance'),
       array('price'),
       array('discount'),

    );

    static $belongs_to = array(
        array('flight', 'class_name' => 'Flight', 'foreign_key' => 'id_flight'),
        array('departure_airport', 'class_name' => 'Airport', 'foreign_key' => 'id_departure_airport'),
        array('arrival_airport', 'class_name' => 'Airport', 'foreign_key' => 'id_destination_airport'),
        array('airplane', 'class_name' => 'Airplane', 'foreign_key' => 'id_airplane'),
    );


}