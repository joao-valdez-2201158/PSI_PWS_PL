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
}
