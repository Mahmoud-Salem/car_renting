<?php
use PHPUnit\Framework\TestCase;
require_once "./Customer.php";
require_once "./Rental.php";
require_once "./Vehicle.php";

final class CharacterizationTest extends TestCase
{
    public function testMatchCurrentBehavior() {
        $blueHonda = new Sedan("Blue Honda 2008");
        $greyJeep = new FourxFour("Grey Jeep 2013");
        $RedSunny = new Sedan("Red Sunny 2014");
        $BlueBMW = new SUV("Blue X3 2017");

        $hondaRental = new Rental($blueHonda, 431, 4, false);
        $jeepRental = new Rental($greyJeep, 744, 4, false);
        $sunnnyRental = new Rental($RedSunny, 591, 3, true);
        $x3Rental = new Rental($BlueBMW, 240, 5, false);

        $apple = new Customer("Apple Corp.");
        $google = new Customer("Alphabet Inc.");

        $apple->addRental($hondaRental);
        $apple->addRental($jeepRental);
        $apple->addRental($sunnnyRental);

        $google->addRental($x3Rental);

        $this->assertEquals(
            "Rental Record for:Apple Corp.\n\t\"Blue Honda 2008\"\tLE 912.00\n\t\"Grey Jeep 2013\"\tLE 850.00\n\t\"Red Sunny 2014\"\tLE 1268.96\nAmount owed is LE 3030.96\nYou earned: 4 new Reward Points\n\n",
            $apple->statement());

        $this->assertEquals(
            "Rental Record for:Alphabet Inc.\n\t\"Blue X3 2017\"\tLE 760.00\nAmount owed is LE 760.00\nYou earned: 1 new Reward Points\n\n",
            $google->statement());
    }
}
