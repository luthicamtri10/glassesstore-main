<?php

namespace App\Models;

class CPVC
{
    private $IDTINH;
    private $IDVC;
    private $CHIPHIVC;

    public function __construct($IDTINH, $IDVC, $CHIPHIVC)
    {
        $this->IDTINH = $IDTINH;
        $this->IDVC = $IDVC;
        $this->CHIPHIVC = $CHIPHIVC;
    }

    // Getters
    public function getIDTINH()
    {
        return $this->IDTINH;
    }

    public function getIDVC()
    {
        return $this->IDVC;
    }

    public function getCHIPHIVC()
    {
        return $this->CHIPHIVC;
    }

    // Setters
    public function setIDTINH($IDTINH)
    {
        $this->IDTINH = $IDTINH;
    }

    public function setIDVC($IDVC)
    {
        $this->IDVC = $IDVC;
    }

    public function setCHIPHIVC($CHIPHIVC)
    {
        $this->CHIPHIVC = $CHIPHIVC;
    }
}
