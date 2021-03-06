# Esemeser 1.1.0

PHP Library designed to sending SMS messages through esemeser.pl API

### Before you use it!

Esemeser.pl is a Polish service for sending SMS messages, so remember that You can send messages only to Polish phone numbers
those numbers must be in format: xxxxxxxxx (9 digits), other numbers probably will not work. 

This library is using [file_get_contents](http://php.net/manual/en/function.file-get-contents.php) as default mechanism to send requests, so before You start using it, make sure you have properly configured environment. Check if your [allow_url_fopen](http://php.net/manual/en/filesystem.configuration.php) is set to "1". You can use [CURL](http://php.net/manual/en/book.curl.php) instead of [file_get_contents](http://php.net/manual/en/function.file-get-contents.php) please read below to get more information.

### How to install

Library is compatible with [composer](https://getcomposer.org/) so You can install it by adding:
```code
"require": {
        "devstrefa/esemeser": "1.0.x-dev"
    }
```

to Your composer.json file

You can also download zip file and include all necessary files by yourself

### How to use

Library is designed for 2 main tasks: 

**1. Sending Messages**

Below you can see example of code sending some message:

```php
<?php

use DevStrefa\Esemeser\Esemeser;
use DevStrefa\Esemeser\Message;
use DevStrefa\Esemeser\MessageType;

require_once ('../vendor/autoload.php');

try {

    $esemeser = new Esemeser();    
    $esemeser->setLogin('login')->setAccount('account_name')->setPassword('password');
    
    $message = new Message();
    $message->setClientName('client_name')->setPhoneNumber('123456789')->setMessage('test')->setMessageType(MessageType::ECO);
    $esemeser->send($message);

} catch (\Exception $e){
    var_dump($e);
}
```



**2. Checking Balance**

Second function of library is checking how many messages of given type You can still send with Your current balance. To do this use library like in code below:

```php
<?php

use DevStrefa\Esemeser\Esemeser;
use DevStrefa\Esemeser\MessageType;

require_once ('../vendor/autoload.php');

try {

    $esemeser = new Esemeser();
    $esemeser->setLogin('login')->setAccount('account_name')->setPassword('password');

    $balance=$esemeser->checkBalance(MessageType::ECO);

    echo $balance;
   

} catch (\Exception $e){
    var_dump($e);
}
```

### How to use CURL instead of file_get_contents

Since version 1.1.0 of library, You can choose mechanism which is used to make requests to API, if you want to do this add this line to Your code:

```php
$esemeser->setRequestMethod('fgc');
```

available values for setRequestMethod are:
 * ***fgc*** - for file_get_contents
 * ***curl*** - for curl library
 

For more information about library please read generated [documentation](http://devstrefa.github.io/esemeserDoc/).


## Changelog

You can see Changelog for this project [here](https://github.com/DevStrefa/esemeser/blob/master/CHANGELOG.md)

### License

Whole code in this repository is Under [MIT license](https://github.com/DevStrefa/esemeser/blob/master/LICENSE)