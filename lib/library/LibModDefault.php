<?php
class LibModDefault extends Model
{
    public $conn = 'default';

    public static $self;

    public static function getInstance(){
        if(!self::$self){
            self::$self = new self();
        }
        return self::$self;
    }

}