<?php

// SpeedFilter.php

namespace App\Filters;

class PriceFilter
{
    public function filter($builder, $value)
    {   
		if($value=='greater'){
			return $builder->where('price', '>' , '500');
		}else{
			return $builder->where('price', '<' , '500');
		}
		
    }
}
