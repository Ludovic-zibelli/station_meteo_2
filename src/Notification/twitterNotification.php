<?php
namespace App\Notification;

use DG\Twitter\Twitter;

class twitterNotification
{

    public function Twitter()
    {
        $consumerKey = 'zlSsLg5F6ea8UnL9DQPNBws6E';
        $consumerSecret = '3eL4eb6XG8XXzGMtvBi7mjC5kJMao36mH411gFdHEabGVWqSik';
        $accessToken = '843750305011580928-Goy8tRhco44CMww2RFmyNxwhjXaIFmE';
        $accessTokenSecret = 'MOgKnHOoLlylLrcPZtMoPNZr4wdjmxeXEBn42e2ZOll5T';
        //Lecture d'un fichier .txt ligne par ligne et stokage dans un tableau
        # Chemin vers fichier texte
        $file ="public/station_direct.txt";
        # On met dans la variable (tableau $read) le contenu du fichier
        $read=file($file);
        $twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
        $twitter->send('Relevés de la station météo du '.$read[0].'Température: '.(int)$read[4].'C° Point de rosée: '.(int)$read[11].'C° Humiditer:'.(int)$read[3].' % Pression: '.(int)$read[5].'Hpa. Bonne journée.');
        //RelevÃ©s de la station mÃ©tÃ©o du {$date} Temperature: {$temp2}CÂ° Point de rosÃ©e: {$pt_rosee}CÂ° Humiditer:{$humiditer} % Pression: {$pression}Hpa. Bonne journÃ©e.
    }

}