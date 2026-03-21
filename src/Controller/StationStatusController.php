<?php
namespace App\Controller;

use App\Repository\StationDirectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StationStatusController extends AbstractController
{
    /**
     * @Route("/api/station-status/{stationId}", name="api_station_status", methods={"GET"})
     */
    public function status(int $stationId, StationDirectRepository $repo): JsonResponse
    {
        // Dernière mesure pour cette station (la plus récente)
        $last = $repo->findOneBy(['station_id' => $stationId], ['dateheure' => 'DESC']);

        if (!$last) {
            // Pas de donnée → considérer “hors ligne”
            return $this->json([
                'ghost'     => 1,
                'dateheure' => null,
            ]);
        }

        return $this->json([
            'ghost'     => (int) $last->getGhost(),
            'dateheure' => $last->getDateheure()->format('d/m/Y H:i'),
        ]);
    }
}