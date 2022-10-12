<?php

namespace App\Infrastructure\Utils;

use function App\Service\Utils\mb_convert_case;
use const App\Service\Utils\MB_CASE_LOWER;
use const App\Service\Utils\MB_CASE_TITLE;

class DateConverter
{
    private const GENITIVE_MONTHS = ['', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября',
        'октября', 'ноября', 'декабря'];

    private const NOMINATIVE_MONTHS = ['', 'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь',
        'октябрь', 'ноябрь', 'декабрь'];

    private const GENITIVE_DAYS = ['', 'понедельника', 'вторника', 'среды', 'четверга', 'пятницы', 'субботы', 'воскресенья'];

    private const NOMINATIVE_DAYS = ['', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье'];

    /**
     * @param string|int $month
     * @param array|null $context
     * @return string
     */
    public static function getMonth(string|int $month, ?array $context = []): string
    {
        $case = array_key_exists('case', $context) ? $context['case'] : 'nominative';
        $register = array_key_exists('register', $context) ? $context['register'] === 'lower' ? MB_CASE_LOWER : MB_CASE_TITLE : MB_CASE_LOWER;

        if ($case === "nominative"){
            return mb_convert_case(self::NOMINATIVE_MONTHS[$month], $register);
        }

        return mb_convert_case(self::GENITIVE_MONTHS[$month], $register);
    }

    /**
     * @param string|int $day
     * @param array|null $context
     * @return string
     */
    public static function getDay(string|int $day, ?array $context = []): string
    {
        $case = array_key_exists('case', $context) ? $context['case'] : 'nominative';
        $register = array_key_exists('register', $context) ? $context['register'] === 'lower' ? MB_CASE_LOWER : MB_CASE_TITLE : MB_CASE_LOWER;

        if ($case === "nominative"){
            return mb_convert_case(self:: NOMINATIVE_DAYS[$day], $register);
        }

        return mb_convert_case(self:: GENITIVE_DAYS[$day], $register);
    }
}