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
        try {
            $response = $this->client->request(
                'GET',
                'https://www.orages.be/services/bearing.json.php?lat=49.1622783&lon=6.7460668&r=1',
            );
            if ($response->getStatusCode() !== 200) {
                return [
                    'error' => true,
                    'message' => "Erreur API Orages 1km : " . $response->getStatusCode(),
                ];
            }
            return $response->toArray();
            } catch (\Exception $e) {
                return [
                    'error' => true,
                    'message' => "Exception capturée Orages 1km : " . $e->getMessage(),
                ];
            }
    }

    //Rayon 10 kms
    public function getResultOrages(): array
    {
        try {
            $response = $this->client->request(
                'GET',
                'https://www.orages.be/services/bearing.json.php?lat=49.1622783&lon=6.7460668&r=10',
            );
            if ($response->getStatusCode() !== 200) {
                return [
                    'error' => true,
                    'message' => "Erreur API Orages 10km : " . $response->getStatusCode(),
                ];
            }
            return $response->toArray();
            } catch (\Exception $e) {
                return [
                    'error' => true,
                    'message' => "Exception capturée Orages 10km : " . $e->getMessage(),
                ];
            }
    }

    //Rayon 50 kms
    public function getResultOrages50(): array
    {
        try {
            $response = $this->client->request(
                'GET',
                'https://www.orages.be/services/bearing.json.php?lat=49.1622783&lon=6.7460668&r=50',
            );
            if ($response->getStatusCode() !== 200) {
                return [
                    'error' => true,
                    'message' => "Erreur API Orages 50km : " . $response->getStatusCode(),
                ];
            }
            return $response->toArray();
            } catch (\Exception $e) {
                return [
                    'error' => true,
                    'message' => "Exception capturée Orages 50km : " . $e->getMessage(),
                ];
            }
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
 
    //Appel API meteo france pour recolter les information sur les vigilance meteo en moselle
    public function getApiMeteoFrance(): array
    {
        try {
        $response = $this->client->request(
            'GET',
            //'https://public-api.meteofrance.fr/public/DPVigilance/v1/cartevigilance/encours',
            'https://public-api.meteofrance.fr/public/DPVigilance/v1/textesvigilance/encours',
            [
                'headers' => [
                    'accept' => '*/*',
                    'apikey' => 'eyJ4NXQiOiJZV0kxTTJZNE1qWTNOemsyTkRZeU5XTTRPV014TXpjek1UVmhNbU14T1RSa09ETXlOVEE0Tnc9PSIsImtpZCI6ImdhdGV3YXlfY2VydGlmaWNhdGVfYWxpYXMiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOiJMdWRvdmljLnppYmVsbGlAY2FyYm9uLnN1cGVyIiwiYXBwbGljYXRpb24iOnsib3duZXIiOiJMdWRvdmljLnppYmVsbGkiLCJ0aWVyUXVvdGFUeXBlIjpudWxsLCJ0aWVyIjoiVW5saW1pdGVkIiwibmFtZSI6IkRlZmF1bHRBcHBsaWNhdGlvbiIsImlkIjo2MTk4LCJ1dWlkIjoiYThiY2UzNWYtMWFiNy00ZDYzLTlkZTQtNTM2OGI5ODczMzhkIn0sImlzcyI6Imh0dHBzOlwvXC9wb3J0YWlsLWFwaS5tZXRlb2ZyYW5jZS5mcjo0NDNcL29hdXRoMlwvdG9rZW4iLCJ0aWVySW5mbyI6eyI1MFBlck1pbiI6eyJ0aWVyUXVvdGFUeXBlIjoicmVxdWVzdENvdW50IiwiZ3JhcGhRTE1heENvbXBsZXhpdHkiOjAsImdyYXBoUUxNYXhEZXB0aCI6MCwic3RvcE9uUXVvdGFSZWFjaCI6dHJ1ZSwic3Bpa2VBcnJlc3RMaW1pdCI6MCwic3Bpa2VBcnJlc3RVbml0Ijoic2VjIn0sIjYwUmVxUGFyTWluIjp7InRpZXJRdW90YVR5cGUiOiJyZXF1ZXN0Q291bnQiLCJncmFwaFFMTWF4Q29tcGxleGl0eSI6MCwiZ3JhcGhRTE1heERlcHRoIjowLCJzdG9wT25RdW90YVJlYWNoIjp0cnVlLCJzcGlrZUFycmVzdExpbWl0IjowLCJzcGlrZUFycmVzdFVuaXQiOiJzZWMifX0sImtleXR5cGUiOiJQUk9EVUNUSU9OIiwic3Vic2NyaWJlZEFQSXMiOlt7InN1YnNjcmliZXJUZW5hbnREb21haW4iOiJjYXJib24uc3VwZXIiLCJuYW1lIjoiRG9ubmVlc1B1YmxpcXVlc1ZpZ2lsYW5jZSIsImNvbnRleHQiOiJcL3B1YmxpY1wvRFBWaWdpbGFuY2VcL3YxIiwicHVibGlzaGVyIjoiYWRtaW4iLCJ2ZXJzaW9uIjoidjEiLCJzdWJzY3JpcHRpb25UaWVyIjoiNjBSZXFQYXJNaW4ifSx7InN1YnNjcmliZXJUZW5hbnREb21haW4iOiJjYXJib24uc3VwZXIiLCJuYW1lIjoiRG9ubmVlc1B1YmxpcXVlc09ic2VydmF0aW9uIiwiY29udGV4dCI6IlwvcHVibGljXC9EUE9ic1wvdjEiLCJwdWJsaXNoZXIiOiJiYXN0aWVuZyIsInZlcnNpb24iOiJ2MSIsInN1YnNjcmlwdGlvblRpZXIiOiI1MFBlck1pbiJ9XSwidG9rZW5fdHlwZSI6ImFwaUtleSIsImlhdCI6MTcxNjE0NDA5NywianRpIjoiOGU1NmI1MzMtOGU1NC00MzAzLThjZDctMjFlNGRhNmE5Yzg4In0=.HFDOq2Mm9u3azwQ_RwBzaOaOP7fzLoTokT2BkBj5ZJWTWjK8LkkZH2r-gLUaLQZ9ds6kVYhMrE2iN5qR2csvnrktc9OnSwpdYE4d0Ugsapem5re5J1mbtzFs2G_AAEx4Nvo6gPyxPpmHzqAz1oGkV_N4JbMPCkFpuOwfLrX7P8bf8ntXf73lrVR8j1tQtO-QJktbsTif_VLk0XpByYU7ZkhnADQx2Vo7gOFIa24Ffsaykox56asTgf7vf2K4GdlJXHUxt7kK0q4qthvBz8PlbdLT-rrymgZV55a5ZcOflX9qzuUVdx1z169aW18W5C7QR1vf_wYJWImE9RODlCRVzg==',
                ],
            ]
        );
        // Vérifie si le statut HTTP est 200
        if ($response->getStatusCode() !== 200) {
            return [
                'error' => true,
                'message' => "Erreur API : " . $response->getStatusCode(),
            ];
        }

        return $response->toArray();

        } catch (\Exception $e) {
            // Gestion des erreurs (timeout, connexion, etc.)
            return [
                'error' => true,
                'message' => "Exception capturée : " . $e->getMessage(),
            ];
        }
    }

    public function getApiMeteoFranceCarte(): array
    {
        $response = $this->client->request(
            'GET',
            'https://public-api.meteofrance.fr/public/DPVigilance/v1/cartevigilance/encours',
            //'https://public-api.meteofrance.fr/public/DPVigilance/v1/textesvigilance/encours',
            [
                'headers' => [
                    'accept' => '*/*',
                    'apikey' => 'eyJ4NXQiOiJZV0kxTTJZNE1qWTNOemsyTkRZeU5XTTRPV014TXpjek1UVmhNbU14T1RSa09ETXlOVEE0Tnc9PSIsImtpZCI6ImdhdGV3YXlfY2VydGlmaWNhdGVfYWxpYXMiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOiJMdWRvdmljLnppYmVsbGlAY2FyYm9uLnN1cGVyIiwiYXBwbGljYXRpb24iOnsib3duZXIiOiJMdWRvdmljLnppYmVsbGkiLCJ0aWVyUXVvdGFUeXBlIjpudWxsLCJ0aWVyIjoiVW5saW1pdGVkIiwibmFtZSI6IkRlZmF1bHRBcHBsaWNhdGlvbiIsImlkIjo2MTk4LCJ1dWlkIjoiYThiY2UzNWYtMWFiNy00ZDYzLTlkZTQtNTM2OGI5ODczMzhkIn0sImlzcyI6Imh0dHBzOlwvXC9wb3J0YWlsLWFwaS5tZXRlb2ZyYW5jZS5mcjo0NDNcL29hdXRoMlwvdG9rZW4iLCJ0aWVySW5mbyI6eyI1MFBlck1pbiI6eyJ0aWVyUXVvdGFUeXBlIjoicmVxdWVzdENvdW50IiwiZ3JhcGhRTE1heENvbXBsZXhpdHkiOjAsImdyYXBoUUxNYXhEZXB0aCI6MCwic3RvcE9uUXVvdGFSZWFjaCI6dHJ1ZSwic3Bpa2VBcnJlc3RMaW1pdCI6MCwic3Bpa2VBcnJlc3RVbml0Ijoic2VjIn0sIjYwUmVxUGFyTWluIjp7InRpZXJRdW90YVR5cGUiOiJyZXF1ZXN0Q291bnQiLCJncmFwaFFMTWF4Q29tcGxleGl0eSI6MCwiZ3JhcGhRTE1heERlcHRoIjowLCJzdG9wT25RdW90YVJlYWNoIjp0cnVlLCJzcGlrZUFycmVzdExpbWl0IjowLCJzcGlrZUFycmVzdFVuaXQiOiJzZWMifX0sImtleXR5cGUiOiJQUk9EVUNUSU9OIiwic3Vic2NyaWJlZEFQSXMiOlt7InN1YnNjcmliZXJUZW5hbnREb21haW4iOiJjYXJib24uc3VwZXIiLCJuYW1lIjoiRG9ubmVlc1B1YmxpcXVlc1ZpZ2lsYW5jZSIsImNvbnRleHQiOiJcL3B1YmxpY1wvRFBWaWdpbGFuY2VcL3YxIiwicHVibGlzaGVyIjoiYWRtaW4iLCJ2ZXJzaW9uIjoidjEiLCJzdWJzY3JpcHRpb25UaWVyIjoiNjBSZXFQYXJNaW4ifSx7InN1YnNjcmliZXJUZW5hbnREb21haW4iOiJjYXJib24uc3VwZXIiLCJuYW1lIjoiRG9ubmVlc1B1YmxpcXVlc09ic2VydmF0aW9uIiwiY29udGV4dCI6IlwvcHVibGljXC9EUE9ic1wvdjEiLCJwdWJsaXNoZXIiOiJiYXN0aWVuZyIsInZlcnNpb24iOiJ2MSIsInN1YnNjcmlwdGlvblRpZXIiOiI1MFBlck1pbiJ9XSwidG9rZW5fdHlwZSI6ImFwaUtleSIsImlhdCI6MTcxNjE0NDA5NywianRpIjoiOGU1NmI1MzMtOGU1NC00MzAzLThjZDctMjFlNGRhNmE5Yzg4In0=.HFDOq2Mm9u3azwQ_RwBzaOaOP7fzLoTokT2BkBj5ZJWTWjK8LkkZH2r-gLUaLQZ9ds6kVYhMrE2iN5qR2csvnrktc9OnSwpdYE4d0Ugsapem5re5J1mbtzFs2G_AAEx4Nvo6gPyxPpmHzqAz1oGkV_N4JbMPCkFpuOwfLrX7P8bf8ntXf73lrVR8j1tQtO-QJktbsTif_VLk0XpByYU7ZkhnADQx2Vo7gOFIa24Ffsaykox56asTgf7vf2K4GdlJXHUxt7kK0q4qthvBz8PlbdLT-rrymgZV55a5ZcOflX9qzuUVdx1z169aW18W5C7QR1vf_wYJWImE9RODlCRVzg==',
                ],
            ]
        );
        return $response->toArray();
    }

    public function getApiMeteoConcept(): array
    {
        $response = $this->client->request(
            'GET',
            'http://api.meteo-concept.com/api/forecast/daily?token=90f6467f2c61761ceb9001ec91617025a7d1d84e82185743d826ac6de51bf073&insee=57336',
            [
                'headers' => [
                    'accept' => '*/*',
                ],
            ]
            );

            // Convertir la réponse en tableau
            $data = $response->toArray();

            // Sauvegarder dans un fichier JSON
            //$filePath = __DIR__ . '/../../var/meteo.json'; // Stocké dans var/
            file_put_contents("meteo.json", json_encode($data, JSON_PRETTY_PRINT));

            return $data;
            //return $response->toArray();

    }
}
