<?php
namespace DevStrefa\Esemeser;

class Esemeser
{

    const SEND_URL='https://esemeser.pl/0api/wyslij.php';

    const CHECK_URL='https://esemeser.pl/0api/sprawdz.php';

    private $account;
    private $login;
    private $password;


    public function __construct($account=null,$login=null,$password=null)
    {
         if ($account != null){
             $this->setAccount($account);
         }

         if ($login!=null){
             $this->setLogin($login);
         }

         if ($password!=null){
             $this->setPassword($password);
         }
    }


    public function checkBalance($messageType=null)
    {
        $query=array(
            'konto'=>$this->getAccount(),
            'login'=>$this->getLogin(),
            'haslo'=>$this->getPassword()
        );

        if ($messageType!==null){
            if (MessageType::typeIsValid($messageType)) {
                $query['rodzaj'] =$messageType;
            } else{
                throw new \InvalidArgumentException('Incorrect Message Type');
            }
        }

        $queryString=http_build_query($query);

        $result=file_get_contents(self::CHECK_URL.'?'.$queryString);



        return $result;

    }


    public function send(Message $message)
    {
        $query=array(
            'konto'=>$this->getAccount(),
            'login'=>$this->getLogin(),
            'haslo'=>$this->getPassword(),
            'nazwa'=>$message->getClientName(),
            'telefon'=>$message->getPhoneNumber(),
            'tresc'=>$message->getMessage()
        );

        if ($message->getMessageType() !== null){
            $query['rodzaj']=$message->getMessageType();
        }

        $queryString=http_build_query($query);

        $result=file_get_contents(self::SEND_URL.'?'.$queryString);

        if ($result < 0){

            switch ($result){

                case '-1':
                    throw new \Exception('Incorrect Account name');
                    break;
                case '-2':
                    throw new \Exception('Incorrect login or password');
                    break;
                default:
                    throw new \Exception('Unknown Error');
                    break;

            }

        } else {

            return $result;

        }

    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $account
     * @return Esemeser
     */
    public function setAccount($account)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     * @return Esemeser
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Esemeser
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }





}