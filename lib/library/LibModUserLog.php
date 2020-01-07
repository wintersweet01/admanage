<?php
class LibModUserLog extends Model
{
    public $conn = 'user_log';

    public static $self;

    public static function getInstance(){
        if(!self::$self){
            self::$self = new self();
        }
        return self::$self;
    }

}