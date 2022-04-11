<?php

namespace App\Helpers;

class Functions
{
    public static function getValidatorMessage($validator)
    {
        $message = "";

        foreach ($validator->messages()->all() as $item => $value) {
            $message .= $message == "" ? $value : "\n$value";
        }

        return $message;
    }

    public static function getValidatorMessageOneLine($validator)
    {
        $message = "";

        foreach ($validator->messages()->all() as $item => $value) {
            $message .= $message == "" ? $value : " $value";
        }

        return $message;
    }

    public static function convertMonthName($month) {
        if ($month == '1') return "ENERO";
        if ($month == '2') return "FEBRERO";
        if ($month == '3') return "MARZO";
        if ($month == '4') return "ABRIL";
        if ($month == '5') return "MAYO";
        if ($month == '6') return "JUNIO";
        if ($month == '7') return "JULIO";
        if ($month == '8') return "AGOSTO";
        if ($month == '9') return "SÉPTIEMBRE";
        if ($month == '10') return "OCTUBRE";
        if ($month == '11') return "NOVIEMBRE";
        if ($month == '12') return "DICIEMBRE";
    }

    public static function convertDayName($day) {
        if ($day == '1') return "LUNES";
        if ($day == '2') return "MARTES";
        if ($day == '3') return "MIÉRCOLES";
        if ($day == '4') return "JUEVES";
        if ($day == '5') return "VIERNES";
        if ($day == '6') return "SÁBADO";
        if ($day == '7') return "DOMINGO";
    }
}
