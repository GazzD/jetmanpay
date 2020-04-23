<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    protected function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function getConversionRate($from, $to){
        $conversionRate = 0;
        switch ($from) {
            case 'USD':
                    switch ($to) {
                        case 'USD':
                            $conversionRate = 1; //USD TO USD
                            break;
                        case 'BS':
                            $conversionRate = 175000; //USD TO BS
                        break;
                        case 'EU':
                            $conversionRate = 0.8; //USD TO EU
                        break;
                        default:
                            $conversionRate = 0; //default
                            break;
                    }
                break;
            case 'BS':
                    switch ($to) {
                        case 'USD':
                            $conversionRate = 1/175000; //BS TO USD
                            break;
                        case 'BS':
                            $conversionRate = 1; //BS TO BS
                        break;
                        case 'EU':
                            $conversionRate = 1/200000; //BS TO EU
                        break;
                        default:
                            $conversionRate = 0; //default
                            break;
                    }
                break;
            case 'EU':
                    switch ($to) {
                        case 'USD':
                            $conversionRate = 1.2; //EU TO USD
                            break;
                        case 'BS':
                            $conversionRate = 200000; //EU TO BS
                        break;
                        case 'EU':
                            $conversionRate = 1; //EU TO EU
                        break;
                        
                        default:
                            $conversionRate = 0; //default
                            break;
                    }
                break;
            default:
                $conversionRate = 0; //default
                break;
        }

        return $conversionRate;
    }

    public function getTaxes(){
        return 15;
    }
}
