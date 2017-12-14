<?php

/*
 * This file is part of the trendsoft/capital.
 * (c) jabber <2898117012@qq.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Capital;

class Money
{
    private $money;

    private $uppers = [ '零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖' ];

    private $units = [ '分', '角' ];

    private $grees = [ '元', '拾', '佰', '仟', '万', '拾', '佰', '仟', '亿', '拾', '佰', '仟', '万', '拾', '佰' ];

    private $thanOne = false;

    /**
     * Money constructor.
     *
     * @param int|number|string $money default 0
     */
    public function __construct( $money = 0 )
    {
        $this->setMoney( $money );
    }

    /**
     * Get Init Money
     *
     * @return string
     */
    public function getMoney(): string
    {
        return $this->money;
    }

    /**
     * @param int|number|string $money default 0
     */
    public function setMoney( $money = 0 )
    {
        if ( ! ( is_float( $money ) || is_numeric( $money ) || is_int( $money ) ) ) {
            throw new \InvalidArgumentException( $money );
        }
        if ( $money > 1 ) {
            $this->thanOne = true;
        }
        $this->money = number_format( $money, 2, '.', '' );
    }

    /**
     * Convert to Capital.
     *
     * @return string
     */
    public function toCapital(): string
    {
        @list( $intPart, $decimalPart ) = explode( '.', $this->money, 2 );
        if ( 0.0 === floatval( $this->money ) ) {
            return '零元';
        }
        $result = $this->getIntPart( $intPart );
        $result .= $this->getDecimalPart( $decimalPart );

        return $result;
    }

    /**
     * Parse to Capital
     *
     * @param int|number|string $money default 0
     *
     * @return string
     */
    public function parse( $money ): string
    {
        $this->setMoney( $money );

        return $this->toCapital();
    }

    /**
     * Get Int Part
     *
     * @return string
     */
    private function getIntPart( $intPart )
    {
        $result = '';
        $gree   = strlen( $intPart ) - 1;
        if ( $intPart > 0 ) {
            for ( $i = 0; $i < strlen( $intPart ); ++ $i ) {
                $num    = $intPart[ $i ];
                $result .= $this->uppers[ $num ] . $this->grees[ $gree -- ];
            }
        }

        $result = str_replace( '零亿', '亿零', $result );
        $result = str_replace( '零万', '万零', $result );

        $result = str_replace( '零拾', '零', $result );
        $result = str_replace( '零佰', '零', $result );
        $result = str_replace( '零仟', '零', $result );

        $result = str_replace( '零零', '零', $result );
        $result = str_replace( '零零', '零', $result );

        $result = str_replace( '零亿', '亿', $result );
        $result = str_replace( '零万', '万', $result );
        $result = str_replace( '零元', '元', $result );

        return $result;
    }

    /**
     * Get Decimal Part
     *
     * @return string
     */
    private function getDecimalPart( $decimalPart )
    {
        $result = '';
        if ( $decimalPart > 0 ) {
            $unit = strlen( $decimalPart ) - 1;
            for ( $i = 0; $i < strlen( $decimalPart ); ++ $i ) {
                $num    = $decimalPart[ $i ];
                $result .= $this->uppers[ $num ] . $this->units[ $unit -- ];
            }
        }
        $result = str_replace( '零分', '', $result );
        if ( $this->thanOne ) {
            $result = str_replace( '零角', '零', $result );
        } else {
            $result = str_replace( '零角', '', $result );
        }

        return $result;
    }
}
