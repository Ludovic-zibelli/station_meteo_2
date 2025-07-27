<?php

namespace App\Notification;

use App\Entity\Orages;
use App\Repository\OragesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class OragesNotification
{
    /**
     * @var CallApiService
     */
    private $callApiService;

    /**
     * @var EntityManagerInterface
     */
    private $em;


    /**
     * @var OragesRepository
     */
    private $oragesRepository;

    public function __construct(EntityManagerInterface $em, CallApiService $callApiService,  OragesRepository $oragesRepository)
    {
        $this->callApiService = $callApiService;
        $this->em = $em;
        $this->oragesRepository = $oragesRepository;
    }

    public function getOragesData()
    {
        // Pour chaque radius, on récupère la ligne existante et on met à jour avec les données de l'API correspondante
        $radiusList = [1, 10, 50];
        foreach ($radiusList as $radius) {
            // Récupère la ligne existante pour ce radius
            $orages = $this->oragesRepository->findOneBy(['radius' => $radius]);
            if (!$orages) {
                continue; // Passe si la ligne n'existe pas
            }

            // Appelle l'API correspondante
            switch ($radius) {
                case 1:
                    $data = $this->callApiService->getResultOrages1();
                    break;
                case 10:
                    $data = $this->callApiService->getResultOrages();
                    break;
                case 50:
                    $data = $this->callApiService->getResultOrages50();
                    break;
                default:
                    $data = [];
            }

            // Mets à jour les champs de l'entité Orages selon la nouvelle structure
            $orages->setStatus($data['status'] ?? '');
            $orages->setStartTime($data['start_time'] ?? 0);
            $orages->setEndTime($data['end_time'] ?? 0);
            $orages->setLat($data['lat'] ?? 0.0);
            $orages->setLon($data['lon'] ?? 0.0);
            $orages->setDuration($data['duration'] ?? 0);
            $orages->setIntervals($data['intervals'] ?? []);
            $orages->setTotalStrikes($data['total_strikes'] ?? 0);
            $orages->setBearings($data['bearings'] ?? []);
            $orages->setClosests($data['closests'] ?? []);
            $orages->setByIntervals($data['by_intervals'] ?? []);
            $orages->setDatetime(new \DateTime());

            $this->em->persist($orages);
        }
        $this->em->flush();
    }
}