<?php

abstract class FormatType
{
    const JSON = 0;
    const TEXT = 1;
}

abstract class StatementFormat {
    private $_statement;
    abstract public function setName($name);
    abstract public function setRental($rental, $amount);
    abstract public function setTotalAmount($totalAmount);
    abstract public function setRewardPoints($rewardPoints);
    abstract public function printStatement();
}

class JsonFormat extends StatementFormat {

    public function __construct()
    {
        $this->_statement = new stdObject();
    }
    
    public function setName($name){

        $this->_statement->name = "Rental Record for: ".$name ;
    }

    public function setRental($rental, $amount){
        if(!$this->_statement->rentals)
        {
            $this->_statement->rentals = array([]) ;
        }
        array_push($this->_statement->rentals, $rental.getVehicle().getMakeAndModel() . "\"\tLE " . number_format($amount,2,'.',''));
    }

    public function setTotalAmount($totalAmount){
        $this->_statement->totalAmount = "Amount owed is LE " . number_format($totalAmount,2,'.','') ;
    }

    public function setRewardPoints($rewardPoints){
        $this->_statement->rewardPoints = "You earned: " . $rewardPoints . " new Reward Points" ;
    }

    public function printStatement(){
        $statement = json_encode($this->_statement);
        $this->_statement = new stdObject();
        return $statement;
    }

}

class TextFormat extends StatementFormat {

    public function __construct()
    {
        $this->_statement = "";
    }
    
    public function setName($name){

        $this->_statement .=  "Rental Record for:" . $name . "\n";
    }

    public function setRental($rental, $amount){

        $this->_statement .= "\t\"" . $rental->getVehicle()->getMakeAndModel() . "\"\tLE " .
        number_format($amount,2,'.','') . "\n";
    }

    public function setTotalAmount($totalAmount){
        $this->_statement .= "Amount owed is LE " . number_format($totalAmount,2,'.','') . "\n";
    }

    public function setRewardPoints($rewardPoints){
        $this->_statement .= "You earned: " . $rewardPoints . " new Reward Points\n\n";
    }

    public function printStatement(){
        $statement = $this->_statement;
        $this->_statement = "";
        return $statement;
    }
}

?>