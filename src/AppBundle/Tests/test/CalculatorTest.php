<?php
// // src/AppBundle/Tests/test/CalculatorTest.php
namespace AppBundle\Tests\test;

use AppBundle\Utils\Calculator;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
	public function testAdd()
	{
		$calc = new Calculator();
		$result = $calc->add(30, 12);
		
		// assert that your calculator added the numbers correctly!
		$this->assertEquals(42, $result);
	}
}
?>