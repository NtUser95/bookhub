<?php


namespace Models\ImageUploader;


class ValidationStatuses
{
    const SUCCESS = 1;
    /** @const int Картинка имеет недопустимое расширение */
    const INVALID_EXTENSION = 2;
    /** @const int Картинка имеет недопустимую высоту/ширину */
    const INVALID_DIMENSION = 3;
    /** @var int Картинка имеет недопустимый размер */
    const INVALID_WEIGHT = 4;
    /** @var int Reserved - недопустимое количество картинок */
    const INVALID_AMOUNT = 5;
    /** @var int Отсутствует изображение */
    const MISSING_IMAGE = 6;

    private static $messages = [
        self::INVALID_EXTENSION => 'Изображение имеет недопустимое расширение.',
        self::INVALID_DIMENSION => 'Изображение имеет недопустимую ширину или высоту',
        self::INVALID_WEIGHT => 'Изображение имеет недопустимый размер',
        self::MISSING_IMAGE => 'Отсутствует изображение',
    ];

    public static function getErrorMessage($code): string
    {
        return self::$messages[$code];
    }
}