<?php
namespace DevStrefa\Esemeser;

class Esemeser
{

    const SEND_URL='https://esemeser.pl/0api/wyslij.php';

    const CHECK_URL='https://esemeser.pl/0api/sprawdz.php';

    const TYPE_ECO='eco';
    const TYPE_STANDARD='standard';
    const TYPE_PLUS='plus';
    const TYPE_PLUS2='plus2';

    private $account;
    private $login;
    private $password;


    public function __construct($account,$login,$password)
    {
        if ($account == '' || $login =='' || $password==''){
            throw new \InvalidArgumentException('Incorrect esemeser.pl credentials');
        }

        $this->account=$account;
        $this->login=$login;
        $this->password=$password;
    }

    public function send(\DevStrefa\Esemeser\Message $message)
    {

    }

    public function checkBalance($messageType='')
    {

    }

    private function typeIsValid($type)
    {

        if (!in_array($type,array('eco','standard','plus','plus2'))){
            return false;
        }
        return true;
    }

}