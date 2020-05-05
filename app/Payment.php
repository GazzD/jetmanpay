<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'dosa_number', 'dosa_date', 'total_amount', 'tail_number',
        'status', 'client', 'user_id', 'created_at', 'updated_at'
    ];
    
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function plane()
    {
        return $this->belongsTo('App\Plane');
    }
    
    public function dosas()
    {
        return $this->belongsToMany('App\Dosa')->with('items');
    }
    public function pendingDosas()
    {
        return $this->belongsToMany('App\Dosa')->where('status','PENDING')->with('items');
    }
    public function cancelledDosas()
    {
        return $this->belongsToMany('App\Dosa')->where('status','CANCELLED')->with('items');
    }
}
