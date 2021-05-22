<?php

class Airplane extends model
{
    public $id_airplane;
    public $airplane_type;
    public $lotation;
    public $reference;

    public function __construct($airplane_type,$id_airplane,$lotation,$reference)
    {
        $this->airplane_type=$airplane_type;
        $this->id_airplane=$id_airplane;
        $this->lotation=$lotation;
        $this->reference=$reference;
    }
}