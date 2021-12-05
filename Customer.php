<?php
require_once "./Rental.php";
require_once "./StatementFormat.php";

class Customer
{
    private $_name;
    private $_rentals = [];
    private $_statementFormat;

    public function __construct($name)
    {
        $this->_name = $name;
        $this->_statementFormat = new TextFormat();
    }

    public function setFormatType($type)
    {
        switch($type){
            case FormatType::TEXT :
                $this->_statementFormat = new TextFormat();
                break ;
            case FormatType::JSON :
                $this->_statementFormat = new JsonFormat();
                break ;
            default :
                $this->_statementFormat = new TextFormat();                
        }
    }

    public function addRental(Rental $arg)
    {
        $this->_rentals[] = $arg;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function statement()
    {
        $totalAmount = 0;
        $rewardPoints = 0;
        $statement;

        $this->_statementFormat->setName($this->getName());

        foreach ($this->_rentals as $eachRental) {
            $amount = $eachRental->getVehicle()->getAmount($eachRental->getMileage(), $eachRental->getDaysRented(),$eachRental->isLate()) ;
            
            if(!$eachRental->isLate())
                $rewardPoints = $eachRental->getVehicle()->getReward($rewardPoints,$eachRental->getDaysRented()) ;

            // Add rental to statement
            $this->_statementFormat->setRental($eachRental->getVehicle()->getMakeAndModel(), $amount);

            $totalAmount += $amount;
        }

        // Add footers
        $this->_statementFormat->setTotalAmount($totalAmount);
        $this->_statementFormat->setRewardPoints($rewardPoints);

        return $this->_statementFormat->printStatement();
    }
}
