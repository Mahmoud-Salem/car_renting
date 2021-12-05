<?php

abstract class Vehicle
{
    private $_makeAndModel;
    
    public function __construct($makeAndModel)
    {
        $this->_makeAndModel = $makeAndModel;
    }

    public function getMakeAndModel()
    {
        return $this->_makeAndModel;
    }

    public function getAmount($mileage, $daysRented, $isLate): float {
        return 50.0 ;
    }
     public function getReward($rewardPoints, $daysRented): int {
        return ++$rewardPoints ;
    }

}

class Sedan extends Vehicle {

    public function getAmount($mileage, $daysRented, $isLate): float {
        $amount = 50.0;

        $amount += 100 * $daysRented ;
        if ($mileage > $daysRented * 50) {
            $amount += ($mileage - $daysRented * 50) * 2;
        }

        if($isLate)
            $amount += $amount * 0.03;

        return $amount ;
    }

    public function getReward($rewardPoints, $daysRented): int {
        return ++$rewardPoints ;
    }   
}

class FourxFour extends Vehicle {

    public function getAmount($mileage, $daysRented, $isLate): float {
        $amount = 50.0;

        $amount += 200 * $daysRented;
        if($mileage >= 200 && $daysRented > 10){
            $amount -= $amount * 0.05;
        }

        if($isLate)
            $amount += $amount * 0.03;

        return $amount ;
    }
    
    public function getReward($rewardPoints, $daysRented): int {
        $rewardPoints++ ;
        $rewardPoints *=2 ;
        return $rewardPoints ;    
    }   
}

class SUV extends Vehicle {

    public function getAmount($mileage, $daysRented, $isLate): float {
        $amount = 50.0;

        $amount += 150 * $daysRented;
        if ($mileage > $daysRented * 70)
            $amount += ($mileage - $daysRented * 70) * 2;

        if($mileage >= 200)
            $amount -= $amount * 0.05;

        if($isLate)
            $amount += $amount * 0.03;

        return $amount ;
    }
    
    public function getReward($rewardPoints, $daysRented): int {
        $rewardPoints++ ;
        
        if($daysRented > 5)
            $rewardPoints += ($daysRented - 5);

        return $rewardPoints ;
    }   
}