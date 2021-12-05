<?php

class Rental
{
    private $_vehicle;
    private $_kilometersRented;
    private $_daysRented;
    private $_lateFee;

    public function __construct($vehicle, $mileage, $daysRented, $lateFee)
    {
        $this->_vehicle = $vehicle;
        $this->_kilometersRented = $mileage;
        $this->_daysRented = $daysRented;
        $this->_lateFee = $lateFee;
    }

    public function getMileage()
    {
        return $this->_kilometersRented;
    }

    public function getVehicle()
    {
        return $this->_vehicle;
    }

    public function getDaysRented()
    {
        return $this->_daysRented;
    }

    public function isLate()
    {
        return $this->_lateFee;
    }
}