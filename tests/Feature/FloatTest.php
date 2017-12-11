<?php

namespace tests\Feature;

use Capital\Money;
use Tests\TestCase;

class FloatTest extends TestCase {
	public function testFloat() {
		$this->assertEquals( ( new Money( 0.01 ) )->toCapital(), '壹分' );
		$this->assertEquals( ( new Money( 0.001 ) )->toCapital(), '零元' );
		$this->assertEquals( ( new Money( 0.09 ) )->toCapital(), '玖分' );
		$this->assertEquals( ( new Money( 1.0 ) )->toCapital(), '壹元' );
		$this->assertEquals( ( new Money( 1.1 ) )->toCapital(), '壹元壹角' );
		$this->assertEquals( ( new Money( 2.0 ) )->toCapital(), '贰元' );
		$this->assertEquals( ( new Money( 2.1 ) )->toCapital(), '贰元壹角' );
		$this->assertEquals( ( new Money( 2.21 ) )->toCapital(), '贰元贰角壹分' );
		$this->assertEquals( ( new Money( 3.05 ) )->toCapital(), '叁元零伍分' );
		$this->assertEquals( ( new Money( 3.005 ) )->toCapital(), '叁元' );
		$this->assertEquals( ( new Money( 999999999999.99911 ) )->toCapital(), '玖仟玖佰玖拾玖亿玖仟玖佰玖拾玖万玖仟玖佰玖拾玖元玖角玖分' );
	}
}
