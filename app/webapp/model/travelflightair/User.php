<?php


class User
{
public $adress;
public $birthday_date;
public $id_user;
public $role;
public $telephone;
public $name;
public $email;
public $nif;
public $username;
public $password;

    public function __construct($adress, $telephone,$name,$email,$id_user,$birthday_date,$nif,$password,$role,$username)
    {
        $this->adress= $adress;
        $this->birthday_date;
        $this->id_user=$id_user;
        $this->role=$role;
        $this->telephone=$telephone;
        $this->name=$name;
        $this->email=$email;
        $this->nif=$nif;
        $this->username=$username;
        $this->password=$password;
    }
}