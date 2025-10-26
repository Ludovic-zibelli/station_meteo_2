<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\EtatStationMeteo;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class EtatStationMeteoPersister implements ContextAwareDataPersisterInterface
{
    /** @var EntityManagerInterface */
    private $em;
    /** @var RequestStack */
    private $requestStack;
    /** @var LoggerInterface|null */
    private $logger;

    public function __construct(EntityManagerInterface $em, RequestStack $requestStack, LoggerInterface $logger = null)
    {
        $this->em = $em;
        $this->requestStack = $requestStack;
        $this->logger = $logger;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof EtatStationMeteo;
    }

    public function persist($data, array $context = [])
    {
        // 1) Voie "normale" : persist + recompute + flush
        $this->em->persist($data);

        $uow  = $this->em->getUnitOfWork();
        $meta = $this->em->getClassMetadata(EtatStationMeteo::class);
        // S’assure que Doctrine voit les changements sur l’entité MANAGED
        $uow->recomputeSingleEntityChangeSet($meta, $data);

        $this->em->flush();

        // 2) Fallback : si rien n’a été vu/écrit, poussons un UPDATE ciblé
        $request = $this->requestStack->getCurrentRequest();
        if ($request && in_array($request->getMethod(), ['PUT','PATCH'], true)) {
            $changeSet = $uow->getEntityChangeSet($data);
            if (empty($changeSet)) {
                $payload = json_decode($request->getContent() ?: '[]', true) ?: [];

                // Whitelist stricte des champs JSON -> colonnes SQL
                $map = [
                    'ghost'           => 'ghost',
                    'moduleBmp280'    => 'module_bmp280',
                    'moduleDht22'     => 'module_dht22',
                    'moduleAnemo'     => 'module_anemo',
                    'moduleGirou'     => 'module_girou',
                    'modulePluvio'    => 'module_pluvio',
                    'moduleTension'   => 'module_tension',
                    'moduleBitvie'    => 'module_bitvie',
                    'capteurDht22'    => 'capteur_dht22',
                    'capteurBmp280'   => 'capteur_bmp280',
                    'capteurPluvio'   => 'capteur_pluvio',
                    'capteurGirou'    => 'capteur_girou',
                    'capteurAnemo'    => 'capteur_anemo',
                    'logBmp280'       => 'log_bmp280',
                    'logDht22'        => 'log_dht22',
                    'logGirou'        => 'log_girou',
                    'logTension'      => 'log_tension',
                    'logAnemo'        => 'log_anemo',
                    'logPluvio'       => 'log_pluvio',
                    'logDateBmp280'   => 'log_date_bmp280',
                    'logDateDht22'    => 'log_date_dht22',
                    'logDateGirou'    => 'log_date_girou',
                    'logDateTension'  => 'log_date_tension',
                    'logDateAnemo'    => 'log_date_anemo',
                    'logDatePluvio'   => 'log_date_pluvio',         
                    'tensionSolaire'  => 'tension_solaire',
                    'tensionBatterie' => 'tension_batterie',

                    // NB: stationMeteo IRI non traité ici (relation gérée par Doctrine)
                ];

                $fields = [];
                $params = [];
                foreach ($map as $jsonField => $column) {
                    if (array_key_exists($jsonField, $payload)) {
                        $fields[] = $column.' = ?';
                        $params[] = $payload[$jsonField];
                    }
                }

                if ($fields) {
                    $params[] = $data->getId();
                    $sql = 'UPDATE etat_station_meteo SET '.implode(', ', $fields).' WHERE id = ?';
                    $this->em->getConnection()->executeStatement($sql, $params);
                    if ($this->logger) {
                        $this->logger->info('[EtatStationMeteoPersister] Fallback SQL UPDATE exécuté', [
                            'id' => $data->getId(),
                            'fields' => $fields
                        ]);
                    }
                }
            }
        }

        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}