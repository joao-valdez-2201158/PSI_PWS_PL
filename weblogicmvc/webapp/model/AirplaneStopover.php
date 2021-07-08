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

}