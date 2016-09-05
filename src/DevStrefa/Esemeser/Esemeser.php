<?php
namespace DevStrefa\Esemeser;

/**
 * Library main class
 *
 * Esemeser is a simple library for sending Mobile Text messages through esemeser.pl official API
 *
 * @license https://opensource.org/licenses/MIT MIT
 * @author Cichy <d3ut3r@gmail.com>
 * @version 1.1.0
 *
 */

class Esemeser
{
    /**
     * @var string Sending messages API endpoint
     */
    const SEND_URL='https://esemeser.pl/0api/wyslij.php';

    /**
     * @var string Checking balance API endpoint
     */
    const CHECK_URL='https://esemeser.pl/0api/sprawdz.php';


    private $account;
    private $login;
    private $password;
    private $requestMethod;


    /**
     * Class Constructor
     *
     * @param string $account Account name
     * @param string $login Account login
     * @param string $password Account password
     */
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

         //default request method is set to file_get_contents
         $this->requestMethod='fgc';

    }

    /**
     * Set mechanism used to make requests to API (Allowed values: fgc OR curl) file_get_contents is default
     *
     * @param $requestMethod
     * @throws \InvalidArgumentException *Exception is thrown when invalud request method is provided as argument*
     */
    public function setRequestMethod($requestMethod){
        if ($requestMethod != 'fgc' && $requestMethod !='curl'){
            throw new \InvalidArgumentException('Invalid Request Method');
        }
    }

    /**
     * @param string $url
     * @return mixed | string
     */
    private function makeRequest($url)
    {
        if ($this->requestMethod == 'fgc'){

            return file_get_contents($url);

        } elseif ($this->requestMethod == 'curl'){

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url
            ));

            return curl_exec($curl);
        }
    }

    /**
     * Method returns number of possible to send messages of given type
     *
     * @param string $messageType Type of message
     * @return int Number of messages possible to send
     * @throws \InvalidArgumentException *Exception is thrown when provided type is incorrect*
     * @throws \Exception *Exception is thrown when library wasn't able to get number of messages (ie. credentials was wrong)*
     */
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

        $result=$this->makeRequest(self::CHECK_URL.'?'.$queryString);

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
     * Method will send given message
     *
     * @param Message $message instance of message object
     * @return bool Function return **true** if message was sent
     * @throws \Exception *Exception is thrown when message wasn't send*
     */
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

        $result=$this->makeRequest(self::SEND_URL.'?'.$queryString);

        if ($result !='OK'){

            switch ($result){

                case '-1':
                    throw new \Exception('Incorrect Account name');
                    break;
                case '-2':
                    throw new \Exception('Incorrect login or password');
                    break;
                case '-3':
                    throw new \Exception('Incorrect phone number');
                    break;
                case 'NIE':
                    throw new \Exception('Message wasn\'t sent');
                    break;
                default:
                    throw new \Exception('Unknown Error');
                    break;

            }

        } else {

            return true;

        }

    }

    /**
     * Method returns account name
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Method for setting account name
     * @param string $account Account name
     * @return Esemeser
     */
    public function setAccount($account)
    {
        $this->account = $account;
        return $this;
    }

    /**
     * Method returns account login
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Method for setting login to account
     * @param string $login
     * @return Esemeser
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * Method return password
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Method for setting password to account
     * @param string $password
     * @return Esemeser
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }





}