<?php

use ActiveRecord\Model;

class Airplane extends Model
{
    static $validates_presence_of = array(
        array('reference'),
        array('airplanetype'),
        array('lotation')
    );

    static $has_many = array(
        array('stopovers', 'class_name' => 'Stopover', 'foreign_key' => 'id_airplane')
    );
}