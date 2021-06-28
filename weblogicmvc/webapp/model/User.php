<?php


use ActiveRecord\Model;

class User extends Model
{
    static $validates_presence_of = array(
        array('name'),
        array('username'),
        array('password'),
        array('telephone'),
        array('email'),
        array('address'),
        array('birthday_date'),
        array('nif'),
        array('role')

    );

    /*static $validates_presence_of = array(
        array('username'),
        array('password')
    );*/

//    static $validates_format_of = array(
//        array('email', 'with' =>
//        '/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/'),
//        array('password', 'with' =>
//        '/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', 'message' => 'is too weak')
//    );
//
//    static $validates_size_of = array(
//        array('password', 'within' => array(8,15), 'too_short' => 'too short!'),
//    );



}