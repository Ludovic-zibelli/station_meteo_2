<?php

namespace App\Command;


use App\Notification\VigilanceMeteoFranceNotification;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class addVigilanceMeteoFrance extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:addVigilanceMeteoFrance';
    /**
     * @var BddNotification
     */
    private $vigilance;

    public function __construct(string $name = null, VigilanceMeteoFranceNotification $vigilance)
    {
        parent::__construct($name);
        $this->vigilance = $vigilance;
    }

    protected function configure()
    {
        $this->setName('app:addVigilanceMeteoFrance');
        $this->setDescription('Commande pour tache cron pour la mise a jour de la vigilance meteo france');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->vigilance->getVigilanceMeteoFrance();
        return 0;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }

}