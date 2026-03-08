<?php

namespace App\Command;

use App\Repository\StationMeteosRepository;
use App\Repository\StationDirectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Output\OutputInterface;

class StationsWatchdogCommand extends Command
{
    // Pour Symfony 5.x sans attributs, on définit le nom ici :
    protected static $defaultName = 'app:stations:watchdog';

    /** @var StationMeteosRepository */
    private $stationMeteosRepo;

    /** @var StationDirectRepository */
    private $stationDirectRepo;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(
        StationMeteosRepository $stationMeteosRepo,
        StationDirectRepository $stationDirectRepo,
        EntityManagerInterface $em
    ) {
        parent::__construct();
        $this->stationMeteosRepo = $stationMeteosRepo;
        $this->stationDirectRepo = $stationDirectRepo;
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Met à jour le statut ghost des stations en fonction de la fraîcheur de la dernière mesure.')
            ->addOption(
                'timeout',
                null,
                InputOption::VALUE_REQUIRED,
                'Seuil en secondes au-delà duquel une station est considérée hors-ligne (ghost=1)',
                180
            )
            ->addOption(
                'dry-run',
                null,
                InputOption::VALUE_NONE,
                'Affiche ce qui serait fait sans rien écrire en BDD'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io      = new SymfonyStyle($input, $output);
        $timeout = (int) $input->getOption('timeout');
        $dryRun  = (bool) $input->getOption('dry-run');

        $now = new \DateTimeImmutable();
        $stations = $this->stationMeteosRepo->findAll();

        if (!$stations) {
            $io->warning('Aucune station trouvée.');
            return 0;
        }

        $updated = 0;

        foreach ($stations as $station) {
            $stationId = $station->getId();

            // Dernière mesure pour cette station
            $last = $this->stationDirectRepo->findOneBy(
                ['station_id' => $stationId],
                ['dateheure' => 'DESC']
            );

            if (!$last) {
                // Aucune mesure pour cette station : on loggue et on passe.
                $io->note(sprintf('Station #%d : aucune mesure, considérée KO (pas de ghost à mettre à jour).', $stationId));
                continue;
            }

            $lastDate = $last->getDateheure(); // champ bien présent dans StationDirect
            $ageSec   = $now->getTimestamp() - $lastDate->getTimestamp();

            $shouldGhost = ($ageSec > $timeout) ? 1 : 0;

            if ((int) $last->getGhost() !== $shouldGhost) {
                $io->writeln(sprintf(
                    'Station #%d : dernière mesure %ds, ghost %d -> %d',
                    $stationId,
                    $ageSec,
                    (int) $last->getGhost(),
                    $shouldGhost
                ));
                $last->setGhost($shouldGhost);
                $updated++;
            }
        }

        if ($updated > 0 && !$dryRun) {
            $this->em->flush();
        }

        $io->success(sprintf(
            'Watchdog terminé. %d enregistrements mis à jour (timeout=%ds, dry-run=%s).',
            $updated,
            $timeout,
            $dryRun ? 'oui' : 'non'
        ));

        return 0;
    }
}