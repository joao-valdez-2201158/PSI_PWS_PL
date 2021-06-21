<?php

use ActiveRecord\Model;

class Airplane extends Model
{
    static $validates_presence_of = array(
        array('reference'),
        array('airplanetype'),
        array('lotation')
    );
}