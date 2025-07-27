<?php

namespace App\Controller;

use App\Notification\GaugesNotification;
use App\Repository\StationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MiniMaxiHRepository;
use App\Repository\StationMeteosRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class GaugesController extends AbstractController
{
    private GaugesNotification $gaugesNotification;
    private RequestStack $requestStack;

    public function __construct(GaugesNotification $gaugesNotification, RequestStack $requestStack) 
    {
        $this->gaugesNotification = $gaugesNotification;
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/api/update-realtime-gauges", name="update_realtime_gauges", methods={"POST"})
     */
    public function updateRealtimeGauges(): JsonResponse
    {
        try {
            $this->gaugesNotification->realTimeGauges();
            return new JsonResponse(['status' => 'success']);
        } catch (\Exception $e) {
            // Ajout d'un log pour déboguer
            error_log('Error in updateRealtimeGauges: ' . $e->getMessage());
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * @Route("/api/minimax/{stationId}", name="api_minimax_station", methods={"GET"})
     */
    public function minimaxDataForStation(int $stationId = 2, StationMeteosRepository $stationRepo): JsonResponse
    {
        // Si stationId n'est pas passé, on utilise 2 par défaut
        if (!$stationId) {
            $stationId = 2;
        }
        $station = $stationRepo->find($stationId);

        if (!$station) {
            return new JsonResponse(['error' => 'Station non trouvée'], 404);
        }

        $data = [];
        $miniMaxiHs = $station->getMiniMaxiHs();
        $session = $this->requestStack->getCurrentRequest()->getSession();

        // Récupère le dernier minimaxiH
        $current = null;
        if (is_iterable($miniMaxiHs)) {
            foreach ($miniMaxiHs as $item) {
                $current = $item; // le dernier dans la boucle
            }
        }

        // Si pas de données, retourne des valeurs de test
        if (!$current || !is_object($current)) {
            $data[] = [
                'miniTemp' => 10,
                'maxiTemp' => 20,
                'miniPtro' => 5,
                'maxiPtro' => 15,
                'miniHumi' => 40,
                'maxiHumi' => 90,
                'miniPres' => 1000,
                'maxiPres' => 1020,
                'miniAnemo' => 0,
                'maxiAnemo' => 30,
                'miniLumi' => 0,
                'maxiLumi' => 100,
                'miniGirou' => 0,
                'maxiGirou' => 360,
                'miniPluvio' => 0,
                'maxiPluvio' => 10,
                'trendMiniTemp' => 'stable',
                'trendMaxiTemp' => 'stable',
                'trendMiniPtro' => 'stable',
                'trendMaxiPtro' => 'stable',
                'trendMiniHumi' => 'stable',
                'trendMaxiHumi' => 'stable',
                'trendMiniPres' => 'stable',
                'trendMaxiPres' => 'stable',
                'trendMiniAnemo' => 'stable',
                'trendMaxiAnemo' => 'stable',
                'trendMiniLumi' => 'stable',
                'trendMaxiLumi' => 'stable',
                'trendMiniGirou' => 'stable',
                'trendMaxiGirou' => 'stable',
                'trendMiniPluvio' => 'stable',
                'trendMaxiPluvio' => 'stable',
            ];
            return new JsonResponse($data);
        }

        // Récupère la dernière valeur stockée en session
        $lastValues = $session->get('minimax_last_'.$stationId);

        $trend = function($now, $before) {
            if ($now > $before) return 'up';
            if ($now < $before) return 'down';
            return 'stable';
        };

        if ($lastValues) {
            $data[] = [
                'miniTemp' => $current->getMiniTemp(),
                'maxiTemp' => $current->getMaxiTemp(),
                'miniPtro' => $current->getMiniPtro(),
                'maxiPtro' => $current->getMaxiPtro(),
                'miniHumi' => $current->getMiniHumi(),
                'maxiHumi' => $current->getMaxiHumi(),
                'miniPres' => $current->getMiniPres(),
                'maxiPres' => $current->getMaxiPres(),
                'miniAnemo' => $current->getMiniAnemo(),
                'maxiAnemo' => $current->getMaxiAnemo(),
                'miniLumi' => $current->getMiniLumi(),
                'maxiLumi' => $current->getMaxiLumi(),
                'miniGirou' => $current->getMiniGirou(),
                'maxiGirou' => $current->getMaxiGirou(),
                'miniPluvio' => $current->getMiniPluvio(),
                'maxiPluvio' => $current->getMaxiPluvio(),
                'trendMiniTemp' => $trend($current->getMiniTemp(), $lastValues['miniTemp']),
                'trendMaxiTemp' => $trend($current->getMaxiTemp(), $lastValues['maxiTemp']),
                'trendMiniPtro' => $trend($current->getMiniPtro(), $lastValues['miniPtro']),
                'trendMaxiPtro' => $trend($current->getMaxiPtro(), $lastValues['maxiPtro']),
                'trendMiniHumi' => $trend($current->getMiniHumi(), $lastValues['miniHumi']),
                'trendMaxiHumi' => $trend($current->getMaxiHumi(), $lastValues['maxiHumi']),
                'trendMiniPres' => $trend($current->getMiniPres(), $lastValues['miniPres']),
                'trendMaxiPres' => $trend($current->getMaxiPres(), $lastValues['maxiPres']),
                'trendMiniAnemo' => $trend($current->getMiniAnemo(), $lastValues['miniAnemo']),
                'trendMaxiAnemo' => $trend($current->getMaxiAnemo(), $lastValues['maxiAnemo']),
                'trendMiniLumi' => $trend($current->getMiniLumi(), $lastValues['miniLumi']),
                'trendMaxiLumi' => $trend($current->getMaxiLumi(), $lastValues['maxiLumi']),
                'trendMiniGirou' => $trend($current->getMiniGirou(), $lastValues['miniGirou']),
                'trendMaxiGirou' => $trend($current->getMaxiGirou(), $lastValues['maxiGirou']),
                'trendMiniPluvio' => $trend($current->getMiniPluvio(), $lastValues['miniPluvio']),
                'trendMaxiPluvio' => $trend($current->getMaxiPluvio(), $lastValues['maxiPluvio']),
            ];
        } else {
            $data[] = [
                'miniTemp' => $current->getMiniTemp(),
                'maxiTemp' => $current->getMaxiTemp(),
                'miniPtro' => $current->getMiniPtro(),
                'maxiPtro' => $current->getMaxiPtro(),
                'miniHumi' => $current->getMiniHumi(),
                'maxiHumi' => $current->getMaxiHumi(),
                'miniPres' => $current->getMiniPres(),
                'maxiPres' => $current->getMaxiPres(),
                'miniAnemo' => $current->getMiniAnemo(),
                'maxiAnemo' => $current->getMaxiAnemo(),
                'miniLumi' => $current->getMiniLumi(),
                'maxiLumi' => $current->getMaxiLumi(),
                'miniGirou' => $current->getMiniGirou(),
                'maxiGirou' => $current->getMaxiGirou(),
                'miniPluvio' => $current->getMiniPluvio(),
                'maxiPluvio' => $current->getMaxiPluvio(),
                'trendMiniTemp' => 'stable',
                'trendMaxiTemp' => 'stable',
                'trendMiniPtro' => 'stable',
                'trendMaxiPtro' => 'stable',
                'trendMiniHumi' => 'stable',
                'trendMaxiHumi' => 'stable',
                'trendMiniPres' => 'stable',
                'trendMaxiPres' => 'stable',
                'trendMiniAnemo' => 'stable',
                'trendMaxiAnemo' => 'stable',
                'trendMiniLumi' => 'stable',
                'trendMaxiLumi' => 'stable',
                'trendMiniGirou' => 'stable',
                'trendMaxiGirou' => 'stable',
                'trendMiniPluvio' => 'stable',
                'trendMaxiPluvio' => 'stable',
            ];
        }

        // Stocke la valeur actuelle pour la prochaine interrogation
        $session->set('minimax_last_'.$stationId, [
            'miniTemp' => $current->getMiniTemp(),
            'maxiTemp' => $current->getMaxiTemp(),
            'miniPtro' => $current->getMiniPtro(),
            'maxiPtro' => $current->getMaxiPtro(),
            'miniHumi' => $current->getMiniHumi(),
            'maxiHumi' => $current->getMaxiHumi(),
            'miniPres' => $current->getMiniPres(),
            'maxiPres' => $current->getMaxiPres(),
            'miniAnemo' => $current->getMiniAnemo(),
            'maxiAnemo' => $current->getMaxiAnemo(),
            'miniLumi' => $current->getMiniLumi(),
            'maxiLumi' => $current->getMaxiLumi(),
            'miniGirou' => $current->getMiniGirou(),
            'maxiGirou' => $current->getMaxiGirou(),
            'miniPluvio' => $current->getMiniPluvio(),
            'maxiPluvio' => $current->getMaxiPluvio(),
        ]);

        // Pour le debug, tu peux aussi retourner le contenu de miniMaxiHs
        /*
        $miniMaxiHsArray = [];
        if (is_iterable($miniMaxiHs)) {
            foreach ($miniMaxiHs as $item) {
                $miniMaxiHsArray[] = [
                    'id' => method_exists($item, 'getId') ? $item->getId() : null,
                    'miniTemp' => method_exists($item, 'getMiniTemp') ? $item->getMiniTemp() : null,
                    'maxiTemp' => method_exists($item, 'getMaxiTemp') ? $item->getMaxiTemp() : null,
                    // Ajoute ici les autres champs que tu veux afficher
                ];
            }
        }
        return new JsonResponse([
            'miniMaxiHs' => $miniMaxiHsArray,
            'data' => $data
        ]);
        */

        return new JsonResponse($data);
    }
}
