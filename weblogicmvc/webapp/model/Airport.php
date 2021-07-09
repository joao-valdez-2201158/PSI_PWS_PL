<?php


use ActiveRecord\Model;

class Airport extends Model
{
    static $validates_presence_of = array(
        array('name'),
        array('localization'),
        array('telephone'),
        array('email')

    );

    static $has_many = array(
        array('departure_airport', 'class_name' => 'Stopover', 'foreign_key' => 'id_departure_airport'),
        array('destination_airport', 'class_name' => 'Stopover', 'foreign_key' => 'id_destination_airport')

    );

}
