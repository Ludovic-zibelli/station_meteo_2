<?php

namespace App\Command;


use App\Notification\OragesNotification;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class addOrages extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:addOrages';
    /**
     * @var orages
     */
    private $orages;

    public function __construct(string $name = null, OragesNotification $orages)
    {
        parent::__construct($name);
        $this->orages = $orages;
    }

    protected function configure()
    {
        $this->setName('app:addOrages');
        $this->setDescription('Commande pour tache cron pour la mise a jour des orages autour de la station');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->orages->getOragesData();
        return 0;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }

}