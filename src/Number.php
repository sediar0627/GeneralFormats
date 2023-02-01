<?php

namespace Sediar0627\Formatters;

use NumberFormatter;

class Number
{
    /**
     * Format a number to a specific style
     * 
     * @param int|float $number Number to format
     * @param string $locale Locale code
     * @param int $style Style to format
     * 
     * @return string
     * 
     * @throws \InvalidArgumentException
     * 
     * @link https://www.php.net/manual/es/class.numberformatter.php
     */
    public static function toFormat(int|float $number, string $locale = 'es_CO', int $style = NumberFormatter::DECIMAL)
    {
        if(! is_numeric($number)){
            throw new \InvalidArgumentException('The number must be numeric');
        }

        $formatter = new NumberFormatter($locale, $style);
        return $formatter->format($number);
    }

    /**
     * Format a number to spell
     * 
     * @param int|float $number Number to format
     * @param string $locale Locale code
     * 
     * @return string
     * 
     * @throws \InvalidArgumentException
     */
    public static function toSpell($number, $locale = 'es_CO')
    {
        return self::toFormat($number, $locale, NumberFormatter::SPELLOUT);
    }

    /**
     * Format a number to currency
     * 
     * @param int|float $number Number to format
     * @param string $locale Locale code
     * @param bool $decimals Show decimals
     * 
     * @return string
     * 
     * @throws \InvalidArgumentException
     */
    public static function toCurrency($number, $locale = 'es_CO', bool $decimals = false)
    {
        $formatingNumber = self::toFormat($number, $locale, NumberFormatter::CURRENCY);
        return $decimals ? $formatingNumber : preg_replace('/(\.|\,)\d{2}$/', '', $formatingNumber);
    }

    /**
     * Format a number to percent
     * 
     * @param int|float $number Number to format
     * @param string $locale Locale code
     * 
     * @return string
     * 
     * @throws \InvalidArgumentException
     */
    public static function toPercent($number, $locale = 'es_CO')
    {
        return self::toFormat($number/100, $locale, NumberFormatter::PERCENT);
    }

    /**
     * Format a number to ordinal
     * 
     * @param int|float $number Number to format
     * @param string $locale Locale code
     * 
     * @return string
     * 
     * @throws \InvalidArgumentException
     */
    public static function toOrdinal($number, $locale = 'es_CO')
    {
        return self::toFormat($number, $locale, NumberFormatter::ORDINAL);
    }
    
    /**
     * Format a number to ordinal spell in spanish
     * 
     * @param int|float $number Number to format
     * @param string $suffix Suffix to ordinal
     * 
     * @return string
     * 
     * @throws \InvalidArgumentException
     */
    public static function toSpanishOrdinalSpell($number, $suffix = 'o')
    {
        if(! is_numeric($number)){
            throw new \InvalidArgumentException('The number must be numeric');
        }

        if($number < 1 || $number > 99){
            throw new \InvalidArgumentException('The number must be between 1 and 99');
        }

        $units = [
            1 => 'Primer' . $suffix,
            2 => 'Segund' . $suffix,
            3 => 'Tercer' . $suffix,
            4 => 'Cuart' . $suffix,
            5 => 'Quint' . $suffix,
            6 => 'Sext' . $suffix,
            7 => 'Séptim' . $suffix,
            8 => 'Octav' . $suffix,
            9 => 'Noven' . $suffix,
        ];

        $firsts = $units + [
            10 => 'Décim' . $suffix,
            11 => 'Undécim' . $suffix,
            12 => 'Duoécimo' . $suffix
        ];

        if (array_key_exists($number, $firsts)) {
            return $firsts[$number];
        }

        $tenths = [
            10 => 'Décim' . $suffix,
            20 => 'Vigésim' . $suffix,
            30 => 'Trigésim' . $suffix,
            40 => 'Cuadragésim' . $suffix,
            50 => 'Quincuagésim' . $suffix,
            60 => 'Sexagésim' . $suffix,
            70 => 'Septuagésim' . $suffix,
            80 => 'Octogésim' . $suffix,
            90 => 'Nonagésim' . $suffix,
        ];

        $numberOrdinal = '';

        for ($tenth = 10; $tenth < 100; $tenth += 10) {
            if ($tenth == $number) {
                $numberOrdinal = $tenths[$tenth];
                break;
            }

            if ($tenth <= $number && ($tenth + 10) > $number) {
                $unit = $number - $tenth;
                $numberOrdinal = $tenths[$tenth] . ' ' . $units[$unit];
                break;
            }
        }

        return $numberOrdinal;
    }
}
