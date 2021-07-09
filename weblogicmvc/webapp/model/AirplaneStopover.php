<?php


use ActiveRecord\Model;

class AirplaneStopover extends Model
{

    public static $table_name = 'airplanesstopovers';

    static $validates_presence_of = array(
        array('id_stopover'),
        array('id_airplane'),
        array('passengers_quantity')
    );

    static $belongs_to = array(
        array('airplane', 'class_name' => 'Airplane', 'foreign_key' => 'id_airplane'),
        array('stopover', 'class_name' => 'Stopover', 'foreign_key' => 'id_stopover')
    );
}