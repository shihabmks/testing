<?php

// ProductFilter.php

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    protected $filters = [
        'speed' => SpeedFilter::class,
		'color' => ColorFilter::class,
		'price' => PriceFilter::class
		
    ];
}