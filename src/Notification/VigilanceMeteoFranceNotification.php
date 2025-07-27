<?php

namespace App\Notification;

use App\Notification\CallApiService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VigilanceMeteofranceRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Notification\AlerteMeteoNotification;



class VigilanceMeteoFranceNotification
{
    private EntityManagerInterface $em;

    /**
     * @var VigilanceMeteofranceRepository
     */
    private $vmf;

      /**
     * @var CallApiService
     */
    private $api;
    private $session;
    private $alerteMeteo;

    public function __construct(EntityManagerInterface $em, VigilanceMeteofranceRepository $vmf, CallApiService $api, SessionInterface $session, AlerteMeteoNotification $alerteMeteo)
    {
        $this->em = $em;
        $this->vmf = $vmf;
        $this->api = $api;
        $this->session = $session;
        $this->alerteMeteo = $alerteMeteo;
    }

    public function getVigilanceMeteoFrance()
    {
        $departement = 54;

        
        //Recuperation des données de l'api meteo france
        $data = $this->api->getApiMeteoFrance();
            // Vérifiez si 'product' existe dans les données
        if (!isset($data['product'])) {
            error_log('Données de l\'API Météo France manquantes ou invalides.');
            return; // Arrêtez l'exécution si les données sont manquantes
        }

        $update = $this->vmf->findByVigilance();
        //Si le tableau bloc_items n'est pas vide alors on met a jour la base de donnée
        $update[0]->setDomaineId($data['product']['text_bloc_items'][$departement]['domain_id']);
        $update[0]->setDomaineName($data['product']['text_bloc_items'][$departement]['domain_name']);
        $update[0]->setBlocTitle($data['product']['text_bloc_items'][$departement]['bloc_title']);
        $update[0]->setBlocId($data['product']['text_bloc_items'][$departement]['bloc_id']);
        $update[0]->setUpdateDate(new \DateTime);

        //Si le tableau bloc_items n'est pas vide alors on met a jour la base de donnée
        if( !empty($data['product']['text_bloc_items'][$departement]['bloc_items']) )
        {
            $update[0]->setTermNames($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['term_names']);
            $update[0]->setStartTime(new \DateTime($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['start_time']));
            $update[0]->setEndTime(new \DateTime($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['end_time']));
            $update[0]->setRiskName($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['risk_name']);
            $update[0]->setRiskLevel($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['risk_level']);
            $update[0]->setRiskColor($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['risk_color']);
            $update[0]->setRiskCode($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['risk_code']);
            $update[0]->setText1($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][0]['text'][0]);

            if( !empty($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][0]['text'][1]))
            {
                $update[0]->setText2($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][0]['text'][1]);
            }

            if( !empty($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][0]['text'][2]))
            {
                $update[0]->setText3($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][0]['text'][2]);
            }

            if( !empty($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][0]['text'][3]))
            {
                $update[0]->setText4($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][0]['text'][3]);
            }

            if( !empty($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][0]['text'][4]))
            {
                $update[0]->setText5($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][0]['text'][4]);
            }

            if( !empty($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][1]['text'][0]))
            {
                $update[0]->setText21($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][1]['text'][0]);
            }

            if( !empty($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][1]['text'][1]))
            {
                $update[0]->setText22($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][1]['text'][1]);
            }

            if( !empty($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][1]['text'][2]))
            {
                $update[0]->setText23($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][1]['text'][2]);
            }

            if( !empty($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][1]['text'][3]))
            {
                $update[0]->setText24($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][1]['text'][3]);
            }

            if( !empty($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][1]['text'][4]))
            {
                $update[0]->setText25($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['term_items'][0]['subdivision_text'][1]['text'][4]);
            }

            $update[0]->setHazardCode($data['product']['text_bloc_items'][$departement]['bloc_items'][0]['text_items'][0]['hazard_code']);

        }
        else
        {
            $update[0]->setTermNames(null);
            $update[0]->setStartTime(null);
            $update[0]->setEndTime(null);
            $update[0]->setRiskName(null);
            $update[0]->setRiskLevel(null);
            $update[0]->setRiskColor("#15ed13");
            $update[0]->setRiskCode(1);
            $update[0]->setBoldText1(null);
            $update[0]->setBoldText2(null);
            $update[0]->setText1(null);
            $update[0]->setText2(null);
            $update[0]->setText3(null);
            $update[0]->setText4(null);
            $update[0]->setText5(null);
            $update[0]->setText6(null);
            $update[0]->setText21(null);
            $update[0]->setText22(null);
            $update[0]->setText23(null);
            $update[0]->setText24(null);
            $update[0]->setText25(null);
            $update[0]->setHazardCode(null);
        }
        $this->em->flush();
        $this->alerteMeteo->VigilanceMeteoFrance();
    }
}