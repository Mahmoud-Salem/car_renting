<?php
use PHPUnit\Framework\TestCase;
require_once "./Customer.php";
require_once "./Rental.php";
require_once "./Vehicle.php";
require_once "./StatementFormat.php";

final class BillingTest extends TestCase
{
    public function testFourxFour() {
        $jeep = new FourxFour("Grey Jeep 2013");
        $price = $jeep->getAmount(300,11,true);
        $rewards = $jeep->getReward(2,15);
        $this->assertEquals($price, 2201.625, 'Check for the correct price for 4x4 rental');
        $this->assertEquals($rewards, 6, 'Check rewards points for 4x4 rental');
    }

    public function testSedan() {
        $sunny = new Sedan("Red Sunny 2014");
        $price = $sunny->getAmount(300,2,true);
        $rewards = $sunny->getReward(2,15);
        $this->assertEquals($price, 669.5, 'Check for the correct price for sedan rental');
        $this->assertEquals($rewards, 3, 'Check rewards points for sedan rental');
    }

    public function testSUV() {
        $bmw = new SUV("Blue X3 2017");
        $price = $bmw->getAmount(300,2,true);
        $rewards = $bmw->getReward(2,15);
        $this->assertEquals($price, 655.595, 'Check for the correct price for suv rental');
        $this->assertEquals($rewards, 13, 'Check rewards points for suv rental');
    }

    public function testJSONStatement() {
        $statement = new JsonFormat(); 
        $statement->setName("Mahmoud");
        $statement->setRental("Blue Sunny", 50.21);
        $statement->setRental("Blue Sunny", 50.21);
        $statement->setTotalAmount(50.22);
        $statement->setRewardPoints(4);

        $correctFormat = new \stdClass;
        $correctFormat->name = "Mahmoud";
        $correctFormat->rentals = array("Blue Sunny" . " LE " . number_format(50.21,2,'.',''), "Blue Sunny" . " LE " . number_format(50.21,2,'.',''));
        $correctFormat->totalAmount= 50.22 . " LE";
        $correctFormat->rewardPoints= 4  . " new Reward Points";

        $jsonFormat = json_encode($correctFormat);
        $this->assertEquals($statement->printStatement(), $jsonFormat, 'Check if json format is correct');
    }

    public function testTextStatement() {
        $statement = new TextFormat(); 
        $statement->setName("Mahmoud");
        $statement->setRental("Blue Sunny", 50.21);
        $statement->setTotalAmount(50.22);
        $statement->setRewardPoints(4);
        
        $textFormat = "Rental Record for:Mahmoud\n\t\"Blue Sunny\"\tLE 50.21\nAmount owed is LE 50.22\nYou earned: 4 new Reward Points\n\n";

        $this->assertEquals($statement->printStatement(), $textFormat, 'Check if text format is correct');
    }

    public function testIntegration1() {
        $blueHonda = new Sedan("Blue Honda 2008");
        $greyJeep = new FourxFour("Grey Jeep 2013");
        $RedSunny = new Sedan("Red Sunny 2014");

        $hondaRental = new Rental($blueHonda, 431, 4, false);
        $jeepRental = new Rental($greyJeep, 744, 4, false);
        $sunnnyRental = new Rental($RedSunny, 591, 3, true);

        $apple = new Customer("Apple Corp.");
        $apple->addRental($hondaRental);
        $apple->addRental($jeepRental);
        $apple->addRental($sunnnyRental);

        $this->assertEquals(
            "Rental Record for:Apple Corp.\n\t\"Blue Honda 2008\"\tLE 912.00\n\t\"Grey Jeep 2013\"\tLE 850.00\n\t\"Red Sunny 2014\"\tLE 1268.96\nAmount owed is LE 3030.96\nYou earned: 4 new Reward Points\n\n",
            $apple->statement(), 'Integration Test with Sedan, FourxFour and Text statement');
    }

    public function testIntegration2() {

        $BlueBMW = new SUV("Blue X3 2017");

        $x3Rental = new Rental($BlueBMW, 240, 5, false);

        $google = new Customer("Alphabet Inc.");
        $google->addRental($x3Rental);
        $google->setFormatType(FormatType::JSON);


        $correctFormat = new \stdClass;
        $correctFormat->name = "Alphabet Inc.";
        $correctFormat->rentals = array("Blue X3 2017" . " LE " . number_format(760.00,2,'.',''));
        $correctFormat->totalAmount= 760 . ".00 LE";
        $correctFormat->rewardPoints= 1  . " new Reward Points";


        $this->assertEquals(json_encode($correctFormat),
            $google->statement(), 'Integration Test with SUV and JSON statement');

    }

}

