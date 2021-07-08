<?php


use ActiveRecord\Model;

class Flight extends Model
{
    static $validates_presence_of = array(
        array('price')

    );

    static $has_many = array(
        array('stopovers', 'class_name' => 'Stopover', 'foreign_key' => 'id_flight')
   );
}
