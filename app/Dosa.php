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

    public static function getConversionRate($from, $to, $tasaEuro, $tasaDolar){
        $conversionRate = 0;
        switch ($from) {
            case 'USD':
                    switch ($to) {
                        case 'USD':
                            $conversionRate = 1; //USD TO USD
                            break;
                        case 'BS':
                            $conversionRate = 1/$tasaDolar; //USD TO BS
                        break;
                        case 'EU':
                            $conversionRate = $tasaEuro/$tasaDolar; //USD TO EU
                        break;
                        default:
                            $conversionRate = 0; //default
                            break;
                    }
                break;
            case 'BS':
                    switch ($to) {
                        case 'USD':
                            $conversionRate = $tasadolar; //BS TO USD
                            break;
                        case 'BS':
                            $conversionRate = 1; //BS TO BS
                        break;
                        case 'EU':
                            $conversionRate = $tasaEuro; //BS TO EU
                        break;
                        default:
                            $conversionRate = 0; //default
                            break;
                    }
                break;
            case 'EU':
                    switch ($to) {
                        case 'USD':
                            $conversionRate = $tasaDolar/$tasaEuro; //EU TO USD
                            break;
                        case 'BS':
                            $conversionRate = $tasaEuro; //EU TO BS
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
