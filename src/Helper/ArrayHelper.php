<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6.5.2020 г.
 * Time: 12:46
 */

namespace App\Helper;

class ArrayHelper
{
    /**
     * @param array $array
     * @return mixed
     */
    public static function flatArray(array $array) : array
    {
        $return = array();
        array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });

        return $return;
    }
}