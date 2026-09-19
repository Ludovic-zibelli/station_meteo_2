<?php

namespace App\Notification;

use App\Notification\AlerteMeteoNotification;
use App\Notification\CallApiService;
use App\Repository\VigilanceMeteofranceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VigilanceMeteoFranceNotification
{
    private const DEPARTEMENT_MOSELLE = '57';

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
        $data = $this->api->getApiMeteoFrance();
        if (!isset($data['product']['text_bloc_items']) || !is_array($data['product']['text_bloc_items'])) {
            error_log('Donnees de l API Meteo France manquantes ou invalides.');
            return;
        }

        $update = $this->vmf->findByVigilance();
        if (empty($update)) {
            error_log('Aucune ligne VigilanceMeteofrance a mettre a jour.');
            return;
        }

        $textBloc = $this->findTextBlocByDomainId($data['product']['text_bloc_items'], self::DEPARTEMENT_MOSELLE);
        if ($textBloc === null) {
            error_log('Bulletin Meteo France introuvable pour le departement ' . self::DEPARTEMENT_MOSELLE . '.');
            return;
        }

        $vigilance = $update[0];
        $vigilance->setDomaineId((int) $textBloc['domain_id']);
        $vigilance->setDomaineName($textBloc['domain_name']);
        $vigilance->setBlocTitle($textBloc['bloc_title']);
        $vigilance->setBlocId($textBloc['bloc_id']);
        $vigilance->setUpdateDate(new \DateTime());
        $this->resetVigilance($vigilance);

        if (!empty($textBloc['bloc_items'])) {
            $textItem = $this->getFirstTextItem($textBloc);
            $termItem = $textItem['term_items'][0] ?? null;

            if ($termItem !== null) {
                $vigilance->setTermNames($termItem['term_names'] ?? null);
                $vigilance->setStartTime(!empty($termItem['start_time']) ? new \DateTime($termItem['start_time']) : null);
                $vigilance->setEndTime(!empty($termItem['end_time']) ? new \DateTime($termItem['end_time']) : null);
                $vigilance->setRiskName($termItem['risk_name'] ?? null);
                $vigilance->setRiskLevel(isset($termItem['risk_level']) ? (int) $termItem['risk_level'] : null);
                $vigilance->setRiskColor($termItem['risk_color'] ?? null);
                $vigilance->setRiskCode(isset($termItem['risk_code']) ? (int) $termItem['risk_code'] : null);
                $this->fillTexts($vigilance, $termItem['subdivision_text'] ?? []);
            }

            $vigilance->setHazardCode(isset($textItem['hazard_code']) ? (int) $textItem['hazard_code'] : null);
        }

        $this->em->flush();
        $this->alerteMeteo->VigilanceMeteoFrance();
    }

    private function findTextBlocByDomainId(array $textBlocItems, string $domainId): ?array
    {
        foreach ($textBlocItems as $textBloc) {
            if (($textBloc['domain_id'] ?? null) === $domainId) {
                return $textBloc;
            }
        }

        return null;
    }

    private function getFirstTextItem(array $textBloc): array
    {
        return $textBloc['bloc_items'][0]['text_items'][0] ?? [];
    }

    private function fillTexts($vigilance, array $subdivisionTexts): void
    {
        $primaryTexts = $subdivisionTexts[0]['text'] ?? [];
        $secondaryTexts = $subdivisionTexts[1]['text'] ?? [];

        $vigilance->setText1($primaryTexts[0] ?? null);
        $vigilance->setText2($primaryTexts[1] ?? null);
        $vigilance->setText3($primaryTexts[2] ?? null);
        $vigilance->setText4($primaryTexts[3] ?? null);
        $vigilance->setText5($primaryTexts[4] ?? null);
        $vigilance->setText21($secondaryTexts[0] ?? null);
        $vigilance->setText22($secondaryTexts[1] ?? null);
        $vigilance->setText23($secondaryTexts[2] ?? null);
        $vigilance->setText24($secondaryTexts[3] ?? null);
        $vigilance->setText25($secondaryTexts[4] ?? null);
    }

    private function resetVigilance($vigilance): void
    {
        $vigilance->setTermNames(null);
        $vigilance->setStartTime(null);
        $vigilance->setEndTime(null);
        $vigilance->setRiskName(null);
        $vigilance->setRiskLevel(null);
        $vigilance->setRiskColor('#15ed13');
        $vigilance->setRiskCode(1);
        $vigilance->setBoldText1(null);
        $vigilance->setBoldText2(null);
        $vigilance->setText1(null);
        $vigilance->setText2(null);
        $vigilance->setText3(null);
        $vigilance->setText4(null);
        $vigilance->setText5(null);
        $vigilance->setText6(null);
        $vigilance->setText21(null);
        $vigilance->setText22(null);
        $vigilance->setText23(null);
        $vigilance->setText24(null);
        $vigilance->setText25(null);
        $vigilance->setHazardCode(null);
    }
}
