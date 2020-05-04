<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3.5.2020 г.
 * Time: 16:58
 */

namespace App\Transformer;

use App\Transformer\ApiTransformerInterface;


abstract class AbstractTransformer implements ApiTransformerInterface
{
    abstract function transform(array $array) : array;
}