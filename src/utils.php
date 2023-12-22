<?php

namespace CerfaReceiptsGen;

use NumberFormatter;

class Utils {

    public static function digits2letters($amount)
    {
        $formatter = NumberFormatter::create('fr_FR', NumberFormatter::SPELLOUT);
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
        $formatter->setAttribute(NumberFormatter::ROUNDING_MODE, NumberFormatter::ROUND_HALFUP);
        return $formatter->format($amount);
    }
}