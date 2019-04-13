<?php

namespace App\Repository\Siranap;

use App\Service\Siranap\ServiceSiranap;

class Siranap 
{
    protected $siranap;

    public function __construct()
    {
        $this->siranap = new ServiceSiranap;
    }

    public function getSearch()
    {
        $data = $this->siranap->getSiranap();
        return $data;
    }
}