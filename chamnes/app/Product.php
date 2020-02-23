<?php

namespace App;
use App\Filters\ProductFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
   // protected $table = 'products';
    //protected $fillable = ['id','name','speed','color','price'];
	public function scopeFilter(Builder $builder, $request)
    {
        return (new ProductFilter($request))->filter($builder);
    }
}
