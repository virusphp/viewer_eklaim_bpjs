<?php

namespace App\Repository\Bed;

use App\Service\Bed\ServiceBed;

class Bed 
{
    protected $bed;

    public function __construct()
    {
        $this->bed = new ServiceBed;
    }

    public function getSearch()
    {
        $data = $this->bed->getBed();
        return $data;
    }
}