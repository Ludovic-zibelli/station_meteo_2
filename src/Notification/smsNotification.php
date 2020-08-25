<?php

namespace App\Notification;

use Th3Mouk\FreeMobileSMSNotif\Client;

class smsNotification
{
    /**
     * @var int
     */
    private $login = '26187808';

    /**
     * @var string
     */
    private $pass ='6nomO4k5CkPcPM';


  public function alerteSms()
  {
      $freeMobileClient = new Client($this->login,$this->pass);
      $freeMobileClient->send('Salut');


  }
}