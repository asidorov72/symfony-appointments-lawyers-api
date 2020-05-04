<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3.5.2020 г.
 * Time: 16:56
 */

namespace App\Transformer;

interface ApiTransformerInterface
{
    public function transform(array $array);
}