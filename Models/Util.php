<?php

namespace Models;

class Util
{
    /**
     * Вырезает из строки все символы, кроме: латинского/кириллического алфавита, цифр и пробелов.
     *
     * @param $string - Очищаемая строка
     * @return string - результат
     */
    public static function clearString($string)
    {
        return trim(preg_replace('![^0-9a-zA-Zа-яА-ЯёЁ\s]+!u', '', $string));
    }
}