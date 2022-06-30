<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Images\HasAnImage;

class Product extends Model
{
    use HasFactory , HasAnImage;

    protected $guarded = ['id'];
    protected $appends = ['image_path'];

    public function scopeSearch($query)
    {
        return $query->where(function($q){

            if(request()->filled('search'))
            {
                $q->where('name' , 'like' , '%' . request()->search . '%')
                        ->orWhere('code' , 'like' , '%' . request()->search . '%');     
            }

            if(request()->filled('category_id'))
            {
                $q->where('category_id' , request()->category_id);     
            }

            if(request()->filled('supplier_id'))
            {
                $q->where('supplier_id' , request()->supplier_id);     
            }

        });
   
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
}
