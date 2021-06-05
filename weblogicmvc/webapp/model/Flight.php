<?php


use ActiveRecord\Model;

class Flight extends Model
{
    static $validates_presence_of = array(
        array('id_flight'),
        array('id_airplane'),
        array('id_stopover'),
        array('price')

    );
}
