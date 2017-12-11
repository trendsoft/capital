<?php

namespace tests\Unit;

use Capital\Money;
use Tests\TestCase;

class MoneyTest extends TestCase {
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testStringMoney() {
		new Money( 'bs' );
	}

	public function testFloatMoney() {
		$money = new Money( 999.02 );
		$this->assertInstanceOf( Money::class, $money );
	}

	public function testFloatMoney2() {
		$money = new Money( '999.02' );
		$this->assertInstanceOf( Money::class, $money );
	}

	public function testIntMoney() {
		$money = new Money( 999 );
		$this->assertInstanceOf( Money::class, $money );
	}

	public function testIntMoney2() {
		$money = new Money( '999' );
		$this->assertInstanceOf( Money::class, $money );
	}


}
