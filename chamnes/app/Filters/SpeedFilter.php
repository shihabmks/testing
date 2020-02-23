<?php

// SpeedFilter.php

namespace App\Filters;

class SpeedFilter
{
    public function filter($builder, $value)
    {        
		if($value=='greater'){
			return $builder->where('speed', '>' , '10');
		}else{
			return $builder->where('speed', '<' , '10');
		}
    }
}
