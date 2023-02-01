<?php

namespace Sediar0627\Formatters;

use Carbon\Carbon;

class Date
{
    public static function toSpanishDocument(Carbon $date)
    {
        $months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        return 'a los '.$date->day.' días del mes de '.$months[$date->month - 1].' de '.$date->year;
    }
}