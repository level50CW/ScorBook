<?php
/**
 * Created by PhpStorm.
 * User: VIRT
 * Date: 15.02.2016
 * Time: 11:50
 */

namespace App\Helpers;


use Carbon\Carbon;

class LocalDateTime {
    public static function fromCarbon(Carbon $date, $format = 'MM-DD-YYYY HH:mm', $tag = 'span', $options = '')
    {
        $text = $date->format('Y-m-d\TH:i:s.000\Z');
        $code = rand(100000,999999);
        return '<'.$tag.' id="time'.$code.'" '.$options.'><script>var q = moment("'.$text.'").format("'.$format.'");$("'.$tag.'#time'.$code.'").val(q).text(q);</script></'.$tag.'>';
    }

    public static function fromCarbonDate(Carbon $date)
    {
        return LocalDateTime::fromCarbon($date, 'MM-DD-YYYY');
    }

    public static function fromCarbonToInput(Carbon $date, $options = [])
    {
        $opts = '';
        foreach($options as $k=>$v){
            $opts .= $k.'="'.$v.'" ';
        }

        return LocalDateTime::fromCarbon($date, 'MM-DD-YYYY HH:mm', 'input', $opts);
    }
}