<?php

namespace Capital;

class Money {
	private $money;
	private $uppers = [ '零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖' ];
	private $units = [ '分', '角' ];
	private $grees = [ '元', '拾', '佰', '仟', '万', '拾', '佰', '仟', '亿', '拾', '佰', '仟', '万', '拾', '佰' ];
	private $isInt = false;
	private $_intPartArray = [];
	private $isFloat = false;
	private $_floatPartArray = [];
	private $likeInt = false;

	public function __construct( $money ) {
		if ( ! ( is_float( $money ) || is_numeric( $money ) || is_int( $money ) ) ) {
			throw new \InvalidArgumentException( $money );
		}
		if ( is_int( $money ) ) {
			$this->isInt = true;
		} else {
			$this->isFloat = false;
		}
		if ( $money > 1 ) {
			$this->likeInt = true;
		}
		$this->money = number_format( $money, 2, '.', '' );
	}

	/**
	 * Convert to Capital
	 * @return string
	 */
	public function toCapital(): string {
		@list( $intPart, $decimalPart ) = explode( '.', $this->money, 2 );
		$result = $this->getIntPart( $intPart );
		$result .= $this->getDecimalPart( $decimalPart );


		return $result;
	}

	public function getIntPart( $intPart ) {
		$gree = strlen( $intPart ) - 1;
		if ( $intPart > 0 ) {
			for ( $i = 0; $i < strlen( $intPart ); $i ++ ) {
				$num                   = $intPart[ $i ];
				$this->_intPartArray[] = $this->uppers[ $num ] . $this->grees[ $gree -- ];
			}
		} else {

		}
	}

	public function getDecimalPart( $decimalPart ) {
		if ( $decimalPart > 0 ) {
			//处理小数部分
			$unit = strlen( $decimalPart ) - 1;
			for ( $i = 0; $i < strlen( $decimalPart ); $i ++ ) {
				$num                     = $decimalPart[ $i ];
				$this->_floatPartArray[] = $this->uppers[ $num ] . $this->units[ $unit -- ];
			}
		}

		if ( $this->likeInt ) {
			foreach ( $this->_floatPartArray as $key => $value ) {
				if ( $value == '零角' ) {
					$this->_floatPartArray[ $key ] = '零';
				}
				if ( $value == '零分' ) {
					unset( $this->_floatPartArray[ $key ] );
				}
			}
		} else {
			foreach ( $this->_floatPartArray as $key => $value ) {
				if ( $value == '零角' || $value == '零分' ) {
					unset( $this->_floatPartArray[ $key ] );
				}
			}
		}

		return implode( '', $this->_floatPartArray );
	}
}
