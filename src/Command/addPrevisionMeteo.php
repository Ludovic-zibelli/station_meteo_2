<?php

namespace App\Command;

use App\Notification\CallApiService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class addPrevisionMeteo extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:addPrevisionMeteo';
    /**
     * @var prevision
     */
    private $prevision;

    public function __construct(string $name = null, CallApiService $prevision)
    {
        parent::__construct($name);
        $this->prevision = $prevision;
    }

    protected function configure()
    {
        //$this->setName('app:addPerevisionMeteo');
        $this->setDescription('Commande pour tache cron pour la mise a jour des prévisions météo');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->prevision->getApiMeteoConcept();
        return 0;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }

}