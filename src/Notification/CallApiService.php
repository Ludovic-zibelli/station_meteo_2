<?php
 
namespace App\Notification;
 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
 
class CallApiService
{
    private $client;
 
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
 
    //Appel API pour recolter les infos sur les orages 
    //Rayon 1 kms
    public function getResultOrages1(): array
    {
        $response = $this->client->request(
            'GET',
            'https://www.orages.be/services/bearing.json.php?lat=49.1622783&lon=6.7460668&r=1',
        );
        return $response->toArray();
    }

    //Rayon 10 kms
    public function getResultOrages(): array
    {
        $response = $this->client->request(
            'GET',
            'https://www.orages.be/services/bearing.json.php?lat=49.1622783&lon=6.7460668&r=10',
        );
        return $response->toArray();
    }

    //Rayon 50 kms
    public function getResultOrages50(): array
    {
        $response = $this->client->request(
            'GET',
            'https://www.orages.be/services/bearing.json.php?lat=49.1622783&lon=6.7460668&r=50',
        );
        return $response->toArray();
    }

    //Appel API pour recolter les information sur les vigilance meteo en moselle 
    public function getResultVigilances(): array
    {
        $response = $this->client->request(
            'GET',
            'https://data.opendatasoft.com/api/records/1.0/search/?dataset=vigilance-meteorologique%40public&q=moselle&facet=couleur',
        );
        return $response->toArray();
    }
}