<?php
namespace DevStrefa\Esemeser;

class Message
{
    private $clientName;
    private $phoneNumber;
    private $message;
    private $messageType;

    public function __construct($clientName,$phoneNumber,$message,$messageType='')
    {
        $this->clientName=$clientName;
        $this->phoneNumber=$phoneNumber;
        $this->message=$message;
        $this->messageType=$messageType;
    }
    

}