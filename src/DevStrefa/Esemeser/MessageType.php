<?php

namespace DevStrefa\Esemeser;



class MessageType
{
    const ECO='eco';
    const STANDARD='standard';
    const PLUS='plus';
    const PLUS2='plus2';

    public static function typeIsValid($type)
    {
        if (!in_array($type,array(self::ECO,self::PLUS,self::PLUS2,self::STANDARD)) && $type !== null){
            return false;
        }

        return true;
    }
}