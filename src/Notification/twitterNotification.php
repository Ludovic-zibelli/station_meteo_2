<?php
namespace App\Notification;

class twitterNotification
{
class Tweeter {

    const CONSUMER_KEY = 'zlSsLg5F6ea8UnL9DQPNBws6E';
    const SECRET_KEY = '3eL4eb6XG8XXzGMtvBi7mjC5kJMao36mH411gFdHEabGVWqSik';
    const ACCES_TOKEN = '843750305011580928-Goy8tRhco44CMww2RFmyNxwhjXaIFmE';
    const SECRET_TOKEN = 'MOgKnHOoLlylLrcPZtMoPNZr4wdjmxeXEBn42e2ZOll5T';

    private $twitter;

    public function __construct() {
        \Codebird\Codebird::setConsumerKey(self::CONSUMER_KEY, self::SECRET_KEY);
        $this->twitter = \Codebird\Codebird::getInstance();
        $this->twitter->setToken(self::ACCES_TOKEN, self::SECRET_TOKEN);
    }

    public function poster($message) {
        $this->twitter->statuses_update('status='.$message);
    }

}
    public function twitteAuto()
    {
        //Creation d'une class pour l'envoie des tweete
        //transformation date echo date("d/m/Y H:i:s", strtotime($date_heure));
        $date = date("d/m/Y H:i:s", strtotime($date_heure));





        //$tweeter = new Tweeter();
        //$message1 = "Suite des RelevÃ©s Pression: {$pression}Hpa. Bonne journÃ©e ";
        //$tweeter->poster($message1);


        $tweeter = new Tweeter();
        $message = "RelevÃ©s de la station mÃ©tÃ©o du {$date} Temperature: {$temp2}CÂ° Point de rosÃ©e: {$pt_rosee}CÂ° Humiditer:{$humiditer} % Pression: {$pression}Hpa. Bonne journÃ©e.";
        $tweeter->poster($message);

        //Creation Alerte SMS pour risque de vergla
        //$sms = "ATTENTION RISQUE DE VERGLA. {$temp} CÂ°";
        //Envoi sms
        header('location: https://smsapi.free-mobile.fr/sendmsg?user=26187808&pass=6nomO4k5CkPcPM&msg='. $message);

    }
}