<?php


class Airport
{
public $id_airport;
public $email;
public $localization;
public $name;
public $telephone;

public function __construct($id_airport,$email,$localization,$name,$telephone)
    {
        $this->id_airport=$id_airport;
        $this->email=$email;
        $this->localization=$localization;
        $this->name=$name;
        $this->telephone=$telephone;
    }
}
