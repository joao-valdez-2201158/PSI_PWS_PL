<?php


use ActiveRecord\Model;

class Ticket extends Model
{
    static $validates_presence_of = array(
        array('id_user'),
        array('id_departure_flight'),
        array('price'),
        array('date'),
        array('hour')

    );

    static $belongs_to = array(
        array('user', 'class_name' => 'User', 'foreign_key' => 'id_user'),
        array('departure_flight', 'class_name' => 'Flight', 'foreign_key' => 'id_departure_flight'),
        array('return_flight', 'class_name' => 'Flight', 'foreign_key' => 'id_return_flight')
    );

    public function update_attributes($attributes)
    {
        if($attributes['id_return_flight'] == '')
            $attributes['id_return_flight'] = NULL;

        $this->set_attributes($attributes);
        return $this->save();
    }


}