<?php

namespace Webmagic\Dashboard\Core;

class PHPDatesFormatHelper
{
    /**
     * Moment JS
     * https://momentjs.com/docs/#/displaying/format/
     * @var string[]
     */
    protected static $phpMomentJSMatching = [
        //Days
        'd' => 'DD',
        'D' => 'ddd',
        'j' => 'D',
        'l' => 'dddd',
        //'L' => '',
        'N' => 'E',
        //'S' => '',
        'w' => 'd',
        //'z' => '',

        //Week
        'W' => 'W',

        //Month
        'F' => 'MMMM',
        'm' => 'MM',
        'M' => 'MMM',
        'n' => 'M',
        //'t' => '',

        //Year
        //'L' => '',
        //'o' => '',
        'Y' => 'YYYY',
        'y' => 'YY',

        //Time
        'a' => 'a',
        'A' => 'A',
        //'B' => '',
        'g' => 'h',
        'G' => 'H',
        'h' => 'hh',
        'H' => 'HH',
        'i' => 'mm',
        's' => 'ss',
        //'u' => '',
        //'v' => '',

        //Timezone
        //'e' => '',
        //'I' => '',
        'O' => 'ZZ',
        'P' => 'Z',
        //'p' => '',
        //'T' => '',
        //'Z' => '',

        //Full Date/Time
        //'c' => '',
        //'r' => '',
        'U' => 'X'
    ];

    /**
     * Convert PHP date formatting string to MomentJS date formatting string
     * https://momentjs.com
     *
     * @param string $format
     *
     * @return string
     */
    public static function convertPHPFormatToMomentJSFormat(string $format): string
    {
        $formatJS = '';

        $formatSymbols = str_split($format);
        foreach ($formatSymbols as $symbol){
            $formatJS .= key_exists($symbol, self::$phpMomentJSMatching) ? self::$phpMomentJSMatching[$symbol] : $symbol;
        }

        return $formatJS;
    }
}