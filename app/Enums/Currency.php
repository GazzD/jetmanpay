<?php

namespace App\Enums;


abstract class Currency extends Enums
{
    public static function getSymbol($currency) {
        
        switch ($currency) {
            case 'EU':
                $symbol = 'x';
                break;
            case 'US':
            case 'USD':
                $symbol = '$';
                break;
            case 'VEF':
            case 'BS':
                $symbol = 'BsS';
                break;
            default:
                $symbol = 'x';
                break;
        }
        return $symbol;
    }
}