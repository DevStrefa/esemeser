<?php
namespace DevStrefa\Esemeser;

/**
 * Class Message
 * @package DevStrefa\Esemeser
 */

class Message
{
    private $clientName;
    private $phoneNumber;
    private $message;
    private $messageType;

    public function __construct($clientName=null,$phoneNumber=null,$message=null,$messageType=null)
    {

        if ($clientName!=null){
            $this->setClientName($clientName);
        }

        if ($phoneNumber!=null){
            $this->setPhoneNumber($phoneNumber);
        }

        if ($message!=null){
            $this->setMessage($message);
        }

        if ($messageType!=null){
            $this->setMessageType($messageType);
        }

    }

    /**
     * @param string $clientName
     * @return Message
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;
        return $this;
    }

    /**
     * @param string $phoneNumber
     * @return Message
     */
    public function setPhoneNumber($phoneNumber)
    {

        if (preg_match('/^[0-9]{9}$/',$phoneNumber)){
            $this->phoneNumber = $phoneNumber;
            return $this;
        }

        throw new \InvalidArgumentException('Incorrect Phone Number');
    }

    /**
     * @param string $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param string $messageType
     * @return Message
     */
    public function setMessageType($messageType)
    {
        if (!MessageType::typeIsValid($messageType)){
            throw new \InvalidArgumentException('Incorrect Message Type');
        }

        $this->messageType = $messageType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getMessageType()
    {
        return $this->messageType;
    }






}