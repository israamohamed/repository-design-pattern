<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['total_price' , 'total_quantities'];

    public function scopeSearch($query)
    {
        return $query->where(function($q){

            if(request()->filled('search'))
            {
                $q->where('notes' , 'like' , '%' . request()->search . '%')
                    ->orWhereHas('customer' , function($q2){
                        $q2->where('name' , 'like' , '%' . request()->search . '%' );

                    });
            }

            if(request()->filled('date'))
            {
                $q->whereDate('date' ,  request()->date); 
            }

            if(request()->filled('today_orders'))
            {
                $q->whereDate('date' ,  date("Y-m-d")); 
            }

            if(request()->filled('customer_id'))
            {
                $q->where('customer_id' ,  request()->customer_id); 
            }

        });
   
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('quantity' , 'price');
    }

    public function getTotalPriceAttribute()
    {
        $price = DB::table('order_product')->selectRaw('sum(price * quantity) as price')->where('order_id' , $this->id)->first()->price;
        if($this->discount)
        {
            $price -= $this->discount;
        }
        return $price;
    }

    public function getTotalQuantitiesAttribute()
    {
        $quantites = DB::table('order_product')->where('order_id' , $this->id)->sum('quantity');
       
        return $quantites;
    }
}
