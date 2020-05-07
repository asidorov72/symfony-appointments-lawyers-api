<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 7.5.2020 г.
 * Time: 16:34
 */

namespace App\Helper;

class DateTimeHelper
{
    public static function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) == $date;
    }

    /**
     * @param $date
     * @param string $format
     * @return bool
     */
    public static function isDatetimeExpired($date, $format = 'Y-m-d H:i:s')
    {
        $now = new \DateTime('TODAY');
        $nowInSeconds = $now->getTimestamp();

        $d = \DateTime::createFromFormat($format, $date);
        $dTimestamp = $d->getTimestamp();

        // Expiration date + 2 days
        return $nowInSeconds > ($dTimestamp - 48 * 60 * 60);
    }
}