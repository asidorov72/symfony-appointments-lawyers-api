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
     * @param string $date
     * @param string $format
     * @return bool
     */
    public static function validateDate(string $date, string $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) == $date;
    }

    /**
     * @param string $date
     * @param string $format
     * @param string $timeZone
     * @param bool|null $cutoffTime
     * @return bool
     */
    public static function isDatetimeExpired(
        string $date,
        string $format = 'Y-m-d H:i:s',
        string $timeZone = 'UTC',
        bool $cutoffTime = false
    )
    {
        $mowDt = new \DateTime();
        $mowDt->setTimezone(new \DateTimeZone($timeZone));
        $nowInSeconds = $mowDt->getTimestamp();

        $expDt = \DateTime::createFromFormat($format, $date);
        $dTimestamp = $expDt->getTimestamp();

        if ($cutoffTime !== false) {
            // Expiration date + 2 days
            return $nowInSeconds > ($dTimestamp - 48 * 60 * 60);
        }

        return $nowInSeconds > ($dTimestamp);
    }

    /**
     * @param string $dateToCheck
     * @param string $format
     * @param string $timeZone
     * @param string $limitDate
     * @param string $limitTime
     * @param int $intervalMins
     * @return bool
     */
    public static function isDatetimeUnavailable(
        string $dateToCheck,
        string $format = 'Y-m-d H:i:s',
        string $timeZone = 'UTC',
        string $limitDate = 'TODAY',
        string $limitTime = '00:00',
        int $intervalMins = 0
    )
    {
        $limitDt = new \DateTime($limitDate);
        $limitDt->setTimezone(new \DateTimeZone($timeZone));

        $time = explode(':', $limitTime);
        $limitDt->setTime($time[0], $time[1], 0);
        $limitDtStr     = $limitDt->format($format);
        $limitTimestamp = $limitDt->getTimestamp();

        $checkDt        = \DateTime::createFromFormat($format, $dateToCheck);
        $checkDt->modify("+{$intervalMins} minutes");
        $checkDtStr     = $checkDt->format($format);
        $checkTime      = $checkDt->format('H:i');
        $checkTimestamp = $checkDt->getTimestamp();

        if ($checkTimestamp < $limitTimestamp) {
            return true;
        } else {
            if ($checkTime > $limitTime) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $format
     * @param string $timeZone
     * @return string
     */
    public static function getCurrentDatetime(string $format = 'Y-m-d H:i:s', string $timeZone = 'UTC')
    {
        $d = new \DateTime('NOW');
        $d->setTimezone(new \DateTimeZone($timeZone));

        return $d->format($format);
    }

    /**
     * @param string $datetime
     * @param string $format
     * @return \DateTime
     * @throws \Exception
     */
    public static function createFromFormatValidation(string $datetime, string $format = 'Y-m-d H:i:s')
    {
        $isDatetimeValid = self::validateDate($datetime, $format);

        if ($isDatetimeValid === false) {
            throw new \Exception('Invalid datetime format.');
        }

        return \DateTime::createFromFormat($format, $datetime);
    }
}