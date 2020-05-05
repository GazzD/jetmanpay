<?php

namespace App\Enums;


abstract class Currency extends Enums
{
    public static function getSymbol($currency) {
        
        switch ($currency) {
            case 'EU':
                $symbol = '€';
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
    
    public static function formatAmount($amount, $currency) {
        switch ($currency) {
            case 'US':
            case 'USD':
                $formattedAmount = Currency::getSymbol($currency). ' ' .$amount;
                break;
            default:
                $formattedAmount = $amount . ' ' . Currency::getSymbol($currency);
                break;
        }
        return $formattedAmount;
    }
}