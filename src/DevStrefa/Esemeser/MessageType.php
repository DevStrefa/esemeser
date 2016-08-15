<?php

namespace DevStrefa\Esemeser;

/**
 * MessageType class
 *
 * MessageType class is helper class in library, it contains constants for message Types and static function for validation type
 *
 * @license https://opensource.org/licenses/MIT MIT
 * @author Cichy <d3ut3r@gmail.com>
 * @version 1.0.0
 *
 */


class MessageType
{
    const ECO='eco';
    const STANDARD='standard';
    const PLUS='plus';
    const PLUS2='plus2';

    /**
     * @param  string $type Message type
     * @return bool
     */
    public static function typeIsValid($type)
    {
        if (!in_array($type,array(self::ECO,self::PLUS,self::PLUS2,self::STANDARD)) && $type !== null){
            return false;
        }

        return true;
    }
}