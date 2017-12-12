<?php

namespace Capital;

class Money {
    private $money;
    private $uppers = [ '零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖' ];
    private $units = [ '分', '角' ];
    private $grees = [ '元', '拾', '佰', '仟', '万', '拾', '佰', '仟', '亿', '拾', '佰', '仟', '万', '拾', '佰' ];
    private $thanOne = false;

    public function __construct( $money ) {
        if ( ! ( is_float( $money ) || is_numeric( $money ) || is_int( $money ) ) ) {
            throw new \InvalidArgumentException( $money );
        }
        if ( $money > 1 ) {
            $this->thanOne = true;
        }
        $this->money = number_format( $money, 2, '.', '' );
    }

    /**
     * Convert to Capital
     * @return string
     */
    public function toCapital(): string {
        @list( $intPart, $decimalPart ) = explode( '.', $this->money, 2 );
        if ( $this->money == 0 ) {
            return '零元';
        }
        $result = $this->getIntPart( $intPart );
        $result .= $this->getDecimalPart( $decimalPart );

        return $result;
    }

    public function getIntPart( $intPart ) {
        $result = '';
        $gree   = strlen( $intPart ) - 1;
        if ( $intPart > 0 ) {
            for ( $i = 0; $i < strlen( $intPart ); $i ++ ) {
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

    public function getDecimalPart( $decimalPart ) {
        $result = '';
        if ( $decimalPart > 0 ) {
            //处理小数部分
            $unit = strlen( $decimalPart ) - 1;
            for ( $i = 0; $i < strlen( $decimalPart ); $i ++ ) {
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
