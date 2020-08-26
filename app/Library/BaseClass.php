<?php

namespace App\Library;
use App;

class BaseClass
{
    /**
     * 中央値を求める関数
     * @param int[] $values
     */
    public function median(array $values)
    {
        if($values == null){
            return 0;
        }
        sort($values);
        if(count($values) % 2 === 0){
            return (($values[(count($values)/2)-1] + $values[((count($values) / 2))]) / 2);
        }else{
            return ($values[floor(count($values) / 2)]);
        }
    }
}