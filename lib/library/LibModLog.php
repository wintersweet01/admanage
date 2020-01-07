<?php

class LibModLog extends Model
{
    public $conn = 'log';

    public static $self;

    public static function getInstance()
    {
        if (!self::$self) {
            self::$self = new self();
        }
        return self::$self;
    }

    public static function lockFile($date, $type)
    {
        $file = LOG_PATH . 'lock/' . $date . '_' . $type . '.lock';
        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0755, true);
        }

        return $file;
    }

}