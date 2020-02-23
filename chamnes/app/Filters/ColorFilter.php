<?php

// SpeedFilter.php

namespace App\Filters;

class ColorFilter
{
    public function filter($builder, $value)
    {
		if($value=='other'){
			return $builder->where('color', '!=', 'black');
		}else{
			return $builder->where('color', 'black');
		}
        
    }
}
