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
    /**
     * @param $date
     * @param string $format
     * @return bool
     */
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

    /**
     * @param string $format
     * @param string $timeZone
     * @return string
     */
    public static function getCurrentDatetime($format = 'Y-m-d H:i:s', $timeZone = 'UTC')
    {
        $d = new \DateTime('NOW');
        $d->setTimezone(new \DateTimeZone($timeZone));

        return $d->format($format);
    }
}