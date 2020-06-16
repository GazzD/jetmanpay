<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosa extends Model
{
    public function payments()
    {
        return $this->belongsToMany('App\Payment');
    }
    
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    
    public function plane()
    {
        return $this->belongsTo('App\Plane');
    }

    public function items(){
        return $this->hasMany('App\DosaItem');
    }

    public static function getConversionRate($from, $to){
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
}
